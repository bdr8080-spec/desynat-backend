<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;
use Validator;

use App\Services\PaymentService;
use App\Services\CountryService;

use App\Models\{ seller,sellerStoreInformation,sellerDocument,Bankdetails,Plan };


class PaymentController extends Controller
{

    public function __Construct(PaymentService $PaymentService, CountryService $CountryService){
        $this->PaymentService=$PaymentService;
        $this->CountryService=$CountryService;
    }

    public function paymentManagement(Request $request){
        $request_data=(object)[
            'from_date'=>$request->from_date??null,
            'to_date'=>$request->to_date??null,
            'country_id'=>$request->country_id??null,
            ];

        $orderPayment=$this->PaymentService->getOrderPaymentData($request_data);
        //dd($orderPayment);

        $request_data1=(object)[
            'from_date'=>$request->from_date1??null,
            'to_date'=>$request->to_date1??null,
            'country_id'=>$request->country_id1??null,
            ];

        $planPayment=$this->PaymentService->getPlanPaymentData($request_data1);

        $request_data2=(object)[
            'from_date'=>$request->from_date2??null,
            'to_date'=>$request->to_date2??null,
            'country_id'=>$request->country_id2??null,
            ];

        $giftCardPayment=$this->PaymentService->getGiftCardPaymentData($request_data2);

        $request_data3=(object)[
            'from_date'=>$request->from_date3??null,
            'to_date'=>$request->to_date3??null,
            'country_id'=>$request->country_id3??null,
            ];

        $bannerPayment=$this->PaymentService->getBannerPaymentData($request_data3);

        $userCountry=$this->CountryService->getUserAllCountries($request)['data'];
        $sellerCountry=$this->CountryService->getCountries($request)['data'];


        return view('admin.payment.index',compact('orderPayment','planPayment','giftCardPayment','bannerPayment','userCountry','sellerCountry'));
    }

    public function export_order_payment_data(Request $request)
    {
        $request_data = (object)[
            'from_date' => $request->from_date ?? null,
            'to_date' => $request->to_date ?? null,
            'country_id' => $request->country_id ?? null,
        ];

        $response = $this->PaymentService->getOrderPaymentData($request_data);

        $data = $response['data'] ?? collect();

        $payments = ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
            ? collect($data->items())
            : collect($data);

        $fileName = 'order_payments_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $locale = app()->getLocale();

        return response()->stream(function () use ($payments, $locale) {

            $file = fopen('php://output', 'w');

            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            /* =========================
            HEADERS EN / AR
            ========================= */

            $headersEn = [
                'Sr No',
                'Transaction Id',
                'Order Date & Time',
                'Transaction Date & Time',
                'Customer Name',
                'Seller Name',
                'Order Id',
                'Country',
                'Total Charges (KD)',
                'Applied Promo Code',
                'Applied Gift Card',
                'Discount (KD)',
                'Commission (KD)',
                'Payment Mode'
            ];

            $headersAr = [
                'الرقم',
                'رقم المعاملة',
                'تاريخ الطلب',
                'تاريخ المعاملة',
                'اسم العميل',
                'اسم البائع',
                'رقم الطلب',
                'الدولة',
                'إجمالي الرسوم',
                'كود الخصم',
                'بطاقة الهدية',
                'الخصم',
                'العمولة',
                'طريقة الدفع'
            ];

            fputcsv($file, $locale == 'ar' ? $headersAr : $headersEn);

            $na = $locale == 'ar' ? 'غير متوفر' : 'N/A';

            /* =========================
            LOOP
            ========================= */

            foreach ($payments as $index => $payment) {

                /* Customer */
                $customerName = $payment->user_details->full_name ?? $na;

                /* Seller */
                $sellerName = trim(
                    ($payment->product_details->seller_details->first_name ?? '') . ' ' .
                    ($payment->product_details->seller_details->last_name ?? '')
                ) ?: $na;

                /* Country */
                $countryData = $payment->user_details->country_info ?? null;

                $country = $countryData
                    ? ($locale == 'ar'
                        ? ($countryData->name_ar ?? $countryData->name ?? $na)
                        : ($countryData->name ?? $na))
                    : $na;

                /* Order Date */
                $orderDate = $payment->created_at
                    ? $payment->created_at->format('jS F Y | g:i A')
                    : $na;

                /* Transaction Date */
                $transactionDate = $payment->updated_at
                    ? $payment->updated_at->format('jS F Y | g:i A')
                    : $na;

                /* Promo Code */
                $promo = $payment->promocode_details ?? null;

                $promoCode = $promo
                    ? ($locale == 'ar'
                        ? ($promo->name_arabic ?? $promo->name_english ?? $na)
                        : ($promo->name_english ?? $na))
                    : ($locale == 'ar' ? 'لا يوجد' : 'No');

                /* Gift Card */
                $gift = $payment->gift_card_details ?? null;

                $giftCard = $gift
                    ? ($locale == 'ar'
                        ? ($gift->name_arabic ?? $gift->name_english ?? $na)
                        : ($gift->name_english ?? $na))
                    : ($locale == 'ar' ? 'لا يوجد' : 'No');

                /* Payment Mode */
                $order = $payment->order ?? null;

                $paymentMode = $na;

                if ($order && isset($order['payment_method'])) {
                    $paymentMode = match ($order['payment_method']) {
                        1 => $locale == 'ar' ? 'الدفع الإلكتروني' : 'Online',
                        2 => $locale == 'ar' ? 'المحفظة' : 'Wallet',
                        3 => $locale == 'ar' ? 'الدفع عند الاستلام' : 'COD',
                        default => $na,
                    };
                }

                fputcsv($file, [
                    $index + 1,
                    '#' . ($payment->order->order_id ?? $payment->order_id ?? $na),
                    $orderDate,
                    $transactionDate,
                    $customerName,
                    $sellerName,
                    '#' . $payment->id,
                    $country,
                    $payment->total_paid_amount ?? 0,
                    $promoCode,
                    $giftCard,
                    $payment->total_discount ?? 0,
                    $payment->affiliate_admin_commission ?? 0,
                    $paymentMode
                ]);
            }

            fclose($file);

        }, 200, $headers);
    }

