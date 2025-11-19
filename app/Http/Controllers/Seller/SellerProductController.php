<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\SubCategory;

use App\Models\Brand;


use App\Services\SellerProductService;

use Auth;

class SellerProductController extends Controller
{

    public function __construct(SellerProductService $SellerProductService){
        $this->SellerProductService=$SellerProductService;
    }

    public function products(Request $request){

        $seller_details=  Auth::guard('seller')->user();
        $seller_id=$seller_details->id;
        $category = Category::orderBy('id', 'asc')->get();
        $brand = Brand::all();
    
        $category = Category::orderBy('id', 'asc')->get();
        $brand = Brand::all();

        if(isset($request->cargory_filter)){
            $cargory_filter= [$request->cargory_filter];
        }else{
            $cargory_filter='';
        }

        if(isset($request->brand_filter)){
            $brand_filter= [$request->brand_filter];
        }else{
            $brand_filter='';
        }
        
        $request_data=(object) [
        'seller_id'=>$seller_id,
        'search' =>$request->search,
        'type' =>$request->type, //  0 all product 1 active product 2 inactive product 
        'cargory_filter' =>$cargory_filter,
        'brand_filter' =>$brand_filter,    
        ];
    
      $all_records= $this->SellerProductService->AllProduct($request_data);

      
      $data=$all_records['data'];

    return view('dealer.product.product',compact('category','brand','data'));

    }


public function product_status_active_inactive(Request $request){

    $request_data=(object) [
    'product_id'=>$request->id,
    
    ];

  $data=  $this->SellerProductService->product_status_active_inactive($request_data);

  return $data;

}








    public function Inventory_Management(){

        return view('dealer.product.Inventory_Management');

    }
    public function Affilate_Commission(){

        return view('dealer.product.Affilate_Commission');

    }
    
    public function Add_product(){

        return view('dealer.product.Add_product');

    }
    public function view_product(){

        return view('dealer.product.view_product');

    }

    

    

}