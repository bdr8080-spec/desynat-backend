<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Services\DealManagementService;
use App\Services\CategoryService;
use App\Services\CountryService;
use App\Services\BrandService;
use App\Models\Deal;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Log;

 
class DealManagementController extends Controller
{

    public function __construct(DealManagementService $DealManagementService, CategoryService $CategoryService, CountryService $CountryService, BrandService $BrandService)
    {
        $this->DealManagementService = $DealManagementService;
        $this->CategoryService = $CategoryService;
        $this->CountryService = $CountryService;
        $this->BrandService = $BrandService;
    }

    public function dealManagement(Request $request){
        $activeDeals = $this->DealManagementService->getActiveDeals($request)['data'];
       // dd($activeDeals);
        $expiredDeals = $this->DealManagementService->getExpireDeals($request)['data'];
        $categories = $this->CategoryService->getCategory($request)['data'];
        //dd($categories);
        return view('admin.deal-management.index',compact('activeDeals','expiredDeals','categories'));
    }

    public function sellerList(Request $request, $id){
        $countries = $this->CountryService->getCountries()['data'];
         $request->merge([
            'deal_id' => $id,
            'country' => $request->country,
        ]);
        $sellers = $this->DealManagementService->dealDetails($request,$id)['data'];
       //dd($sellers);
        return view('admin.deal-management.seller-list',compact('sellers','countries'));
    }

    public function productList(Request $request, $deal_id, $seller_id){
        $brands = $this->BrandService->getBrand($request)['data'];
        $request->merge([
            'deal_id' => $deal_id,
            'seller_id' => $seller_id,
        ]);
        $products = $this->DealManagementService->dealDetailsSellerProductList($request)['data'];
        //dd($products);
        return view('admin.deal-management.product-list',compact('products','brands'));
    }

    public function getSubCategories($categoryId)
    {
        try {
            $subCategories = $this->CategoryService->getSubCategoriesByCategoryId($categoryId)['data'];

            return response()->json([
                'status' => 'success',
                'data' => $subCategories
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch subcategories: ' . $e->getMessage()
            ]);
        }
    }

    // public function submitDeal(Request $request)
    // {
    //    //dd($request->all());
    //     $validator = Validator::make($request->all(), [
    //         'name_english' => 'required',
    //         'name_arabic' => 'required',
    //         'category_id' => 'required',
    //         'sub_category_id' => 'required',
    //         'discount' => 'required',
    //         'from' => 'required',
    //         'to' => 'required',
    //         'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
    //     ], [
    //         'image.required' => 'Please Upload an Image',
    //         'image.image' => 'The uploaded file must be an image',
    //         'image.mimes' => 'Image must be in JPEG, PNG, JPG, or GIF format',
    //         'image.max' => 'Image size should not exceed 5MB',
    //     ]);


    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     $deal = new Deal();
    //     $deal->name_english = $request->name_english;
    //     $deal->name_arabic = $request->name_arabic;
    //     $deal->category_id = $request->category_id;
    //     $deal->sub_category_id = $request->sub_category_id;
    //     $deal->discount = $request->discount;
    //     $deal->from = $request->from;
    //     $deal->to = $request->to;

    //     if($request->hasFile('image')){
    //         $commonController = new CommonController();
    //         $uploadResult = $commonController->upload($request);
    //         $uploadResultArray = $uploadResult->getData(true); 

    //         if ($uploadResultArray['status'] === 'error') {
    //             return response()->json(['success' => false, 'message' => $uploadResultArray['message']]);
    //         }

    //         $imageUrl = $uploadResultArray['data']['url'];
    //         $deal->image = $imageUrl; 
    //     }

    //     $deal->save();

    //     return response()->json(['success' => true, 'message' => 'Deal Added Successfully!']);
    // }

    public function submitDeal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_english' => 'required',
            'name_arabic' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required|array',
            'discount' => 'required',
            'from' => 'required|date',
            'to' => 'required|date',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ], [
            'image.required' => 'Please Upload an Image',
            'image.image' => 'The uploaded file must be an image',
            'image.mimes' => 'Image must be in JPEG, PNG, JPG, or GIF format',
            'image.max' => 'Image size should not exceed 5MB',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $deal = new Deal();
        $deal->name_english = $request->name_english;
        $deal->name_arabic = $request->name_arabic;
        $deal->category_id = $request->category_id;
        $deal->sub_category_id = $request->sub_category_id; 
        $deal->discount = $request->discount;
        $deal->from = $request->from;
        $deal->to = $request->to;

        if ($request->hasFile('image')) {
            $commonController = new CommonController();
            $uploadResult = $commonController->upload($request);
            $uploadResultArray = $uploadResult->getData(true);

            if ($uploadResultArray['status'] === 'error') {
                return response()->json(['success' => false, 'message' => $uploadResultArray['message']]);
            }

            $deal->image = $uploadResultArray['data']['url'];
        }

        $deal->save();

        return response()->json(['success' => true, 'message' => __('admin_messages.deal_added_successfully')]);
    }


    public function updateDeal(Request $request, $id)
    {
        //Log::info('Update Deal Request Data:', $request->all());
        $deal = Deal::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name_english' => 'required',
            'name_arabic' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required|array',
            'discount' => 'required',
            'from' => 'required',
            'to' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $deal->name_english = $request->name_english;
        $deal->name_arabic = $request->name_arabic;
        $deal->category_id = $request->category_id;
        $deal->sub_category_id = $request->sub_category_id;
        $deal->discount = $request->discount;
        $deal->from = $request->from;
        $deal->to = $request->to;

        if ($request->hasFile('image')) {
            $commonController = new CommonController();
            $uploadResult = $commonController->upload($request);
            $uploadResultArray = $uploadResult->getData(true);

            if ($uploadResultArray['status'] === 'error') {
                return response()->json(['success' => false, 'message' => $uploadResultArray['message']]);
            }

            $imageUrl = $uploadResultArray['data']['url'];
            $deal->image = $imageUrl;
        }

        $deal->save();

        return response()->json(['success' => true, 'message' => __('admin_messages.deal_updated_successfully')]);
    }

    public function deleteDeal($id)
    {
        $result = $this->DealManagementService->deleteDeal($id);

        if ($result['status'] === 'error') {
            return response()->json([
                'status' => 'error',
                'message' => $result['message']
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => $result['message']
        ], 200);
    }

    public function blockUnblockDeal($dealId)
    {
        $result = $this->DealManagementService->blockUnblockDeal($dealId);

        if ($result['status'] === 'error') {
            return response()->json([
                'status' => 'error',
                'message' => $result['message']
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => $result['message']
        ], 200);
    }







    



}