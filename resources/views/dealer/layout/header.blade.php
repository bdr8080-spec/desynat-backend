<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>desynat seller</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Favicons -->
    <link href="{{ asset('dealer') }}/assets/img/desynat_fav_ic.svg" rel="icon">
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="{{ asset('dealer') }}/assets/custom-file/css/bootstrap.min.css" rel="stylesheet">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="{{ asset('dealer') }}/assets/custom-file/css/style.css" rel="stylesheet">
    <link href="{{ asset('dealer') }}/assets/custom-file/css/custom.css" rel="stylesheet">
    <link href="{{ asset('dealer') }}/assets/custom-file/table-lib/table-style.css" rel="stylesheet">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- jQuery (required by Toastr) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>




</head>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center">
            <a href="{{ route('seller.dashboard') }}" class="logo">
                <img src="{{ asset('dealer') }}/assets/img/desynat-logo.svg" alt="image" class="img-fluid">
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <img src="{{ asset('dealer') }}/assets/img/chat.svg" alt="icon" class="bell-icon">
                        <!-- <span class="badge bg-success badge-number">3</span> -->
                    </a>
                    <!-- <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                        <li class="dropdown-header">
                            You have 3 new messages
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                    </ul> -->
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <img src="{{ asset('dealer') }}/assets/img/bell.svg" alt="icon" class="bell-icon">
                        <!-- <span class="badge bg-primary badge-number">4</span> -->
                    </a>

                    <!-- <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            You have 4 new notifications
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                    </ul> -->
                </li>


                <!-- End Messages Nav -->

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown">
                        <img src="{{ asset('dealer') }}/assets/img/profile-img.jpg" alt="Profile"
                            class="rounded-circle">
                        <!-- <span class="d-none d-md-block dropdown-toggle ps-2">Seller</span> -->
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <!-- <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li> -->
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('seller.logout') }}">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <div class="des-language">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <img src="{{ asset('dealer') }}/assets/img/global.svg" class="img-fluid" /> EN
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"><span>AR</span> Arabic</a></li>
                                <li><a class="dropdown-item" href="#"><span>EN</span> English</a></li>
                            </ul>
                        </div>
                    </div>
                </li>

            </ul>


        </nav>

    </header>

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link border-radious-9 margin-20  {{ Request::is('seller/dashboard') ? 'sidebar-active' : '' }}"
                    href="{{ route('seller.dashboard') }}">
                    <img src="{{ asset('dealer') }}/assets/img/all-icons/dashboard.svg" alt="icon"
                        class="asideicon">
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link border-radious-9 margin-20 {{ Request::is('seller/products') ? 'sidebar-active' : '' }}"
                    href="{{ route('seller.products') }}">
                    <img src="{{ asset('dealer') }}/assets/img/all-icons/product.svg" alt="icon"
                        class="asideicon">
                    <span>Product Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link border-radious-9 margin-20 {{ Request::is('seller/Inventory-Management') ? 'sidebar-active' : '' }}"
                    href="{{ route('seller.Inventory_Management') }}">
                    <img src="{{ asset('dealer') }}/assets/img/all-icons/inventory.svg" alt="icon"
                        class="asideicon">
                    <span>Inventory Management</span>
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


    <main id="main" class="main">
