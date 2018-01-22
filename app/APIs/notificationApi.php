<?php
namespace App\APIs;

class notificationApi extends API
{
    public function __construct($request, $response, $params)
    {
        parent::__construct($request, $response, $params);
    }

    public function newFun()
    {

        if (!$user = $this->authorized()) {
            return $this->forbiddenResponse();
        }


        //$page = new \App\Models\Page($this->user->getPageId());
        //die();
        $br = new \App\Models\Broadcast(null, $user->getId());
        $res = $br->getUserBroadcast();
        if($res) {
            $br->ackUserBroadcast();
        }
            return $this->json(["RC"=>200,'records'=>$res]);
       
    }

    public function allFun()
    {
        if (!$user = $this->authorized()) {
            return $this->forbiddenResponse();
        }
        
        $br = new \App\Models\Broadcast(null, $user->getId());
        $res = $br->getAllUserBroadcast();
        //var_dump($res);die;
        if($res) {
            $br->ackUserBroadcast();
        }
            return $this->json(["RC"=>200,'records'=>$res]);

    }
    

 
}