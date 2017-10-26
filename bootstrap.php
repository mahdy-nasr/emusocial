<?php
session_start();
date_default_timezone_set('Europe/Istanbul');
ini_set("xdebug.var_display_max_children", -1);
ini_set("xdebug.var_display_max_data", -1);
ini_set("xdebug.var_display_max_depth", -1);
//error_reporting( E_ALL );
//ini_set( "display_errors", 1 );

require __DIR__ . "/vendor/autoload.php";

require __DIR__ . "/settings.php";


$app = new \Slim\App( [
    'settings' => [
        'displayErrorDetails' => true,
    ],
]);

require __DIR__ . "/app/Routes/Api.php";
require __DIR__ . "/app/Routes/Frontend.php";

