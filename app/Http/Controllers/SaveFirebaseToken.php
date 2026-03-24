<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\User;



class SaveFirebaseToken extends Controller
{
    
    public function saveUserToken(Request $request)
    {
            $userId =$request->user()->id;
            $user = User::find($userId);

        if ($user) {
            $user->fcm_token = $request->token;
            $user->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'User not found'], 404);
    }


}