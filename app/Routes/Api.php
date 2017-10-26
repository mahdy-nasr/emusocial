<?php
$app->get('/api/students', function ( $request,  $response,$arguments) {
	$arr = ['RC' => 200,'results' => ['id'=>1,'username'=>'elmahdy sharidy','student_number'=>'146932']];
	return $response->withJson($arr,200);

});