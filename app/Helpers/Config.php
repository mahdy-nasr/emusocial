<?php
namespace App\Helpers;


class Config {
	
	public static function get($path=null)
	{
		if($path)
		{
			global $settings;
			$config = $settings;
			$path= explode('/',$path);
			foreach ($path as $bit)
			{
				if(isset($config[$bit]))
				{
					$config=$config[$bit];
				}
			}
			return $config;
		}
		return false;
	}
}