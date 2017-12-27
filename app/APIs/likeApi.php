<?php
namespace App\APIs;

class likeApi extends API
{
    public function __construct($request, $response, $params)
    {
        parent::__construct($request, $response, $params);
    }

    public function likePost()
    {

        if (!$user = $this->authorized()) {
            return $this->forbiddenResponse();
        }

        if (!$user->isLoggedIn())
            return $this->redirect('home/login'); 
        if (!isset($this->data['post_id'])) 
            return json_encode(["RC"=>400]);

        $post = new \App\Models\Post($this->data['post_id']);

       

        $post->getLikes()->doLike($user->getId());
        return json_encode(['RC'=>200,'count'=>$post->getLikes('count')]);
    }

    public function dislikePost()
    {
        if (!$user = $this->authorized()) {
            return $this->forbiddenResponse();
        }

        if (!isset($this->data['post_id'])) 
            return json_encode(["RC"=>400]);

        $post = new \App\Models\Post($this->data['post_id']);



        $post->getLikes()->removeLike($user->getId());
        return json_encode(['RC'=>200,'count'=>$post->getLikes('count')]);
    }
    
    public function likeComment()
    {
        if (!$user = $this->authorized()) {
            return $this->forbiddenResponse();
        }

        if (!isset($this->data['post_id'])) 
            return json_encode(["RC"=>400]);

        $comment = new \App\Models\Comment($this->data['post_id']);



        $comment->getLikes()->doLike($user->getId());
        return json_encode(['RC'=>200,'count'=>$comment->getLikes('count')]);
    }

    public function dislikeComment()
    {
        if (!$user = $this->authorized()) {
            return $this->forbiddenResponse();
        }

        if (!isset($this->data['post_id'])) 
            return json_encode(["RC"=>400]);

        $comment = new \App\Models\Comment($this->data['post_id']);

     

        $comment->getLikes()->removeLike($user->getId());
        return json_encode(['RC'=>200,'count'=>$comment->getLikes('count')]);

    }


   

}