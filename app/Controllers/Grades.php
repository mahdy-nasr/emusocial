<?php

namespace App\Controllers;

class Grades extends Base_controller
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

    public function postGrades()
    {
    	if (!$this->user->isLoggedIn())
    		return $this->redirect('/home/login');


    	//$page = new \App\Models\Page($this->user->getPageId());
       if(!isset($this->post_data['page_id']))
            return $this->redirect('/');

    	$grades = new \App\Models\Grade($this->post_data['page_id']);
        $err = $grades->processGrades($this->post_data);
        if($err === false) {
            $this->Session::flash('error_grades',$grades->getErrorsHtml());
        }


  
    	return $this->redirect($this->post_data['referer']);
    }


    public function deleteGrades()
    {
        if (!$this->user->isLoggedIn())
            return $this->redirect('/home/login'); 

        if (!$page_id = $this->request->getQueryParam('page_id')) 
            return $this->redirect('/');
        $grades  = new \App\Models\Grade($page_id);
        $grades->removeGrades();
        //die("what happen");
        return $this->redirect('/page/grades/?page_id='.$page_id);
    }
}

