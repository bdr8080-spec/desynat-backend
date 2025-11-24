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

       .color-box {
        width: 40px;
        height: 40px;
        border-radius: 6px;
        cursor: pointer;
        border: 2px solid transparent;
    }
    .size-btn {
        padding: 8px 15px;
        background: #f5f5f5;
        border: 1px solid #ccc;
        border-radius: 6px;
        cursor: pointer;
    }
    .size-btn.active {
        background: #000;
        color: #fff;
    }

</style>

<section class="section dashboard container">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between">
        <div class="title24"><i class="bi bi-chevron-left"></i> Product code- {{ $product->id }}
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
                <img id="mainImage" src="{{ asset('dealer/assets/img/image33.png') }}" class="img-fluid"
                    class="img-fluid rounded main-img" alt="">
                <!-- <img src="{{ asset('user/assets/images/categorie1.png') }}" class="img-fluid" /> -->
            </div>

            <div class="d-flex justify-content-center gap-2 mt-3">

                <img src="{{ asset('dealer/assets/img/image33.png') }}" class="thumb-img"
                    onclick="changeImage(this.src)">

                <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" class="thumb-img"
                    onclick="changeImage(this.src)">

                <img src="{{ asset('dealer/assets/img/image33.png') }}" class="thumb-img"
                    onclick="changeImage(this.src)">

                <img src="{{ asset('dealer/assets/img/image33.png') }}" class="thumb-img"
                    onclick="changeImage(this.src)">

            </div>

        </div>
        <div class="col-lg-6 col-xxl-6">
            <div style="float-right justify-content-end" class=" float-end justify-content-end">
                <a href="{{ route('seller.edit-product',$product->id) }}">
                    <img src="{{ asset('dealer/assets/img/edit2.png') }}" class=""></a>
                <img src="{{ asset('dealer/assets/img/delete2.png') }}" class="">

            </div>
            <h4 class="fw-semibold">{{ $product->brand->name_english }}</h4>
            <p class="text-muted mb-1">{{ $product->product_name_en }}</p>
            <p class="text-muted">{{ $product->category->name }}</p>

            <div class="d-flex align-items-center mb-2">
                <span class="text-warning fs-5">★★★★☆</span>
                <span class="ms-2 text-muted">(1K)</span>
            </div>

            
            <p class="text-success small">inclusive of all taxes</p>

            <hr>

            <h6 class="fw-semibold mb-2">More Color</h6>
           

<div class="d-flex gap-2 mb-4">
    @php $count=1;
    $countSize=1;
    @endphp

    @foreach ($product['ColorPriceCombination'] as $key => $item)
    <div class="color-box"
         style="background:{{ $key }}"
         data-color="color{{ $count }}">
    </div>
        @php $count++; @endphp
        @endforeach
</div>

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="fw-semibold">Available Size</h6>
        <a href="#" class="text-brown fw-semibold text-decoration-none">Size Guide</a>
    </div>

    @php $countSize = 1; @endphp
@foreach ($product['ColorPriceCombination'] as $key => $item)

