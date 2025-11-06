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

    public function add_plan(Request $request)
    {
        // Validation
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'plan_name_english' => 'required|string',
            'plan_name_arabic' => 'required|string',
            'duration' => 'required|numeric',
            'duration_type' => 'required|in:1,2',
            'no_of_videos' => 'required|numeric',
            'no_of_products' => 'required|numeric',
            'no_of_highlights' => 'required|numeric',
            'no_of_employee' => 'required|numeric',
            'stories' => 'required|in:yes,no',
            'price' => 'required|numeric',
            'commission' => 'required|in:yes,no',
            'commission_percentage' => 'required_if:commission,yes|nullable|numeric',
        ]);

        try {
            $request->merge([
                'stories' => $request->stories === 'yes' ? 1 : 0,
                'commission' => $request->commission === 'yes' ? 1 : 0,
            ]);

            $plan = $this->PlanService->addPlan($request);

            return response()->json([
                'status' => 'success',
                'message' => 'Plan added successfully',
                'data' => $plan
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create plan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update_plan(Request $request)
    {
        // Validation
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'country_id' => 'required|exists:countries,id',
            'plan_name_english' => 'required|string',
            'plan_name_arabic' => 'required|string',
            'duration' => 'required|numeric',
            'duration_type' => 'required|in:1,2',
            'no_of_videos' => 'required|numeric',
            'no_of_products' => 'required|numeric',
            'no_of_highlights' => 'required|numeric',
            'no_of_employee' => 'required|numeric',
            'stories' => 'required|in:yes,no',
            'price' => 'required|numeric',
            'commission' => 'required|in:yes,no',
            'commission_percentage' => 'required_if:commission,yes|nullable|numeric',
        ]);

        try {
            // Convert yes/no to 1/0 for database
            $request->merge([
                'stories' => $request->stories === 'yes' ? 1 : 0,
                'commission' => $request->commission === 'yes' ? 1 : 0,
            ]);

            $plan = $this->PlanService->updatePlan($request);

            return response()->json([
                'status' => 'success',
                'message' => 'Plan updated successfully',
                'data' => $plan,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update plan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }







}