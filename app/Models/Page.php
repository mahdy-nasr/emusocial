<?php
namespace App\Models;
// user transactions 
class Page extends \App\Base
{
    public $id;
    protected $data;
    const COURSE_TYPE = 1;
    const OTHER_TYPE = 2;
    public function __construct($page_id=null)
    {
        parent::__construct();
        $this->id = $page_id;
    }

    public function getId()
    {
        return $this->id;
    }
    public function checkValidity()
    {
        return  $this->db->readOne("SELECT id from page where id = ?",[$this->id]);
    }


    public function createUserPage($userData)
    {
    
        $this->db->write("insert into page (user_id) values({$userData['id']})");
        $this->id = $this->db->last_id();
        
        //$this->subscribeUser($userData['id']);
        $this->addAdminPage($userData['id']);
        

        return $this->id;
    }
    public function createCouresPage($course)
    {
        
        $this->db->write("insert into page (course_id) values({$course['id']})");
        $this->id = $this->db->last_id();

        $this->addAdminPage($course['instructors']);

        
        return $this->id;
    }
    public function setPage($id)
    {
        $this->id = $id;
    }
    private function subscribeUser($user_id, $instructor_id)
    {

        return $this->db->write("insert into page_user (page_id,user_id,instructor_id) values ({$this->id},{$user_id},{$instructor_id})");
    }

    public function getCoverPicture()
    {
        $coverPic = \App\Helpers\Config::get("picture/profile_cover");
        if(!empty($this->data['cover_picture'])) {
            $coverPic = $this->data['cover_picture'];
        }
        return $coverPic;
    }

    public function getUserPage($user_id)
    {

            $id = $user_id;
        $data =  $this->db->readOne("SELECT page.* from page where user_id = ?",[$id]);
        $this->id = $data['id'];
        $this->data = $data;
        return $this;
    }

    public function getPageCourse()
    {
        return $this->db->readOne("SELECT course_id from page where id = ?",[$this->id])['course_id'];

    }

    public function getOtherPages()
    {
        $res = $this->db->read("SELECT * from page join page_about on page.id = page_about.page_id where page.type = 3");
        return $res;
    }
    public function addAdminPage($user_id=null,$ident=null)
    {
        if($ident)
            $ident = trim($ident);
        if(is_array($user_id)){
            $values_str = str_repeat(",({$this->id},?)",count($user_id));
            $values_str = trim($values_str," ,");
            $this->db->write("insert into page_admin (page_id,user_id) values $values_str", $user_id);
            return ;
        }

        if (!$user_id)
            $user_id = $this->db->readOne("SELECT id from user where identification = ? or email = ?",[$ident,$ident])['id'];
        if (!$user_id)
            throw new Exception("Error Processing Request", 1);
            
        return $this->db->write("insert into page_admin (page_id,user_id) values ({$this->id},{$user_id})");

    }

    public function enrollUser($ident,$instructor)
    {
        $ident = trim($ident);
        $instructor = (int) $instructor;
        $res = $this->db->readOne("SELECT id from user where identification = ? or email = ?",[$ident,$ident]);
        if (!$res) {
            throw new Exception("Error Processing Request, no student with ($stdNo)", 1);
        }

        return $this->subscribeUser($res['id'],$instructor);
    }

    public function deEnrollUser($user_id)
    {
        $res = $this->db->readOne("SELECT id from user where id = ?",[$user_id]);
        if (!$res) {
            throw new Exception("Error Processing Request, no student with ($stdNo)", 1);
        }
        
        return $this->db->write("DELETE from page_user where user_id = ? and page_id = ?",[$user_id,$this->id]);
    }
    public function deEnrollAdmin($user_id)
    {
        
        $res = $this->db->readOne("SELECT id from user where id = ?",[$user_id]);
        if (!$res) {
            throw new Exception("Error Processing Request, no student with ($stdNo)", 1);
        }
        
        return $this->db->write("DELETE from page_admin where user_id = ? and page_id = ?",[$user_id,$this->id]);
    }

}