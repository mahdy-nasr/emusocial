<?php
namespace App\Models;

class Friend extends \App\Base
{
    private $user_id;
    public function __construct($id)
    {
        parent::__construct();
        $this->user_id = $id;
    }

    public function setUserId($id) 
    {
    	$this->user_id = $id;
    }

    public function makeFriendRequist($id)
    {
    	$res = $this->db->readOne("SELECT * from friend where from_id = {$this->user_id} and to_id = ?", [$id]);
    	if ($res) {
    		return false;
    	}

    	$res = $this->db->write("INSERT into friend (`from_id`,`to_id`) VALUES ({$this->user_id},?)", [$id]);
    	if ($res)
    		return $this->db->last_id();
    	return false;
    }

    public function acceptFriendRequist($requist_id)
    {
    	return $this->db->write("UPDATE friend set accept = 1 where id = ?", [$requist_id]);
    }

    public function getFriendRequists($start=0,$limit=10)
    {
    	//LIMIT 10 OFFSET 15
    	//LIMIT 15,10
    	return $this->db->read("SELECT id, from_id as user_id,created_at from friend where to_id = {$this->user_id} and accept = 0 Limit $start,$limit");
    }

    public function getFriends($start=0,$limit=10)
    {
    	return $this->db->read("SELECT id, IF(from_id = {$this->user_id}, to_id, from_id) as user_id, created_at from friend where (from_id = {$this->user_id} or to_id = {$this->user_id} ) and accept = 1 Limit $start,$limit");
    }

    public function getFriendsId($start=0,$limit=10,$as_string = true)
    {
        $friends = $this->getFriends($start,$limit);
        $ids = [];
        foreach ($friends as $key => $value) {
            $ids[]=$value['user_id'];
        }
        if (!$as_string)
            return $ids;
        else
            return trim(implode(', ',$ids)," ,");

    }


}