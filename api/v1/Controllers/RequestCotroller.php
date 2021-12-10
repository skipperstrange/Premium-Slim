<?php

namespace Premium\Api\Controllers;

use Exception;
use Premium\Models\Request;
use Premium\Models\Customer;
use Premium\Models\Usage;
use Premium\Models\Cover;
use Premium\Models\Homeinsurance;
use Premium\Models\Comment;

class RequestController
{
    private $requestModel;
    private $commentModel;
    private $requestStatus = ['complete', 'failed', 'pending', 'unfollowed'];

    function __construct()
    {
        $this->requestModel = new Request();
        $this->commentModel = new Comment();
    }


    private function organize_payload($result){
        if($result){
            $cover = Cover::where('code',$result->cover)->first();
        $homeprehensive = Homeinsurance::where('id',$result->homeinsurance)->first();
        $usage = Usage::find($result->vusage);
        $customer = Customer::find($result->userid);
        $data =  [
           'id'=>$result->id, 'location' => $result->buildinglocation, 
            'start_date' => $result->mobile, 'policy'=>$cover->cover_name, 'policy_code'=>$result->cover, 'usage' => $usage->usage_name, 'usage_code' => $usage->id,
            'manufacture_year' => $result->year, 'seats'=>$result->seat, 'vehicle_value' => $result->value, 'currency' => $result->currency,
            'engine_cap_cc' => $result->cubic, 'claim_free'=>$result->cfree, 'additional_third_party' => $result->extra_tppd,
            'excess' => $result->excess, 'duration'=>$result->duration, 'additional_third_party' => $result->extra_tppd, 'property_policy'=>$homeprehensive->cover_name,
            'property_policy_id'=>$homeprehensive->id,'property_content_value' => $result->txtcontentvalue, 'property_value'=>$result->txtbuildingvalue, 'additional_third_party' => $result->extra_tppd,
            "status"=>$result->status,"request_date"=>$result->datetime, 
      
        'original' => $result,
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
        ], 
          ];
        return $data;
        }
        return false;
    }
    
    function index($request, $response, $args)
    {
        
        $payload = []; 
        if(isset($args['id'])){
            try{
                $req = $this->requestModel->find($args['id']);
             if(isset($req->id)){
                $req['usage'] = $req['vusage'];
                $payload = $this->organize_payload($req);
                return $response->withStatus(200)->withJson($payload);
             }
             return $response->withStatus(404)->withJson(["message"=>"Not Found"]);
            }
            catch(Exception $e){
                return $response->withStatus(404)->withJson(["message"=>"Not Found"]);
            }
        }

        $req = $this->requestModel->get();
        foreach ($req as $request) {
            $request['usage'] = $request['vusage'];
           $payload[] = $this->organize_payload($request);
        }
        return $response->withStatus(200)->withJson($payload);
    }

    function create($request, $response) {
        $_request = $this->requestModel->getParsedBody('request', '');
        mapObjectValues($request, $_request);
        $this->requestModel->save();

        if ($this->requestModel->id) {
            $payload = [
                'request_type_id' => $this->requestModel->id,
                'request'                    => $_request,
                'links'                       => [
                    '_self'                      => API_URL . '/requests/' . $this->requestModel->id
                ]
            ];
            return $response->withStatus(201)->withJson($payload);
        } else {
            return $response->withStatus(400);
        }
    }


    function status($request, $response, $args){
        $payload =[];
        
        if(isset($args['status'])){
            $status = $args['status'];
            $results = $this->requestModel->where('status', $status)->get();
            
            foreach ($results as $request) {
                $request['usage'] = $request['vusage'];
               $payload[] = $this->organize_payload($request);
            }
            return $response->withStatus(200)->withJson($payload);
        }
        return $response->withStatus(404)->withJson([]);
    }

    function status_change($request, $response)
    {
        $_status = $request->getParsedBody('status', '');
        mapObjectValues($this->requestModel, $_status);
        $this->requestModel->where('id',$_status['id'])->update(['status'=>$_status['status']]);
        return $response->withStatus(200)->withJson($_status);
    }

    function comment($request, $response, $args){
        $comments = $this->requestModel->comments()->where('request_id', $args['id'])->get();
        return $response->withStatus(200)->withJson($comments);
    }
}