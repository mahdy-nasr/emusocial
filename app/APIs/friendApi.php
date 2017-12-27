<?php
namespace App\APIs;

class friendApi extends API
{
    public function __construct($request, $response, $params)
    {
        parent::__construct($request, $response, $params);
    }

    public function addFriend()
    {

        if (!$user = $this->authorized()) {
            return $this->forbiddenResponse();
        }

        if (!($id = $this->request->getQueryParam('id'))) 
            return $this->response->withJson(['RC'=>400], 200);

        $friend = new \App\Models\Friend($user->getId());
        $friend->makeFriendRequist($id);
        return  $this->response->withJson(['RC'=>200], 200);
    }

    public function removeFriend()
    {
    	if (!$user = $this->authorized()) {
            return $this->forbiddenResponse();
        }

        if (!($id = $this->request->getQueryParam('id'))) 
            return $this->response->withJson(['RC'=>400], 200);

        $friend = new \App\Models\Friend($user->getId());
        $friend->removeFriendRequist($id);
        return $this->response->withJson(['RC'=>200], 200);
    }
    
    public function acceptFriend()
    {
    	if (!$user = $this->authorized()) {
            return $this->forbiddenResponse();
        }

        if (!($id = $this->request->getQueryParam('id'))) 
            return $this->response->withJson(['RC'=>400], 200);

        $friend = new \App\Models\Friend($user->getId());
        $friend->acceptFriendRequist($id);
        return $this->response->withJson(['RC'=>200], 200);
    }

    public function getUserStatus()
    {

    }

    public function getFriends()
    {

    }

    public function getFriendRequests() 
    {

    }

 
}