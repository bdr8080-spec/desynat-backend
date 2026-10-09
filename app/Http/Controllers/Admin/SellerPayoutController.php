<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SellerPayoutController extends Controller
{
   public function payouts() { return view('admin.seller-payouts.index'); }

   public function Sellerpayouts() { return view('admin.seller-payouts.sellerPayout'); }

}