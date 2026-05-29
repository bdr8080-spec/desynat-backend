@extends('admin.layout.app')
@section('content')


<div class="inner-content management">

    <div class="d-flex gap-2 align-items-center">
        <a href="#"><i class="bi bi-chevron-left"></i></a>
        <h2 class="h2">Seller Information</h2>
    </div>

    <div class="brand-banner">
        <img src="https://d79swovq1y56s.cloudfront.net/uploads/lAHVxEhGIV.png" alt="Profile" class="img-fluid">
    </div>

    <div class="mb-5 viewSeller">
        <div class="profile-card">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="user_view">
                        <div class="position-relative">
                            <div class="addprofile">
                                <img src="https://d79swovq1y56s.cloudfront.net/profile/1777366604.jpg"
                                    class="img-fluid">
                            </div>
                        </div>
                        <div class="user_content">
                            <h5 class="mb-0">Joh shop</h5>
                            <small class="text-muted">+965 9767876545</small><br>
                            <small class="text-muted">Testing@gmail.com</small>
                            <div class="star-rating mt-1">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                                <span class="text-black">(123K)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <h6 class="fw-bold"> desynat store </h6>
                <small class="text-muted"> +965 84884848484 </small><br>
                <small class="text-muted"> testing@gmail.com</small>
                <div class="mt-2 mb-0"> 33MF+99Q, Al Ahmadi, Kuwait </div>
                <div class="mt-2 mb-0"> Bdbdbd </div>
            </div>
        </div>

        <div class="py-2">
            <h5 class="h2">Total Orders(0)</h5>
        </div>
        <div class="order-total">
            <div class="row mt-0">
                <div class="col-lg-6 col-md-6">
                    <div class="profile-card pnl-flex mb-3">
                        <div class="dash-content">
                            <h5>Completed  </h5>
                            <div class="title30">0</div>
                        </div>
                        <div class="dash-circle">
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="profile-card pnl-flex mb-3">
                        <div class="dash-content">
                            <h5>Cancelled  </h5>
                            <div class="title30">0</div>
                        </div>
                        <div class="dash-circle">
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="profile-card pnl-flex">
                        <div class="dash-content">
                            <h5>My Earnings  </h5>
                            <div class="title30">0 KD</div>
                        </div>
                        <div class="dash-circle">
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="profile-card pnl-flex">
                        <div class="dash-content">
                            <h5>Commission  </h5>
                            <div class="title30">0</div>
                        </div>
                        <div class="dash-circle">
                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>


        <div class="py-3">
            <h5 class="h2">Heighlights</h5>
        </div>

        <div class="product-row d-flex align-items-center gap-2 profile-card">
            <div class="product-item">
                <img src="https://d79swovq1y56s.cloudfront.net/uploads/eP5qyMywkJ.jpg" class="product-circle">
                <small>shoes</small>
            </div>
            <div class="product-item">
                <img src="https://d79swovq1y56s.cloudfront.net/uploads/eP5qyMywkJ.jpg" class="product-circle">
                <small>shoes</small>
            </div>

        </div>


        <div class="reels-wrapper mt-4 pb-5">
            <div class="py-3">
                <h5 class="h2">Reel</h5>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="reels-grid">
                        <div class="reel-card">
                            <img src="#" alt="image" class="img-fluid">
                        </div>
                    </div>

                    <div class="text-center">
                        <button class="deleteStoryBtn"> Delete </button>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>






@endsection
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>