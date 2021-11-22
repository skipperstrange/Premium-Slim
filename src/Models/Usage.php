<?php

namespace Premium\Models;

class Usage extends \Illuminate\Database\Eloquent\Model {
    function customer(){
        return $this->belongsTo(Customer::class);
    }
}
