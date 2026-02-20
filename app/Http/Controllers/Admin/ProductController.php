<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Services\ProductManagementService;
use App\Services\CountryService;
use App\Services\BrandService;
use App\Services\CategoryService;

 
class ProductController extends Controller
{

    public function __construct(ProductManagementService $ProductManagementService, CountryService $CountryService, BrandService $BrandService, CategoryService $CategoryService)
    {
        $this->ProductManagementService = $ProductManagementService;
        $this->CountryService = $CountryService;
        $this->BrandService = $BrandService;
        $this->CategoryService = $CategoryService;
    }

    public function productManagement(Request $request){
        $countries = $this->CountryService->getCountries()['data'];
        $brands = $this->BrandService->getBrand($request)['data'];
        $categories = $this->CategoryService->getCategory($request)['data'];
        $subcategories = $this->CategoryService->getSubCategoriesByCategoryId($request->category)['data'];
        $products = $this->ProductManagementService->getProducts($request)['data'];
        //dd($products);
        return view('admin.product-mgt.index',compact('countries','brands','categories','subcategories','products'));
    }





    



}