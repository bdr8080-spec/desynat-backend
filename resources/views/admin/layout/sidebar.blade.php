
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion customSidebar" id="accordionSidebar">
    <li class="nav-item {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <span><img src="{{ asset('admin/image/dashboard.svg') }}" alt="Dashboard" /></span>
            Dashboard
        </a>
    </li>
    <li class="nav-item {{ Request::routeIs('brandManagement') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('brandManagement') }}">
            <span><img src="{{ asset('admin/image/brand-icon.svg') }}" alt="Brands Management" /></span>
            Brands Management
        </a>
    </li>
    <li class="nav-item {{ Request::routeIs('categoryManagement') || Request::routeIs('manageSubCategory') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('categoryManagement') }}">
            <span><img src="{{ asset('admin/image/category.svg') }}" alt="Category Management" /></span>
            Category & Sub-Category Management
        </a>
    </li>
    <li class="nav-item {{ Request::routeIs('sellerManagement') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('sellerManagement') }}">
            <span><img src="{{ asset('admin/image/seller.svg') }}" alt="Seller Management" /></span>
            Seller Management
        </a>
    </li>
    <li class="nav-item {{ Request::routeIs('countryManagement') || Request::routeIs('manageCities') || Request::routeIs('manageZones') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('countryManagement') }}">
            <span><img src="{{ asset('admin/image/country.svg') }}" alt="Country Management" /></span>
            Country,City & Zone Management
        </a>
    </li>
    <li class="nav-item {{ Request::routeIs('planManagement') || Request::routeIs('managePlans') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('planManagement') }}">
            <span><img src="{{ asset('admin/image/subscription.svg') }}" alt="Plan Management" /></span>
            Subscription Plan Management
        </a>
    </li>
    <li class="nav-item {{ Request::routeIs('admin.userManagement') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.userManagement') }}">
            <span><img src="{{ asset('admin/image/users-01.svg') }}" alt="Plan Management" /></span>
            User Management
        </a>
    </li>
    <li class="nav-item {{ Request::routeIs('admin.deliveryBoyManagement') || Request::routeIs('admin.deliveryboy_reg_step1') || Request::routeIs('admin.deliveryboy_reg_step2') || Request::routeIs('admin.edit_deliveryboy_step1') || Request::routeIs('admin.edit_deliveryboy_step2') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.deliveryBoyManagement') }}">
            <span><img src="{{ asset('admin/image/image-user-check.svg') }}" alt="Plan Management" /></span>
            Delivery Boy Management
        </a>
    </li>
    <li class="nav-item {{ Request::routeIs('admin.reasonManagement') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.reasonManagement') }}">
            <span><img src="{{ asset('admin/image/help-circle.svg') }}" alt="Plan Management" /></span>
            Reason Management
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('adminLogout') }}">
            <span><img src="{{ asset('admin/image/logout.svg') }}" alt="Logout" /></span>
            Logout
        </a>
    </li>
</ul>

