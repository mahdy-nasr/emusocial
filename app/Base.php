<?php
namespace App;

abstract  class Base
{
	public $Config;
	public $db;
	public $Session;
	public $Cookie;
	public $view;
	public function __construct() 
	{
		$this->Config = new Helpers\Config;
		$this->Session = new Helpers\Session;
		$this->Cookie = new Helpers\Cookie;
		$this->db = Helpers\DB::getInstance();
		$this->view = new Helpers\View();
	}
}