<?php
$app->get('/api/students', function ( $request,  $response,$arguments) {
	$arr = ['RC' => 200,'results' => ['id'=>1,'username'=>'elmahdy sharidy','student_number'=>'146932']];
	return $response->withJson($arr,200);

});

$app->post('/api/student/login', function ( $request,  $response,$arguments) {
	$data = $this->request->getParsedBody();
	$student = new App\Models\Student();
	$token = $student->login($data['student_number'],$data['password']);
	if($token && strlen($token)>10) {
		$res = [
			'RC' => 200,
			'token' => $token,
			'data' => $student->getUserData()
		];
	} else {
		$res = ['RC' => 404];
	}

	return $response->withJson($arr,200);

});