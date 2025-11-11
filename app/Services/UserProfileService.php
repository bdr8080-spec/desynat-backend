<?php
namespace App\Services;
use App\Helpers\ApiResponse;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\UserContactChangeHistory;
use Hash;

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
        $subCategory = SubCategory::where('category_id', $request->category_id)->get();

        if ($subCategory->isEmpty()) {
             return ['status'=>'success','message'=>"No sub categories found",'data'=>[]];
            // return ApiResponse::generateResponse('success', 'No sub categories found', (object)[], 200);
        }

        return ['status'=>'success','message'=>"Sub category list fetched successfully",'data'=>$subCategory];
        // return ApiResponse::generateResponse('success', 'Sub category list fetched successfully', $subCategory, 201);
    }


    // get categories
    public function getCategories($request){
        
        $category = Category::orderBy('name', 'asc')->get();


        if ($category->isEmpty()) {
             return ['status'=>'success','message'=>"No categories found",'data'=>[]];
            // return ApiResponse::generateResponse('success', 'No sub categories found', (object)[], 200);
        }

        return ['status'=>'success','message'=>"Category list fetched successfully",'data'=>$category];
        // return ApiResponse::generateResponse('success', 'Sub category list fetched successfully', $subCategory, 201);
    }





}