<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Helpers\ApiResponse;
use App\Services\LiveRequestService;


use Validator;

class AdminLiveStreamController extends Controller
{
      public function __construct(LiveRequestService $LiveRequestService){

        $this->LiveRequestService=$LiveRequestService;

    }

    public function sellerlivestreamManagemnt(Request $request){


         $result = $this->LiveRequestService->LiveStreminigRequest($request);

        if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
        }

        $sellerLive=$result['data'];

        return view('admin.seller-live.index',compact('sellerLive'));
        
    }






}