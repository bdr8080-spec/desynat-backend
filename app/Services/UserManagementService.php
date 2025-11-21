<?php
namespace App\Services;

use App\Models\User;
use App\Models\UserWallet;
use App\Models\all_countrie;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;

use App\Models\{ product,ProductSpecification,ProductVariant,sortFilter,wishlist,Addtocart};

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
                $query->where(function($query) use ($search) {
                    $query->where('full_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('mobile', 'like', "%{$search}%");
                });
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


         $all_store_information=sellerStoreInformation::with('seller_information')->whereIn('id',$productQuery);
        //  where('Store_Availability','1')->

        if(isset($request->search)){
            $all_store_information->where('store_name', 'Like', '%'.$request->search.'%');
        }

        if(isset($request->rating)){
            // $all_store_information->where('store_name', 'Like', '%'.$request->search.'%');
        }
        if(isset($request->availbility)){
            $all_store_information->where('Store_Availability',$request->availbility);
        }

        $all_store_information=$all_store_information->get();

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
            $products = $products->paginate()
            ->through(function ($product) use ($wishlistIds) {
                $product->wishlist = in_array($product->id, $wishlistIds) ? 1 : 0;
                return $product;
            })
            ->appends((array) $data);

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
            
            $product_details = Product::with(['category','subcategory','brand','product_specifications','product_variants'])
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
                $msg="Product remove from Wishlist";
                $update_status=0;
            }else{
               $wishlist= wishlist::create($data);
                $msg="Product Add From Wishlist";
                $update_status=1;
            }
          
            return [
                'status'  => 'success',
                'message' => $msg,
                'data'    => $update_status
            ];
    
        } catch (\Exception $e) {
    
            return [
                'status'  => 'error',
                'message' => 'Failed: ' . $e->getMessage(),
                'data'    => (object)[]
            ];
        }
    }


public function product_add_to_cart($request)
    {
        try {


            $match=[
                'user_id'=>$request->user_id,
                'product_id'=>$request->product_id,
                'variants_id'=>$request->variants_id,
               ];

            $data=[
                'user_id'=>$request->user_id,
                'product_id'=>$request->product_id,
                'quantity'=>$request->quantity,
                'variants_id'=>$request->variants_id,
               ];

            $variation_stock_check= ProductVariant::where('id',$request->variants_id)->first();

            if(intVal($variation_stock_check->total_stock) < $request->quantity){
                return [
                    'status'  => 'error',
                    'message' => 'product Stock limit Is Low',
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
                        'message' => 'product Stock limit Is Low',
                        'data'    => (object)[]
                    ];
                }
                
                $add_to_cart->update(['quantity'=>$update_quantity,'amount'=>$update_amount]);

                $msg="Product Add to Cart Update Successfully";
            
            }else{

              $data['amount']=$product_amount*$request->quantity;


              $add_to_cart= Addtocart::create($data);
                $msg="Product Add in Cart Successfully";
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

    



public function product_view_cart_details($request)
{
    try {


        $total_mrp=0;
        $discount_on_mrp=0;
        $discount_coupon=0;
        $shipping_fees=0;
        $tax=0;
        $total_amount=0;

        $add_to_cart= Addtocart::with('product.seller_details','product_variants.color','product_variants.size')->where('user_id',$request->user_id)->get();


        if($add_to_cart->isEmpty()){
            return [
                'status'  => 'success',
                'message' => 'Add To Cart Is Empty',
                'data'    => []
            ];
        }

        foreach($add_to_cart as $key=>$val){

            // check Every product Stock
            if($val->product_variants->total_stock < $val->quantity ){
                $val->check_stock='No_Stock';
            }else{
                $val->check_stock='Stock_Availble';
            }

            $total_amount+=$val->product_variants->final_price * $val->quantity ;
            $discount_on_mrp+=$val->product_variants->discount_value * $val->quantity;
            $total_mrp=$total_amount+$discount_on_mrp;
        }


        $response['total_mrp']=$total_mrp;
        $response['discount_on_mrp']=$discount_on_mrp;
        $response['discount_coupon']=$discount_coupon;
        $response['shipping_fees']=$shipping_fees;
        $response['tax']=$tax;
        $response['total_amount']=$total_amount;
        
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
                    'message' => 'product Stock limit Is Low',
                    'data'    => (object)[]
                ];
            }
            
            $add_to_cart->update(['quantity'=>$update_quantity,'amount'=>$update_amount]);

            $msg="Product Add to Cart Update Successfully";
        
        }else{

          $data['amount']=$product_amount*$request->quantity;


          $add_to_cart= Addtocart::create($data);
            $msg="Product Add in Cart Successfully";
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

                $current_quntity=$cart_details->quantity;
                if($request->type=='increment'){

                $update_quantity=$current_quntity+1;

                if(intVal($cart_details->product_variants->total_stock) < $update_quantity){
                    return [
                        'status'  => 'error',
                        'message' => "product Stock limit Is Low You Can't Increment quantity ",
                        'data'    => (object)[]
                    ];
                }

                $cart_details->update(['quantity'=>$update_quantity]);
                $msg="Product Increment successfully";

                }else{
                // decrement Code
                $update_quantity=$current_quntity-1;
                
                if($update_quantity<=0){
                  $cart_details->delete();
                  $msg="Product Remove from The cart successfully";
                }else{
      
                $cart_details->update(['quantity'=>$update_quantity]);
                $msg="Product decrement successfully";
                
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
                    'message' => 'product Stock limit Is Low',
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
                        'message' => 'product Stock limit Is Low',
                        'data'    => (object)[]
                    ];
                }
                
                $add_to_cart->update(['quantity'=>$update_quantity,'amount'=>$update_amount]);

                $msg="Product Add to Cart Update Successfully";
            
            }else{

              $data['amount']=$product_amount*$request->quantity;


              $add_to_cart= Addtocart::create($data);
                $msg="Product Add in Cart Successfully";
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

    


    
}
    