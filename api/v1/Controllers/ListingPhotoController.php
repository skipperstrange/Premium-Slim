<?php

namespace Premium\Api\Controllers;

use Premium\Models\Listing;
use Premium\Models\ListingPhoto;

class ListingPhotoController
{
    function create($request, $response, $args) {
		$_photo = $request->getParsedBody('photo', '');
		$photo = new ListingPhoto();
		$package = @$request->getUploadedFiles();
		//print_r($_photo);
		$file = $package['file'];

		$listing = Listing::find($args['id']);

		if ($listing->id) {
			if ($file->getError() === UPLOAD_ERR_OK) {

				mapObjectValues($photo, $_photo);
				$photo->listing_id = $listing->id;
				$extension = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
				$photo->photo = generateRandom($listing->id).'.'.$extension;
				usleep(25000);

				$file->moveTo(UP_ONE.UP_ONE.LISTINGS_IMG_UPLOAD_PATH.$photo->photo);

				$photo->save();

				if ($photo->id) {
					$payload = [
						'listing_uri' => '/listing/'.$listing->id,
						'photos_uri'  => '/listing/'.$listing->id.'/photo',
						'_self'       => LISTINGS_IMG_URL.$photo->photo
					];
					return $response->withStatus(201)->withJson($payload);
				}
			} else {
				return $response->withStatus(400)->withJson(['message' => 'Could not upload file']);
			}
		} else {
			return $response->withStatus(404)->withJson(['message' => 'Listing not found']);
		}
	}
}