<?php
namespace App\Helpers;
class validate
{
	private $_passed = false,
			$_errors = array(),
			$_db=null;
	
	private function add_error($error)
	{
		$this->_errors[]=$error;
	}
	private function clean($input)
	{
		if(is_string($input))
		{
			return trim($input);
		}
		return $input;
	}
	
	public function __construct()
	{
		$this->_db=DB::getInstance();
	}
	public function passed()
	{
		return $this->_passed;
	}
	public function check($source,$items=array())
	{
		foreach($items as $item => $rules)
		{
			foreach($rules as $rule => $rule_value)
			{
				$item=escape($item);
				$value= $this->clean($source[$item]);
				 
				if($rule=='required' && empty($value))
				{
					$this->add_error("{$item} is required");
					continue;
				}
				else if (empty($value))
					continue;
				
				switch ($rule)
				{
					case 'min' :
						if(is_string($value)&& strlen($value)<$rule_value)
							$this->add_error("{$item} must be minimum of {$rule_value} characters.");
						else if((!is_string($value))&&$value<$rule_value)
							$this->add_error("{$item} must be minimum of {$rule_value}.");
						break;
					case 'max' :
						if(is_string($value)&&strlen($value)>$rule_value)
							$this->add_error("{$item} must be maximum of {$rule_value} characters.");
						else if($value>$rule_value)
							$this->add_error("{$item} must be maximum of {$rule_value}.");
						break;
					case 'matches' :
						if($value != $source[$rule_value] )
							$this->add_error("{$rule_value} must match {$item}");
						break;
					case 'unique' :
						$table=explode(';', $rule_value);
						$field=$table[1];
						$table=$table[0];
					//	die($value);
						$ch=$this->_db->get($table, array($field,'=',$value));
						
						if($ch->count())
							$this->add_error("{$item} already exists!");
						break;
				}
			
			}
		}
		if(empty($this->_errors))
			$this->_passed=true;
		
		
		return $this;
	}
	public function errors()
	{
		return $this->_errors;
	}
}