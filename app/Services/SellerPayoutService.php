<?php
namespace App\Services;

use App\Models\WithdrawRequest;
use App\Models\seller;
use App\Models\orderdetail;
use Illuminate\Support\Facades\DB;

class SellerPayoutService
{
    // Staff accounts (type 1) share the payouts of their parent seller
    public function resolveSellerId($user)
    {
        if ($user->type == '1' && !empty($user->parent_id)) {
            return (int) $user->parent_id;
        }
        return (int) $user->id;
    }

    private function getCurrency($sellerId)
    {
        $sellerDetails = seller::withTrashed()->with('store_info.country_info')->find($sellerId);
        $country = optional(optional($sellerDetails)->store_info)->country_info;

        return [
            'currency_code' => optional($country)->currency_code,
            'currency_symbol' => optional($country)->currency_symbol,
        ];
    }

    private function earningQuery($sellerId)
    {
        return orderdetail::query()
            ->where('seller_id', $sellerId)
            ->where('payment_status', '1')
            ->where('delivery_status', '3');
    }

    private function revenueSummary($sellerId)
    {
        $totals = $this->earningQuery($sellerId)
            ->selectRaw('COALESCE(SUM(COALESCE(amount, 0) + COALESCE(tax, 0) + COALESCE(shipping_fees, 0)), 0) as total_revenue')
            ->selectRaw('COALESCE(SUM(COALESCE(admin_commission, 0)), 0) as total_commission')
            ->first();

        return [
            'total_revenue' => number_format((float) $totals->total_revenue, 3, '.', ''),
            'total_commission' => number_format((float) $totals->total_commission, 3, '.', ''),
        ];
    }

    private function payoutQuery($sellerId)
    {
        return WithdrawRequest::query()
            ->where('type', '3')
            ->where('user_id', $sellerId)
            ->where('admin_verify', '1');
    }

    private function applyDateFilter($query, $column, $request_data)
    {
        if (!empty($request_data->from_date)) {
            $query->whereDate($column, '>=', $request_data->from_date);
        }
        if (!empty($request_data->to_date)) {
            $query->whereDate($column, '<=', $request_data->to_date);
        }
        return $query;
    }

    public function getMyPayouts($request_data)
    {
        try {
            $sellerId = $request_data->seller_id;

            $totalEarned = (float) $this->earningQuery($sellerId)
                ->selectRaw('COALESCE(SUM(COALESCE(amount, 0) + COALESCE(tax, 0) + COALESCE(shipping_fees, 0)), 0) as total')
                ->value('total');

            $totalPaid = (float) $this->payoutQuery($sellerId)
                ->selectRaw('COALESCE(SUM(CAST(amount AS DECIMAL(12, 3))), 0) as total')
                ->value('total');

            $lastPayment = $this->payoutQuery($sellerId)
                ->orderByDesc('updated_at')
                ->orderByDesc('id')
                ->first();

            $query = $this->payoutQuery($sellerId);
            $this->applyDateFilter($query, 'created_at', $request_data);

            if (!empty($request_data->search)) {
                $search = $request_data->search;
                $query->where(function ($q) use ($search) {
                    $q->where('request_id', 'like', "%{$search}%")
                        ->orWhere('transaction_id', 'like', "%{$search}%");
                });
            }

            $payouts = $query->orderByDesc('created_at')
                ->orderByDesc('id')
                ->paginate((int) $request_data->limit, [
                    'id',
                    'request_id',
                    'amount',
                    'transaction_id',
                    'payment_status',
                    'created_at as payout_date',
                ], 'history_page');

            // Each payout covers the period since the previous payout
            $allPayouts = $this->payoutQuery($sellerId)
                ->orderBy('created_at')
                ->orderBy('id')
                ->get(['id', 'created_at']);
            $payoutIds = $allPayouts->pluck('id')->all();
            $payoutDates = $allPayouts->pluck('created_at')->all();
            $firstOrderDate = $this->earningQuery($sellerId)->min('updated_at');

            $payouts->getCollection()->transform(function ($payout) use ($sellerId, $payoutDates, $payoutIds, $firstOrderDate) {
                $index = array_search($payout->id, $payoutIds);
                $fromDate = $index > 0 ? $payoutDates[$index - 1] : $firstOrderDate;
                $toDate = $payoutDates[$index];

                $commissionQuery = $this->earningQuery($sellerId)->where('updated_at', '<=', $toDate);
                if ($index > 0) {
                    $commissionQuery->where('updated_at', '>', $fromDate);
                }

                $payout->from_date = $fromDate ? \Carbon\Carbon::parse($fromDate)->format('Y-m-d H:i:s') : null;
                $payout->to_date = \Carbon\Carbon::parse($toDate)->format('Y-m-d H:i:s');
                $payout->commission = number_format((float) $commissionQuery->sum('admin_commission'), 3, '.', '');

                return $payout;
            });

            // All seller orders with customer name and commission
            $ordersQuery = DB::table('orderdetails')
                ->leftJoin('orders', 'orders.id', '=', 'orderdetails.order_id')
                ->leftJoin('users', 'users.id', '=', 'orderdetails.user_id')
                ->where('orderdetails.seller_id', $sellerId);
            $this->applyDateFilter($ordersQuery, 'orderdetails.created_at', $request_data);

            if (!empty($request_data->search)) {
                $search = $request_data->search;
                $ordersQuery->where(function ($q) use ($search) {
                    $q->where('orders.order_id', 'like', "%{$search}%")
                        ->orWhere('users.full_name', 'like', "%{$search}%");
                });
            }

            $orders = $ordersQuery
                ->selectRaw("orderdetails.id as id, orders.order_id as order_number, orderdetails.order_id as order_id, users.full_name as customer_name, CAST(COALESCE(orderdetails.amount, 0) + COALESCE(orderdetails.tax, 0) + COALESCE(orderdetails.shipping_fees, 0) AS DECIMAL(12, 3)) as amount, CAST(COALESCE(orderdetails.admin_commission, 0) AS DECIMAL(12, 3)) as commission, orderdetails.payment_status, orderdetails.delivery_status, orderdetails.created_at as order_date")
                ->orderByDesc('orderdetails.created_at')
                ->orderByDesc('orderdetails.id')
                ->paginate((int) $request_data->limit);

            return [
                'status' => 'success',
                'message' => $orders->isEmpty() ? 'No payouts found' : 'Payouts fetched successfully',
                'data' => array_merge($this->getCurrency($sellerId), $this->revenueSummary($sellerId), [
                    'total_earning' => number_format($totalEarned, 3, '.', ''),
                    'total_paid' => number_format($totalPaid, 3, '.', ''),
                    'pending_amount' => number_format(max(0, $totalEarned - $totalPaid), 3, '.', ''),
                    'last_payout' => number_format((float) ($lastPayment->amount ?? 0), 3, '.', ''),
                    'last_payout_date' => optional($lastPayment)->updated_at,
                    'payouts' => $orders,
                    'payout_history' => $payouts,
                ]),
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch payouts: ' . $e->getMessage(),
                'data' => [],
            ];
        }
    }

