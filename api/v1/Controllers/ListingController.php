<?php

namespace Premium\Api\Controllers;

use Premium\Models\Listing;
use Premium\Models\ListingPhoto;
use Premium\Models\Search;



class ListingController
{

    /**
     * Get all listings.
     * If id specified, a single listing is returned
     */
    function index($request, $response, $args)
    {
        $ListingModel = new Listing();
        $payload = [];

        if($args['id']){
            $listing = $ListingModel->find($args['id']);

            $listing->links = [
                'photos_uri' => '/listings/' . $listing->id . '/photos',
                'amenities' => '/listings/' . $listing->id . '/amenities',
                '_self'      => '/listings/' . $listing->id
            ];
            return $response->withStatus(200)->withJson($listing);
        }

        $listings = $ListingModel->all();

        foreach ($listings as $listing) {
            $payload[$listing->id] = [
                'listing_type' => $listing->listing_type, 'price' => $listing->price, 'description' => $listing->description, 'location' => $listing->location, 'coordinates' => $listing->coordinates, 'status' => $listing->status, 'links' => [
                    'amenities' => '/listings/' . $listing->id . '/amenities',
                    'photos_uri'                           => '/listings/' . $listing->id . '/photos',
                    '_self'                                => '/listings/' . $listing->id,
                ]
            ];
        }
        return $response->withStatus(200)->withJson($payload);
    }

    //Create new listing
    function create($request, $response) {
        $_listing = $request->getParsedBody('listing', '');
        $listing = new Listing();

        mapObjectValues($listing, $_listing);
        $listing->user_id = -1;
        $listing->save();

        if ($listing->id) {
            $payload = [
                'listing_id' => $listing->id,
                'amenities' => '/listings/' . $listing->id . '/amenities',
                'photos_uri'            => '/listings/' . $listing->id . '/photos',
                '_self'           => '/listings/' . $listing->id
            ];
            return $response->withStatus(201)->withJson($payload);
        } else {
            return $response->withStatus(400);
        }
    }

    /**
     * Upload a listing image
     */
    function photos($request, $response, $args) {
    $listing_id = $args['id'];

    $payload = Listing::find($listing_id)->listing_photos()->get();
    if ($payload) {
        foreach ($payload as $key => $value) {
            $payload[$key]['links'] = [
                'listing_uri' => '/listings/' . $listing_id,
                'photos_uri'  => '/listings/' . $listing_id . '/photos',
                '_self'       => LISTINGS_IMG_URL . $payload[$key]->photo
            ];
        }
    }

    return $response->withStatus(200)->withJson($payload);
}


/**
 * Search through listnggs
 */

 function search($request, $response, $args) {

    $query = $request->getParsedBody('query', '');
    $search = new Search();
    $search->setModel('listings');
    $search->setSearchFields(['description', 'location']);
    $search->setDataFields(['id', 'description', 'listing_type', 'date_posted', 'customer_id', 'user_id', 'coordinates', 'price', 'currency']);
    $search->setKeyword($query['query']);

    $payload = $search->search();

    foreach ($payload as $result => $r) {
        $payload[$result]['links'] = [
            'photos_uri' => '/listings/' . $r->id . '/photos',
            '_self'      => '/listings/' . $r->id
        ];
    }
    return $response->withStatus(200)->withJson($payload);
}
        
}
