<?php

namespace Premium\Api\Controllers;

use Premium\Models\User;
use \Firebase\JWT\JWT;

class AuthController  
{
    private $ontainer;

    function __construct($container){
        $this->container = $container;
    }

    function authenticate($request, $response) {
    $_user = $request->getParsedBody('user', '');
    $_user['password'] = encryptValue($_user['password']);

    $u = User::select('id','username', 'email')->where('password', '=', $_user['password'])->where(function($query) use ($_user){
        $query->where('username', '=', $_user['username'])->orWhere('email', '=', $_user['username']);
    })->get()->toArray();

    $user = $u[0];
    if ($user) {
        $settings = $this->container->get('authConfig');

        $token = JWT::encode(['id' => $user['id'], 'email' => $user['email'], 'username' => $user['username']], $settings['secret'], "HS256");
        return $response->withJson(['token' => $token]);
    } else {
        return $response->withStatus(404);
    }

    return $response->withStatus(200)->withJson($user);
}
}
