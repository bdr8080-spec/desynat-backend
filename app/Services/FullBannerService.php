<?php
namespace App\Services;

use App\Models\FullBanner;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use Carbon\Carbon;


class FullBannerService
{
   
    public function getFullBanners($request)
    {
        try {
            $limit = $request->input('limit');
            $limit = (int)$limit;

            $query = FullBanner::with([
                'country_info'
            ]);

            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where('title', 'like', '%' . $search . '%');
            }

            if ($request->filled('country')) {
                $country = $request->input('country');

                $query->whereHas('country_info', function ($q) use ($country) {
                    $q->where('name', 'like', '%' . $country . '%');
                });
            }

            $query->orderBy('id', 'desc');

            $banner_details = $query->paginate($limit);

            if ($banner_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Banner found',
                    'data' =>  (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Banners fetched successfully',
                'data' => $banner_details
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch brands: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }



    public function addFullBanner(Request $request)
    {

        try {
            $data = FullBanner::create([
                'image' => $request->image,
                'country_id' => $request->country_id,
                'title' => $request->title,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            return [
                'status' => 'success',
                'message' => 'Banner added successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to add banner',
                'data' => []
            ];
        }
    }

    public function updateFullBanner(Request $request, $bannerId)
    {
        $data = FullBanner::find($bannerId);

        if (!$data) {
            return [
                'status' => 'error',
                'message' => 'Banner not found',
                'data' => []
            ];
        }

        try {
            $data->update([
                'image' => $request->image,
                'country_id' => $request->country_id,
                'title' => $request->title,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,  
            ]);

            return [
                'status' => 'success',
                'message' => 'Banner updated successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update deal',
                'data' => []
            ];
        }
    }

    public function deleteFullBanner($bannerId)
    {
        try {
            $data = FullBanner::find($bannerId);

            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => 'Banner not found',
                    'data' => []
                ];
            }
            $data->delete();

            return [
                'status' => 'success',
                'message' => 'Banner deleted successfully',
                'data' => []
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to delete banner',
                'data' => []
            ];
        }
    }





    

            
        


}
    