<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserAddressService;
use App\Models\userAddress;
use Validator;


class AddressController extends Controller
{
    //

      public function __construct(UserAddressService $UserAddressService){

        $this->UserAddressService=$UserAddressService;
           
    }


    public function viewAddress(Request $request){
       $result =   $this->UserAddressService->viewAddress($request);

       $address = $result['data'];


       return view('user.profile.saved-address', compact('address'));
       
    }


    public function saveAddress(Request $request){
        if($request->isMethod('get')){
            
            return view('user.profile.add-new-address');
        }else{
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
                    return response()->json([
                        'status'=>false,
                        'errors'=>$validate->errors()
                    ]);
            }

            
         $request_data = [
            'user_id'=>$request->user()->id,
            'name'=>$request->name,
            'country_code'=>$request->country_code ?? +964,
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


        $data = UserAddress::updateOrCreate(
            ['id' => $request->id],
            $request_data
        );


         return response()->json([
            'status'=>true,
            'message'=>'Address save successfully'
         ]);

        }
    }


     public function updateAddress(string $id){

       $address = userAddress::where('id', $id)->first();
        return view('user.profile.add-new-address', compact('address'));
     }


      public function deleteAddress(string $id){
        
            $request_data= (object)  [
                'id'=>$id
            ];

        $result =   $this->UserAddressService->deleteAddress($request_data);
        
        return back()->with('success', $result['message']);
        
         
      }

}