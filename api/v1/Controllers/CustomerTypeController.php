<?php

namespace Premium\Api\Controllers;

use Premium\Models\CustomerType;

class CustomerTypeController
{
    function create($request, $response, $args) {
    $_customerType = $request->getParsedBody('customertype', '');
    $customerType = new CustomerType();

    mapObjectValues($customerType, $_customerType);
    $customerType->save();

    if ($customerType->id) {
        $payload = [
            'customer_type_id' => $customerType->id,
            'links'                       => [
                'customer_type_uri'          => API_URL . '/customertypes/' . $customerType->id
            ]
        ];
        return $response->withStatus(201)->withJson($payload);
    } else {
        return $response->withStatus(400);
    }
}
}