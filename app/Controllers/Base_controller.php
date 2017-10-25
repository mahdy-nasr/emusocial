<?php
namespace App\Controllers;

abstract class  Base_controller extends \App\Base
{
    public $request;
    public $response;
    public $args;
  


    public function __construct($request,$response,$params)
    {
        parent::__construct();
     
        $this->request = $request;
        $this->response = $response;
        $this->args = $params;
    }
    
}