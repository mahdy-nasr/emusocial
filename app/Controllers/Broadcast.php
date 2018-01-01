<?php

namespace App\Controllers;

class Broadcast extends Base_controller
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

    public function postBroadcast()
    {
    	if (!$this->user->isLoggedIn())
    		return $this->redirect('/home/login');


    	//$page = new \App\Models\Page($this->user->getPageId());
       if(!isset($this->post_data['page_id']))
            return $this->redirect('/');

    	$broadcast = new \App\Models\Broadcast();
        $broadcast->addBroadcast($this->post_data);

  
    	return $this->redirect($this->post_data['referer']);
    }


    public function deleteBroadcast()
    {
        if (!$this->user->isLoggedIn())
            return $this->redirect('/home/login'); 
        $broadcast_id = $this->request->getQueryParam('broadcast_id');
        $page_id = $this->request->getQueryParam('page_id');
        if (!$broadcast_id  || !$page_id ) 
            return $this->redirect('/');
        $broadcast  = new \App\Models\Broadcast();
        $broadcast->deleteBroadcast($broadcast_id);
        //die("what happen");
        return $this->redirect('/page/broadcasts/?page_id='.$page_id);
    }
}

