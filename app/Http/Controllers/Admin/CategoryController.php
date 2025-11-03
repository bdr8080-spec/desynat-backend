<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdminAuthService;
use App\Models\Category;
use App\Models\SubCategory;
use Validator;
use App\Http\Controllers\CommonController;
 
class CategoryController extends Controller
{


    public function categoryManagement(Request $request){
        $Categories = Category::all();
        return view('admin.category-management.index',compact('Categories'));
    }

    public function manageSubCategory($id){
        $subcategories = SubCategory::where('category_id', $id)->orderBy('id', 'desc')->get();
        return view('admin.category-management.manage',compact('subcategories','id'));
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
            'status' => $category->status,
            'message' => "Category has been {$statusText} Successfully!"
        ]);
    }

    public function deleteSubCategory($id)
    {
        $scat = SubCategory::find($id);
        if (!$scat) {
            return response()->json(['success' => false, 'message' => 'Sub Category not found.']);
        }
        $scat->delete();
        return response()->json(['success' => true, 'message' => 'Sub Category deleted successfully!']);
    }

    public function updateSubCategoryStatus($id)
    {
        $scat = SubCategory::find($id);
        if (!$scat) {
            return response()->json(['success' => false, 'message' => 'Sub Category not found.']);
        }
        $scat->status = $scat->status == 1 ? 0 : 1;
        $scat->save();
        $statusText = $scat->status == 1 ? 'Activated' : 'Deactivated';

        return response()->json([
            'success' => true,
            'status' => $scat->status,
            'message' => "Sub Category has been {$statusText} Successfully!"
        ]);
    }

    public function addSubCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $scat = new SubCategory();
        $scat->category_id = $request->category_id;
        $scat->name_english = $request->name_english;
        $scat->name_arabic = $request->name_arabic;

        if($request->hasFile('image')){
            $commonController = new CommonController();
            $uploadResult = $commonController->upload($request);
            $uploadResultArray = $uploadResult->getData(true); 

            if ($uploadResultArray['status'] === 'error') {
                return response()->json(['success' => false, 'message' => $uploadResultArray['message']]);
            }

            $imageUrl = $uploadResultArray['data']['url'];
            $scat->image = $imageUrl; 
        }

        $scat->status = 1;
        $scat->save();

        return response()->json(['success' => true, 'message' => 'Sub Category added successfully!']);
    }

    public function updateSubCategory(Request $request, $id)
    {
        $scat = SubCategory::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $scat->category_id = $request->category_id;
        $scat->name_english = $request->name_english;
        $scat->name_arabic = $request->name_arabic;

        if ($request->hasFile('image')) {
            $commonController = new CommonController();
            $uploadResult = $commonController->upload($request);
            $uploadResultArray = $uploadResult->getData(true);

            if ($uploadResultArray['status'] === 'error') {
                return response()->json(['success' => false, 'message' => $uploadResultArray['message']]);
            }

            $imageUrl = $uploadResultArray['data']['url'];
            $scat->image = $imageUrl;
        }

        $scat->save();

        return response()->json(['success' => true, 'message' => 'Sub Category updated successfully!']);
    }
}