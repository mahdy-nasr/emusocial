<?php
namespace App\Models;

class Course extends \App\Base
{
    
    public function __construct()
    {
        parent::__construct();
    }

    public function addDepartment($name) 
    {
        if (empty($name))
            throw new Exception("Error Processing Request, \$name is empty", 1);
        $this->db->write("insert into deparment (name) values ($name)");
            
    }
    public function getCourses()
    {
        $res = $this->db->read("SELECT course.*, department.name as department from course left join department on course.department_id = department.id order by year DESC,semester DESC,department ASC");
        $instructors  = $this->db->read("SELECT course_group.course_id as course_id, CONCAT(user.first_name,' ',user.last_name) as name, user.id as id from course_group left join user on user.id = course_group.instructor_id");
        foreach ($res as &$key) {
            $key['instructors'] = [];
            foreach ($instructors as $inst) {
                if ($inst['course_id'] == $key['id'])
                    $key['instructors'] [] = $inst;
            }
        }

        return $res;
    }

    public function getCoursesForStudent($id)
    {
        $instructor_select = "CONCAT( '{',JSON_STR('first_name',user.first_name),',',JSON_STR('last_name',user.last_name),',',JSON_INT('id',user.id),'}' )";
  
        $res = $this->db->read("SELECT course.*, department.name as department, page.id as page_id, 
            $instructor_select as instructor, course_group.id as group_id from page_user left join page on page_user.page_id = page.id left join course on page.course_id = course.id left join course_group on course_group.course_id = course.id left join user on course_group.instructor_id = user.id left join department on course.department_id = department.id where page_user.user_id = $id");
        

        return $res;
    }

    public function getCourse($id)
    {
    	$res = $this->db->readOne("SELECT course.*, page.id as page_id from course left join page on page.course_id = course.id where course.id = ? ",[$id]);
        $instructors  = $this->db->read("SELECT course_group.id as group_id, CONCAT(user.first_name,' ',user.last_name) as name, user.id as id from course_group left join user on user.id = course_group.instructor_id where course_id = ?",[$id]);
        $res['instructors'] = $instructors;

        return $res;
    }

    public function addCourse($data)
    {
       
        if(!isset($data['code'])||!isset($data['name'])||!isset($data['semester'])||!isset($data['year'])||!isset($data['department_id']))
        	throw new \Exception("Error Processing Request in addCourse The values not setted", 1);
        if(empty($data['code'])||empty($data['name'])||empty($data['semester'])||empty($data['year'])||empty($data['department_id']))
        	throw new \Exception("Error Processing Request in addCourse The values is embty", 1);


        $insert=[];
        $insert[]=$data['name'];
        $insert[]=$data['code'];
        $insert[]=$data['semester'];
        $insert[]=$data['year'];
        $insert[]=$data['department_id'];

        // create a page to the course
        
        $this->db->write('insert into course (`name`, `code`, `semester`, `year`,`department_id`) values (?,?,?,?,?)',$insert);
        $data['id'] = $this->db->last_id();

        $values_str = str_repeat(",({$data['id']},?)",count($data['instructors']));
        $values_str = trim($values_str," ,");
       
        $this->db->write("insert into course_group (course_id,instructor_id) values $values_str",$data['instructors']);


        $page = new Page();
        $page_id = $page->createCouresPage($data);
        return;
    }

    public function editCourse($data)
    {
    	if(!isset($data['id'])||empty($data['id']))
    		throw new Exception("Error Processing Request of edit course", 1);
    	$res = $this->db->readOne("select * from course where id = ?", [$data['id']]);
        
        if (!$res)
            throw new Exception("Error Processing Request of edit course", 1);

        $values = "";
        $query = "";

        $update = [];
        if(isset($data['name']))
         	$update[]=$data['name'];

        $query.= isset($data['name'])?',name = ?':'';

        if(isset($data['code']))
         	$update[]=$data['code'];
        
        $query.= isset($data['code'])?' , code = ?':'';

        if(isset($data['year']))
        	$update[]=$data['year'];
        $query.= isset($data['year'])?' , year = ?':'';

        if(isset($data['semester']))
         	$update[]=$data['semester'];
        $query.= isset($data['semester'])?' , semester = ?':'';

        if(isset($data['department_id']))
         	$update[]=$data['department_id'];
        $query.= isset($data['department_id'])?' , department_id = ?':'';
        $update[] = $data['id'];
        
        

        $query = trim($query,",");

        return $this->db->write("UPDATE course SET $query WHERE id = ?",$update);

            
    }

    public function deleteCourse($id)
    {
        $this->db->write("delete from page where course_id = ?",[$id]);
        return $this->db->write("delete from course where id = ?",[$id]);
    }

    public function deleteDepartment($id)
    {
        $this->db->startTransaction();
        $this->db->write('delete from course where department_id = ?',[$id]);
        $this->db->write("delete from department where id = ?",[$id]);
        return $this->db->endTransaction();
        
    }

    public function getDepartmentsList()
    {
        return $this->db->read('select * from department');
    }

    public function changeAllPermission($data)
    {
    	$whereArray = [$data['semester'],$data['year']];

    	if ($data['action'] == "readonly") {
    		return $this->db->write("UPDATE course set readonly = 1 where semester = ? and year = ?",$whereArray);
    	} else {
    		return $this->db->write("UPDATE course set readonly = 0 where semester = ? and year = ?",$whereArray);

    	}
    }
    public function changePermission($id)
    {
    	$res = $this->db->readOne("select * from course where id = ?", [$id]);
    	if (!$res)
    		throw new \Exception("Error Processing Request", 1);
    	if ($res['readonly'] == 0) {
    		return $this->db->write("UPDATE course set readonly = 1 where id = ? ",[$id]);

    	} else {
    		return $this->db->write("UPDATE course set readonly = 0 where id = ? ",[$id]);

    	}
    		

	
    }

    
    	
}