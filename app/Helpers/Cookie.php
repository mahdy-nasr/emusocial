<?php
namespace App\Helpers;

class Cookie
{
	public static $year = 31104000;
	public static $month = 2592000;
	public static $day = 86400;

	public static function exists($name)
	{
		return (isset($_COOKIE[$name]))?true:false;
	}
	
	public static function get($name)
	{
		return $_COOKIE[$name];
	}
	
	public static function put($name,$value,$expiry)
	{
		if(setcookie($name,$value,time()+$expiry,'/'))
			return true;
		return false;
	}
	
	public static function delete($name)
	{
		self::put($name, '', time()-1);
	}
}