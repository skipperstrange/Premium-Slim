<?php

namespace Premium\Models;

use Premium\Models\Customer;
use Premium\Models\Cover;
use Premium\Models\Comment;
class Request extends \Illuminate\Database\Eloquent\Model {
    function customer(){
        return $this->belongsTo(Customer::class);
    }

    function cover(){
        return $this->belongsTo(Cover::class);
    }

    function comments() {
		return $this->hasMany(Comment::class );
	}
}
