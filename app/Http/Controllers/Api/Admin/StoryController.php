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

    public function get_seller_promotional_stories(Request $req)
    {

        $validate = Validator::make($req->all(), [
            'type' => 'required|in:0,1,2',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 400);
        }

        $request_data = (object)[
            'limit' => $request->limit??null,
            'search' => $request->search??null,
            'from_date' => $request->from_date??null,
            'to_date' => $request->to_date??null,
            'country_id' => $request->country_id??null,
        ];
        try {
            $data = $this->StoryManagementService->getSellerPromotionalStory($request_data);

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

    public function delete_seller_story(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'story_id' => 'required|exists:stories,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        $request_data=(object )[
            'story_id'=>$request->story_id,
        ];

        try {
            $result = $this->StoryManagementService->deleteSellerStory($request_data);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function delete_seller_reel(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'reel_id' => 'required|exists:reels,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        $request_data=(object )[
            'reel_id'=>$request->reel_id,
        ];

        try {
            $result = $this->StoryManagementService->deleteSellerReel($request_data);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function delete_seller_highlight(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'highlight_id' => 'required|exists:highlights,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        $request_data=(object )[
            'highlight_id'=>$request->highlight_id,
        ];

        try {
            $result = $this->StoryManagementService->deleteSellerHighlight($request_data);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function approve_story(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'story_id' => 'required|exists:stories,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

         $request_data=(object )[
            'story_id'=>$request->story_id,
        ];

        try {
            $result = $this->StoryManagementService->approveStory($request_data);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function reject_story(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'story_id' => 'required|exists:stories,id',
            'reason' => 'required',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        $request_data=(object )[
            'story_id'=>$request->story_id,
            'reason'=>$request->reason,
        ];

        try {
            $result = $this->StoryManagementService->rejectStory($request_data);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }





    

    


      






}