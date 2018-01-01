<?php
namespace App\Models;

class Broadcast extends \App\Base
{
    private $page_id;
    private $user_id;

    public function __construct($page_id=null,$user_id=null)
    {
        parent::__construct();
        $this->page_id = $page_id;
        $this->user_id = $user_id;
    }

    public function setPageId($page_id) 
    {
    	$this->page_id = $page_id;
    }

    public function setUserId($user_id)
    {
    	$this->user_id = $user_id;
    }

    public function addBroadcast($data)
    {
    	$important = ['page_id','user_id','title'];
    	$insert=[];
    	foreach ($important as $key) {
    		if (!isset($data[$key])||empty($data[$key])) {
    			return false;
    		}
    		$insert[':'.$key] = $data[$key];
    	}
    	if (!isset($data['msg'])||empty($data['msg'])) {
    		$insert[':msg'] = '';
    	} else {
    		$insert[':msg'] = $data['msg'];
    	}
    	//var_dump($insert);die;
    	
    	return $this->db->write("INSERT into broadcast (`page_id`,`user_id`,`title`,`msg`) VALUES (:page_id, :user_id, :title, :msg)",$insert);
    }

    public function deleteBroadcast($id)
    {
    	return $this->db->write("DELETE from broadcast where id = ?",[$id]);
    }

    public function getPageBroadcast($page_id=null)
    {
    	if (!$page_id)
    		$page_id = $this->page_id;
    	if (!$page_id) return false;

    	$res = $this->db->read("SELECT broadcast.*, CONCAT(user.first_name,' ',user.last_name) as username, user.id as user_id from broadcast left join user on  user.id = broadcast.user_id where broadcast.page_id = $page_id order by broadcast.created_at desc");

    

    	if (!$res)
    		return [];
    	return $res;

    }

    public function ackUserBroadcast($user_id=null)
    {
    	if (!$user_id)
    		$user_id = $this->user_id;
    	if (!$user_id) return false;

    	$casts = $this->getUserBroadcast($user_id);
    	if (!count($casts))
    		return ;
    	$id = $casts[0]['id'];

    	return $this->db->write("UPDATE page_user SET broadcast = $id where user_id = ?",[$user_id]);

    }
    public function getUserBroadcast($user_id=null)
    {
    	if (!$user_id)
    		$user_id = $this->user_id;
    	if (!$user_id) return false;

    	$res = $this->db->read("SELECT broadcast.*, course.code as course_code, CONCAT(user.first_name,' ',user.last_name) as username, user.id as user_id from broadcast left join user on  user.id = broadcast.user_id left join page on broadcast.page_id = page.id left join course on course.id = page.course_id where broadcast.page_id IN (select page.id from page right join page_user on page_user.page_id = page.id left join course on course.id = page.course_id where course.readonly = 0 and page_user.user_id = $user_id and broadcast.id>page_user.broadcast) order by broadcast.created_at desc");



    	if (!$res)
    		return [];
    	return $res;
    }
}