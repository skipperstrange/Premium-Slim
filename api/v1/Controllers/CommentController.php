<?php

namespace Premium\Api\Controllers;

use Premium\Models\Comment;

class CommentController  
{

    function index($request, $response) {
        
    }

    function create($request, $response) {
    $_comment = $request->getParsedBody('comment', '');
    $comment = new Comment();

        mapObjectValues($comment, $_comment);
        $comment->save();

        if ($comment->id) {
            $payload = [
                'request_uri'  => API_URL .'/requests/' . $comment->id ,
                '_self'        => API_URL .'/comments/' . $comment->id
            ];
            return $response->withStatus(201)->withJson($payload);
        } else {
            return $response->withStatus(400);
        }
    }
}
