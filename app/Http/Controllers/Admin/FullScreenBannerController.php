<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Services\FullBannerService;
use App\Services\CountryService;
use App\Models\FullBanner;
use App\Http\Controllers\CommonController;

 
class FullScreenBannerController extends Controller
{

    public function __construct(FullBannerService $FullBannerService, CountryService $CountryService)
    {
        $this->FullBannerService = $FullBannerService;
        $this->CountryService = $CountryService;
    }

    public function fullScreenBannerManagement(Request $request){
        $banners = $this->FullBannerService->getFullBanners($request)['data'];
       // dd($banners);
        $countries = $this->CountryService->getUserAllCountries()['data'];
        return view('admin.fullscreen-banner-management.index',compact('banners','countries'));
    }

    public function deleteFullScreenBanner($id)
    {
        $result = $this->FullBannerService->deleteFullBanner($id);

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

    public function addFullBanner(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'country_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'type' => 'required',
        ], [
            'image.required' => 'Please Upload an Image',
            'image.image' => 'The uploaded file must be an image',
            'image.mimes' => 'Image must be in JPEG, PNG, JPG, or GIF format',
            //'image.max' => 'Image size should not exceed 5MB',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // if ($request->hasFile('image')) {

        //     [$width, $height] = getimagesize($request->file('image'));

        //     $imageRatio = $width / $height;
        //     $tolerance  = 0.01;

        //     // Determine target ratio based on type
        //     if ($request->type == '1') {
        //         // Mobile → 9:16 (portrait)
        //         $targetRatio = 9 / 16;
        //         $ratioLabel  = '9:16';
        //     } else {
        //         // Web → 16:9 (landscape)
        //         $targetRatio = 16 / 9;
        //         $ratioLabel  = '16:9';
        //     }

        //     if ($imageRatio < ($targetRatio - $tolerance) || $imageRatio > ($targetRatio + $tolerance)) {
        //         return response()->json([
        //             'success' => false,
        //             'message' => "Image upload failed. Please upload an image with a {$ratioLabel} aspect ratio"
        //         ]);
        //     }
        // }

        if ($request->hasFile('image')) {

            [$width, $height] = getimagesize($request->file('image'));

            // Only validate aspect ratio for Mobile (type == 1)
            if ($request->type == '1') {

                $imageRatio = $width / $height;
                $tolerance  = 0.01;

                // Mobile → 9:16 (portrait)
                $targetRatio = 9 / 16;
                $ratioLabel  = '9:16';

                if (
                    $imageRatio < ($targetRatio - $tolerance) ||
                    $imageRatio > ($targetRatio + $tolerance)
                ) {
                    return response()->json([
                        'success' => false,
                        'message' => "Image upload failed. Please upload an image with a {$ratioLabel} aspect ratio"
                    ]);
                }
            }

            // No aspect ratio validation for Web or other types
        }




        $banner = new FullBanner();
        $banner->title = $request->title;
        $banner->country_id = $request->country_id;
        $banner->start_date = $request->start_date;
        $banner->end_date = $request->end_date;
        $banner->type = $request->type;

        if($request->hasFile('image')){
            $commonController = new CommonController();
            $uploadResult = $commonController->upload($request);
            $uploadResultArray = $uploadResult->getData(true); 

            if ($uploadResultArray['status'] === 'error') {
                return response()->json(['success' => false, 'message' => $uploadResultArray['message']]);
            }

            $imageUrl = $uploadResultArray['data']['url'];
            $banner->image = $imageUrl; 
        }

        $banner->save();

        return response()->json(['success' => true, 'message' => 'Banner Added Successfully!']);
    }

    public function updateFullBanner(Request $request, $id)
    {
        $banner = FullBanner::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'country_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'type' => 'required|',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // if ($request->hasFile('image')) {

        //     [$width, $height] = getimagesize($request->file('image'));

        //     $imageRatio = $width / $height;
        //     $tolerance  = 0.01;

        //     // Determine target ratio based on type
        //     if ($request->type == '1') {
        //         // Mobile → 9:16 (portrait)
        //         $targetRatio = 9 / 16;
        //         $ratioLabel  = '9:16';
        //     } else {
        //         // Web → 16:9 (landscape)
        //         $targetRatio = 16 / 9;
        //         $ratioLabel  = '16:9';
        //     }

        //     if ($imageRatio < ($targetRatio - $tolerance) || $imageRatio > ($targetRatio + $tolerance)) {
        //         return response()->json([
        //             'success' => false,
        //             'message' => "Image upload failed. Please upload an image with a {$ratioLabel} aspect ratio"
        //         ]);
        //     }
        // }

        if ($request->hasFile('image')) {

            [$width, $height] = getimagesize($request->file('image'));

            // Only validate aspect ratio for Mobile (type == 1)
            if ($request->type == '1') {

                $imageRatio = $width / $height;
                $tolerance  = 0.01;

                // Mobile → 9:16 (portrait)
                $targetRatio = 9 / 16;
                $ratioLabel  = '9:16';

                if (
                    $imageRatio < ($targetRatio - $tolerance) ||
                    $imageRatio > ($targetRatio + $tolerance)
                ) {
                    return response()->json([
                        'success' => false,
                        'message' => "Image upload failed. Please upload an image with a {$ratioLabel} aspect ratio"
                    ]);
                }
            }

            // No aspect ratio validation for Web or other types
        }


        $banner->title = $request->title;
        $banner->country_id = $request->country_id;
        $banner->start_date = $request->start_date;
        $banner->end_date = $request->end_date;
        $banner->type = $request->type;

        if ($request->hasFile('image')) {
            $commonController = new CommonController();
            $uploadResult = $commonController->upload($request);
            $uploadResultArray = $uploadResult->getData(true);

            if ($uploadResultArray['status'] === 'error') {
                return response()->json(['success' => false, 'message' => $uploadResultArray['message']]);
            }

            $imageUrl = $uploadResultArray['data']['url'];
            $banner->image = $imageUrl;
        }

        $banner->save();

        return response()->json(['success' => true, 'message' => 'Banner Updated Successfully!']);
    }





    



}