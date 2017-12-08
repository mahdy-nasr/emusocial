<?php
namespace App\Helpers;

class DB
{
	//sql scable string but he said it is ready
	//more functionnality in get and set
	//make new version of insert with values only
	//also with update
	public static $instance=null;
	public $db;
	private $hasTransaction = 0;
	private function __construct()
	{
		try
		{
			$this->db=new \PDO('mysql:host='.Config::get('database/mysql/host').';dbname='.Config::get('database/mysql/db'),Config::get('database/mysql/username'),Config::get('database/mysql/password'));
			$this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e)
		{
			die($e->getMessage());
		}
	}
	
	public static function getInstance()
	{
		if(!isset(self::$_instance))
		{
			self::$instance=new DB();
			return self::$instance;
			
		}
		return self::$instance;
	}

	public function startTransaction()
	{
		$this->hasTransaction = 1;
		$this->db->beginTransaction();
	}
	public function endTransaction()
	{
		$this->db->rollBack();
	}
	public function write($sql,$param = null) 
	{
		$statement = $this->db->prepare( $sql);
		return $statement->execute($param);
	}

	public function read($query,$param = null)
	{
		$statement = $this->db->prepare($query);
		$statement->execute($param);
		return $statement->fetchAll(\PDO::FETCH_ASSOC);
	}
	
	public function readOne($query,$param = null)
	{
		$statement = $this->db->prepare( $query);
		$statement->execute($param);
		return $statement->fetch(\PDO::FETCH_ASSOC);
	}

	public function last_id()
    {
        return $this->db->lastInsertId();
    }
}