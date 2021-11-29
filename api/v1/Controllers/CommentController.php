<?php

namespace Premium\Api\Controllers;

use Premium\Models\Comment;

class CommentController  
{
    function index(){
        echo "Hi from comments";
    }
    function create($request, $response) {
    $_comment = $request->getParsedBody('comment', '');
    $comment = new Comment();

        mapObjectValues($comment, $_comment);
        $request->save();
        echo 'success';
    }
}
