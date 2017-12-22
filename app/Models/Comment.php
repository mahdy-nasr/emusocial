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
        if ($data && is_array($data))
        	$this->loadFullComment($data,$with_replies);
        else if ($data)
        	$this->loadFullById($data,$with_replies);

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
    	$user['id'] = $data['user_id'];
    	$comment['user'] = new User($user);
    	return $comment;
    }

    public function deleteComment($comment_id,$user_id)
    {
    	$res = $this->db->readOne("SELECT * from comment where id = ?",[$comment_id]);

        if (!$res || $res['user_id'] != $user_id) {
            return false;
        }

        $queries = [
                        ["DELETE from like_comment where comment_id = ?",[$comment_id]],
                        ["DELETE from comment where parent_id = ?",[$comment_id]],
                        ["DELETE from comment where id = ?",[$comment_id]]
                    ];
        return $this->db->runTransaction($queries);
    }

    public function addComment($data)
    {
    	if (!isset($data['user_id']) || !isset($data['comment']) || 
    		!isset($data['post_id']) || !isset($data['parent_id']))
    		return 0;

    	if ( empty($data['user_id']) || empty($data['comment']) || 
    		 empty($data['post_id']) || !is_numeric($data['parent_id']) )
    		return 0;

 
    	$insert = [];
    	$insert[':user_id']   =  $data['user_id'];
    	$insert[':post_id']   =  $data['post_id'];
    	$insert[':comment']   =  $data['comment'];
    	$insert[':parent_id'] =  $data['parent_id'];
    	$insert[':created_at'] = date('Y-m-d H-i-s');
 

    	$res = $this->db->write("INSERT into comment (`user_id`,`post_id`,`comment`,`parent_id`,`created_at`) VALUES (:user_id , :post_id , :comment , :parent_id,:created_at )", $insert);

    	if (!$res)
    		return false;

    	return $this->db->last_id();

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
    public function hasLikes()
    {
    	return $this->data['likes']->getCount();
    }
    private function loadLikes()
    {

       $this->data['likes'] = new Like('comment',$this->getId());

    }

    private function loadFullById($id,$with_replies)
    {
    	$data = $this->db->readOne("SELECT user.*,comment.* from comment left join user  on user.id = comment.user_id  where comment.id = ?",[$id]);
    	$this->data = $this->seperateUserFromComment($data);
    	if ($with_replies && $this->data['parent_id']==0)
    		$this->getReplies();
    	$this->loadLikes();
    }
    private function loadFullComment($data,$with_replies)
    {
    	$this->data = $this->seperateUserFromComment($data);
    	if ($with_replies)
    		$this->getReplies();
    	$this->loadLikes();
    }


 
}