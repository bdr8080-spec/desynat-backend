<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\SubCategory;

use App\Models\Brand;



class SellerProductController extends Controller
{

    public function products(){

        $category = Category::orderBy('id', 'asc')->get();
        $brand = Brand::all();
 

        return view('dealer.product.product',compact('category','brand'));

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