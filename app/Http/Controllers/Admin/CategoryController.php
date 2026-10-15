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

        return response()->json([
            'success' => true,
            'status' => $category->status,
            'message' => $category->status == 1
                ? __('admin_messages.category_has_been_activated_successfully')
                : __('admin_messages.category_has_been_deactivated_successfully')
        ]);
    }

    public function deleteSubCategory($id)
    {
        $scat = SubCategory::find($id);
        if (!$scat) {
            return response()->json(['success' => false, 'message' => 'Sub Category not found.']);
        }
        $scat->delete();
        return response()->json(['success' => true, 'message' => __('admin_messages.sub_category_deleted_successfully')]);
    }

    public function updateSubCategoryStatus($id)
    {
        $scat = SubCategory::find($id);
        if (!$scat) {
            return response()->json(['success' => false, 'message' => 'Sub Category not found.']);
        }
        $scat->status = $scat->status == 1 ? 0 : 1;
        $scat->save();

        return response()->json([
            'success' => true,
            'status' => $scat->status,
            'message' => $scat->status == 1
                ? __('admin_messages.sub_category_has_been_activated_successfully')
                : __('admin_messages.sub_category_has_been_deactivated_successfully')
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
            $commonController = app(CommonController::class);
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

        return response()->json(['success' => true, 'message' => __('admin_messages.sub_category_added_successfully')]);
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
            $commonController = app(CommonController::class);
            $uploadResult = $commonController->upload($request);
            $uploadResultArray = $uploadResult->getData(true);

            if ($uploadResultArray['status'] === 'error') {
                return response()->json(['success' => false, 'message' => $uploadResultArray['message']]);
            }

            $imageUrl = $uploadResultArray['data']['url'];
            $scat->image = $imageUrl;
        }

        $scat->save();

        return response()->json(['success' => true, 'message' => __('admin_messages.sub_category_updated_successfully')]);
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $category->name = $request->name;

        if ($request->hasFile('image')) {
            $commonController = app(CommonController::class);
            $uploadResult = $commonController->upload($request);
            $uploadResultArray = $uploadResult->getData(true);

            if ($uploadResultArray['status'] === 'error') {
                return response()->json(['success' => false, 'message' => $uploadResultArray['message']]);
            }

            $imageUrl = $uploadResultArray['data']['url'];
            $category->image = $imageUrl;
        }

        $category->save();

        return response()->json(['success' => true, 'message' => __('admin_messages.category_updated_successfully')]);
    }
}
