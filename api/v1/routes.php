<?php

$app->get('/', 'HomeController:index');

//all endppoints begining with /edit require token from authorization (/login)
$app->group('/edit', function () use ($app) {

    $app->post('/listings', 'ListingController:create');

    /**
     * Listing Photos
     */
    $app->post('/listings/{id}/photos', 'ListingPhotoController:create');

    /*
    Listing Amenities
    */
    $app->post('/listings/{id}/amenities', 'ListingAmenitiesController:create');

    /*
    Listing Types
    */
    $app->post('/listingtypes', 'ListingTypeController');

    /*
    Listing Views
    */
    $app->post('/listingviews', 'ListingViewController:create');
});



//No tokens required
/*
Listings
 */
$app->get('/listings', 'ListingController:index');
$app->get('/listings/{id}', 'ListingController:index');
$app->get('/listings/{id}/photos', 'ListingController:photos');
$app->post('/searchlistings', 'ListingController:search');

/*
Users
 */
$app->post('/users', 'UserController:create');


//authentication of new user
$app->post('/login', 'AuthController:authenticate');


/*
Customers
 */
$app->post('/customers', 'CustomerController:create');

/*
Customer Types
 */
$app->post('/customertypes', 'CustomerTypeController:create');
