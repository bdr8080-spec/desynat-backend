<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Services\OrderManagementService;
use App\Services\CountryService;
use App\Helpers\ApiResponse;

 
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
        $fromDate = $request->get('from_date');
       // dd($fromDate);
        $toDate = $request->get('to_date');

        // Active Orders
        $activeRequestParams = [];
        if ($type === 'active') {
            $activeRequestParams['country_name'] = $country;
            $activeRequestParams['from_date'] = $fromDate;
            $activeRequestParams['to_date'] = $toDate;
        }
        $activeOrders = $this->OrderManagementService->ActiveOrdersNew(new Request($activeRequestParams))['data'];
        //dd($activeOrders);

        $returnRequestParams = [];
        if ($type === 'return' && $country) {
            $returnRequestParams['country_name'] = $country;
            $returnRequestParams['from_date'] = $fromDate;
            $returnRequestParams['to_date'] = $toDate;
        }
        $returnOrders = $this->OrderManagementService->ReturnExchangeOrdersNew(new Request($returnRequestParams))['data'];

        $completeRequestParams = [];
        if ($type === 'complete' && $country) {
            $completeRequestParams['country_name'] = $country;
            $completeRequestParams['from_date'] = $fromDate;
            $completeRequestParams['to_date'] = $toDate;
        }
        $completeOrders = $this->OrderManagementService->CompletedOrdersNew(new Request($completeRequestParams))['data'];

        $cancelledRequestParams = [];
        if ($type === 'cancelled' && $country) {
            $cancelledRequestParams['country_name'] = $country;
            $cancelledRequestParams['from_date'] = $fromDate;
            $cancelledRequestParams['to_date'] = $toDate;
        }
        $cancelledOrders = $this->OrderManagementService->CancelledOrdersNew(new Request($cancelledRequestParams))['data'];

        $countries = $this->CountryService->getUserAllCountries()['data'];

        return view('admin.order-management.index',compact('countries','type','activeOrders','returnOrders','completeOrders','cancelledOrders'));
    }

    public function invoice(Request $request){
        return view('admin.order-management.invoice');
    }

    public function getDriverListToAssign(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'order_id' => 'required|exists:orderdetails,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->OrderManagementService->getDriversListToAssignNew($request);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function assignDriver(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'driver_id' => 'required|exists:delivery_boys,id',
            'order_id' => 'required|exists:orderdetails,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->OrderManagementService->assignDriverNew($request);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }




    



}