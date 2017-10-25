<?php
namespace \App\Models;
class Student extends User
{
    public function __construct()
    {
        parent::__construct();
        $this->setUserType('student');  
    }

    public function loadData()
    {
        if (!$this->isLoggedIn())
            return false;
        
    }


}