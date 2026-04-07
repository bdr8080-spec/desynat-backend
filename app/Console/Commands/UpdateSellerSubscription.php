<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SellerSubcriptionPlanBuy;
use App\Models\Plan;
use Carbon\Carbon;

class UpdateSellerSubscription extends Command
{
    protected $signature = 'subscription:update';
    protected $description = 'Update seller subscription monthly limits and expire plans';

    public function handle()
    {
        $today = Carbon::today();

        // Get all active subscriptions
        $subscriptions = SellerSubcriptionPlanBuy::where('payment_status', 1)
            ->where('payment_status', '1')
            ->where('is_expired', '0')
            ->get();

        foreach ($subscriptions as $subscription) {

            //  EXPIRE PLAN
            if (Carbon::parse($subscription->plan_end_date)->lt($today)) {
                $subscription->update([
                    'is_expired' => 1
                ]);
                continue;
            }

            //  MONTHLY RESET CHECK
            $startDate = Carbon::parse($subscription->plan_start_date);

            // Example: if bought on 7th → reset every 7th
            if ($today->day == $startDate->day) {

                $plan = Plan::find($subscription->plan_id);

                if ($plan) {
                    $subscription->update([
                        'product_type'      => $plan->product_type,
                        'no_of_products'    => $plan->no_of_products,
                        'no_of_videos'      => $plan->no_of_videos,
                        'no_of_highlights'  => $plan->no_of_highlights,
                        'no_of_employee'    => $plan->no_of_employee,
                    ]);
                }
            }
        }

        $this->info('Subscription updated successfully');
    }
}