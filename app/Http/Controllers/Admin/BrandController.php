<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdminAuthService;
use App\Models\Admin;
use App\Models\Brand;
use Validator;
use App\Http\Controllers\CommonController;
 
class BrandController extends Controller
{


    public function brandManagement(Request $request){
        $brands = Brand::orderBy('id', 'desc')->get();
        return view('admin.brand-management.index',compact('brands'));
    }

    public function deleteBrand($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json(['success' => false, 'message' => 'Brand not found.']);
        }
        $brand->delete();
        return response()->json(['success' => true, 'message' => 'Brand deleted successfully!']);
    }

    public function updateBrandStatus($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json(['success' => false, 'message' => 'Brand not found.']);
        }
        $brand->status = $brand->status == 1 ? 0 : 1;
        $brand->save();
        $statusText = $brand->status == 1 ? 'Activated' : 'Deactivated';

        return response()->json([
            'success' => true,
            'message' => "Brand has been {$statusText} Successfully!"
        ]);
    }

    public function addBrand(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $brand = new Brand();
        $brand->name_english = $request->name_english;
        $brand->name_arabic = $request->name_arabic;

        if($request->hasFile('image')){
            $commonController = new CommonController();
            $uploadResult = $commonController->upload($request);
            $uploadResultArray = $uploadResult->getData(true); 

            if ($uploadResultArray['status'] === 'error') {
                return response()->json(['success' => false, 'message' => $uploadResultArray['message']]);
            }

            $imageUrl = $uploadResultArray['data']['url'];
            $brand->image = $imageUrl; 
        }

        $brand->status = 1;
        $brand->save();

        return response()->json(['success' => true, 'message' => 'Brand added successfully!']);
    }

    public function updateBrand(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $brand->name_english = $request->name_english;
        $brand->name_arabic = $request->name_arabic;

        if ($request->hasFile('image')) {
            $commonController = new CommonController();
            $uploadResult = $commonController->upload($request);
            $uploadResultArray = $uploadResult->getData(true);

            if ($uploadResultArray['status'] === 'error') {
                return response()->json(['success' => false, 'message' => $uploadResultArray['message']]);
            }

            $imageUrl = $uploadResultArray['data']['url'];
            $brand->image = $imageUrl;
        }

        $brand->save();

        return response()->json(['success' => true, 'message' => 'Brand updated successfully!']);
    }






}