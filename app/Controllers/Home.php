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
        if (!$this->user->isLoggedIn()){
            return $this->redirect("/home/login/");
        }
        $data = [];
        $data['user'] = $this->user;
        echo $this->view->load('frontend:home', $data);
        
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

    public function logout()
    {
        if (!$this->user->isLoggedIn()){
            return $this->redirect("/home/login/");
        } else {
            $this->user->logout();
            return $this->redirect("/home/login/");
        }
    }
}