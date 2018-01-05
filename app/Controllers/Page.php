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

    public function viewPost()
    {
       


        $data = $this->data;
        if (!$post_id = $this->request->getQueryParam('post_id')) 
            return $this->redirect("/page/?page_id={$this->page->getId()}");
        $data['sub_page'] = 'viewPost';
        $data['referer'] = "/page/viewPost/?page_id={$this->page->getId()}&post_id={$post_id}";
        $data['post_page_id'] = $this->page->getId();
        $post_model = new \App\Models\Post($post_id);
        if ($post_model->getPageId() != $this->page->getId())
            return $this->redirect("/page/?page_id={$this->page->getId()}");

        $data['posts'] = [$post_model];

        echo $this->view->load('frontend:page:viewPost',$data);

    }

    public function announcements()
    {
       


        $data = $this->data;
        $data['sub_page'] = 'announcements';
        $data['referer'] = '/page/announcements/?page_id='.$this->page->getId();
        $data['post_page_id'] = $this->page->getId();
        $data['posts'] = $this->posts_collection->getAnnouncements();
        $data['refresh_url'] = "post/getAnnouncementPosts/";
        echo $this->view->load('frontend:page:announcements',$data);

    }

    public function events()
    {
       //$noti = new \App\Models\Notification($this->user);
       //$noti->getAllNotification();

        $data = $this->data;
        $data['sub_page'] = 'events';
        $data['referer'] = '/page/events/?page_id='.$this->page->getId();
        $data['post_page_id'] = $this->page->getId();
        $data['posts'] = $this->posts_collection->getEventPosts();
        $data['refresh_url'] = "post/getEventsPosts/";
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
    	} else  {
    		$data['grades'] = $grades->getStudentGrades($this->user->getIdentification());
    		echo $this->view->load('frontend:page:student_grades',$data);
    	} 
    }

    public function broadcasts()
    {
    	$broadcast = new \App\Models\Broadcast();
    	$data = $this->data;
        $data['sub_page'] = 'broadcasts';
        $data['referer'] = '/page/broadcasts/?page_id='.$this->page->getId();
        $data['post_page_id'] = $this->page->getId();
        if($data['user_role'] == 'i') {
            $data['broadcasts'] = $broadcast->getPageBroadcast($this->page->getId(),5);
        } else {
            $data['broadcasts'] = $broadcast->getPageBroadcast($this->page->getId(),$this->user->getType());
        }

        echo $this->view->load('frontend:page:broadcasts',$data);
    }

    public function students()
    {
    	$data = $this->data;
    	$data['sub_page'] = 'students';
        $data['referer'] = '/page/students/?page_id='.$this->page->getId();
        $data['post_page_id'] = $this->page->getId();
        $data['students'] = [];
        echo $this->view->load('frontend:page:students',$data);

    }
 

    
}