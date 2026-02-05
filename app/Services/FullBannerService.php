<?php
namespace App\Services;

use App\Models\FullBanner;
use App\Models\sellerBanner;
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

            if ($request->filled('type')) {
                $type = $request->input('type');
                $query->where('type', $type);
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
                'type' => $request->type,
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
                'type' => $request->type, 
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

    public function bannerDetails($bannerId)
    {
        try {
           $data = FullBanner::with('country_info')->find($bannerId);

            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => 'Banner not found',
                    'data' => (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Banner details fetched successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch banne details',
                'data' => []
            ];
        }
    }

    public function addPromotionalBanner($request){

        try{

            $order_id = substr(time() . rand(100, 999), 0, 9);
            
            $request_data=[
                'order_id'=>$order_id,
                'banner_position'=>$request->banner_position,
                'category'=>$request->category,
                'subcatgory'=>$request->subcatgory,
                'start_date'=>$request->start_date,
                'end_date'=>$request->end_date,
                'total_days'=>$request->total_days,
                'upload_banner'=>$request->upload_banner,
                'added_by' => '1',
                'Admin_verify' => '1',
                'payment_status' => '1',
            ];

        

            $createBanner=sellerBanner::Create($request_data);

            if($createBanner){
                
                return [
                        'status'  => 'success',
                        'message' => 'Promotional Banner Added Successfully',
                        'data'    => $createBanner
                    ];

            }

        }catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ];
        }
    }

    public function updatePromotionalBanner($request)
    {
        try {
            $banner = sellerBanner::find($request->id);

            if (!$banner) {
                return [
                    'status'  => 'error',
                    'message' => 'Promotional Banner not found',
                ];
            }

            $updateData = [
                'banner_position' => $request->banner_position,
                'category'        => $request->category,
                'subcatgory'      => $request->subcatgory,
                'start_date'      => $request->start_date,
                'end_date'        => $request->end_date,
                'total_days'      => $request->total_days,
            ];

            // update banner image only if provided
            if (!empty($request->upload_banner)) {
                $updateData['upload_banner'] = $request->upload_banner;
            }

            $banner->update($updateData);

            return [
                'status'  => 'success',
                'message' => 'Promotional Banner Updated Successfully',
                'data'    => $banner
            ];

        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ];
        }
    }

    public function deletePromotionalBanner($bannerId)
    {
        try {
            $data = sellerBanner::find($bannerId);

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
                'message' => 'Promotional Banner deleted successfully',
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

    public function getPromotionalBanners($request)
    {
        try {
            $limit = (int) $request->input('limit', 10);

            $query = sellerBanner::with([
                'category_details',
                'subcategory_details'
            ])
            ->where('added_by', '1');

            // if ($request->filled('category')) {
            //     $categoryId = $request->input('category');

            //     $query->where('category', $categoryId);
            // }

            // if ($request->filled('sub_category')) {
            //     $subCategoryId = $request->input('sub_category');

            //     $query->where('subcatgory', $subCategoryId);
            // }

            $query->orderBy('id', 'desc');

            $banner_details = $query->paginate($limit);

            if ($banner_details->isEmpty()) {
                return [
                    'status'  => 'success',
                    'message' => 'No Banner found',
                    'data'    => (object)[]
                ];
            }

            return [
                'status'  => 'success',
                'message' => 'Banners fetched successfully',
                'data'    => $banner_details
            ];

        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => 'Failed to fetch banners: ' . $e->getMessage(),
                'data'    => []
            ];
        }
    }

    public function promotionalBannerDetails($bannerId)
    {
        try {
           $data = sellerBanner::with('category_details','subcategory_details')->find($bannerId);

            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => 'Banner not found',
                    'data' => (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Banner details fetched successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch banne details',
                'data' => []
            ];
        }
    }







    

            
        


}
    