<?php
namespace App\APIs;

class chatApi extends API
{
    public function __construct($request, $response, $params)
    {
        parent::__construct($request, $response, $params);
    }

    public function sendMessage()
    {
    	if (!$user = $this->authorized()) {
            return $this->forbiddenResponse();
        }

        $chat = new \App\Models\Chat($user->getId());

        if(!isset($this->data['target_id']))
             return $this->json(['RC'=>400,'msg'=>'no target specified'], 200);

        $chat->setTargetId($this->data['target_id']);

        if(!$chat->sendMessage($this->data['message'])) {
            return $this->json(['RC'=>400,'msg'=>'problem sending message'], 200);
        }

        return $this->json(['RC'=>200], 200);

    }//

    public function getMessages()
    {
    	if (!$user = $this->authorized()) {
            return $this->forbiddenResponse();
        }
        $start = $this->request->getQueryParam('start',0);
        $limit = $this->request->getQueryParam('limit',10);

        $chat = new \App\Models\Chat($user->getId());

        if(!$target_id = $this->request->getQueryParam('id'))
             return $this->json(['RC'=>400,'msg'=>'no target specified'], 200);
        $chat->setTargetId($target_id);

        $data =  $chat->loadMessages($start,$limit);
        return $this->json(['RC'=>200,'records'=>$data], 200);
    }

    public function getNewMessages()
    {
    	if (!$user = $this->authorized()) {
            return $this->forbiddenResponse();
        }

        $chat = new \App\Models\Chat($user->getId());

        if(!$target_id = $this->request->getQueryParam('id'))
             return $this->json(['RC'=>400,'msg'=>'no target specified'], 200);
        $chat->setTargetId($target_id);
        $data =  $chat->loadNewMessage();
        return $this->json(['RC'=>200,'records'=>$data], 200);
    }
}