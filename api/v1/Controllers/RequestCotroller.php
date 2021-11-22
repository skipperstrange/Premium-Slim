<?php

namespace Premium\Api\Controllers;

use Premium\Models\Request;
use Premium\Models\Customer;
use Premium\Models\Usage;
use Premium\Models\Cover;

class RequestController
{
    
    function index($request, $response, $args)
    {
        $requestModel = new Request();
        $payload = []; 

        if(isset($args['id'])){
            $request = $requestModel->find($args['id']);
            $payload = $this->organize_payload($request);
            return $response->withStatus(200)->withJson($payload);
        }

        $requests = $requestModel->all();

        foreach ($requests as $request) {
            $payload = $this->organize_payload($request);
        }
        return $response->withStatus(200)->withJson($payload);
    }

    function create($request, $response) {
        $_request = $request->getParsedBody('request', '');
        $request = new Request();

        mapObjectValues($request, $_request);
        $request->save();

        if ($request->id) {
            $payload = [
                'request_type_id' => $request->id,
                'request'                    => $_request,
                'links'                       => [
                    '_self'                      => API_URL . '/requests/' . $request->id
                ]
            ];
            return $response->withStatus(201)->withJson($payload);
        } else {
            return $response->withStatus(400);
        }
    }

    private function organize_payload($result){
        $cover = Cover::where('code',$result->cover)->first();
        $usage = Usage::find($result->vusage);
        $data['data' ] =  [
            'id'=>$result->id, 'buildinglocation' => $result->buildinglocation, 
            'start_date' => $result->mobile, 'cover'=>$cover->cover_name, 'cover_code'=>$result->cover, 'usage' => $usage->usage_name, 'usage_code' => $usage->id,
            'manufacture_year' => $result->year, 'seats'=>$result->seat, 'vehicle_value' => $result->value,
            'engine_cap_cc' => $result->cubic, 'claim_free'=>$result->cfree, 'additional_third_party' => $result->extra_tppd,
            'excess' => $result->excess, 'duration'=>$result->duration, 'additional_third_party' => $result->extra_tppd,
            'property_content_value' => $result->txtcontentvalue, 'property_value'=>$result->txtbuildingvalue, 'additional_third_party' => $result->extra_tppd,
            "status"=>$result->status,"request date"=>$result->datetime,
    ];
        $data['links'] = [
            'customer'      => API_URL.'/customers/' . $result->id,
            'usages'      => API_URL.'/usages/' . $usage->id,
            'cover'      => API_URL.'/covers/' . $cover->id,
            '_self'      => API_URL.'/requests/' . $result->id,
        ];

        return $data;
    }
}