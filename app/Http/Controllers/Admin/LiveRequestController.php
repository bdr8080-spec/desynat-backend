<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Services\BannerService;

 
class LiveRequestController extends Controller
{

    public function __construct(BannerService $BannerService)
    {
        $this->BannerService = $BannerService;
    }

    public function liveRequestManagement(Request $request){
        return view('admin.live-request-management.index');
    }




    



}