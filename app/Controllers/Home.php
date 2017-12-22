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
        die("404");
        
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