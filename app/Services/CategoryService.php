<?php
namespace App\Services;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;


class CategoryService
{
   
    public function getCategory($request)
    {
        try {
            $category_details = Category::orderBy('id', 'asc')->get();

            if ($category_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No categories found',
                    'data' => (object) []
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

    public function getSubCategoriesByCategoryId($categoryId, $limit = null, $search = null)
    {
        try {
            $limit = !empty($limit) ? (int)$limit : null;

            $query = SubCategory::where('category_id', $categoryId);

            if (!empty($search)) {
                $query->where('name_english', 'like', '%' . $search . '%');
            }

            $query->orderBy('id', 'desc');

            $subCategories = $query->paginate($limit);

            if ($subCategories->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No subcategories found for this category',
                    'data' => (object) []
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


    public function changeCategoryStatus($categoryId)
    {
        try {
            $category = Category::find($categoryId);

            if (!$category) {
                return [
                    'status' => 'error',
                    'message' => 'Category not found',
                    'data' => []
                ];
            }

            $category->status = $category->status == 1 ? 0 : 1;
            $category->save();

            return [
                'status' => 'success',
                'message' => 'Category status updated successfully',
                'data' => $category
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch Category: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function changeSubCategoryStatus($subCategoryId)
    {
        try {
            $subCategory = SubCategory::find($subCategoryId);

            if (!$subCategory) {
                return [
                    'status' => 'error',
                    'message' => 'Sub Category not found',
                    'data' => []
                ];
            }

            $subCategory->status = $subCategory->status == 1 ? 0 : 1;
            $subCategory->save();

            return [
                'status' => 'success',
                'message' => 'Sub Category status updated successfully',
                'data' => $subCategory
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch Sub Category: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function createSubCategory(Request $request)
    {

        try {
            $subCategory = SubCategory::create([
                'category_id' => $request->category_id,
                'name_english' => $request->name_english,
                'name_arabic' => $request->name_arabic,
                'image' => $request->image,
            ]);

            return [
                'status' => 'success',
                'message' => 'Subcategory created successfully',
                'data' => $subCategory
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to create subcategory',
                'data' => []
            ];
        }
    }

    public function updateSubCategory(Request $request, $subCategoryId)
    {
        $subCategory = SubCategory::find($subCategoryId);

        if (!$subCategory) {
            return [
                'status' => 'error',
                'message' => 'Category not found',
                'data' => []
            ];
        }

        try {
            $subCategory->update([
                'name_english' => $request->name_english,
                'name_arabic' => $request->name_arabic,
                'image' => $request->image,  
            ]);

            return [
                'status' => 'success',
                'message' => 'Sub Category updated successfully',
                'data' => $subCategory
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update category',
                'data' => []
            ];
        }
    }

    public function deleteSubCategory($subCategoryId)
    {
        try {
            $subCategory = SubCategory::find($subCategoryId);

            if (!$subCategory) {
                return [
                    'status' => 'error',
                    'message' => 'Subcategory not found',
                    'data' => []
                ];
            }
            $subCategory->delete();

            return [
                'status' => 'success',
                'message' => 'Subcategory deleted successfully',
                'data' => []
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to delete subcategory',
                'data' => []
            ];
        }
    }





    

            
        


}
    