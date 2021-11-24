<?php

namespace Premium\Models;

class Homeinsurance extends \Illuminate\Database\Eloquent\Model {
    function customer(){
        return $this->belongsTo(Request::class);
    }
}
