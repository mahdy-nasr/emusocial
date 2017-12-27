<?php
//'route' => 'method;class;function',
$routes = 
[
    '/student/login' => 'post;loginStudent;runPost',

    '/upload/{type}' => 'post;uploadApi;runPost',
    
    ///////////////////////////////////////////////////////////////////////////////

    '/createProfilePost' => 'post;postApi;createProfile',

    '/profileTimeline' => 'get;postApi;getProfilePosts',

    '/deletePost' => 'post;postApi;deletePost',

    ///////////////////////////////////////////////////////////////////////////////
    
    '/submitComment' => 'post;commentApi;createComment',

    '/deleteComment' => 'post;commentApi;deleteComment',

    '/getComments' => 'get;commentApi;getComments',

    ///////////////////////////////////////////////////////////////////////////////

    '/likePost' => 'post;likeApi;likePost',

    '/dislikePost' => 'post;likeApi;dislikePost',

    '/likeComment' => 'post;likeApi;likeComment',

    '/dislikeComment' => 'post;likeApi;dislikeComment'
];



////////////////////////////////////////////////////////////////////////////////
///
////////////////////////////////////////////////////////////////////////////////





















$app->get('/api/dummy', function ( $request,  $response,$arguments) {
    $arr = ['RC' => 200,'results' => ['id'=>1,'username'=>'elmahdy sharidy','student_number'=>'146932']];
    return $response->withJson($arr,200);

});


foreach ($routes as $route => $det) {
    $details = explode(';',$det);

    $route = "/api".$route.'[/]';
    $method = $details[0];
    $class_name = '\App\APIs\\'.$details[1];
    $function_name = $details[2];
    // var_dump($class_name);die;

    if ($method == 'get') {
        $app->get($route, function ($request, $response, $arguments) use ($class_name, $function_name) {
            $class = new $class_name($request,$response,$arguments);
            return $class->$function_name();
        });

    } else {
        $app->post($route, function ($request, $response, $arguments) use ($class_name,$function_name) {
            $class = new $class_name($request,$response,$arguments);
            return $class->$function_name();
        });
    }
    
}


