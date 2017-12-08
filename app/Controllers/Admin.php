<?php

namespace App\Controllers;

class Admin extends Base_controller
{
    public $admin;
    public $instructor;
    public $student;
    public $course;



    public function __construct($request,$response,$params)
    {
        parent::__construct($request,$response,$params);
        $this->admin = new \App\Models\Admin();
        $this->instructor =  new \App\Models\Instructor();
        $this->student = new \App\Models\Student();
        $this->user =  new \App\Models\User();
        $this->course = new \App\Models\Course();
    }

    public function index()
    {
      
        if($this->admin->isLoggedIn())
            echo $this->view->load('admin:blank');
        else
             return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/login');
        
    }

    public function adminsList()
    {
        if(!$this->admin->isLoggedIn()||!$this->admin->isSuper())
            return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/login');
        $data = [];
        $data['admins']  = $this->admin->getAdminsList();
        $data['departments']  = $this->course->getDepartmentsList();
        $admin = $this->request->getParam('admin');
        
        if($admin)
        {
            $data['admin']  = $this->admin->getAdminData((int)$admin);
        }

        
        echo $this->view->load('admin:admins_list',$data);
        
             
    }

    public function addAdmin()
    {
        $data = $this->request->getParsedBody();
        $this->admin->addAdmin($data);
        return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/adminsList');
    }
    public function editAdmin()
    {
        $data = $this->request->getParsedBody();

        $this->admin->editAdmin($data);

        return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/adminsList');    
    }


    /////////////////////////////////////////////////////////////////
    ///
    ///               Instructor
    ///
    ////////////////////////////////////////////////////////////////
    
    public function instructorsList()
    {
        if(!$this->admin->isLoggedIn()||!$this->admin->isSuper())
            return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/login');
        $data = [];
        $data['instructors']  = $this->instructor->getInstructorsList();
        $data['departments']  = $this->course->getDepartmentsList();
        if(isset($this->args[0]))
        {
            $data['instructor']  = $this->instructor->getInstructorData((int)$this->args[0]);
        }

        
        echo $this->view->load('admin:instructors_list',$data);
        
             
    }

    public function addInstructor()
    {
        $data = $this->request->getParsedBody();
        $this->instructor->addInstructor($data);
        return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/instructorsList');
    }
    public function editInstructor()
    {
        $data = $this->request->getParsedBody();

        $this->instructor->editInstructor($data);

        return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/instructorsList');    
    }

    public function deleteInstructor()
    {
        if(!$this->admin->isLoggedIn()||!$this->admin->isSuper()||!isset($this->args[0]))
            return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/login');
     
        $this->instructor->deleteUser((int)$this->args[0]);
        return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/instructorsList');
   
    }

    /////////////////////////////////////////////////////////////////
    ///
    ///               Students
    ///
    ////////////////////////////////////////////////////////////////
    public function deleteStudent()
    {
        if(!$this->admin->isLoggedIn()||!$this->admin->isSuper()||!isset($this->args[0]))
            return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/login');
     
        $this->student->deleteUser((int)$this->args[0]);
        return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/studentsList');
   
    }



    public function studentsList()
    {
        if(!$this->admin->isLoggedIn()||!$this->admin->isSuper())
            return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/login');
        $data = [];
        $data['students']  = $this->student->getStudentsList();
        $data['departments']  = $this->course->getDepartmentsList();
        if(isset($this->args[0]))
        {
            $data['student']  = $this->student->getStudentData((int)$this->args[0]);
        }

        
        echo $this->view->load('admin:students_list',$data);
        
             
    }

    public function addStudent()
    {
        $data = $this->request->getParsedBody();
        $this->student->addStudent($data);
        return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/studentsList');
    }
    public function editStudent()
    {
        $data = $this->request->getParsedBody();

        $this->student->editStudent($data);

        return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/studentsList');    
    }



    public function login()
    {
        $data = $this->request->getParsedBody();
        if($data)
        {
            if (!isset($data['email'])||!isset($data['password']))
                $error = "both must exist";
            else if($this->admin->login($data['email'],$data['password']))
            {
                return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin');
            }
        }
        if($this->admin->isLoggedIn())
            return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin');
        echo $this->view->load('login');
    }

    public function logout()
    {
        $this->admin->logout();
        return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/login'); 
    }

     /////////////////////////////////////////////////////////////////
    ///
    ///               Courses
    ///
    ////////////////////////////////////////////////////////////////
   
