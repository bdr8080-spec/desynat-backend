<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Validator;
 
class DashboardController extends Controller
{


    public function dashboard(Request $request){
        // $admin = Auth::guard('admin')->user();
        // $adminId = $admin->id;
        return view('admin.dashboard.index');
    }
}