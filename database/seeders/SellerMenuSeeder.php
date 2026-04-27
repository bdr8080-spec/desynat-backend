<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

  use App\Models\SellerMenus_table;

class SellerMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

SellerMenus_table::truncate(); // optional (clear old data)

SellerMenus_table::insert([

    [
        'title' => 'Dashboard',
        'route' => 'seller.dashboard',
        'icon' => 'dealer/assets/img/all-icons/dashboard.svg',
        'active_patterns' => json_encode(['seller/dashboard']),
        'order_by' => 1,
        'status' => 1
    ],

    [
        'title' => 'Product Management',
        'route' => 'seller.products',
        'icon' => 'dealer/assets/img/all-icons/product.svg',
        'active_patterns' => json_encode([
            'seller/products',
            'seller/Add-product'
        ]),
        'order_by' => 2,
        'status' => 1
    ],

    [
        'title' => 'Inventory Management',
        'route' => 'seller.Inventory_Management',
        'icon' => 'dealer/assets/img/all-icons/inventory.svg',
        'active_patterns' => json_encode([
            'seller/inventory-Management',
            'seller/view-inventory/*'
        ]),
        'order_by' => 3,
        'status' => 1
    ],

    [
        'title' => 'Affiliated Commission',
        'route' => 'seller.update_commison',
        'icon' => 'dealer/assets/img/all-icons/affiliated.svg',
        'active_patterns' => json_encode(['seller/update-commison']),
        'order_by' => 4,
        'status' => 1
    ],

    [
        'title' => 'Banner Management',
        'route' => 'seller.show_banner',
        'icon' => 'dealer/assets/img/all-icons/banner.svg',
        'active_patterns' => json_encode(['seller/show-banner']),
        'order_by' => 5,
        'status' => 1
    ],

    [
        'title' => 'Order Management',
        'route' => 'seller.order_management',
        'icon' => 'dealer/assets/img/all-icons/order.svg',
        'active_patterns' => json_encode(['seller/order-management']),
        'order_by' => 6,
        'status' => 1
    ],

    [
        'title' => 'Deal Management',
        'route' => 'seller.deal_management',
        'icon' => 'dealer/assets/img/all-icons/deal.svg',
        'active_patterns' => json_encode([
            'seller/deal-management',
            'seller/View-single-deal-management/*',
            'seller/add-single-deal-management/*'
        ]),
        'order_by' => 7,
        'status' => 1
    ],

    [
        'title' => 'Live',
        'route' => 'sellerLiveRequest',
        'icon' => 'dealer/assets/img/all-icons/live-send.svg',
        'active_patterns' => json_encode(['seller/seller-live']),
        'order_by' => 8,
        'status' => 1
    ],

    [
        'title' => 'Live Coverage Requests',
        'route' => 'seller.liveRequests',
        'icon' => 'dealer/assets/img/all-icons/live-send.svg',
        'active_patterns' => json_encode(['seller/live-request']),
        'order_by' => 9,
        'status' => 1
    ],

    [
        'title' => 'Subscription Plans',
        'route' => 'seller.subscriptionPlan',
        'icon' => 'dealer/assets/img/all-icons/plan.svg',
        'active_patterns' => json_encode(['seller/subscription-plans']),
        'order_by' => 10,
        'status' => 1
    ],

    [
        'title' => 'Ticket Management',
        'route' => 'seller.ticket_management',
        'icon' => 'dealer/assets/img/all-icons/plan.svg',
        'active_patterns' => json_encode(['seller/ticket-management']),
        'order_by' => 11,
        'status' => 1
    ],
    [
        'title' => 'Staff Management',
        'route' => 'dealer.staff-management',
        'icon' => 'dealer/assets/img/all-icons/plan.svg',
        'active_patterns' => json_encode(['seller/staff-management']),
        'order_by' => 12,
        'status' => 1
    ],
    [
        'title' => 'Refund Management',
        'route' => 'seller.refundManagement',
        'icon' => 'dealer/assets/img/all-icons/refund.svg',
        'active_patterns' => json_encode(['seller/refund-management']),
        'order_by' => 19,
        'status' => 1
    ],
    [
        'title' => 'Terms & Condition',
        'route' => 'seller.termCondition',
        'icon' => 'dealer/assets/img/all-icons/plan.svg',
        'active_patterns' => json_encode(['seller/terms-conditions']),
        'order_by' => 13,
        'status' => 1
    ],
    [
        'title' => 'About Us',
        'route' => 'seller.aboutUs',
        'icon' => 'dealer/assets/img/all-icons/plan.svg',
        'active_patterns' => json_encode(['seller/about-us']),
        'order_by' => 14,
        'status' => 1
    ],
    [
        'title' => 'Faq',
        'route' => 'seller.faq',
        'icon' => 'dealer/assets/img/all-icons/faqs.svg',
        'active_patterns' => json_encode(['seller/faq']),
        'order_by' => 15,
        'status' => 1
    ],
    [
        'title' => 'Return Policy',
        'route' => 'seller.returnPolicy',
        'icon' => 'dealer/assets/img/all-icons/plan.svg',
        'active_patterns' => json_encode(['seller/return-policy']),
        'order_by' => 16,
        'status' => 1
    ],
    [
        'title' => 'Exchange Policy',
        'route' => 'seller.exchangePolicy',
        'icon' => 'dealer/assets/img/all-icons/plan.svg',
        'active_patterns' => json_encode(['seller/exchange-policy']),
        'order_by' => 17,
        'status' => 1
    ],
    [
        'title' => 'Cancellation Policy',
        'route' => 'seller.cancellationPolicy',
        'icon' => 'dealer/assets/img/all-icons/terms.svg',
        'active_patterns' => json_encode(['seller/cancellation-policy']),
        'order_by' => 18,
        'status' => 1
    ],
    [
        'title' => 'Setting',
        'route' => 'seller.setting',
        'icon' => 'dealer/assets/img/all-icons/plan.svg',
        'active_patterns' => json_encode(['seller/setting']),
        'order_by' => 20,
        'status' => 1
    ]

]);


    }
}
