<?php
$settings["database"] = 
	[
		'mysql' => 
			[
				'host' 		=> 'localhost',
				'db' 		=> 'emu',
				'username'	=> 'root',
				'password'	=> 'root'
			]
	];
$settings['base'] = 
	[
		'url'		=> "http://".$_SERVER['SERVER_NAME'],
		'document'	=> $_SERVER['DOCUMENT_ROOT']
	];
	