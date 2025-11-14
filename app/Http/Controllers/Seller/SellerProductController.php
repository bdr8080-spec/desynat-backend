<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SellerProductController extends Controller
{

    public function products(){

        return view('dealer.product.product');

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