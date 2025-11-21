@include('dealer.layout.header')
<style>
     <style>
        .brand-banner {
            background: url("YOUR_PUMA_IMAGE.jpg") center/contain no-repeat;
            background-color: #f3f3f3;
            height: 250px;
            width: 100%;
            border-radius: 10px;
        }

        .profile-card {
            margin-top: -60px;
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
        }

        .profile-img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
        }

        .star-rating i {
            color: gold;
        }

        .qr-box img {
            width: 70px;
        }
    </style>
</style>
<section class="section dashboard container">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between">
        <h1 class="title24"><i class="bi bi-chevron-left"></i> Profile
        </h1>
        <div class="">
            <a href="{{ route('seller.Add_product') }}">
                <img src="{{asset('dealer/assets/img/edit2.png')}}" class=""></a>
        </div>
    </div>

    <body class="bg-light">

    <div class="container mt-4">

        <div class="brand-banner"></div>

        <div class="profile-card">

            <div class="row align-items-center">
                <div class="col-md-1 col-2">
                    <img src="/mnt/data/8e95ba7b-737a-463b-aa73-d655acf349f7.jpg"
                         class="profile-img" alt="Profile">
                </div>

                <div class="col-md-8 col-7">
                    <h5 class="mb-0">Atif Aslam</h5>
                    <small class="text-muted">+948225555</small><br>
                    <small class="text-muted">atif32@gmail.com</small>

                    <div class="star-rating mt-1">
                        ⭐⭐⭐⭐⭐ (123)
                    </div>
                </div>

                <div class="col-md-3 col-3 text-end qr-box">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=https://example.com" alt="QR">
                    <div class="mt-1 small">Share</div>
                </div>
            </div>

            <hr>

            <h6 class="fw-bold">Puma</h6>
            <small class="text-muted">+948225555</small><br>
            <small class="text-muted">atif32@gmail.com</small>

            <p class="mt-2 mb-0">
                C 19, Sector 63, Blue diamond road, Kuwait <br>
                Lorem ipsum dolor sit amet consectetur, un pretium ut lacus du lacinia amet.
                Aliquam eu eget a suspendisse tellus cursus.
            </p>

        </div>
    </div>

</body>
</section>