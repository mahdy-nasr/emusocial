<?php
namespace App\Models;

class User extends \App\Base
{
    private $cookieName = "user_token";
    public $data = null;
    public $id = null;
    public $type = null;
    
    public function __construct($data_or_id = null)
    {
        parent::__construct();
        $this->setUserType('student');

        if (is_array($data_or_id)) {
            $this->data = $data_or_id;
            $this->id = $data_or_id['id'];
        } else if ($data_or_id) {
            $this->id = $data_or_id;
            $this->loadUser();
        } else {
            $this->isLoggedIn();
        }
    }

    public function getBroadcats()
    {
        $broad = new Broadcast();
        $res = $broad->getUserBroadcast($this->id);
        $broad->ackUserBroadcast($this->id);
        return $res;
    }
    public function getProfilePicture()
    {
        $tmp = "img/Profile/".$this->data['gender']."-avatar.png";
        if (!empty($this->data['profile_picture']))
            $tmp = $this->data['profile_picture'];
        return $tmp;
    }

    public function getName()
    {
        return $this->data['first_name'].' '.$this->data['last_name'];
    }

    public function getFullName()
    {
        return $this->data['title'].' '.$this->getName();
    }
    public function isLoggedIn()
    {
        if ($this->Session::exists($this->cookieName)) {
            $this->id = (int) $this->Session::get($this->cookieName);
            $this->loadUser();
            return true;
        } else if ($this->Cookie::exists($this->cookieName)) {
            $res = $this->db->readOne("select * from token where `token`.`token` = ?", [$this->Cookie::get($this->cookieName)]);
            $this->Session::put($this->cookieName, (int)$res['user_id']);
            $this->id = (int)$res['user_id'];
            $this->loadUser();
            return true;
        
        } else {
            return false;            
        }
    }

    public function getId()
    {
        return $this->id;
    }

   

    private function loadUser()
    {
       if ($this->data != null || !$this->id)
        return $this;

        $this->data = $this->db->readOne("SELECT user.*,department.name as department_name,page.id as page_id from user left join department on user.department_id = department.id left join page on user.id = page.user_id where user.id = {$this->id}");
        return $this;
    }
    public function getUserData()
    {
      
        $this->loadUser();
        return $this->data;
    }
    public function getUserType() 
    {
        if ($this->data == null) {
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

    public function authinticate($access_token) 
    {
        if(empty($access_token))
            return false;
        $res = $this->db->readOne("select * from token where `token`.`token` = ?", [$access_token]);
        if (!$res)
            return false;

        $this->id = (int)$res['user_id'];
        $this->loadUser();
        return true;

    }
    public function login($email,$password)
    {
        $email = trim($email);
        if (strlen($password)<3||strlen($email)<6) {
            return false;
        }

    
        $res = $this->db->readOne("select * from user where identification = ? or email = ?", [$email,$email]);
        $this->getUserType();

        
 
      
        if (!count($res))
            return false;
        $correctPassword = explode(':',$res['password']);
        if (md5($correctPassword[1].$password)!= $correctPassword[0])
            return false;
        $this->id = $res['id'];
        $this->loadUser();
        $token = md5($email.$res['id']);
        $this->db->write("delete from token where user_id = ".$this->id);
        if ($this->db->write("INSERT INTO `token` (`user_id`, `token`) VALUES ({$res['id']},'$token')")) {
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

  


}