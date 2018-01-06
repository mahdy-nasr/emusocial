<?php

namespace App\Controllers;

class Friends extends Base_controller
{
    public $user;
    public $instructor;
    public $page;
    public $course;




    public function __construct($request,$response,$params)
    {
        parent::__construct($request,$response,$params);
        $this->user = new \App\Models\User();


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
