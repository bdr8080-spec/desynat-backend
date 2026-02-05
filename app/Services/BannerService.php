<?php
namespace App\Services;

use App\Models\Banner;
use App\Models\sellerBanner;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;


class BannerService
{
   
    // public function getBanners($request)
    // {
    //     try {
    //         $limit = $request->input('limit');
    //         $limit = (int)$limit;

    //         $query = Banner::query();

    //         if ($request->filled('search')) {
    //             $search = $request->input('search');
    //             $query->where('name_english', 'like', '%' . $search . '%');
    //         }

    //         $query->orderBy('id', 'desc');

    //         $data = $query->paginate($limit);

    //         if ($data->isEmpty()) {
    //             return [
    //                 'status' => 'success',
    //                 'message' => 'No Banner found',
    //                 'data' => (object) []
    //             ];
    //         }

    //         return [
    //             'status' => 'success',
    //             'message' => 'Banners fetched successfully',
    //             'data' => $data
    //         ];

    //     } catch (\Exception $e) {
    //         return [
    //             'status' => 'error',
    //             'message' => 'Failed to fetch banner: ' . $e->getMessage(),
    //             'data' => []
    //         ];
    //     }
    // }

    public function getBanners($request)
    {
        try {
            // $data = Banner::with('country_info')
            //         ->where('type', $request->type)
            //         ->orderBy('id', 'desc')
            //         ->get();

            $data = Banner::with('country_info')
                    ->leftJoin('countries', 'countries.id', '=', 'banners.country_id')
                    ->where('banners.type', $request->type)
                    ->orderBy('countries.name', 'asc')
                    ->select('banners.*')
                    ->get();


            if ($data->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Banner found',
                    'data' =>  []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Banners fetched successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch banner: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function addUpdateBanner(Request $request)
    {
        try {
            $data = Banner::updateOrCreate(
                [
                    'country_id' => $request->country_id,
                    'type' => $request->type,
                ],
                [
                    'per_day_price' => $request->per_day_price,
                ]
            );

            return [
                'status' => 'success',
                'message' => 'Banner updated successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update banner',
                'data' => []
            ];
        }
    }

    public function updateBannerPrice(Request $request)
    {
        try {
            $banner = Banner::find($request->banner_id);

            if (!$banner) {
                return [
                    'status' => 'error',
                    'message' => 'Banner not found',
                    'data' => []
                ];
            }

            $banner->update([
                'per_day_price' => $request->per_day_price,
            ]);

            return [
                'status' => 'success',
                'message' => 'Banner per day charge updated successfully',
                'data' => $banner
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update banner',
                'data' => []
            ];
        }
    }


    //banner req service

    public function getBannersReq($request)
    {
        try {
            $limit = (int)($request->input('limit'));

            $data = sellerBanner::with('category_details','subcategory_details','seller_details.country_details','seller_details.seller_bank_details')->where('Admin_verify', $request->type)->where('added_by', '0');
            
            if ($request->search) {
                $search = $request->search;

                $data->where(function ($query) use ($search) {
                    $query->where('order_id', 'like', '%' . $search . '%')
                        ->orWhereHas('seller_details', function ($q) use ($search) {
                            $q->where('first_name', 'like', '%' . $search . '%')
                                ->orWhere('last_name', 'like', '%' . $search . '%');
                        });
                });
            }

            if ($request->country_name) {
                $data = $data->whereHas('seller_details.country_details', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->country_name . '%');
                });
            }

            if (!empty($request->from_date) && !empty($request->to_date)) {
                $data->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            } elseif (!empty($request->from_date)) {
                $data->whereDate('created_at', '>=', $request->from_date);
            } elseif (!empty($request->to_date)) {
                $data->whereDate('created_at', '<=', $request->to_date);
            }

            $data = $data->orderBy('id', 'desc')->paginate($limit);

            if ($data->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Banner Request found',
                    'data' =>  (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Banner Request fetched successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch banner: ' . $e->getMessage(),
                'data' => (object)[]
            ];
        }
    }

    public function approveBannerReq(Request $request)
    {
        try {
            $banner = sellerBanner::find($request->banner_id);

            if (!$banner) {
                return [
                    'status' => 'error',
                    'message' => 'Banner request not found',
                    'data' => []
                ];
            }

            $banner->update([
                'Admin_verify' => '1',
            ]);

            return [
                'status' => 'success',
                'message' => 'Banner Request Approved successfully',
                'data' => $banner
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to approve banner request',
                'data' => []
            ];
        }
    }

    public function rejectBannerReq(Request $request)
    {
        try {
            $banner = sellerBanner::find($request->banner_id);

            if (!$banner) {
                return [
                    'status' => 'error',
                    'message' => 'Banner request not found',
                    'data' => []
                ];
            }

            // if ($banner->Admin_verify == '1') {
            //     return [
            //         'status' => 'error',
            //         'message' => 'Banner request already accepted',
            //         'data' => []
            //     ];
            // }

            $banner->update([
                'Admin_verify' => '2',
                'cancelled_reason' => $request->reason,
            ]);

            return [
                'status' => 'success',
                'message' => 'Banner Request Rejected successfully',
                'data' => $banner
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to reject banner request',
                'data' => []
            ];
        }
    }

    public function blockUnblockBannerReq($id)
    {
        try {
            $data = sellerBanner::find($id);

            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => 'Banner Req not found',
                    'data' => []
                ];
            }

            $data->status = $data->status == 1 ? 0 : 1;
            $data->save();

            $message = $data->status == 1
                ? 'Banner Request Unblocked Successfully'
                : 'Banner Request blocked Successfully';

            return [
                'status' => 'success',
                'message' => $message,
                'data' => $data
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch banner: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }









    

            
        


}
    