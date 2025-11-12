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
    



}