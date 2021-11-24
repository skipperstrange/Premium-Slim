<?php

namespace Premium\Api\Controllers;

use Premium\Models\Request;
use Premium\Models\Customer;
use Premium\Models\Usage;
use Premium\Models\Cover;
use Premium\Models\Homeinsurance;

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
            $payload[] = $this->organize_payload($request);
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
        $homeprehensive = Homeinsurance::where('id',$result->homeinsurance)->first();
        $usage = Usage::find($result->vusage);
        $customer = Customer::find($result->userid);
        $data =  [
            'id'=>$result->id, 'location' => $result->buildinglocation, 
            'start_date' => $result->mobile, 'policy'=>$cover->cover_name, 'policy_code'=>$result->cover, 'usage' => $usage->usage_name, 'usage_code' => $usage->id,
            'manufacture_year' => $result->year, 'seats'=>$result->seat, 'vehicle_value' => $result->value,
            'engine_cap_cc' => $result->cubic, 'claim_free'=>$result->cfree, 'additional_third_party' => $result->extra_tppd,
            'excess' => $result->excess, 'duration'=>$result->duration, 'additional_third_party' => $result->extra_tppd, 'property_policy'=>$homeprehensive->cover_name,
            'property_policy_id'=>$homeprehensive->id,'property_content_value' => $result->txtcontentvalue, 'property_value'=>$result->txtbuildingvalue, 'additional_third_party' => $result->extra_tppd,
            "status"=>$result->status,"request date"=>$result->datetime,
      

        'customer' => [
            'name' => $customer->fullname, 
            'email' => $customer->email,
            'mobile' => $customer->mobile],
        'links' => [
            'customer_requests' => API_URL.'/customers/' . $customer->id . '/requests',
            'customer'      => API_URL.'/customers/' . $result->id,
            'usages'      => API_URL.'/usages/' . $usage->id,
            'cover'      => API_URL.'/covers/' . $cover->id,
            '_self'      => API_URL.'/requests/' . $result->id,
        ]
          ];

        return $data;
    }
}