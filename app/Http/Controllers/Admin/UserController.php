<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

 
class UserController extends Controller
{


    public function userManagement(Request $request){
        return view('admin.user-management.index');
    }
    



}