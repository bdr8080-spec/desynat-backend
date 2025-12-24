<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderInvoiceController extends Controller
{
    
    public function Invoice(Request $request, $id){


         $checkOrder = Order::with(
                'delivery_details',
                'user_details',
                'order_details.product_details.brand',
                'order_details.product_details.category',
                'order_details.product_details.subcategory',
                'order_details.product_details.seller_details',
                'order_details.variation_details.color',
                'order_details.variation_details.size',
                'driver_details.zone_info'
            )->where('order_id', $id)->first();

            dump($checkOrder);
            

            if($checkOrder){
                return view('invoice',compact('checkOrder'));
            }else{
                return redirect()->route('userLogin');
            }

    }


}