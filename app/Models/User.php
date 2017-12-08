<?php
namespace App\Models;

class User extends \App\Base
{
    private $cookieName = "user_token";
    public $data;
    public $id;
    public $type = null;
    
    public function __construct()
    {
        parent::__construct();
        $this->setUserType();
    }

    public function isLoggedIn()
    {
        if ($this->Session::exists($this->cookieName)) {
            $this->id = (int) $this->Session::get($this->cookieName);
            return true;
        } else if ($this->Cookie::exists($this->cookieName)) {
            $res = $this->db->readOne("select * from token where `token`.`token` = ?", [$this->Cookie::get($this->cookieName)]);
            $this->Session::put($this->cookieName, (int)$res['user_id']);
            $this->id = (int)$res['user_id'];
            return true;
        
        } else {
            return false;            
        }
    }

    public function getUserData()
    {
        return $this->data;
    }
    public function getUserType() 
    {
        if ($this->type !== null) {
            return $this->type;
        }

        if ($this->data['type'] == 2) {
            $this->type = 'student';
        } else if ($this->data['type'] == 1) {
            $this->type = 'instructor';
        } else {
            $this->type = 'other';
        }

        return $this->type;
    }

    public function setUserType($str="student")
    {
        $this->type = $str;
    }

    public function login($email,$password)
    {
        $email = trim($email);
        if (strlen($password)<3||strlen($email)<6) {
            return false;
        }

        if ($this->getUserType() == 'student') {
            $res = $this->db->readOne("select * from user where identification = ?", [$email]);
        } else {
            $res = $this->db->readOne("select * from user where email = ?", [$email]);
        }

        
 
      
        if (!count($res))
            return false;
        $correctPassword = explode(':',$res['password']);
        if (md5($correctPassword[1].$password)!= $correctPassword[0])
            return false;
        $this->data = $res;
        $token = md5($email.$res['id']);
        if ($this->db->db->query("INSERT INTO `token` (`user_id`, `token`) VALUES ({$res['id']},'$token')")) {
            $this->Session::put($this->cookieName,$res['id']);
            $this->Cookie::put($this->cookieName,$token,$this->Cookie::$month);
        }

        return $token;

    }

    public function createPage($data)
    {
        $page = new Page();
        $page_id = $page->createUserPage($data);

        return $this->db->write("UPDATE user SET page_id = $page_id WHERE id = {$data['id']}");

    }
    public function deleteUser($id) 
    {
        $this->db->write("delete from page where user_id = ? ",[$id]);
        $this->db->write("delete from user where id = ? ",[$id]);
    }

    public function logout() 
    {
        if (!$this->isLoggedIn()) 
            return false;
        if ($this->Session::exists($this->cookieName))
            $this->Session::delete($this->cookieName);
        if ($this->Cookie::exists($this->cookieName))
            $this->Cookie::delete($this->cookieName);
        
        return ($this->db->write('delete from token where user_id = '.$this->data['id']));

    }

    public function getUsersCourse($id)
    {
        $res = $this->db->read("select user_id from page_user where page_id = ?",[$id]);
        $stdIds = "";
        foreach ($res as $key => $value) {
            $stdIds.= ", ".$value['user_id'];
        }
       
        
        $stdIds = trim($stdIds,',');

        if (!empty($stdIds))

            $data = $this->db->read("select user.*, identification as student_number ,department.name as department from user left join department on department_id = department.id  where user.id IN ($stdIds)");
        else
            $data = [];


     
        return $data;
    }

    public function getAdminUsersCourse($id) {
        $res = $this->db->read("select user_id from page_admin where page_id = ?",[$id]);
        $stdIds = "";
        foreach ($res as $key => $value) {
            $stdIds.= ", ".$value['user_id'];
        }
       
        
        $stdIds = trim($stdIds,',');

        if (!empty($stdIds))
            $data = $this->db->read("select user.*, identification as student_number ,department.name as department from user left join department on department_id = department.id  where user.id IN ($stdIds)");
        else
            $data = [];

     
        return $data;
    }


}