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

    public function addBroadcast()
    {

    }

    public function deleteBroadcast()
    {

    }
    
    public function getPageBroadcast($page_id=null)
    {
    	if (!$page_id)
    		$page_id = $this->page_id;
    	if (!$page_id) return false;

    }
    public function getUserBroadcast($user_id=null)
    {
    	if (!$user_id)
    		$user_id = $this->user_id;
    	if (!$user_id) return false;

    	$res = $this->db->read("SELECT broadcast.*, CONCAT(user.first_name,' ',user.last_name) as username, user.id as user_id from broadcast left join user on  user.id = broadcast.user_id where broadcast.page_id IN (select page.id from page right join page_user on page_user.page_id = page.id where page.active = 1 and page_user.user_id = $user_id and broadcast.id>page_user.broadcast)"):

    	if (!$res)
    		return [];
    	return $res;
    }
}