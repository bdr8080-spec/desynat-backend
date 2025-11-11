<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\CountryService;
use App\Models\country;
use App\Models\City;
use App\Models\ServiceCity;
use App\Models\Zone;


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

    public function get_cities(Request $request)
    {
       //print_r('123');
        $validate = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->CountryService->getCities($request->country_id);

            if (isset($data['status']) && $data['status'] == 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function get_service_cities(Request $request)
    {
       //print_r('123');
        $validate = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->CountryService->getServiceCities($request->country_id,$request->limit,$request->search);

            if (isset($data['status']) && $data['status'] == 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function add_service_city(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'city_id' => 'required|exists:cities,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->CountryService->addServiceCity($request);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function change_service_city_status(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'city_id' => 'required|exists:service_cities,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->CountryService->changeServiceCityStatus($request->city_id);

            if (isset($data['status']) && $data['status'] == 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function delete_service_city(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'city_id' => 'required|exists:service_cities,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->CountryService->deleteServiceCity($request->city_id);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'] ?? null, 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function get_zones(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:service_cities,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->CountryService->getZones($request->country_id,$request->city_id,$request->limit,$request->search);

            if (isset($data['status']) && $data['status'] == 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function get_zone_details(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'zone_id' => 'required|exists:zones,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->CountryService->getZoneDetailsById($request->zone_id);

            if (isset($data['status']) && $data['status'] === 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function add_zone(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:service_cities,id',
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'coordinates' => 'required|array|min:3',
            'coordinates.*.lat' => 'required|numeric',
            'coordinates.*.lng' => 'required|numeric',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->CountryService->addZone($request);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function update_zone(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'zone_id' => 'required|exists:zones,id',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:service_cities,id',
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'coordinates' => 'required|array|min:3',
            'coordinates.*.lat' => 'required|numeric',
            'coordinates.*.lng' => 'required|numeric',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->CountryService->updateZone($request);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function change_zone_status(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'zone_id' => 'required|exists:zones,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $data = $this->CountryService->changeZoneStatus($request->zone_id);

            if (isset($data['status']) && $data['status'] == 'error') {
                return ApiResponse::generateResponse('error', $data['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $data['message'], $data['data'], 200);

        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    public function delete_zone(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'zone_id' => 'required|exists:zones,id',
        ]);

        if ($validate->fails()) {
            return ApiResponse::generateResponse('error', 'Validation error', $validate->errors()->first(), 422);
        }

        try {
            $result = $this->CountryService->deleteZone($request->zone_id);

            if ($result['status'] === 'error') {
                return ApiResponse::generateResponse('error', $result['message'], [], 400);
            }

            return ApiResponse::generateResponse('success', $result['message'], $result['data'], 200);
            
        } catch (\Exception $e) {
            return ApiResponse::generateResponse('error', 'Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }







    

    


      






}
