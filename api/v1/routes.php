<?php

$app->get('/', 'HomeController:index');

//all endppoints begining with /edit require token from authorization (/login)
$app->group('/edit', function () use ($app) {
   
});

//No tokens required


/*
Users
 */
$app->post('/new', 'UserController:create');
$app->get('/users', 'UserController:index');
$app->get('/users/{id}', 'UserController:index');


//authentication of new user
$app->post('/login', 'AuthController:authenticate');


/*
Customers
 */
//$app->post('/customers', 'CustomerController:create');
$app->get('/customers', 'CustomerController:index');
$app->get('/customers/{id}', 'CustomerController:index');

/*
Requests
*/
$app->get('/requests', 'RequestController:index');
$app->get('/requests/{id}', 'RequestController:index');
$app->get('/customer/{id}/requests', 'RequestController:customer');
$app->post('/status', 'RequestController:status_change');

// Comments
$app->post('/comment', 'CommentController:create');
$app->get('/comment', 'CommentController:index');

