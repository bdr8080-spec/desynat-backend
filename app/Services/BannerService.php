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
            $data = Banner::with('country_info')
                    ->where('type', $request->type)
                    ->orderBy('id', 'desc')
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







    

            
        


}
    