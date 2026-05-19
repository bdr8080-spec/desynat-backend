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
        'title_ar' => 'لوحة التحكم',
        'route' => 'seller.dashboard',
        'icon' => 'dealer/assets/img/all-icons/dashboard.svg',
        'active_patterns' => json_encode(['seller/dashboard']),
        'order_by' => 1,
        'status' => 1
    ],

    [
        'title' => 'Product Management',
        'title_ar' => 'إدارة المنتجات',
        'route' => 'seller.products',
        'icon' => 'dealer/assets/img/all-icons/product.svg',
        'active_patterns' => json_encode(['seller/products','seller/Add-product']),
        'order_by' => 2,
        'status' => 1
    ],

    [
        'title' => 'Inventory Management',
        'title_ar' => 'إدارة المخزون',
        'route' => 'seller.Inventory_Management',
        'icon' => 'dealer/assets/img/all-icons/inventory.svg',
        'active_patterns' => json_encode(['seller/inventory-Management','seller/view-inventory/*']),
        'order_by' => 3,
        'status' => 1
    ],

    [
        'title' => 'Affiliated Commission',
        'title_ar' => 'العمولة التابعة',
        'route' => 'seller.update_commison',
        'icon' => 'dealer/assets/img/all-icons/affiliated.svg',
        'active_patterns' => json_encode(['seller/update-commison']),
        'order_by' => 4,
        'status' => 1
    ],

    [
        'title' => 'Banner Management',
        'title_ar' => 'إدارة البنرات',
        'route' => 'seller.show_banner',
        'icon' => 'dealer/assets/img/all-icons/banner.svg',
        'active_patterns' => json_encode([
            'seller/show-banner',
            'seller/add-banner'    
        ]),
        'order_by' => 5,
        'status' => 1
    ],

    [
        'title' => 'Order Management',
        'title_ar' => 'إدارة الطلبات',
        'route' => 'seller.order_management',
        'icon' => 'dealer/assets/img/all-icons/order.svg',
        'active_patterns' => json_encode(['seller/order-management',"seller/single-order-view/*"]),
        'order_by' => 6,
        'status' => 1
    ],

    [
        'title' => 'Deal Management',
        'title_ar' => 'إدارة العروض',
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
        'title_ar' => 'مباشر',
        'route' => 'sellerLiveRequest',
        'icon' => 'dealer/assets/img/all-icons/live.svg',
        'active_patterns' => json_encode(['seller/seller-live']),
        'order_by' => 8,
        'status' => 1
    ],

    [
        'title' => 'Live Coverage Requests',
        'title_ar' => 'طلبات التغطية المباشرة',
        'route' => 'seller.liveRequests',
        'icon' => 'dealer/assets/img/all-icons/live-send.svg',
        'active_patterns' => json_encode(['seller/live-request']),
        'order_by' => 9,
        'status' => 1
    ],

    [
        'title' => 'Subscription Plans',
        'title_ar' => 'خطط الاشتراك',
        'route' => 'seller.subscriptionPlan',
        'icon' => 'dealer/assets/img/all-icons/plan.svg',
        'active_patterns' => json_encode(['seller/subscription-plans']),
        'order_by' => 10,
        'status' => 1
    ],

    [
        'title' => 'Ticket Management',
        'title_ar' => 'إدارة التذاكر',
        'route' => 'seller.ticket_management',
        'icon' => 'dealer/assets/img/all-icons/plan.svg',
        'active_patterns' => json_encode(['seller/ticket-management']),
        'order_by' => 11,
        'status' => 1
    ],

    [
        'title' => 'Staff Management',
        'title_ar' => 'إدارة الموظفين',
        'route' => 'dealer.staff-management',
        'icon' => 'dealer/assets/img/all-icons/staff.svg',
        'active_patterns' => json_encode(['seller/staff-management']),
        'order_by' => 12,
        'status' => 1
    ],

    [
        'title' => 'Refund Management',
        'title_ar' => 'إدارة الاسترجاع',
        'route' => 'seller.refundManagement',
        'icon' => 'dealer/assets/img/all-icons/refund.svg',
        'active_patterns' => json_encode(['seller/refund-management']),
        'order_by' => 19,
        'status' => 1
    ],

    [
        'title' => 'Terms & Condition',
        'title_ar' => 'الشروط والأحكام',
        'route' => 'seller.termCondition',
        'icon' => 'dealer/assets/img/all-icons/terms.svg',
        'active_patterns' => json_encode(['seller/terms-conditions']),
        'order_by' => 13,
        'status' => 1
    ],

    [
        'title' => 'About Us',
        'title_ar' => 'معلومات عنا',
        'route' => 'seller.aboutUs',
        'icon' => 'dealer/assets/img/m3-icon/about.svg',
        'active_patterns' => json_encode(['seller/about-us']),
        'order_by' => 14,
        'status' => 1
    ],

    [
        'title' => 'Faq',
        'title_ar' => 'الأسئلة الشائعة',
        'route' => 'seller.faq',
        'icon' => 'dealer/assets/img/all-icons/faqs.svg',
        'active_patterns' => json_encode(['seller/faq']),
        'order_by' => 15,
        'status' => 1
    ],

    [
        'title' => 'Return Policy',
        'title_ar' => 'سياسة الإرجاع',
        'route' => 'seller.returnPolicy',
        'icon' => 'dealer/assets/img/all-icons/return.svg',
        'active_patterns' => json_encode(['seller/return-policy']),
        'order_by' => 16,
        'status' => 1
    ],

    [
        'title' => 'Exchange Policy',
        'title_ar' => 'سياسة الاستبدال',
        'route' => 'seller.exchangePolicy',
        'icon' => 'dealer/assets/img/all-icons/exchange.svg',
        'active_patterns' => json_encode(['seller/exchange-policy']),
        'order_by' => 17,
        'status' => 1
    ],

    [
        'title' => 'Cancellation Policy',
        'title_ar' => 'سياسة الإلغاء',
        'route' => 'seller.cancellationPolicy',
        'icon' => 'dealer/assets/img/all-icons/terms.svg',
        'active_patterns' => json_encode(['seller/cancellation-policy']),
        'order_by' => 18,
        'status' => 1
    ],

    [
        'title' => 'Setting',
        'title_ar' => 'الإعدادات',
        'route' => 'seller.setting',
        'icon' => 'dealer/assets/img/m3-icon/setting.svg',
        'active_patterns' => json_encode(['seller/setting']),
        'order_by' => 20,
        'status' => 1
    ]

]);


    }
}
