<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdminAuthService;
use App\Models\Admin;
use Validator;
 
class BrandController extends Controller
{


    public function brandManagement(Request $request){
        return view('admin.brand-management.index');
    }
}