<?php

namespace Premium\Models;

class Homeinsurance extends \Illuminate\Database\Eloquent\Model {
    function request(){
        return $this->belongsTo(Request::class);
    }
}
