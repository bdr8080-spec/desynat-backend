<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

use Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use App\Models\country;
use App\Models\all_countrie;
use App\Models\Category;
use App\Models\SubCategory;

use App\Models\Brand;
use App\Models\color;
use App\Models\size;





class CommonController extends Controller
{
    

    public function upload(Request $request)
    {
        // Validate the request
        $request->validate([
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:5120',
        ]);

        // Check if the request has a valid file
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');
            // Generate a unique filename
            $filename = Str::random(10) . '.' . $image->getClientOriginalExtension();
            

            try {
                // Print the S3 configuration for debugging
                Log::info('S3 Configuration:', config('filesystems.disks.s3'));

                // Attempt to store the file in S3
                $path = $image->storeAs('images', $filename, 's3');

                if (!$path) {
                    // Log an error if storeAs fails
                    Log::error('File upload failed: storeAs returned false');
                    return ApiResponse::generateResponse('error', 'Failed to upload file.', null, 500);
                }

                // Generate the URL for the uploaded file
                $url = Storage::disk('s3')->url($path);

                // Return the URL in the response
                return ApiResponse::generateResponse('success', 'File uploaded successfully.', ['url' => $url], 200);
            } catch (\Exception $e) {
                // Log any exceptions thrown during the file upload
                Log::error('File upload failed: ' . $e->getMessage());
                Log::error('Exception Trace: ' . $e->getTraceAsString());
                return ApiResponse::generateResponse('error', 'Failed to upload file.', null, 500);
            }
        }

        // Return an error response if the file upload is invalid
        return ApiResponse::generateResponse('error', 'Invalid file upload.', null, 400);
    }



    public function country(Request $request){

     $all_country=country::get();

    return ApiResponse::generateResponse('success', 'All Seller Country Details fetch Successfully',$all_country, 200);
       
    }


    public function all_country(Request $request){
        
        $all_country=all_countrie::get();
   
       return ApiResponse::generateResponse('success', 'All Country Details fetch Successfully',$all_country, 200);
       
       }



    // fetch category
    public function getCategories(Request $request)
    {

        $category = Category::orderBy('id', 'asc')->where('status','1')->get();


        if ($category->isEmpty()) {
            return ApiResponse::generateResponse('success',"No categories found",[],200);

        }

        return ApiResponse::generateResponse('success',"Category list fetched successfully",$category,200);
          
    }

    // fetch sub category
    public function getSubCategories(Request $request)
    {
        $rules = [
            'category_id' => 'required|integer|exists:categories,id'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
               return ApiResponse::generateResponse('error', $validator->errors()->first(), $validator->errors(), 422);
        }

        $subCategory = SubCategory::where('category_id', $request->category_id)->where('status','1')->get();

        if ($subCategory->isEmpty()) {
            return ApiResponse::generateResponse('success', 'No sub categories found', [], 200);
        }

        return ApiResponse::generateResponse('success', 'Sub category list fetched successfully', $subCategory, 200);
     
    }


     // fetch get_brand
     public function get_brand(Request $request)
     {

         $sub_brand = Brand::all();
 
         if ($sub_brand->isEmpty()) {
             return ApiResponse::generateResponse('success', 'No Brand found', [], 200);
         }
         
        return ApiResponse::generateResponse('success', 'Brand list fetched successfully', $sub_brand, 200);
     }

     
     // fetch get_color
     public function get_color(Request $request)
     {

         $data = color::all();
 
         if ($data->isEmpty()) {
             return ApiResponse::generateResponse('success', 'No Color found', [], 200);
         }
         
        return ApiResponse::generateResponse('success', 'color list fetched successfully', $data, 200);
      
     }


     // fetch get_size
     public function get_size(Request $request)
     {
        $data = size::all();
        if ($data->isEmpty()) {
            return ApiResponse::generateResponse('success', 'No size found', [], 200);
        }
        return ApiResponse::generateResponse('success', 'Size list fetched successfully', $data, 200);
     }

     public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpeg,png,jpg,gif,svg,mp4,mov,avi,mkv|max:5120', // 5MB max
        ]);

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');

            $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();

            try {
                $path = $file->storeAs('uploads', $filename, 's3');

                if (!$path) {
                    Log::error('File upload failed: storeAs returned false');
                    return ApiResponse::generateResponse('error', 'Failed to upload file.', null, 500);
                }

                $url = Storage::disk('s3')->url($path);

                return ApiResponse::generateResponse('success', 'File uploaded successfully.', ['url' => $url], 200);

            } catch (\Exception $e) {
                Log::error('File upload failed: ' . $e->getMessage());
                Log::error('Trace: ' . $e->getTraceAsString());
                return ApiResponse::generateResponse('error', 'Failed to upload file.', null, 500);
            }
        }

        return ApiResponse::generateResponse('error', 'Invalid file upload.', null, 400);
    }

 

     
}