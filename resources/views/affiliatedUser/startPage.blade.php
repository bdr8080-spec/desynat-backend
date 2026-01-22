<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>desynat seller</title>
    <!-- Favicons -->
    <link href="{{ asset('/dealer') }}/assets/img/desynat_fav_ic.svg" rel="icon">
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/css/intlTelInput.css" />
    <link href="{{ asset('/dealer') }}/assets/custom-file/css/bootstrap.min.css" rel="stylesheet">
    <!-- Main CSS File -->
    <link href="{{ asset('/dealer') }}/assets/custom-file/css/style.css" rel="stylesheet">
</head>

<body>

    <div class="login-header">
        <div class="des-logo">
            <a href="#"><img src="{{ asset('/dealer') }}/assets/img/desynat-logo.svg" alt="image"
                    class="img-fluid logo-login"> </a>
        </div>
        <div class="des-language">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <img src="{{ asset('/dealer') }}/assets/img/global.svg" class="img-fluid" /> EN
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><span>AR</span> Arabic</a></li>
                    <li><a class="dropdown-item" href="#"><span>EN</span> English</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="login-wapper">
        <div class="container-fluid p-0">

            <div class="" style="margin-top:15%">
                <div class="row g-0">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-md-6 text-center" style="padding:50px;border:1px solid grey">
                                <a href="{{route('affiliate.affiliate_login')}}" class="btn ">Existance User </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- New User  -->
                <div class="row g-0">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-md-6 text-center" style="padding:50px;border:1px solid grey">
                                <a href="{{route('affiliate.affiliate_signup')}}" class="btn ">New User </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


</body>


<!-- Vendor JS Files -->
<script src="{{ asset('/dealer') }}/assets/custom-file/js/jquery.min.js"></script>
<script src="{{ asset('/dealer') }}/assets/custom-file/js/bootstrap.bundle.min.js"></script>

<!--Main JS File -->
<script src="{{ asset('/dealer') }}/assets/custom-file/js/main.js"></script>

<script>
$(".toggle-password").click(function() {
    $(this).toggleClass("bi-eye bi-eye-slash");
    input = $(this).parent().find("input");
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});
</script>

<script>
function showPreview(e, i) {
    const input = e.target;
    const img = document.getElementById(`preview-${i}`);
    const rm = document.getElementById(`remove-${i}`);
    const label = document.getElementById(`label-${i}`);

    if (!input.files.length) return;

    img.src = URL.createObjectURL(input.files[0]);
    img.style.display = rm.style.display = "block";
    label.style.display = "none";

    // 👇 allow same image re-upload
    input.value = "";
}

function removeImg(i) {
    const img = document.getElementById(`preview-${i}`);
    const rm = document.getElementById(`remove-${i}`);
    const label = document.getElementById(`label-${i}`);

    img.src = "";
    img.style.display = rm.style.display = "none";
    label.style.display = "block";
}
</script>




{{-- @include('dealer.custom_code'); --}}

@include('dealer.layout.custom_code')



</html>