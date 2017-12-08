<?php
namespace App\Models;

class Instructor extends User
{
    
    public function __construct()
    {
        parent::__construct();
        $this->setUserType('Instructor');  

    }

     public function getInstructorsList()
    {
        $data = $this->db->read("select user.* , department.name as department from user left join department on department_id = department.id  where (user.type = 1 or user.type = 3) ORDER BY type ");

        return $data;
    }


    public function getInstructorData($id) 
    {
        return $this->db->readOne("select * from user where user.id = ?", [$id]);
    }
    public function addInstructor($data)
    {
        foreach ($data as $key => &$value) {
            $value = trim($value);
        }
        if(!isset($data['email'])||!isset($data['password'])||strlen($data['email'])<5||strlen($data['password'])<3)
            return false;
         $res = $this->db->readOne("select * from user where email = ?", [$data['email']]);
        
        if ($res)
            return false;


        $insert=[];
        $insert[]=isset($data['title'])?$data['title']:'';
        $insert[]=isset($data['first_name'])?$data['first_name']:'';
        
        $insert[]=isset($data['last_name'])?$data['last_name']:'';
        $insert[]=$data['email'];
        $salt = date("D,M,d,Y:G:i");
        $insert[] = md5($salt.$data['password']).':'.$salt; // password
        $insert[] = isset($data['account'])? 1:3;
     
        $insert[]=isset($data['department_id'])?$data['department_id']:'';
       

        if ($this->db->write('insert into user (`title`,`first_name`, `last_name`, `email`, `password`,`type`,`department_id`)values (?,?,?,?,?,?,?)',$insert)) {
            $insId = $this->db->last_id();
            //$this->db->write("insert into instructor values (null,'','',$insId)");
            $data['id'] = $insId;
            $this->createPage($data);
            return $insId;
        }
        return false;

    }

    public function editInstructor($data)
    {
        foreach ($data as $key => &$value) {
            $value = trim($value);
        }
        if(!isset($data['email'])||strlen($data['email'])<5)
            return false;
         $res = $this->db->readOne("select * from user where email = ?", [$data['email']]);
        
        if (!$res)
            return false;
      

        $update=[];
        
        $update[] = isset($data['title'])?$data['title']:'';

        $update[] = isset($data['first_name'])?$data['first_name']:'';
        
        $update[] = isset($data['last_name'])?$data['last_name']:'';
       
        $update[] = isset($data['department_id'])?$data['department_id']:'';
        
        $update[] = isset($data['account'])? 1:3;

        if (isset($data['password'])&&!strlen($data['password'])>3) {
            $salt = date("D,M,d,Y:G:i");
            $password=md5($salt.$data['password']).':'.$salt;
            $this->db->write('UPDATE `user` SET `password` = '.$password.'where email =\''.$data['email']."'"); 
        }

        if ($this->db->write('UPDATE `user` SET `title` = ? ,`first_name` = ?,`last_name` = ?,`department_id` = ? ,`type` = ? where email =\''.$data['email']."'",$update))
            return $this->db->last_id();

        return false;

    }
}