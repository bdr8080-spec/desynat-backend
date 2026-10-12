<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\seller;
use App\Models\color;


use App\Models\SellerSubcriptionPlanBuy;

use App\Helpers\ApiResponse;


use Validator;


use App\Services\SellerAuthService;
use App\Services\StoryManagementService;
use App\Services\TicketService;
use App\Services\SellerDashboardService;


class SellerDashboardController extends Controller
{

    public function __construct(SellerAuthService $SellerAuthService, StoryManagementService $StoryManagementService, TicketService $TicketService, SellerDashboardService $SellerDashboardService){

        $this->SellerAuthService=$SellerAuthService;
        $this->StoryManagementService=$StoryManagementService;
        $this->TicketService=$TicketService;
        $this->SellerDashboardService=$SellerDashboardService;

    }

    public function index(Request $request){

        $user_details=$request->user();


        $seller_details=seller::with('store_info','owner_document','store_document','seller_bank_details','subcription_plan')->where('id',$user_details->id)->first();
        
        return ApiResponse::generateResponse('success','Seller Dashboard fetch Successfully',$seller_details, 200);


    }

    public function dashboard_data(Request $request){

        $seller_details=$request->user()->id;
         $request_data = (object)[
                'seller_id' => $seller_details,
                'from_date' => $request->from_date??null,
                'to_date' => $request->to_date??null,
                'filter' => $request->filter??null,
                'from_date_analytics' => $request->from_date_analytics??null,
                'to_date_analytics' => $request->to_date_analytics??null,
            ];
  
          $data= $this->SellerDashboardService->GetDashboardData($request_data);

          if(isset($data['status']) && $data['status']=='error' ){
              return ApiResponse::generateResponse('error', $data['message'],$data['data'],400);
          }
  
          return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
  
    }

    




    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::generateResponse('success','Logged out successfully',(object)[], 200);
    }



    public function all_plans(Request $request){

        $seller_details=$request->user();

        $seller_details=seller::with('store_info','owner_document','store_document','seller_bank_details')->where('id',$seller_details->id)->first();

        $request_data=(object )[
            'seller_id'=>$seller_details->id,
            'country_id' =>$seller_details->store_info->country
        ];

      $data= $this->SellerAuthService->seller_allPlan($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],[],400);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    
    }

    

    public function single_plans_show(Request $request , $id){

        $request_data=(object )[
            'plan_id'=>$id,
        ];

      $data= $this->SellerAuthService->seller_single_allPlan($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }

    public function create_subcription_plan_buy(Request $request){

        
        $validate = Validator::make($request->all(), [
            'plan_id' => 'required|exists:plans,id',
        ]);


        if($validate->fails()){
            return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
           }


        $seller_details=$request->user();

        $seller_details=seller::with('store_info','owner_document','store_document','seller_bank_details')->where('id',$seller_details->id)->first();

        $tranasaction_id='Tran'.rand(1111111111111,9999999999999);

        $request_data=(object )[
            'transaction_id'=>$tranasaction_id,
            'seller_id'=>$seller_details->id,
            'plan_id' =>$request->plan_id,
            "payment_method"=>$request->payment_method??'online',
            'payment_status'=>'0',
        ];

      $data= $this->SellerAuthService->create_Subcription_Order($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    
    }

    



    public function payment_subcription_plan(Request $request){

        
        $validate = Validator::make($request->all(), [
            'transaction_id' => 'required|exists:seller_subcription_plan_buys,transaction_id',
            'payment_status'=>"required|in:1,2"
        ]);


        if($validate->fails()){
            return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
           }

        $request_data=(object )[
            'transaction_id'=>$request->transaction_id,
            'payment_status'=>$request->payment_status,
            'online_transaction_id'=>$request->online_transaction_id??null
        ];

      $data= $this->SellerAuthService->complete_Subcription_Order($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }


    public function seller_profile(Request $request){

        $user_details=$request->user();

     $seller_details = seller::with([
        'store_info' => function ($query) {
            $query->withAvg('store_review as store_rating', 'store_rating');
        },
        'owner_document',
        'store_document',
        'seller_bank_details',
        'subcription_plan',
        'store_info.store_review'
    ])
    ->where('id', $user_details->id)
    ->first();



        return ApiResponse::generateResponse('success','Seller Dashboard fetch Successfully',$seller_details, 200);


    }


    public function store_on_off(Request $request){

        $user_details=$request->user();
   
        $request_data=(object )[
            'seller_id'=>$user_details->id,
        ];

     $data= $this->SellerAuthService->seller_storeOnOff($request_data);
      
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);


    }


    public function upload_color(){

      $colors = include app_path('Helpers/color.php');

        foreach($colors as $key=>$value){
            $data=[
                'name'=>$key,
                'hex_code'=>$value
            ];

            color::updateOrCreate($data);
        }

          $color=  color::all();

        return ApiResponse::generateResponse('success',"All Color fetch Successfully",$color, 200);

    }

    public function renew_subcription_plan_buy(Request $request){

        
        $validate = Validator::make($request->all(), [
            'plan_id' => 'required|exists:plans,id',
        ]);


        if($validate->fails()){
            return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
           }


        $seller_details=$request->user();

        $seller_details=seller::with('store_info','owner_document','store_document','seller_bank_details')->where('id',$seller_details->id)->first();

        $tranasaction_id='Tran'.rand(1111111111111,9999999999999);

        $request_data=(object )[
            'transaction_id'=>$tranasaction_id,
            'seller_id'=>$seller_details->id,
            'plan_id' =>$request->plan_id,
            "payment_method"=>$request->payment_method??'online',
            'payment_status'=>'0',
        ];

      $data= $this->SellerAuthService->renew_Subscription_Order($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    
    }

    public function my_plans(Request $request){

        $seller_details=$request->user();

        $seller_details=seller::with('store_info','owner_document','store_document','seller_bank_details')->where('id',$seller_details->id)->first();

        $request_data=(object )[
            'seller_id'=>$seller_details->id,
            'limit' =>$request->limit??10,
        ];

      $data= $this->SellerAuthService->seller_myPlan($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],(object)[],200);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    
    }

    public function add_story(Request $request){

      $validate = Validator::make($request->all(), [
            'file' => 'required',
            'is_promotional' => 'required|in:0,1',

            'start_date' => 'required_if:is_promotional,1|date',
            'total_days' => 'required_if:is_promotional,1|integer|min:1',
            'amount' => 'required_if:is_promotional,1|numeric|min:0',
        ], [
            'file.required' => __('seller_messages.file_required'),

            'is_promotional.required' => __('seller_messages.is_promotional_required'),
            'is_promotional.in' => __('seller_messages.is_promotional_invalid'),

            'start_date.required_if' => __('seller_messages.start_date_required'),
            'start_date.date' => __('seller_messages.start_date_invalid'),


            'total_days.required_if' => __('seller_messages.total_days_required'),
            'total_days.integer' => __('seller_messages.total_days_invalid'),

            'amount.required_if' => __('seller_messages.amount_required'),
            'amount.numeric' => __('seller_messages.amount_invalid'),
        ]);
    
        if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
        }

        $user_details=$request->user();
   
        $request_data = (object)[
            'seller_id'        => $user_details->id,
            'file'             => $request->file,
            'thumbnail'        => $request->thumbnail ?? null,

            'is_promotional'   => $request->is_promotional,
            'start_date'       => $request->start_date ?? null,
            'end_date'         => $request->end_date ?? null,
            'total_days'       => $request->total_days ?? null,
            'amount'           => $request->amount ?? null,
        ];

        $data= $this->StoryManagementService->addSellerStory($request_data);
      
        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        if(isset($data['status']) && $data['status']=='failed' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],499);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);


    }

    public function delete_story(Request $request){

      $validate = Validator::make($request->all(), [
        'story_id' => 'required|exists:stories,id',
        ]);
    
        if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
        }
   
        $request_data=(object )[
            'story_id'=>$request->story_id,
        ];

        $data= $this->StoryManagementService->deleteSellerStory($request_data);
      
        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);


    }

    public function add_reels(Request $request){

      $validate = Validator::make($request->all(), [
        'file' => 'required',
        'caption' => 'required',
        ],[
            'file.required' => __('seller_messages.file_required') ,
            // 'file.mimes' => __('seller_messages.file_invalid_format') ,
            // 'file.max' => __('seller_messages.file_size_exceed') ,
            'caption.required' => __('seller_messages.caption_required'),

        ]);
    
        if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
        }

        $user_details=$request->user();
   
        $request_data=(object )[
            'seller_id'=>$user_details->id,
            'file'=>$request->file,
            'caption'=>$request->caption,
            'thumbnail' => $request->thumbnail??null,
        ];

        $data= $this->StoryManagementService->addSellerReel($request_data);
      
        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        if(isset($data['status']) && $data['status']=='failed' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],499);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);


    }

    public function delete_highlight(Request $request){

      $validate = Validator::make($request->all(), [
        'highlight_id' => 'required|exists:highlights,id',
        ]);
    
        if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
        }
   
        $request_data=(object )[
            'highlight_id'=>$request->highlight_id,
        ];

        $data= $this->StoryManagementService->deleteSellerHighlight($request_data);
      
        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);


    }

    public function add_highlights(Request $request){

      $validate = Validator::make($request->all(), [
        'file' => 'required',
        'title' => 'required',
        ],[
            'file.required' => __('seller_messages.file_required') ,
            // 'file.mimes' => __('seller_messages.file_invalid_format') ,
            // 'file.max' => __('seller_messages.file_size_exceed') ,
            'title.required' => __('seller_messages.caption_required'),
        ]);
    
        if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
        }

        $user_details=$request->user();
   
        $request_data=(object )[
            'seller_id'=>$user_details->id,
            'file'=>$request->file,
            'title'=>$request->title,
            'thumbnail' => $request->thumbnail??null,
        ];

        $data= $this->StoryManagementService->addSellerHighlight($request_data);
      
        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        if(isset($data['status']) && $data['status']=='failed' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],499);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);


    }

    public function delete_reel(Request $request){

      $validate = Validator::make($request->all(), [
        'reel_id' => 'required|exists:reels,id',
        ]);
    
        if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
        }
   
        $request_data=(object )[
            'reel_id'=>$request->reel_id,
        ];

        $data= $this->StoryManagementService->deleteSellerReel($request_data);
      
        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);


    }

    public function update_reel(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'reel_id' => 'required|exists:reels,id',
            'file' => 'required',
            'caption' => 'required',
        ],[
            'file.required' => __('seller_messages.file_required') ,
            // 'file.mimes' => __('seller_messages.file_invalid_format') ,
            // 'file.max' => __('seller_messages.file_size_exceed') ,
            'caption.required' => __('seller_messages.caption_required'),

        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', $validate->errors()->first(), (object)[], 422);
        }

        $user_details = $request->user();

        $request_data = (object)[
            'reel_id' => $request->reel_id,
            'seller_id' => $user_details->id,
            'file' => $request->file,
            'caption' => $request->caption,
            'thumbnail' => $request->thumbnail??null,
        ];

        $data = $this->StoryManagementService->updateSellerReel($request_data);

        if (isset($data['status']) && $data['status'] == 'error') {
            return ApiResponse::generateResponse('error', $data['message'], (object)[], 400);
        }

        return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);
    }

    public function update_reel_status(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'reel_id' => 'required|exists:reels,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', $validate->errors()->first(), (object)[], 422);
        }

        $user_details = $request->user();

        $request_data = (object)[
            'reel_id' => $request->reel_id,
        ];

        $data = $this->StoryManagementService->updateSellerReelStatus($request_data);

        if (isset($data['status']) && $data['status'] == 'error') {
            return ApiResponse::generateResponse('error', $data['message'], (object)[], 400);
        }

        return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);
    }

     public function get_my_stories(Request $request)
    {

        $user_details = $request->user();

        $request_data = (object)[
            'seller_id' => $user_details->id,
            'limit' => $request->limit??null,
        ];

        $data = $this->StoryManagementService->getSellerStories($request_data);

        if (isset($data['status']) && $data['status'] == 'error') {
            return ApiResponse::generateResponse('error', $data['message'], (object)[], 400);
        }

        return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);
    }

     public function get_my_stories_today(Request $request)
    {

        $user_details = $request->user();

        $request_data = (object)[
            'seller_id' => $user_details->id,
           // 'limit' => $request->limit??null,
        ];

        $data = $this->StoryManagementService->getSellerStoryOnUser($request_data);

        if (isset($data['status']) && $data['status'] == 'error') {
            return ApiResponse::generateResponse('error', $data['message'], (object)[], 400);
        }

        return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);
    }

      public function get_my_reels(Request $request)
    {

        $user_details = $request->user();

        $request_data = (object)[
            'seller_id' => $user_details->id,
            'limit' => $request->limit??null,
        ];

        $data = $this->StoryManagementService->getSellerReels($request_data);

        if (isset($data['status']) && $data['status'] == 'error') {
            return ApiResponse::generateResponse('error', $data['message'], (object)[], 400);
        }

        return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);
    }

      public function get_my_highlights(Request $request)
    {

        $user_details = $request->user();

        $request_data = (object)[
            'seller_id' => $user_details->id,
            'limit' => $request->limit??null,
        ];

        $data = $this->StoryManagementService->getSellerHighlights($request_data);

        if (isset($data['status']) && $data['status'] == 'error') {
            return ApiResponse::generateResponse('error', $data['message'], (object)[], 400);
        }

        return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);
    }

    public function upload_story_from_gallery(Request $request){

      $validate = Validator::make($request->all(), [
        'file' => 'required',
        ],[
            'file.required' => __('seller_messages.file_required') ,

        ]);
    
        if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
        }

        $user_details=$request->user();
   
        $request_data=(object )[
            'seller_id'=>$user_details->id,
            'file'=>$request->file,
        ];

        $data= $this->StoryManagementService->uploadStoryFromGallery($request_data);
      
        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);


    }

    public function upload_highlight_from_gallery(Request $request){

      $validate = Validator::make($request->all(), [
        'file' => 'required',
        'title' => 'required',
        ],[
             'file.required' => __('seller_messages.file_required') ,
            // 'file.mimes' => __('seller_messages.file_invalid_format') ,
            // 'file.max' => __('seller_messages.file_size_exceed') ,
            'title.required' => __('seller_messages.caption_required'),

        ]);
    
        if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
        }

        $user_details=$request->user();
   
        $request_data=(object )[
            'seller_id'=>$user_details->id,
            'file'=>$request->file,
            'title'=>$request->title,
        ];

        $data= $this->StoryManagementService->uploadHighlightFromGallery($request_data);
      
        if(isset($data['status']) && $data['status']=='error' ){
            return ApiResponse::generateResponse('error', $data['message'],(object)[],400);
        }

        return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);


    }


