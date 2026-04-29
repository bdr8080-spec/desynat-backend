<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\all_countrie;

class OrderInvoiceController extends Controller
{
    
    public function Invoice(Request $request, $id){


         $checkOrder = Order::with(
                'delivery_details',
                'promocode_details',
                'user_details',
                'order_details.product_details.brand',
                'order_details.product_details.category',
                'order_details.product_details.subcategory',
                'order_details.product_details.seller_details.store_info',
                'order_details.variation_details.color',
                'order_details.variation_details.size',
                'driver_details.zone_info'
            )->where('order_id', $id)->first();


            
           //dd($checkOrder);
            if($checkOrder){
                return view('invoice',compact('checkOrder'));
            }else{
                return redirect()->route('userLogin');
            }

    }

    public function InvoiceUser(Request $request, $id){


         $checkOrder = Order::with(
                'delivery_details',
                'promocode_details',
                'user_details',
                'order_details.product_details.brand',
                'order_details.product_details.category',
                'order_details.product_details.subcategory',
                'order_details.product_details.seller_details.store_info',
                'order_details.variation_details.color',
                'order_details.variation_details.size',
                'driver_details.zone_info'
            )->where('order_id', $id)->first();

            $userId = $checkOrder->user_details->id;

            $user = User::find($userId);

            $currencyData = all_countrie::find($user->selected_currency);

            $currencyCode = $currencyData->currency_code ?? 'KWD';
            $rate = $currencyData->exchange_rate_to_kwd ?? 1;

            
           //dd($checkOrder);
            if($checkOrder){
                return view('invoice_user',compact('checkOrder','currencyCode','rate'));
            }else{
                return redirect()->route('userLogin');
            }

    }


}