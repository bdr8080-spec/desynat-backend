<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdminAuthService;
use App\Models\country;
use Validator;
use App\Http\Controllers\CommonController;
 
class CountryController extends Controller
{


    public function countryManagement(Request $request){
        return view('admin.country-management.index');
    }

    public function manageCities(Request $request){
        return view('admin.country-management.manage-cities');
    }

    public function manageZones(Request $request){
        return view('admin.country-management.manage-zones');
    }


}