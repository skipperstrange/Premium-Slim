<?php

namespace Premium\Models;

use Premium\Models\Request;
class Customer extends \Illuminate\Database\Eloquent\Model {
    function requests() {
		return $this->hasMany(Request::class );
	}
}
