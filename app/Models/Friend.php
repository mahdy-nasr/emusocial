<?php
namespace App\Models;

class Friend extends \App\Base
{
    private $user_id;
    const IS_FRIEND = 3;
    const IS_FRIEND_R_FROM_ME = 2;
    const IS_FRIEND_R_TO_ME = 1;
    const IS_NOT_FRIEND = 0;


    public function __construct($id)
    {
        parent::__construct();
        $this->user_id = $id;
    }

    public function setUserId($id) 
    {
    	$this->user_id = $id;
    }

    public function getUserStatus($id)
    {

        $res1 = $this->db->readOne("SELECT * from friend where from_id = {$this->user_id} and to_id = :id ", [':id'=>$id]);
        $res2 = $this->db->readOne("SELECT * from friend where to_id = {$this->user_id} and from_id = :id ", [':id'=>$id]);
        if (!$res1 && !$res2)
            return self::IS_NOT_FRIEND;
        else if ($res1 && $res1['accept']|| $res2 && $res2['accept'])
            return self::IS_FRIEND;
        else if ($res1)
            return self::IS_FRIEND_R_FROM_ME;
        else
            return self::IS_FRIEND_R_TO_ME;

    }

    public function makeFriendRequist($id)
    {

    	$res = $this->db->readOne("SELECT * from friend where from_id = {$this->user_id} and to_id = ? ", [$id]);
    	if ($res) {
    		return false;
    	}

    	$res = $this->db->write("INSERT into friend (`from_id`,`to_id`) VALUES ({$this->user_id},?)", [$id]);
    	if ($res)
    		return $this->db->last_id();
    	return false;
    }



    public function removeFriendRequist($id)
    {

       /* $res = $this->db->readOne("SELECT * from friend where from_id = {$this->user_id} and to_id = ? ", [$id]);
        if (!$res) {
            return false;
        }*/

        return $this->db->write("DELETE from friend where (from_id = {$this->user_id} and to_id = ? ) or (to_id = {$this->user_id} and from_id = ? )  ", [$id,$id]);
      
    }

    public function acceptFriendRequist($id)
    {
    	return $this->db->write("UPDATE friend set accept = 1 where to_id = {$this->user_id} and from_id = ?", [$id]);
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