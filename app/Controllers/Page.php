<?php

namespace App\Controllers;

class Page extends Base_controller
{
    public $user;
    public $page;
    public $course;
    public $posts_collection;
    public $data;




    public function __construct($request,$response,$params)
    {
        parent::__construct($request,$response,$params);


        $this->user = new \App\Models\User();
        if (!$this->user->isLoggedIn())
            return $this->redirect("/home/login/");
         //$this->user->logout();
        if (!$page_id = $this->request->getQueryParam('page_id')) 
        	return $this->redirect('/');

        $this->page = new \App\Models\Page($page_id);
        $this->course = new \App\Models\Course($this->page);
        $this->posts_collection = new \App\Models\PostCollection($this->page->getId());

        $this->data = [];
        $this->data['user'] = $this->user;
        $this->data['course'] = $this->course;

        $this->data['user_role'] = ($this->course->getInstructors($this->user->getId())!=null)?'i':'g';
        
        if ($this->data['user_role'] == 'g') {
       		$this->data['user_role'] = ($this->course->getStudents($this->user->getId())!= null)?'s':'g';
    	}
    	$this->data['type'] = 'course';

    }

	public function index()
    {
        $data = $this->data;
        $data['sub_page'] = 'timeline';
        $data['referer'] = '/page?page_id='.$this->page->getId();
        $data['post_page_id'] = $this->page->getId();
        $data['posts'] = $this->posts_collection->getPagePosts();

        echo $this->view->load('frontend:page:timeline',$data);
    }

    public function announcements()
    {
       


        $data = $this->data;
        $data['sub_page'] = 'announcements';
        $data['referer'] = '/page/announcements/?page_id='.$this->page->getId();
        $data['post_page_id'] = $this->page->getId();
        $data['posts'] = $this->posts_collection->getAnnouncements();

        echo $this->view->load('frontend:page:announcements',$data);

    }

    public function events()
    {
       


        $data = $this->data;
        $data['sub_page'] = 'events';
        $data['referer'] = '/page/events/?page_id='.$this->page->getId();
        $data['post_page_id'] = $this->page->getId();
        $data['posts'] = $this->posts_collection->getEventPosts();

        echo $this->view->load('frontend:page:announcements',$data);

    }

    public function allfiles() 
    {
    	$data = $this->data;
        $data['sub_page'] = 'all_files';
        $data['referer'] = '/page/allfiles/?page_id='.$this->page->getId();
        $data['post_page_id'] = $this->page->getId();
        $data['files'] = $this->posts_collection->getAllFiles();

        echo $this->view->load('frontend:page:files',$data);
    }

    public function instructorFiles() 
    {
    	$data = $this->data;
        $data['sub_page'] = 'instructorFiles';
        $data['referer'] = '/page/instructorFiles/?page_id='.$this->page->getId();
        $data['post_page_id'] = $this->page->getId();
        $data['files'] = $this->posts_collection->getInstructorFiles();

        echo $this->view->load('frontend:page:files',$data);
    }

    public function grades()
    {
    	$data = $this->data;
    	$grades = new \App\Models\Grade($this->page->getId());

    	$data['sub_page'] = 'grades';
        $data['referer'] = '/page/grades/?page_id='.$this->page->getId();
        $data['post_page_id'] = $this->page->getId();
        
        if ($data['user_role'] == 'i') {
        	$data['file_name'] = $grades->getUploadFileName();
        	$data['students'] = $grades->getAllStudentGrades();
        	echo $this->view->load('frontend:page:instructor_grades',$data);
    	} else if($data['user_role'] == 's') {
    		$data['grades'] = $grades->getStudentGrades($this->user->getIdentification());
    		echo $this->view->load('frontend:page:student_grades',$data);
    	} else {
    		die("404!");
    	}
    }

    public function broadcast()
    {
    	$data = $this->data;
        $data['sub_page'] = 'broadcast';
        $data['referer'] = '/page/broadcast/?page_id='.$this->page->getId();
        $data['post_page_id'] = $this->page->getId();

        echo $this->view->load('frontend:page:broadcast',$data);
    }
 

    
}