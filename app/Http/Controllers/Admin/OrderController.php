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
        $toDate = $request->get('to_date');

        $activeRequestParams = [];

        if ($type === 'active') {
            $activeRequestParams['country_name'] = $country;
            $activeRequestParams['from_date'] = $fromDate;
            $activeRequestParams['to_date'] = $toDate;
        }

        $response = $this->OrderManagementService->ActiveOrdersNew(new Request($activeRequestParams));

        $data = $response['data'] ?? collect();

        $orders = ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
            ? collect($data->items())
            : collect($data);

        $fileName = 'active_orders_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $locale = app()->getLocale();

        return response()->stream(function () use ($orders, $locale) {

            $file = fopen('php://output', 'w');

            // UTF-8 fix for Excel
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            /* =========================
            HEADERS
            ========================= */

            $headersEn = [
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
                'Order Amount (KD)',
                'Admin Commission (KD)',
                'Order Type',
                'Delivery Boy',
                'Delivery Boy Company Name',
                'Status',
                'Zone'
            ];

            $headersAr = [
                'الرقم',
                'رقم الطلب',
                'اسم البائع',
                'اسم العميل',
                'الدولة',
                'اسم المنتج',
                'رابط صورة المنتج',
                'الفئة',
                'الفئة الفرعية',
                'العلامة التجارية',
                'عنوان التوصيل',
                'إجمالي الطلب (دينار)',
                'عمولة الإدارة (دينار)',
                'نوع الطلب',
                'مندوب التوصيل',
                'اسم شركة التوصيل',
                'الحالة',
                'المنطقة'
            ];

            $csvHeaders = $locale == 'ar' ? $headersAr : $headersEn;

            fputcsv($file, $csvHeaders);

            $na = $locale == 'ar' ? 'غير متوفر' : 'N/A';

            /* =========================
            DELIVERY STATUS (EN/AR)
            ========================= */
            $deliveryStatuses = $locale == 'ar' ? [
                '1'   => 'تم التأكيد',
                '2.1' => 'تم الشحن',
                '2.2' => 'في الطريق',
                '3'   => 'تم التوصيل',
                '4'   => 'ملغي',
                '5'   => 'مرتجع',
                '6'   => 'تم التأكيد',
                '7'   => 'تم الاستلام',
                '8'   => 'لم يتم التوصيل',
            ] : [
                '1'   => 'Confirmed',
                '2.1' => 'Shipped',
                '2.2' => 'On the Way',
                '3'   => 'Delivered',
                '4'   => 'Cancelled',
                '5'   => 'Return',
                '6'   => 'Confirmed',
                '7'   => 'Picked',
                '8'   => 'Not Delivered',
            ];

            /* =========================
            DATA LOOP
            ========================= */

            foreach ($orders as $index => $data) {

                $product = $data->product_details ?? null;

                /* Seller */
                $sellerName = $na;
                if ($product && $product->seller_details) {
                    $seller = $product->seller_details;

                    $sellerName = trim(
                        ($seller->first_name ?? '') . ' ' . 
                        ($seller->last_name ?? '')
                    );
                }

                /* Customer */
                $customerName = $data['order']['delivery_details']['name'] ?? $na;

                /* Country */
                $country = $data['order']['delivery_details']['country_name'] ?? $na;

                /* Address */
                $delivery = $data['order']['delivery_details'] ?? [];

                $address = ($delivery['address'] ?? '') . ' ' .
                        ($delivery['postal_code'] ?? '') . ' ' .
                        ($delivery['state'] ?? '');

                $address = trim(str_replace(["\r", "\n"], ' ', $address));
                $address = $address ?: $na;

                /* Product Name */
                $productName = $locale == 'ar'
                    ? ($product->product_name_ar ?? $product->product_name_en ?? $na)
                    : ($product->product_name_en ?? $na);

                /* Product Image */
                $variant = $data->variation_details ?? null;

                $productImage = $na;

                if ($variant && !empty($variant->variant_image)) {
                    $images = is_string($variant->variant_image)
                        ? json_decode($variant->variant_image, true)
                        : $variant->variant_image;

                    if (is_array($images) && isset($images[0])) {
                        $productImage = $images[0];
                    }
                }

                /* Category */
                $category = $product->category ?? null;

                $categoryName = $category
                    ? ($locale == 'ar'
                        ? ($category->name_ar ?? $category->name ?? $na)
                        : ($category->name ?? $na))
                    : $na;

                /* Sub Category */
                $subCategory = $product->subcategory ?? null;

                $subCategoryName = $subCategory
                    ? ($locale == 'ar'
                        ? ($subCategory->name_arabic ?? $subCategory->name_english ?? $na)
                        : ($subCategory->name_english ?? $na))
                    : $na;

                /* Brand */
                $brand = $product->brand ?? null;

                $brandName = $brand
                    ? ($locale == 'ar'
                        ? ($brand->name_arabic ?? $brand->name_english ?? $na)
                        : ($brand->name_english ?? $na))
                    : $na;

                /* Zone */
                $zone = $data['driver_details']['zone_info'] ?? null;

                $zoneName = $zone
                    ? ($locale == 'ar'
                        ? ($zone['name_arabic'] ?? $zone['name_english'] ?? $na)
                        : ($zone['name_english'] ?? $na))
                    : $na;

                /* Order Amount */
                if ($data['order']['order_type'] == '1') {
                    $amount = $data['amount_with_charges'];
                    $orderAmount = ($amount == floor($amount))
                        ? intval($amount)
                        : number_format($amount, 2);
                } else {
                    $orderAmount = intval($data['order']['total_amount']);
                }

                /* Commission */
                $adminCommission = $data['admin_commission'] ?? $na;

                /* Order Type */
                $orderType = ($data['order']['order_type'] == '1')
                    ? ($locale == 'ar' ? 'عادي' : 'Normal')
                    : ($locale == 'ar' ? 'مخصص' : 'Custom');

                /* Delivery Boy */
                $deliveryBoy = $data['driver_details']['full_name_english'] ?? $na;

                /* Company */
                $companyName = $na;

                /* Status */
                $status = $deliveryStatuses[$data['delivery_status']] ?? ($locale == 'ar' ? 'غير معروف' : 'Unknown');

                /* Final CSV Row */
                fputcsv($file, [
                    $index + 1,
                    $data['id'],
                    $sellerName,
                    $customerName,
                    $country,
                    $productName,
                    $productImage,
                    $categoryName,
                    $subCategoryName,
                    $brandName,
                    $address,
                    $orderAmount,
                    $adminCommission,
                    $orderType,
                    $deliveryBoy,
                    $companyName,
                    $status,
                    $zoneName
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
        $toDate = $request->get('to_date');

        $returnRequestParams = [];

        if ($type === 'return' && $country) {
            $returnRequestParams['country_name'] = $country;
            $returnRequestParams['from_date'] = $fromDate;
            $returnRequestParams['to_date'] = $toDate;
        }

        $response = $this->OrderManagementService
            ->ReturnExchangeOrdersNew(new Request($returnRequestParams));

        $data = $response['data'] ?? collect();

        $orders = ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
            ? collect($data->items())
            : collect($data);

        $fileName = 'return_exchange_orders_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $locale = app()->getLocale();

        return response()->stream(function () use ($orders, $locale) {

            $file = fopen('php://output', 'w');

            // UTF-8 BOM
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            /* =========================
            HEADERS EN / AR
            ========================= */

            $headersEn = [
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
                'Order Amount (KD)',
                'Admin Commission (KD)',
                'Order Type',
                'Delivery Boy',
                'Delivery Boy Company Name',
                'Type',
                'Reason',
                'Status',
                'Zone'
            ];

            $headersAr = [
                'الرقم',
                'رقم الطلب',
                'اسم البائع',
                'اسم العميل',
                'الدولة',
                'اسم المنتج',
                'رابط صورة المنتج',
                'الفئة',
                'الفئة الفرعية',
                'العلامة التجارية',
                'عنوان التوصيل',
                'إجمالي الطلب (دينار)',
                'عمولة الإدارة (دينار)',
                'نوع الطلب',
                'مندوب التوصيل',
                'اسم شركة التوصيل',
                'النوع',
                'السبب',
                'الحالة',
                'المنطقة'
            ];

            $csvHeaders = $locale == 'ar' ? $headersAr : $headersEn;

            fputcsv($file, $csvHeaders);

            $na = $locale == 'ar' ? 'غير متوفر' : 'N/A';

            /* =========================
            DELIVERY STATUS (EN/AR)
            ========================= */

            $deliveryStatuses = $locale == 'ar' ? [
                '1'   => 'تم التأكيد',
                '2.1' => 'تم الشحن',
                '2.2' => 'في الطريق',
                '3'   => 'تم التوصيل',
                '4'   => 'ملغي',
                '5'   => 'مرتجع',
                '6'   => 'تم التأكيد',
                '7'   => 'تم الاستلام',
                '8'   => 'لم يتم التوصيل',
            ] : [
                '1'   => 'Confirmed',
                '2.1' => 'Shipped',
                '2.2' => 'On the Way',
                '3'   => 'Delivered',
                '4'   => 'Cancelled',
                '5'   => 'Return',
                '6'   => 'Confirmed',
                '7'   => 'Picked',
                '8'   => 'Not Delivered',
            ];

            /* =========================
            TYPE (RETURN / EXCHANGE)
            ========================= */

            $returnTypeMap = $locale == 'ar' ? [
                '1' => 'مرتجع',
                '2' => 'استبدال',
            ] : [
                '1' => 'Return',
                '2' => 'Exchange',
            ];

            /* =========================
            LOOP
            ========================= */

            foreach ($orders as $index => $data) {

                $product = $data->product_details ?? null;

                /* Seller */
                $sellerName = $na;
                if ($product && $product->seller_details) {
                    $seller = $product->seller_details;

                    $sellerName = trim(
                        ($seller->first_name ?? '') . ' ' . 
                        ($seller->last_name ?? '')
                    );
                }

                /* Customer */
                $customerName = $data['order']['delivery_details']['name'] ?? $na;

                /* Country */
                $country = $data['order']['delivery_details']['country_name'] ?? $na;

                /* Address */
                $delivery = $data['order']['delivery_details'] ?? [];

                $address = ($delivery['address'] ?? '') . ' ' .
                        ($delivery['postal_code'] ?? '') . ' ' .
                        ($delivery['state'] ?? '');

                $address = trim(str_replace(["\r", "\n"], ' ', $address));
                $address = $address ?: $na;

                /* Product Name */
                $productName = $locale == 'ar'
                    ? ($product->product_name_ar ?? $product->product_name_en ?? $na)
                    : ($product->product_name_en ?? $na);

                /* Image */
                $variant = $data->variation_details ?? null;

                $productImage = $na;

                if ($variant && !empty($variant->variant_image)) {

                    $images = is_string($variant->variant_image)
                        ? json_decode($variant->variant_image, true)
                        : $variant->variant_image;

                    if (is_array($images) && isset($images[0])) {
                        $productImage = $images[0];
                    }
                }

                /* Category */
                $category = $product->category ?? null;

                $categoryName = $category
                    ? ($locale == 'ar'
                        ? ($category->name_ar ?? $category->name ?? $na)
                        : ($category->name ?? $na))
                    : $na;

                /* Sub Category */
                $subCategory = $product->subcategory ?? null;

                $subCategoryName = $subCategory
                    ? ($locale == 'ar'
                        ? ($subCategory->name_arabic ?? $subCategory->name_english ?? $na)
                        : ($subCategory->name_english ?? $na))
                    : $na;

                /* Brand */
                $brand = $product->brand ?? null;

                $brandName = $brand
                    ? ($locale == 'ar'
                        ? ($brand->name_arabic ?? $brand->name_english ?? $na)
                        : ($brand->name_english ?? $na))
                    : $na;

                /* Zone */
                $zone = $data['driver_details']['zone_info'] ?? null;

                $zoneName = $zone
                    ? ($locale == 'ar'
                        ? ($zone['name_arabic'] ?? $zone['name_english'] ?? $na)
                        : ($zone['name_english'] ?? $na))
                    : $na;

                /* Order Amount */
                if ($data['order']['order_type'] == '1') {
                    $amount = $data['amount_with_charges'];
                    $orderAmount = ($amount == floor($amount))
                        ? intval($amount)
                        : number_format($amount, 2);
                } else {
                    $orderAmount = intval($data['order']['total_amount']);
                }

                /* Commission */
                $adminCommission = $data['admin_commission'] ?? $na;

                /* Order Type */
                $orderType = ($data['order']['order_type'] == '1')
                    ? ($locale == 'ar' ? 'عادي' : 'Normal')
                    : ($locale == 'ar' ? 'مخصص' : 'Custom');

                /* Delivery Boy */
                $deliveryBoy = $data['driver_details']['full_name_english'] ?? $na;

                /* Company */
                $companyName = $na;

                /* TYPE */
                $typeValue = $returnTypeMap[$data['return_type']] ?? $na;

                /* REASON */
                $reason = $na;

                if ($data['return_type'] == '1') {
                    $reason = $data['return_reason'] ?? $na;
                } elseif ($data['return_type'] == '2') {
                    $reason = $data['exchange_reason'] ?? $na;
                }

                /* STATUS */
                $status = $deliveryStatuses[$data['delivery_status']] ?? ($locale == 'ar' ? 'غير معروف' : 'Unknown');

                /* ROW */
                fputcsv($file, [
                    $index + 1,
                    $data['id'],
                    $sellerName,
                    $customerName,
                    $country,
                    $productName,
                    $productImage,
                    $categoryName,
                    $subCategoryName,
                    $brandName,
                    $address,
                    $orderAmount,
                    $adminCommission,
                    $orderType,
                    $deliveryBoy,
                    $companyName,
                    $typeValue,
                    $reason,
                    $status,
                    $zoneName
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
        $toDate = $request->get('to_date');

        $completeRequestParams = [];

        if ($type === 'complete' && $country) {
            $completeRequestParams['country_name'] = $country;
            $completeRequestParams['from_date'] = $fromDate;
            $completeRequestParams['to_date'] = $toDate;
        }

        $response = $this->OrderManagementService->CompletedOrdersNew(
            new Request($completeRequestParams)
        );

        $data = $response['data'] ?? collect();

        $orders = ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
            ? collect($data->items())
            : collect($data);

        $fileName = 'completed_orders_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $locale = app()->getLocale();

        return response()->stream(function () use ($orders, $locale) {

            $file = fopen('php://output', 'w');

            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            /* =========================
            HEADERS EN / AR
            ========================= */

            $headersEn = [
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
                'Order Amount (KD)',
                'Admin Commission (KD)',
                'Order Type',
                'Delivery Boy',
                'Delivery Boy Company Name',
            ];

            $headersAr = [
                'الرقم',
                'رقم الطلب',
                'اسم البائع',
                'اسم العميل',
                'الدولة',
                'اسم المنتج',
                'رابط صورة المنتج',
                'الفئة',
                'الفئة الفرعية',
                'العلامة التجارية',
                'عنوان التوصيل',
                'إجمالي الطلب (دينار)',
                'عمولة الإدارة (دينار)',
                'نوع الطلب',
                'مندوب التوصيل',
                'اسم شركة التوصيل',
            ];

            fputcsv($file, $locale == 'ar' ? $headersAr : $headersEn);

            $na = $locale == 'ar' ? 'غير متوفر' : 'N/A';

            foreach ($orders as $index => $data) {

                $product = $data->product_details ?? null;

                /* Seller */
                $sellerName = $na;
                if ($product && $product->seller_details) {
                    $seller = $product->seller_details;

                    $sellerName = trim(
                        ($seller->first_name ?? '') . ' ' . 
                        ($seller->last_name ?? '')
                    );
                }

                /* Customer */
                $customerName = $data['order']['delivery_details']['name'] ?? $na;

                /* Country */
                $countryVal = $data['order']['delivery_details']['country_name'] ?? $na;

                /* Address */
                $delivery = $data['order']['delivery_details'] ?? [];

                $address = ($delivery['address'] ?? '') . ' ' .
                        ($delivery['postal_code'] ?? '') . ' ' .
                        ($delivery['state'] ?? '');

                $address = trim(str_replace(["\r", "\n"], ' ', $address));
                $address = $address ?: $na;

                /* Product Name */
                $productName = $locale == 'ar'
                    ? ($product->product_name_ar ?? $product->product_name_en ?? $na)
                    : ($product->product_name_en ?? $na);

                /* Image */
                $variant = $data->variation_details ?? null;

                $productImage = $na;

                if ($variant && !empty($variant->variant_image)) {

                    $images = is_string($variant->variant_image)
                        ? json_decode($variant->variant_image, true)
                        : $variant->variant_image;

                    if (is_array($images) && isset($images[0])) {
                        $productImage = $images[0];
                    }
                }

                /* Category */
                $category = $product->category ?? null;

                $categoryName = $category
                    ? ($locale == 'ar'
                        ? ($category->name_ar ?? $category->name ?? $na)
                        : ($category->name ?? $na))
                    : $na;

                /* Sub Category */
                $subCategory = $product->subcategory ?? null;

                $subCategoryName = $subCategory
                    ? ($locale == 'ar'
                        ? ($subCategory->name_arabic ?? $subCategory->name_english ?? $na)
                        : ($subCategory->name_english ?? $na))
                    : $na;

                /* Brand */
                $brand = $product->brand ?? null;

                $brandName = $brand
                    ? ($locale == 'ar'
                        ? ($brand->name_arabic ?? $brand->name_english ?? $na)
                        : ($brand->name_english ?? $na))
                    : $na;

                /* Order Amount */
                if ($data['order']['order_type'] == '1') {
                    $amount = $data['amount_with_charges'];
                    $orderAmount = ($amount == floor($amount))
                        ? intval($amount)
                        : number_format($amount, 2);
                } else {
                    $orderAmount = intval($data['order']['total_amount']);
                }

                /* Commission */
                $adminCommission = $data['admin_commission'] ?? $na;

                /* Order Type */
                $orderType = ($data['order']['order_type'] == '1')
                    ? ($locale == 'ar' ? 'عادي' : 'Normal')
                    : ($locale == 'ar' ? 'مخصص' : 'Custom');

                /* Delivery Boy */
                $deliveryBoy = $data['driver_details']['full_name_english'] ?? $na;

                /* Company */
                $companyName = $na;

                /* ROW */
                fputcsv($file, [
                    $index + 1,
                    $data['id'],
                    $sellerName,
                    $customerName,
                    $countryVal,
                    $productName,
                    $productImage,
                    $categoryName,
                    $subCategoryName,
                    $brandName,
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
        $toDate = $request->get('to_date');

        $cancelledRequestParams = [];

        if ($type === 'cancelled' && $country) {
            $cancelledRequestParams['country_name'] = $country;
            $cancelledRequestParams['from_date'] = $fromDate;
            $cancelledRequestParams['to_date'] = $toDate;
        }

        $response = $this->OrderManagementService->CancelledOrdersNew(
            new Request($cancelledRequestParams)
        );

        $data = $response['data'] ?? collect();

        $orders = ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
            ? collect($data->items())
            : collect($data);

        $fileName = 'cancelled_orders_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $locale = app()->getLocale();

        return response()->stream(function () use ($orders, $locale) {

            $file = fopen('php://output', 'w');

            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            /* =========================
            HEADERS EN / AR
            ========================= */

            $headersEn = [
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
                'Order Amount (KD)',
                'Admin Commission (KD)',
                'Order Type',
                'Delivery Boy',
                'Delivery Boy Company Name',
                'Reason',
            ];

            $headersAr = [
                'الرقم',
                'رقم الطلب',
                'اسم البائع',
                'اسم العميل',
                'الدولة',
                'اسم المنتج',
                'رابط صورة المنتج',
                'الفئة',
                'الفئة الفرعية',
                'العلامة التجارية',
                'عنوان التوصيل',
                'إجمالي الطلب (دينار)',
                'عمولة الإدارة (دينار)',
                'نوع الطلب',
                'مندوب التوصيل',
                'اسم شركة التوصيل',
                'السبب',
            ];

            fputcsv($file, $locale == 'ar' ? $headersAr : $headersEn);

            $na = $locale == 'ar' ? 'غير متوفر' : 'N/A';

            /* =========================
            DELIVERY STATUS (optional future use)
            ========================= */
            $deliveryStatuses = $locale == 'ar' ? [
                '1' => 'تم التأكيد',
                '2.1' => 'تم الشحن',
                '2.2' => 'في الطريق',
                '3' => 'تم التوصيل',
                '4' => 'ملغي',
                '5' => 'مرتجع',
                '6' => 'تم التأكيد',
                '7' => 'تم الاستلام',
                '8' => 'لم يتم التوصيل',
            ] : [
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

            foreach ($orders as $index => $data) {

                $product = $data->product_details ?? null;

                /* Seller */
                $sellerName = $na;
                if ($product && $product->seller_details) {
                    $seller = $product->seller_details;

                    $sellerName = trim(
                        ($seller->first_name ?? '') . ' ' .
                        ($seller->last_name ?? '')
                    );
                }

                /* Customer */
                $customerName = $data['order']['delivery_details']['name'] ?? $na;

                /* Country */
                $countryVal = $data['order']['delivery_details']['country_name'] ?? $na;

                /* Address */
                $delivery = $data['order']['delivery_details'] ?? [];

                $address = ($delivery['address'] ?? '') . ' ' .
                        ($delivery['postal_code'] ?? '') . ' ' .
                        ($delivery['state'] ?? '');

                $address = trim(str_replace(["\r", "\n"], ' ', $address));
                $address = $address ?: $na;

                /* Product Name */
                $productName = $locale == 'ar'
                    ? ($product->product_name_ar ?? $product->product_name_en ?? $na)
                    : ($product->product_name_en ?? $na);

                /* Image */
                $variant = $data->variation_details ?? null;

                $productImage = $na;

                if ($variant && !empty($variant->variant_image)) {

                    $images = is_string($variant->variant_image)
                        ? json_decode($variant->variant_image, true)
                        : $variant->variant_image;

                    if (is_array($images) && isset($images[0])) {
                        $productImage = $images[0];
                    }
                }

                /* Category */
                $category = $product->category ?? null;

                $categoryName = $category
                    ? ($locale == 'ar'
                        ? ($category->name_ar ?? $category->name ?? $na)
                        : ($category->name ?? $na))
                    : $na;

                /* Sub Category */
                $subCategory = $product->subcategory ?? null;

                $subCategoryName = $subCategory
                    ? ($locale == 'ar'
                        ? ($subCategory->name_arabic ?? $subCategory->name_english ?? $na)
                        : ($subCategory->name_english ?? $na))
                    : $na;

                /* Brand */
                $brand = $product->brand ?? null;

                $brandName = $brand
                    ? ($locale == 'ar'
                        ? ($brand->name_arabic ?? $brand->name_english ?? $na)
                        : ($brand->name_english ?? $na))
                    : $na;

                /* Order Amount */
                if ($data['order']['order_type'] == '1') {
                    $amount = $data['amount_with_charges'];
                    $orderAmount = ($amount == floor($amount))
                        ? intval($amount)
                        : number_format($amount, 2);
                } else {
                    $orderAmount = intval($data['order']['total_amount']);
                }

                /* Admin Commission */
                $adminCommission = $data['admin_commission'] ?? $na;

                /* Order Type */
                $orderType = ($data['order']['order_type'] == '1')
                    ? ($locale == 'ar' ? 'عادي' : 'Normal')
                    : ($locale == 'ar' ? 'مخصص' : 'Custom');

                /* Delivery Boy */
                $deliveryBoy = $data['driver_details']['full_name_english'] ?? $na;

                /* Company */
                $companyName = $na;

                /* Reason */
                $reason = $data['cancel_reason'] ?? $na;

                /* Final CSV */
                fputcsv($file, [
                    $index + 1,
                    $data['id'],
                    $sellerName,
                    $customerName,
                    $countryVal,
                    $productName,
                    $productImage,
                    $categoryName,
                    $subCategoryName,
                    $brandName,
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