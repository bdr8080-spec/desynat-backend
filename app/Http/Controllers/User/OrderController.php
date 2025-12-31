<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\UserOrderService;
use App\Helpers\ApiResponse;
use App\Http\Controllers\CommonController;

use Validator;

class OrderController extends Controller
{
 
    public function __construct(UserOrderService $UserOrderService)
    {
        $this->UserOrderService = $UserOrderService;
    }

    public function myOrders(Request $request){ 

         $user=  $request->user();

        $data = (object)[
            'user_id' => $user->id,
            'search' => $request->search ?? null,
            'filter' => $request->filter ?? null
        ];

        $orderData = $this->UserOrderService->AllOrderDetailsNew($data)['data'];
        // dump($orderData);

        return view('user.orders.my-order',compact('orderData'));

    }

    public function order_details(Request $request, $id){ 


        $data = (object)[
            'order_id' => $id,
             'orderdetails_id' => $request->orderdetails_id
        ];

      $orderData = $this->UserOrderService->singleOrderDetailsNew($data)['data'];
      
        // dump($orderData);
      
       $data1 = (object)[
            'type' => '3',
        ];
       $cancelReasons = $this->UserOrderService->getRejectReasonDetails($data1)['data'];
       //dd($cancelReason);

        $data2 = (object)[
            'type' => '1',
        ];
       $exchangeReasons = $this->UserOrderService->getRejectReasonDetails($data2)['data'];

       $data2 = (object)[
            'type' => '2',
        ];
       $returnReasons = $this->UserOrderService->getRejectReasonDetails($data2)['data'];

        return view('user.orders.order-details',compact('orderData','cancelReasons','exchangeReasons','returnReasons'));

    }



    public function cancel_order(Request $request)
    {
        //dd($request->all());

        try {
              $request_data = (object)[
                'order_id' => $request->order_id,
                'orderdetails_id' => $request->orderdetails_id,
                'cancel_reason' => $request->cancel_reason,
              ];

            $data = $this->UserOrderService->cancelledSingleProduct($request_data);
            //dd($data);
            
            if ($data['status'] === 'success') {
                return response()->json([
                    'status' => 'success',
                    'message' => $data['message'],
                    'data' => $data
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => $data['message'],
                    'data' => (object)[]
                ], 422); 
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed cancel order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function exchange_order(Request $request)
    {
        //dd($request->all());

        try {
              $request_data = (object)[
                'order_id' => $request->order_id,
                'orderdetails_id' => $request->orderdetails_id,
                'exchange_reason' => $request->exchange_reason,
                'new_size' => $request->new_size,
              ];

            $data = $this->UserOrderService->exchnageProductAfterdelivery($request_data);
            //dd($data);
            
            if ($data['status'] === 'success') {
                return response()->json([
                    'status' => 'success',
                    'message' => $data['message'],
                    'data' => $data
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => $data['message'],
                    'data' => (object)[]
                ], 422); 
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed exchange order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAvailableSize(Request $request)
    {
        //dd($request->all());

        try {
              $request_data = (object)[
                'product_id' => $request->product_id,
                'size_id' => $request->size_id,
                'color_id' => $request->color_id,
              ];

            $data = $this->UserOrderService->getSizesExceptProvided($request_data);
            //dd($data);
            
            if ($data['status'] === 'success') {
                return response()->json([
                    'status' => 'success',
                    'message' => $data['message'],
                    'data' => $data
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => $data['message'],
                    'data' => (object)[]
                ], 422); 
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed cancel order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function return_order(Request $request)
    {
        try {
            $imageUrls = [];

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageUrls[] = doc_upload($image, 'images');
                }
            }

            $request_data = (object)[
                'order_id'        => $request->order_id,
                'orderdetails_id' => $request->orderdetails_id,
                'return_reason'   => $request->return_reason,
                'return_image'    => $imageUrls, 
            ];

           // dd($request_data);

            $data = $this->UserOrderService->returnProductAfterdelivery($request_data);

            if ($data['status'] === 'success') {
                return response()->json([
                    'status' => 'success',
                    'message' => $data['message'],
                    'data' => $data
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => $data['message'],
                'data' => (object)[]
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to return order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function submitRating(Request $request)
    {
        try {
             $user=  $request->user();
            $productImages = [];
            $storeImages = [];
            $dir = "product_reviews";

            // Handle product images
            if ($request->hasFile('product_image')) {
                foreach ($request->file('product_image') as $image) {
                    $productImages[] = doc_upload($image, $dir);
                }
            }
            //dd($productImages);

            // Handle store images
            if ($request->hasFile('store_image')) {
                foreach ($request->file('store_image') as $image) {
                    $storeImages[] = doc_upload($image, $dir);
                }
            }

            $request_data = (object)[
                'user_id'        => $user->id,
                'order_id'        => $request->order_id,
                'orderdetails_id' => $request->orderdetails_id,
                'product_id'      => $request->product_id,
                'store_id'        => $request->store_id,
                'product_rating'  => $request->product_rating,
                'store_rating'    => $request->store_rating,
                'product_review'  => $request->product_review ?? null,
                'store_review'    => $request->store_review ?? null,
                'product_image'   => $productImages,
                'store_image'     => $storeImages,
            ];

           //dd($request_data);

            // Call your service for handling review logic
            $data = $this->UserOrderService->ProductReviewAndRating($request_data);

            if ($data['status'] === 'success') {
                return response()->json([
                    'status' => 'success',
                    'message' => $data['message'],
                    'data' => $data
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => $data['message'],
                'data' => (object)[]
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to submit review',
                'error' => $e->getMessage()
            ], 500);
        }
    }









}