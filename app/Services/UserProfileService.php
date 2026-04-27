<?php
namespace App\Services;
use App\Helpers\ApiResponse;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\UserContactChangeHistory;
use App\Models\UserCard;
use Hash;
use Illuminate\Support\Facades\DB;

class UserProfileService
{


    // change password
    function ChangePassword($request){
         $user = User::find($request->id);

        if (!$user) {
            return ['status'=>'error','message'=>"User not found",'data'=>(object)[]];    
        //    return ApiResponse::generateResponse('error','User not found',(object)[],401);
        }

        if (!Hash::check($request->old_password, $user->password)) {
             return ['status'=>'error','message'=>"Old Password is not correct",'data'=>(object)[]];
            // return ApiResponse::generateResponse("error", "Old password doesn't match",(object)[],400);
        }

        if (Hash::check($request->new_password, $user->password)) {
            return ['status'=>'error','message'=>"New password cannot be the same as the old password",'data'=>(object)[]];
            // return ApiResponse::generateResponse("error", "New password cannot be the same as the old password",(object)[],400);
        }


        $user->password = Hash::make($request->new_password);
        $user->save();
        CreateNotification([
                    'sender_id' => 1, 
                    'sender_type' => 1, 

                    'receiver_id' => $request->id,
                    'receiver_type' => 2, 

                    'title_english' => 'Password Update',
                    'description_english' => "Your login password has been updated successfully",

                    'notification_type' => 'password_update'
                ]);

        return ['status'=>'success','message'=>"Password changed successfully",'data'=>$user];
        // return ApiResponse::generateResponse("success", "Password changed successfully",(object)[], 201);
    }



    // verify otp

    public function verifyOtp($request){
        $userDetails = UserContactChangeHistory::find($request->id);

    
        if (!$userDetails) {
              return ['status'=>'error','message'=>"No User Found",'data'=>(object)[]];
            // return ApiResponse::generateResponse('error', 'No User Found', (object)[], 404);
        }


        // if ($userDetails->otp === $request->otp) {
        //     $userDetails->otp = null;
        //     $userDetails->otp_verify = '1';
        //     $userDetails->status = '1';
        //     $userDetails->save();
        //     $user = request()->user();
        //     $user->country_code = $userDetails->country_code;
        //     $user->mobile = $userDetails->mobile;
        //             // User::where('')
        //     return ['status'=>'success','message'=>"OTP verified successfully",'data'=>$userDetails];
        //     // return ApiResponse::generateResponse('success', 'OTP verified successfully', $userDetails, 201);
        // }


        if ($userDetails && $userDetails->otp === $request->otp) {
            $userDetails->otp = null;
            $userDetails->otp_verify = '1';
            $userDetails->status = '1';
            $userDetails->save();

            $user = request()->user();
            $user->country_code = $userDetails->country_code ?? $user->country_code;
            $user->mobile = $userDetails->mobile ?? $user->mobile;
            $user->email = $userDetails->email ?? $user->email;
            $user->save();

            return ['status' => 'success', 'message' => 'OTP verified successfully', 'data' => $userDetails];
        }



         return ['status'=>'error','message'=>"Invalid OTP. Please try again.",'data'=>(object)[]];
        // return ApiResponse::generateResponse('error', 'Invalid OTP. Please try again.', (object)[], 400);
    }

    // getSubCategory
    public function getSubCategories($request){

        if(isset($request->category_id)){
            $subCategory = SubCategory::where('category_id', $request->category_id)->where('status','1')->get();

        }else{
            $subCategory = SubCategory::where('status','1')->get();
        }
        
        if ($subCategory->isEmpty()) {
             return ['status'=>'success','message'=>"No sub categories found",'data'=>[]];
            // return ApiResponse::generateResponse('success', 'No sub categories found', (object)[], 200);
        }

        return ['status'=>'success','message'=>"Sub category list fetched successfully",'data'=>$subCategory];
        // return ApiResponse::generateResponse('success', 'Sub category list fetched successfully', $subCategory, 201);
    }