    public function export_plan_payment_data(Request $request)
    {
        $request_data1 = (object)[
            'from_date' => $request->from_date1 ?? null,
            'to_date' => $request->to_date1 ?? null,
            'country_id' => $request->country_id1 ?? null,
        ];

        $response = $this->PaymentService->getPlanPaymentData($request_data1);

        $data = $response['data'] ?? collect();

        $payments = ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
            ? collect($data->items())
            : collect($data);

        $fileName = 'plan_payments_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $locale = app()->getLocale();

        return response()->stream(function () use ($payments, $locale) {

            $file = fopen('php://output', 'w');

            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            /* =========================
            HEADERS EN / AR
            ========================= */

            $headersEn = [
                'Sr No',
                'Transaction ID',
                'Seller Name',
                'Country',
                'Amount (KD)',
                'Plan Name',
                'Date & Time'
            ];

            $headersAr = [
                'الرقم',
                'رقم المعاملة',
                'اسم البائع',
                'الدولة',
                'المبلغ',
                'اسم الباقة',
                'التاريخ والوقت'
            ];

            fputcsv($file, $locale == 'ar' ? $headersAr : $headersEn);

            $na = $locale == 'ar' ? 'غير متوفر' : 'N/A';

            foreach ($payments as $index => $payment) {

                /* Seller Name */
                $sellerName = trim(
                    ($payment->seller_details->first_name ?? '') . ' ' .
                    ($payment->seller_details->last_name ?? '')
                ) ?: $na;

                /* Country */
                $countryData = $payment->seller_details->store_info->country_info ?? null;

                $country = $countryData
                    ? ($locale == 'ar'
                        ? ($countryData->name_ar ?? $countryData->name ?? $na)
                        : ($countryData->name ?? $na))
                    : $na;

                /* Plan Name */
                $plan = $payment->plan_info ?? null;

                $planName = $plan
                    ? ($locale == 'ar'
                        ? ($plan->plan_name_arabic ?? $plan->plan_name_english ?? $na)
                        : ($plan->plan_name_english ?? $na))
                    : $na;

                /* Amount */
                $amount = $payment->amount ?? 0;

                /* Date */
                $dateTime = $payment->created_at
                    ? $payment->created_at->format('jS F Y | g:i A')
                    : $na;

                fputcsv($file, [
                    $index + 1,
                    '#' . ($payment->transaction_id ?? $na),
                    $sellerName,
                    $country,
                    $amount,
                    $planName,
                    $dateTime
                ]);
            }

            fclose($file);

        }, 200, $headers);
    }

