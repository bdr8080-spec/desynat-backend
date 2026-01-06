<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Services\BannerService;

 
class DealController extends Controller
{

    public function __construct(BannerService $BannerService)
    {
        $this->BannerService = $BannerService;
    }

    public function dealManagement(Request $request){
        return view('admin.deal-management.index');
    }

    public function sellerList(Request $request){
        return view('admin.deal-management.seller-list');
    }

    public function productList(Request $request){
        return view('admin.deal-management.product-list');
    }






    



}