<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Desynat</title>
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet" />

    <link rel="icon" type="image/x-icon" href="{{asset('admin/image/favicon.svg')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <link href="{{ asset('admin/css/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <link href="{{ asset('admin/css/bootstrap.css') }}" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>
<style>
#content-wrapper {
    display: flex;
    flex-direction: row;
    /* height: 100vh;  */
}

#accordionSidebar {
    margin-top: 75px;
    /* Ensures no extra space at the top */
    padding-top: 0;
    /* Ensures no extra padding at the top */
    /* height: 100%; */
    /* Ensures sidebar takes full height */
    padding: 20px 5px;
}

#content {
    flex-grow: 1;
    /* Allows content to fill the remaining space */
}
</style>

<style>

        iframe#\:1\.container {
    visibility: hidden !important;
}

/* Hide the Google Translate tooltip */
.goog-te-banner-frame.skiptranslate,
.goog-tooltip,
.goog-tooltip:hover,
.goog-tooltip-vertical {
    display: none !important;
}

/* Hide the feedback popup on selected text */
#goog-gt-tt {
    display: none !important;
}
    </style>

    <style>
  body {
    visibility: hidden;
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