<?php
namespace App\Services;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;


class BrandService
{
   
    public function getBrand($request)
    {
        try {
            $limit = $request->input('limit', 10);
            $limit = (int)$limit;
            $brand_details = Brand::where('status', 1)->paginate($limit);

            if ($brand_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Brand found',
                    'data' => []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Brands fetched successfully',
                'data' => $brand_details
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch brands: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    public function changeBrandStatus($brandId)
    {
        try {
            $brand = Brand::find($brandId);

            if (!$brand) {
                return [
                    'status' => 'error',
                    'message' => 'Brand not found',
                    'data' => []
                ];
            }

            $brand->status = $brand->status == 1 ? 0 : 1;
            $brand->save();

            return [
                'status' => 'success',
                'message' => 'Brand status updated successfully',
                'data' => $brand
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch Brand: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    public function createBrand(Request $request)
    {
        $commonController = new CommonController();
        $uploadResult = $commonController->upload($request);
        $uploadResultArray = $uploadResult->getData(true); 

        if ($uploadResultArray['status'] === 'error') {
            return $uploadResult;  
        }

        try {
            $imageUrl = $uploadResultArray['data']['url'];
            $brand = Brand::create([
                'name_english' => $request->name_english,
                'name_arabic' => $request->name_arabic,
                'image' => $imageUrl,
            ]);

            return [
                'status' => 'success',
                'message' => 'Brand created successfully',
                'data' => $brand
            ];

        } catch (\Exception $e) {
            Log::error('Failed to create Brand: ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Failed to create Brand',
                'data' => []
            ];
        }
    }

    public function updateBrand(Request $request, $brandId)
    {
        $brand = Brand::find($brandId);

        if (!$brand) {
            return [
                'status' => 'error',
                'message' => 'Brand not found',
                'data' => []
            ];
        }

        if ($request->hasFile('image')) {
            $commonController = new CommonController();
            $uploadResult = $commonController->upload($request);
            $uploadResultArray = $uploadResult->getData(true); 

            if ($uploadResultArray['status'] === 'error') {
                return $uploadResult; 
            }

            $imageUrl = $uploadResultArray['data']['url'];
        } else {
            $imageUrl = $brand->image;
        }

        try {
            $brand->update([
                'name_english' => $request->name_english,
                'name_arabic' => $request->name_arabic,
                'image' => $imageUrl,  
            ]);

            return [
                'status' => 'success',
                'message' => 'Brand updated successfully',
                'data' => $brand
            ];

        } catch (\Exception $e) {
            Log::error('Failed to update brand: ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Failed to update brand',
                'data' => []
            ];
        }
    }

    public function deleteBrand($brandId)
    {
        try {
            $brand = Brand::find($brandId);

            if (!$brand) {
                return [
                    'status' => 'error',
                    'message' => 'Brand not found',
                    'data' => []
                ];
            }
            $brand->delete();

            return [
                'status' => 'success',
                'message' => 'Brand deleted successfully',
                'data' => []
            ];

        } catch (\Exception $e) {
            Log::error('Failed to delete brand: ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Failed to delete brand',
                'data' => []
            ];
        }
    }





    

            
        


}
    