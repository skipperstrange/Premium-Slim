<?php

namespace Premium\Models;

use Premium\Models\ListingPhoto;
use Premium\Models\ListingType;
use Premium\Models\ListingView;
use Premium\Models\ListingAmenity;

class Listing extends \Illuminate\Database\Eloquent\Model {

	function listing_photos() {
		return $this->hasMany(ListingPhoto::class );
	}

	function listing_types() {
		return $this->belongsTo(ListingType::class );
	}

	function listing_views() {
		return $this->hasMany(ListingView::class );
	}

	function listing_listing() {
		return $this->hasMany(ListingAmenity::class );
	}
}
