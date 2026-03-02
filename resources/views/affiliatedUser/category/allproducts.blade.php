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

            @foreach($products as $key=>$product)
            <div class="col-lg-3 col-md-6">
                <div class="sub-category-pnl mb-3 pb-1">
                    <div class="sub-grid position-relative">
                        <figure>
                            <img src="{{$product['product_variants'][0]['variant_image'][0]}}" alt="image"
                                class="img-fluid">
                        </figure>
                        <div class="af-commission">

                            {{$product['affiliated_commission']}}%

                            Commission</div>
                    </div>
                    <div class="af-content p-2">
                        <div class="sub-title"> {{ substr($product['product_name_en'],0,20)}}</div>
                        <div class="af-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                            <span>(123K)</span>
                        </div>
                        <div class="af-price"> {{$product['product_variants'][0]['final_price']}} KD</div>
                        <div class="af-price-line"><span class="text-decoration-line-through">
                                {{$product['product_variants'][0]['actual_price']}} KD </span>

                            {{$product['product_variants'][0]['discount_value']}}

                            @if($product['product_variants'][0]['discount_type']=='1')
                            %
                            @else
                            Off
                            @endif

                        </div>
                        <div class="text-center mt-2">
                            <button type="button" class="btn btn-success w-100 lh-sm get-link-btn"
                                data-bs-toggle="modal" data-bs-target="#getlink" data-product="{{$product['id']}}">Get
                                Link</button>
                        </div>
                    </div>
                </div>
            </div>

            @endforeach

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

            <form id="AddproductToLink" action="{{route('affiliate.add_to_my_products')}}" method="post">
                <meta name="csrf-token" content="{{ csrf_token() }}">

                <div class="modal-body">
                    <div class="search-field-2 d-flex align-items-center py-4 gap-3">
                        <div class="from-group position-relative w-75">
                            <input type="search" class="form-control py-3" id="generate_url_link"
                                placeholder="Enter URL" readonly>

                            <input type="hidden" class="form-control py-3" name="product_id" id="product_id">
                        </div>
                        <button type="button" class="btn btn-success" id="copyLinkBtn">Copy link</button>
                    </div>
                    <div class="text-center mt-2">
                        <button type="submit" class="btn btn-success w-100 lh-2">Add product</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script src="{{ asset('/dealer') }}/assets/custom-file/js/jquery.min.js"></script>

<script>
$(document).on('click', '.get-link-btn', function() {

    let productId = $(this).data('product');

    $.ajax({
        url: "{{ route('affiliate.generateProductLink') }}",
        type: "GET",
        data: {
            product_id: productId
        },
        beforeSend: function() {
            // $('#getlink .modal-body').html('<p>Loading...</p>');
        },
        success: function(response) {

            $('#generate_url_link').val(response);
            $('#product_id').val(productId);

        },
        error: function() {
            alert('Something went wrong');
        }
    });

});

$(document).on('click', '#copyLinkBtn', function() {

    let copyText = $('#generate_url_link').val();

    navigator.clipboard.writeText(copyText).then(function() {
        toastr.success("Link copied successfully!");
    }).catch(function() {
        toastr.failed("Failed to copy link");
    });

});



$(document).on('submit', '#AddproductToLink', function(e) {

    e.preventDefault(); // stop normal form submit

    let form = $(this);
    let formData = form.serialize();

    $.ajax({
        url: form.attr('action'),
        type: "POST",
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            // form.find('button[type="submit"]').prop('disabled', true).text('Adding...');
        },
        success: function(response) {

            console.log(response.status);

            if (response.status == "success") {
                toastr.success(response.message);

            }

            if (response.status == "error") {
                toastr.error(response.message);
            }

            // window.setTimeout(function() {
            //     location.reload();
            // }, 2000);

            // Optional success message
            // alert('Product added successfully!');

            // 🔥 Refresh page
            // location.reload();

        },
        error: function(xhr) {

            alert('Something went wrong');

            form.find('button[type="submit"]').prop('disabled', false).text('Add product');
        }
    });

});
</script>



@include('affiliatedUser.layout.footer')