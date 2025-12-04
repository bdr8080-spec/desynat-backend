<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

 
class PromoCodeController extends Controller
{

    public function promoCodeManagement(Request $request){
        return view('admin.promocode-management.index');
    }



    



}