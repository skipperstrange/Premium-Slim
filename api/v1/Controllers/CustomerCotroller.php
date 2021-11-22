<?php

namespace Premium\Api\Controllers;

use Premium\Models\Customer;

class CustomerController
{
    function index($request, $response, $args)
    {
        $customerModel = new Customer();
        $payload = []; 

        if(isset($args['id'])){
            $customer = $customerModel->find($args['id']);
            $customer->links = [
                'requests' => API_URL.'/customers/' . $customer->id . '/requests',
                '_self'      => API_URL.'/customers/' . $customer->id
            ];
            return $response->withStatus(200)->withJson($customer);
        }

        $customers = $customerModel->all();

        foreach ($customers as $customer) {
            $payload[$customer->id] = [
                'name' => $customer->fullname, 'email' => $customer->email, 'mobile' => $customer->mobile, 'links' => [
                    'requests' => '/customers/' . $customer->id . '/requests',
                    'photos' => '/customers/' . $customer->id . '/photos',
                    '_self'      => '/customers/' . $customer->id,
                ]
            ];
        }
        return $response->withStatus(200)->withJson($payload);
    }

    function create($request, $response) {
    $_customer = $request->getParsedBody('customer', '');
    $customer = new Customer();

    mapObjectValues($customer, $_customer);
    $customer->save();

    if ($customer->id) {
        $payload = [
            'customer_type_id' => $customer->id,
            'customer'                    => $_customer,
            'links'                       => [
                '_self'                      => API_URL . '/customers/' . $customer->id
            ]
        ];
        return $response->withStatus(201)->withJson($payload);
    } else {
        return $response->withStatus(400);
    }
}
}