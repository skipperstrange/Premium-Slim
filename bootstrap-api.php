<?php

require "includes.php";
require "../../vendor/autoload.php";

use Illuminate\Database\Capsule\Manager as Connection;
use Slim\App as SlimApp;

$app = new SlimApp($config['settings']);
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


$container['ListingController'] = function ($container) {
    return new Premium\Api\Controllers\ListingController;
};

$container['ListingAmenitiesController'] = function ($container) {
    return new Premium\Api\Controllers\ListingAmenitiesController;
};

$container['HomeController'] = function ($container) {
    return new Premium\Api\Controllers\HomeController;
};

$container['CustomerController'] = function ($container) {
    return new Premium\Api\Controllers\CustomerController;
};

$container['ListingTypeController'] = function ($container) {
    return new Premium\Api\Controllers\ListingTypeController;
};

$container['UserController'] = function ($container) {
    return new Premium\Api\Controllers\UserController;
};

$container['CustomerTypeController'] = function ($container) {
    return new Premium\Api\Controllers\CustomerTypeController;
};

$container['CustomerController'] = function ($container) {
    return new Premium\Api\Controllers\CustomerController;
};

$container['ListingPhotoController'] = function ($container) {
    return new Premium\Api\Controllers\ListingPhotoController;
};

$container['AuthController'] = function ($container) {
    return new Premium\Api\Controllers\AuthController($container);
};

