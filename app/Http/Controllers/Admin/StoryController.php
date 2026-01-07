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
        $countries = $this->CountryService->getUserAllCountries()['data'];
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

    public function addStory(Request $request)
    {
       //dd($request->all());
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:jpeg,png,jpg,gif,mp4,mov,avi,mkv|max:51200',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $story = new Story();

        if($request->hasFile('file')){
            //dd('123');
            $commonController = new CommonController();
            $uploadResult = $commonController->uploadFile($request);
            $uploadResultArray = $uploadResult->getData(true); 

            if ($uploadResultArray['status'] === 'error') {
                return response()->json(['success' => false, 'message' => $uploadResultArray['message']]);
            }

            $imageUrl = $uploadResultArray['data']['url'];
            $story->file = $imageUrl; 
        }

        $story->save();

        return response()->json(['success' => true, 'message' => 'Story Added Successfully!']);
    }




    



}