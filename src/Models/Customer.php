<?php

namespace Premium\Models;

class Customer extends \Illuminate\Database\Eloquent\Model {
    function requests() {
		return $this->hasMany(Request::class );
	}
}
