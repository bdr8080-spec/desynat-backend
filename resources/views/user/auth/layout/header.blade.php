<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desynat</title>
    <link href="{{ asset('user/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('user/assets/css/responsive.css') }}" rel="stylesheet" />
    <!-- <link href="assets/css/fontawesome.min.css" rel="stylesheet" /> -->
    <link rel="icon" type="image/x-icon" href="{{ asset('user/assets/images/desynat_fav_ic.svg') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/9.0.6/css/intlTelInput.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="{{ asset('user/assets/css/style.css') }}" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        .country-option:hover {
            background-color: #f8f9fa;
        }

        .country-radio:checked+img+span {
            font-weight: 600;
        }
    </style>
</head>

<body>
