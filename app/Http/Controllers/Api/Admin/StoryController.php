<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\StoryManagementService;
use App\Models\story;


use Validator;

class StoryController extends Controller
{

    public function __construct(StoryManagementService $StoryManagementService){

        $this->StoryManagementService=$StoryManagementService;

    }


    public function get_seller_stories(Request $req)
    {
        try {
            $data = $this->StoryManagementService->getSelletStory($req);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function get_admin_stories(Request $req)
    {
        try {
            $data = $this->StoryManagementService->getAdminStory($req);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }




    public function add_story(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'file' => 'required',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 400);
        }

        try {
            $request_data=(object )[
                'file'=>$request->file,
                'thumbnail' => $request->thumbnail??null,
            ];
            
            $result = $this->StoryManagementService->addStory($request_data);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }


    public function delete_story(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'story_id' => 'required|exists:stories,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->StoryManagementService->deleteStory($request->story_id);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function add_story_comment(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'story_id' => 'required|exists:stories,id',
            'comment' => 'required',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 400);
        }

        try {
            $userId = auth()->id();
            $request_data=(object )[
                'story_id'=>$request->story_id,
                'comment' => $request->comment,
                'user_id' => $userId,
                'user_type' => 1,
            ];
            
            $result = $this->StoryManagementService->addCommentOnSellerStory($request_data);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }




    

    


      






}