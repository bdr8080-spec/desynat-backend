<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserProfileService;
use App\Models\country;
use App\Models\User;
use App\Models\UserCurrentLocation;
use App\Models\all_countrie;
use App\Models\UserContactChangeHistory;
use App\Helpers\ApiResponse;
use Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\CommonController;
use App\Services\TwilioService;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserOtpMail;
use Illuminate\Support\Facades\DB;


class ProfileController extends Controller
{
    //

    public function __construct(UserProfileService $UserProfileService){

        $this->UserProfileService=$UserProfileService;

    }

    public function userProfile(Request $request){
         $user = User::with('country_info')->where('id',$request->user()->id)->first();
        
             if($request->isMethod('get')){
                    return view('user.profile.index', compact('user'));
             }else{

                   
               $rules = [
                    'full_name' => 'required',
                ];

                $messages = [
                    'full_name.required' => __('user_messages.please_enter_full_name'),
                ];

                $validator = Validator::make($request->all(), $rules, $messages);

                if ($validator->fails()) {
                    return response()->json([
                        'status'=>false,
                        'error'=>$validator->errors()->first()
                    ]);
                }

            //    if($request->image){
            //      $dir = 'profile_image/';
            //      $image_path = $this->image_upload($request->image, $dir);
                 
            //     }

                if ($request->hasFile('image')) {
                    $commonController = app(CommonController::class);
                    $uploadResult = $commonController->upload($request);
                    $uploadResultArray = $uploadResult->getData(true);

                    if ($uploadResultArray['status'] === 'error') {
                        return response()->json([
                            'status'  => 'error',
                            'message' => $uploadResultArray['message']
                        ], 400);
                    }

                    $imageUrl = $uploadResultArray['data']['url'];
                }

                $data = User::where('id', $user->id)->update([
                    'full_name'     => $request->full_name,
                    'profile_image' => $imageUrl ?? $request->old_image,
                ]);

                    return response()->json([
                        'status'=>true,
                        'message' => __('user_messages.profile_updated_successfully'),
                    ]);


             }
    
    }

