<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdminAuthService;
use App\Models\Category;
use Validator;
use App\Http\Controllers\CommonController;
 
class CategoryController extends Controller
{


    public function categoryManagement(Request $request){
        $Categories = Category::all();
        return view('admin.category-management.index',compact('Categories'));
    }

    public function manageSubCategory($id){
        return view('admin.category-management.manage');
    }

    public function updateCategoryStatus($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category not found.']);
        }
        $category->status = $category->status == 1 ? 0 : 1;
        $category->save();
        $statusText = $category->status == 1 ? 'Activated' : 'Deactivated';

        return response()->json([
            'success' => true,
            'message' => "Category has been {$statusText} Successfully!"
        ]);
    }
}