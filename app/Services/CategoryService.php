<?php
namespace App\Services;

use App\Models\Category;
use App\Models\SubCategory;


class CategoryService
{
   
    public function getCategory($request)
    {
        try {
            $category_details = Category::where('status', 1)->get();

            if ($category_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No categories found',
                    'data' => []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Categories fetched successfully',
                'data' => $category_details
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch categories: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function getSubCategoriesByCategoryId($categoryId)
    {
        try {
            $subCategories = SubCategory::where('category_id', $categoryId)->where('status', 1)->get();

            if ($subCategories->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No subcategories found for this category',
                    'data' => []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Subcategories fetched successfully',
                'data' => $subCategories
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch subcategories: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }



    

            
        


}
    