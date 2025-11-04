
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
            <span><img src="{{ asset('admin/image/brand-icon.svg') }}" alt="Seller Management" /></span>
            Seller Management
        </a>
    </li>
    <li class="nav-item {{ Request::routeIs('countryManagement') || Request::routeIs('manageCities') || Request::routeIs('manageZones') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('countryManagement') }}">
            <span><img src="{{ asset('admin/image/category.svg') }}" alt="Country Management" /></span>
            Country,City & Zone Management
        </a>
    </li>
    <li class="nav-item {{ Request::routeIs('planManagement') || Request::routeIs('managePlans') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('planManagement') }}">
            <span><img src="{{ asset('admin/image/category.svg') }}" alt="Plan Management" /></span>
            Subscription Plan Management
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('adminLogout') }}">
            <span><img src="{{ asset('admin/image/logout.svg') }}" alt="Logout" /></span>
            Logout
        </a>
    </li>
</ul>

