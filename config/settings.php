<?php

$config['settings'] =
[
	'displayErrorDetails' => true,
	'debug'               => true,
	'mode'                => 'development'
];

$config['db'] =
['driver'    => "mysql",
	'host'      => "localhost",
	'database'  => "vanguas2_homeprehensive",
	'username'  => "root",
	'password'  => "root",
	'charset'   => "utf8",
	'collation' => "utf8_general_ci",
	'prefix'    => "tb"
];

$config['frontend'] = [
	'root' => APP_ROOT,
	'404'  => APP_ROOT.'404.html',
	'default' => 'index.html'
];