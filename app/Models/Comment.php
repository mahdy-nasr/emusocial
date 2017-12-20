<?php
namespace App\Models;

class Comment extends \App\Base
{
    protected $data;
    protected $id;
    static public  $limit = 10;
    static public  $start = 0;

    public function __construct($data = null,$with_replies = 1)
    {
        parent::__construct();
        if ($data)
        	$this->loadFullComment($data,$with_replies);
    }
    private function getCommentAttributes()
    {
    	return ['id','comment','parent_id','post_id','user_id','created_at','updated_at'];
    }
    public function getData()
    {
    	return $this->data;
    }
    private function seperateUserFromComment($data) 
    {
    	$user = [];
    	$comment = [];
    	$attr = $this->getCommentAttributes();
    	foreach ($data as $key => $value) {
    		if (in_array($key,$attr)) {
    			$comment[$key] = $value;
    		} else {
    			$user[$key] = $value;
    		}
    	}
    	$comment['user'] = $user;
    return $comment;
    }
    public function hasReplies()
    {
    	return count($this->data['replies']);
    }
    private function getReplies()
    {
    	$res = $this->db->read("SELECT user.*, comment.* from comment left join user on comment.user_id = user.id where parent_id = {$this->data['id']} ORDER BY comment.created_at DESC LIMIT ".self::$start.','.self::$limit);
    	if (!$res)
    		$this->data['replies'] = [];
    	$replies = [];
    	foreach ($res as $reply) {
    		$replies[] = new Comment($reply,0);
    	}

    	$this->data['replies'] = $replies;
    	
    }

    private function loadFullComment($data,$with_replies)
    {
    	$this->data = $this->seperateUserFromComment($data);
    	if ($with_replies)
    		$this->getReplies();
    }
 
}