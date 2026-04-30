<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\AdminDashboardService;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

use Validator;

class DashboardController extends Controller
{

    public function __construct(AdminDashboardService $AdminDashboardService){

        $this->AdminDashboardService=$AdminDashboardService;

    }


    public function dashboard_data(Request $req){


         $request_data = (object)[
                'from_date' => $req->from_date??null,
                'to_date' => $req->to_date??null,
                'country_id' => $req->country_id??null,
                'filter' => $req->filter??null,
            ];
  
          $data= $this->AdminDashboardService->GetDashboardData($request_data);

          if(isset($data['status']) && $data['status']=='error' ){
              return ApiResponse::generateResponse('error', $data['message'],$data['data'],400);
          }
  
          return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);
  
    }


    



    

    


      






}
