<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdminAuthService;
use App\Models\Admin;
use Validator;
 
class DashboardController extends Controller
{


    public function dashboard(Request $request){
        return view('admin.dashboard.index');
    }
}