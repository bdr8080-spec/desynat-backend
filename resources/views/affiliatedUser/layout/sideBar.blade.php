    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link border-radious-9 margin-20  {{ Request::is('affiliate-dashboard') ? 'sidebar-active' : '' }}"
                    href="{{ route('affiliate.affiliateDashboard') }}">
                    <img src="{{ asset('dealer') }}/assets/img/all-icons/dashboard.svg" alt="icon" class="asideicon">
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link border-radious-9 margin-20 {{ Request::is('affiliate/my-product')|| Request::is('affiliate/affiliate-product-performance*') ? 'sidebar-active' : '' }} "
                    href="{{route('affiliate.affiliateMyProduct')}}">
                    <img src="{{ asset('dealer') }}/assets/img/all-icons/my-product.svg" alt="icon" class="asideicon">
                    <span>My Product</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link border-radious-9 margin-20 
                {{ Request::is('affiliate/category') || Request::is('affiliate/all-products*') ? 'sidebar-active' : '' }}"
                    href="{{route('affiliate.affiliateCategory')}}">
                    <img src="{{ asset('dealer') }}/assets/img/all-icons/categary-ic.svg" alt="icon" class="asideicon">
                    <span>Category</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link border-radious-9 margin-20
                {{ Request::is('affiliate/payment') ? 'sidebar-active' : '' }}"
                  href="{{route('affiliate.payment')}}">
                    <img src="{{ asset('dealer') }}/assets/img/m3-icon/payment.svg" alt="icon" class="asideicon">
                    <span>Payments</span>
                </a>
            </li> 

            <li class="nav-item">
                <a class="nav-link border-radious-9 margin-20
                {{ Request::is('affiliate/my-withdrawals') ? 'sidebar-active' : '' }}"
                  href="{{route('affiliate.myWithdrawls')}}">
                    <img src="{{ asset('dealer') }}/assets/img/m3-icon/withdrawal.svg" alt="icon" class="asideicon">
                    <span>My Withdrawals</span>
                </a>
            </li> 

            <!--

            <li class="nav-item">
                <a class="nav-link border-radious-9 margin-20" href="">
                    <img src="{{ asset('dealer') }}/assets/img/m3-icon/terms.svg" alt="icon" class="asideicon">
                    <span>Terms & Condition</span>
                </a>
            </li> 
            <li class="nav-item">
                <a class="nav-link border-radious-9 margin-20" href="">
                    <img src="{{ asset('dealer') }}/assets/img/m3-icon/about.svg" alt="icon" class="asideicon">
                    <span>About Us</span>
                </a>
            </li> 
            <li class="nav-item">
                <a class="nav-link border-radious-9 margin-20" href="">
                    <img src="{{ asset('dealer') }}/assets/img/m3-icon/faq.svg" alt="icon" class="asideicon">
                    <span>FAQs</span>
                </a>
            </li>  -->
          

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