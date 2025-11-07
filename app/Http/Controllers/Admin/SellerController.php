<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\seller;
use Validator;
use App\Http\Controllers\CommonController;
use App\Services\SellerManagementService;
use App\Services\CountryService;
 
class SellerController extends Controller
{
    public function __construct(SellerManagementService $SellerManagementService, CountryService $CountryService)
    {
        $this->SellerManagementService = $SellerManagementService;
        $this->CountryService = $CountryService;
    }

    public function sellerManagement(Request $request){
        $countries = $this->CountryService->getCountries()['data'];
        $newSellers = $this->SellerManagementService->getNewSellers($request)['data'];
        $approvedSellers = $this->SellerManagementService->getApprovedSellers($request)['data'];
        $rejectedSellers = $this->SellerManagementService->getRejectedSellers($request)['data'];
        //dd($newSellers);
        return view('admin.seller-management.index',compact('newSellers','countries','approvedSellers','rejectedSellers'));
    }



}