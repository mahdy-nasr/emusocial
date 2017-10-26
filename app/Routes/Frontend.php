<?php



$app->any('/{controller}[/{function}[/{params:.*}]]', function ( $request,  $response,$arguments) {
	$params = isset($arguments['params'])?explode('/',$arguments['params']):null;
	$fun = isset($arguments['function'])?$arguments['function']:'index';
	$controller_name = '\App\Controllers\\'.(isset($arguments['controller'])?ucwords($arguments['controller']):'Home');
	//$controller = new \App\Controllers\Admin($request,  $response);
	var_dump($controller_name);die;
	if(class_exists($controller_name)) {
		$controller = new $controller_name($request,$response,$params);
		return $controller->$fun();
	}
	else {
		return "Not found 404!";
	}
});