    public function getAllTransactions($request_data)
    {
        try {
            $sellerId = $request_data->seller_id;

            // Credits: delivered and paid order items
            $credits = DB::table('orderdetails')
                ->leftJoin('orders', 'orders.id', '=', 'orderdetails.order_id')
                ->leftJoin('users', 'users.id', '=', 'orderdetails.user_id')
                ->where('orderdetails.seller_id', $sellerId)
                ->where('orderdetails.payment_status', '1')
                ->where('orderdetails.delivery_status', '3')
                ->selectRaw("orderdetails.id as id, 1 as transaction_type, 'credit' as transaction_label, orders.order_id as reference_id, orderdetails.order_id as order_id, users.full_name as customer_name, NULL as transaction_id, CAST(COALESCE(orderdetails.amount, 0) + COALESCE(orderdetails.tax, 0) + COALESCE(orderdetails.shipping_fees, 0) AS DECIMAL(12, 3)) as amount, CAST(COALESCE(orderdetails.admin_commission, 0) AS DECIMAL(12, 3)) as commission, orderdetails.updated_at as transaction_date");

            // Debits: payouts transferred by admin
            $debits = DB::table('withdraw_requests')
                ->where('type', '3')
                ->where('user_id', $sellerId)
                ->where('admin_verify', '1')
                ->selectRaw("id as id, 2 as transaction_type, 'debit' as transaction_label, request_id as reference_id, NULL as order_id, NULL as customer_name, transaction_id as transaction_id, CAST(amount AS DECIMAL(12, 3)) as amount, NULL as commission, created_at as transaction_date");

            $this->applyDateFilter($credits, 'orderdetails.updated_at', $request_data);
            $this->applyDateFilter($debits, 'created_at', $request_data);

            if (!empty($request_data->search)) {
                $search = $request_data->search;
                $credits->where(function ($q) use ($search) {
                    $q->where('orders.order_id', 'like', "%{$search}%")
                        ->orWhere('users.full_name', 'like', "%{$search}%");
                });
                $debits->where(function ($q) use ($search) {
                    $q->where('request_id', 'like', "%{$search}%")
                        ->orWhere('transaction_id', 'like', "%{$search}%");
                });
            }

            if ($request_data->transaction_type == '1') {
                $union = $credits;
            } elseif ($request_data->transaction_type == '2') {
                $union = $debits;
            } else {
                $union = $credits->unionAll($debits);
            }

            $transactions = DB::query()
                ->fromSub($union, 't')
                ->orderByDesc('transaction_date')
                ->orderByDesc('id')
                ->paginate((int) $request_data->limit);

            return [
                'status' => 'success',
                'message' => $transactions->isEmpty() ? 'No transactions found' : 'Transactions fetched successfully',
                'data' => array_merge($this->getCurrency($sellerId), $this->revenueSummary($sellerId), [
                    'transactions' => $transactions,
                ]),
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch transactions: ' . $e->getMessage(),
                'data' => [],
            ];
        }
    }
}
