<?php

namespace Premium\Api\Controllers;

use Premium\Models\ListingType;



class ListingTypeController
{
    function create($request, $response) {
        $_listingType = $request->getParsedBody('listingtype', '');
        $listingType = new ListingType();

        mapObjectValues($listingType, $_listingType);
        $listingType->save();

        if ($listingType->id) {
            $payload = [
                'listing_type_id' => $listingType->id,
                'links'                      => [
                    '_self'                     => '/listingtypes/' . $listingType->id
                ]
            ];
            return $response->withStatus(201)->withJson($payload);
        } else {
            return $response->withStatus(400);
        }
    }
}