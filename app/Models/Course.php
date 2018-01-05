<?php
namespace App\Models;

class Course extends \App\Base implements \JsonSerializable
{
    private     $id;
    protected   $data;
    private     $page_id;

    public function __construct($id = null)
    {
        parent::__construct();
        if ($id && is_numeric($id)) { 
            $this->load($id);

        } else if ($id && ($id instanceof Page)) {
            $this->page_id = $id->getId();
            $this->id = $id->getPageCourse();
            $this->load();
        }


    }

    public function jsonSerialize()
    {
        return $this->data;
    }

    public function load($id=null)
    {
        if ($id)
            $this->id = $id;
        else if (!$this->id)
            return false;

        if(!$this->loadData()) {
            return false;
        }

        $this->setPageId();

        $this->loadInstructor();
        $this->loadStudents();
        $this->loadAdmins();
        $this->loadEvents();
        $this->loadNumbers();
        return $this;

    }

    private function setPageId()
    {
        if (!$this->page_id) {
            $this->page_id = $this->db->readOne("SELECT id from page where course_id = {$this->id}")['id'];
        }
        $this->data['page_id'] = $this->page_id;
    }

    private function loadData()
    {
        $res = $this->db->readOne("SELECT course.*, department.name as department_name from course left join department on course.department_id = department.id where course.id = ?",[$this->id]);
        if (!$res) {
            return false;
        }
        $this->data = $res;
        return true;
    }

    private function loadStudents()
    {
        $res = $this->db->read("SELECT user.* , instructor_id from page_user left join user on user.id = page_user.user_id where page_user.page_id = {$this->page_id}");
        $users = [];
        foreach ($res as $row) {
            $users[$row['id']] = new User($row);
        }

        $this->data['students'] = $users;
    }

    private function loadInstructor()
    {
        $res = $this->db->read("SELECT user.* FROM `page_user` LEFT JOIN user on user.id = page_user.instructor_id where page_user.page_id = {$this->page_id} GROUP BY instructor_id");
        $users = [];
        foreach ($res as $row) {
            $users[$row['id']] = new User($row);
        }

        $this->data['instructors'] = $users;
    }

    private function loadAdmins()
    {
        $res = $this->db->read("SELECT user.* FROM `page_admin` LEFT JOIN user on user.id = page_admin.user_id where page_admin.page_id = {$this->page_id}");
        $users = [];
        foreach ($res as $row) {
            $users[] = new User($row);
        }

        $this->data['Admins'] = $users;
    }

    private function loadEvents()
    {
        $events = new EventCollection();
        $this->data['events'] = $events->getCoursePageEvents($this->page_id);
    }

    private function loadNumbers()
    {
       $posts = new PostCollection($this->page_id);
        $this->data['numbers'] = [];
        $this->data['numbers']['posts'] = $posts->getPostsCount();

        $this->data['numbers']['files'] = $posts->getFilesCount();
        

    }



    

}