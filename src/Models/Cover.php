<?php

namespace Premium\Models;

class Cover extends \Illuminate\Database\Eloquent\Model {
    function customer(){
        return $this->belongsTo(Request::class);
    }
}
