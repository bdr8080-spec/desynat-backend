<?php
namespace App\Services;

use App\Models\{AffilatedUser,AffilatedUserAddress,Bankdetails};
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;


class AffiliatedUserManagementService
{
   
    public function getNewAffiliatedUers($request)
    {
        try {
            $limit = (int)($request->input('limit')); 

            $query = AffilatedUser::where('admin_verify', '1')
                ->with([
                    'address_details',
                    'bank_details',
                    'country_details'
                ]);

            if (!empty($request->country)) {
                $query->whereHas('country_details', function ($q) use ($request) {
                    $q->where('name', $request->country);
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
                $query->where(function ($q) use ($search) {
                    $q->where('full_name', 'like', "%{$search}%");
                });
            }

            $user_details = $query->orderBy('id', 'desc')->paginate($limit);


            if ($user_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No New Affiliate Uesrs found',
                    'data' => (object) []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'New Affiliate Users fetched successfully',
                'data' => $user_details
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch new affiliate users: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function getApprovedAffiliatedUers($request)
    {
        try {
            $limit = (int)($request->input('limit')); 

            $query = AffilatedUser::where('admin_verify', '2')
                ->with([
                    'address_details',
                    'bank_details',
                    'country_details'
                ]);

            if (!empty($request->country)) {
                $query->whereHas('country_details', function ($q) use ($request) {
                    $q->where('name', $request->country);
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
                $query->where(function ($q) use ($search) {
                    $q->where('full_name', 'like', "%{$search}%");
                });
            }

            $user_details = $query->orderBy('id', 'desc')->paginate($limit);


            if ($user_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Approved Affiliate Uesrs found',
                    'data' => (object) []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Approved Affiliate Users fetched successfully',
                'data' => $user_details
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch approved affiliate users: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function getRejectedAffiliatedUers($request)
    {
        try {
            $limit = (int)($request->input('limit')); 

            $query = AffilatedUser::whereIn('admin_verify', ['3','4'])
                ->with([
                    'address_details',
                    'bank_details',
                    'country_details'
                ]);

            if (!empty($request->country)) {
                $query->whereHas('country_details', function ($q) use ($request) {
                    $q->where('name', $request->country);
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
                $query->where(function ($q) use ($search) {
                    $q->where('full_name', 'like', "%{$search}%");
                });
            }

            $user_details = $query->orderBy('id', 'desc')->paginate($limit);


            if ($user_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Rejected Affiliate Uesrs found',
                    'data' => (object) []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Rejected Affiliate Users fetched successfully',
                'data' => $user_details
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch rejected affiliate users: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }



    public function getAffiliateUserDetailsById($userId)
    {
        try {
            $user = AffilatedUser::with([
                'address_details',
                    'bank_details',
                    'country_details'
            ])->find($userId);

            if (!$user) {
                return [
                    'status' => 'error',
                    'message' => 'Affiliate User not found',
                    'data' => (object) []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'affilaite User details fetched successfully',
                'data' => $user
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch affilaite user details: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function acceptAffiliateUser($userId)
    {
        try {
            $user = AffilatedUser::find($userId);

            if (!$user) {
                return [
                    'status' => 'error',
                    'message' => 'Affiliate user not found',
                    'data' => (object) []
                ];
            }

            $user->admin_verify = '2'; 
            $user->save();

            return [
                'status' => 'success',
                'message' => 'Affiliate User Approved Successfully',
                'data' => $user
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to approve user: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function rejectAffiliateUser($userId, $rejectReason, $rejectType)
    {
        try {
            $user = AffilatedUser::find($userId);

            if (!$user) {
                return [
                    'status' => 'error',
                    'message' => 'Affiliate User not found',
                    'data' => (object) []
                ];
            }

            if ($rejectType === 'complete') {
                $user->admin_verify = '3';
            } elseif ($rejectType === 'document') {
                $user->admin_verify = '4';
            }

            $user->reject_reason = $rejectReason;
            $user->save();

            return [
                'status' => 'success',
                'message' => 'Affiliate User Rejected Successfully',
                'data' => $user
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to reject user: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    public function blockUnblockAffiliateUser($userId)
    {
        try {
            $user = AffilatedUser::find($userId);

            if (!$user) {
                return [
                    'status' => 'error',
                    'message' => 'Affiliate User not found',
                    'data' => (object)[]
                ];
            }

            $previousStatus = $user->status; 
            $user->status = $user->status == 0 ? 1 : 0;
            $user->save();

            $message = $user->is_block == 1
                ? 'Affiliate User Unblocked Successfully'
                : 'Affiliate User Blocked Successfully';

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

    














}
    