    public function changePassword(Request $request){
        if($request->isMethod('get')){
                    return view('user.profile.changePassword');
        }else{
            
               $rules = [
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password', 
        ];

        $messages = [
            'old_password.required'     => __('user_messages.please_enter_old_password'),
            'new_password.required'     => __('user_messages.please_enter_new_password'),
            'new_password.min'          => __('user_messages.new_password_min_8_chars'),
            'new_password.regex'        => __('user_messages.new_password_regex'),
            'confirm_password.required' => __('user_messages.please_confirm_new_password'),
            'confirm_password.same'     => __('user_messages.passwords_do_not_match'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
               return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()
               ]);
        }

        $request_data = (object )[
            'id'=>$request->user()->id,
            'old_password'=>$request->old_password,
            'new_password'=>$request->new_password,
        ];

        $data = $this->UserProfileService->ChangePassword($request_data);
        
        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);

        }

        return response()->json([
            'status'=>true,
            'message'=>$data['message']
        ]);
     
        }
    }


    public function oldNumberSendOtp(Request $request)
{
    $for = $request->input('for');
    $type = $request->input('type');

     if ($for === 'mobile') {
            $rules = [
                'country_code' => 'required|string|max:10',
                'mobile'       => ['required', 'regex:/^[0-9]{7,15}$/', 'string', 'max:20'],
                'type'         => 'required|in:0,1',
            ];

            $messages = [
                'country_code.required' => __('affiliate_messages.please_enter_country_code'),
                'mobile.required'       => __('affiliate_messages.please_enter_mobile_number'),
                'mobile.regex'          => __('affiliate_messages.mobile_number_must_be_7_to_15_digits'),
                'type.required'         => __('affiliate_messages.please_specify_old_or_new_number'),
                'type.in'               => __('affiliate_messages.type_must_be_old_or_new'),
            ];

        
            if ($request->type == '0') {
                $rules['mobile'][] = Rule::exists('users', 'mobile')
                    ->where('country_code', $request->country_code);
            } else {
                $rules['mobile'][] = Rule::unique('users', 'mobile')
                    ->where('country_code', $request->country_code);
            }

        } elseif ($for === 'email') {

            $rules = [
                'email' => ['required', 'email'],
                'type'  => 'required|in:0,1',
            ];

            $messages = [
                'email.required' => __('affiliate_messages.please_enter_email_address'),
                'email.email'    => __('affiliate_messages.please_enter_valid_email_address'),
                'type.required'  => __('affiliate_messages.please_specify_old_or_new_email'),
                'type.in'        => __('affiliate_messages.type_must_be_old_or_new_email'),
            ];

            if ($request->type == '0') {
                $rules['email'][] = Rule::exists('users', 'email');
            } else {
                $rules['email'][] = Rule::unique('users', 'email');
            }

        } else {
            return redirect()->back()->with('error', 'Invalid "for" value. Use either "mobile" or "email"');
        }


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $firstError = $validator->errors()->first();
            return redirect()->back()->with('error', $firstError)->withInput();
        }  



    $user = $request->user();
    $otp = config('services.otp');

    UserContactChangeHistory::where('user_id', $user->id)->update(['status' => '1']);

    if ($for === 'mobile') {

        if ($type == '0') {
            if (
                $user->country_code === $request->country_code &&
                $user->mobile === $request->mobile
            ) {
                $data = UserContactChangeHistory::create([
                    'user_id'      => $user->id,
                    'country_code' => $request->country_code,
                    'mobile'       => $request->mobile,
                    'otp'          => $otp,
                    'type'         => '0',
                    'status'       => '0',
                ]);

                 $phone = $user->country_code . $user->mobile;
                $message = "Your verification Code Is $otp";
                if (preg_match('/^\+[1-9]\d{6,14}$/', $phone)) {
                                try {
                                    $this->TwilioService->sendOtp($phone, $message);
                                } catch (\Exception $e) {
                                    // ❌ silently skip (no return, no error)
                                    // Optional: log for debugging
                                    //\Log::warning('Twilio SMS skipped: ' . $e->getMessage());
                                }
                            }

                return redirect()->route('userOldNumberVerify', [
                    'country_code' => $user->country_code,
                    'mobile'       => $user->mobile,
                    'id'           => encrypt($data->id),
                    'type'         => '0',
                    'for'          => 'mobile',
                ])->with('success', __('user_messages.otp_sent_successfully_old_mobile'));
                
            }

            return redirect()->back()->with('error', "Old mobile number doesn't match our records.");
        }

        if ($type == '1') {
            $data = UserContactChangeHistory::create([
                'user_id'      => $user->id,
                'country_code' => $request->country_code,
                'mobile'       => $request->mobile,
                'otp'          => $otp,
                'type'         => '1',
                'status'       => '0',
            ]);

            $phone = $data->country_code . $data->mobile;
            $message = "Your verification Code Is $otp";
            if (preg_match('/^\+[1-9]\d{6,14}$/', $phone)) {
                try {
                    $this->TwilioService->sendOtp($phone, $message);
                } catch (\Exception $e) {
                    // ❌ silently skip (no return, no error)
                    // Optional: log for debugging
                    //\Log::warning('Twilio SMS skipped: ' . $e->getMessage());
                }
            }

            return redirect()->route('userOldNumberVerify', [
                'country_code' => $data->country_code,
                'mobile'       => $data->mobile,
                'id'           => encrypt($data->id),
                'type'         => '1',
                'for'          => 'mobile',
            ])->with('success', __('user_messages.otp_sent_successfully_new_mobile'));

        }
    }

    if ($for === 'email') {
        if ($type == '0') {
            if ($user->email !== $request->email) {
                return redirect()->back()->with('error', __('user_messages.old_email_not_match'));
            }

            $data = UserContactChangeHistory::create([
                'user_id' => $user->id,
                'email'   => $request->email,
                'otp'     => $otp,
                'type'    => '1',
                'status'  => '0',
            ]);

            $check = User::where('email', $data->email)->first();
            Mail::to($data->email)->send(new UserOtpMail($check, $otp));

            return redirect()->route('userOldNumberVerify', [
                'email' => $data->email,
                'id'    => encrypt($data->id),
                'type'  => '0',
                'for'   => 'email',
            ])->with('success', __('user_messages.otp_sent_successfully_old_email'));

        }

        if ($type == '1') {
            $data = UserContactChangeHistory::create([
                'user_id' => $user->id,
                'email'   => $request->email,
                'otp'     => $otp,
                'type'    => '1',
                'status'  => '0',
            ]);

            $check = User::where('email', $data->email)->first();
            Mail::to($data->email)->send(new UserOtpMail($check, $otp));

            return redirect()->route('userOldNumberVerify', [
                'email' => $data->email,
                'id'    => encrypt($data->id),
                'type'  => '1',
                'for'   => 'email',
            ])->with('success', __('user_messages.otp_sent_successfully_new_email'));

        }
    }

    return redirect()->back()->with('error', 'Something went wrong. Please try again.');
}




    public function oldNumberVerify(Request $request){
          if($request->isMethod('get')){
                    return view('user.profile.profileChangeNumberOtp');
        }else{
         
        $validator = Validator::make($request->all(), [
                'id'  => 'required',
                'otp' => 'required|array',
                'otp.*' => 'required|digits:1',
            ], [
                'id.required' => __('user_messages.verification_id_missing'),
                'otp.required' => __('user_messages.please_enter_otp'),
                'otp.*.required' => __('user_messages.please_enter_all_otp_digits'),
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'error'  => $validator->errors()->first(),
                ]);
            }

  
        try {
            $id = decrypt($request->id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect()->back()->with('error', 'Invalid or expired verification link.');
        }

        $request->merge(['id' => $id]);
         $request->merge([
                'otp' => implode('', $request->otp)
            ]);



        $data = $this->UserProfileService->verifyOtp($request);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);

        }

        
        return response()->json([
            'status'=>true,
            'message'=>$data['message'],
        ]);

        }
    }


    
    
    public function updateNewNumber(Request $request){
               if($request->isMethod('get')){
                  $country =   all_countrie::where('status',1)->get();
                    return view('user.profile.profileChangeNumber', compact('country'));
        }
    }


    public function updateEmailAddress(){
                    return view('user.profile.profileChangeEmailOtp');  
    }


 public function updateResendOtp(Request $request)
{
    try {
        // Ensure the ID is present
        if (!$request->has('id')) {
            return response()->json([
                'status' => false,
                'message' => 'ID is required.',
            ], 400);
        }

        $id = decrypt($request->id);

        
        $data = UserContactChangeHistory::find($id);
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 404);
        }

        $otp = config('services.otp');
        $data->otp = $otp;
        $data->save();
        if(!empty($data->mobile)){
         $phone = $data->country_code . $data->mobile;
            $message = "Your verification Code Is $otp";
            if (preg_match('/^\+[1-9]\d{6,14}$/', $phone)) {
                try {
                    $this->TwilioService->sendOtp($phone, $message);
                } catch (\Exception $e) {
                    // ❌ silently skip (no return, no error)
                    // Optional: log for debugging
                    //\Log::warning('Twilio SMS skipped: ' . $e->getMessage());
                }
            }
        }else{

            $check = User::where('email', $data->email)->first();
            Mail::to($data->email)->send(new UserOtpMail($check, $otp));
        }


        return response()->json([
            'status' => true,
            'message' => __('user_messages.otp_resent_successfully'),
            'otp' => $otp,
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong: ' . $e->getMessage(),
        ], 500);
    }
}

