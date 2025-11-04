<?php
namespace App\Services;

use App\Models\country;
use App\Models\City;
use App\Models\ServiceCity;
use Illuminate\Http\Request;


class CountryService
{
   public function getCountries()
    {
        try {
            $countries = country::orderBy('name', 'asc')->get();

            if ($countries->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No countries found',
                    'data' => (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Countries fetched successfully',
                'data' => $countries
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch countries: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function getCities($countryId)
    {
        try {

            $query = City::where('country_id', $countryId)->orderBy('name', 'asc')->get();

            if ($query->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No cities found for this country',
                    'data' => (object) []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Cities fetched successfully',
                'data' => $query
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch cities: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function getServiceCities($countryId, $limit = null, $search = null)
    {
        try {
            $limit = !empty($limit) ? (int)$limit : 10;

            $query = ServiceCity::where('country_id', $countryId);

            if (!empty($search)) {
                $query->where('name', 'like', '%' . $search . '%');
            }

            $cities = $query->paginate($limit);

            if ($cities->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No City found for this Country',
                    'data' => (object) []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Service Cities fetched successfully',
                'data' => $cities
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch cities: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function addServiceCity(Request $request)
    {
        try {
            $city = City::find($request->city_id);

            if (!$city) {
                return [
                    'status' => 'error',
                    'message' => 'City not found',
                    'data' => (object)[]
                ];
            }

            $serviceCity = ServiceCity::create([
                'country_id' => $city->country_id, 
                'name' => $city->name,             
            ]);

            return [
                'status' => 'success',
                'message' => 'City added successfully',
                'data' => $serviceCity
            ];

        } catch (\Exception $e) {
            Log::error('Failed to create ServiceCity: ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Failed to create ServiceCity',
                'data' => (object)[]
            ];
        }
    }

    public function changeServiceCityStatus($cityId)
    {
        try {
            $city = ServiceCity::find($cityId);

            if (!$city) {
                return [
                    'status' => 'error',
                    'message' => 'City not found',
                    'data' => (object)[]
                ];
            }

            $city->status = $city->status == 1 ? 0 : 1;
            $city->save();

            return [
                'status' => 'success',
                'message' => 'City status updated successfully',
                'data' => $city
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch city: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function deleteServiceCity($cityId)
    {
        try {
            $city = ServiceCity::find($cityId);

            if (!$city) {
                return [
                    'status' => 'error',
                    'message' => 'City not found',
                    'data' => (object)[]
                ];
            }
            $city->delete();

            return [
                'status' => 'success',
                'message' => 'City deleted successfully',
                'data' => []
            ];

        } catch (\Exception $e) {
            Log::error('Failed to delete city: ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Failed to delete city',
                'data' => (object)[]
            ];
        }
    }






    

            
        


}
    