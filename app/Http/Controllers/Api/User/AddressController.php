<?php

namespace App\Http\Controllers\Api\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserAddressService;
use App\Helpers\ApiResponse;
use Validator;


class AddressController extends Controller
{
    //

    public function __construct(UserAddressService $UserAddressService){

        $this->UserAddressService=$UserAddressService;

    }

    public function saveAddress(Request $request){
       
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'country_code' => 'required',
            'mobile' => 'required',
            'address'=>  'required',
            'house_no' => 'required',
            'street_no' => 'required',
            'city'=> 'required',
            'state'=>'required',
            'save_address_as'=>'required'
        ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

         $request_data = [
            'user_id'=>$request->user()->id,
            'name'=>$request->name,
            'country_code'=>$request->country_code,
            'mobile'=>$request->mobile,
            'address'=>$request->address,
            'house_no'=>$request->house_no,
            'street_no'=>$request->street_no,
            'postal_code'=>$request->postal_code ?? null,
            'city'=>$request->city,
            'state'=>$request->state,
            'landmark'=>$request->landmark ?? null,
            'save_address_as'=>$request->save_address_as,
            'latitude'=>$request->latitude ?? null,
            'longitude'=>$request->longitude ?? null
        ];


       $data = $this->UserAddressService->saveAddress($request_data);

         if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);

        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
       
    }


    
    public function updateAddress(Request $request){
       
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'country_code' => 'required',
            'mobile' => 'required',
            'address'=>  'required',
            'house_no' => 'required',
            'street_no' => 'required',
            'city'=> 'required',
            'state'=>'required',
            'save_address_as'=>'required'
        ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

         $request_data = [
            'user_id'=>$request->user()->id,
            'name'=>$request->name,
            'country_code'=>$request->country_code,
            'mobile'=>$request->mobile,
            'address'=>$request->address,
            'house_no'=>$request->house_no,
            'street_no'=>$request->street_no,
            'postal_code'=>$request->postal_code ?? null,
            'city'=>$request->city,
            'state'=>$request->state,
            'landmark'=>$request->landmark ?? null,
            'save_address_as'=>$request->save_address_as,
            'latitude'=>$request->latitude ?? null,
            'longitude'=>$request->longitude ?? null
        ];


       $data = $this->UserAddressService->updateAddress($request_data,$request->id);

         if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
       
    }

    public function viewAddress(Request $request){

        $data = $this->UserAddressService->viewAddress($request);

         if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],[],200);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
  
    }

     public function deleteAddress(Request $request , $id){

        $validate = Validator::make(['id'=>$id], [
                 'id' => 'required',
        ]);
                
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

        $data = $this->UserAddressService->deleteAddress($request);

         if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
  
    }

}