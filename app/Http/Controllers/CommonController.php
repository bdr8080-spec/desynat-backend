<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

use validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CommonController extends Controller
{
    

    public function upload(Request $request)
    {
        // Validate the request
        $request->validate([
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
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


}
