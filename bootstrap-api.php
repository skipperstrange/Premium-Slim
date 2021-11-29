<?php

require "includes.php";

$env = get_config('env');


//if(($env['displayErrorDetails'] == true) || ($env['mode'] == 'development')){
    ini_set('display_errors',1);
//}

require "../../vendor/autoload.php";

use Illuminate\Database\Capsule\Manager as Connection;
use Slim\App as SlimApp;

$app = new SlimApp($config);
$container = $app->getContainer();


$connection = new Connection;
$connection->addConnection($config['db']);
$connection->setAsGlobal();
$connection->bootEloquent();

$container['db'] = function ($container) use ($connection) {
    return $connection;
};

$container['authConfig'] = function ($container) use ($config) {
    return $config['auth'];
};

$container['HomeController'] = function ($container) {
    return new Premium\Api\Controllers\HomeController;
};

$container['CustomerController'] = function ($container) {
    return new Premium\Api\Controllers\CustomerController;
};

$container['RequestController'] = function ($container) {
    return new Premium\Api\Controllers\RequestController;
};


$container['CommentController'] = function ($container) {
    return new Premium\Api\Controllers\CommentController;
};

$container['UserController'] = function ($container) {
    return new Premium\Api\Controllers\UserController;
};

$container['AuthController'] = function ($container) {
    return new Premium\Api\Controllers\AuthController($container);
};

