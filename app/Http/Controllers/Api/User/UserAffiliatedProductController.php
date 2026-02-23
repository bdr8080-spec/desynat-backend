<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;
use Validator;

use Illuminate\Validation\Rule;
use App\Services\UserAffiliatedProductService;




class UserAffiliatedProductController extends Controller
{

    public function __construct(UserAffiliatedProductService $UserAffiliatedProductService){

        $this->UserAffiliatedProductService=$UserAffiliatedProductService;

    }

    public function get_all_products(Request $request)
    {
        $validate = Validator::make($request->all(), [
        'category_id'         => 'required|exists:categories,id',
        'subcategory_id' => 'required',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse(
                'error',
                $validate->errors()->first(),
                (object) $validate->errors(),
                422
            );
        }

        try {
            $data = $this->UserAffiliatedProductService->getAllProducts($request);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function get_product_detail(Request $request)
    { 
        $validate = Validator::make($request->all(), [
            'id' => 'required|exists:products,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->UserAffiliatedProductService->getProductDetail($request);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function get_my_product_detail(Request $request)
    { 
        $validate = Validator::make($request->all(), [
            'id' => 'required|exists:products,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {

            $user_id = $request->user()->id;
            $request_data = (object) [
                'user_id' => $user_id,
                'id' => $request->id,
            ];
            $data = $this->UserAffiliatedProductService->getMyProductDetail($request_data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function get_my_products(Request $request)
    {
        $affilated_user = $request->user()->id;

        $request_data = (object) [
            'user_id' => $affilated_user,
            'from' => $request->from ?? null,
            'to' => $request->to ?? null,
            'limit' => $request->limit ?? null,
            'search' => $request->search ?? null,
        ];

        try {
            $data = $this->UserAffiliatedProductService->getMyProducts($request_data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function add_to_my_products(Request $request)
    {
       $validate = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        $affilated_user = $request->user()->id;

        $request_data = (object) [
            'user_id' => $affilated_user,
            'product_id' => $request->product_id,
        ];

        try {
            $data = $this->UserAffiliatedProductService->addToMyProducts($request_data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function generate_product_link(Request $request)
    {
       $validate = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        $affilated_user = $request->user()->id;

        $request_data = (object) [
            'user_id' => $affilated_user,
            'product_id' => $request->product_id,
        ];

        try {
            $data = $this->UserAffiliatedProductService->generateProductLink($request_data);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], $data['data'], 400);
            }
            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function product_search(Request $request){


    $user_id=$request->user()->id;

     $request_data=(object)[
        'user_id'=>$user_id,
        'search' =>$request->search,
        'sort_filter'=> $request->sort_filter,
        'brand_id'     => is_array($request->brand_id) ? $request->brand_id : [],     
        'category_id'  => is_array($request->category_id) ? $request->category_id : [],   
        'size_id'      => is_array($request->size_id) ? $request->size_id : [],       
        'color_id'     => is_array($request->color_id) ? $request->color_id : [],      
        'price_min'    => $request->price_min ?? null,
        'price_max'    => $request->price_max ?? null,
        'attributes'    => $request->attributes_data ?? null,
       ];

     $data=$this->UserAffiliatedProductService->ProductSearch($request_data);
    
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }

    public function getRecentSearchData(Request $request){

    $user_id=$request->user()->id;

     $request_data=(object)[
        'user_id'=>$user_id,
        ];

     $data=$this->UserAffiliatedProductService->HomeRecentSearchList($request_data);
    
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }



public function getRecommendedSearchData(Request $request){

    $user_id=$request->user()->id;

     $request_data=(object)[
        'user_id'=>$user_id,
        ];

     $data=$this->UserAffiliatedProductService->Recommanded_HomeRecentSearchList($request_data);
    
    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],$data['data'],422);
    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }

    public function product_filter_keys(Request $request){

     $data=$this->UserAffiliatedProductService->get_store_filter();


    if(isset($data['status']) && $data['status']=='error' ){
        return ApiResponse::generateResponse('error', $data['message'],(object)[],422);

    }

    return ApiResponse::generateResponse('success', $data['message'],$data['data'], 200);

    }
    
    









    

    


      






}
