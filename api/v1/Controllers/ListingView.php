<?php

namespace Premium\Api\Controllers;

use Premium\Models\ListingView;


class ListingViewController
{
    function create($request, $response, $args) {
        $_listingView = $request->getParsedBody('listingview', '');
        $listingView = new ListingView();

        mapObjectValues($listingView, $_listingView);
        $listingView->save();

        if ($listingView->id) {
            $payload = [
                'listing_view_id' => $listingView->id,
                'links'                      => [
                    'listing_uri'               => '/listings/' . $listingView->listing_id
                ]
            ];
            return $response->withStatus(201)->withJson($payload);
        } else {
            return $response->withStatus(400);
        }
    }
}