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
use App\Models\TicketType;
use App\Models\Content;
use App\Models\Faq;




class CommonController extends Controller
{
    

    public function upload(Request $request)
    {
        // Validate the request
        $request->validate([
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:512000',
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
                // $url = Storage::disk('s3')->url($path);
                $cloudfrontBase = env('CLOUDFRONT_URL', 'https://d79swovq1y56s.cloudfront.net');
                $url = $cloudfrontBase . '/' . $path; 

                // Return the URL in the response
                return ApiResponse::generateResponse('success', 'File uploaded successfully.', ['url' => $url], 200);
            } catch (\Exception $e) {
                // Log any exceptions thrown during the file upload
                Log::error('File upload failed: ' . $e->getMessage());
                Log::error('Exception Trace: ' . $e->getTraceAsString());
                return ApiResponse::generateResponse('error', 'Failed to upload file.', null, 500);
            }

//     try {
//     $file = $request->file('file');

//     if (!$file) {
//         return ApiResponse::generateResponse('error', 'No file provided.', null, 400);
//     }

//     // Get original extension & mime type
//     $extension = $file->getClientOriginalExtension();
//     $mimeType = $file->getMimeType();

//     // Generate unique filename
//     $filename = 'uploads/' . Str::random(20) . '.' . $extension;

//     // S3 client
//     $client = Storage::disk('s3')->getClient();

//     // Create command
//     $cmd = $client->getCommand('PutObject', [
//         'Bucket' => env('AWS_BUCKET'),
//         'Key' => $filename,
//         'ContentType' => $mimeType, // dynamic type
//     ]);

//     // Generate pre-signed URL (10 minutes)
//     $requestUrl = $client->createPresignedRequest($cmd, '+10 minutes');

//     $presignedUrl = (string) $requestUrl->getUri();

//     // CloudFront URL
//     $cloudfrontBase = env('CLOUDFRONT_URL', 'https://d79swovq1y56s.cloudfront.net');
//     $fileUrl = $cloudfrontBase . '/' . $filename;

//     return ApiResponse::generateResponse('success', 'Upload URL generated.', [
//         'upload_url' => $presignedUrl,
//         'file_url' => $fileUrl,
//         'type' => $mimeType
//     ], 200);

// } catch (\Exception $e) {
//     Log::error('Upload URL error: ' . $e->getMessage());
//     return ApiResponse::generateResponse('error', 'Failed to generate upload URL.', null, 500);
// }

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
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:jpeg,png,jpg,gif,svg,mp4,mov,avi,mkv|max:512000',
        ], [
            'file.max' => 'Please upload a file upto 500 MB.',
        ]);

        if ($validator->fails()) {
               return ApiResponse::generateResponse('error', $validator->errors()->first(), $validator->errors(), 400);
        }

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');

            $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();

