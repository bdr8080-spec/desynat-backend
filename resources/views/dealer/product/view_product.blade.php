@include('dealer.layout.header')

<style>
.main-img {
    width: 100%;
    height: auto;
    border-radius: 15px;
}

.thumb-img {
    width: 65px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
    border: 2px solid transparent;
    transition: 0.3s;
}

.thumb-img:hover {
    border-color: #7c7c7c;
}



.color-box {
    width: 38px;
    height: 38px;
    border-radius: 8px;
    cursor: pointer;
    border: 2px solid transparent;
}

.size-btn {
    padding: 6px 16px;
    border: 1px solid #ddd;
    background: #fff;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 500;
}

.size-btn:hover {
    border-color: #000;
}

.size-btn.disabled {
    opacity: 0.4;
    pointer-events: none;
}

.text-brown {
    color: #8a4f2d;
}



.desc-box {

    border: 1px solid #e5e5e5;

    background: #fff;

}

.spec-list li {

    margin-bottom: 10px;

    font-size: 15px;

}
</style>

<section class="section dashboard container">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between">
        <div class="title24"><i class="bi bi-chevron-left"></i> Product code- 2103
        </div>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault">
            <label class="form-check-label" for="switchCheckDefault"></label>
        </div>
    </div>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="row my-4">
        <div class="col-lg-6 col-xxl-6">
            <!-- <div class="bg-header d-flex justify-content-between mt-3 align-items-center">
                <div class="title24">Store availability</div>
                <div class="d-flex gap-3">
                    <div class="buy">Busy/On</div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault">
                        <label class="form-check-label" for="switchCheckDefault"></label>
                    </div>
                </div>
            </div> -->


            <!-- Main Image -->
            <div class="main-img-container mb-3">
                <img id="mainImage" src="{{asset('dealer/assets/img/image33.png')}}" class="img-fluid"
                    class="img-fluid rounded main-img" alt="">
                <!-- <img src="{{asset('user/assets/images/categorie1.png')}}" class="img-fluid" /> -->
            </div>

            <div class="d-flex justify-content-center gap-2 mt-3">

                <img src="{{asset('dealer/assets/img/image33.png')}}" class="thumb-img" onclick="changeImage(this.src)">

                <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" class="thumb-img"
                    onclick="changeImage(this.src)">

                <img src="{{asset('dealer/assets/img/image33.png')}}" class="thumb-img" onclick="changeImage(this.src)">

                <img src="{{asset('dealer/assets/img/image33.png')}}" class="thumb-img" onclick="changeImage(this.src)">

            </div>

        </div>
        <div class="col-lg-6 col-xxl-6">

            <h4 class="fw-semibold">Levies</h4>
            <p class="text-muted mb-1">Silk Blend Heavy Sequence Work Co-Ord (Set of 3)</p>
            <p class="text-muted">Abayas (women)</p>

            <div class="d-flex align-items-center mb-2">
                <span class="text-warning fs-5">★★★★☆</span>
                <span class="ms-2 text-muted">(123K)</span>
            </div>

            <div class="d-flex align-items-center mb-1">
                <h4 class="fw-bold text-dark me-2">239 KD</h4>
                <del class="text-muted me-2">239 KD</del>
                <span class="text-danger fw-semibold">20% off</span>
            </div>
            <p class="text-success small">inclusive of all taxes</p>

            <hr>

            <h6 class="fw-semibold mb-2">More Color</h6>
            <div class="d-flex gap-2 mb-4">

                <div class="color-box border border-2 border-warning" style="background:#efe3c4"></div>
                <div class="color-box" style="background:#8ea6ff"></div>
                <div class="color-box" style="background:#c79aff"></div>
                <div class="color-box" style="background:#ff6f99"></div>

            </div>

            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="fw-semibold">Available Size</h6>
                <a href="#" class="text-brown fw-semibold text-decoration-none">Size Guide</a>
            </div>

            <div class="d-flex gap-2 mb-4">
                <button class="size-btn">S</button>
                <button class="size-btn disabled">M</button>
                <button class="size-btn">L</button>
                <button class="size-btn">XL</button>
            </div>

            <div class="p-4 rounded-4 shadow-sm" style="background:#fff;">
                <div class="row mb-2">
                    <div class="col-6">Bust</div>
                    <div class="col-6 text-end">32</div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">Waist</div>
                    <div class="col-6 text-end">32</div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">Hip</div>
                    <div class="col-6 text-end">32</div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">Shoulder</div>
                    <div class="col-6 text-end">32</div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">Sleeve length</div>
                    <div class="col-6 text-end">32</div>
                </div>
                <div class="row">
                    <div class="col-6">Length</div>
                    <div class="col-6 text-end">32</div>
                </div>
            </div>

            <div class="p-4 my-2 rounded-4 shadow-sm" style="background:#fff;">
                <div class="row mb-2">
                    <div class="col-6">Total Stocks</div>
                    <div class="col-6 text-end">32</div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">SKU</div>
                    <div class="col-6 text-end">32</div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">SKU Threshold value</div>
                    <div class="col-6 text-end">32</div>
                </div>

            </div>

        </div>

    </div>
    <div class="row">
        <div class="col-lg-6 col-xxl-6">
            <div class="container my-4">
                <div class="desc-box p-4 rounded-4">
                    <h5 class="fw-semibold">Description</h5>
                    <p class="mt-3 text-muted">
                        lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore

                        dolore magna aliqua. Ut enim ad minimdipisicing elit, sed do eiusmod tempor incididunt ut labore
                        aliqua

                        dolore magna aliqua. Ut enim ad minim aliqua.
                    </p>
                    <h5 class="fw-semibold mt-4">Specification</h5>
                    <ul class="mt-3 spec-list">
                        <li>Type 1 - Feature</li>
                        <li>Type 2 - Feature</li>
                        <li>Type 3 - Feature</li>
                    </ul>
                </div>
            </div>
            <div class="p-4 rounded-4 shadow-sm" style="background:#fff;">
                <div class="row mb-2">
                    <div class="col-6">Return allowed ?
                    </div>
                    <div class="col-6 text-end">32</div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">Exchange allowed ?
                    </div>
                    <div class="col-6 text-end">32</div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">Review & ratings allowed ?
                    </div>
                    <div class="col-6 text-end">32</div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">Is it an Affiliated Product?
                    </div>
                    <div class="col-6 text-end">32</div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">Is this a Customized product?
                    </div>
                    <div class="col-6 text-end">32</div>
                </div>
                <div class="row">
                    <div class="col-6">Ready to ship?
                    </div>
                    <div class="col-6 text-end">32</div>
                </div>
                <div class="row">
                    <div class="col-6">Cash on delivery allowed?

                    </div>
                    <div class="col-6 text-end">32</div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xxl-6">
            <div class="container my-4">
                <div class="review-box p-4 rounded-4">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png"
                                class="profile-img img-fluid" width="60" />
                            <div>
                                <h6 class="fw-semibold mb-1">Gimhana</h6>
                                <span class="text-warning fs-5">★★★★☆</span>
                            </div>
                        </div>
                        <span class="text-muted">11 Nov 2025</span>
                    </div>
                    <p class="mt-3 text-muted">
                        lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt
                        ut labore et dolore magna aliqua. Ut enim ad minimdipisicing elit, sed do eiusmod tempor
                        incididunt ut labore et dolore magna aliqua. Ut enim ad minim aliqua.
                    </p>
                    <div class="d-flex gap-3 mt-3">
                        <img src="/mnt/data/a74c7c83-76b3-4c72-a009-2b0579341435.png" class="review-img" />
                        <img src="/mnt/data/a74c7c83-76b3-4c72-a009-2b0579341435.png" class="review-img" />
                    </div>
                </div>

                <div class="review-box p-4 rounded-4">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png"
                                class="profile-img img-fluid" width="60" />
                            <div>
                                <h6 class="fw-semibold mb-1">Gimhana</h6>
                                <span class="text-warning fs-5">★★★★☆</span>
                            </div>
                        </div>
                        <span class="text-muted">11 Nov 2025</span>
                    </div>
                    <p class="mt-3 text-muted">
                        lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt
                        ut labore et dolore magna aliqua. Ut enim ad minimdipisicing elit, sed do eiusmod tempor
                        incididunt ut labore et dolore magna aliqua. Ut enim ad minim aliqua.
                    </p>
                    <div class="d-flex gap-3 mt-3">
                        <img src="/mnt/data/a74c7c83-76b3-4c72-a009-2b0579341435.png" class="review-img" />
                        <img src="/mnt/data/a74c7c83-76b3-4c72-a009-2b0579341435.png" class="review-img" />
                    </div>
                </div>

            </div>
        </div>

    </div>

    </div>
    </div>

    @include('dealer.layout.footer');

    <script>
    function changeImage(src) {
        document.getElementById("mainImage").src = src;
    }
    </script>