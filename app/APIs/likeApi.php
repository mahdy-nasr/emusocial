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

        if (!isset($this->data['post_id'])) 
            return json_encode(["RC"=>400]);

        $post = new \App\Models\Post($this->data['post_id']);

       

        $post->getLikes()->doLike($user->getId());
        return $this->json(['RC'=>200,'count'=>$post->getLikes('count')]);
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
        return $this->json(['RC'=>200,'count'=>$post->getLikes('count')]);
    }
    
    public function likeComment()
    {
        if (!$user = $this->authorized()) {
            return $this->forbiddenResponse();
        }

        if (!isset($this->data['comment_id'])) 
            return json_encode(["RC"=>400]);

        $comment = new \App\Models\Comment($this->data['comment_id']);



        $comment->getLikes()->doLike($user->getId());
        return $this->json(['RC'=>200,'count'=>$comment->getLikes('count')]);
    }

    public function dislikeComment()
    {
        if (!$user = $this->authorized()) {
            return $this->forbiddenResponse();
        }

        if (!isset($this->data['comment_id'])) 
            return json_encode(["RC"=>400]);

        $comment = new \App\Models\Comment($this->data['comment_id']);

     

        $comment->getLikes()->removeLike($user->getId());
        return $this->json(['RC'=>200,'count'=>$comment->getLikes('count')]);

    }


   

}