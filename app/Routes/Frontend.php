<?php



$app->any('/{controller}[/[{function}[/[{params:.*}]]]]', function ($request, $response, $arguments) {
    $params = isset($arguments['params'])?explode('/', $arguments['params']):null;
    $fun = isset($arguments['function'])?$arguments['function']:'index';
    $controller_name = '\App\Controllers\\'.(isset($arguments['controller'])?ucwords($arguments['controller']):'Home');
    //$controller = new \App\Controllers\Admin($request,  $response);
    
    if (class_exists($controller_name)) {
        $controller = new $controller_name($request, $response, $params);
        return $controller->$fun();
    } else {
        return "Not found 404!";
    }
});

$app->get('/', function ($request, $response, $arguments) {
    return (new \App\Controllers\Home($request, $response, $arguments))->index();
});
