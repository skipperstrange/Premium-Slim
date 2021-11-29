<?php

namespace Premium\Models;

use Premium\Models\Request;

class Comment extends \Illuminate\Database\Eloquent\Model {
    function request(){
        return $this->belongsTo(Request::class);
    }
}
