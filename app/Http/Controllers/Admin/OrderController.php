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

        // Active Orders
        $activeRequestParams = [];
        if ($type === 'active' && $country) {
            $activeRequestParams['country_name'] = $country;
        }
        $activeOrders = $this->OrderManagementService->ActiveOrders(new Request($activeRequestParams))['data'];
        //dd($activeOrders);

        $returnRequestParams = [];
        if ($type === 'return' && $country) {
            $returnRequestParams['country_name'] = $country;
        }
        $returnOrders = $this->OrderManagementService->ReturnExchangeOrders(new Request($returnRequestParams))['data'];

        $completeRequestParams = [];
        if ($type === 'complete' && $country) {
            $completeRequestParams['country_name'] = $country;
        }
        $completeOrders = $this->OrderManagementService->CompletedOrders(new Request($completeRequestParams))['data'];

        $cancelledRequestParams = [];
        if ($type === 'cancelled' && $country) {
            $cancelledRequestParams['country_name'] = $country;
        }
        $cancelledOrders = $this->OrderManagementService->CancelledOrders(new Request($cancelledRequestParams))['data'];

        $countries = $this->CountryService->getUserAllCountries()['data'];

        return view('admin.order-management.index',compact('countries','type','activeOrders','returnOrders','completeOrders','cancelledOrders'));
    }

    public function invoice(Request $request){
        return view('admin.order-management.invoice');
    }

    public function getDriverListToAssign(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->OrderManagementService->getDriversListToAssign($request);

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
            'order_id' => 'required|exists:orders,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->OrderManagementService->assignDriver($request);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }




    



}