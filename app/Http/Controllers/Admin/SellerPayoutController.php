<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\seller;
use App\Services\WithdrawRequestManagementService;
use App\Services\CountryService;

class SellerPayoutController extends Controller
{
    public function __construct(WithdrawRequestManagementService $WithdrawRequestManagementService, CountryService $CountryService)
    {
        $this->WithdrawRequestManagementService = $WithdrawRequestManagementService;
        $this->CountryService = $CountryService;
    }

    public function payouts(Request $request)
    {
        $countries = $this->CountryService->getCountries()['data'];

        // DataTable paginates on the client, so fetch every seller in one go
        $request_data = (object) [
            'req_type' => null,
            'seller_id' => null,
            'countryId' => $request->countryId ?? null,
            'limit' => 10000,
            'from_date' => $request->from_date ?? null,
            'to_date' => $request->to_date ?? null,
            'search' => $request->search ?? null,
        ];

        $result = $this->WithdrawRequestManagementService->getSellerPayouts($request_data);
        if ($result['status'] === 'error') {
            session()->now('error', $result['message']);
            return view('admin.seller-payouts.index', [
                'countries' => $countries,
                'sellers' => collect(),
                'totalPending' => '0.000',
                'currency' => 'KD',
            ]);
        }

        $currency = 'KD';
        if (!empty($request->countryId)) {
            $currency = optional(collect($countries)->firstWhere('id', (int) $request->countryId))->currency_code ?? $currency;
        }

        return view('admin.seller-payouts.index', [
            'countries' => $countries,
            'sellers' => $result['data']['sellers'],
            'totalPending' => $result['data']['total_payout_pending'],
            'currency' => $currency,
        ]);
    }

    public function Sellerpayouts(Request $request)
    {
        $sellerDetails = seller::withTrashed()->with('store_info.country_info')->find($request->seller_id);
        if (!$sellerDetails) {
            return redirect()->route('admin.payouts')->with('error', 'Seller not found.');
        }

        $result = $this->WithdrawRequestManagementService->getSellerPayoutHistory(
            $sellerDetails->id,
            10000,
            $request->from_date ?? null,
            $request->to_date ?? null
        );
        if ($result['status'] === 'error') {
            return redirect()->route('admin.payouts')->with('error', $result['message']);
        }

        return view('admin.seller-payouts.sellerPayout', [
            'sellerDetails' => $sellerDetails,
            'sellerName' => trim($sellerDetails->first_name . ' ' . $sellerDetails->last_name),
            'currency' => optional(optional($sellerDetails->store_info)->country_info)->currency_code ?? 'KD',
            'totalPaid' => $result['data']['total_paid'],
            'pendingAmount' => $result['data']['pending_amount'],
            'payouts' => $result['data']['payout_history'],
        ]);
    }

    public function addSellerPayout(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'seller_id' => 'required|integer|exists:sellers,id',
            'amount' => ['required', 'numeric', 'min:0.001', 'regex:/^\d+(\.\d{1,3})?$/'],
            'transaction_id' => 'required|string|max:255',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()->first()
            ], 422);
        }

        $result = $this->WithdrawRequestManagementService->transferSellerWithdrawRequest($request);

        if ($result['status'] === 'error') {
            return response()->json([
                'status' => 'error',
                'message' => $result['message']
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => $result['message']
        ], 200);
    }
}
