<?php

namespace Premium\Api\Controllers;

use Exception;
use Premium\Models\User;

class UserController  
{
    private $userModel;

    function __construct()
    {
        $this->userModel = new User();
    }

    function index($request, $response, $args){
        $payload = [];
        $this->userModel->select('id', 'first_name', 'last_name', 'role', 'username', 'created_at');
        if(isset($args['id'])){
            $user =  $this->userModel->find($args['id']);

            $user->links = [
                '_self'      => '/user/' . $user->id
            ];
            return $response->withStatus(200)->withJson($user);
        }

        $users = $this->userModel->get();

        foreach ($users as $user) {
            $payload[] = [
                'id' => $user->id, 'first_name' => $user->first_name, 'last_name' => $user->last_name, 'username' => $user->username, 'role' => $user->role, 'status' => $user->status, 
                'links' => [
                    '_self' => '/users/' . $user->id,
                ]
            ];
        }
        return $response->withStatus(200)->withJson($payload);
    }


    function create($request, $response) {
        $_user = $request->getParsedBody('user', '');
        $_user['user']['password'] = encryptValue('default');
        mapObjectValues($this->userModel, $_user['user']);
        try{
        if($this->userModel->save()){
                    $payload = [
                        'id' => $this->userModel->id,
                        'first_name' => $this->userModel->first_name,
                        'last_name' => $this->userModel->last_name,
                        'role' => $this->userModel->role,
                        'status' => $this->userModel->status,
                        'username' => $this->userModel->username,
                        'links'              => [
                            'user_uri'          => API_URL . '/users/' . $this->userModel->id
                        ]
                    ];
                    return $response->withStatus(201)->withJson($payload);
        }else{
            return $response->withStatus(400);
        }
    }
        catch( Exception $e){
            $payload['error'] = "User already exists";
            return $response->withStatus(422)->withJson($payload);
        }
    }

    function edit($request, $response)
    {
        $_user = $request->getParsedBody('user', '');
                $user['id'] = $_user['user']['id'];
                $user['first_name'] = $_user['user']['first_name'];
                $user['last_name'] = $_user['user']['last_name'];
                $user['role'] = $_user['user']['role'];
                $user['status'] = $_user['user']['status'];
                $user['username'] = $_user['user']['username'];
        mapObjectValues($this->userModel, $user);
                
        $this->userModel->where('id',$user['id'])->update($user);
       
        return $response->withStatus(200)->withJson($user);
    }
}
