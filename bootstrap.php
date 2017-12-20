<?php
session_start();
date_default_timezone_set('Europe/Istanbul');

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
require __DIR__ . "/app/Helpers/Helper.php";

