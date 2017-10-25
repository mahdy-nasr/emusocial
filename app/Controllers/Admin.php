<?php

namespace App\Controllers;

class Admin extends Base_controller
{
    public $admin;



    public function __construct($request,$response,$params)
    {
        parent::__construct($request,$response,$params);
        $this->admin = new \App\Models\Admin();
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
        $data['departments']  = $this->admin->getDepartmentsList();
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

    public function instructorsList()
    {
        if(!$this->admin->isLoggedIn()||!$this->admin->isSuper())
            return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/login');
        $data = [];
        $data['instructors']  = $this->admin->getInstructorsList();
        $data['departments']  = $this->admin->getDepartmentsList();
        if(isset($this->args[0]))
        {
            $data['instructor']  = $this->admin->getInstructorData((int)$this->args[0]);
        }

        
        echo $this->view->load('admin:instructors_list',$data);
        
             
    }

    public function addInstructor()
    {
        $data = $this->request->getParsedBody();
        $this->admin->addInstructor($data);
        return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/instructorsList');
    }
    public function editInstructor()
    {
        $data = $this->request->getParsedBody();

        $this->admin->editInstructor($data);

        return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/instructorsList');    
    }



    public function studentsList()
    {
        if(!$this->admin->isLoggedIn()||!$this->admin->isSuper())
            return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/login');
        $data = [];
        $data['students']  = $this->admin->getStudentsList();
        $data['departments']  = $this->admin->getDepartmentsList();
        if(isset($this->args[0]))
        {
            $data['student']  = $this->admin->getStudentData((int)$this->args[0]);
        }

        
        echo $this->view->load('admin:students_list',$data);
        
             
    }

    public function addStudent()
    {
        $data = $this->request->getParsedBody();
        $this->admin->addStudent($data);
        return $this->response->withStatus(302)->withHeader('Location', $this->Config::get('base/url').'/admin/studentsList');
    }
    public function editStudent()
    {
        $data = $this->request->getParsedBody();

        $this->admin->editStudent($data);

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

   
}