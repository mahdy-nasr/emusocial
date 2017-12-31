<?php

namespace App\Controllers;

class Profile extends Base_controller
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
         if ($this->request->getQueryParam('id')) 
            $profile = new \App\Models\User($this->request->getQueryParam('id'));
        else 
            $profile = $this->user;

        $page = new \App\Models\Page();
        $course = new \App\Models\Course_Collection();
        $friend = new \App\Models\Friend($profile->getId());
        $users = new \App\Models\UserCollection();

        $data = [];
        $data['user'] = $this->user;

        $data['profile'] = $profile;     
        $data['page'] = $page->getUserPage($profile->getId());
        $data['type'] = 'profile';
        $data['referer'] = '/profile?id='.$profile->getId();
        $data['post_page_id'] = $this->user->getPageId();
        $posts_collection = new \App\Models\PostCollection($page->getId());
        $data['posts'] = $posts_collection->getPagePosts();
      
        if ($profile->getUserType() == 'student') {   
            $data['courses'] = $course->getCoursesForStudent($profile->getId());
        } else {
            $data['courses'] = $course->getCoursesForInstructor($profile->getId());
        }

        $data['friend'] = new \App\Models\Friend($this->user->getId());
        $data['friends'] = $users->getUsers($friend->getFriendsId(0,6));

        echo $this->view->load('frontend:profile',$data);
    }

    public function addFriend()
    {
        if (!$this->user->isLoggedIn())
            return $this->redirect("/home/login/");

        if (!($id = $this->request->getQueryParam('id'))) 
            return $this->redirect("/profile");

        $friend = new \App\Models\Friend($this->user->getId());
        $friend->makeFriendRequist($id);
        return $this->redirect("/profile?id=$id");

    }

    public function removeRequest()
    {
        if (!$this->user->isLoggedIn())
            return $this->redirect("/home/login/");

        if (!($id = $this->request->getQueryParam('id'))) 
            return $this->redirect("/profile");

        $friend = new \App\Models\Friend($this->user->getId());
        $friend->removeFriendRequist($id);
        return $this->redirect("/profile?id=$id");

    }

    public function acceptRequest()
    {
        if (!$this->user->isLoggedIn())
            return $this->redirect("/home/login/");

        if (!($id = $this->request->getQueryParam('id'))) 
            return $this->redirect("/profile");

        $friend = new \App\Models\Friend($this->user->getId());
        $friend->acceptFriendRequist($id);
        return $this->redirect("/profile?id=$id");

    }
 

    
}