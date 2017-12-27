<?php

namespace App\Controllers;

class Comment extends Base_controller
{
    public $user;
    public $instructor;
    public $student;
    public $course;




    public function __construct($request,$response,$params)
    {
        parent::__construct($request,$response,$params);
        $this->user = new \App\Models\User();
    }

    public function createComment()
    {
    	if (!$this->user->isLoggedIn())
    		return json_encode(['RC'=>403]);


    	//$page = new \App\Models\Page($this->user->getPageId());
    	$comment = new \App\Models\Comment();
        $this->post_data['user_id'] = $this->user->getId();

        if (!$comment->addComment($this->post_data)) {
            return json_encode(['RC'=>400,'msg'=>'problem']);
        }
  
    	return  json_encode(['RC'=>200]);
    }
    public function doLike()
    {
        if (!$this->user->isLoggedIn())
            return $this->redirect('home/login'); 
        if (!isset($this->post_data['comment_id'])) 
            return json_encode(["RC"=>400]);

        $comment = new \App\Models\Comment($this->post_data['comment_id']);



        $comment->getLikes()->doLike($this->user->getId());
        return json_encode(['RC'=>200,'count'=>$comment->getLikes('count')]);
      
    }

    public function removeLike()
    {
       if (!$this->user->isLoggedIn())
            return $this->redirect('home/login'); 
        if (!isset($this->post_data['comment_id'])) 
            return json_encode(["RC"=>400]);

        $comment = new \App\Models\Comment($this->post_data['comment_id']);

     

        $comment->getLikes()->removeLike($this->user->getId());
        return json_encode(['RC'=>200,'count'=>$comment->getLikes('count')]);
    }

    public function deleteComment()
    {
        if (!$this->user->isLoggedIn())
            return $this->redirect('home/login');
        if (!isset($this->args[0])) {
            return json_encode(["RC"=>400]);
        }

       

        $comment = new \App\Models\Comment($this->args[0]);
        $comment->deleteComment($this->args[0], $this->user->getId());

        return  json_encode(["RC"=>200,"post_id"=>$comment->getPostId()]);
    }
}