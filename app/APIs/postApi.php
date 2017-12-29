<?php
namespace App\APIs;

class postApi extends API
{
    public function __construct($request, $response, $params)
    {
        parent::__construct($request, $response, $params);
    }

    public function createProfile()
    {

        if (!$user = $this->authorized()) {
            return $this->forbiddenResponse();
        }

        $post = new \App\Models\Post();
        $post->setUserAndPage($user->getId(), $user->getPageId());
        if (!$id=$post->createPost($this->data)) {
            $result = ['RC' =>400 , 'msg' => 'problem adding post!'];
         return $this->response->withJson($result, 200);
        }

        $result = ['RC'=>200];
        $result['post'] = (new \App\Models\Post($id))->getData();
        return $this->response->withJson($result, 200);
    }

    public function getPost()
    {
        if (!$user = $this->authorized()) {
            return $this->forbiddenResponse();
        }

        $id = $this->request->getQueryParam('post_id');
        $post = new \App\Models\Post($id);
        $result = ['RC'=>200, 'post'=>$post->getData()];

        return $this->response->withJson($result, 200);
    }
    
    public function getProfilePosts()
    {
        if (!$user = $this->authorized()) {
            return $this->forbiddenResponse();
        }

        $start = $this->request->getQueryParam('start',0);
        $limit = $this->request->getQueryParam('limit',10);

        if ($this->request->getQueryParam('id')) 
            $profile = new \App\Models\User($this->request->getQueryParam('id'));
        else 
            $profile = $user;

         $page = new \App\Models\Page();
         $page->getUserPage($profile->getId());
         $posts_collection = new \App\Models\PostCollection($page->getId());
        
       
        $data = [];
        $data['posts'] = $posts_collection->getPagePosts($start, $limit);
        $data['profile'] = $profile;
        //$data['user'] = $user;
        $data['page'] = $page->getUserPage($profile->getId());
       // $data['type'] = 'profile';
        

        
        $data_r = ['RC'=>200,'records'=>$data];


        return $this->response->withJson($data_r, 200);
    }

    public function getPagePosts()
    {

    }

    public function deletePost()
    {
        if (!$user = $this->authorized()) {
            return $this->forbiddenResponse();
        }

        if (!isset($this->data['post_id'])) {
            return $this->response->withJson(['RC'=>400], 200);
        }

      

        $post = new \App\Models\Post();
        $post->deletePost($this->data['post_id'], $user->getId());

        return $this->response->withJson(['RC'=>200], 200);
    }

   

}