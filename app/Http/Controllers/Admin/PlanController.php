<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdminAuthService;
use App\Models\country;
use Validator;
use App\Services\CountryService;
use App\Services\PlanService;
 
class PlanController extends Controller
{
    
    public function __construct(CountryService $CountryService, PlanService $PlanService)
    {
        $this->CountryService = $CountryService;
        $this->PlanService = $PlanService;
    }


    public function planManagement(Request $request){
        $countries = $this->CountryService->getCountries()['data'];
        //dd($countries);
        return view('admin.plan-management.index', compact('countries'));
    }

    // public function managePlans(Request $request){
    //     return view('admin.plan-management.manage-plans');
    // }
    public function managePlans($id, Request $request)
    {
        $request->merge(['country_id' => $id]);
        $plansResponse = $this->PlanService->getPlans($request);
        $plans = $plansResponse['data'];
        return view('admin.plan-management.manage-plans', compact('plans'));
    }




}