<div id="color{{ $countSize }}" class="color-section" 
     @if($countSize != 1) style="display:none;" @endif>

    {{-- PRICE BLOCK --}}
    <div class="d-flex align-items-center mb-1">
        <h4 class="fw-bold text-dark me-2">{{ $item[0]['final_price'] }} KD</h4>
        <del class="text-muted me-2">{{ $item[0]['actual_price'] }} KD</del>
        <span class="text-danger fw-semibold">
            {{ $item[0]['discount_value'] }} {{ $item[0]['discount_type']=='1'? '%' : 'off' }}
        </span>
    </div>

    {{-- SIZE BUTTONS --}}
    <div class="d-flex gap-2 mb-4">
        @foreach ($item as $key1 => $item1)
        <button class="size-btn" data-size="size{{ $countSize }}-{{ $key1 }}">
            {{ $item1['size'] }}
        </button>
        @endforeach
    </div>

    {{-- SIZE DETAILS --}}
    @foreach ($item as $key1 => $item1)
    <div id="size{{ $countSize }}-{{ $key1 }}" class="size-section" 
         style="display:none;">

           @if($product->category_id==2)

            <div class="p-4 rounded-4 shadow-sm" style="background:#fff;" >
                <div class="row mb-2">
                    <div class="col-6">Bust</div>
                    <div class="col-6 text-end">{{$item1['bust']}}  </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">Waist</div>
                    <div class="col-6 text-end">{{$item1['waist']}} </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">Hip</div>
                    <div class="col-6 text-end">{{$item1['hip']}} </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">Shoulder</div>
                    <div class="col-6 text-end">{{$item1['shoulder']}} </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">Sleeve length</div>
                    <div class="col-6 text-end">{{$item1['sleeve_length']}} </div>
                </div>
                <div class="row">
                    <div class="col-6">Length</div>
                    <div class="col-6 text-end">{{$item1['length']}} </div>
                </div>
            </div>
            @endif
            
        <div class="p-4 rounded-4 shadow-sm bg-white">
            <div class="row mb-2">
                <div class="col-6">Total Stocks</div>
                <div class="col-6 text-end">{{ $item1['total_stock'] }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-6">SKU</div>
                <div class="col-6 text-end">{{ $item1['sku'] }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-6">SKU Threshold</div>
                <div class="col-6 text-end">{{ $item1['sku_threshold_value'] }}</div>
            </div>
        </div>

    </div>
    @endforeach

</div>

@php $countSize++; @endphp
@endforeach

    </div>

    </div>
    <div class="row">
        <div class="col-lg-6 col-xxl-6">

            <div class="container my-4">
                <div class="desc-box p-4 rounded-4">
                    <h5 class="fw-semibold">Description</h5>
                    <p class="mt-3 text-muted">
                        {{ $product->description_en }}
                    </p>
                    <h5 class="fw-semibold mt-4">Specification</h5>
                    <ul class="mt-3 spec-list">

                    @foreach ($product->product_specifications as $item)

                        <li>{{$item->name_en}} - {{$item->feature_en}}</li>
                        
                        @endforeach

                        </ul>
                </div>
            </div>
            <div class="p-4 rounded-4 shadow-sm" style="background:#fff;">
                <div class="row mb-2">
                    <div class="col-6">Return allowed ?
                    </div>
                    <div class="col-6 text-end">@if($product->return_days==1) Yes @else No @endif </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">Exchange allowed ?
                    </div>
                    <div class="col-6 text-end">@if($product->product_exchangable==1) Yes @else No @endif </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">Review & ratings allowed ?
                    </div>
                <div class="col-6 text-end">@if($product->review_rating==1) Yes @else No @endif </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">Is it an Affiliated Product?
                    </div>
                <div class="col-6 text-end">@if($product->affiliated_product==1) Yes @else No @endif </div>
             
                </div>
                <div class="row mb-2">
                    <div class="col-6">Is this a Customized product?
                    </div>
                <div class="col-6 text-end">@if($product->customized_product==1) Yes @else No @endif </div>
             
                </div>
                <div class="row">
                    <div class="col-6">Ready to ship?
                    </div>
                       <div class="col-6 text-end">@if($product->ready_to_ship==1) Yes @else No @endif </div>
                </div>
                <div class="row">
                    <div class="col-6">Cash on delivery allowed?

                    </div>
                       <div class="col-6 text-end">@if($product->cash_on_delivery==1) Yes @else No @endif </div>
             
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

    <script>
document.addEventListener("DOMContentLoaded", function () {

    // ----------------------------
    // COLOR TAB SWITCHING
    // ----------------------------
    document.querySelectorAll(".color-box").forEach(box => {
        box.addEventListener("click", function () {

            let colorId = this.dataset.color;

            // Hide all color sections
            document.querySelectorAll(".color-section").forEach(sec => sec.style.display = "none");

            // Show selected one
            document.getElementById(colorId).style.display = "block";

            // Remove highlight from all colors
            document.querySelectorAll(".color-box").forEach(b => b.style.borderColor = "transparent");

            // Highlight selected color
            this.style.borderColor = "gold";
        });
    });

    // ----------------------------
    // SIZE TAB SWITCHING
    // ----------------------------
    document.addEventListener("click", function (e) {

        if (!e.target.classList.contains("size-btn")) return;

        let sizeId = e.target.dataset.size;
        let parentColor = e.target.closest(".color-section");

        // Hide all size sections inside same color
        parentColor.querySelectorAll(".size-section").forEach(sec => sec.style.display = "none");

        // Show selected size section
        document.getElementById(sizeId).style.display = "block";

        // Remove active class from sizes of this color
        parentColor.querySelectorAll(".size-btn").forEach(b => b.classList.remove("active"));

        // highlight selected size
        e.target.classList.add("active");
    });

});
</script>

