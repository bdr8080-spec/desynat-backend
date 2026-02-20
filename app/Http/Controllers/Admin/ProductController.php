<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Services\ProductManagementService;
use App\Services\CountryService;

 
class ProductController extends Controller
{

    public function __construct(ProductManagementService $ProductManagementService, CountryService $CountryService)
    {
        $this->ProductManagementService = $ProductManagementService;
        $this->CountryService = $CountryService;
    }

    public function productManagement(Request $request){
        return view('admin.product-mgt.index');
    }





    



}