<?php

namespace App\Controllers;

class Home extends Base_controller
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


    public function index()
    {
        if (!$this->user->isLoggedIn())
            return $this->redirect("/home/login/");
         //$this->user->logout();
        $page = new \App\Models\Page();
        $course = new \App\Models\Course();
        $friend = new \App\Models\Friend($this->user->getId());
       
        $data = [];
        $data['user'] = $this->user->getUserData();
        $data['page'] = $page->getUserPage($data['user']);
        $data['type'] = 'profile';
        $posts_collection = new \App\Models\PostCollection($page->getId());
        $data['posts'] = $posts_collection->getPagePosts();
      
        if ($this->user->getUserType() == 'student') {   
            $data['courses'] = $course->getCoursesForStudent($this->user->getId());
        } else {
            $data['courses'] = $course->getCoursesForInstructor($this->user->getId());
        }

        $data['friends'] = $this->user->getUsers($friend->getFriendsId(0,6));

    	echo $this->view->load('frontend:profile',$data);
    }

    public function login()
    {
        $data = $this->request->getParsedBody();
        if(isset($data['identification'])&&isset($data['password'])) {
            if ($token = $this->user->login($data['identification'], $data['password'])) {
                
                return $this->redirect("/");
            }

            $this->Session::flash("error_login","The identification or password is incorrect!");
            return $this->redirect("/home/login/");
        } else {
            echo $this->view->load('login');
        }
    }
}