<?php
namespace App\APIs;

class courseApi extends API
{

	protected $role;
	protected $page;
	protected $course;
	protected $user;
	protected $posts_collection;


    public function __construct($request, $response, $params)
    {
        parent::__construct($request, $response, $params);
    }

    private function init($method = "get")
    {
    	if (!$user = $this->authorized()) {
            return false;
        }

        if ($method == "get" && !$page_id = $this->request->getQueryParam('page_id')) 
        	return false;
        else if ($method == "post" && !isset($this->data['page_id']))
        	return false;
      	
      	if($method == "post")
       	$page_id = $this->data['page_id'];

        $this->user = $user;
        $this->page = new \App\Models\Page($page_id);
        $this->course = new \App\Models\Course($this->page);
        $this->posts_collection = new \App\Models\PostCollection($this->page->getId());

  

        $this->role= ($this->course->getInstructors($this->user->getId())!=null)?'i':'g';
        
        if ($this->role == 'g') {
       		$this->role = ($this->course->getStudents($this->user->getId())!= null)?'s':'g';
    	}


    	return true;
    }

    public function getStudents()
    {
    	if ($this->init() === false) {
            return $this->forbiddenResponse();
        }

        $data = $this->course->getStudents();
        return $this->json(['RC'=>200,'students'=>$data]);
    }

    public function getTimeline()
    {
    	if ($this->init() === false) {
            return $this->forbiddenResponse();
        }
        $start = $this->request->getQueryParam('start',0);
        $limit = $this->request->getQueryParam('limit',10);

        $data = $this->posts_collection->getPagePosts($start, $limit);
        return $this->json(['RC'=>200,'posts'=>$data]);
    }

    public function getAnnouncements()
    {
    	if ($this->init() === false) {
            return $this->forbiddenResponse();
        }

        $start = $this->request->getQueryParam('start',0);
        $limit = $this->request->getQueryParam('limit',10);

        $data = $this->posts_collection->getAnnouncements($start, $limit);
        return $this->json(['RC'=>200,'announcement_posts'=>$data]);

    }

    public function getEvents()
    {
    	if ($this->init() === false) {
            return $this->forbiddenResponse();
        }

        $start = $this->request->getQueryParam('start',0);
        $limit = $this->request->getQueryParam('limit',10);

        $data = $this->posts_collection->getEventPosts($start, $limit);
        return $this->json(['RC'=>200,'event_posts'=>$data]);

    }

    public function getGrades()
    {
    	if ($this->init() === false) {
            return $this->forbiddenResponse();
        }

        $grades = new \App\Models\Grade($this->page->getId());
        $data = $grades->getStudentGrades($this->user->getIdentification());
        return $this->json(['RC'=>200,'grades'=>$data]);
    }

    public function getAdminFiles()
    {
    	if ($this->init() === false) {
            return $this->forbiddenResponse();
        }

        $data = $this->posts_collection->getInstructorFiles();
        return $this->json(['RC'=>200,'files'=>$data]);
    }

    public function getAllFiles()
    {
    	if ($this->init() === false) {
            return $this->forbiddenResponse();
        }

        $data = $this->posts_collection->getAllFiles();
        return $this->json(['RC'=>200,'files'=>$data]);

    }

    public function getBroadcasts()
    {
    	if ($this->init() === false) {
            return $this->forbiddenResponse();
        }

        $broadcast = new \App\Models\Broadcast();
        $data = $broadcast->getPageBroadcast($this->page->getId(),$this->user->getType());
        return $this->json(['RC'=>200,'broadcasts'=>$data]);

    }

    public function post()
    {
    	if ($this->init('post') === false) {
            return $this->forbiddenResponse();
        }

        $post = new \App\Models\Post();

        $post->setUserAndPage($this->user->getId(), $this->page->getId());
    	if (!$post->createPost($this->data)) {
    		return $this->json(["RC"=>400,"msg"=>"problem adding post!"]);
    	}

    	return $this->json(['RC'=>200]);
    }
}