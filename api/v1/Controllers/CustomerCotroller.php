<?php

namespace Premium\Api\Controllers;

use Premium\Models\Customer;

class CustomerController
{
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