    public function addDepartment()
    {
        $data = $this->request->getParsedBody();
        if (isset($data['department_name']))
            $this->course->addDepartment($data['department_name']);

        return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/allCourses');
    }
    public function allCourses()
    {
        if(!$this->admin->isLoggedIn())
            return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/login');
        $data = [];
        $data['departments']  = $this->course->getDepartmentsList();
        $data['courses'] = $this->course->getCourses();
        $data['instructors']  = $this->instructor->getInstructorsList();

        if(isset($this->args[0]))
        {
            $data['course']  = $this->course->getCourse((int)$this->args[0]);
        }
        echo $this->view->load('admin:all_courses',$data);
    }

    public function addCourse()
    {

        $data = $this->request->getParsedBody();
        $this->course->addCourse($data);

        return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/allCourses');
    }
    public function editCourse()
    {
        $data = $this->request->getParsedBody();
        $this->course->editCourse($data);

        return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/allCourses');
    
    }
    public function deleteCourse()
    {
        if(!$this->admin->isLoggedIn()||!$this->admin->isSuper()||!isset($this->args[0]))
            return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/allCourses');
     
        $this->course->deleteCourse((int)$this->args[0]);
        return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/allCourses');
    }

    public function allCoursesPermission()
    {
        if(!$this->admin->isLoggedIn()||!$this->admin->isSuper())
            return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/allCourses');
        $data = $this->request->getParsedBody();
        $this->course->changeAllPermission($data);
        return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/allCourses');
    
    }
    public function coursePermission()
    {
        if(!$this->admin->isLoggedIn()||!$this->admin->isSuper()||!isset($this->args[0]))
            return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/allCourses');

        $this->course->changePermission((int)$this->args[0]);

        return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/allCourses');

    
    }

    public function deleteDepartment()
    {
        if(!$this->admin->isLoggedIn()||!$this->admin->isSuper()||!isset($this->args[0]))
            return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/allCourses');
     
        $this->course->deleteDepartment((int)$this->args[0]);
        return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/allCourses');
    }

    public function courseRegistration()
    {
        if(!$this->admin->isLoggedIn())
            return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/login');
        $data = [];
        $data['departments']  = $this->course->getDepartmentsList();
        $data['courses'] = $this->course->getCourses();
        if (isset($this->args[0]))
            $data['course']  = $this->course->getCourse((int)$this->args[0]);
        else
            $data['course'] = $this->course->getCourse((int)$data['courses'][0]['id']);
        $data['users'] = $this->user->getUsersCourse($data['course']['page_id']);
        $data['admins'] = $this->user->getAdminUsersCourse($data['course']['page_id']);
        echo $this->view->load('admin:course_registration',$data);

    }

    public function enrollUser()
    {
        if(!$this->admin->isLoggedIn())
            return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/login');
        $data = $this->request->getParsedBody();
        if(isset($data['identification'])&&isset($data['page_id'])) {
            $page =  new \App\Models\Page($data['page_id']);
            $page->enrollUser($data['identification'],$data['instructor']);

            return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/courseRegistration/'.$data['course_id']);
        }

        return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/courseRegistration');

    }

    public function removeUserCourse()
    {
        if(!$this->admin->isLoggedIn())
            return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/login');
        if (isset($this->args[0])&&isset($this->args[1])) {
            $page = new \App\Models\Page((int)$this->args[1]);
            $page->deEnrollUser((int)$this->args[0]);
            return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/courseRegistration/'.$page->getPageCourse());
        }

        return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/courseRegistration');

    }
    public function registerAdmin()
    {
        if(!$this->admin->isLoggedIn())
            return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/login');
        $data = $this->request->getParsedBody();
        if(isset($data['identification'])&&isset($data['page_id'])) {
            $page =  new \App\Models\Page($data['page_id']);
            $page->addAdminPage(null,$data['identification']);

            return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/courseRegistration/'.$data['course_id']);
        }

        return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/courseRegistration');

    }

    public function removeAdminCourse()
    {
         if(!$this->admin->isLoggedIn())
            return $this->redirect("/admin/login");
        if (isset($this->args[0])&&isset($this->args[1])) {
            $page = new \App\Models\Page((int)$this->args[1]);
            $page->deEnrollAdmin((int)$this->args[0]);
            return $this->redirect('/admin/courseRegistration/'.$page->getPageCourse());
        }

        return $this->redirect('/admin/courseRegistration');


    }

    public function otherPages()
    {
        if(!$this->admin->isLoggedIn())
            return $this->redirect("/admin/login");
        $page =  new \App\Models\Page();

        $data = [];
        $data['pages'] = $page->getOtherPages();

        return $this->view->load("admin:other_pages",$data);
    }




    private function redirect($str)
    {
        return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').$str);

    }


   
}