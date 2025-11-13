<?php
namespace App\Services;

use App\Models\User;
use App\Models\UserWallet;
use App\Models\all_countrie;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;


class UserManagementService
{
   
    public function getUsers($request)
    {
        try {
            $limit = (int) $request->input('limit');

            $query = User::with(['country_info', 'wallet_info']);

            if (!empty($request->country_id)) {
                $query->whereHas('country_info', function ($q) use ($request) {
                    $q->where('id', $request->country_id);
                });
            }

            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            } elseif (!empty($request->from_date)) {
                $query->whereDate('created_at', '>=', $request->from_date);
            } elseif (!empty($request->to_date)) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }

            if (!empty($request->search)) {
                $search = $request->search;
                $query->where('full_name', 'like', "%{$search}%");
            }

            $user_details = $query->orderBy('id', 'desc')->paginate($limit);

            if ($user_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No user found',
                    'data' => (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Users fetched successfully',
                'data' => $user_details
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch users: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }



    public function getUserDetailsById($userId)
    {
        try {
            $user = User::with(['country_info', 'wallet_info'])->find($userId);

            if (!$user) {
                return [
                    'status' => 'error',
                    'message' => 'User not found',
                    'data' => (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'User details fetched successfully',
                'data' => $user
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch user details: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    public function blockUnblockUser($userId)
    {
        try {
            $user = User::find($userId);

            if (!$user) {
                return [
                    'status' => 'error',
                    'message' => 'User not found',
                    'data' => (object)[]
                ];
            }

            $previousStatus = $user->status; 
            $user->status = $user->status == 1 ? 0 : 1;
            $user->save();

            $message = $user->status == 1
                ? 'User unblocked Successfully'
                : 'User blocked Successfully';

            return [
                'status' => 'success',
                'message' => $message,
                'data' => $user
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update user status: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function addUserWalletAmount($userId, $amount)
    {
        try {
            $wallet = UserWallet::where('user_id', $userId)->first();

            if ($wallet) {
                $wallet->amount += $amount;
                $wallet->save();

                $message = 'Amount added in wallet successfully';
            } else {
                $wallet = UserWallet::create([
                    'user_id' => $userId,
                    'amount' => $amount,
                ]);

                $message = 'Amount added in wallet successfully';
            }

            return [
                'status' => 'success',
                'message' => $message,
                'data' => $wallet
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update or create wallet: ' . $e->getMessage(),
                'data' => (object)[]
            ];
        }
    }

    














}
    