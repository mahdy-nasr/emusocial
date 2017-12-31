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
        $this->data['user_id'] = $user->getId();

        if (!$comment->addComment($this->data)) {
            return $this->json(['RC'=>400,'msg'=>'problem']);
        }
  
        return  $this->json(['RC'=>200]);
    }

    public function deleteComment()
    {
        if (!$user = $this->authorized()) {
            return $this->forbiddenResponse();
        }

        if (!isset($this->data['comment_id'])) {
            return $this->json(["RC"=>400]);
        }

       

        $comment = new \App\Models\Comment($this->data['comment_id']);
        $comment->deleteComment($this->data['comment_id'], $user->getId());

        return  $this->json(["RC"=>200,"post_id"=>$comment->getPostId()]);

    }
    
    public function getComments()
    {
        if (!$user = $this->authorized()) {
            return $this->forbiddenResponse();
        }
       
        $data = [];
        $data['user'] = $user;
        $data['type'] = 'profile';
        if(!$this->request->getQueryParam('post_id'))
             return $this->json(["RC"=>400]);

        $data['post'] = new \App\Models\Post($this->request->getQueryParam('post_id'),1);
      

        return   $this->json(["RC"=>200,"records"=>$data['post']->getComments()]);
    }

 
}