<?php

namespace Premium\Api\Controllers;

use Premium\Models\ListingAmenity;


class ListingAmenitiesController
{
    function create($request, $response, $args) {
        $_listingAmenities = $request->getParsedBody('listingamenity', '');
        $listingAmenity = new ListingAmenity();

        mapObjectValues($listingAmenity, $_listingAmenities);
        $listingAmenity->save();

        if ($listingAmenity->id) {
            $payload = [
                'amenity_id' => $listingAmenity->id,
                'links'                 => [
                    'listing_uri'          => '/listings/' . $listingAmenity->listing_id,
                    '_self'                => '/amenities/' . $listingAmenity->id
                ]
            ];
            return $response->withStatus(201)->withJson($payload);
        } else {
            return $response->withStatus(400);
        }
    }
}