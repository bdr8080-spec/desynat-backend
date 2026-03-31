<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\UserDashboardService;
use App\Services\NotificationManagementService;
use App\Services\StoryManagementService;
use Illuminate\Support\Facades\Session;
use App\Helpers\ApiResponse;
use Validator;


class DashBoardController extends Controller
{

    public function __construct(UserDashboardService $UserDashboardService,NotificationManagementService $NotificationManagementService, StoryManagementService $StoryManagementService)
    {
        $this->UserDashboardService = $UserDashboardService;
        $this->NotificationManagementService = $NotificationManagementService;
        $this->StoryManagementService = $StoryManagementService;
    }


    public function headerSearch(Request $request)
    {
       // dd($request->all());

        try {

            $user=  $request->user();
            $request_data = (object)[
                    'user_id' => $user ? $user->id : null,
                    'search'        => $request->search,
                ];

            $data = $this->UserDashboardService->HomePageSearchWeb($request_data);
       

            $message = $data['message'];

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to search',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getSearchData(Request $request)
    {
       // dd($request->all());

        try {

            $user=  $request->user();
            $request_data = (object)[
                    'user_id' =>  $user->id,
                ];

            $data = $this->UserDashboardService->HomeRecentSearchList($request_data);
            
            $message = $data['message'];

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to search',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    


    public function getRecommandedlatestSearch(Request $request)
    {
       // dd($request->all());

        try {

            $user=  $request->user();
            $request_data = (object)[
                    'user_id' =>  $user->id,
                ];

            $data = $this->UserDashboardService->Recommanded_HomeRecentSearchList($request_data);
            
            $message = $data['message'];

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to search',
                'error' => $e->getMessage()
            ], 500);
        }
    }


        public function getlatestSearch(Request $request)
    {
       // dd($request->all());

        try {

            $user=  $request->user();
            $request_data = (object)[
                    'user_id' =>  $user->id,
                ];

            $data = $this->UserDashboardService->RecentSearch_dateGet($request_data);
            
            $message = $data['message'];

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to search',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function mark_notification_as_read(Request $request){

        try{

            $validate = Validator::make($request->all(), [
            'notification_id' => 'required|exists:notifications,id',
        ]);
        
       if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
       }

            
        $user = $request->user();
       
       $request_data=(object)[
        'user_id'=>$user->id,
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

    public function get_admin_story(Request $request)
    {

        try {

            // $user=  $request->user();
            // $request_data = (object)[
            //         'user_id' =>  $user->id,
            //     ];

            $data = $this->StoryManagementService->getAdminStoryOnUser($request);
            //dd($data);
            
            $message = $data['message'];

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get story',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}