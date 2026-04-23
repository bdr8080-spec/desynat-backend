<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Helpers\ApiResponse;
use Validator;
use App\Services\SellerStaffManagementService;

use App\Models\country;


class WebSellerStuffManagementController extends Controller
{

    public function __construct(SellerStaffManagementService $SellerStaffManagementService){
        $this->SellerStaffManagementService=$SellerStaffManagementService;
    }

    public function index(Request $request){

        return view('dealer.staff.index');
    }


    public function addStaff(Request $request){

        $data=  $this->SellerStaffManagementService->newStaffCategoryType();
        $staff_category=$data['data'];

        $sellerMenu=  $this->SellerStaffManagementService->SellerAllMenu();
        $sellerMenu=$sellerMenu['data'];

        $all_country=country::get();

        
    return view('dealer.staff.add-staff',compact('staff_category','all_country','sellerMenu'));

    }

}
