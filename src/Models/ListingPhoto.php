<?php

namespace Premium\Models;

use Premium\Models\Listing;

class ListingPhoto extends \Illuminate\Database\Eloquent\Model {

	function listings() {
		return $this->belongsTo(Listing::class );
	}

}
