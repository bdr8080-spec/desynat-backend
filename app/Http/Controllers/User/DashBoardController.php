<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\UserDashboardService;

use Illuminate\Support\Facades\Session;


class DashBoardController extends Controller
{

    public function __construct(UserDashboardService $UserDashboardService)
    {
        $this->UserDashboardService = $UserDashboardService;
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

}