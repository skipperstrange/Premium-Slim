<?php

namespace Premium\Api\Controllers;

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
                'first_name' => $user->first_name, 'last_name' => $user->last_name, 'username' => $user->username, 'role' => $user->role, 'status' => $user->status, 
                'links' => [
                    '_self' => '/users/' . $user->id,
                ]
            ];
        }
        return $response->withStatus(200)->withJson($payload);
    }


    function create($request, $response) {
    $_user = $request->getParsedBody('user', '');
    $_user['password'] = encryptValue($_user['password']);

    mapObjectValues($this->userModel, $_user);
    $this->userModel->save();

    if ($this->userModel->id) {
        $payload = [
            'user_id' => $this->userModel->id,
            'links'              => [
                'user_uri'          => API_URL . '/users/' . $this->userModel->id
            ]
        ];
        return $response->withStatus(201)->withJson($payload);
    } else {
        return $response->withStatus(400);
    }
}
}
