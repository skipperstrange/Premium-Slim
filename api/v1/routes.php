<?php

$app->get('/', 'HomeController:index');

//all endppoints begining with /edit require token from authorization (/login)
$app->group('/edit', function () use ($app) {
   
});

//No tokens required


/*
Users
 */
$app->post('/users', 'UserController:create');


//authentication of new user
$app->post('/login', 'AuthController:authenticate');


/*
Customers
 */
$app->post('/customers', 'CustomerController:create');

