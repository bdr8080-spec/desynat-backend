<?php
namespace App\Services;

use App\Models\User;
use App\Models\UserWallet;
use App\Models\all_countrie;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;

use App\Models\{ product,ProductSpecification,ProductVariant,sortFilter};

use App\Models\{ seller,sellerStoreInformation,sellerDocument,Bankdetails,Plan };




class UserManagementService
{
   
    public function getUsers($request)
    {
        try {
            $limit = (int) $request->input('limit');

            $query = User::with(['country_info', 'wallet_info']);

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
                $query->where('full_name', 'like', "%{$search}%");
            }

            $user_details = $query->orderBy('id', 'desc')->paginate($limit);

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

            $message = $user->status == 1
                ? 'User unblocked Successfully'
                : 'User blocked Successfully';

            return [
                'status' => 'success',
                'message' => $message,
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
        try {
            $wallet = UserWallet::where('user_id', $userId)->first();

            if ($wallet) {
                $wallet->amount += $amount;
                $wallet->save();

                $message = 'Amount added in wallet successfully';
            } else {
                $wallet = UserWallet::create([
                    'user_id' => $userId,
                    'amount' => $amount,
                ]);

                $message = 'Amount added in wallet successfully';
            }

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

            $productQuery = Product::with(['category','subcategory','brand','product_specifications','product_variants'])
            ->where('category_id', $request->category_id)->pluck('store_id');

            if($productQuery->isEmpty()){
                return [
                    'status' => 'success',
                    'message' => 'No Store Found',
                    'data' => []
                ];
            }


         $all_store_information=sellerStoreInformation::with('seller_information')->whereIn('id',$productQuery)->
        //  where('Store_Availability','1')->
         get();

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
            $store_information = sellerStoreInformation::find($data->store_id);
    
            // If store not found
            if (!$store_information) {
                return [
                    'status' => 'success',
                    'message' => 'No Store Found',
                    'data'   => []
                ];
            }
    
            // Step 2: Product query
            $products = $store_information->All_product()
                ->with([
                    'brand',
                    'category',
                    'subcategory',
                    'product_specifications',
                    'product_variants'
                ]);
    
            // Step 3: Search
            if (!empty($data->search)) {
                $products->where('product_name_en', 'LIKE', '%' . $data->search . '%');
            }

            // Apply Filter

            switch ($data->sort_filter) {

                case 1: // Recommended
                    // $products = $products->orderBy('recommended_score', 'desc');
                    break;
            
                case 2: // Price: Low to High
                    $products = $products->whereHas('product_variants',function($query){
                        $query->orderBy('actual_price', 'asc');
                        
                    });
                    break;
            
                case 3: // Price: High to Low
                    $products = $products->whereHas('product_variants',function($query){
                        $query->orderBy('actual_price', 'desc');
                        
                    });
                    break;
            
                case 4: // Newest First
                    $products = $products->orderBy('created_at', 'desc');
                    break;
            
                case 5: // Customer Rating
                    // $products = $products->orderBy('rating', 'desc');
                    break;
            
                case 6: // Best selling
                    // $products = $products->orderBy('total_sales', 'desc');
                    break;
            
                case 7: // Fastest delivery
                    // $products = $products->orderBy('delivery_time', 'asc');
                    break;
            
                default:
                    // No filter
                    break;
            }
            
            // Step 4: Pagination (convert stdClass to array)
            $products = $products->paginate()->appends((array) $data);

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

    
}
    