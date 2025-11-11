<?php
namespace App\Services;

use App\Models\country;
use App\Models\City;
use App\Models\ServiceCity;
use App\Models\Zone;
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
            $limit = !empty($limit) ? (int)$limit : null;

            $query = ServiceCity::where('country_id', $countryId);

            if (!empty($search)) {
                $query->where('name', 'like', '%' . $search . '%');
            }
            $query->orderBy('id', 'desc');
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
                'city_id' => $city->id,  
                'name' => $city->name,             
            ]);

            return [
                'status' => 'success',
                'message' => 'City added successfully',
                'data' => $serviceCity
            ];

        } catch (\Exception $e) {
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
                'data' => null
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to delete city',
                'data' => (object)[]
            ];
        }
    }

    public function addZone(Request $request)
    {
        try {
            $zone = Zone::create([
                'country_id' => $request->country_id,
                'city_id' => $request->city_id,
                'name_english' => $request->name_english,
                'name_arabic' => $request->name_arabic,
                'coordinates' => $request->coordinates,
            ]);

            return [
                'status' => 'success',
                'message' => 'Zone added successfully',
                'data' => $zone,
            ];

        } catch (\Exception $e) {

            return [
                'status' => 'error',
                'message' => 'Failed to create zone',
                'data' => (object)[],
            ];
        }
    }

    public function getZones($countryId, $cityId, $limit = null, $search = null)
    {
        try {
            $limit = !empty($limit) ? (int)$limit : null;

            $query = Zone::where('country_id', $countryId)->where('city_id',$cityId);

            if (!empty($search)) {
                $query->where('name', 'like', '%' . $search . '%');
            }
            $query->orderBy('id', 'desc');
            $zones = $query->paginate($limit);

            if ($zones->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No zone found for this city',
                    'data' => (object) []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Zones fetched successfully',
                'data' => $zones
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch zones: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function getZoneDetailsById($zoneId)
    {
        try {
            $details = Zone::find($zoneId);

            if (!$details) {
                return [
                    'status' => 'error',
                    'message' => 'Zone not found',
                    'data' => (object) []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Zone details fetched successfully',
                'data' => $details
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch zone details: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function updateZone(Request $request)
    {
        try {
            $zone = Zone::find($request->zone_id);

            if (!$zone) {
                return [
                    'status' => 'error',
                    'message' => 'Zone not found',
                    'data' => (object)[]
                ];
            }

            $zone->update([
                'country_id'   => $request->country_id,
                'city_id'      => $request->city_id,
                'name_english' => $request->name_english,
                'name_arabic'  => $request->name_arabic,
                'coordinates'  => $request->coordinates, 
            ]);

            return [
                'status' => 'success',
                'message' => 'Zone updated successfully',
                'data' => $zone,
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update zone',
                'data' => (object)[],
            ];
        }
    }

    public function changeZoneStatus($zoneId)
    {
        try {
            $zone = Zone::find($zoneId);

            if (!$zone) {
                return [
                    'status' => 'error',
                    'message' => 'Zone not found',
                    'data' => (object)[]
                ];
            }

            $zone->status = $zone->status == 1 ? 0 : 1;
            $zone->save();

            return [
                'status' => 'success',
                'message' => 'Zone status updated successfully',
                'data' => $zone
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch zone: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function deleteZone($zoneId)
    {
        try {
            $zone = Zone::find($zoneId);

            if (!$zone) {
                return [
                    'status' => 'error',
                    'message' => 'Zone not found',
                    'data' => (object)[]
                ];
            }
            $zone->delete();

            return [
                'status' => 'success',
                'message' => 'Zone deleted successfully',
                'data' => []
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to delete zone',
                'data' => (object)[]
            ];
        }
    }







    

            
        


}
    