            try {
                $path = $file->storeAs('uploads', $filename, 's3');

                if (!$path) {
                    Log::error('File upload failed: storeAs returned false');
                    return ApiResponse::generateResponse('error', 'Failed to upload file.', null, 500);
                }

                // $url = Storage::disk('s3')->url($path);
                $cloudfrontBase = env('CLOUDFRONT_URL', 'https://d79swovq1y56s.cloudfront.net');
                $url = $cloudfrontBase . '/' . $path; 

                return ApiResponse::generateResponse('success', 'File uploaded successfully.', ['url' => $url], 200);

            } catch (\Exception $e) {
                Log::error('File upload failed: ' . $e->getMessage());
                Log::error('Trace: ' . $e->getTraceAsString());
                return ApiResponse::generateResponse('error', 'Failed to upload file.', null, 500);
            }
        }

        return ApiResponse::generateResponse('error', 'Invalid file upload.', null, 400);
    }


    public function uploadWithResolution(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,avif',
            'type'  => 'required|in:1,2', // 1 = Mobile, 2 = Web
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $image = $request->file('image');

            //  Aspect ratio validation
            [$width, $height] = getimagesize($image);

            $imageRatio = $width / $height;
            $tolerance  = 0.01;

            // if ($request->type == 1) {
            //     // Mobile → 9:16 (portrait)
            //     $targetRatio = 9 / 16;
            //     $ratioLabel  = '9:16';
            // } else {
            //     // Web → 16:9 (landscape)
            //     $targetRatio = 16 / 9;
            //     $ratioLabel  = '16:9';
            // }
            // if ($imageRatio < ($targetRatio - $tolerance) || $imageRatio > ($targetRatio + $tolerance)) {
            //     return ApiResponse::generateResponse(
            //         'error',
            //         "Image upload failed. Please upload an image with a {$ratioLabel} aspect ratio",
            //         null,
            //         422
            //     );
            // }
            if ($request->type == 1) {
                // Mobile → 9:16 (portrait)
                $targetRatio = 9 / 16;
                $ratioLabel  = '9:16';

                if (
                    $imageRatio < ($targetRatio - $tolerance) ||
                    $imageRatio > ($targetRatio + $tolerance)
                ) {
                    return ApiResponse::generateResponse(
                        'error',
                        "Image upload failed. Please upload an image with a {$ratioLabel} aspect ratio",
                        null,
                        422
                    );
                }
            }

            $filename = Str::random(10) . '.' . $image->getClientOriginalExtension();

            try {
                Log::info('S3 Configuration:', config('filesystems.disks.s3'));

                $path = $image->storeAs('images', $filename, 's3');

                if (!$path) {
                    Log::error('File upload failed: storeAs returned false');
                    return ApiResponse::generateResponse(
                        'error',
                        'Failed to upload file.',
                        null,
                        500
                    );
                }

                // $url = Storage::disk('s3')->url($path);
                $cloudfrontBase = env('CLOUDFRONT_URL', 'https://d79swovq1y56s.cloudfront.net');
                $url = $cloudfrontBase . '/' . $path; 

                return ApiResponse::generateResponse(
                    'success',
                    'File uploaded successfully.',
                    ['url' => $url],
                    200
                );

            } catch (\Exception $e) {
                Log::error('File upload failed: ' . $e->getMessage());
                Log::error('Exception Trace: ' . $e->getTraceAsString());

                return ApiResponse::generateResponse(
                    'error',
                    'Failed to upload file.',
                    null,
                    500
                );
            }
        }

        return ApiResponse::generateResponse(
            'error',
            'Invalid file upload.',
            null,
            400
        );
    }

    public function ticket_types(Request $request)
     {

         $data = TicketType::all();
 
         if ($data->isEmpty()) {
             return ApiResponse::generateResponse('success', 'No ticket type found', [], 200);
         }
         
        return ApiResponse::generateResponse('success', 'ticket type list fetched successfully', $data, 200);
      
     }

     public function contact_us(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'type' => 'required|in:1,2,3'
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        $data = Content::where('slug', 'contact_us')
            ->where('type', $request->type)
            ->first();

        if (!$data) {
            return ApiResponse::generateResponse('success', 'No data found', [], 200);
        }

        $data->content_english = json_decode($data->content_english, true);

        return ApiResponse::generateResponse(
            'success',
            'contact us fetched successfully',
            $data,
            200
        );
    }

     public function terms_conditions(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'type' => 'required|in:1,2,3'
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        $data = Content::where('slug', 'terms_conditions')
            ->where('type', $request->type)
            ->first();

        if (!$data) {
            return ApiResponse::generateResponse('success', 'No data found', [], 200);
        }

        return ApiResponse::generateResponse(
            'success',
            'term & condition fetched successfully',
            $data,
            200
        );
    }

     public function return_policy(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'type' => 'required|in:1,2,3'
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        $data = Content::where('slug', 'return_policy')
            ->where('type', $request->type)
            ->first();

        if (!$data) {
            return ApiResponse::generateResponse('success', 'No data found', [], 200);
        }

        return ApiResponse::generateResponse(
            'success',
            'Return Policy fetched successfully',
            $data,
            200
        );
    }

     public function about_us(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'type' => 'required|in:1,2,3'
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        $data = Content::where('slug', 'about_us')
            ->where('type', $request->type)
            ->first();

        if (!$data) {
            return ApiResponse::generateResponse('success', 'No data found', [], 200);
        }

        return ApiResponse::generateResponse(
            'success',
            'About Us fetched successfully',
            $data,
            200
        );
    }

     public function cancellation_policy(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'type' => 'required|in:1,2,3'
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        $data = Content::where('slug', 'cancellation_policy')
            ->where('type', $request->type)
            ->first();

        if (!$data) {
            return ApiResponse::generateResponse('success', 'No data found', [], 200);
        }

        return ApiResponse::generateResponse(
            'success',
            'Cancellation Policy fetched successfully',
            $data,
            200
        );
    }

     public function exchange_policy(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'type' => 'required|in:1,2,3'
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        $data = Content::where('slug', 'exchange_policy')
            ->where('type', $request->type)
            ->first();

        if (!$data) {
            return ApiResponse::generateResponse('success', 'No data found', [], 200);
        }

        return ApiResponse::generateResponse(
            'success',
            'Exchange Policy fetched successfully',
            $data,
            200
        );
    }

    public function faqs(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'type' => 'required|in:1,2,3'
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        $data = Faq::where('status', '1')
            ->where('type', $request->type)
            ->get();

        if (!$data) {
            return ApiResponse::generateResponse('success', 'No data found', [], 200);
        }

        return ApiResponse::generateResponse(
            'success',
            'Faqs fetched successfully',
            $data,
            200
        );
    }



 

     
}