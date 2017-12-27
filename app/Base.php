<?php
namespace App;

abstract  class Base
{
	protected $Config;
	protected $db;
	protected $Session;
	protected $Cookie;
	protected $view;
	public function __construct() 
	{
		$this->Config = new Helpers\Config;
		$this->Session = new Helpers\Session;
		$this->Cookie = new Helpers\Cookie;
		$this->db = Helpers\DB::getInstance();
		$this->view = new Helpers\View();
	}
	private function from_camel_case($input) 
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret =  $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }

        return implode('_', $ret);
    }

	public function __call($name, $args) 
    {
        $method = substr($name,0,3);
        if (!in_array($method, ['get','set']))
            return false;

        $key = $this->from_camel_case(substr($name,3));
     
        if (!isset($this->data[$key]))
            return NULL;
        if (count($args)) {
            $res = $this->data[$key];
         
		        foreach ($args as $key) {
                    if (is_array($res)) 
		                $res = $res[$key];
		            else {
                		$function = str_replace(" ","",ucwords(str_replace("_"," ",(string)$args[0]) ) );
                    
                		$full_method_name = $method.$function;
                       
                		unset($args[0]);


                		if(method_exists($res,$function)) {
                			return call_user_func_array([$res,$function], $args);

                			//$res = $res->$function($args);
                		} else {
                   
                			return  call_user_func_array([$res,$full_method_name], $args);
                            //var_dump($res);
                			//$res = $res->$full_method_name($args);
                		}
        	       }
               }

            return $res;
        }

        return $this->data[$key];
    }
}