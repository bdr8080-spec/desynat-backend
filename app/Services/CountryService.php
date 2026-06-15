<?php
namespace App\Services;

use App\Models\country;
use App\Models\City;
use App\Models\ServiceCity;
use App\Models\Zone;
use App\Models\all_countrie;
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
                    $message = __('Service_messages.no_data_found'),
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

    // public function getCities($countryId)
    // {
    //     try {
    //         $cities = City::where('country_id', $countryId)
    //                     ->orderBy('name', 'asc')
    //                     ->get();

    //         if ($cities->isEmpty()) {
    //             return [
    //                 'status' => 'success',
    //                 'message' => 'No cities found for this country',
    //                 'data' =>  []
    //             ];
    //         }

    //         $excludedCities = $cities->filter(function ($city) use ($countryId) {
    //             return !ServiceCity::where('country_id', $countryId)
    //                             ->where('city_id', $city->id)
    //                             ->exists(); 
    //         });

    //         if ($excludedCities->isEmpty()) {
    //             return [
    //                 'status' => 'success',
    //                 'message' => 'All cities are already added',
    //                 'data' =>  []
    //             ];
    //         }

    //         $excludedCities = $excludedCities->values();

    //         return [
    //             'status' => 'success',
    //             'message' => 'Cities fetched successfully',
    //             'data' => $excludedCities
    //         ];

    //     } catch (\Exception $e) {
    //         return [
    //             'status' => 'error',
    //             'message' => 'Failed to fetch cities: ' . $e->getMessage(),
    //             'data' => []
    //         ];
    //     }
    // }

    public function getCities($countryId)
    {
        try {
            $cities = City::where('country_id', $countryId)
                ->orderBy('name', 'asc')
                ->get();

            if ($cities->isEmpty()) {
                return [
                    'status' => 'success',
                    $message = __('Service_messages.no_data_found'),
                    'all_added' => false,
                    'data' => []
                ];
            }

            $excludedCities = $cities->filter(function ($city) use ($countryId) {
                return !ServiceCity::where('country_id', $countryId)
                    ->where('city_id', $city->id)
                    ->exists();
            })->values();

            // ✅ When all cities are already added
            if ($excludedCities->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => __('Service_messages.all_cities_already_added'),
                    'all_added' => true,
                    'data' => []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Cities fetched successfully',
                'all_added' => false,
                'data' => $excludedCities
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch cities',
                'all_added' => false,
                'data' => []
            ];
        }
    }




    public function getServiceCities($countryId, $limit = null, $search = null)
    {
        try {
            $limit = !empty($limit) ? (int)$limit : null;

            $query = ServiceCity::with(['city_info', 'country'])->where('country_id', $countryId);

            if (!empty($search)) {
                $query->where('name', 'like', '%' . $search . '%');
            }
            $query->orderBy('id', 'desc');
            $cities = $query->paginate($limit);

            if ($cities->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => __('Service_messages.no_data_found'),
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
                'name_ar' => $city->name_ar,          
            ]);

            return [
                'status' => 'success',
                // 'message' => 'City added successfully',
                'message' => __('admin_messages.city_added_successfully'),
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
           $message = $city->status == 1
                ? __('admin_messages.city_has_been_activated_successfully')
                : __('admin_messages.city_has_been_deactivated_successfully');

            return [
                'status' => 'success',
                'message' => $message,
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
                // 'message' => 'City deleted successfully',
                'message' => __('admin_messages.city_deleted_successfully'),
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
                // 'message' => 'Zone added successfully',
                'message' => __('admin_messages.zone_added_successfully'),
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
                $query->where('name_english', 'like', '%' . $search . '%');
            }
            $query->orderBy('id', 'desc');
            $zones = $query->paginate($limit);

            if ($zones->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => __('Service_messages.no_data_found'),
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
                // 'message' => 'Zone updated successfully',
                'message' => __('admin_messages.zone_updated_successfully'),
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
            $message = $zone->status == 1
                ? __('admin_messages.zone_has_been_activated_successfully')
                : __('admin_messages.zone_has_been_deactivated_successfully');

            return [
                'status' => 'success',
                'message' => $message,
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
                // 'message' => 'Zone deleted successfully',
                'message' => __('admin_messages.zone_deleted_successfully'),
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

    public function getUserAllCountries()
    {
        try {
            $countries = all_countrie::where('status',1)->orderBy('name', 'asc')->get();

            if ($countries->isEmpty()) {
                return [
                    'status' => 'success',
                    $message = __('Service_messages.no_data_found'),
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







    

            
        


}
    