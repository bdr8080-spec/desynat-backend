<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminModuleSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            ['name' => 'dashboard', 'display_name' => 'Dashboard'],

            ['name' => 'brand_management', 'display_name' => 'Brands Management'],
            ['name' => 'category_management', 'display_name' => 'Category & Sub-Category Management'],
            ['name' => 'seller_management', 'display_name' => 'Seller Management'],
            ['name' => 'country_management', 'display_name' => 'Country, City & Zone Management'],
            ['name' => 'plan_management', 'display_name' => 'Subscription Plan Management'],

            ['name' => 'user_management', 'display_name' => 'User Management'],
            ['name' => 'affiliate_user_management', 'display_name' => 'Affiliate User Management'],
            ['name' => 'delivery_boy_management', 'display_name' => 'Delivery Boy Management'],

            ['name' => 'reason_management', 'display_name' => 'Reason Management'],
            ['name' => 'shipping_management', 'display_name' => 'Delivery Charges & Tax Management'],

            ['name' => 'gift_card_management', 'display_name' => 'Gift Card Category Management'],
            ['name' => 'banner_per_day_price_management', 'display_name' => 'Banner Per Day Price Management'],
            ['name' => 'promo_code_management', 'display_name' => 'Promo Code Management'],

            ['name' => 'order_management', 'display_name' => 'Order Management'],
            ['name' => 'affiliate_commission_management', 'display_name' => 'Affiliate Commission Management'],

            ['name' => 'banner_request_management', 'display_name' => 'Banner Request Management'],
            ['name' => 'live_request_management', 'display_name' => 'Live Request & Timeslot Management'],
            ['name' => 'story_management', 'display_name' => 'Story Management'],
            ['name' => 'deal_management', 'display_name' => 'Deal Management'],
            ['name' => 'full_screen_banner_management', 'display_name' => 'Banner Management'],

            ['name' => 'product_management', 'display_name' => 'Product Management'],
            ['name' => 'affiliate_withdraw_request_management', 'display_name' => 'Affiliate User Withdraw Request Management'],

            ['name' => 'cms_management', 'display_name' => 'CMS Management'],
            ['name' => 'notification_management', 'display_name' => 'Notification Management'],
            ['name' => 'ticket_management', 'display_name' => 'Ticket Management'],
            ['name' => 'payment_management', 'display_name' => 'Payment Management'],

            ['name' => 'seller_livestream_management', 'display_name' => 'Current Live Seller'],

            ['name' => 'support_chat', 'display_name' => 'Support Chat'],
        ];

        foreach ($modules as $module) {
            DB::table('admin_modules')->updateOrInsert(
                ['name' => $module['name']],
                [
                    'display_name' => $module['display_name'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}