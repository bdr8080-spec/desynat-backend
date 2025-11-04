<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdminAuthService;
use App\Models\country;
use Validator;
use App\Http\Controllers\CommonController;
 
class SellerController extends Controller
{


    public function sellerManagement(Request $request){
        return view('admin.seller-management.index');
    }



}