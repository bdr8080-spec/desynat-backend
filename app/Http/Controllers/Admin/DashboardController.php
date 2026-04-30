<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Validator;
use App\Services\AdminDashboardService;
 
class DashboardController extends Controller
{

    public function __construct(AdminDashboardService $AdminDashboardService){

        $this->AdminDashboardService=$AdminDashboardService;

    }


    public function dashboard(Request $request){
        // $admin = Auth::guard('admin')->user();
        // $adminId = $admin->id;
        $request_data = (object)[
                'from_date' => $req->from_date??null,
                'to_date' => $req->to_date??null,
                'country_id' => $req->country_id??null,
                'filter' => $req->filter??null,
            ];
  
          $data= $this->AdminDashboardService->GetDashboardData($request_data)['data'];
        return view('admin.dashboard.index',compact('data'));
    }
}