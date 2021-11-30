<?php

namespace Premium\Api\Controllers;

use Premium\Models\Comment;

class CommentController  
{
    private $commentModel;

    function __construct(){
        $this->commentModel = new Comment();
    }
    
    function index($request, $response) {
        
    }

    function create($request, $response) {
    $_comment = $request->getParsedBody('comment', '');

        mapObjectValues($this->commentModel, $_comment);
        $this->commentModel->save();

        if ($this->commentModel->id) {
            $payload = [
                'request_uri'  => API_URL .'/requests/' . $this->commentModel->id ,
                '_self'        => API_URL .'/comments/' . $this->commentModel->id
            ];
            return $response->withStatus(201)->withJson($payload);
        } else {
            return $response->withStatus(400);
        }
    }
}
