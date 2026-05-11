<?php
namespace App\Services;

use App\Models\User;
use App\Models\userAddress;
use App\Services\UserProfileService;


use Hash;

class UserAddressService
{

 

      public function saveAddress(array $request){
     
       $saveAddress = userAddress::create($request);

     
        if (!$saveAddress) {
             return ['status'=>'error','message'=>"Failed to save address. Please try again",'data'=>[]];
              }

        return ['status'=>'success','message' => __('user_messages.address_saved_successfully'),'data'=>$saveAddress];
      
    }


       public function updateAddress(array $request,string $id){

        $updateAddress = userAddress::where('id', $id)->update($request);

        if (!$updateAddress) {
             return ['status'=>'error','message'=>"Address not found",'data'=>[]];
              }

        return ['status'=>'success','message' => __('user_messages.update_address_successfully'),'data'=>$updateAddress];
      
    }

    public function viewAddress($request){
        $viewAddress = userAddress::orderBy('id','desc')->where('user_id', $request->user()->id)->get();

            if ($viewAddress->isEmpty()) {
                return [
                    'status' => 'error',
                    'message' => "No address found",
                    'data' => []
                ];
            }

            return [
                'status' => 'success',
                'message' => "Address retrieved successfully",
                'data' => $viewAddress
            ];
    }


    public function deleteAddress($request){
        
        $deleteAddress = userAddress::find($request->id);

        if (!$deleteAddress) {
            return [
                'status' => 'error',
                'message' => "Address not found",
                'data' => []
            ];
        }

        $deleteAddress->delete();

        return [
            'status' => 'success',
            'message' => __('user_messages.address_deleted_successfully'),
            'data' => []
        ];


    }


   public function addressSetDefault($request){
    
     userAddress::where('user_id', $request->id)->update(['set_as_default' => '0']);

        $updateSetAddress = userAddress::where('id', $request->address_id)
        ->update(['set_as_default' => '1']);

        $addresses = userAddress::where('id', $request->address_id)->get();

        return [
            'status' => 'success',
            'message' => __('user_messages.address_set_as_default_successfully'),
            'data' => $addresses
        ];

   }



}