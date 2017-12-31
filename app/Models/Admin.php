<?php
namespace App\Models;

// cascade deletion of customer and its related items
// //         //    //  department and its related items
// //         //    //  courses 
// user transaction
// throw exceptoins in errors
// use translations 
// use tokens in forms 
//--------------------------------------

//login
//
//create a new admin users
//create a new student
//create a new instructor
//create new departament 
//create new coures page 
//create create a new page
//
//assign admin to the page 
//change page to read only 
//change password to any users
//chagne page profile photo
//chagne page cover photo
//change page data
//change user data
//
//add new announcment to department students
//add new announcment to deparmtnt instructor or boot
//add new announcment to univeristy
//add post in the admin pannel
//
//view all users
//view single user
//view all pages
//view single page 
//view all deparments
//view all courses
//view all running courses
//view all announcemnts 
//
//view system notifications
class Admin extends \App\Base
{

    private $cookieName = "admin_token";
    public $data;

    public function __construct()
    {
        parent::__construct();
    }

    public function isLoggedIn()
    {
        if ($this->Session::exists($this->cookieName)) {
            $this->data = $this->db->readOne("select * from admin where id = ".$this->Session::get($this->cookieName));
        

        } else if ($this->Cookie::exists($this->cookieName)) {
            $res = $this->db->readOne("select * from token where `token`.`token` = ?", [$this->Cookie::get($this->cookieName)]);
            $this->data = $this->db->readOne("select * from admin where id = {$res['admin_id']}");
            $this->Session::put($this->cookieName, (int)$res['user_id']);
        
        } else {
            return false;            
        }
        return true;
    }

    public function __get($name)
    {
        // get something
    }

    public function isSuper()
    {
        if ($this->data['permission'] == 1) {
            return true;
        }
        return false;
    }
    public function getAdminsList() 
    {
        //TODO check fro previliges in controller
        $data = $this->db->read('select admin.* , department.name as department from admin left join department on department_id = department.id');
       
        return $data;
    }

    

    
    public function login($email,$password)
    {
        $email = trim($email);
        if (strlen($password)<3||strlen($email)<6) {
            return false;
        }
 
        $res = $this->db->readOne("select * from admin where email = ?", [$email]);
        if (!count($res))
            return false;
        $correctPassword = explode(':',$res['password']);
        if (md5($correctPassword[1].$password)!= $correctPassword[0])
            return false;
        $this->data = $res;

        $token = md5($email.$res['id']);

        $this->db->write("delete from token where admin_id = ".$this->data['id']);
        if ($this->db->write("INSERT INTO `token` (`admin_id`, `token`) VALUES ({$res['id']},'$token')")) {
            $this->Session::put($this->cookieName,$res['id']);
            $this->Cookie::put($this->cookieName,$token,$this->Cookie::$month);
        }

        return true;

    }

    public function logout() 
    {
        if (!$this->isLoggedIn()) 
            return false;
        if ($this->Session::exists($this->cookieName))
            $this->Session::delete($this->cookieName);
        if ($this->Cookie::exists($this->cookieName))
            $this->Cookie::delete($this->cookieName);
        
        return $this->db->write('delete from token where user_id = '.$this->data['id']);

    }

    public function addAdmin($data)
    {
        if(!isset($data['email'])||!isset($data['password'])||strlen($data['email'])<5||strlen($data['password'])<3)
            return false;
         $res = $this->db->readOne("select * from admin where email = ?", [$data['email']]);
        
        if ($res)
            return false;


        $insert=[];
        $insert[]=isset($data['first_name'])?$data['first_name']:'';
        
        $insert[]=isset($data['last_name'])?$data['last_name']:'';
        $insert[]=$data['email'];
        $salt = date("D,M,d,Y:G:i");
        $insert[]=md5($salt.$data['password']).':'.$salt;
        $insert[]=isset($data['permission'])?$data['permission']:'';
        $insert[]=isset($data['department_id'])?$data['department_id']:'';
       

        if ($this->db->write('insert into admin values (null,?,?,?,?,?,?)',$insert))
            return $this->db->last_id();
        return false;

    }

    public function editAdmin($data)
    {
        if(!isset($data['email'])||strlen($data['email'])<5)
            return false;
         $res = $this->db->readOne("select * from admin where email = ?", [$data['email']]);
        
        if (!$res)
            return false;


        $insert=[];
        $update[]=isset($data['first_name'])?$data['first_name']:'';
        
        $update[]=isset($data['last_name'])?$data['last_name']:'';
       
        $update[]=isset($data['permission'])?$data['permission']:'';
        $update[]=isset($data['department_id'])?$data['department_id']:'';

        if (isset($data['password'])&&!strlen($data['password'])>3) {
            $salt = date("D-M-d-Y-G-i");
            $password=md5($salt.$data['password']).':'.$salt;
            $this->db->write('UPDATE `admin` SET `password` = '.$password.'where email =\''.$data['email']."'"); 
        }

        if ($this->db->write('UPDATE `admin` SET `first_name` = ?,`last_name` = ?,`permission` = ?,`department_id` = ? where email =\''.$data['email']."'",$update))
            return $this->db->last_id();

        return false;

    }

    public function getAdminData($id)
    {
        return $this->db->readOne("select * from admin where id = ?",[$id]);
    }


   

    //////////////////////////////////////////
    ///
    ///    courses
    ///
    //////////////////////////////////////////
   
    
   
    

   

    

}
