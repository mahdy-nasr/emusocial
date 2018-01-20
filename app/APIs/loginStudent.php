<?php
namespace App\APIs;

class loginStudent extends API
{
    public function __construct($request, $response, $params)
    {
        parent::__construct($request, $response, $params);
    }

    public function runPost()
    {
        
        $student = new \App\Models\Student();
        $result = [];
        $token = $student->login($this->data['student_number'],$this->data['password']);
        if (!$token || !strlen($token)>10) {
            $result = ['RC'=> 400,"msg" => "The student number or password is incorrect!"];
            return $this->response->withJson($result, 200);
        } 
        $course = new \App\Models\Course_Collection();
        $courses = $course->getCoursesForStudent($student->getUserData()['id']);
        

        $result['RC'] = 200;
        $result['records'] = [ 'access_token'=> $token, 'profile' => $student->getUserData(), 'courses'=>$courses ];

        return $this->response->withJson($result, 200);
    }


    public function saveToken()
    {
        if (!$user = $this->authorized()) {
            return $this->forbiddenResponse();
        }

        if (!isset($this->data['firebase_token']))
            return $this->json(['RC'=>400,'msg'=>'No firebase_token']);

        $user->addNotificationToken($this->data['firebase_token']);

        return $this->json(['RC'=>200]);die;
    }

}