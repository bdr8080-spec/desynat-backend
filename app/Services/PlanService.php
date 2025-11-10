<?php
namespace App\Services;

use App\Models\Plan;
use App\Models\country;
use Illuminate\Http\Request;


class PlanService
{

   public function addPlan(Request $request)
    {
        try {
            $plan = Plan::create([
                'country_id' => $request->country_id,
                'plan_name_english' => $request->plan_name_english,
                'plan_name_arabic' => $request->plan_name_arabic,
                'duration' => $request->duration,
                'duration_type' => $request->duration_type,
                'no_of_videos' => $request->no_of_videos,
                'no_of_products' => $request->no_of_products,
                'no_of_highlights' => $request->no_of_highlights,
                'no_of_employee' => $request->no_of_employee,
                'stories' => $request->stories,
                'price' => $request->price,
                'commission' => $request->commission,
                'commission_percentage' => $request->commission_percentage ?? null,
            ]);

            return [
                'status' => 'success',
                'message' => 'Plan added successfully',
                'data' => $plan,
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => (object)[],
            ];
        }
    }

    public function updatePlan(Request $request)
    {
        try {
            $plan = Plan::find($request->plan_id);

            if (!$plan) {
                return [
                    'status' => 'error',
                    'message' => 'Plan not found',
                    'data' => (object)[],
                ];
            }

            $plan->update([
                'country_id' => $request->country_id,
                'plan_name_english' => $request->plan_name_english,
                'plan_name_arabic' => $request->plan_name_arabic,
                'duration' => $request->duration,
                'duration_type' => $request->duration_type,
                'no_of_videos' => $request->no_of_videos,
                'no_of_products' => $request->no_of_products,
                'no_of_highlights' => $request->no_of_highlights,
                'no_of_employee' => $request->no_of_employee,
                'stories' => $request->stories,
                'price' => $request->price,
                'commission' => $request->commission,
                'commission_percentage' => $request->commission_percentage ?? null,
            ]);

            return [
                'status' => 'success',
                'message' => 'Plan updated successfully',
                'data' => $plan,
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update plan',
                'data' => (object)[],
            ];
        }
    }

    public function getPlans(Request $request)
    {
        try {
            $query = Plan::with('country_info');

            if ($request->has('country_id')) {
                $query->where('country_id', $request->country_id);
            }

            $plans = $query->orderBy('id', 'desc')->get();

            return [
                'status' => 'success',
                'message' => 'Plans retrieved successfully',
                'data' => $plans,
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch plans',
                'data' => (object)[],
            ];
        }
    }

    public function getPlanDetails($id)
    {
        try {
            $plan = Plan::with('country_info')->find($id);

            if (!$plan) {
                return [
                    'status' => 'error',
                    'message' => 'Plan not found',
                    'data' => (object)[],
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Plan details retrieved successfully',
                'data' => $plan,
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch plan details',
                'data' => (object)[],
            ];
        }
    }

    public function changePlanStatus($planId)
    {
        try {
            $plan = Plan::find($planId);

            if (!$plan) {
                return [
                    'status' => 'error',
                    'message' => 'Plan not found',
                    'data' => (object)[]
                ];
            }

            $plan->status = $plan->status == 1 ? 0 : 1;
            $plan->save();

            return [
                'status' => 'success',
                'message' => 'Plan status updated successfully',
                'data' => $plan
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch plan: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function deletePlan($planId)
    {
        try {
            $plan = Plan::find($planId);

            if (!$plan) {
                return [
                    'status' => 'error',
                    'message' => 'Plan not found',
                    'data' => (object)[]
                ];
            }
            $plan->delete();

            return [
                'status' => 'success',
                'message' => 'Plan deleted successfully',
                'data' => []
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to delete plan',
                'data' => (object)[]
            ];
        }
    }






    

            
        


}
    