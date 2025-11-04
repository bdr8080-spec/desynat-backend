<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdminAuthService;
use App\Models\country;
use Validator;
use App\Http\Controllers\CommonController;
 
class PlanController extends Controller
{


    public function planManagement(Request $request){
        return view('admin.plan-management.index');
    }

    public function managePlans(Request $request){
        return view('admin.plan-management.manage-plans');
    }



}