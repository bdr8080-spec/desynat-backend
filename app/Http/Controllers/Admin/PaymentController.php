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








}