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

    public function bannerRequestManagement(Request $request)
    {
        $type = $request->get('type'); 
        $country = $request->get('country_name');

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
        //dd($approvedRequest);
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

    public function updateBannerReqStatus($id)
    {
        $data = $this->BannerService->blockUnblockBannerReq($id);
        //dd($result);

        if ($data['status'] == 'success') {
           // $statusText = $data['data']->status == 1 ? 'Activated' : 'Deactivated';
  
            return response()->json([
                'success' => true,
                'status' => $data['data']->status,
                'message' => $data['message']
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => $data['message']
            ], 400); 
        }
    }



    



}