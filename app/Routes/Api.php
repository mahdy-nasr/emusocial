<?php
$app->get('/api/students', function ( $request,  $response,$arguments) {
    $arr = ['RC' => 200,'results' => ['id'=>1,'username'=>'elmahdy sharidy','student_number'=>'146932']];
    return $response->withJson($arr,200);

});

$app->post('/api/student/login[/]', function ( $request,  $response,$arguments) {

    return (new \App\APIs\loginStudent($request, $response, $arguments))->run();
});

$app->post('/api/upload/{type}[/]', function ($request, $response, $arguments) {

    return (new \App\APIs\uploadApi($request, $response, $arguments))->run();

});