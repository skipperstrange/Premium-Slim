<?php

namespace Premium\Api\Controllers;

use Premium\Models\User;

class UserController  
{
    function create($request, $response) {
    $_user = $request->getParsedBody('user', '');
    $user = new User();
    $_user['password'] = encryptValue($_user['password']);

    mapObjectValues($user, $_user);
    $user->save();

    if ($user->id) {
        $payload = [
            'user_id' => $user->id,
            'links'              => [
                'user_uri'          => API_URL . '/users/' . $user->id
            ]
        ];
        return $response->withStatus(201)->withJson($payload);
    } else {
        return $response->withStatus(400);
    }
}
}
