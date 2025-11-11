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
            $limit = $request->input('limit');
            $limit = (int)$limit;

            $query = Brand::query();

            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where('name_english', 'like', '%' . $search . '%');
            }

            $query->orderBy('id', 'desc');

            $brand_details = $query->paginate($limit);

            if ($brand_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Brand found',
                    'data' => (object) []
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

        try {
            $brand = Brand::create([
                'name_english' => $request->name_english,
                'name_arabic' => $request->name_arabic,
                'image' => $request->image,
            ]);

            return [
                'status' => 'success',
                'message' => 'Brand created successfully',
                'data' => $brand
            ];

        } catch (\Exception $e) {
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

        try {
            $brand->update([
                'name_english' => $request->name_english,
                'name_arabic' => $request->name_arabic,
                'image' => $request->image,  
            ]);

            return [
                'status' => 'success',
                'message' => 'Brand updated successfully',
                'data' => $brand
            ];

        } catch (\Exception $e) {
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
            return [
                'status' => 'error',
                'message' => 'Failed to delete brand',
                'data' => []
            ];
        }
    }





    

            
        


}
    