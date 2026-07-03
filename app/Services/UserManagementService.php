<?php
namespace App\Services;

use App\Models\{User,userAddress,country,Tax,ShippingCharge};
use App\Models\UserWallet;
use App\Models\UserWalletHistory;
use App\Models\all_countrie;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\DB;
use App\Models\DefaultShippingFee;
use App\Models\AffilatedUserAddress;
use App\Models\AffiliateCommission;
use App\Models\ProductLink;
use App\Models\AffiliateProduct;
use App\Models\AffiliateProductClickRecord;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\Story;
use App\Models\StorySeenHistory;

use App\Models\{ product,ProductSpecification,ProductVariant,sortFilter,wishlist,Addtocart,allproductchats,orderdetail};

use App\Models\{ seller,sellerStoreInformation,sellerDocument,Bankdetails,Plan };

use SimpleSoftwareIO\QrCode\Facades\QrCode;




class UserManagementService
{
   
    // public function getUsers($request)
    // {
    //     try {
    //         $limit = (int) $request->input('limit');

    //         $query = User::with(['country_info', 'wallet_info']);

    //         if (!empty($request->country_id)) {
    //             $query->whereHas('country_info', function ($q) use ($request) {
    //                 $q->where('id', $request->country_id);
    //             });
    //         }

    //         if (!empty($request->from_date) && !empty($request->to_date)) {
    //             $query->whereBetween('created_at', [
    //                 $request->from_date . ' 00:00:00',
    //                 $request->to_date . ' 23:59:59'
    //             ]);
    //         } elseif (!empty($request->from_date)) {
    //             $query->whereDate('created_at', '>=', $request->from_date);
    //         } elseif (!empty($request->to_date)) {
    //             $query->whereDate('created_at', '<=', $request->to_date);
    //         }

    //         if (!empty($request->search)) {
    //             $search = $request->search;
    //             $query->where(function($query) use ($search) {
    //                 $query->where('full_name', 'like', "%{$search}%")
    //                     ->orWhere('email', 'like', "%{$search}%")
    //                     ->orWhere('mobile', 'like', "%{$search}%");
    //             });
    //         }

    //         $user_details = $query->orderBy('id', 'desc')->paginate($limit);

    //         if ($user_details->isEmpty()) {
    //             return [
    //                 'status' => 'success',
    //                 'message' => 'No user found',
    //                 'data' => (object)[]
    //             ];
    //         }

    //         return [
    //             'status' => 'success',
    //             'message' => 'Users fetched successfully',
    //             'data' => $user_details
    //         ];

    //     } catch (\Exception $e) {
    //         return [
    //             'status' => 'error',
    //             'message' => 'Failed to fetch users: ' . $e->getMessage(),
    //             'data' => []
    //         ];
    //     }
    // }
    public function getUsers($request)
    {
        try {
            $limit = (int) $request->input('limit');

            // $query = User::with(['country_info', 'wallet_info']);
            $query = User::with(['country_info', 'wallet_info'])
            ->withCount([

                // Total completed orders
                'order_details as total_completed_orders' => function ($q) {
                    $q->where('payment_status', '1')
                      ->where('delivery_status', '3');
                },

                // Total cancelled orders
                'order_details as total_cancelled_orders' => function ($q) {
                    $q->where('payment_status', '2');
                }

            ]);

            if (!empty($request->country_id)) {
                $query->whereHas('country_info', function ($q) use ($request) {
                    $q->where('id', $request->country_id);
                });
            }

            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            } elseif (!empty($request->from_date)) {
                $query->whereDate('created_at', '>=', $request->from_date);
            } elseif (!empty($request->to_date)) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }

