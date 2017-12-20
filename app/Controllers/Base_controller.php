<?php
namespace App\Controllers;

abstract class  Base_controller extends \App\Base
{
    public $request;
    public $response;
    public $args;
    public $post_data;
  


    public function __construct($request,$response,$params)
    {
        parent::__construct();
     
        $this->request = $request;
        $this->response = $response;
        $this->args = $params;
        $this->post_data = $this->request->getParsedBody();

    }

    protected function redirect($str)
    {
        return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').$str);

    }


}