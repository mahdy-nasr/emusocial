<?php

namespace App\Controllers;

class Profile extends Base_controller
{
    protected $user;
    protected $course_collection;
    protected $profile;
    protected $page;
    protected $friend;
    protected $user_collection;
    protected $post_collection;

    protected $data = [];




    public function __construct($request,$response,$params)
    {
        parent::__construct($request,$response,$params);
        
        if ($this->init()===false)
            return $this->redirect("/home/login/");   
    }

    public function index()
    {
        

        $data = $this->data;
        $data['referer'] = '/profile?id='.$this->profile->getId();
        $data['posts'] = $this->post_collection->getPagePosts();
        $data['sub_page'] = 'timeline';

        echo $this->view->load('frontend:profile:home:timeline',$data);
    }

    public function viewPost()
    {
       


        $data = $this->data;
        if (!$post_id = $this->request->getQueryParam('post_id')) 
            return $this->redirect("/");

        $data['referer'] = '/profile/viewPost/?id='.$this->profile->getId().'&post_id='.$post_id;
        $data['sub_page'] = 'timeline';

        $post_model = new \App\Models\Post($post_id);
        if ($post_model->getPageId() != $this->profile->getPageId())
            return $this->redirect("/profile");

        $data['posts'] = [$post_model];

        echo $this->view->load('frontend:profile:home:viewPost',$data);

    }

    public function about()
    {
        $data = $this->data;
        $events = new \App\Models\EventCollection();
        $noti =  new \App\Models\Notification($this->user);
        $data['notifications'] = $noti->getAllNotification(0, 100);
        $data['all_events'] = $events->getUserAllEvents($this->profile->getId());
        $data['all_courses'] = $this->course_collection->getAllCoursesForStudent($this->profile->getId());
        $data['referer'] = '/profile/about/?id='.$this->profile->getId();
        $data['sub_page'] = 'about';

        echo $this->view->load('frontend:profile:about',$data);   
    }

    public function friends()
    {
         $data = $this->data;

        $data['referer'] = '/profile/friends/?id='.$this->profile->getId();
        $data['sub_page'] = 'friends';
        $data['all_friends'] = $this->user_collection->getUsers($this->friend->getFriendsId(0,100));

        echo $this->view->load('frontend:profile:friends',$data);   
    }

    public function photos()
    {
         $data = $this->data;

        $data['referer'] = '/profile/photos/?id='.$this->profile->getId();
        $data['sub_page'] = 'photos';

        echo $this->view->load('frontend:profile:photos',$data);   
    }

    public function chat()
    {
         $data = $this->data;

        $data['referer'] = '/profile/chat/?id='.$this->profile->getId();
        $data['sub_page'] = 'chat';

        echo $this->view->load('frontend:chat',$data);   
    }

    public function editProfile()
    {
        $upload =  new \App\Helpers\Upload('image');
        
        $result = [];
        $upload->uploadAll(['profile_picture']);
        if (!count($upload->getErrors())) {
            $this->post_data['profile_picture'] = $upload->getResult()[0]['link'];
        }

        $upload =  new \App\Helpers\Upload('image');
        $upload->uploadAll(['cover_picture']);
        if (!count($upload->getErrors())) {
            $this->post_data['cover_picture'] = $upload->getResult()[0]['link'];
        }
        
        $this->user->editUserProfile($this->post_data);
        return $this->redirect("/profile/about/");
    }

    private function init()
    {
        $this->user = new \App\Models\User();

        if (!$this->user->isLoggedIn())
            return false;;

        if ($this->request->getQueryParam('id')) 
            $this->profile = new \App\Models\User($this->request->getQueryParam('id'));
        else 
            $this->profile = $this->user;

        $this->page = new \App\Models\Page();
        $this->course_collection = new \App\Models\Course_Collection();
        $this->friend = new \App\Models\Friend($this->profile->getId());
        $this->user_collection = new \App\Models\UserCollection();
        $this->post_collection = new \App\Models\PostCollection($this->profile->getPageId());

        $this->data['friend'] = new \App\Models\Friend($this->user->getId());
        $this->data['user'] = $this->user;
        $this->data['profile'] = $this->profile;
        $this->data['type'] = 'profile';
        $this->data['post_page_id'] = $this->user->getPageId();

        if ($this->profile->getUserType() == 'student') {   
            $this->data['courses'] = $this->course_collection->getCoursesForStudent($this->profile->getId());
        } else {
            $this->data['courses'] = $this->course_collection->getCoursesForInstructor($this->profile->getId());
        }

        $this->data['friends'] = $this->user_collection->getUsers($this->friend->getFriendsId(0,6));
        return true;
    }
 

    
}