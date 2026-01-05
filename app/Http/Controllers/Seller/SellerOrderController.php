<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SellerOrderController extends Controller
{
    

    public function order_management(Request $Request){
        return View('dealer.orderManagement.allOrder');
    }

     public function single_order_View(Request $Request){   

        return View('dealer.orderManagement.singleorder');
   
    }

    





}