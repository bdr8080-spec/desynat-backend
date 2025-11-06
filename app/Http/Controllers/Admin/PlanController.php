<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

    public function managePlans($id, Request $request)
    {
        $request->merge(['country_id' => $id]);
        $plansResponse = $this->PlanService->getPlans($request);
        $plans = $plansResponse['data'];
        return view('admin.plan-management.manage-plans', compact('plans'));
    }

   public function change_plan_status($id)
    {
        $data = $this->PlanService->changePlanStatus($id);

        if ($data['status'] == 'success') {
            $statusText = $data['data']->status == 1 ? 'Activated' : 'Deactivated';
  
            return response()->json([
                'success' => true,
                'status' => $data['data']->status,
                'message' => "Plan has been {$statusText} Successfully!"
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => $data['message']
            ], 400); 
        }
    }


    public function deletePlan($id)
    {
        $result = $this->PlanService->deletePlan($id);

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





}