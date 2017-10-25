<?php
namespace App\Models;

class User extends \App\Base
{
    private $cookieName = "user_token";
    public $data;
    public $id;
    public $type = null;
    const STUDENT_EMAIL = "@students.emu.edu.tr";
    
    public function __construct()
    {
        parent::__construct();
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
    public function getUserType() 
    {
        if ($this->type !== null) {
            return $this->type;
        }

        if ($this->data['type'] == 2) {
            $this->type = 'student';
        } else {
            $this->type = 'instructor';
        }

        return $this->type;
    }

    public function setUserType($str)
    {
        $this->type = $str;
    }

    public function login($email,$password)
    {
        $email = trim($email);
        if ($this->getUserType() == 'student') {
            $email.= constant('STUDENT_EMAIL');
        }

        if (strlen($password)<3||strlen($email)<6) {
            return false;
        }
 
        $res = $this->db->readOne("select * from user where email = ?", [$email]);
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
        
        return ($this->db->write('delete from token where user_id = '.$this->data['id']));

    }



}