<?php
namespace App\Services;

use App\Models\Story;
use App\Models\Reel;
use App\Models\Highlight;
use App\Models\WhislistReel;
use App\Models\StoriesComment;
use App\Models\StorySeenHistory;
use App\Models\SellerSubcriptionPlanBuy;
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
                'seller_details.store_info.country_info',
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

                $query->whereHas('seller_details.store_info.country_info', function ($q) use ($country) {
                    $q->where('name', 'like', '%' . $country . '%');
                });
            }
            
            $query->where('type', '2');
            $query->orderBy('id', 'desc');

            $story_details = $query->paginate($limit);
           // dd(auth()->id());

            $story_details->getCollection()->transform(function ($story) {

                $type = 3;

                $story->is_seen = \App\Models\StorySeenHistory::where('story_id', $story->id)
                    ->where('user_id', auth()->id())
                    ->where('type', $type)
                    ->exists() ? 1 : 0;

                return $story;
            });

            if ($story_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => __('Service_messages.no_story_found'),
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

            $story_details->getCollection()->transform(function ($story) {

                $type = 3;

                $story->is_seen = \App\Models\StorySeenHistory::where('story_id', $story->id)
                    ->where('user_id', auth()->id())
                    ->where('type', $type)
                    ->exists() ? 1 : 0;

                return $story;
            });

            if ($story_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => __('Service_messages.no_story_found'),
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




    public function addStory($request)
    {


        try {

            $story = Story::create([
                'file' => $request->file,
                'thumbnail' => $request->thumbnail??null,
                'type'=>'1'
            ]);

            return [
                'status' => 'success',
                'message' => __('Service_messages.story_added_successfully'),
                'data' => $story
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
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
                'message' => __('Service_messages.story_deleted_successfully'),
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
            $query->orderBy('id', 'asc');

            $story_details = $query->get();

                $story_details = $story_details->map(function ($story) {

                $type = 2;

                $story->is_seen = \App\Models\StorySeenHistory::where('story_id', $story->id)
                    ->where('user_id', auth()->id())
                    ->where('type', $type)
                    ->exists() ? 1 : 0;

                return $story;
            });

            if ($story_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => __('Service_messages.no_story_found'),
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

    public function getSellerStoryOnUserNew($request)
    {
        try {
            $query = Story::query();


            // Only last 24 hours stories
            $query->where('created_at', '>=', Carbon::now()->subDay());

            // Existing conditions
            $query->where('type', '2');
            $query->where('seller_id', $request->seller_id);
            $query->where('status', '1');
            $query->orderBy('id', 'asc');

            $story_details = $query->get();

                $story_details = $story_details->map(function ($story) {

                $type = 1;

                $story->is_seen = \App\Models\StorySeenHistory::where('story_id', $story->id)
                    ->where('user_id', $request->user_id)
                    ->where('type', $type)
                    ->exists() ? 1 : 0;

                return $story;
            });

            if ($story_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => __('Service_messages.no_story_found'),
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
            
            // $query->orderBy('id', 'asc');

            $story_details = $query->get();

                $story_details = $story_details->map(function ($story) {

                $type = 1;

                $story->is_seen = \App\Models\StorySeenHistory::where('story_id', $story->id)
                    ->where('user_id', $request->user_id)
                    ->where('type', $type)
                    ->exists() ? 1 : 0;

                return $story;
            });

            if ($story_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => __('Service_messages.no_story_found'),
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



    public function getAdminStoryOnSeller($request)
    {
        try {
            $query = Story::query();

            $query->where('type', '1');

            //  Only last 24 hours stories
            $query->where('created_at', '>=', Carbon::now()->subDay());
            $query->where('status', '1');

            $query->orderBy('id', 'asc');

            $story_details = $query->get();

            $story_details = $story_details->map(function ($story) {

                $type = 2;

                $story->is_seen = \App\Models\StorySeenHistory::where('story_id', $story->id)
                    ->where('user_id', auth()->id())
                    ->where('type', $type)
                    ->exists() ? 1 : 0;

                return $story;
            });

            if ($story_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => __('Service_messages.no_story_found'),
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
                    'message' => __('Service_messages.no_reel_found'),
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
           // $query->where('created_at', '>=', Carbon::now()->subDay());

            // Existing conditions
            $query->where('type', '2');
            $query->where('seller_id', $request->seller_id);
            $query->where('status', '1');
            $query->orderBy('id', 'desc');

            $story_details = $query->get();

            if ($story_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => __('Service_messages.no_highlights_found'),
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

            $subscription = SellerSubcriptionPlanBuy::where('seller_id', $request_data->seller_id)
                ->where('payment_status', '1')
                ->where('status', '1')
                ->whereDate('plan_end_date', '>=', Carbon::today())
                ->first();

            if (!$subscription) {
                return [
                    'status' => 'failed',
                    'message' => __('Service_messages.no_active_plan'),
                    'data' => []
                ];
            }

            if ($subscription->stories !== '1') {
                return [
                    'status' => 'error',
                    'message' => __('Service_messages.story_limit_reached_for_plan'),
                    'data' => []
                ];
            }

            $story = Story::create([
                'file' => $request_data->file,
                'type' => 2,
                'seller_id' => $request_data->seller_id,
                'thumbnail' => $request_data->thumbnail??null,
            ]);

            return [
                'status' => 'success',
                'message' => __('Service_messages.story_added_successfully'),
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

    // public function addSellerReel($request_data)
    // {

    //     try {
    //         $story = Reel::create([
    //             'file' => $request_data->file,
    //             'type' => 2,
    //             'seller_id' => $request_data->seller_id,
    //             'caption' => $request_data->caption,
    //             'thumbnail' => $request_data->thumbnail??null,
    //         ]);

    //         return [
    //             'status' => 'success',
    //             'message' => 'Reel added successfully',
    //             'data' => $story
    //         ];

    //     } catch (\Exception $e) {
    //         return [
    //             'status' => 'error',
    //             'message' => 'Failed to add reel',
    //             'data' => []
    //         ];
    //     }
    // }

    

    public function addSellerReel($request_data)
    {
        try {

            $subscription = SellerSubcriptionPlanBuy::where('seller_id', $request_data->seller_id)
                ->where('payment_status', '1')
                ->where('status', '1')
                ->whereDate('plan_end_date', '>=', Carbon::today())
                ->first();

            if (!$subscription) {
                return [
                    'status' => 'failed',
                    'message' => __('Service_messages.no_active_plan'),
                    'data' => []
                ];
            }

            if ($subscription->no_of_videos !== null) {

                if ($subscription->no_of_videos <= '0') {
                    return [
                        'status' => 'error',
                        'message' => __('Service_messages.reel_upload_limit_reached'),
                        'data' => []
                    ];
                }
            }

            $story = Reel::create([
                'file' => $request_data->file,
                'type' => 2,
                'seller_id' => $request_data->seller_id,
                'caption' => $request_data->caption,
                'thumbnail' => $request_data->thumbnail ?? null,
            ]);

            if ($subscription->no_of_videos !== null) {
                $subscription->decrement('no_of_videos');
            }

            return [
                'status' => 'success',
                'message' => __('Service_messages.reel_added_successfully'),
                'data' => $story
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to add reel',
                'data' => $e->getMessage()
            ];
        }
    }

    // public function addSellerHighlight($request_data)
    // {

    //     try {
    //         $story = Highlight::create([
    //             'file' => $request_data->file,
    //             'type' => 2,
    //             'seller_id' => $request_data->seller_id,
    //             'title' => $request_data->title,
    //             'thumbnail' => $request_data->thumbnail??null,
    //         ]);

    //         return [
    //             'status' => 'success',
    //             'message' => 'Highlight added successfully',
    //             'data' => $story
    //         ];

    //     } catch (\Exception $e) {
    //         return [
    //             'status' => 'error',
    //             'message' => 'Failed to add highlight',
    //             'data' => []
    //         ];
    //     }
    // }


    public function addSellerHighlight($request_data)
    {
        try {

            $subscription = SellerSubcriptionPlanBuy::where('seller_id', $request_data->seller_id)
                ->where('payment_status', '1')
                ->where('status', '1')
                ->whereDate('plan_end_date', '>=', Carbon::today())
                ->first();

            if (!$subscription) {
                return [
                    'status' => 'failed',
                    'message' => __('Service_messages.no_active_plan'),
                    'data' => []
                ];
            }

            if ($subscription->no_of_highlights !== null && $subscription->no_of_highlights <= '0') {
                return [
                    'status' => 'error',
                    'message' => __('Service_messages.highlight_limit_reached'),
                    'data' => []
                ];
            }

            $story = Highlight::create([
                'file' => $request_data->file,
                'type' => 2,
                'seller_id' => $request_data->seller_id,
                'title' => $request_data->title,
                'thumbnail' => $request_data->thumbnail ?? null,
            ]);

            if ($subscription->no_of_highlights !== null) {
                $subscription->decrement('no_of_highlights');
            }

            return [
                'status' => 'success',
                'message' => __('Service_messages.highlight_added_successfully'),
                'data' => $story
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to add highlight',
                'data' => $e->getMessage()
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
                'message' => __('Service_messages.story_deleted_successfully'),
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
                'message' => __('Service_messages.highlight_deleted_successfully'),
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
                'message' => __('Service_messages.reel_deleted_successfully'),
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
            $reel->thumbnail = $request_data->thumbnail??null;
            $reel->updated_at = now();
            $reel->created_at = now(); 
            $reel->save();

            return [
                'status' => 'success',
                'message' => __('Service_messages.reel_updated_successfully'),
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

            $message = $reel->status == 1
                ? __('Service_messages.reel_activated_successfully')
                : __('Service_messages.reel_inactivated_successfully');

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
                        ->where('type', 2)
                        ->orderBy('id', 'asc');

            // Paginate if limit provided, else fetch all
            if (!empty($request_data->limit)) {
                $stories = $query->paginate((int)$request_data->limit);

                $stories->getCollection()->transform(function ($story) {

                    $type = 1;

                    $story->is_seen = \App\Models\StorySeenHistory::where('story_id', $story->id)
                        ->where('user_id', auth()->id())
                        ->where('type', $type)
                        ->exists() ? 1 : 0;

                    return $story;
                });

            } else {
                $stories = $query->get();

                $stories = $stories->map(function ($story) {

                    $type = 1;

                    $story->is_seen = \App\Models\StorySeenHistory::where('story_id', $story->id)
                        ->where('user_id', auth()->id())
                        ->where('type', $type)
                        ->exists() ? 1 : 0;

                    return $story;
                });
            }

            if ($stories->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => __('Service_messages.no_story_found'),
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
                    'message' => __('Service_messages.no_reel_found'),
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
             
            if (!empty($request_data->limit)) {
                return [
                    'status' => 'success',
                    'message' => __('Service_messages.no_highlights_found'),
                    'data' =>(object)[]
                ];
            }else{
                return [
                    'status' => 'success',
                    'message' => __('Service_messages.no_highlights_found'),
                    'data' => []
                ];

            }



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
                    'message' => __('user_messages.reel_removed_from_whishlist'),
                    'data' => (object)[]
                ];
            } else {
                $data = WhislistReel::create([
                    'user_id' => $request_data->user_id,
                    'reel_id' => $request_data->reel_id,
                ]);

                return [
                    'status' => 'success',
                    'message' => __('user_messages.reel_added_to_whishlist'),
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
            $subscription = SellerSubcriptionPlanBuy::where('seller_id', $request_data->seller_id)
                ->where('payment_status', '1')
                ->where('status', '1')
                ->whereDate('plan_end_date', '>=', Carbon::today())
                ->first();

            if (!$subscription) {
                return [
                    'status' => 'failed',
                    'message' => __('Service_messages.no_active_plan'),
                    'data' => []
                ];
            }

            if ($subscription->stories !== '1') {
                return [
                    'status' => 'error',
                    'message' => __('Service_messages.story_limit_reached_for_plan'),
                    'data' => []
                ];
            }
            
            $story = new Story();
            $story->seller_id = $request_data->seller_id;
            $story->file = $request_data->file;
            $story->type = 2;

            $story->save();

            return [
                'status' => 'success',
                'message' => __('Service_messages.story_added_successfully'),
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

            $subscription = SellerSubcriptionPlanBuy::where('seller_id', $request_data->seller_id)
                ->where('payment_status', '1')
                ->where('status', '1')
                ->whereDate('plan_end_date', '>=', Carbon::today())
                ->first();

            if (!$subscription) {
                return [
                    'status' => 'failed',
                    'message' => __('Service_messages.no_active_plan'),
                    'data' => []
                ];
            }

            if ($subscription->no_of_highlights !== null && $subscription->no_of_highlights <= '0') {
                return [
                    'status' => 'error',
                    'message' => __('Service_messages.highlight_limit_reached'),
                    'data' => []
                ];
            }
            
            $story = new Highlight();
            $story->seller_id = $request_data->seller_id;
            $story->file = $request_data->file;
            $story->title = $request_data->title;
            $story->type = 2;

            $story->save();

            return [
                'status' => 'success',
                'message' => __('Service_messages.highlight_added_successfully'),
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

    // public function addCommentOnSellerStory($request_data)
    // {
    //     try {
    //         $storyComment = new StoriesComment();
    //         $storyComment->story_id = $request_data->story_id;
    //         $storyComment->comment = $request_data->comment;
    //         $storyComment->user_id = $request_data->user_id;
    //         $storyComment->user_type = $request_data->user_type;

    //         $storyComment->save();

    //         return [
    //             'status' => 'success',
    //             'message' => 'Comment added successfully',
    //             'data' => $storyComment
    //         ];

    //     } catch (\Exception $e) {
    //         return [
    //             'status' => 'error',
    //             'message' => 'Failed to add comment: ' . $e->getMessage(),
    //             'data' => []
    //         ];
    //     }
    // }

    public function seeStory($request_data)
    {
        try {

            $story = Story::where('id', $request_data->story_id)
                ->first();

            if (!$story) {
                return [
                    'status' => 'error',
                    'message' => 'Story not found',
                    'data' => (object)[]
                ];
            }

            $story = StorySeenHistory::create([
                'story_id' => $request_data->story_id,
                'type' => $request_data->type,
                'user_id' => $request_data->user_id,
            ]);


            return [
                'status' => 'success',
                'message' => 'seen successfully',
                'data' => $story
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to see story',
                'data' => $e->getMessage()
            ];
        }
    }




    

            
        


}
    