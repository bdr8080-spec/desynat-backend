<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserAddressService;
use App\Models\userAddress;
use App\Models\all_countrie;
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
            $country =   all_countrie::where('status',1)->orderBy('id','asc')->get();
            return view('user.profile.add-new-address', compact('country'));
        }else{

            $rules =  [
            'name'            => 'required',
            'country_code'    => 'required',
            'mobile'          => 'required|digits_between:7,15',
            'address'         => 'required',
            'house_no'        => 'required',
            'country_name'    => 'required',
            'city'            => 'required',
            'state'           => 'required',
            'save_address_as' => 'required',
        ];


            //         $messages = [
            //     'name.required'            => 'Please Enter Name',
            //     'mobile.required'          => 'Please Enter Mobile Number',
            //     'address.required'         => 'Please Enter Address',
            //     'house_no.required'        => 'Please Enter House No.',
            //     'country_name.required'       => 'Please Enter Country Name.',
            //     'city.required'            => 'Please Enter City',
            //     'state.required'           => 'Please Enter State',
            //     'country_code.required'    => 'Please Select Country Code',
            //     'save_address_as.required' => 'Please Select Save Address As',
            //     'mobile.digits_between'    => 'Mobile number must be between 7 to 15 digits',
            // ];
            $messages = [
                'name.required'            => __('user_messages.please_enter_name'),
                'mobile.required'          => __('user_messages.please_enter_mobile_number'),
                'address.required'         => __('user_messages.please_enter_address'),
                'house_no.required'        => __('user_messages.please_enter_house_no'),
                'country_name.required'    => __('user_messages.please_enter_country_name'),
                'city.required'            => __('user_messages.please_enter_city'),
                'state.required'           => __('user_messages.please_enter_state'),
                'country_code.required'    => __('user_messages.please_select_country_code'),
                'save_address_as.required' => __('user_messages.please_select_save_address_as'),
                'mobile.digits_between'    => __('user_messages.mobile_digits_between'),
            ];



             $validate = Validator::make($request->all(),$rules, $messages);
            
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
            'country_name'=>$request->country_name,
            'landmark'=>$request->landmark ?? null,
            'save_address_as'=>$request->save_address_as,
            'latitude'=>$request->latitude ?? null,
            'longitude'=>$request->longitude ?? null
        ];


      $checkUserAddress=  UserAddress::where('user_id',$request->id)->get();

      if(count($checkUserAddress)==0){
        $request_data['set_as_default']='1';
      }



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
        $country =   all_countrie::where('status',1)->orderBy('id','asc')->get();
        return view('user.profile.add-new-address', compact('address','country'));
     }


      public function deleteAddress(string $id){
        
            $request_data= (object)  [
                'id'=>$id
            ];

        $result =   $this->UserAddressService->deleteAddress($request_data);
        
        return back()->with('success', $result['message']);
        
         
      }

          public function addressSetDefault(Request $request){
        
            $id = $request->user()->id;

              $request_data= (object)  [
                'id'=>$id,
                'address_id'=>$request->address_id
            ];

           $data = $this->UserAddressService->addressSetDefault($request_data);

           return response()->json([
            'status'=>true,
            'message'=>$data['message']
           ]);

     }

}