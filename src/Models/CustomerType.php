<?php

namespace Premium\Models;

use Premium\Models\Customer;

class CustomerType extends \Illuminate\Database\Eloquent\Model {
	function Customers() {
		return $this->hasMany(Customer::class );
	}
}
