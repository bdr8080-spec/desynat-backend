@include('affiliatedUser.layout.header')

<section class="section dashboard">
    <div class="d-flex justify-content-between mt-4 mb-5">
        <a href="/category" class="title24 alink"> 
            <i class="bi bi-chevron-left"></i> All Products
        </a>
    </div>
    <div class="search-field d-flex align-items-center">
        <div class="from-group position-relative w-100">
            <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search" class="search-icon2">
            <input type="search" class="form-control py-3" placeholder="Search">
        </div>
        <button type="button" class="btn btn-success searchlin">Search</button>
    </div>
    
    <div class="allproduct-wapper pt-5">
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
    </div>

    

   

</section>


<!-- Get Link Modal -->
<div class="modal fade" id="getlink" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered w-75">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Affiliate link</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <div class="search-field-2 d-flex align-items-center py-4 gap-3">
                <div class="from-group position-relative w-75">
                    <input type="search" class="form-control py-3" placeholder="Enter URL">
                </div>
                <button type="button" class="btn btn-success">Copy link</button>
            </div>
            <div class="text-center mt-2">
                <button type="button" class="btn btn-success w-100 lh-2"> Submit </button>
            </div>

     
      </div>
    </div>
  </div>
</div>



@include('affiliatedUser.layout.footer')


