<?php

namespace App\Controllers;

class Chat extends Base_controller
{
    public $user;
    public $instructor;
    public $page;
    public $course;
    public $chat;




    public function __construct($request,$response,$params)
    {
        parent::__construct($request,$response,$params);
        $this->user = new \App\Models\User();
        $this->chat = new \App\Models\Chat($this->user->getId());

    }

    public function index()
    {
        if (!$this->user->isLoggedIn())
            return false;
        if(!$target_id = $this->request->getQueryParam('id')) {
            return $this->redirect("/profile/friends/");
        }
        $target = new \App\Models\User($target_id);
       
        $this->chat->setTargetId($target_id);

        $data['referer'] = '/chat';
        $data['sub_page'] = 'chat';
        $data['user'] = $this->user;
        $data['target'] = $target;
        $data['type'] = 'profile';
        $data['messages'] = $this->chat->loadMessages();
        $data['all_chats'] = $this->chat->getAllChats();
        if (isset($data['all_chats'][$target_id])) {
            $data['active_side'] = $data['all_chats'][$target_id];
        } else {
            $data['active_side'] = $target;
        }

        unset($data['all_chats'][$target_id]);
       // var_dump($data['all_chats']);die;


        echo $this->view->load('frontend:chat',$data);  
    }

    public function choose()
    {

    }

    



   
}

