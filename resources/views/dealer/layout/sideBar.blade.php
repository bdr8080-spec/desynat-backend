    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link border-radious-9 margin-20  {{ Request::is('seller/dashboard') ? 'sidebar-active' : '' }}"
                    href="{{ route('seller.dashboard') }}">
                    <img src="{{ asset('dealer') }}/assets/img/all-icons/dashboard.svg" alt="icon" class="asideicon">
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link border-radious-9 margin-20 {{ Request::is('seller/products') || Request::is('seller/Add-product') ? 'sidebar-active' : '' }}"
                    href="{{ route('seller.products') }}">
                    <img src="{{ asset('dealer') }}/assets/img/all-icons/product.svg" alt="icon" class="asideicon">
                    <span>Product Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link border-radious-9 margin-20 {{ Request::is('seller/inventory-Management') || Request::is('seller/view-inventory/*') ? 'sidebar-active' : '' }}"
                    href="{{ route('seller.Inventory_Management') }}">
                    <img src="{{ asset('dealer') }}/assets/img/all-icons/inventory.svg" alt="icon" class="asideicon">
                    <span>Inventory Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link border-radious-9 margin-20 {{ Request::is('seller/update-commison') ? 'sidebar-active' : '' }}"
                    href="{{ route('seller.update_commison') }}">
                    <img src="{{ asset('dealer') }}/assets/img/all-icons/affiliated.svg" alt="icon" class="asideicon">
                    <span>Affiliated Commission</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link border-radious-9 margin-20" href="/staff-management">
                    <img src="{{ asset('dealer') }}/assets/img/all-icons/staff.svg" alt="icon" class="asideicon">
                    <span>Staff Management</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link border-radious-9 margin-20 {{ Request::is('seller/show-banner') ? 'sidebar-active' : '' }}"
                    href="{{ route('seller.show_banner') }}">
                    <img src="{{ asset('dealer') }}/assets/img/all-icons/banner.svg" alt="icon" class="asideicon">
                    <span>Banner Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link border-radious-9 margin-20 {{ Request::is('seller/order-management') ? 'sidebar-active' : '' }}"
                    href="{{ route('seller.order_management') }}">
                    <img src="{{ asset('dealer') }}/assets/img/all-icons/order.svg" alt="icon" class="asideicon">
                    <span>Order Management</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link border-radious-9 margin-20 {{ Request::is('seller/deal-management')||  Request::is('seller/View-single-deal-management/*') ||  Request::is('seller/add-single-deal-management/*')? 'sidebar-active' : '' }}"
                    href="{{ route('seller.deal_management') }}">
                    <img src="{{ asset('dealer') }}/assets/img/all-icons/deal.svg" alt="icon" class="asideicon">
                    <span>Deal Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link border-radious-9 margin-20 {{ Request::is('seller/seller-live')? 'sidebar-active' : ''}} "
                    href="{{ route('sellerLiveRequest') }}">
                    <img src="{{ asset('dealer') }}/assets/img/all-icons/live-send.svg" alt="icon" class="asideicon">
                    <span>Live</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link border-radious-9 margin-20 {{ Request::is('seller/live-request')? 'sidebar-active' : ''}} "
                    href="{{ route('seller.liveRequests') }}">
                    <img src="{{ asset('dealer') }}/assets/img/all-icons/live-send.svg" alt="icon" class="asideicon">
                    <span>Live Coverage Requests</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link border-radious-9 margin-20 {{ Request::is('seller/subscription-plans')? 'sidebar-active' : ''}} "
                    href="{{ route('seller.subscriptionPlan') }}">
                    <img src="{{ asset('dealer') }}/assets/img/all-icons/plan.svg" alt="icon" class="asideicon">
                    <span>Subscription Plans</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link border-radious-9 margin-20 {{ Request::is('seller/ticket-management')? 'sidebar-active' : ''}} "
                    href="{{ route('seller.ticket_management') }}">
                    <img src="{{ asset('dealer') }}/assets/img/all-icons/plan.svg" alt="icon" class="asideicon">
                    <span>Ticket Management </span>
                </a>
            </li>

            <!-- <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Components</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="components-alerts.html">
                            <i class="bi bi-circle"></i><span>Alerts</span>
                        </a>
                    </li>
                </ul>
            </li> -->


        </ul>

    </aside>