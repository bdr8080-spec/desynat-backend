@include('affiliatedUser.layout.header')

<section class="section dashboard">
    <div class="d-flex justify-content-between mt-4 mb-5">
        <a href="/category" class="title24 alink"> 
            <i class="bi bi-chevron-left"></i> My Product
        </a>
    </div>
    <div class="search-field d-flex align-items-center mb-4">
        <div class="from-group position-relative w-100">
            <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search" class="search-icon2">
            <input type="search" class="form-control py-3" placeholder="Search">
        </div>
        <button type="button" class="btn btn-success searchlin">Search</button>
    </div>
    
    <div class="tabs-panel py-3">
        <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active w-100" id="pills-allproduct-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-allproduct" type="button" role="tab" aria-controls="pills-allproduct"
                    aria-selected="true">All  </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link w-100" id="pills-mentab-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-mentab" type="button" role="tab" aria-controls="pills-mentab"
                    aria-selected="false"> Men</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link w-100" id="pills-womentab-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-womentab" type="button" role="tab" aria-controls="pills-womentab"
                    aria-selected="false"> Women</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link w-100" id="pills-kidstab-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-kidstab" type="button" role="tab" aria-controls="pills-kidstab"
                    aria-selected="false"> Kids </button>
            </li>

        </ul>
    </div>


    <div class="tab-body-wapper">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-allproduct" role="tabpanel"
                aria-labelledby="pills-allproduct-tab" tabindex="0">

                <div class="personl-wapper">
                    

                </div>
            </div>

            <div class="tab-pane fade" id="pills-mentab" role="tabpanel" aria-labelledby="pills-mentab-tab"
                tabindex="0">


            </div>

            <div class="tab-pane fade" id="pills-womentab" role="tabpanel" aria-labelledby="pills-womentab-tab" tabindex="0">

            </div>

            <div class="tab-pane fade" id="pills-kidstab" role="tabpanel" aria-labelledby="pills-kidstab-tab" tabindex="0">

            </div>

        </div>
    </div>



    <!-- <div class="allproduct-wapper pt-5">

        <div class="row">
            <div class="col-lg-3">
                <div class="sub-category-pnl mb-3 pb-1">
                    <div class="sub-grid position-relative">
                        <figure>
                            <img src="{{ asset('dealer') }}/assets/img/t-shirt.jpg" alt="image"
                                class="img-fluid">
                        </figure>
                        <div class="af-commission">5% Commission</div>
                    </div>
                    <div class="af-content p-2">
                        <div class="sub-title">3pcs Set (by Abaya)</div>
                        <div class="af-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                                <span>(123K)</span>
                        </div>
                        <div class="af-price">239 KD</div>
                        <div class="af-price-line"><span class="text-decoration-line-through">239 KD </span>20% Off</div>
                        <div class="text-center mt-2">
                             <button type="button" class="btn btn-success w-100 lh-sm" data-bs-toggle="modal" data-bs-target="#getlink">Get Link</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="sub-category-pnl mb-3 pb-1">
                    <div class="sub-grid position-relative">
                        <figure>
                            <img src="{{ asset('dealer') }}/assets/img/t-shirt-1.jpg" alt="image"
                                class="img-fluid">
                        </figure>
                        <div class="af-commission">5% Commission</div>
                    </div>
                    <div class="af-content p-2">
                        <div class="sub-title">3pcs Set (by Abaya)</div>
                        <div class="af-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                                <span>(123K)</span>
                        </div>
                        <div class="af-price">239 KD</div>
                        <div class="af-price-line"><span class="text-decoration-line-through">239 KD </span>20% Off</div>
                        <div class="text-center mt-2">
                             <button type="button" class="btn btn-success w-100 lh-sm" data-bs-toggle="modal" data-bs-target="#getlink">Get Link</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="sub-category-pnl mb-3 pb-1">
                    <div class="sub-grid position-relative">
                        <figure>
                            <img src="{{ asset('dealer') }}/assets/img/t-shirt.jpg" alt="image"
                                class="img-fluid">
                        </figure>
                        <div class="af-commission">5% Commission</div>
                    </div>
                    <div class="af-content p-2">
                        <div class="sub-title">3pcs Set (by Abaya)</div>
                        <div class="af-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                                <span>(123K)</span>
                        </div>
                        <div class="af-price">239 KD</div>
                        <div class="af-price-line"><span class="text-decoration-line-through">239 KD </span>20% Off</div>
                        <div class="text-center mt-2">
                             <button type="button" class="btn btn-success w-100 lh-sm" data-bs-toggle="modal" data-bs-target="#getlink">Get Link</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="sub-category-pnl mb-3 pb-1">
                    <div class="sub-grid position-relative">
                        <figure>
                            <img src="{{ asset('dealer') }}/assets/img/t-shirt-1.jpg" alt="image"
                                class="img-fluid">
                        </figure>
                        <div class="af-commission">5% Commission</div>
                    </div>
                    <div class="af-content p-2">
                        <div class="sub-title">3pcs Set (by Abaya)</div>
                        <div class="af-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                                <span>(123K)</span>
                        </div>
                        <div class="af-price">239 KD</div>
                        <div class="af-price-line"><span class="text-decoration-line-through">239 KD </span>20% Off</div>
                        <div class="text-center mt-2">
                             <button type="button" class="btn btn-success w-100 lh-sm" data-bs-toggle="modal" data-bs-target="#getlink">Get Link</button>
                        </div>
                    </div>
                </div>
            </div>
            





        </div>
    </div> -->

    

   

</section>





@include('affiliatedUser.layout.footer');


