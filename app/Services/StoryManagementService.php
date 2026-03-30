<?php
namespace App\Services;

use App\Models\Story;
use App\Models\Reel;
use App\Models\Highlight;
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
                    'data' =>  (object)[]
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
                    'data' =>  (object)[]
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


    // user panel


    public function getSellerStoryOnUser($request)
    {
        try {
            $query = Story::with([
                'seller_details',
                'seller_details.country_details'
            ]);

            // Search by seller name
            // if ($request->filled('search')) {
            //     $search = $request->input('search');

            //     $query->whereHas('seller_details', function ($q) use ($search) {
            //         $q->where('first_name', 'like', '%' . $search . '%')
            //         ->orWhere('last_name', 'like', '%' . $search . '%');
            //     });
            // }

            // Filter by country
            // if ($request->filled('country')) {
            //     $country = $request->input('country');

            //     $query->whereHas('seller_details.country_details', function ($q) use ($country) {
            //         $q->where('name', 'like', '%' . $country . '%');
            //     });
            // }


            // Only last 24 hours stories
            $query->where('created_at', '>=', Carbon::now()->subDay());

            // Existing conditions
            $query->where('type', '2');
            $query->where('seller_id', $request->seller_id);
            $query->where('status', '1');
            $query->orderBy('id', 'desc');

            $story_details = $query->get();

            if ($story_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Story found',
                    'data' => (object)[]
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


    public function getAdminStoryOnUser($request)
    {
        try {
            $query = Story::query();

            $query->where('type', '1');

            //  Only last 24 hours stories
            $query->where('created_at', '>=', Carbon::now()->subDay());
            $query->where('status', '1');

            $query->orderBy('id', 'desc');

            $story_details = $query->get();

            if ($story_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Story found',
                    'data' => (object)[]
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


    public function getSellerReelOnUser($request)
    {
        try {
            $query = Reel::query();

            // Only last 24 hours 
            $query->where('created_at', '>=', Carbon::now()->subDay());

            // Existing conditions
            $query->where('type', '2');
            $query->where('seller_id', $request->seller_id);
            $query->where('status', '1');
            $query->orderBy('id', 'desc');

            $story_details = $query->get();

            if ($story_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Reel found',
                    'data' => (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Seller Reels fetched successfully',
                'data' => $story_details
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch reels: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function getSellerHighlightOnUser($request)
    {
        try {
            $query = Highlight::query();

            // Only last 24 hours 
            $query->where('created_at', '>=', Carbon::now()->subDay());

            // Existing conditions
            $query->where('type', '2');
            $query->where('seller_id', $request->seller_id);
            $query->where('status', '1');
            $query->orderBy('id', 'desc');

            $story_details = $query->get();

            if ($story_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Highlight found',
                    'data' => (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Seller Highlights fetched successfully',
                'data' => $story_details
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch highlight: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }
    
    //seller

    public function addSellerStory($request_data)
    {

        try {
            $story = Story::create([
                'file' => $request_data->file,
                'type' => 2,
                'seller_id' => $request_data->seller_id,
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

    public function addSellerReel($request_data)
    {

        try {
            $story = Reel::create([
                'file' => $request_data->file,
                'type' => 2,
                'seller_id' => $request_data->seller_id,
            ]);

            return [
                'status' => 'success',
                'message' => 'Reel added successfully',
                'data' => $story
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to add reel',
                'data' => []
            ];
        }
    }

    public function addSellerHighlight($request_data)
    {

        try {
            $story = Highlight::create([
                'file' => $request_data->file,
                'type' => 2,
                'seller_id' => $request_data->seller_id,
                'title' => $request_data->title,
            ]);

            return [
                'status' => 'success',
                'message' => 'Highlight added successfully',
                'data' => $story
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to add highlight',
                'data' => []
            ];
        }
    }

     public function deleteSellerStory($data)
    {
        try {
            $story = Story::find($data->story_id);

            if (!$story) {
                return [
                    'status' => 'error',
                    'message' => 'Story not found',
                    'data' => (object)[]
                ];
            }

            $story->delete();

            return [
                'status' => 'success',
                'message' => 'Story deleted successfully',
                'data' => (object)[]
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to delete story: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

     public function deleteSellerHighlight($data)
    {
        try {
            $story = Highlight::find($data->highlight_id);

            if (!$story) {
                return [
                    'status' => 'error',
                    'message' => 'Highlight not found',
                    'data' => (object)[]
                ];
            }

            $story->delete();

            return [
                'status' => 'success',
                'message' => 'Highlight deleted successfully',
                'data' => (object)[]
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to delete highlight: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

     public function deleteSellerReel($data)
    {
        try {
            $story = Reel::find($data->reel_id);

            if (!$story) {
                return [
                    'status' => 'error',
                    'message' => 'Reel not found',
                    'data' => (object)[]
                ];
            }

            $story->delete();

            return [
                'status' => 'success',
                'message' => 'Reel deleted successfully',
                'data' => (object)[]
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to delete reel: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }




    

            
        


}
    