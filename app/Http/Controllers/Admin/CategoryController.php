<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdminAuthService;
use App\Models\Admin;
use Validator;
 
class CategoryController extends Controller
{


    public function categoryManagement(Request $request){
        return view('admin.category-management.index');
    }
}