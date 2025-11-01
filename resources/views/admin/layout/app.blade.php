<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Desynat</title>
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/css/bootstrap.css') }}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <link href="{{ asset('admin/css/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<style>
   #content-wrapper {
    display: flex;
    flex-direction: row;
    /* height: 100vh;  */
}

#accordionSidebar {
    margin-top: 75px; /* Ensures no extra space at the top */
    padding-top: 0; /* Ensures no extra padding at the top */
    height: 100%; /* Ensures sidebar takes full height */
}

#content {
    flex-grow: 1; /* Allows content to fill the remaining space */
}
</style>

<body id="page-top">

    <!-- HEADER SECTION -->
    @include('admin.layout.header')

    <!-- MAIN WRAPPER (Including Sidebar) -->
        <div id="wrapper">

            <!-- SIDEBAR SECTION -->
            @include('admin.layout.sidebar')

            <!-- CONTENT SECTION -->
            <div id="content-wrapper" class="d-flex flex-column position-relative">
                <div id="content" class="">

                    <!-- Page Content goes here -->
                    @yield('content')

                </div>
            </div>

        </div>

    <!-- FOOTER SECTION -->
    @include('admin.layout.footer')
</body>

</html>
