<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;
use Validator;


use App\Services\NotificationManagementService;


class ApiNotificationController extends Controller
{

    public function __construct(NotificationManagementService $NotificationManagementService){
        $this->NotificationManagementService=$NotificationManagementService;
    }


    public function userNotification(Request $request){

        try{

        $user_id= $request->user()->id;
       
       $request_data=(object)[
        'user_id'=>$user_id,
       ];

    $data=$this->NotificationManagementService->getUserNotifications($request_data);


    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }catch(exception $e){
        return ApiResponse::generateResponse('error', $e->getMessage(),'', 400);
    }

}

 public function CountUserNotification(Request $request){

        try{

        $user_id= $request->user()->id;
       
       $request_data=(object)[
        'user_id'=>$user_id,
       ];

    $data=$this->NotificationManagementService->CountgetUserNotifications($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }catch(exception $e){
        return ApiResponse::generateResponse('error', $e->getMessage(),'', 400);
    }

}


public function ReaduserNotification(Request $request){

        try{

            $validate = Validator::make($request->all(), [
            'notification_id' => 'required|exists:notifications,id',
        ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

            
        $user_id= $request->user()->id;
       
       $request_data=(object)[
        'user_id'=>$user_id,
        'notification_id' => $request->notification_id
       ];

    $data=$this->NotificationManagementService->ReaduserNotification($request_data);


    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }catch(exception $e){
        return ApiResponse::generateResponse('error', $e->getMessage(),'', 400);
    }

}

 public function affiliateUserNotification(Request $request){

        try{

        $user_id= $request->user()->id;
       
       $request_data=(object)[
        'user_id'=>$user_id,
       ];

    $data=$this->NotificationManagementService->getAffiliateUserNotifications($request_data);


    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }catch(exception $e){
        return ApiResponse::generateResponse('error', $e->getMessage(),'', 400);
    }

}


 public function affiliateUserNotificationCount(Request $request){

        try{

        $user_id= $request->user()->id;
       
       $request_data=(object)[
        'user_id'=>$user_id,
       ];

    $data=$this->NotificationManagementService->getAffiliateUserNotificationsCount($request_data);


    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }catch(exception $e){
        return ApiResponse::generateResponse('error', $e->getMessage(),'', 400);
    }

}


public function ReadAffiliateUserNotification(Request $request){

        try{

            $validate = Validator::make($request->all(), [
            'notification_id' => 'required|exists:notifications,id',
        ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

            
        $user_id= $request->user()->id;
       
       $request_data=(object)[
        'user_id'=>$user_id,
        'notification_id' => $request->notification_id
       ];

    $data=$this->NotificationManagementService->ReadAffiliateUserNotification($request_data);


    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }catch(exception $e){
        return ApiResponse::generateResponse('error', $e->getMessage(),'', 400);
    }

}


public function sendDummynotification(Request $request){

        try{

            $validate = Validator::make($request->all(), [
            'fcm_token' => 'required',
            'title' => 'required',
            'content' => 'required',
            
        ]);
        
    if($validate->fails()){
    return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }
    

    $data = sendPushNotificationNew($request->fcm_token, $request->title, $request->content,'1','2');



    return ApiResponse::generateResponse('success', 'notification send ',$data, 200);

    }catch(exception $e){
        return ApiResponse::generateResponse('error', $e->getMessage(),'', 400);
    }

}



}