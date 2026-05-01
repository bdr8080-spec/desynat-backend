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

        return response()->stream(function () use ($payments) {

            $file = fopen('php://output', 'w');

            // UTF-8 fix
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // CSV Headers
            fputcsv($file, [
                'Sr No',
                'Transaction Id',
                'Order Date & Time',
                'Transaction Date & Time',
                'Customer Name',
                'Seller Name',
                'Order Id',
                'Country',
                'Total Charges(KD)',
                'Applied Promo Code',
                'Applied Gift Card',
                'Discount(KD)',
                'Commission(KD)',
                'Payment Mode'
            ]);

            foreach ($payments as $index => $payment) {

                // Customer Name
                $customerName = $payment->user_details->full_name ?? 'N/A';

                // Seller Name
                $sellerName = trim(
                    ($payment->product_details->seller_details->first_name ?? '') . ' ' .
                    ($payment->product_details->seller_details->last_name ?? '')
                ) ?: 'N/A';

                // Country
                $country = $payment->user_details->country_info->name ?? 'N/A';

                // Order Date
                $orderDate = $payment->created_at
                    ? $payment->created_at->format('jS F Y | g:i A')
                    : '-';

                // Transaction Date
                $transactionDate = $payment->updated_at
                    ? $payment->updated_at->format('jS F Y | g:i A')
                    : '-';

                // Promo Code
                $promoCode = $payment->promocode_details->name_english ?? 'No';

                // Gift Card
                $giftCard = $payment->gift_card_details->name_english ?? 'No';

                // Payment Mode
                $order = $payment->order ?? null;

                $paymentMode = 'N/A';

                if ($order && isset($order['payment_method'])) {
                    if ($order['payment_method'] == 1) {
                        $paymentMode = 'Online';
                    } elseif ($order['payment_method'] == 2) {
                        $paymentMode = 'Wallet';
                    } elseif ($order['payment_method'] == 3) {
                        $paymentMode = 'COD';
                    } else {
                        $paymentMode = '-';
                    }
                }

                fputcsv($file, [
                    $index + 1,
                    '#' . ($payment->order->order_id ?? $payment->order_id ?? 'N/A'),
                    $orderDate,
                    $transactionDate,
                    $customerName,
                    $sellerName,
                    '#' . $payment->id,
                    $country,
                    ($payment->total_paid_amount ?? 0),
                    $promoCode,
                    $giftCard,
                    ($payment->total_discount ?? 0),
                    ($payment->affiliate_admin_commission ?? 0),
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

        return response()->stream(function () use ($payments) {

            $file = fopen('php://output', 'w');

            // UTF-8 fix
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // CSV Headers
            fputcsv($file, [
                'Sr No',
                'Transaction ID',
                'Seller Name',
                'Country',
                'Amount(KD)',
                'Plan Name',
                'Date & Time'
            ]);

            foreach ($payments as $index => $payment) {

                $sellerName = trim(
                    ($payment->seller_details->first_name ?? '') . ' ' .
                    ($payment->seller_details->last_name ?? '')
                ) ?: 'N/A';

                $country = $payment->seller_details->store_info->country_info->name ?? 'N/A';

                $amount = ($payment->amount ?? 0);

                $planName = $payment->plan_info->plan_name_english ?? 'N/A';

                $dateTime = $payment->created_at
                    ? $payment->created_at->format('jS F Y | g:i A')
                    : '-';

                fputcsv($file, [
                    $index + 1,
                    '#' . ($payment->transaction_id ?? 'N/A'),
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

        $fileName = 'giftcard_payments_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        return response()->stream(function () use ($payments) {

            $file = fopen('php://output', 'w');

            // UTF-8 fix
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // CSV Headers
            fputcsv($file, [
                'Sr No',
                'Transaction ID',
                'Gift Card Name',
                'Purchased By',
                'Country',
                'Amount(KD)',
                'Date & Time'
            ]);

            foreach ($payments as $index => $payment) {

                $giftCardName = $payment->gift_details->name_english ?? 'N/A';

                $purchasedBy = $payment->user_details->full_name ?? 'N/A';

                $country = $payment->user_details->country_info->name ?? 'N/A';

                $amount = ($payment->amount ?? 0);

                $dateTime = $payment->created_at
                    ? $payment->created_at->format('jS F Y | g:i A')
                    : '-';

                fputcsv($file, [
                    $index + 1,
                    '#' . ($payment->transaction_id ?? 'N/A'),
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

        $fileName = 'banner_payments_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        return response()->stream(function () use ($payments) {

            $file = fopen('php://output', 'w');

            // UTF-8 fix
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // CSV Headers
            fputcsv($file, [
                'Sr No',
                'Transaction ID',
                'Request ID',
                'Seller Name',
                'Country',
                'Amount(KD)',
                'Date & Time'
            ]);

            foreach ($payments as $index => $payment) {
                $sellerName = trim(
                    ($payment->seller_details->first_name ?? '') . ' ' .
                    ($payment->seller_details->last_name ?? '')
                ) ?: 'N/A';

                $country = $payment->seller_details->store_info->country_info->name ?? 'N/A';

                $amount = ($payment->price ?? 0);

                $dateTime = $payment->created_at
                    ? $payment->created_at->format('jS F Y | g:i A')
                    : '-';

                fputcsv($file, [
                    $index + 1,
                    '#' . ($payment->transaction_id ?? 'N/A'),
                    '#' . ($payment->order_id ?? 'N/A'),
                    $sellerName,
                    $country,
                    $amount,
                    $dateTime
                ]);
            }

            fclose($file);

        }, 200, $headers);
    }








}