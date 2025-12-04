<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

 
class GiftCardController extends Controller
{

    public function giftCardManagement(Request $request){
        return view('admin.giftcard-management.index');
    }



    



}