    public function export_giftcard_payment_data(Request $request)
    {
        $request_data2 = (object)[
            'from_date' => $request->from_date2 ?? null,
            'to_date' => $request->to_date2 ?? null,
            'country_id' => $request->country_id2 ?? null,
        ];

        $response = $this->PaymentService->getGiftCardPaymentData($request_data2);

        $data = $response['data'] ?? collect();

        $payments = ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
            ? collect($data->items())
            : collect($data);

        $isArabic = app()->getLocale() === 'ar';
        $na = $isArabic ? 'غير متوفر' : 'N/A';

        $fileName = 'giftcard_payments_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        return response()->stream(function () use ($payments, $isArabic, $na) {

            $file = fopen('php://output', 'w');

            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                $isArabic ? 'رقم' : 'Sr No',
                $isArabic ? 'رقم المعاملة' : 'Transaction ID',
                $isArabic ? 'اسم بطاقة الهدية' : 'Gift Card Name',
                $isArabic ? 'تم الشراء بواسطة' : 'Purchased By',
                $isArabic ? 'الدولة' : 'Country',
                $isArabic ? 'المبلغ (دينار) ' : 'Amount(KD)',
                $isArabic ? 'التاريخ والوقت' : 'Date & Time',
            ]);

            foreach ($payments as $index => $payment) {

                $giftCardName = $payment->gift_details
                    ? (
                        $isArabic
                            ? ($payment->gift_details->name_arabic
                                ?? $payment->gift_details->name_english
                                ?? $na)
                            : ($payment->gift_details->name_english
                                ?? $payment->gift_details->name_arabic
                                ?? $na)
                    )
                    : $na;

                $purchasedBy = $payment->user_details->full_name ?? $na;

                $country = $payment->user_details->country_info
                    ? (
                        $isArabic
                            ? ($payment->user_details->country_info->name_ar
                                ?? $payment->user_details->country_info->name
                                ?? $na)
                            : ($payment->user_details->country_info->name
                                ?? $payment->user_details->country_info->name_ar
                                ?? $na)
                    )
                    : $na;

                $amount = $payment->amount ?? 0;

                $dateTime = $payment->created_at
                    ? $payment->created_at->format('jS F Y | g:i A')
                    : '-';

                fputcsv($file, [
                    $index + 1,
                    '#' . ($payment->transaction_id ?? $na),
                    $giftCardName,
                    $purchasedBy,
                    $country,
                    $amount,
                    $dateTime
                ]);
            }

            fclose($file);

        }, 200, $headers);
    }

    public function export_banner_payment_data(Request $request)
    {
        $request_data3 = (object)[
            'from_date' => $request->from_date3 ?? null,
            'to_date' => $request->to_date3 ?? null,
            'country_id' => $request->country_id3 ?? null,
        ];

        $response = $this->PaymentService->getBannerPaymentData($request_data3);

        $data = $response['data'] ?? collect();

        $payments = ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
            ? collect($data->items())
            : collect($data);

        $isArabic = app()->getLocale() === 'ar';
        $na = $isArabic ? 'غير متوفر' : 'N/A';

        $fileName = 'banner_payments_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        return response()->stream(function () use ($payments, $isArabic, $na) {

            $file = fopen('php://output', 'w');

            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                $isArabic ? 'رقم' : 'Sr No',
                $isArabic ? 'رقم المعاملة' : 'Transaction ID',
                $isArabic ? 'رقم الطلب' : 'Request ID',
                $isArabic ? 'اسم البائع' : 'Seller Name',
                $isArabic ? 'الدولة' : 'Country',
                $isArabic ? 'المبلغ (دينار)' : 'Amount(KD)',
                $isArabic ? 'التاريخ والوقت' : 'Date & Time',
            ]);

            foreach ($payments as $index => $payment) {

                $sellerName = $payment->seller_details
                    ? trim(
                        ($payment->seller_details->first_name ?? '') . ' ' .
                        ($payment->seller_details->last_name ?? '')
                    )
                    : $na;

                $country = $payment->seller_details->store_info->country_info ?? null;

                $countryName = $country
                    ? (
                        $isArabic
                            ? ($country->name_ar ?? $country->name ?? $na)
                            : ($country->name ?? $country->name_ar ?? $na)
                    )
                    : $na;

                $amount = $payment->price ?? 0;

                $dateTime = $payment->created_at
                    ? $payment->created_at->format('jS F Y | g:i A')
                    : '-';

                fputcsv($file, [
                    $index + 1,
                    '#' . ($payment->transaction_id ?? $na),
                    '#' . ($payment->order_id ?? $na),
                    $sellerName,
                    $countryName,
                    $amount,
                    $dateTime
                ]);
            }

            fclose($file);

        }, 200, $headers);
    }








}