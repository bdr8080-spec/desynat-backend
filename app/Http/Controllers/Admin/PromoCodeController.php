<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Services\PromocodeService;
use App\Services\CountryService;

 
class PromoCodeController extends Controller
{

    public function __construct(PromocodeService $PromocodeService, CountryService $CountryService)
    {
        $this->PromocodeService = $PromocodeService;
        $this->CountryService = $CountryService;
    }

    public function promoCodeManagement(Request $request){
        $promoCodes = $this->PromocodeService->getPromoCodes($request)['data'];
        $countries = $this->CountryService->getCountries()['data'];
        return view('admin.promocode-management.index',compact('promoCodes','countries'));
    }



    



}