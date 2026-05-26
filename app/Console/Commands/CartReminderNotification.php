<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Addtocart;
use Carbon\Carbon;

class CartReminderNotification extends Command
{
    protected $signature = 'cart:reminder';

    protected $description = 'Send cart reminder notifications (1h, 24h, 48h)';

    public function handle()
    {
        $now = Carbon::now();

        //  after 1 hour
        $this->sendReminder(1, $now->copy()->subHour(), 1);

        // after 24 hours
        $this->sendReminder(2, $now->copy()->subHours(24), 2);

        // after 48 hours
        $this->sendReminder(3, $now->copy()->subHours(48), 3);

        $this->info('Cart reminder process completed.');
    }

    private function sendReminder($step, $timeLimit, $nextStep)
    {
        $userIds = Addtocart::where('cart_reminder_step', $step - 1)
            ->where('updated_at', '<=', $timeLimit)
            ->distinct()
            ->pluck('user_id');

        $users = User::whereIn('id', $userIds)->get();

        foreach ($users as $user) {

            CreateNotification([
                'sender_id' => 1,
                'sender_type' => 1,
                'receiver_id' => $user->id,
                'receiver_type' => 2,

                'title_english' => 'Cart Reminder',
                'title_arabic' => 'تذكير بالسلة',

                'description_english' => 'Your favorite pieces are waiting! Complete your order now before they run out.',
                'description_arabic' => 'القطع المفضلة لديك بانتظارك في السلة! أكمل طلبكِ الآن قبل أن تنفد الكمية.',

                'notification_type' => 'cart_reminder'
            ]);

            // update step
            Addtocart::where('user_id', $user->id)
                ->update([
                    'cart_reminder_step' => $step
                ]);

            $this->info("Step {$step} sent to User ID: {$user->id}");
        }
    }
}