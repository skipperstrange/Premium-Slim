<?php

namespace Premium\Models;

use Premium\Models\CustomerType;

class Customer extends \Illuminate\Database\Eloquent\Model {

	function customer_type() {
		return $this->belongsTo(CustomerType::class );
	}

}
