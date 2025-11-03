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

            $query = City::where('country_id', $countryId)->get();

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
                'message' => 'Failed to fetch subcategories: ' . $e->getMessage(),
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
                    'message' => 'No subcategories found for this category',
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





    

            
        


}
    