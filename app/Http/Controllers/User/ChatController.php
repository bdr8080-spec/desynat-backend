<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\UserFirebaseService;
use App\Helpers\ApiResponse;
use App\Http\Controllers\CommonController;

use Validator;

class ChatController extends Controller
{
 
    public function __construct(UserFirebaseService $UserFirebaseService)
    {
        $this->UserFirebaseService = $UserFirebaseService;
    }

    public function allChats(Request $request){ 

         $user=  $request->user();

        $data = (object)[
            'user_id' => $user->id,
        ];

        $chatData = $this->UserFirebaseService->userGetAllChatsRecords($data)['data'];
         //dd($chatData);

        return view('user.chat.chatlists',compact('chatData'));

    }

    public function userChat(Request $request, $id){ 

        return view('user.chat.userChat');

    }

    public function chatDetails(Request $request){ 

        return view('user.chat.detailsChat');

    }












}