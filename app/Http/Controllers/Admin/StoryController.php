<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Services\StoryManagementService;
use App\Services\CountryService;
use App\Models\Story;
use App\Http\Controllers\CommonController;

 
class StoryController extends Controller
{

    public function __construct(StoryManagementService $StoryManagementService, CountryService $CountryService)
    {
        $this->StoryManagementService = $StoryManagementService;
        $this->CountryService = $CountryService;
    }

    public function storyManagement(Request $request){
        $sellerStory = $this->StoryManagementService->getSelletStory($request)['data'];
        //dd($sellerStory);
        $adminStory = $this->StoryManagementService->getAdminStory($request)['data'];
        $countries = $this->CountryService->getCountries()['data'];
        return view('admin.story-management.index',compact('sellerStory','adminStory','countries'));
    }

    public function deleteStory($id)
    {
        $result = $this->StoryManagementService->deleteStory($id);

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

    // public function addStory(Request $request)
    // {
    //    //dd($request->all());
    //     $validator = Validator::make($request->all(), [
    //         'file' => 'required|mimes:jpeg,png,jpg,gif,mp4,mov,avi,mkv|max:20480',
    //     ]);


    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     $story = new Story();

    //     if($request->hasFile('file')){
    //         //dd('123');
    //         $commonController = new CommonController();
    //         $uploadResult = $commonController->uploadFile($request);
    //         $uploadResultArray = $uploadResult->getData(true); 

    //         if ($uploadResultArray['status'] === 'error') {
    //             return response()->json(['success' => false, 'message' => $uploadResultArray['message']]);
    //         }

    //         $imageUrl = $uploadResultArray['data']['url'];
    //         $story->file = $imageUrl; 
    //     }

    //     $story->save();

    //     return response()->json(['success' => true, 'message' => 'Story Added Successfully!']);
    // }

    public function addStory(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json([
                'success' => false,
                'message' => 'File is required'
            ], 422);
        }

        $file = $request->file('file');

        // Allowed extensions
        $allowedExtensions = ['jpeg','png','jpg','gif','mp4','mov','avi','mkv'];
        if (!in_array($file->getClientOriginalExtension(), $allowedExtensions)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid file type'
            ], 422);
        }

        // Size check (20MB)
        $maxSize = 20 * 1024 * 1024; // bytes
        if ($file->getSize() > $maxSize) {

            if (str_starts_with($file->getMimeType(), 'video')) {
                return response()->json([
                    'success' => false,
                    'message' => "You can't upload video of more than 20 MB"
                ], 422);
            }

            return response()->json([
                'success' => false,
                'message' => "You can't upload image of more than 20 MB"
            ], 422);
        }

        $story = new Story();

        $commonController = new CommonController();
        $uploadResult = $commonController->uploadFile($request);
        $uploadResultArray = $uploadResult->getData(true);

        if ($uploadResultArray['status'] === 'error') {
            return response()->json([
                'success' => false,
                'message' => $uploadResultArray['message']
            ]);
        }

        $story->file = $uploadResultArray['data']['url'];
        $story->save();

        return response()->json([
            'success' => true,
            'message' => 'Story Added Successfully!'
        ]);
    }






    



}