// save currenct location

 public function saveCurrentLocation(Request $request)
{

    if ($request->user() && $request->user()->id) {
        $data = UserCurrentLocation::updateOrCreate(
            ['user_id' => $request->user()->id],
            [
                'latitude'  => $request->latitude,
                'longitude' => $request->longitude,
                'address'   => $request->address,
            ]
        );

        return response()->json([
            'status'  => true,
            // 'message' => 'Address changed successfully!',
            'message' => __('user_messages.address_changed_successfully'),
            'data'    => $data,
        ]);
    }

        return response()->json([
            'status'  => false,  
            'message' => '',
        ]);

}

    public function saved_cards(REQUEST $request){
        $user = $request->user();
        $userId = $user->id;
        $request_data=(object)[
            'user_id'=>$userId,
        ];
        $data = $this->UserProfileService->GetMyCards($request_data)['data'];

        return view('user.savecard.index',compact('data'));
    }

    public function add_new_card(REQUEST $request){

        return view('user.savecard.add-new-card');
    }

    public function make_card_default(Request $request){

        try{

        $user = $request->user();
        $cardId = $request->card_id;
       
        $request_data=(object)[
            'user_id'=>$user->id,
            'card_id'=>$cardId,
        ];

        $data=$this->UserProfileService->MakeDefaultCard($request_data);


        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

        }catch(exception $e){
            return ApiResponse::generateResponse('error', $e->getMessage(),'', 400);
        }
    }

    public function delete_card(Request $request){

        try{

        $user = $request->user();
        $cardId = $request->card_id;
       
        $request_data=(object)[
            'card_id'=>$cardId,
        ];

        $data=$this->UserProfileService->DeleteCard($request_data);


        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

        }catch(exception $e){
            return ApiResponse::generateResponse('error', $e->getMessage(),'', 400);
        }
    }

    public function save_new_card(Request $request){

        try{

        $user = $request->user();
       
        $request_data=(object)[
            'user_id'=>$user->id,
            'card_holder_name'=>$request->card_holder_name,
            'card_number'=>$request->card_number,
            'expiry_date'=>$request->expiry_date,
            'cvv'=>$request->cvv,
            'is_future'=>$request->is_future,
        ];

        $data=$this->UserProfileService->AddCard($request_data);


        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

        }catch(exception $e){
            return ApiResponse::generateResponse('error', $e->getMessage(),'', 400);
        }
    }




}