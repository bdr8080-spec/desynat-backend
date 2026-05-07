<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\country;
use App\Models\ServiceCity;
use Validator;
use App\Services\CountryService;
 
class CountryController extends Controller
{

    public function __construct(CountryService $CountryService)
    {
        $this->CountryService = $CountryService;
    }

    public function countryManagement(Request $request){
        $countries = $this->CountryService->getCountries()['data'];
        return view('admin.country-management.index',compact('countries'));
    }

    public function manageCities($id, Request $request){
        $country = country::find($id);
        // $cities = $this->CountryService->getCities($id)['data'];
        $response = $this->CountryService->getCities($id);
        $cities = $response['data'];
        $allAdded = $response['all_added'];
        $serviceCities = $this->CountryService->getServiceCities($id)['data'];
        return view('admin.country-management.manage-cities',compact('country','cities','serviceCities','allAdded'));
    }

    public function manageZones($id, Request $request){
        $city = ServiceCity::find($id);
        $country = country::find($city->country_id);
        $zones = $this->CountryService->getZones($city->country_id,$id)['data'];
        //dd($zones);
        return view('admin.country-management.manage-zones',compact('zones','city','country'));
    }

    public function addServiceCity(Request $request)
    {
        try {
            $request->validate([
                'city_id' => 'required|exists:cities,id',
            ]);

            $response = $this->CountryService->addServiceCity($request);

            return response()->json($response);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function change_service_city_status($id)
    {
        $data = $this->CountryService->changeServiceCityStatus($id);

        if ($data['status'] == 'success') {
  
            return response()->json([
                'success' => true,
                'status' => $data['data']->status,
                'message' => $data['data']->status == 1
                    ? __('admin_messages.city_has_been_activated_successfully')
                    : __('admin_messages.city_has_been_deactivated_successfully')
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => $data['message']
            ], 400); 
        }
    }

    public function deleteServiceCity($id)
    {
        $result = $this->CountryService->deleteServiceCity($id);

        if ($result['status'] === 'error') {
            return response()->json([
                'status' => 'error',
                'message' => $result['message']
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => $result['message']
        ], 200);
    }

    public function add_zone(Request $request)
    {
        $request->validate([
            'country_id' => 'required|integer|exists:countries,id',
            'city_id' => 'required|integer|exists:service_cities,id',
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'coordinates' => 'required|array|min:3', 
            'coordinates.*.lat' => 'required|numeric',
            'coordinates.*.lng' => 'required|numeric',
        ]);

        $result = $this->CountryService->addZone($request);

        if ($result['status'] === 'success') {
            return response()->json([
                'status' => 'success',
                'message' => $result['message'],
                'data' => $result['data']
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => $result['message'],
                'data' => $result['data']
            ], 500);
        }
    }

    public function update_zone(Request $request)
    {
        $request->validate([
            'zone_id' => 'required|integer|exists:zones,id',
            'country_id' => 'required|integer|exists:countries,id',
            'city_id' => 'required|integer|exists:service_cities,id',
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'coordinates' => 'required|array|min:3',
            'coordinates.*.lat' => 'required|numeric',
            'coordinates.*.lng' => 'required|numeric',
        ]);

        $result = $this->CountryService->updateZone($request);

        if ($result['status'] === 'success') {
            return response()->json([
                'status' => 'success',
                'message' => $result['message'],
                'data' => $result['data']
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => $result['message'],
                'data' => $result['data']
            ], 500);
        }
    }

    public function deleteZone($id)
    {
        $result = $this->CountryService->deleteZone($id);

        if ($result['status'] === 'error') {
            return response()->json([
                'status' => 'error',
                'message' => $result['message']
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => $result['message']
        ], 200);
    }

    public function change_zone_status($id)
    {
        $data = $this->CountryService->changeZoneStatus($id);

        if ($data['status'] == 'success') {
            
            return response()->json([
                'success' => true,
                'status' => $data['data']->status,
                'message' => $data['data']->status == 1
                    ? __('admin_messages.zone_has_been_activated_successfully')
                    : __('admin_messages.zone_has_been_deactivated_successfully')
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => $data['message']
            ], 400); 
        }
    }




}