public function SellerSide_get_admin_stories(Request $request){

    $data=$this->StoryManagementService->getAdminStoryOnSeller($request);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],(object)[],422);

    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

}

public function raise_ticket(Request $request){
  
    $validate = Validator::make($request->all(), [
        'ticket_type_id' => 'required|integer|exists:ticket_types,id',
        'title' => 'required',
        'description' => 'required',
        ],[

            'ticket_type_id.required' => __('seller_messages.Please_Select_Ticket_Type') ,
            'title.required' => __('seller_messages.Please_Enter_Title'),
            'description.required' => __('seller_messages.Please_Enter_Description'),

        ]);
    
    if($validate->fails()){
    return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
    }

    $user_id=$request->user()->id;
    $request_data=(object)[
        'sender_id'=>$user_id,
        'sender_type'=> 2,
        'file'=>$request->file??null,
        'ticket_type_id'=>$request->ticket_type_id,
        'title'=>$request->title,
        'description'=>$request->description,

        ];

    $data=$this->TicketService->raiseTicket($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],(object)[],422);

    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

}

public function get_raised_tickets(Request $request){
  

    $user_id=$request->user()->id;
    $request_data=(object)[
        'sender_id'=>$user_id,
        'sender_type'=> 2,
        'sender_id'=>$user_id,
        'limit'=>$request->limit??null,
        'search'=>$request->search??null,

        ];

    $data=$this->TicketService->getTickets($request_data);

    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],(object)[],422);

    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

}

    public function get_seller_story_price(Request $request)
    {

        $validate = Validator::make($request->all(), [
        'country_id' => 'required|integer|exists:countries,id',
        'no_of_days' => 'required',
        ],[
            'country_id.required' => __('seller_messages.country_required') ,
            'no_of_days.required' => __('seller_messages.no_of_days_required') ,

        ]);
    
        if($validate->fails()){
        return ApiResponse::generateResponse('error', $validate->errors()->first(),$validate->errors()->first(),422);
        }

        $request_data = (object)[
            'country_id' => $request->country_id,
            'no_of_days' => $request->no_of_days,
        ];

        $data = $this->StoryManagementService->getSellerStoryPrice($request_data);

        if (isset($data['status']) && $data['status'] == 'error') {
            return ApiResponse::generateResponse('error', $data['message'], (object)[], 400);
        }

        return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);
    }

    public function complete_story_payment(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'story_id' => 'required|integer|exists:stories,id',
            'transaction_id' => 'required',
        ], [
            'story_id.required' => __('seller_messages.story_id_required'),
            'story_id.exists' => __('seller_messages.story_not_found'),
            'transaction_id.required' => __('seller_messages.transaction_id_required'),
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse(
                'error',
                $validate->errors()->first(),
                $validate->errors()->first(),
                422
            );
        }

        $user = $request->user();

        $request_data = (object)[
            'seller_id' => $user->id,
            'story_id' => $request->story_id,
            'transaction_id' => $request->transaction_id,
        ];

        $data = $this->StoryManagementService->completeStoryPayment($request_data);

        if ($data['status'] == 'error') {
            return ApiResponse::generateResponse('error', $data['message'], (object)[], 400);
        }

        return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);
    }

     public function get_my_stories_requests(Request $request)
    {

        $user_details = $request->user();

        $request_data = (object)[
            'seller_id' => $user_details->id,
            'limit' => $request->limit??null,
            'search' => $request->search??null,
            'from_date' => $request->from_date??null,
            'to_date' => $request->to_date??null,
            'filter' => $request->filter??null,
        ];

        $data = $this->StoryManagementService->getSellerStoriesRequests($request_data);

        if (isset($data['status']) && $data['status'] == 'error') {
            return ApiResponse::generateResponse('error', $data['message'], (object)[], 400);
        }

        return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);
    }

    

    



}