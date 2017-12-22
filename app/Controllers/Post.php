<?php

namespace App\Controllers;

class Post extends Base_controller
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

    public function createProfilePost()
    {
    	if (!$this->user->isLoggedIn())
    		return $this->redirect('home/login');


    	//$page = new \App\Models\Page($this->user->getPageId());
    	$post = new \App\Models\Post();

        $post->setUserAndPage($this->user->getId(), $this->user->getPageId());
    	if (!$post->createPost($this->post_data)) {
    		$this->Session::flash('error_post','problem adding post!');
    	}
  
    	return $this->redirect("/Profile");
    }

    public function doLike()
    {
        if (!$this->user->isLoggedIn())
            return $this->redirect('home/login'); 
        if (!isset($this->post_data['post_id'])) 
            return json_encode(["RC"=>400]);

        $post = new \App\Models\Post($this->post_data['post_id']);

       

        $post->getLikes()->doLike($this->user->getId());
        return json_encode(['RC'=>200,'count'=>$post->getLikes('count')]);
      
    }
    public function removeLike()
    {
        if (!$this->user->isLoggedIn())
            return $this->redirect('home/login'); 

        if (!isset($this->post_data['post_id'])) 
            return json_encode(["RC"=>400]);

        $post = new \App\Models\Post($this->post_data['post_id']);



        $post->getLikes()->removeLike($this->user->getId());
        return json_encode(['RC'=>200,'count'=>$post->getLikes('count')]);
    }

    public function getComments()
    {
         if (!$this->user->isLoggedIn())
            return $this->redirect("/home/login/");
       
        $data = [];
        $data['user'] = $this->user;
        $data['type'] = 'profile';
        if(!$this->request->getQueryParam('post_id'))
            die('no way!');
        $data['post'] = new \App\Models\Post($this->request->getQueryParam('post_id'),1);
      

        return $this->view->load('frontend-parts/comment-view',$data);
    }

    public function getProfilePosts()
    {
         if (!$this->user->isLoggedIn())
            return $this->redirect("/home/login/");

        if ($this->request->getQueryParam('id')) 
            $profile = new \App\Models\User($this->request->getQueryParam('id'));
        else 
            $profile = $this->user;

         $page = new \App\Models\Page($profile->getId());
 
       
        $data = [];
        $data['profile'] = $profile;
        $data['user'] = $this->user;
        $data['page'] = $page->getUserPage();
        $data['type'] = 'profile';
        $posts_collection = new \App\Models\PostCollection($page->getId());
        

        if(!$this->request->getQueryParam('start')||!$this->request->getQueryParam('limit'))
            die('no way!');
        $data['posts'] = $posts_collection->getPagePosts($this->request->getQueryParam('start'), $this->request->getQueryParam('limit'));
      

        return $this->view->load('frontend-parts/post-view',$data);
    }
    public function deletePost()
    {
        if (!$this->user->isLoggedIn())
            return $this->redirect('home/login');
        if (!isset($this->args[0]) || !isset($this->args[1])) {
            return $this->redirect('/');
        }

        if ($this->args[1] == 'profile') {
            $referer = "/Profile";
        } else {

        }

        $post = new \App\Models\Post();
        $post->deletePost($this->args[0], $this->user->getId());

        return $this->redirect($referer);
    }
}

