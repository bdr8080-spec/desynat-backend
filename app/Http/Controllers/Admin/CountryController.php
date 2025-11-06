<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\country;
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
        return view('admin.country-management.manage-cities');
    }

    public function manageZones(Request $request){
        return view('admin.country-management.manage-zones');
    }

    // public function change_country_status($id)
    // {
    //     $data = $this->CountryService->changeCountryStatus($id);

    //     if ($data['status'] == 'success') {
    //         $statusText = $data['data']->status == 1 ? 'Activated' : 'Deactivated';
  
    //         return response()->json([
    //             'success' => true,
    //             'status' => $data['data']->status,
    //             'message' => "Plan has been {$statusText} Successfully!"
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $data['message']
    //         ], 400); 
    //     }
    // }


}