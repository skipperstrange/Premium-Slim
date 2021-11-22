<?php

namespace Premium\Models;

class Request extends \Illuminate\Database\Eloquent\Model {
    function customer(){
        return $this->belongsTo(Customer::class);
    }
}
