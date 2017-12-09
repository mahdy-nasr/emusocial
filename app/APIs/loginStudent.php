<?php
namespace App\APIs;

class loginStudent extends API
{
    private $data;
    public function __construct($request, $response, $params, $data)
    {
        $this->data = $data;
        parent::__construct($request, $response, $params);
    }

    public function run()
    {
        
        $student = new \App\Models\Student();
        $result = [];
        $token = $student->login($this->data['student_number'],$this->data['password']);
        if (!$token || !strlen($token)>10) {
            $result = ['RC'=> 400,"msg" => "The student number or password is incorrect!"];
            return $this->response->withJson($result, 200);
        } 
        $course = new \App\Models\Course();
        $courses = $course->getCoursesForStudent($student->getUserData()['id']);
        foreach ($courses as &$course) {
            # code...
            $course['instructor'] = json_decode($course['instructor'],1);
        }

        $result['RC'] = 200;
        $result['records'] = [ 'access_token'=> $token, 'profile' => $student->getUserData(), 'courses'=>$courses ];

        return $this->response->withJson($result, 200);
    }

}