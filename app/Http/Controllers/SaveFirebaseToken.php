<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\User;
use App\Models\Admin;
use App\Models\seller;
use App\Models\AffilatedUser;



class SaveFirebaseToken extends Controller
{
    
    public function saveUserToken(Request $request)
    {
            $userId =$request->user()->id;
            //dd($userId);
            $user = User::find($userId);

        if ($user) {
            $user->fcm_token = $request->token;
            $user->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'User not found'], 404);
    }

    public function saveAdminToken(Request $request)
    {
            $userId =Auth::guard('admin')->user()->id;
           // dd($userId);
            $user = Admin::find($userId);

        if ($user) {
            $user->fcm_token = $request->token;
            $user->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'User not found'], 404);
    }

    public function saveSellerToken(Request $request)
    {
            $userId =Auth::guard('seller')->user()->id;
           // dd($userId);
            $user = seller::find($userId);

        if ($user) {
            $user->fcm_token = $request->token;
            $user->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'User not found'], 404);
    }

    public function saveAffiliateToken(Request $request)
    {
            $userId =Auth::guard('affilated_user')->user()->id;
           // dd($userId);
            $user = AffilatedUser::find($userId);

        if ($user) {
            $user->fcm_token = $request->token;
            $user->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'User not found'], 404);
    }


}