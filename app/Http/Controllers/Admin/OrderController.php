<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Services\OrderManagementService;
use App\Services\CountryService;

 
class OrderController extends Controller
{

    public function __construct(OrderManagementService $OrderManagementService, CountryService $CountryService)
    {
        $this->OrderManagementService = $OrderManagementService;
        $this->CountryService = $CountryService;
    }

    public function orderManagement(Request $request){
        $type = $request->get('type'); 
        $country = $request->get('country_name');

        // Active Orders
        $activeRequestParams = [];
        if ($type === 'active' && $country) {
            $activeRequestParams['country_name'] = $country;
        }
        $activeOrders = $this->OrderManagementService->ActiveOrders(new Request($activeRequestParams))['data'];
        //dd($activeOrders);
        $countries = $this->CountryService->getUserAllCountries()['data'];
        return view('admin.order-management.index',compact('countries','type','activeOrders'));
    }



    



}