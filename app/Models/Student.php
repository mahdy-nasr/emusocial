<?php
namespace App\Models;

class Student extends User
{
    public function __construct()
    {
        parent::__construct();
        $this->setUserType('student');  
    }

     public function getStudentsList()
    {
        $data = $this->db->read("select user.*, identification as student_number ,department.name as department from user left join department on department_id = department.id  where user.type = 2");
        return $data;
    }

    


    public function getStudentData($id) 
    {
        return $this->db->readOne("select *, identification as student_number from user where user.id = ?", [$id]);
    }
    public function addStudent($data)
    {
        foreach ($data as $key => &$value) {
            $value = trim($value);
        }

        if(!isset($data['student_number'])||!isset($data['password'])||strlen($data['student_number'])<5||strlen($data['password'])<3)
            return false;
         $res = $this->db->readOne("select * from user where identification = ?", [$data['student_number']]);
        
        if ($res)
            return false;


        $insert=[];
        $insert[]=isset($data['first_name'])?$data['first_name']:'';
        
        $insert[]=isset($data['last_name'])?$data['last_name']:'';
        $insert[]=isset($data['email'])?$data['email']:'';
        $salt = date("D,M,d,Y:G:i");
        $insert[] = md5($salt.$data['password']).':'.$salt;
        $insert[] = 2;
        $insert[]=isset($data['department_id'])?$data['department_id']:'';
        $insert[] = $data['student_number'];

        if ($this->db->write('insert into user (`first_name`, `last_name`, `email`, `password`,`type`,`department_id`,`identification`) values (?,?,?,?,?,?,?)',$insert)) {
            $insId = $this->db->last_id();
            //$this->db->write("insert into student (`student_number`,`user_id`) values (?,$insId)",[$data['student_number']]);
            $data['id'] = $insId;
            $this->createPage($data);
            return $insId;
        }
        return false;

    }

    public function editStudent($data)
    {
        foreach ($data as $key => &$value) {
            $value = trim($value);
        }
        
        if(!isset($data['student_number'])||strlen($data['student_number'])<5)
            return false;
         $res = $this->db->readOne("select * from user where identification = ?", [$data['student_number']]);
        
        if (!$res)
            return false;


        $update=[];
        $update[]=isset($data['first_name'])?$data['first_name']:'';
        
        $update[]=isset($data['last_name'])?$data['last_name']:'';
       
        $update[]=isset($data['department_id'])?$data['department_id']:'';

        if (isset($data['password'])&&!strlen($data['password'])>3) {
            $salt = date("D,M,d,Y:G:i");
            $password=md5($salt.$data['password']).':'.$salt;
            $this->db->write('UPDATE `user` SET `password` = '.$password.'where identification =\''.$data['student_number']."'"); 
        }

        $f1 = $this->db->write('UPDATE `user` SET `first_name` = ?,`last_name` = ?,`department_id` = ? where identification =\''.$data['student_number']."'",$update);
       
        return $f1;


    }


}