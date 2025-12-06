<?php
namespace App\Services;

use App\Models\Banner;
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
                    'data' => (object) []
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
                'data' => (object)[]
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
                'data' => (object)[]
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
                    'data' => (object)[]
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
                'data' => (object)[]
            ];
        }
    }








    

            
        


}
    