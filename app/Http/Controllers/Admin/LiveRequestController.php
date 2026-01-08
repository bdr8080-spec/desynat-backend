<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Services\LiveRequestService;
use App\Services\CountryService;

 
class LiveRequestController extends Controller
{

    public function __construct(LiveRequestService $LiveRequestService, CountryService $CountryService)
    {
        $this->LiveRequestService = $LiveRequestService;
        $this->CountryService = $CountryService;
    }

    public function liveRequestManagement(Request $req){
        $countries = $this->CountryService->getCountries()['data'];
        $timeslots = $this->LiveRequestService->getTimeslots($req)['data'];
        return view('admin.live-request-management.index',compact('countries','timeslots'));
    }




    



}