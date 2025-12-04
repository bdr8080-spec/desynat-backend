<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

 
class BannerController extends Controller
{

    public function bannerManagement(Request $request){
        return view('admin.banner-management.index');
    }



    



}