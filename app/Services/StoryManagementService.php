<?php
namespace App\Services;

use App\Models\Story;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use Carbon\Carbon;


class StoryManagementService
{
   
    public function getSelletStory($request)
    {
        try {
            $limit = $request->input('limit');
            $limit = (int)$limit;

            $query = Story::with([
                'seller_details',
                'seller_details.country_details'
            ]);

            if ($request->filled('search')) {
                $search = $request->input('search');

                $query->whereHas('seller_details', function ($q) use ($search) {
                    $q->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%');
                });
            }

            if ($request->filled('country')) {
                $country = $request->input('country');

                $query->whereHas('seller_details.country_details', function ($q) use ($country) {
                    $q->where('name', 'like', '%' . $country . '%');
                });
            }
            
            $query->where('type', '2');
            $query->orderBy('id', 'desc');

            $story_details = $query->paginate($limit);

            if ($story_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Story found',
                    'data' =>  []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Seller Stories fetched successfully',
                'data' => $story_details
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch story: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function getAdminStory($request)
    {
        try {
            $limit = $request->input('limit');
            $limit = (int)$limit;

            $query = Story::query();

            // if ($request->filled('search')) {
            //     $search = $request->input('search');
            //     $query->where('name_english', 'like', '%' . $search . '%');
            // }

            $query->where('type', '1');
            $query->orderBy('id', 'desc');

            $story_details = $query->paginate($limit);

            if ($story_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Story found',
                    'data' =>  []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Admin Stories fetched successfully',
                'data' => $story_details
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch story: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }




    public function addStory(Request $request)
    {

        try {
            $story = Story::create([
                'file' => $request->file,
            ]);

            return [
                'status' => 'success',
                'message' => 'Story added successfully',
                'data' => $story
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to add story',
                'data' => []
            ];
        }
    }


    public function deleteStory($storyId)
    {
        try {
            $story = Story::find($storyId);

            if (!$story) {
                return [
                    'status' => 'error',
                    'message' => 'Deal not found',
                    'data' => []
                ];
            }
            $story->delete();

            return [
                'status' => 'success',
                'message' => 'Story deleted successfully',
                'data' => []
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to delete story',
                'data' => []
            ];
        }
    }





    

            
        


}
    