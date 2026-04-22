@php
    $admin = auth('admin')->user();

    $permissions = \App\Models\AdminPermission::where('admin_id', $admin->id)
        ->where('can_view', 1)
        ->pluck('module_id')
        ->toArray();
@endphp

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion customSidebar" id="accordionSidebar">
    @if(in_array(1, $permissions) || $admin->type == 1)
    <li class="nav-item {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <span><img src="{{ asset('admin/image/dashboard.svg') }}" alt="Dashboard" /></span>
            Dashboard
        </a>
    </li>
    @endif
    @if(in_array(2, $permissions) || $admin->type == 1)
    <li class="nav-item {{ Request::routeIs('brandManagement') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('brandManagement') }}">
            <span><img src="{{ asset('admin/image/brand-icon.svg') }}" alt="Brands Management" /></span>
            Brands Management
        </a>
    </li>
    @endif
    @if(in_array(3, $permissions) || $admin->type == 1)
    <li
        class="nav-item {{ Request::routeIs('categoryManagement') || Request::routeIs('manageSubCategory') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('categoryManagement') }}">
            <span><img src="{{ asset('admin/image/category.svg') }}" alt="Category Management" /></span>
            Category & Sub-Category Management
        </a>
    </li>
    @endif
    @if(in_array(3, $permissions) || $admin->type == 1)
    <li class="nav-item {{ Request::routeIs('sellerManagement') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('sellerManagement') }}">
            <span><img src="{{ asset('admin/image/seller.svg') }}" alt="Seller Management" /></span>
            Seller Management
        </a>
    </li>
    @endif
    @if(in_array(5, $permissions) || $admin->type == 1)
    <li
        class="nav-item {{ Request::routeIs('countryManagement') || Request::routeIs('manageCities') || Request::routeIs('manageZones') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('countryManagement') }}">
            <span><img src="{{ asset('admin/image/country.svg') }}" alt="Country Management" /></span>
            Country,City & Zone Management
        </a>
    </li>
    @endif
    @if(in_array(6, $permissions) || $admin->type == 1)
    <li class="nav-item {{ Request::routeIs('planManagement') || Request::routeIs('managePlans') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('planManagement') }}">
            <span><img src="{{ asset('admin/image/subscription.svg') }}" alt="Plan Management" /></span>
            Subscription Plan Management
        </a>
    </li>
    @endif
    @if(in_array(7, $permissions) || $admin->type == 1)
    <li class="nav-item {{ Request::routeIs('admin.userManagement') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.userManagement') }}">
            <span><img src="{{ asset('admin/image/users-01.svg') }}" alt="Plan Management" /></span>
            User Management
        </a>
    </li>
    @endif
    @if(in_array(8, $permissions) || $admin->type == 1)
    <li class="nav-item {{ Request::routeIs('admin.affiliateUserManagement') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.affiliateUserManagement') }}">
            <span><img src="{{ asset('admin/image/users-01.svg') }}" alt="Plan Management" /></span>
            Affiliate User Management
        </a>
    </li>
    @endif
    @if(in_array(9, $permissions) || $admin->type == 1)
    <li
        class="nav-item {{ Request::routeIs('admin.deliveryBoyManagement') || Request::routeIs('admin.deliveryboy_reg_step1') || Request::routeIs('admin.deliveryboy_reg_step2') || Request::routeIs('admin.edit_deliveryboy_step1') || Request::routeIs('admin.edit_deliveryboy_step2') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.deliveryBoyManagement') }}">
            <span><img src="{{ asset('admin/image/image-user-check.svg') }}" alt="Plan Management" /></span>
            Delivery Boy Management
        </a>
    </li>
    @endif
    @if(in_array(10, $permissions) || $admin->type == 1)
    <li class="nav-item {{ Request::routeIs('admin.reasonManagement') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.reasonManagement') }}">
            <span><img src="{{ asset('admin/image/help-circle.svg') }}" alt="Plan Management" /></span>
            Reason Management
        </a>
    </li>
    @endif
    @if(in_array(11, $permissions) || $admin->type == 1)
    <li
        class="nav-item {{ Request::routeIs('admin.shippingManagement') || Request::routeIs('admin.manageShippingCharges') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.shippingManagement') }}">
            <span><img src="{{ asset('admin/image/category.svg') }}" alt="Shipping Management" /></span>
            Delivery Charges & Tax Management
        </a>
    </li>
    @endif
    @if(in_array(12, $permissions) || $admin->type == 1)
    <li class="nav-item {{ Request::routeIs('admin.giftCardManagement') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.giftCardManagement') }}">
            <span><img src="{{ asset('admin/image/DDDDDDDDD/gift.svg') }}" alt="Gift Card Management" /></span>
            Gift Card Category Management
        </a>
    </li>
    @endif
    @if(in_array(13, $permissions) || $admin->type == 1)
    <li class="nav-item {{ Request::routeIs('admin.bannerManagement') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.bannerManagement') }}">
            <span><img src="{{ asset('admin/image/DDDDDDDDD/banner.svg') }}" alt="Banner Management" /></span>
            Banner Per day Price Management
        </a>
    </li>
    @endif
    @if(in_array(14, $permissions) || $admin->type == 1)
    <li class="nav-item {{ Request::routeIs('admin.promoCodeManagement') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.promoCodeManagement') }}">
            <span><img src="{{ asset('admin/image/DDDDDDDDD/addvertisement.svg') }}"
                    alt="Promo Code Management" /></span>
            Promo Code Management
        </a>
    </li>
    @endif
    @if(in_array(15, $permissions) || $admin->type == 1)
    <li class="nav-item {{ Request::routeIs('admin.orderManagement') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.orderManagement') }}">
            <span><img src="{{ asset('admin/image/Icon.svg') }}" alt="Order Management" /></span>
            Order Management
        </a>
    </li>
    @endif
    @if(in_array(16, $permissions) || $admin->type == 1)
    <li class="nav-item {{ Request::routeIs('admin.affiliateCommissionManagement') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.affiliateCommissionManagement') }}">
            <span><img src="{{ asset('admin/image/seller.svg') }}" alt="Affiliate Commission Management" /></span>
            Affiliate Commission Management
        </a>
    </li>
    @endif
    @if(in_array(17, $permissions) || $admin->type == 1)
    <li class="nav-item {{ Request::routeIs('admin.bannerRequestManagement') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.bannerRequestManagement') }}">
            <span><img src="{{ asset('admin/image/image-03.svg') }}" alt="Banner Request Management" /></span>
            Banner Request Management
        </a>
    </li>
    @endif
    @if(in_array(18, $permissions) || $admin->type == 1)
    <li class="nav-item {{ Request::routeIs('admin.liveRequestManagement') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.liveRequestManagement') }}">
            <span><img src="{{ asset('admin/image/play-square.svg') }}" alt="Live Request Management" /></span>
            Live Request & Timeslot Management
        </a>
    </li>
    @endif
    @if(in_array(19, $permissions) || $admin->type == 1)
    <li class="nav-item {{ Request::routeIs('admin.storyManagement') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.storyManagement') }}">
            <span><img src="{{ asset('admin/image/Frame-3.svg') }}" alt="Story Management" /></span>
            Story Management
        </a>
    </li>
    @endif
    @if(in_array(20, $permissions) || $admin->type == 1)
    <li class="nav-item {{ Request::routeIs('admin.dealManagement') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dealManagement') }}">
            <span><img src="{{ asset('admin/image/Frame.svg') }}" alt="Deal Management" /></span>
            Deal Management
        </a>
    </li>
    @endif
    @if(in_array(21, $permissions) || $admin->type == 1)
    <li class="nav-item {{ Request::routeIs('admin.fullScreenBannerManagement') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.fullScreenBannerManagement') }}">
            <span><img src="{{ asset('admin/image/browser.svg') }}" alt="Full Screen Banner Management" /></span>
            Banner Management
        </a>
    </li>
    @endif
    @if(in_array(22, $permissions) || $admin->type == 1)
    <li class="nav-item {{ Request::routeIs('admin.productManagement') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.productManagement') }}">
            <span><img src="{{ asset('admin/image/list.svg') }}" alt="Product Management" /></span>
            Product Management
        </a>
    </li>
    @endif
    @if(in_array(23, $permissions) || $admin->type == 1)
    <li class="nav-item {{ Request::routeIs('admin.affiliateWithdrawRequestManagement') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.affiliateWithdrawRequestManagement') }}">
            <span><img src="{{ asset('admin/image/credit-card-down.svg') }}"
                    alt="Affiliate Withdraw Request Management" /></span>
            Affiliate User Withdraw Request Management
        </a>
    </li>
    @endif
    @if(in_array(24, $permissions) || $admin->type == 1)
    <li class="nav-item {{ Request::routeIs('admin.cmsManagement') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.cmsManagement') }}">
            <span><img src="{{ asset('admin/image/users-01-1.svg') }}" alt="icon" /></span>
            CMS Management
        </a>
    </li>
    @endif
    @if(in_array(25, $permissions) || $admin->type == 1)
    <li
        class="nav-item {{ Request::routeIs('admin.notificationManagement') || Request::routeIs('admin.sendNotification') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.notificationManagement') }}">
            <span><img src="{{ asset('admin/image/bell-01.svg') }}" alt="icon" /></span>
            Notification Management
        </a>
    </li>
    @endif
    @if(in_array(26, $permissions) || $admin->type == 1)
    <li class="nav-item {{ Request::routeIs('admin.ticketManagement') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.ticketManagement') }}">
            <span><img src="{{ asset('admin/image/bell-01.svg') }}" alt="icon" /></span>
            Ticket Management
        </a>
    </li>
    @endif
    @if(in_array(27, $permissions) || $admin->type == 1)
    <li class="nav-item {{ Request::routeIs('admin.paymentManagement') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.paymentManagement') }}">
            <span><img src="{{ asset('admin/image/bell-01.svg') }}" alt="icon" /></span>
            Payment Management
        </a>
    </li>
    @endif
    @if(in_array(28, $permissions) || $admin->type == 1)
    <li class="nav-item {{ Request::routeIs('admin.sellerlivestreamManagemnt') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.sellerlivestreamManagemnt') }}">
            <span><img src="{{ asset('admin/image/play-square.svg') }}" alt="icon" /></span>
            Current Live Seller
        </a>
    </li>
    @endif
    @if(in_array(29, $permissions) || $admin->type == 1)
    <!-- <li class="nav-item">
        <a class="nav-link" href="/support">
            <span><img src="{{ asset('admin/image/bell-01.svg') }}" alt="icon" /></span>
            Support Chat
        </a>
    </li> -->
    @endif
    @if(in_array(30, $permissions) || $admin->type == 1)
    <li class="nav-item {{ Request::routeIs('admin.accountSetting') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.accountSetting') }}">
            <span><img src="{{ asset('admin/image/play-square.svg') }}" alt="icon" /></span>
            Account Setting
        </a>
    </li>
    @endif
    @if(in_array(31, $permissions) || $admin->type == 1)
    <li class="nav-item {{ Request::routeIs('admin.subAdminManagement') || Request::routeIs('admin.add_subadmin') || Request::routeIs('admin.edit_subadmin') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.subAdminManagement') }}">
            <span><img src="{{ asset('admin/image/play-square.svg') }}" alt="icon" /></span>
            Sub Admin Management
        </a>
    </li>
    @endif
    @if(in_array(32, $permissions) || $admin->type == 1)
    <li class="nav-item {{ Request::routeIs('admin.refundManagement') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.refundManagement') }}">
            <span><img src="{{ asset('admin/image/play-square.svg') }}" alt="icon" /></span>
            Refund Management
        </a>
    </li>
    @endif

    <!-- <li class="nav-item">
        <a class="nav-link" href="{{ route('adminLogout') }}">
            <span><img src="{{ asset('admin/image/logout.svg') }}" alt="Logout" /></span>
            Logout
        </a>
    </li> -->
</ul>