    // get categories
    public function getCategories($request){
        
        $category = Category::orderBy('id', 'asc')->where('status','1')->get();


        if ($category->isEmpty()) {
             return ['status'=>'success','message'=>"No categories found",'data'=>[]];
            // return ApiResponse::generateResponse('success', 'No sub categories found', (object)[], 200);
        }

        return ['status'=>'success','message'=>"Category list fetched successfully",'data'=>$category];
        // return ApiResponse::generateResponse('success', 'Sub category list fetched successfully', $subCategory, 201);
    }


    public function AddCard($request_data)
    {
        try {
            DB::beginTransaction();

             $exists = UserCard::where('user_id', $request_data->user_id)
                ->where('card_number', $request_data->card_number)
                ->first();

            if ($exists) {
                return [
                    'status' => 'error',
                    'message' => 'This card is already added',
                    'data' => (object)[]
                ];
            }

            // if is_future = 1, make others 0
            if ($request_data->is_future == 1) {
                UserCard::where('user_id', $request_data->user_id)
                    ->update(['is_future' => 0]);
            }

            // ================= CARD TYPE DETECTION =================
            $cardNumber = preg_replace('/\D/', '', $request_data->card_number);

            if (preg_match('/^4/', $cardNumber)) {
                $cardType = 'Visa';
            } elseif (
                preg_match('/^5[1-5]/', $cardNumber) ||
                preg_match('/^2(2[2-9]|[3-6]|7[01]|720)/', $cardNumber)
            ) {
                $cardType = 'MasterCard';
            } elseif (preg_match('/^3[47]/', $cardNumber)) {
                $cardType = 'American Express';
            } elseif (preg_match('/^6/', $cardNumber)) {
                $cardType = 'Discover';
            } else {
                $cardType = 'Unknown';
            }

            $card = UserCard::create([
                'user_id'          => $request_data->user_id,
                'card_holder_name' => $request_data->card_holder_name,
                'card_number'      => $request_data->card_number,
                'expiry_date'      => $request_data->expiry_date,
                'cvv'              => $request_data->cvv,
                'is_future'        => $request_data->is_future,
                'card_type'        => $cardType,
                
            ]);

            DB::commit();

            return [
                'status' => 'success',
                'message' => 'Card added successfully',
                'data' => $card
            ];

        } catch (\Exception $e) {
            DB::rollBack();


            return [
                'status' => 'error',
                'message' => 'Failed to add card',
                'data' => []
            ];
        }
    }


    public function GetMyCards($request_data)
    {
        try {
            $cards = UserCard::where('user_id', $request_data->user_id)
                ->orderBy('id', 'desc')
                ->get();

            if ($cards->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No cards found',
                    'data' => []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Cards fetched successfully',
                'data' => $cards
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Failed to fetch cards',
                'data' => []
            ];
        }
    }


    public function DeleteCard($request_data)
    {
        try {
            $card = UserCard::where('id', $request_data->card_id)->first();

            if (!$card) {
                return [
                    'status' => 'error',
                    'message' => 'Card not found',
                    'data' => []
                ];
            }

            $card->delete();

            return [
                'status' => 'success',
                'message' => 'Card deleted successfully',
                'data' => (object)[]
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Failed to delete card',
                'data' => []
            ];
        }
    }

    public function MakeDefaultCard($request_data)
    {
        try {
            $card = UserCard::where('id', $request_data->card_id)
                            ->where('user_id', $request_data->user_id)
                            ->first();

            if (!$card) {
                return [
                    'status' => 'error',
                    'message' => 'Card not found',
                    'data' => []
                ];
            }

            UserCard::where('user_id', $request_data->user_id)
                    ->update(['is_future' => '0']);

            $card->is_future = '1';
            $card->save();

            return [
                'status' => 'success',
                'message' => 'Card updated to default successfully',
                'data' => $card
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Failed to make default card',
                'data' => []
            ];
        }
    }
    





}