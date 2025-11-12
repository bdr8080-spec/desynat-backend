<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

 
class ReasonController extends Controller
{


    public function reasonManagement(Request $request){
        return view('admin.reason-management.index');
    }
    



}