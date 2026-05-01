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

    public function export_active_orders_data(Request $request)
    {
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
        $response = $this->OrderManagementService->ActiveOrdersNew(new Request($activeRequestParams));

        $data = $response['data'] ?? collect();

        // Handle paginator or collection
        $orders = ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
            ? collect($data->items())
            : collect($data);

        $fileName = 'active_orders_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        return response()->stream(function () use ($orders) {

            $file = fopen('php://output', 'w');

            // Excel UTF-8 fix
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Headers
            fputcsv($file, [
                'Sr No',
                'Order Id',
                'Seller Name',
                'Customer Name',
                'Country',
                'Product Name',
                'Product Image Url',
                'Category',
                'Sub Category',
                'Brand',
                'Delivery Address',
                'Order Amount(KD)',
                'Admin Commission(KD)',
                'Order Type',
                'Delivery Boy',
                'Delivery Boy Comapany Name',
                'Status',
                'Zone'
            ]);

            foreach ($orders as $index => $data) {

                // Seller Name
               $product = $data->product_details ?? null;

                $sellerName = 'Seller not found';

                if ($product && $product->seller_details) {
                    $seller = $product->seller_details;

                    $sellerName = trim(
                        ($seller->first_name ?? '') . ' ' .
                        ($seller->last_name ?? '')
                    );
                }

                // Customer Name
                $customerName = $data['order']['delivery_details']['name'] ?? 'N/A';

                // Country
                $country = $data['order']['delivery_details']['country_name'] ?? 'N/A';

                // Product Details (you can customize this)
                $productDetails = 'View Products';

                // Address
                $delivery = $data['order']['delivery_details'] ?? [];
                $address =
                    ($delivery['address'] ?? '') . ' ' .
                    ($delivery['postal_code'] ?? '') . ' ' .
                    ($delivery['state'] ?? '');

                $address = str_replace(["\r", "\n"], ' ', $address);
                $address = trim($address);

                // Order Amount
                if ($data['order']['order_type'] == '1') {
                    $amount = $data['amount_with_charges'];
                    $orderAmount = ($amount == floor($amount)) ? intval($amount) : number_format($amount, 2);
                } else {
                    $orderAmount = intval($data['order']['total_amount']);
                }

                // Admin Commission
                $adminCommission = isset($data['admin_commission']) && $data['admin_commission'] !== null
                    ? $data['admin_commission']
                    : 'N/A';

                // Order Type
                $orderType = ($data['order']['order_type'] == '1') ? 'Normal' : 'Custom';

                // Delivery Boy
                $deliveryBoy = $data['driver_details']['full_name_english'] ?? 'Not Assigned';

                // Company Name
                $companyName = 'N/A';

                // Status Mapping
                $deliveryStatuses = [
                    '1' => 'Confirmed',
                    '2.1' => 'Shipped',
                    '2.2' => 'On the Way',
                    '3' => 'Delivered',
                    '4' => 'Cancelled',
                    '5' => 'Return',
                    '6' => 'Confirmed',
                    '7' => 'Picked',
                    '8' => 'Not Delivered',
                ];

                $status = $deliveryStatuses[$data['delivery_status']] ?? 'Unknown';

                // Zone
                $zone = $data['driver_details']['zone_info']['name_english'] ?? 'N/A';

                // Product Name
                $productName = $product->product_name_en ?? 'N/A';

                // Product Image Url
                $variant = $data->variation_details ?? null;

                $productImage = 'N/A';

                if ($variant && !empty($variant->variant_image)) {

                    $images = $variant->variant_image;

                    // If stored as JSON string, decode it
                    if (is_string($images)) {
                        $images = json_decode($images, true);
                    }

                    // Take first image only
                    if (is_array($images) && isset($images[0])) {
                        $productImage = $images[0];
                    }
                }

                // Category
                $category = $product->category->name ?? 'N/A';

                // Sub Category
                $subCategory = $product->subcategory->name_english ?? 'N/A';

                // Brand
                $brand = $product->brand->name_english ?? 'N/A';

                // Final CSV row
                fputcsv($file, [
                    $index + 1,
                    $data['id'],
                    $sellerName,
                    $customerName,
                    $country,
                    $productName,
                    $productImage,
                    $category,
                    $subCategory,
                    $brand,
                    $address,
                    $orderAmount,
                    $adminCommission,
                    $orderType,
                    $deliveryBoy,
                    $companyName,
                    $status,
                    $zone
                ]);
            }

            fclose($file);

        }, 200, $headers);
    }

    public function export_return_exchange_orders_data(Request $request)
    {
        $type = $request->get('type'); 
        $country = $request->get('country_name');
        $fromDate = $request->get('from_date');
       // dd($fromDate);
        $toDate = $request->get('to_date');

       $returnRequestParams = [];
        if ($type === 'return' && $country) {
            $returnRequestParams['country_name'] = $country;
            $returnRequestParams['from_date'] = $fromDate;
            $returnRequestParams['to_date'] = $toDate;
        }
        $response = $this->OrderManagementService->ReturnExchangeOrdersNew(new Request($returnRequestParams));

        $data = $response['data'] ?? collect();

        // Handle paginator or collection
        $orders = ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
            ? collect($data->items())
            : collect($data);

        $fileName = 'return_exchange_orders_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        return response()->stream(function () use ($orders) {

            $file = fopen('php://output', 'w');

            // Excel UTF-8 fix
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Headers
            fputcsv($file, [
                'Sr No',
                'Order Id',
                'Seller Name',
                'Customer Name',
                'Country',
                'Product Name',
                'Product Image Url',
                'Category',
                'Sub Category',
                'Brand',
                'Delivery Address',
                'Order Amount(KD)',
                'Admin Commission(KD)',
                'Order Type',
                'Delivery Boy',
                'Delivery Boy Comapany Name',
                'Type',
                'Reason',
                'Status',
                'Zone'
            ]);

            foreach ($orders as $index => $data) {

                // Seller Name
               $product = $data->product_details ?? null;

                $sellerName = 'Seller not found';

                if ($product && $product->seller_details) {
                    $seller = $product->seller_details;

                    $sellerName = trim(
                        ($seller->first_name ?? '') . ' ' .
                        ($seller->last_name ?? '')
                    );
                }

                // Customer Name
                $customerName = $data['order']['delivery_details']['name'] ?? 'N/A';

                // Country
                $country = $data['order']['delivery_details']['country_name'] ?? 'N/A';

                // Product Details (you can customize this)
                $productDetails = 'View Products';

                // Address
                $delivery = $data['order']['delivery_details'] ?? [];
                $address =
                    ($delivery['address'] ?? '') . ' ' .
                    ($delivery['postal_code'] ?? '') . ' ' .
                    ($delivery['state'] ?? '');

                $address = str_replace(["\r", "\n"], ' ', $address);
                $address = trim($address);

                // Order Amount
                if ($data['order']['order_type'] == '1') {
                    $amount = $data['amount_with_charges'];
                    $orderAmount = ($amount == floor($amount)) ? intval($amount) : number_format($amount, 2);
                } else {
                    $orderAmount = intval($data['order']['total_amount']);
                }

                // Admin Commission
                $adminCommission = isset($data['admin_commission']) && $data['admin_commission'] !== null
                    ? $data['admin_commission']
                    : 'N/A';

                // Order Type
                $orderType = ($data['order']['order_type'] == '1') ? 'Normal' : 'Custom';

                // Delivery Boy
                $deliveryBoy = $data['driver_details']['full_name_english'] ?? 'Not Assigned';

                // Company Name
                $companyName = 'N/A';

                $deliveryStatuses = [
                    '1' => 'Return',
                    '2' => 'Exchange',
                ];

                $type = $deliveryStatuses[$data['return_type']] ?? 'Unknown';

                $reason = 'N/A';

                if ($data['return_type'] == '1') {
                    $reason = $data['return_reason'] ?? 'N/A';
                } elseif ($data['return_type'] == '2') {
                    $reason = $data['exchange_reason'] ?? 'N/A';
                }

                // Status Mapping
                $deliveryStatuses = [
                    '1' => 'Confirmed',
                    '2.1' => 'Shipped',
                    '2.2' => 'On the Way',
                    '3' => 'Delivered',
                    '4' => 'Cancelled',
                    '5' => 'Return',
                    '6' => 'Confirmed',
                    '7' => 'Picked',
                    '8' => 'Not Delivered',
                ];

                $status = $deliveryStatuses[$data['delivery_status']] ?? 'Unknown';

                // Zone
                $zone = $data['driver_details']['zone_info']['name_english'] ?? 'N/A';

                // Product Name
                $productName = $product->product_name_en ?? 'N/A';

                // Product Image Url
                $variant = $data->variation_details ?? null;

                $productImage = 'N/A';

                if ($variant && !empty($variant->variant_image)) {

                    $images = $variant->variant_image;

                    // If stored as JSON string, decode it
                    if (is_string($images)) {
                        $images = json_decode($images, true);
                    }

                    // Take first image only
                    if (is_array($images) && isset($images[0])) {
                        $productImage = $images[0];
                    }
                }

                // Category
                $category = $product->category->name ?? 'N/A';

                // Sub Category
                $subCategory = $product->subcategory->name_english ?? 'N/A';

                // Brand
                $brand = $product->brand->name_english ?? 'N/A';

                // Final CSV row
                fputcsv($file, [
                    $index + 1,
                    $data['id'],
                    $sellerName,
                    $customerName,
                    $country,
                    $productName,
                    $productImage,
                    $category,
                    $subCategory,
                    $brand,
                    $address,
                    $orderAmount,
                    $adminCommission,
                    $orderType,
                    $deliveryBoy,
                    $companyName,
                    $type,
                    $reason,
                    $status,
                    $zone
                ]);
            }

            fclose($file);

        }, 200, $headers);
    }


    public function export_completed_orders_data(Request $request)
    {
        $type = $request->get('type'); 
        $country = $request->get('country_name');
        $fromDate = $request->get('from_date');
       // dd($fromDate);
        $toDate = $request->get('to_date');

       $completeRequestParams = [];
        if ($type === 'complete' && $country) {
            $completeRequestParams['country_name'] = $country;
            $completeRequestParams['from_date'] = $fromDate;
            $completeRequestParams['to_date'] = $toDate;
        }
        $response = $this->OrderManagementService->CompletedOrdersNew(new Request($completeRequestParams));

        $data = $response['data'] ?? collect();

        // Handle paginator or collection
        $orders = ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
            ? collect($data->items())
            : collect($data);

        $fileName = 'completed_orders_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        return response()->stream(function () use ($orders) {

            $file = fopen('php://output', 'w');

            // Excel UTF-8 fix
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Headers
            fputcsv($file, [
                'Sr No',
                'Order Id',
                'Seller Name',
                'Customer Name',
                'Country',
                'Product Name',
                'Product Image Url',
                'Category',
                'Sub Category',
                'Brand',
                'Delivery Address',
                'Order Amount(KD)',
                'Admin Commission(KD)',
                'Order Type',
                'Delivery Boy',
                'Delivery Boy Comapany Name',
            ]);

            foreach ($orders as $index => $data) {

                // Seller Name
               $product = $data->product_details ?? null;

                $sellerName = 'Seller not found';

                if ($product && $product->seller_details) {
                    $seller = $product->seller_details;

                    $sellerName = trim(
                        ($seller->first_name ?? '') . ' ' .
                        ($seller->last_name ?? '')
                    );
                }

                // Customer Name
                $customerName = $data['order']['delivery_details']['name'] ?? 'N/A';

                // Country
                $country = $data['order']['delivery_details']['country_name'] ?? 'N/A';

                // Product Details (you can customize this)
                $productDetails = 'View Products';

                // Address
                $delivery = $data['order']['delivery_details'] ?? [];
                $address =
                    ($delivery['address'] ?? '') . ' ' .
                    ($delivery['postal_code'] ?? '') . ' ' .
                    ($delivery['state'] ?? '');

                $address = str_replace(["\r", "\n"], ' ', $address);
                $address = trim($address);

                // Order Amount
                if ($data['order']['order_type'] == '1') {
                    $amount = $data['amount_with_charges'];
                    $orderAmount = ($amount == floor($amount)) ? intval($amount) : number_format($amount, 2);
                } else {
                    $orderAmount = intval($data['order']['total_amount']);
                }

                // Admin Commission
                $adminCommission = isset($data['admin_commission']) && $data['admin_commission'] !== null
                    ? $data['admin_commission']
                    : 'N/A';

                // Order Type
                $orderType = ($data['order']['order_type'] == '1') ? 'Normal' : 'Custom';

                // Delivery Boy
                $deliveryBoy = $data['driver_details']['full_name_english'] ?? 'Not Assigned';

                // Company Name
                $companyName = 'N/A';


                // Status Mapping
                $deliveryStatuses = [
                    '1' => 'Confirmed',
                    '2.1' => 'Shipped',
                    '2.2' => 'On the Way',
                    '3' => 'Delivered',
                    '4' => 'Cancelled',
                    '5' => 'Return',
                    '6' => 'Confirmed',
                    '7' => 'Picked',
                    '8' => 'Not Delivered',
                ];


                // Product Name
                $productName = $product->product_name_en ?? 'N/A';

                // Product Image Url
                $variant = $data->variation_details ?? null;

                $productImage = 'N/A';

                if ($variant && !empty($variant->variant_image)) {

                    $images = $variant->variant_image;

                    // If stored as JSON string, decode it
                    if (is_string($images)) {
                        $images = json_decode($images, true);
                    }

                    // Take first image only
                    if (is_array($images) && isset($images[0])) {
                        $productImage = $images[0];
                    }
                }

                // Category
                $category = $product->category->name ?? 'N/A';

                // Sub Category
                $subCategory = $product->subcategory->name_english ?? 'N/A';

                // Brand
                $brand = $product->brand->name_english ?? 'N/A';

                // Final CSV row
                fputcsv($file, [
                    $index + 1,
                    $data['id'],
                    $sellerName,
                    $customerName,
                    $country,
                    $productName,
                    $productImage,
                    $category,
                    $subCategory,
                    $brand,
                    $address,
                    $orderAmount,
                    $adminCommission,
                    $orderType,
                    $deliveryBoy,
                    $companyName,
                ]);
            }

            fclose($file);

        }, 200, $headers);
    }

    public function export_cancelled_orders_data(Request $request)
    {
        $type = $request->get('type'); 
        $country = $request->get('country_name');
        $fromDate = $request->get('from_date');
       // dd($fromDate);
        $toDate = $request->get('to_date');

       $cancelledRequestParams = [];
        if ($type === 'cancelled' && $country) {
            $cancelledRequestParams['country_name'] = $country;
            $cancelledRequestParams['from_date'] = $fromDate;
            $cancelledRequestParams['to_date'] = $toDate;
        }
        $response = $this->OrderManagementService->CancelledOrdersNew(new Request($cancelledRequestParams));

        $data = $response['data'] ?? collect();

        // Handle paginator or collection
        $orders = ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
            ? collect($data->items())
            : collect($data);

        $fileName = 'cancelled_orders_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        return response()->stream(function () use ($orders) {

            $file = fopen('php://output', 'w');

            // Excel UTF-8 fix
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Headers
            fputcsv($file, [
                'Sr No',
                'Order Id',
                'Seller Name',
                'Customer Name',
                'Country',
                'Product Name',
                'Product Image Url',
                'Category',
                'Sub Category',
                'Brand',
                'Delivery Address',
                'Order Amount(KD)',
                'Admin Commission(KD)',
                'Order Type',
                'Delivery Boy',
                'Delivery Boy Comapany Name',
                'Reason',
            ]);

            foreach ($orders as $index => $data) {

                // Seller Name
               $product = $data->product_details ?? null;

                $sellerName = 'Seller not found';

                if ($product && $product->seller_details) {
                    $seller = $product->seller_details;

                    $sellerName = trim(
                        ($seller->first_name ?? '') . ' ' .
                        ($seller->last_name ?? '')
                    );
                }

                // Customer Name
                $customerName = $data['order']['delivery_details']['name'] ?? 'N/A';

                // Country
                $country = $data['order']['delivery_details']['country_name'] ?? 'N/A';

                // Product Details (you can customize this)
                $productDetails = 'View Products';

                // Address
                $delivery = $data['order']['delivery_details'] ?? [];
                $address =
                    ($delivery['address'] ?? '') . ' ' .
                    ($delivery['postal_code'] ?? '') . ' ' .
                    ($delivery['state'] ?? '');

                $address = str_replace(["\r", "\n"], ' ', $address);
                $address = trim($address);

                // Order Amount
                if ($data['order']['order_type'] == '1') {
                    $amount = $data['amount_with_charges'];
                    $orderAmount = ($amount == floor($amount)) ? intval($amount) : number_format($amount, 2);
                } else {
                    $orderAmount = intval($data['order']['total_amount']);
                }

                // Admin Commission
                $adminCommission = isset($data['admin_commission']) && $data['admin_commission'] !== null
                    ? $data['admin_commission']
                    : 'N/A';

                // Order Type
                $orderType = ($data['order']['order_type'] == '1') ? 'Normal' : 'Custom';

                // Delivery Boy
                $deliveryBoy = $data['driver_details']['full_name_english'] ?? 'Not Assigned';

                // Company Name
                $companyName = 'N/A';

                $reason = $data['cancel_reason'] ?? 'N/A';


                // Status Mapping
                $deliveryStatuses = [
                    '1' => 'Confirmed',
                    '2.1' => 'Shipped',
                    '2.2' => 'On the Way',
                    '3' => 'Delivered',
                    '4' => 'Cancelled',
                    '5' => 'Return',
                    '6' => 'Confirmed',
                    '7' => 'Picked',
                    '8' => 'Not Delivered',
                ];


                // Product Name
                $productName = $product->product_name_en ?? 'N/A';

                // Product Image Url
                $variant = $data->variation_details ?? null;

                $productImage = 'N/A';

                if ($variant && !empty($variant->variant_image)) {

                    $images = $variant->variant_image;

                    // If stored as JSON string, decode it
                    if (is_string($images)) {
                        $images = json_decode($images, true);
                    }

                    // Take first image only
                    if (is_array($images) && isset($images[0])) {
                        $productImage = $images[0];
                    }
                }

                // Category
                $category = $product->category->name ?? 'N/A';

                // Sub Category
                $subCategory = $product->subcategory->name_english ?? 'N/A';

                // Brand
                $brand = $product->brand->name_english ?? 'N/A';

                // Final CSV row
                fputcsv($file, [
                    $index + 1,
                    $data['id'],
                    $sellerName,
                    $customerName,
                    $country,
                    $productName,
                    $productImage,
                    $category,
                    $subCategory,
                    $brand,
                    $address,
                    $orderAmount,
                    $adminCommission,
                    $orderType,
                    $deliveryBoy,
                    $companyName,
                    $reason,
                ]);
            }

            fclose($file);

        }, 200, $headers);
    }




    



}