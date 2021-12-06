<?php

namespace Premium\Api\Controllers;

use Exception;
use Premium\Models\User;
use \Firebase\JWT\JWT;

class AuthController  
{
    private $container;

    function __construct($container){
        $this->container = $container;
    }

    function authenticate($request, $response) {
        $_user = $request->getParsedBody('user', '');
        $_user['password'] = encryptValue($_user['password']);
        $user = User::select('id','username', 'first_name', 'last_name', 'role')
            ->where('password', '=', $_user['password'])
            ->where('username', '=', $_user['username'])
            ->where('status', '=', 'active')
            ->first();
           
        if($user){   
            try{
            
                $settings = $this->container->get('authConfig');
    
                $token = JWT::encode(['id' => $user['id'], 'first_name' => $user['first_name'], 'role' => $user['role'], 'last_name' => $user['last_name'], 'username' => $user['username']], $settings['secret'], "HS256");
                $payload['user'] = ['id' => $user['id'], 'first_name' => $user['first_name'], 'role' => $user['role'], 'last_name' => $user['last_name'], 'username' => $user['username']];
                $payload['token'] = $token;
                $payload['status'] = 'success';
                return $response->withStatus(200)->withJson($payload); 
            }
            catch(Exception $e){
                return $response->withStatus(400)->withJson($e);
            }
        }else{
            return $response->withStatus(404);
        }
           
    }

    function user($request, $response){
        $auth = $request->getHeader('Authourization');
        $_apikey = $auth[0];
        $apikey = substr($_apikey, strpos($_apikey, ' ')+1);

        $user = new User();
        if(!$user->authenticate($apikey)){
            return $response->withStatus(401);
        }
		return $user;
    }
}
