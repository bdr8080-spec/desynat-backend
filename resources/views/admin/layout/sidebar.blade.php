
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion customSidebar" id="accordionSidebar">
    <li class="nav-item {{ Request::routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
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
    <li class="nav-item {{ Request::routeIs('categoryManagement') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('categoryManagement') }}">
            <span><img src="{{ asset('admin/image/brand-icon.svg') }}" alt="Category Management" /></span>
            Category & Sub-Category Management
        </a>
    </li>
</ul>

