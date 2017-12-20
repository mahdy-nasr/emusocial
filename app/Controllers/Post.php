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

    public function createPost()
    {
    	if (!$this->user->isLoggedIn())
    		return $this->redirect('home/login');

    	if (!isset($this->args[0]) || ! is_numeric($this->args[0])) {
    		return $this->redirect("/");
    	}

    	$page = new \App\Models\Page($this->args[0]);
    	if (!$page->checkValidity())
    		return $this->redirect('/');
    	$post = new \App\Models\Post($this->user,$page);
    	if (!$post->createPost($this->post_data)) {
    		$this->Session::flash('error_post','problem adding post!');
    	}
    	if ($user['page_id'] == $this->args[0]) {
    		return $this->redirect('/');
    	}
    	return $this->redirect("/");
    }
}