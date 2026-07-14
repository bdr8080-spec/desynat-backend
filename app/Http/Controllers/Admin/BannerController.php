<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Services\BannerService;

 
class BannerController extends Controller
{

    public function __construct(BannerService $BannerService)
    {
        $this->BannerService = $BannerService;
    }

    public function bannerManagement(Request $request){
        $request->merge(['type' => 1]);
        $topBanner = $this->BannerService->getBanners($request)['data'];
       // dd($topBanner);

        $request->merge(['type' => 2]);
        $bottomBanner = $this->BannerService->getBanners($request)['data'];

        $request->merge(['type' => 3]);
        $subCategoryBanner = $this->BannerService->getBanners($request)['data'];

        $storyPerDayPrice = $this->BannerService->getSellerStoryPrice($request)['data'];

        
        return view('admin.banner-management.index',compact('topBanner','bottomBanner','subCategoryBanner','storyPerDayPrice'));
    }

    public function update_banner(Request $request)
    {
        $request->validate([
            'per_day_price' => 'required',
            'banner_id'          => 'required|integer',
        ]);

        try {
            $updatedBanner = $this->BannerService->updateBannerPrice($request);
            $message = $updatedBanner['message'];

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => $updatedBanner
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update banner',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update_story_per_day_price(Request $request)
    {
        $request->validate([
            'per_day_price' => 'required',
            'country_id'          => 'required|integer',
        ]);

        try {
            $updatedBanner = $this->BannerService->addUpdateSellerStoryPrice($request);
            $message = $updatedBanner['message'];

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => $updatedBanner
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update banner',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    



}