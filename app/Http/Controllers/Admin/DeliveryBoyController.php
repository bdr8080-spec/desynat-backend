<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

 
class DeliveryBoyController extends Controller
{


    public function deliveryBoyManagement(Request $request){
        return view('admin.delivery-boy-management.index');
    }

    public function deliveryboy_reg_step1(Request $request){
        return view('admin.delivery-boy-management.reg_step1');
    }

    public function deliveryboy_reg_step2(Request $request){
        return view('admin.delivery-boy-management.reg_step2');
    }

    public function edit_deliveryboy_step1(Request $request){
        return view('admin.delivery-boy-management.edit_reg_step1');
    }

    public function edit_deliveryboy_step2(Request $request){
        return view('admin.delivery-boy-management.edit_reg_step2');
    }
    



}