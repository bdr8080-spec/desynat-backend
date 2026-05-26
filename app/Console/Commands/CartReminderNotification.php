<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Addtocart;
use Carbon\Carbon;

class CartReminderNotification extends Command
{
    protected $signature = 'cart:reminder';

    protected $description = 'Send cart reminder notifications every hour';

    public function handle()
    {
        $userIds = Addtocart::where('updated_at', '<=', Carbon::now()->subHour())
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

            Addtocart::where('user_id', $user->id)
                ->update([
                    'updated_at' => now()
                ]);

            $this->info("Notification sent to User ID: {$user->id}");
        }

        $this->info('Cart reminder notifications sent successfully.');
    }
}