<?php

namespace Premium\Models;

class Cover extends \Illuminate\Database\Eloquent\Model {
    function request(){
        return $this->hasMany(Request::class);
    }
}
