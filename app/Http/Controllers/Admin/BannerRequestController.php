<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Services\BannerService;
use App\Services\CountryService;

 
class BannerRequestController extends Controller
{

    public function __construct(BannerService $BannerService, CountryService $CountryService)
    {
        $this->BannerService = $BannerService;
        $this->CountryService = $CountryService;
    }

    // public function bannerRequestManagement(Request $request){
    //     $request->merge(['type' => '0']);
    //     $newRequest = $this->BannerService->getBannersReq($request)['data'];
    //     //dd($newRequest);

    //     $request->merge(['type' => '1']);
    //     $approvedRequest = $this->BannerService->getBannersReq($request)['data'];

    //     $request->merge(['type' => '2']);
    //     $rejectedRequest = $this->BannerService->getBannersReq($request)['data'];

    //     $countries = $this->CountryService->getCountries()['data'];
    //     return view('admin.banner-request.index',compact('newRequest','approvedRequest','rejectedRequest','countries'));
    // }

    // public function bannerRequestManagement(Request $request)
    // {
    //     // Get country_name from request if any
    //     $countryName = $request->input('country_name', null);

    //     // Default: New Requests
    //     $request->merge(['type' => '0']);
    //     if ($request->input('type') === 'new' && $countryName) {
    //         $request->merge(['country_name' => $countryName]);
    //     }
    //     $newRequest = $this->BannerService->getBannersReq($request)['data'];

    //     // Approved Requests
    //     $request->merge(['type' => '1']);
    //     if ($request->input('type') === 'approved' && $countryName) {
    //         $request->merge(['country_name' => $countryName]);
    //     }
    //     $approvedRequest = $this->BannerService->getBannersReq($request)['data'];

    //     // Rejected Requests
    //     $request->merge(['type' => '2']);
    //     if ($request->input('type') === 'rejected' && $countryName) {
    //         $request->merge(['country_name' => $countryName]);
    //     }
    //     $rejectedRequest = $this->BannerService->getBannersReq($request)['data'];

    //     $countries = $this->CountryService->getCountries()['data'];

    //     return view('admin.banner-request.index', compact(
    //         'newRequest',
    //         'approvedRequest',
    //         'rejectedRequest',
    //         'countries'
    //     ));
    // }

public function bannerRequestManagement(Request $request)
{
    $type = $request->get('type'); // may be null
    $country = $request->get('country_name'); // may be null

    // New Requests
    $newRequestParams = ['type' => '0'];
    if ($type === 'new' && $country) {
        $newRequestParams['country_name'] = $country;
    }
    $newRequest = $this->BannerService->getBannersReq(new Request($newRequestParams))['data'];

    // Approved Requests
    $approvedRequestParams = ['type' => '1'];
    if ($type === 'approved' && $country) {
        $approvedRequestParams['country_name'] = $country;
    }
    $approvedRequest = $this->BannerService->getBannersReq(new Request($approvedRequestParams))['data'];

    // Rejected Requests
    $rejectedRequestParams = ['type' => '2'];
    if ($type === 'rejected' && $country) {
        $rejectedRequestParams['country_name'] = $country;
    }
    $rejectedRequest = $this->BannerService->getBannersReq(new Request($rejectedRequestParams))['data'];

    $countries = $this->CountryService->getCountries()['data'];

    return view('admin.banner-request.index', compact('newRequest', 'approvedRequest', 'rejectedRequest', 'countries', 'type'));
}





    public function approveBannerRequest(Request $req)
    {
        $data = $this->BannerService->approveBannerReq($req);

        if ($data['status'] === 'error') {
            return response()->json([
                'status' => 'error',
                'message' => $data['message']
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => $data['message']
        ], 200);

    }

    public function rejectBannerRequest(Request $req)
    {
        $data = $this->BannerService->rejectBannerReq($req);

        if ($data['status'] === 'error') {
            return response()->json([
                'status' => 'error',
                'message' => $data['message']
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => $data['message']
        ], 200);

    }



    



}