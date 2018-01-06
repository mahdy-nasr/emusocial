<?php
namespace App\Models;

class Chat extends \App\Base
{
    protected $data;
    protected $user_id;
    protected $target_id;

    public function __construct($user_id)
    {
        parent::__construct();
        $this->user_id = $user_id;
    }

    public function setTargetId($target_id)
    {
    	$this->target_id = $target_id;
    }


    private function ackNewMessage() {
    	return $this->db->write("UPDATE message SET NEW = 0 where to_id = {$this->user_id} and from_id = {$this->target_id}");
    }

    public function loadMessages($start = 0, $limit = 10)
    {
    	$res = $this->db->read("SELECT message.* from message where (from_id = {$this->user_id} and to_id = {$this->target_id}) or (from_id = {$this->target_id} and to_id = {$this->user_id}) order by created_at DESC limit $start,$limit");
    	if(!$res)
    		return [];
    	return $res;
    }

    public function getAllChats()
    {
    	$targets = "(SELECT chat_users.* from (select @user_id_var:={$this->user_id}) parm, chat_users) as targets";
    	$res = $this->db->read("SELECT user.*,message.msg ,message.created_at as message_created_at,message.from_id,message.new from $targets left join user on user.id = targets.target_id left join message on message.created_at = targets.created_at_date where targets.target_id = message.from_id or targets.target_id = message.to_id order by message.created_at DESC");

    	$output = [];
    	foreach ($res as $key => $value) {
    		$res[$key]['message'] = [
    			"passed_time"=>passedTime($value['message_created_at']),
    			"created_at"=>$value['message_created_at'],
    			"msg" => $value['msg'],
    			"sent" => ($value['from_id']==$value['id'])?0:1,
    			"new" => ($value['from_id']==$value['id'] && $value['new'])?1:0
    			];
    		$output[$value['id']] = new User($res[$key]);
    	}
    	return $output;
    }

    public function sendMessage($message)
    {
    	if(empty($message))
    		return false;
    	$created_at = date('Y-m-d H-i-s');
    	return $this->db->write("INSERT into message (`from_id`,`to_id`,`msg`,`created_at`) VALUES ({$this->user_id}, {$this->target_id}, '{$message}','{$created_at}')");
    }

    public function countNewMessages()
    {
    	$res = $this->db->readOne("SELECT count(DISTINCT id) as count from message where from_id = {$this->target_id} and to_id = {$this->user_id} and new = 1")['count'];
    	return $res;
    }

    public function loadNewMessage()
    {
    	$res = $this->db->read("SELECT message.* from message where from_id = {$this->target_id} and to_id = {$this->user_id} and new = 1 order by created_at DESC");
    	if (!$res)
    		return [];
    	$this->ackNewMessage();
    	foreach ($res as $key => $value) {
    		$res[$key]['passed_time'] = passedTime($value['created_at']);
    	}

    	return $res;
    }

    /*
    create view chat_users as (select vw.target_id,Max(vw.created_at) as created_at_date from ((select from_id as target_id, MAX(created_at) as created_at from message where to_id = user_id() GROUP by from_id) UNION (select  to_id as target_id, MAX(created_at) as created_at from message where from_id = user_id() GROUP by to_id)) as vw group by vw.target_id order by created_at_date DESC)
     */

}