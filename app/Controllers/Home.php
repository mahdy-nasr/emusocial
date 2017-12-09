<?php

namespace App\Controllers;

class Home extends Base_controller
{
    public $admin;
    public $instructor;
    public $student;
    public $course;



    public function __construct($request,$response,$params)
    {
        parent::__construct($request,$response,$params);
    }

    public function index()
    {
    	echo $this->view->load('frontend:home');
    }

    public function login()
    {

    }
}