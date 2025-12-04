<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

 
class ShippingController extends Controller
{

    public function shippingManagement(Request $request){
        return view('admin.shipping-charge-tax-management.index');
    }

    public function manageShippingCharges(Request $request){
        return view('admin.shipping-charge-tax-management.manage');
    }


    



}