            if (!empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%");
                });
            }

            $query->orderBy('id', 'desc');

            if ($limit > 0) {
                $user_details = $query->paginate($limit);
            } else {
                $user_details = $query->get();
            }

            if ($user_details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No user found',
                    'data' => (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Users fetched successfully',
                'data' => $user_details
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch users: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }



    public function getUserDetailsById($userId)
    {
        try {
            $user = User::with(['country_info', 'wallet_info'])->find($userId);

            if (!$user) {
                return [
                    'status' => 'error',
                    'message' => 'User not found',
                    'data' => (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'User details fetched successfully',
                'data' => $user
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch user details: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    public function blockUnblockUser($userId)
    {
        try {
            $user = User::find($userId);

            if (!$user) {
                return [
                    'status' => 'error',
                    'message' => 'User not found',
                    'data' => (object)[]
                ];
            }

            $previousStatus = $user->status; 
            $user->status = $user->status == 1 ? 0 : 1;
            $user->save();

            return [
                'status' => 'success',
                'message' => $user->status == 1
                    ? __('admin_messages.user_unblocked_successfully')
                    : __('admin_messages.user_blocked_successfully'),
                'data' => $user
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update user status: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function addUserWalletAmount($userId, $amount)
    {
        DB::beginTransaction();
        try {
            $wallet = UserWallet::where('user_id', $userId)->first();

            if ($wallet) {
                $wallet->amount += $amount;
                $wallet->save();

                $message = __('admin_messages.amount_added_in_wallet_successfully');
            } else {
                $wallet = UserWallet::create([
                    'user_id' => $userId,
                    'amount' => $amount,
                ]);

                $message = __('admin_messages.amount_added_in_wallet_successfully');
            }

            $transaction = random_int(10000000, 99999999);
            $unique_id="Wal".Rand('100000','999999');
            UserWalletHistory::create([
                "unique_id"      => $unique_id,
                'user_id'        => $userId,
                'type'           => 1, 
                'transaction_id' => $transaction,
                'amount'         => $amount,
                'payment_status' => '1'
            ]);

            CreateNotification([
                'sender_id' => 1,
                'sender_type' => 1,

                'receiver_id' => $userId,
                'receiver_type' => 2,

                'title_english' => 'Add Wallet Money',
                'title_arabic' => 'إضافة رصيد إلى المحفظة',

                'description_english' => "Amount of {$amount} KD is added in your wallet by Admin, Transaction Id: {$transaction}",
                'description_arabic' => "تمت إضافة مبلغ {$amount} دينار كويتي إلى محفظتك بواسطة الإدارة، رقم العملية: {$transaction}",

                'notification_type' => 'money_added_in_wallet_by_admin'
            ]);

            DB::commit();

            return [
                'status' => 'success',
                'message' => $message,
                'data' => $wallet
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update or create wallet: ' . $e->getMessage(),
                'data' => (object)[]
            ];
        }
    }

    


    public function getStoreWithCatgory($request)
    {
        try {

            if(isset($request->subcategory) ){

                $productQuery = product::with(['category','subcategory','brand','product_specifications','product_variants'])
                 ->where('category_id', $request->category_id)
                 ->where('subcategory_id', $request->subcategory)
                 
                 ->pluck('store_id');
        

            }elseif(isset($request->category_id)){
                      $productQuery = product::with(['category','subcategory','brand','product_specifications','product_variants'])
                 ->where('category_id', $request->category_id)->pluck('store_id');
            }else{
                      $productQuery = product::with(['category','subcategory','brand','product_specifications','product_variants'])
                        ->pluck('store_id');
            }
      

            if($productQuery->isEmpty()){
                return [
                    'status' => 'success',
                    'message' => 'No Store Found',
                    'data' => []
                ];
            }


         $all_store_information=sellerStoreInformation::with('seller_information','All_product.review.user_details')->whereIn('id',$productQuery);
        //  where('Store_Availability','1')->

        if(isset($request->search)){
            $all_store_information->where('store_name', 'Like', '%'.$request->search.'%');
        }

        
        if(isset($request->availbility)){
            $all_store_information->where('Store_Availability',$request->availbility);
        }



        $all_store_information=$all_store_information->get();
        $userId = $request->user_id ?? null;

        $all_store_information->map(function ($store) use ($userId) {

            $totalRating = 0;
            $count = 0;
            $reviewCount = 0;

            foreach ($store->All_product as $product) {
                foreach ($product->review as $review) {
                    if (!empty($review->store_rating)) {
                        $totalRating += (float)$review->store_rating;
                        $count++;
                    }
                    $reviewCount++;
                }
            }

            $store->average_store_rating = $count > 0 ? round($totalRating / $count, 1) : 0;
            $store->total_review_count = $reviewCount;

            $stories = Story::where('seller_id', $store->seller_id)
                ->where('type', '2')
                ->where('created_at', '>=', Carbon::now()->subHours(24))
                ->get();

            $stories->map(function ($story) use ($userId) {

                $story->is_seen = StorySeenHistory::where('story_id', $story->id)
                    ->where('user_id', $userId)
                    ->where('type', 1)
                    ->exists() ? 1 : 0;

                return $story;
            });

            $store->seller_stories = $stories;

            return $store;
        });

        if (!empty($request->rating) && is_array($request->rating)) {

            $maxRating = max(array_map('intval', $request->rating));

            $all_store_information = $all_store_information->filter(function ($store) use ($maxRating) {

                return $store->average_store_rating <= $maxRating;

            })->values();
        }

        if (!empty($request->sort) && is_array($request->sort)) {
           //shortest delivery time

            if (in_array('0', $request->sort)) {

                // random order
                $all_store_information = $all_store_information->shuffle()->values();
            }

           //highest sale
            if (in_array('1', $request->sort)) {

                $all_store_information = $all_store_information->map(function ($store) {

                    // get store product ids
                    $productIds = product::where('store_id', $store->id)
                        ->pluck('id');

                    // count total sold products
                    $totalSales = orderdetail::whereIn('product_id', $productIds)
                        ->where('payment_status', '1')
                        ->where('delivery_status', '3')
                        ->count();

                    $store->total_sales_count = $totalSales;

                    return $store;
                });

                // sort by highest sales count
                $all_store_information = $all_store_information
                    ->sortByDesc('total_sales_count')
                    ->values();
            }
        }


            return [
                'status' => 'success',
                'message' => "All Store Information fetch Successfully",
                'data' => $all_store_information
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update or create wallet: ' . $e->getMessage(),
                'data' => (object)[]
            ];
        }
    }

    public function singleStoreWiseAllproduct($data)
    {
        try {
    
            // Step 1: Find store
            $store_information = sellerStoreInformation::with('seller_information')->find($data->store_id);
            // seller profile generate Qr Code 
            Generate_SellerQrCode($store_information->seller_id,$data->store_id);
            
            // If store not found
            if (!$store_information) {
                return [
                    'status' => 'success',
                    'message' => 'No Store Found',
                    'data'   => []
                ];
            }

            $wishlistIds = wishlist::where('user_id', $data->user_id)
                       ->pluck('product_id')
                       ->toArray();

                    // Step 2: Product query
            $products = $store_information->All_product()
                ->with([
                    'brand',
                    'category',
                    'subcategory',
                    'product_specifications',
                    'product_variants.color',
                    'product_variants.size',
                    'review',
                    'review.user_details'
                ]);
    
            // Step 3: Search
            if (!empty($data->search)) {
                $products->where('product_name_en', 'LIKE', '%' . $data->search . '%');
            }

            if (!empty($data->category_id) && is_array($data->category_id)) {

                $products->whereIn('category_id', $data->category_id);
            }

            if (!empty($data->brand_id) && is_array($data->brand_id)) {

                $products->whereIn('brand_id', $data->brand_id);
            }

            //price filter

            if (!empty($data->price_min) || !empty($data->price_max)) {

                $products->whereHas('product_variants', function ($query) use ($data) {

                    // minimum price
                    if (!empty($data->price_min)) {
                        $query->where('final_price', '>=', $data->price_min);
                    }

                    // maximum price
                    if (!empty($data->price_max)) {
                        $query->where('final_price', '<=', $data->price_max);
                    }
                });
            }

            //dicount
            if (!empty($data->discount)) {

                $products->whereHas('product_variants', function ($query) use ($data) {

                    $query->where('discount_value', '<=', $data->discount);
                });
            }

            //size filter
            if (!empty($data->size_id) && is_array($data->size_id)) {

                $products->whereHas('product_variants', function ($query) use ($data) {

                    $query->whereIn('size_id', $data->size_id);
                });
            }

            if (!empty($data->rating)) {

                $products->where(function ($q) use ($data) {

                    $q->whereHas('review', function ($query) use ($data) {

                        $query->where('product_rating', '<=', $data->rating);

                    })
                    ->orWhereDoesntHave('review');
                });
            }

            //delivery time
            if (!empty($data->delivery_time)) {

                $products->reorder()->inRandomOrder();
            }

            //delivery option
            if (!empty($data->delivery_option)) {
                $deliveryOptions = (array) $data->delivery_option;

                if (in_array('2', $deliveryOptions)) {

                    $products = $products->select('products.*')
                        ->addSelect([
                            'total_sales' => orderdetail::selectRaw('COUNT(*)')
                                ->whereColumn('orderdetails.product_id', 'products.id')
                                ->where('payment_status', '1')
                                ->where('delivery_status', '3')
                        ])
                        ->orderByDesc('total_sales');
                }

                elseif (in_array('1', $deliveryOptions)) {

                    $products->reorder()->inRandomOrder();
                }

            }

            

            // Apply Filter

            // switch ($data->sort_filter) {

            //     case 1: // Recommended
            //         // $products = $products->orderBy('recommended_score', 'desc');
            //         break;
            
            //     case 2: // Price: Low to High
            //         $products = $products->whereHas('product_variants',function($query){
            //             $query->orderBy('actual_price', 'asc');
                        
            //         });
            //         break;
            
            //     case 3: // Price: High to Low
            //         $products = $products->whereHas('product_variants',function($query){
            //             $query->orderBy('actual_price', 'desc');
                        
            //         });
            //         break;
            
            //     case 4: // Newest First
            //         $products = $products->orderBy('created_at', 'desc');
            //         break;
            
            //     case 5: // Customer Rating
            //         // $products = $products->orderBy('rating', 'desc');
            //         break;
            
            //     case 6: // Best selling
            //         // $products = $products->orderBy('total_sales', 'desc');
            //         break;
            
            //     case 7: // Fastest delivery
            //         // $products = $products->orderBy('delivery_time', 'asc');
            //         break;
            
            //     default:
            //         // No filter
            //         break;
            // }
            

            // Step 4: Pagination (convert stdClass to array)
            $products = $products->paginate()
            ->through(function ($product) use ($wishlistIds) {
                $product->wishlist = in_array($product->id, $wishlistIds) ? 1 : 0;
                $reviews = $product->review ?? [];
                if (count($reviews) > 0) {

                    $totalRating = 0;
                    $count = 0;

                    foreach ($reviews as $review) {
                        if (!empty($review->product_rating)) {
                            $totalRating += (float) $review->product_rating;
                            $count++;
                        }
                    }

                    $product->average_rating = $count > 0 ? round($totalRating / $count, 1) : 0;

                } else {
                    $product->average_rating = 0;
                }
                return $product;
            })
            ->appends((array) $data);

            $allProducts = $store_information->All_product()->with('review')->get();

                $totalStoreRating = 0;
                $storeRatingCount = 0;
                $reviewCount = 0;

                foreach ($allProducts as $product) {
                    foreach ($product->review as $review) {
                        if (!empty($review->store_rating)) {
                            $totalStoreRating += (float)$review->store_rating;
                            $storeRatingCount++;
                        }
                        $reviewCount++;
                    }
                }

                $store_information->average_store_rating = $storeRatingCount > 0
                    ? round($totalStoreRating / $storeRatingCount, 1)
                    : 0;

                $store_information->total_review_count = $reviewCount;


            // Step 5: Response
            $response = [
                'store'       => $store_information,
                'All_Product' => $products,
            ];
    
            return [
                'status'  => 'success',
                'message' => "single Store Information fetch Successfully",
                'data'    => $response
            ];
    
        } catch (\Exception $e) {
    
            return [
                'status'  => 'error',
                'message' => 'Failed: ' . $e->getMessage(),
                'data'    => (object)[]
            ];
        }
    }









    public function singleproductView($request)
    {
        try {
    
            // Step 1: Find store
            
            $product_details = product::with(['category','subcategory','store','brand','delivery_time','product_specifications','product_variants.color','product_variants.size','review','review.user_details'])
            ->where('id', $request->product_id)->first();

           
    
            // If store not found
            if (!$product_details) {
                return [
                    'status' => 'success',
                    'message' => 'No Product Found',
                    'data'   => []
                ];
            }

            $wishlistIds = wishlist::where('user_id', $request->user_id)
            ->pluck('product_id')
            ->toArray();


            if($product_details){
                $product_details->wishlist = in_array($product_details->id, $wishlistIds) ? 1 : 0;

            }

            // add to cart check 

             $addtocart = Addtocart::where('user_id', $request->user_id)
             ->where('product_id',$product_details->id)
             ->first();

              if($addtocart){
                $product_details->addtocart = $addtocart;
            }else{
                $product_details->addtocart = (object)[];
                
            }

            // add to cart total count
              $addtocartcount = Addtocart::where('user_id', $request->user_id)
             ->count();

            if($addtocartcount){
                $product_details->addtocartTotalProduct = $addtocartcount;
            }else{
                $product_details->addtocartTotalProduct = 0;
                
            }

            $reviews = $product_details->review ?? [];

            if (count($reviews) > 0) {

                $totalRating = 0;
                $count = 0;

                foreach ($reviews as $review) {
                    if (!empty($review->product_rating)) {
                        $totalRating += (float) $review->product_rating;
                        $count++;
                    }
                }

                $average = $count > 0 ? round($totalRating / $count, 1) : 0;

            } else {
                $average = 0;
            }

            $product_details->average_rating = $average;

            $similar_products=product::with(['category','subcategory','brand','product_specifications','product_variants.color'])
            ->withAvg('review as product_avg_rating', 'product_rating')
            ->withCount('review') 
            ->limit(12)
            ->inRandomOrder()
            ->where('category_id',$product_details->category_id)
        ->where('subcategory_id',$product_details->subcategory_id)
            ->get();

            $product_details->similar_products = $similar_products;


           
            return [
                'status'  => 'success',
                'message' => "Product Information fetch Successfully",
                'data'    => $product_details
            ];
    
        } catch (\Exception $e) {
    
            return [
                'status'  => 'error',
                'message' => 'Failed: ' . $e->getMessage(),
                'data'    => (object)[]
            ];
        }
    }
    


    


    public function get_store_filter()
    {
        try {
    
            // Step 1: Find store
            $store_information = sortFilter::where('status','1')->get();
    
            // If store not found
            if (!$store_information) {
                return [
                    'status' => 'success',
                    'message' => 'No Store Found',
                    'data'   => []
                ];
            }
    
            return [
                'status'  => 'success',
                'message' => "Store filter Information fetch Successfully",
                'data'    => $store_information
            ];
    
        } catch (\Exception $e) {
    
            return [
                'status'  => 'error',
                'message' => 'Failed: ' . $e->getMessage(),
                'data'    => (object)[]
            ];
        }
    }

    

    


    public function product_add_to_wishlist($request)
    {
        try {

            // dd($request);
            $data=[
                'user_id'=>$request->user_id,
                'product_id'=>$request->product_id
               ];


            $wishlist = wishlist::where($data)->first();

            if($wishlist){
                $wishlist->delete();
                // $msg="Product remove from Wishlist";
                $msg = __('user_messages.product_remove_from_wishlist');
                $update_status=0;
            }else{
               $wishlist= wishlist::create($data);
                // $msg="Product Add to Wishlist";
                $msg = __('user_messages.product_add_to_wishlist');
                $update_status=1;
            }

            
            $count = wishlist::where('user_id',$request->user_id)->count();

          
            return [
                'status'  => 'success',
                'message' => $msg,
                'data'    => $update_status,
                'count' => $count
            ];
    
        } catch (\Exception $e) {
    
            return [
                'status'  => 'error',
                'message' => 'Failed: ' . $e->getMessage(),
                'data'    => (object)[]
            ];
        }
    }


// public function product_add_to_cart($request)
//     {
//         try {


//             $match=[
//                 'user_id'=>$request->user_id,
//                 'product_id'=>$request->product_id,
//                 'variants_id'=>$request->variants_id,
//                 'order_type'=>'1',
//                ];

//             $data=[
//                 'user_id'=>$request->user_id,
//                 'product_id'=>$request->product_id,
//                 'quantity'=>$request->quantity,
//                 'variants_id'=>$request->variants_id,
//                ];

//             $variation_stock_check= ProductVariant::where('id',$request->variants_id)->first();

//             if(intVal($variation_stock_check->total_stock) < $request->quantity){
//                 return [
//                     'status'  => 'error',
//                     'message' => 'product Stock limit Is Low',
//                     'data'    => (object)[]
//                 ];
//             }

//             $product_amount=$variation_stock_check->final_price;


//             $add_to_cart = Addtocart::where($match)->first();

//             if($add_to_cart){

//                 $update_quantity=$add_to_cart->quantity + $request->quantity;

//                 $update_amount=$product_amount*$update_quantity;

//                 // check quantity Again on Update product Time

//                 if(intVal($variation_stock_check->total_stock) < $update_quantity){
//                     return [
//                         'status'  => 'error',
//                         'message' => 'product Stock limit Is Low',
//                         'data'    => (object)[]
//                     ];
//                 }
                
//                 $add_to_cart->update(['quantity'=>$update_quantity,'amount'=>$update_amount]);

//                 $msg="Product Add to Cart Update Successfully";
            
//             }else{

//               $data['amount']=$product_amount*$request->quantity;


//               $add_to_cart= Addtocart::create($data);
//                 $msg="Product Add in Cart Successfully";
//             }

          
//             return [
//                 'status'  => 'success',
//                 'message' => $msg,
//                 'data'    => $add_to_cart
//             ];
    
//         } catch (\Exception $e) {
    
//             return [
//                 'status'  => 'error',
//                 'message' => 'Failed: ' . $e->getMessage(),
//                 'data'    => (object)[]
//             ];
//         }
//     }

public function product_add_to_cart($request)
{
    try {

        $affiliate_id = null;
        $reference_link = null;
        $admin_commission_percent = null;
        $affiliate_commission_percent = null;

        if(!empty($request->reference_link)){

            $reference_link = $request->reference_link;

            $query = parse_url($reference_link, PHP_URL_QUERY);
            parse_str($query, $params);

            if(isset($params['ref'])){
                $affiliate_id = $params['ref'];
            }
        }

        $match = [
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'variants_id' => $request->variants_id,
            'order_type' => '1',
        ];

        $data = [
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'variants_id' => $request->variants_id,
        ];

        if($reference_link){
            $data['reference_link'] = $reference_link;
        }

        if($affiliate_id){
            $data['affiliate_id'] = $affiliate_id;
        }

        $variation_stock_check = ProductVariant::where('id', $request->variants_id)->first();

        if(!$variation_stock_check){
            return [
                'status' => 'error',
                'message' => __('Service_messages.variant_not_found'),
                'data' => (object)[]
            ];
        }

        if(intval($variation_stock_check->total_stock) < $request->quantity){
            return [
                'status' => 'error',
                'message' => __('Service_messages.product_stock_limit_low'),
                'data' => (object)[]
            ];
        }

        $product_amount = $variation_stock_check->final_price;
        $total_amount = $product_amount * $request->quantity;

        $product = Product::select('affiliated_commission')
                    ->where('id', $request->product_id)
                    ->first();

        if($product){
            $affiliate_commission_percent = $product->affiliated_commission;
        }

        if($affiliate_id){

            if(!is_null($affiliate_commission_percent)){
                $data['affiliate_commission'] = number_format(($affiliate_commission_percent / 100) * $total_amount, 2, '.', '');
            } else {
                $data['affiliate_commission'] = null;
            }

            $affiliate_address = AffilatedUserAddress::where('affiliate_id', $affiliate_id)->first();

            if($affiliate_address){

                $affiliate_country_id = $affiliate_address->country;

                $admin_commission = AffiliateCommission::where('country_id', $affiliate_country_id)
                                    ->orderBy('id', 'asc')
                                    ->first();

                if($admin_commission){

                    $admin_commission_percent = $admin_commission->commission ?? null;

                    if($admin_commission_percent){
                        $data['admin_commission'] = number_format(($admin_commission_percent / 100) * $total_amount, 2, '.', '');
                    } else {
                        $data['admin_commission'] = null;
                    }
                }
            }
        }

        $add_to_cart = Addtocart::where($match)->first();

        if($add_to_cart){

            $update_quantity = $add_to_cart->quantity + $request->quantity;

            if(intval($variation_stock_check->total_stock) < $update_quantity){
                return [
                    'status' => 'error',
                    'message' => __('Service_messages.product_stock_limit_low'),
                    'data' => (object)[]
                ];
            }

            $update_amount = $product_amount * $update_quantity;

            $updateData = [
                'quantity' => $update_quantity,
                'amount' => $update_amount
            ];

            if($reference_link){
                // $updateData['reference_link'] = $reference_link;
            }

            if($affiliate_id){

                $updateData['affiliate_id'] = $affiliate_id;

                // if(!is_null($affiliate_commission_percent)){
                //     $updateData['affiliate_commission'] = number_format(($affiliate_commission_percent / 100) * $update_amount, 2, '.', '');
                // } else {
                //     $updateData['affiliate_commission'] = null;
                // }

                // if($admin_commission_percent){
                //     $updateData['admin_commission'] = number_format(($admin_commission_percent / 100) * $update_amount, 2, '.', '');
                // } else {
                //     $updateData['admin_commission'] = null;
                // }
            }

            $add_to_cart->update($updateData);

            $msg = __('Service_messages.product_cart_updated_successfully');

        } else {

            $data['amount'] = $total_amount;

            $add_to_cart = Addtocart::create($data);

            $msg = __('Service_messages.product_added_to_cart_successfully');
        }

        if($reference_link){

            Session::put('affiliate_product', [
                'product_id' => $add_to_cart->product_id,
                'variant_id' => $add_to_cart->variants_id,
                'reference_number' => $add_to_cart->reference_link,
                'affiliate_id' => $add_to_cart->affiliate_id ?? null,
                'admin_commission' => $add_to_cart->admin_commission ?? null,
                'affiliate_commission' => $add_to_cart->affiliate_commission ?? null
            ]);
            //dd(Session::get('affiliate_product'));
        }

        return [
            'status' => 'success',
            'message' => $msg,
            'data' => $add_to_cart
        ];

    } catch (\Exception $e){

        return [
            'status' => 'error',
            'message' => 'Failed: ' . $e->getMessage(),
            'data' => (object)[]
        ];
    }
}

    



public function product_view_cart_details($request)
{
    try {

       $user_address= userAddress::where('user_id',$request->user_id)->where('set_as_default','1')->first();

       if($user_address){

        $country_dataId= country::where('dial_code',$user_address->country_code)->first();

        if($country_dataId){
            $userCountry_id= $country_dataId->id;
        }else{
            $userCountry_id=0;
        }

       }


    //    country,Tax,ShippingCharge}
  

        $total_mrp=0;
        $discount_on_mrp=0;
        $discount_coupon=0;
        $shipping_fees=0;
        $tax=0;
        $total_amount=0;
        $defaultFee=config('services.defaultShippingFees');

        $defaultTaxFee=config('services.defaultTaxFees');


        $add_to_cart= Addtocart::with('chatroom_data','product.seller_details','product.store','product_variants.color','product_variants.size','product.delivery_time')->where('user_id',$request->user_id)->get();

        if($add_to_cart->isEmpty()){
            return [
                'status'  => 'success',
                'message' => 'Add To Cart Is Empty',
                'data'    => (object)[]
            ];
        }


        foreach($add_to_cart as $key=>$val){

            // check Every product Stock
            if($val->product_variants->total_stock < $val->quantity ){
                $val->check_stock='No_Stock';
            }else{
                $val->check_stock='Stock_Availble';
            }


            // if($val->order_type=='2'){ // when Cutom Order Show in card
                
            // $ItemAmounttotal=$val->amount * $val->quantity ;
            
            // $total_amount+=$ItemAmounttotal;
            // $discount_on_mrp+=($val->product_variants->final_price-$val->amount)* $val->quantity;            
            // $total_mrp=$total_amount+$discount_on_mrp;

            // }
            // else{

            // $ItemAmounttotal=$val->product_variants->final_price * $val->quantity ;
            // $total_amount+=$ItemAmounttotal;
            // $discount_on_mrp+=($val->product_variants->actual_price - $val->product_variants->final_price)* $val->quantity;
            // $total_mrp=$total_amount+$discount_on_mrp;
            // }
            if($val->order_type=='1'){ 
                

            $ItemAmounttotal=$val->product_variants->final_price * $val->quantity ;
            $total_amount+=$ItemAmounttotal;
            $discount_on_mrp+=($val->product_variants->actual_price - $val->product_variants->final_price)* $val->quantity;
            $total_mrp=$total_amount+$discount_on_mrp;
            }else{
                $ItemAmounttotal=$val->product_variants->final_price * $val->quantity ;
            }


         // discount Amount Code Apply 
        if($val->product->store){
          
            
        if($user_address && $userCountry_id!==0){
            $user_let=$user_address->latitude;
            $user_long=$user_address->longitude;

            $store_let=$val->product->store->let;
            $store_long=$val->product->store->long;

            // Calculate the distance
            $distance = calculateDistance($user_let, $user_long, $store_let, $store_long);
            //dd($distance);
           
            // $distance = 10;

            $shipping_charges= ShippingCharge::where('country_id',$userCountry_id)
            ->where('range_from','<=',$distance)
            ->where('range_to','>=',$distance)
            ->where('status','1')->first();

            $defaultShipping = DefaultShippingFee::where('country_id',$userCountry_id)->first();
            $defaultFee = $defaultShipping->shipping_fee ?? 0;
            //dd($defaultFee);

            if($shipping_charges){
                $get_shipping_charge=$shipping_charges->shipping_fee *$val->quantity ;

                $shipping_fees+=$get_shipping_charge;

            }else{
                $get_shipping_charge=$defaultFee*$val->quantity;
                $shipping_fees+=$get_shipping_charge;
            }

            }else{

                $get_shipping_charge=$defaultFee*$val->quantity;
                $shipping_fees+=$get_shipping_charge;
           
            }

            // Tax calculate Code 

        if(isset($userCountry_id)){

        $Tax_calculate= Tax::where('country_id',$userCountry_id)->where('status','1')->first();

        if($Tax_calculate){
            $taxAmount= $ItemAmounttotal*$Tax_calculate->tax/100; 
             $tax+=$taxAmount;
            // $total_amount=$total_amount+$tax;
           
        }else{
            $taxAmount= $defaultTaxFee; 
             $tax+=$taxAmount;

        }
          }else{

            $taxAmount= $defaultTaxFee; 
            $tax+=$taxAmount;
            
         }

            Addtocart::where('id',$val->id)->update(['shipping_fees'=>$get_shipping_charge,'tax'=>$taxAmount]); // Update Shiping Charge
            }   
        }

        // Tax calucltor Code  start

        $response['total_mrp']=$total_mrp;

        $response['discount_on_mrp']=$discount_on_mrp;
        $response['discount_coupon']=$discount_coupon;
        $response['shipping_fees']=$shipping_fees;
        $response['tax']=round($tax);
        $response['total_amount']=$total_amount+$shipping_fees+$tax;

        $response['user_address']=$user_address;
        
        $response['cart_data']=$add_to_cart;
        
        return [
            'status'  => 'success',
            'message' => 'All Cart Data fetch Successfully',
            'data'    => $response
        ];


        $product_amount=$variation_stock_check->final_price;


        $add_to_cart = Addtocart::where($match)->first();

        if($add_to_cart){

            $update_quantity=$add_to_cart->quantity + $request->quantity;

            $update_amount=$product_amount*$update_quantity;

            // check quantity Again on Update product Time

            if(intVal($variation_stock_check->total_stock) < $update_quantity){
                return [
                    'status'  => 'error',
                    'message' => __('Service_messages.product_stock_limit_low'),
                    'data'    => (object)[]
                ];
            }
            
            $add_to_cart->update(['quantity'=>$update_quantity,'amount'=>$update_amount]);

            $msg = __('Service_messages.product_cart_updated_successfully');
        
        }else{

          $data['amount']=$product_amount*$request->quantity;


          $add_to_cart= Addtocart::create($data);
            $msg = __('Service_messages.product_added_to_cart_successfully');
        }

      
        return [
            'status'  => 'success',
            'message' => $msg,
            'data'    => $add_to_cart
        ];

    } catch (\Exception $e) {


        return [
            'status'  => 'error',
            'message' => 'Failed: ' . $e->getMessage(),
            'data'    => (object)[]
        ];
    }
}






public function addtoCart_Increment_decrement($request)
    {
        try {

            $match=[
                'user_id'=>$request->user_id,
                'cart_id'=>$request->cart_id,
               ];

               $cart_details=Addtocart::with('product_variants')->where('id',$request->cart_id)->first();

               if($cart_details){

                if($cart_details->order_type=='2'){
                     return [
                        'status'  => 'error',
                        'message' => __('Service_messages.custom_order_quantity_change_not_allowed'),
                        'data'    => (object)[]
                    ];
                }

                $current_quntity=$cart_details->quantity;
                if($request->type=='increment'){

                $update_quantity=$current_quntity+1;

                if(intVal($cart_details->product_variants->total_stock) < $update_quantity){
                    return [
                        'status'  => 'error',
                        'message' => __('Service_messages.product_stock_limit_low'),
                        'data'    => (object)[]
                    ];
                }

                $cart_details->update(['quantity'=>$update_quantity]);
                $msg = __('Service_messages.product_incremented_successfully');

                }else{
                // decrement Code
                $update_quantity=$current_quntity-1;
                
                if($update_quantity<=0){
                  $cart_details->delete();
                  $msg = __('Service_messages.product_removed_from_cart_successfully');
                }else{
      
                $cart_details->update(['quantity'=>$update_quantity]);
                $msg = __('Service_messages.product_decremented_successfully');
                
                   }
                }

                return [
                    'status'  => 'success',
                    'message' => $msg,
                    'data'    => $cart_details
                ];


               }else{

                return [
                    'status'  => 'error',
                    'message' => 'Add To Cart Id wrong',
                    'data'    => (object)[]
                ];
               }










            $variation_stock_check= ProductVariant::where('id',$request->variants_id)->first();

            if(intVal($variation_stock_check->total_stock) < $request->quantity){
                return [
                    'status'  => 'error',
                    'message' => __('Service_messages.product_stock_limit_low'),
                    'data'    => (object)[]
                ];
            }

            $product_amount=$variation_stock_check->final_price;


            $add_to_cart = Addtocart::where($match)->first();

            if($add_to_cart){

                $update_quantity=$add_to_cart->quantity + $request->quantity;

                $update_amount=$product_amount*$update_quantity;

                // check quantity Again on Update product Time

                if(intVal($variation_stock_check->total_stock) < $update_quantity){
                    return [
                        'status'  => 'error',
                        'message' => __('Service_messages.product_stock_limit_low'),
                        'data'    => (object)[]
                    ];
                }
                
                $add_to_cart->update(['quantity'=>$update_quantity,'amount'=>$update_amount]);

               $msg = __('Service_messages.product_cart_updated_successfully');
            
            }else{

              $data['amount']=$product_amount*$request->quantity;


              $add_to_cart= Addtocart::create($data);
                 $msg = __('Service_messages.product_added_to_cart_successfully');
            }

          
            return [
                'status'  => 'success',
                'message' => $msg,
                'data'    => $add_to_cart
            ];
    
        } catch (\Exception $e) {
    
            return [
                'status'  => 'error',
                'message' => 'Failed: ' . $e->getMessage(),
                'data'    => (object)[]
            ];
        }
    }

    public function getWishlist($userId)
    {
        try {

            $user = User::find($userId);

            if (!$user) {
                return [
                    'status' => 'error',
                    'message' => 'User not found',
                    'data' => []
                ];
            }

            $productIds = wishlist::where('user_id', $userId)->pluck('product_id');

            $wishListProduct = product::with(['category','subcategory','brand','product_specifications','product_variants.color','product_variants.size','review','review.user_details'])
            ->whereIn('id', $productIds)
                ->get();

            $wishListProduct->map(function ($item) use ($user) {
                $item->user_name = $user->full_name; 
                $reviews = $item->review ?? [];
                if (count($reviews) > 0) {

                    $totalRating = 0;
                    $count = 0;

                    foreach ($reviews as $review) {
                        if (!empty($review->product_rating)) {
                            $totalRating += (float) $review->product_rating;
                            $count++;
                        }
                    }

                    $item->average_rating = $count > 0 ? round($totalRating / $count, 1) : 0;

                } else {
                    $item->average_rating = 0;
                }
                return $item;
            });

            return [
                'status' => 'success',
                'message' => 'Wishlist fetched successfully',
                'data' => $wishListProduct
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Failed to fetch wishlist: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }


    // public function product_add_to_cart_without_quantity_increment($request)
    // {
    //     try {
    //         // Match existing cart item for the user, product, and variant
    //         $match = [
    //             'user_id'     => $request->user_id,
    //             'product_id'  => $request->product_id,
    //             'variants_id' => $request->variants_id,
    //         ];

    //         // Prepare data to insert if not exists
    //         $data = [
    //             'user_id'     => $request->user_id,
    //             'product_id'  => $request->product_id,
    //             'quantity'    => $request->quantity,
    //             'variants_id' => $request->variants_id,
    //         ];

    //         // Get variant stock and price
    //         $variant = ProductVariant::find($request->variants_id);
    //         if (!$variant) {
    //             return [
    //                 'status'  => 'error',
    //                 'message' => 'Product variant not found.',
    //                 'data'    => (object)[]
    //             ];
    //         }

    //         // Check stock only if quantity is greater than 0
    //         if ($request->quantity > 0) {
    //             if (intval($variant->total_stock) < $request->quantity) {
    //                 return [
    //                     'status'  => 'error',
    //                     'message' => 'Product stock is too low.',
    //                     'data'    => (object)[]
    //                 ];
    //             }
    //         }

    //         $product_amount = $variant->final_price;

    //         // Find existing cart entry
    //         $cartItem = Addtocart::where($match)->first();

    //         if ($request->quantity == 0) {
    //             // If quantity is 0, remove the item from the cart
    //             if ($cartItem) {
    //                 $cartItem->delete();
    //                 return [
    //                     'status'  => 'error',
    //                     'message' => 'Item removed from cart successfully.',
    //                     'data'    => (object)[]
    //                 ];
    //             } else {
    //                 return [
    //                     'status'  => 'error',
    //                     'message' => 'Item not found in cart.',
    //                     'data'    => (object)[]
    //                 ];
    //             }
    //         }

    //         if ($cartItem) {
    //             // Update the existing cart item if the quantity is non-zero
    //             $cartItem->quantity = $request->quantity;
    //             $cartItem->amount = $product_amount * $request->quantity;
    //             $cartItem->save();

    //             $msg = "Cart updated successfully";
    //         } else {
    //             // Create new cart entry if it doesn't exist
    //             $data['amount'] = $product_amount * $request->quantity;
    //             $cartItem = Addtocart::create($data);
    //             $msg = "Added to cart successfully";
    //         }

    //         return [
    //             'status'  => 'success',
    //             'message' => $msg,
    //             'data'    => $cartItem
    //         ];

    //     } catch (\Exception $e) {
    //         return [
    //             'status'  => 'error',
    //             'message' => 'Failed: ' . $e->getMessage(),
    //             'data'    => (object)[]
    //         ];
    //     }
        
    // }

    public function product_add_to_cart_without_quantity_increment($request)
{
    try {

        $affiliate_id = null;
        $reference_link = null;
        $admin_commission_percent = null;
        $affiliate_commission_percent = null;

        // Check reference link
        if(!empty($request->reference_link)){
            //dd(123);

            $reference_link = $request->reference_link;

            $query = parse_url($reference_link, PHP_URL_QUERY);
            parse_str($query, $params);

            if(isset($params['ref'])){
                $affiliate_id = $params['ref'];
            }
        }

        $match = [
            'user_id'     => $request->user_id,
            'product_id'  => $request->product_id,
            'variants_id' => $request->variants_id,
        ];

        $data = [
            'user_id'     => $request->user_id,
            'product_id'  => $request->product_id,
            'quantity'    => $request->quantity,
            'variants_id' => $request->variants_id,
        ];

        if($reference_link){
            $data['reference_link'] = $reference_link;
        }

        if($affiliate_id){
            $data['affiliate_id'] = $affiliate_id;
        }

        $variant = ProductVariant::find($request->variants_id);

        if (!$variant) {
            return [
                'status'  => 'error',
                'message' => __('user_messages.product_variant_not_found'),
                'data'    => (object)[]
            ];
        }

        if ($request->quantity > 0) {
            if (intval($variant->total_stock) < $request->quantity) {
                return [
                    'status'  => 'error',
                    'message' => __('user_messages.product_stock_is_too_low'),
                    'data'    => (object)[]
                ];
            }
        }

        

        $product_amount = $variant->final_price;
        $total_amount = $product_amount * $request->quantity;

        // Get affiliate commission percent
        $product = Product::select('affiliated_commission')
                    ->where('id', $request->product_id)
                    ->first();

        if($product){
            $affiliate_commission_percent = $product->affiliated_commission;
        }

        if($affiliate_id){

            if(!is_null($affiliate_commission_percent)){
                $data['affiliate_commission'] = number_format(($affiliate_commission_percent / 100) * $total_amount, 2, '.', '');
            }

            $affiliate_address = AffilatedUserAddress::where('affiliate_id', $affiliate_id)->first();

            if($affiliate_address){

                $affiliate_country_id = $affiliate_address->country;

                $admin_commission = AffiliateCommission::where('country_id', $affiliate_country_id)
                                    ->orderBy('id','asc')
                                    ->first();

                if($admin_commission){

                    $admin_commission_percent = $admin_commission->commission ?? null;

                    if($admin_commission_percent){
                        $data['admin_commission'] = number_format(($admin_commission_percent / 100) * $total_amount, 2, '.', '');
                    }
                }
            }
        }

        $cartItem = Addtocart::where($match)->first();

        if ($request->quantity == 0) {

            if ($cartItem) {
                $cartItem->delete();

                return [
                    'status'  => 'error',
                    'message' => __('user_messages.item_removed_from_cart_successfully'),
                    'data'    => (object)[]
                ];
            }

            return [
                'status'  => 'error',
                'message' => __('user_messages.item_not_found_in_cart'),
                'data'    => (object)[]
            ];
        }

        if ($cartItem) {

            $updateData = [
                'quantity' => $request->quantity,
                'amount' => $product_amount * $request->quantity
            ];

            if($reference_link){
                $updateData['reference_link'] = $reference_link;
            }

            if($affiliate_id){

                $updateData['affiliate_id'] = $affiliate_id;

                if(!is_null($affiliate_commission_percent)){
                    $updateData['affiliate_commission'] = number_format(($affiliate_commission_percent / 100) * $updateData['amount'], 2, '.', '');
                }

                if($admin_commission_percent){
                    $updateData['admin_commission'] = number_format(($admin_commission_percent / 100) * $updateData['amount'], 2, '.', '');
                }
            }

            $cartItem->update($updateData);

            $msg = __('user_messages.cart_updated_successfully');

        } else {

            $data['amount'] = $total_amount;

            $cartItem = Addtocart::create($data);

            $msg = __('user_messages.added_to_cart_successfully');
        }

        // Save affiliate session
        if($reference_link){

            Session::put('affiliate_product', [
                'product_id' => $cartItem->product_id,
                'variant_id' => $cartItem->variants_id,
                'reference_number' => $cartItem->reference_link,
                'affiliate_id' => $cartItem->affiliate_id ?? null,
                'admin_commission' => $cartItem->admin_commission ?? null,
                'affiliate_commission' => $cartItem->affiliate_commission ?? null
            ]);
        }

        return [
            'status'  => 'success',
            'message' => $msg,
            'data'    => $cartItem
        ];

    } catch (\Exception $e) {

        return [
            'status'  => 'error',
            'message' => 'Failed: ' . $e->getMessage(),
            'data'    => (object)[]
        ];
    }
}



    

      public function CustomorderAddToCard($request)
    {
        try {
         
        $chat_order=allproductchats::where('unique_id',$request->unique_id)->first();

         if($chat_order->type!=='2'){

         return [
                'status'  => 'error',
                'message' => __('user_messages.not_a_custom_order'),
                'data'    => (object)[]
            ];
        }

        if($chat_order->action!=="5"){

         return [
                'status'  => 'error',
                'message' => __('user_messages.order_not_accepted_by_user_or_seller'),
                'data'    => (object)[]
            ];
        }


      $checkOrderAlreadyPaid=orderdetail::with('order_details')->where('unique_id',$request->unique_id)->first();

      if($checkOrderAlreadyPaid){

        if(in_array($checkOrderAlreadyPaid->payment_status,['0','1'])){


            if($checkOrderAlreadyPaid->order_details->payment_method=='3' && in_array($checkOrderAlreadyPaid->payment_status,['0','1'])){

              return [
                'status'  => 'error',
                'message' => __('user_messages.chat_order_already_proceeded_0'),
                'data'    => (object)[]
            ];
            }

            if($checkOrderAlreadyPaid->order_details->payment_method!=='3' && $checkOrderAlreadyPaid->payment_status !== '1' ){
                
              return [
                'status'  => 'error',
                'message' => __('user_messages.chat_order_already_proceeded_1'),
                'data'    => (object)[]
            ];
            }
        }



      }



         $match=[
            "user_id"=>$chat_order->user_id,
            "order_type"=>"2",
            "product_id"=>$chat_order->product_id,
            "quantity" =>$chat_order->quantity,
            "unique_id"=>$chat_order->unique_id
        ];
        

        
        $cardData=[
            "user_id"=>$chat_order->user_id,
            "order_type"=>"2",
            "product_id"=>$chat_order->product_id,
            "variants_id"=>$chat_order->variation_id,
            "quantity" =>$chat_order->quantity,
            "amount" =>$chat_order->price,
            "tax" =>$chat_order->tax,
            "shipping_fees"=>$chat_order->shipping ,
             "unique_id"=>$chat_order->unique_id
        ];
        
      $checkAddToCard=Addtocart::Updateorcreate($match,$cardData);
      
      $chat_order->update(['addtocardStatus'=>'1']); // Update code in card product

        if ($checkAddToCard->wasRecentlyCreated) {
            // New record inserted
            return [
                'status' => "success",
                'message' => __('user_messages.custom_product_added_to_cart_successfully'),
                'data'    => $chat_order
            ];
        } else {
            // Existing record updated
            return [
                'status' => "error",
                'message' => __('user_messages.product_already_exists_in_cart'),
                'data'    => $chat_order
            ];
        }
            


        return [
            'status'  => 'success',
            'message' => $msg,
            'data'    => $cartItem
        ];

        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => 'Failed: ' . $e->getMessage(),
                'data'    => (object)[]
            ];
        }
        
    }



    

      public function RemoveCustomProductAddToCard($request)
    {
        try {
         
        $AddToCardCheck=Addtocart::where('id',$request->id)->first();

         if($AddToCardCheck){
            allproductchats::where('unique_id',$AddToCardCheck->unique_id)->update(['addtocardStatus'=>'0']);
            $AddToCardCheck->delete();

            return [
                'status' => "success",
                'message' => __('Service_messages.custom_product_removed_from_cart_successfully'),
                'data'    => $AddToCardCheck
            ];
        } 

        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => 'Failed: ' . $e->getMessage(),
                'data'    => (object)[]
            ];
        }
        
    }

    public function recordAffiliateClick($request_data1)
{
    try {
        $affiliateProduct = AffiliateProduct::where('affiliate_id', $request_data1->affiliate_id)
            ->where('product_id', $request_data1->product_id)
            ->first();

        $affiliate_product_id = $affiliateProduct ? $affiliateProduct->id : null;

        $clickRecord = AffiliateProductClickRecord::create([
            'product_id' => $request_data1->product_id,
            'affiliate_id' => $request_data1->affiliate_id,
            'affiliate_product_id' => $affiliate_product_id,
            'user_id' => $request_data1->user_id,
            'reference_link' => $request_data1->reference_link,
        ]);

        return [
            'status' => 'success',
            'message' => __('Service_messages.affiliate_click_recorded_successfully'),
            'data' => $clickRecord
        ];

    } catch (\Exception $e) {
        //\Log::error('Affiliate click record failed: ' . $e->getMessage());

        return [
            'status' => 'error',
            'message' => 'Failed to record affiliate click: ' . $e->getMessage(),
            'data' => (object)[]
        ];
    }
}





    
}
    