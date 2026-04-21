<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\UserDashboardService;
use App\Services\NotificationManagementService;
use App\Services\StoryManagementService;
use App\Services\TicketService;
use App\Services\CMSManagementService;
use Illuminate\Support\Facades\Session;
use App\Helpers\ApiResponse;
use Validator;
use App\Http\Controllers\CommonController;

use App\Models\LiveRequest;

use Carbon\Carbon;



class DashBoardController extends Controller
{

    public function __construct(UserDashboardService $UserDashboardService,NotificationManagementService $NotificationManagementService, StoryManagementService $StoryManagementService, TicketService $TicketService, CMSManagementService $CMSManagementService)
    {
        $this->UserDashboardService = $UserDashboardService;
        $this->NotificationManagementService = $NotificationManagementService;
        $this->StoryManagementService = $StoryManagementService;
        $this->TicketService = $TicketService;
        $this->CMSManagementService = $CMSManagementService;
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

    public function get_seller_story(Request $request)
    {

        try {

            // $user=  $request->user();
            $request_data = (object)[
                    'seller_id' =>  $request->seller_id,
                ];

            // $data = $this->StoryManagementService->getSellerStoryOnUser($request_data);
            $data = $this->StoryManagementService->getSellerStoryOnUser($request_data);
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

    public function get_seller_highlight(Request $request)
    {

        try {

            // $user=  $request->user();
            $request_data = (object)[
                    'seller_id' =>  $request->seller_id,
                ];

            $data = $this->StoryManagementService->getSellerHighlightOnUser($request_data);
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

    public function add_remove_reel_to_whishlist(Request $request)
    {
        try {
            $user = $request->user();
            if (!$user) {
                return ApiResponse::generateResponse(
                    'error',
                    'Please login to add to wishlist',
                    (object)[],
                    401
                );
            }

            $validate = Validator::make($request->all(), [
                'reel_id' => 'required|exists:reels,id',
            ]);

            if ($validate->fails()) {
                return ApiResponse::generateResponse(
                    'error',
                    $validate->errors()->first(),
                    $validate->errors()->first(),
                    422
                );
            }

            $request_data = (object)[
                'user_id' => $user->id,
                'reel_id' => $request->reel_id,
            ];

            $data = $this->StoryManagementService->addRemoveReelToWhislist($request_data);

            return response()->json([
                'status' => 'success',
                'message' => $data['message'],
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

    public function support(REQUEST $request){
       // dd(123);

        $user = $request->user();

        $request_data=(object) [
        'sender_id'=>$user->id,
        'sender_type'=>1,
        'search'=>$request->search??null,
        'limit'=>10,
        ];

        $tickets =  $this->TicketService->getTickets($request_data)['data'];
        //dd($tickets);
        $commonController = new CommonController();
        $ticketTypesResponse = $commonController->ticket_types($request);
        $ticketTypes = $ticketTypesResponse->original['data'];
        //dd($ticketTypes);
        $request_data1 = new Request([
            'type' => 1,
        ]);
        $contactUsResponse = $commonController->contact_us($request_data1);
        $ContactUs = $contactUsResponse->original['data'];
        //dd($ContactUs);

        return view('user.support.index',compact('tickets','ticketTypes','ContactUs'));
    }

    public function raise_ticket(REQUEST $request){

        $validator = Validator::make($request->all(), [
            'file' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ], [
            'file.mimes' => 'File must be in JPEG, PNG, JPG, GIF, SVG format',
            'file.max' => 'Image size should not exceed 5MB',
        ]);

        $user = $request->user();

        if($request->hasFile('file')){
            $commonController = new CommonController();
            $uploadResult = $commonController->uploadFile($request);
            $uploadResultArray = $uploadResult->getData(true); 

            if ($uploadResultArray['status'] === 'error') {
                return response()->json(['success' => false, 'message' => $uploadResultArray['message']]);
            }

            $imageUrl = $uploadResultArray['data']['url'];
           // dd($imageUrl);
        }
        

        $request_data=(object) [
        'sender_id'=>$user->id,
        'sender_type'=>1,
        'file'=>$imageUrl??null,
        'ticket_type_id'=>$request->ticket_type_id,
        'title'=>$request->title,
        'description'=>$request->description,
        ];

        $data=  $this->TicketService->raiseTicket($request_data);
        //dd($stories);

        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
    }


     public function getLiveSellerRecords(REQUEST $request){

            $data = $this->UserDashboardService->UserSidelive_room_records();

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            $live_records=$data['data'];

            return view('user.liveSeller.index',compact('live_records'));
     }

      public function ViewLiveSellerRecords(Request $request)
    {
       
        return view('user.liveSeller.UserJoinLive');
        
    }


    


public function checkLiveJoinTimeStatus($id)
{

    $live = LiveRequest::with('timeslot_details')->find($id);

    $currentTime = Carbon::now();

    $fromTime = Carbon::createFromFormat('h:i A', $live->timeslot_details->from);
    $toTime   = Carbon::createFromFormat('h:i A', $live->timeslot_details->to);

    $isLive = $currentTime->between($fromTime, $toTime);

    return response()->json([
        'live' => $isLive
    ]);
}

    public function aboutUs(REQUEST $request){

        $request_data = (object)[
                'type'        => '1',
            ];

       $data = $this->CMSManagementService->GetAboutUs($request_data)['data'];
        return view('user.cms-page.about',compact('data'));
    }

    public function termCondition(REQUEST $request){

        $request_data = (object)[
                'type'        => '1',
            ];

       $data = $this->CMSManagementService->GetTermConditions($request_data)['data'];
        return view('user.cms-page.terms',compact('data'));
    }

    public function returnPolicy(REQUEST $request){

        $request_data = (object)[
                'type'        => '1',
            ];

       $data = $this->CMSManagementService->GetReturnPolicy($request_data)['data'];
        return view('user.cms-page.return',compact('data'));
    }

    public function exchangePolicy(REQUEST $request){

        $request_data = (object)[
                'type'        => '1',
            ];

       $data = $this->CMSManagementService->GetExchangePolicy($request_data)['data'];
        return view('user.cms-page.exchange',compact('data'));
    }

    public function cancellationPolicy(REQUEST $request){

        $request_data = (object)[
                'type'        => '1',
            ];

       $data = $this->CMSManagementService->GetCancellationPolicy($request_data)['data'];
        return view('user.cms-page.cancellation',compact('data'));
    }

    public function faq(REQUEST $request){

        $request_data = (object)[
                'type'        => '1',
            ];

       $data = $this->CMSManagementService->GetFaq($request_data)['data'];
       //dd($data);
        return view('user.cms-page.faq-list',compact('data'));
    }


}