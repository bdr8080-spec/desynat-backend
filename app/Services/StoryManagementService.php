<?php
namespace App\Services;

use App\Models\Story;
use App\Models\Reel;
use App\Models\Highlight;
use App\Models\WhislistReel;
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
            $query = Story::query();


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
                    'data' => []
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
                    'data' => []
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


    // public function getSellerReelOnUser($request)
    // {
    //     try {
    //         $query = Reel::query();

    //         // Only last 24 hours 
    //         $query->where('created_at', '>=', Carbon::now()->subDay());

    //         // Existing conditions
    //         $query->where('type', '2');
    //         $query->where('seller_id', $request->seller_id);
    //         $query->where('status', '1');
    //         $query->orderBy('id', 'desc');

    //         $story_details = $query->get();

    //         if ($story_details->isEmpty()) {
    //             return [
    //                 'status' => 'success',
    //                 'message' => 'No Reel found',
    //                 'data' => (object)[]
    //             ];
    //         }

    //         return [
    //             'status' => 'success',
    //             'message' => 'Seller Reels fetched successfully',
    //             'data' => $story_details
    //         ];

    //     } catch (\Exception $e) {
    //         return [
    //             'status' => 'error',
    //             'message' => 'Failed to fetch reels: ' . $e->getMessage(),
    //             'data' => []
    //         ];
    //     }
    // }

    public function getSellerReelOnUser($request)
    {
        try {
            $query = Reel::query();

            // Only last 24 hours 
            //$query->where('created_at', '>=', Carbon::now()->subDay());

            // Existing conditions
            $query->where('type', '2');
            $query->where('seller_id', $request->seller_id);
            $query->where('status', '1');
            $query->orderBy('id', 'desc');

            //  Apply pagination if limit exists
            if (!empty($request->limit)) {
                $story_details = $query->paginate((int)$request->limit);
                $collection = collect($story_details->items());
            } else {
                $story_details = $query->get();
                $collection = $story_details;
            }

            if ($collection->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Reel found',
                    'data' => []
                ];
            }

            //  Get reel IDs
            $reelIds = $collection->pluck('id')->toArray();

            //  Fetch wishlist reels
            $wishlistReels = WhislistReel::where('user_id', $request->user_id)
                ->whereIn('reel_id', $reelIds)
                ->where('status', 1)
                ->pluck('reel_id')
                ->toArray();

            $collection->transform(function ($reel) use ($wishlistReels) {
                $reel->is_whishlisted = in_array($reel->id, $wishlistReels) ? 1 : 0;
                return $reel;
            });

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
                    'data' => []
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
                'caption' => $request_data->caption,
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
                    'data' => []
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
                    'data' => []
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

    public function updateSellerReel($request_data)
    {
        try {
            $reel = Reel::find($request_data->reel_id);

            if (!$reel) {
                return [
                    'status' => 'error',
                    'message' => 'Reel not found',
                    'data' => []
                ];
            }

            // Update file and timestamps
            $reel->file = $request_data->file;
            $reel->caption = $request_data->caption;
            $reel->updated_at = now();
            $reel->created_at = now(); 
            $reel->save();

            return [
                'status' => 'success',
                'message' => 'Reel updated successfully',
                'data' => $reel
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update reel: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function updateSellerReelStatus($request_data)
    {
        try {
            $reel = Reel::find($request_data->reel_id);

            if (!$reel) {
                return [
                    'status' => 'error',
                    'message' => 'Reel not found',
                    'data' => []
                ];
            }

            $reel->status = $reel->status == 1 ? 0 : 1;
            $reel->save();

            $message = $reel->status == 1 ? 'Reel Activated successfully' : 'Reel Inactivated successfully';

            return [
                'status' => 'success',
                'message' => $message,
                'data' => $reel
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update reel status: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    public function getSellerStories($request_data)
    {
        try {
            $query = Story::where('seller_id', $request_data->seller_id)
                        ->where('type', '2')
                        ->orderBy('id', 'desc');

            // Paginate if limit provided, else fetch all
            if (!empty($request_data->limit)) {
                $stories = $query->paginate((int)$request_data->limit);
            } else {
                $stories = $query->get();
            }

            if ($stories->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No stories found',
                    'data' => (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Seller stories fetched successfully',
                'data' => $stories
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch stories: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function getSellerReels($request_data)
    {
        try {
            $query = Reel::where('seller_id', $request_data->seller_id)
                        ->where('type', '2')
                        ->orderBy('id', 'desc');

            // Paginate if limit provided, else fetch all
            if (!empty($request_data->limit)) {
                $stories = $query->paginate((int)$request_data->limit);
            } else {
                $stories = $query->get();
            }

            if ($stories->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No reel found',
                    'data' => (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Seller reels fetched successfully',
                'data' => $stories
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch reels: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    public function getSellerHighlights($request_data)
    {
        try {
            $query = Highlight::where('seller_id', $request_data->seller_id)
                        ->where('type', '2')
                        ->orderBy('id', 'desc');

            // Paginate if limit provided, else fetch all
            if (!empty($request_data->limit)) {
                $stories = $query->paginate((int)$request_data->limit);
            } else {
                $stories = $query->get();
            }

            if ($stories->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No highlights found',
                    'data' => (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Seller highlights fetched successfully',
                'data' => $stories
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch highlights: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function addRemoveReelToWhislist($request_data)
    {
        try {
            $existing = WhislistReel::where('user_id', $request_data->user_id)
                ->where('reel_id', $request_data->reel_id)
                ->first();

            if ($existing) {
                $existing->delete();

                return [
                    'status' => 'success',
                    'message' => 'Reel removed from wishlist',
                    'data' => (object)[]
                ];
            } else {
                $data = WhislistReel::create([
                    'user_id' => $request_data->user_id,
                    'reel_id' => $request_data->reel_id,
                ]);

                return [
                    'status' => 'success',
                    'message' => 'Reel added to wishlist',
                    'data' => $data
                ];
            }

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Something went wrong',
                'data' => []
            ];
        }
    }

    public function shareReel($request_data)
    {
        try {
            $reel = Reel::select('id', 'file')
                ->where('id', $request_data->reel_id)
                ->first();

            if (!$reel) {
                return [
                    'status' => 'error',
                    'message' => 'Reel not found',
                    'data' => (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Reel link fetched successfully',
                'data' => [
                    'reel_id' => $reel->id,
                    'file' => $reel->file
                ]
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch reel',
                'data' => (object)[]
            ];
        }
    }

    public function uploadStoryFromGallery($request_data)
    {
        try {
            $story = new Story();
            $story->seller_id = $request_data->seller_id;
            $story->file = $request_data->file;
            $story->type = 2;

            $story->save();

            return [
                'status' => 'success',
                'message' => 'Story uploaded successfully',
                'data' => $story
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to upload story: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function uploadHighlightFromGallery($request_data)
    {
        try {
            $story = new Highlight();
            $story->seller_id = $request_data->seller_id;
            $story->file = $request_data->file;
            $story->title = $request_data->title;
            $story->type = 2;

            $story->save();

            return [
                'status' => 'success',
                'message' => 'Highlight uploaded successfully',
                'data' => $story
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to upload highlight: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function GetWhislistedReels($request_data)
    {
        try {
            $reel = WhislistReel::with('reel_details')->where('user_id', $request_data->user_id)
                ->get();

            if (!$reel) {
                return [
                    'status' => 'error',
                    'message' => 'Whishlisted Reel not found',
                    'data' => []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Whislist Reels  fetched successfully',
                'data' => $reel
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch reel',
                'data' => (object)[]
            ];
        }
    }




    

            
        


}
    