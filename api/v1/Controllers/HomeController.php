<?php

namespace Premium\Api\Controllers;


class HomeController
{
    function index($request, $response) {
        return $response->withStatus(200)->withJson([
            'messege' => 'Sweet!! your API has been cognfigured and is working successfully.',
            'api_version' => API_VERSION
        ]);
        //print_r($request->getAttribute('decoded_token_data')); //Gets Authenticated user
    }
}