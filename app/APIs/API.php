<?php
namespace App\APIs;

abstract class  API extends \App\Base
{
    public $request;
    public $response;
    public $args;
    public $data;
  


    public function __construct($request,$response,$params)
    {
        parent::__construct();
     
        $this->request = $request;
        $this->response = $response;
        $this->args = $params;
        $this->data = $this->request->getParsedBody();

    }

    public function authorized()
    {
        $user = new \App\Models\User();
        if (!isset($this->data['ACCESSTOKEN'])&&!isset($_SERVER['HTTP_ACCESSTOKEN'])&&!$user->isLoggedIn()) {
            return false;
        }
        if (!$user->isLoggedIn()) {
            $token = isset($this->data['ACCESSTOKEN'])  ? $this->data['ACCESSTOKEN'] : $_SERVER['HTTP_ACCESSTOKEN'];
            if ($user->authinticate($token))
                return $user;
            return false;
        }
        
        $user->isLoggedIn();
        return $user;
    }

    public function forbiddenResponse() 
    {
        $result = ['RC'=>403,'msg'=>"forbidden requist, this API require authintication!"];
        return $this->response->withJson($result, 200);
    }
    
}