<?php
namespace App\APIs;

class commentApi extends API
{
    public function __construct($request, $response, $params)
    {
        parent::__construct($request, $response, $params);
    }

    public function createComment()
    {

        if (!$user = $this->authorized()) {
            return $this->forbiddenResponse();
        }


        //$page = new \App\Models\Page($this->user->getPageId());
        $comment = new \App\Models\Comment();
        $this->post_data['user_id'] = $user->getId();

        if (!$comment->addComment($this->post_data)) {
            return json_encode(['RC'=>400,'msg'=>'problem']);
        }
  
        return  json_encode(['RC'=>200]);
    }

    public function deleteComment()
    {
        if (!$user = $this->authorized()) {
            return $this->forbiddenResponse();
        }

        if (!isset($this->args[0])) {
            return json_encode(["RC"=>400]);
        }

       

        $comment = new \App\Models\Comment($this->args[0]);
        $comment->deleteComment($this->args[0], $user->getId());

        return  json_encode(["RC"=>200,"post_id"=>$comment->getPostId()]);

    }
    
    public function getComments()
    {
        if (!$user = $this->authorized()) {
            return $this->forbiddenResponse();
        }
       
        $data = [];
        $data['user'] = $this->user;
        $data['type'] = 'profile';
        if(!$this->request->getQueryParam('post_id'))
             return json_encode(["RC"=>400]);

        $data['post'] = new \App\Models\Post($this->request->getQueryParam('post_id'),1);
      

        return   json_encode(["RC"=>200,"records"=>$data['post']->getComments()]);
    }

 
}