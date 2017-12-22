<?php
namespace App\Models;

class UserCollection extends \App\Base
{
    public $users = null;
   
    
    public function __construct()
    {
        parent::__construct();
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

    public function getUsers($ids)
    {
        if(empty($ids))
            return [];
        $data = $this->db->read("SELECT user.*,department.name as department_name ,page.id as page_id from user left join department on user.department_id = department.id left join page on page.user_id = user.id where user.id IN ($ids)");
        $users = [];
        foreach ($data as $user_data) {
            $users[] = new User($user_data);
        }
        $this->users = $users;
        return $this->users;
    }
}