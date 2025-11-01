<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\CountryService;
use App\Models\country;


use Validator;

class CountryController extends Controller
{

    public function __construct(CountryService $CountryService){

        $this->CountryService=$CountryService;

    }

    public function get_countries(Request $request)
    {
        try {
            $data = $this->CountryService->getCountries();

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }






    

    


      






}
