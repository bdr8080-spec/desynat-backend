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
    object-fit: fill;
    border-radius: 8px;
    cursor: pointer;
    border: 2px solid #ccc;
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

a:hover {
    color: #8a4f2d;
}

.size-btn {
    width: 32px;
    height: 32px;
    padding: 2px;
    background: #f5f5f5;
    border: 1px solid #DFBF8F;
    border-radius: 6px;
    cursor: pointer;
}

.size-btn.active {
    background: #fff;
    color: #000;
    border: 1px solid #DFBF8F;

}

.color-box {
    width: 32px;
    height: 32px;
    /* border-radius: 50%; */
    border: 2px solid transparent;
    cursor: pointer;
    position: relative;
}

.color-box.active {
    border: 1px solid #DFBF8F;
    box-shadow: 0 0 0 3px #fff inset;
}

p,
span {
    font-size: 14px;
}

.main-img-container {
    height: 60vh;
    background: #f7f7f7;
    border-radius: 16px;
}

.main-img-container img {
    width: 100%;
    HEIGHT: 100%;
    OBJECT-FIT: contain;
    border-radius: 12px;
}

/* .{
    position: absolute;
    bottom: 1.3rem;
    margin: auto;
    justify-content: center;
    text-align: center;
} */
.modal-footer,
.modal-header {
    border: 0;
}

.cstm-pd {
    padding: auto 5px;
}
</style>

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between mb-4">
        <div class="title24"> <a href="{{route('seller.products')}}" style="color:rgb(57, 55, 55)"><i
                    class="bi bi-chevron-left"></i> Product code- {{ $product->id }}
            </a> </div>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault"
                @if($product->product_active_status==1) checked @endif rel="{{ $product->id }}">
            <label class="form-check-label" for="switchCheckDefault"></label>
        </div>
    </div>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="row my-3">

        <div id="images_show-box" class="col-lg-5 col-xxl-5 position-relative" style="position:relative;"></div>

        <div class="col-lg-7 col-xxl-7">
            <div style="float-right justify-content-end" class=" float-end justify-content-end">
                <a href="#" data-bs-toggle="modal" data-bs-target="#editModals" onclick="checkInventory()">
                    <img src="{{ asset('dealer/assets/img/edit2.png') }}" height="40px" width="40px">
                </a>

            </div>
            <h6 class="fw-semibold">
                @if (strtolower($product->brand->name_english) == 'other')
                {{ $product->other_en }}
                @else
                {{ $product->brand->name_english }}
                @endif

            </h6>
            <p class="text-muted mb-1">{{ $product->product_name_en }} ({{ $product->category->name }}) </p>

            <div class="d-flex align-items-center mb-2">
                <span class="text-warning fs-5">★★★★☆</span>
                <span class="ms-2 text-muted">(1K)</span>
            </div>

            <div id="price-box" class="mb-0"></div>

            <p class="text-success small">inclusive of all taxes</p>

            <hr class="mt-0">

            <h6 class="fw-semibold mb-2">More Color</h6>

            <div class="d-flex gap-2 mb-2">
                @php $count=1;
                $countSize=1;
                $i = 0;
                @endphp

                @foreach ($product['ColorPriceCombination'] as $key => $item)

                <div class="color-box {{ $i == 0 ? 'active' : '' }}" id="color-list" style="background:{{ $key }}"
                    data-color="{{ $item[0]['color_id'] }}">
                </div>
                @php $count++;
                $i++;
                @endphp
                @endforeach
            </div>

            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="fw-semibold">Available Size</h6>
                <a href="#" class="text-brown fw-semibold text-decoration-none" data-bs-toggle="modal"
                    data-bs-target="#sizeGuideModal">Size Guide</a>

            </div>

            <div id="size-list"></div>

            <div id="variation-box" class="cstm-pd rounded-4 my-3"></div>

        </div>

    </div>

    </div>
    </div>

    <!-- Size Guide Modal -->
    <div class="modal fade" id="sizeGuideModal" tabindex="-1" aria-labelledby="sizeGuideModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sizeGuideModalLabel">Size Guide</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="position: relative">
                    <!-- Add your size guide content here -->
                    <p>Here you can show image of size guide:</p>

                    <img src="{{$product->upload_size_chart}}" style="width:100%">

                </div>

            </div>
        </div>
    </div>

    <!-- Edits Modal -->

    <div class="modal fade" id="editModals" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="editinventory" action="{{ route('seller.update_inventory_stock')}}" method="post">
                @csrf

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Inventory</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="inventory_product_id" value="{{ $product->id }}"
                            id="inventory_product_id">
                        <input type="hidden" name="variation_id" value="" id="inventory_variation_id">

                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="sub-form">
                                    <div class="label-flex">
                                        <label>Total Stocks</label>
                                    </div>
                                    <input type="text" class="form-control" placeholder="" id="Inventory_stock"
                                        name="stock_quantity" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                    <p class="text-danger" id="error-stock_quantity"></p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="sub-form">
                                    <div class="label-flex">
                                        <label>SKU</label>
                                    </div>
                                    <input type="text" class="form-control" placeholder="" id="Inventory_sku" name="sku"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');">

                                    <p class="text-danger" id="error-sku"></p>
                                </div>
                            </div>

                        </div>

                        <div class="dashboard-button mt-4">
                            <button type="submit" class="btn add-fillbtn w-100">Save Changes</button>
                        </div>

                    </div>

                </div>
            </form>

        </div>
    </div>



    @include('dealer.layout.footer');

    <script>
    function changeImage(src) {
        document.getElementById("mainImage").src = src;
    }


    // When user clicks a color
    $(document).on('click', '.color-box', function() {

        $('.color-box').removeClass('active');
        $(this).addClass('active');

        loadSizes($(this).data('color'));

    });

    // Load sizes on first color automatically when page loads
    $(document).ready(function() {
        let firstColor = $('.color-box').first().data('color');
        loadSizes(firstColor);

    });

    // Function to load sizes using AJAX
    function loadSizes(color) {
        let product_id = "{{ $product->id }}";

        $.ajax({
            url: "{{ route('get.sizes.by.color') }}",
            type: "GET",
            data: {
                product_id: product_id,
                color: color
            },
            success: function(response) {
                $("#size-list").html(response);
                $("#price-box").html(""); // clear price

                // Auto-select first size
                let firstSizeBtn = $('.size-btn').first();
                firstSizeBtn.addClass('active');
                let size = firstSizeBtn.data('size');
                // Auto-load price + images for first size
                loadPriceAnddata(size, color, product_id);
                loadImages_data(size, color, product_id);



            }
        });
    }

    // load image and price

    function loadPriceAnddata(size, color, product_id) {

        // Load price
        $.ajax({
            url: "{{ route('get.price.by.size') }}",
            type: "GET",
            data: {
                product_id: product_id,
                color: color,
                size: size
            },
            success: function(response) {
                $("#price-box").html(response);
            }
        });


        // load variation

        $.ajax({
            url: "{{ route('get.product.variation') }}",
            type: "GET",
            data: {
                product_id: product_id,
                color: color,
                size: size
            },
            success: function(response) {
                $("#variation-box").html(response);
            }
        });


    }


    function loadImages_data(size, color, product_id) {


        // Load images
        $.ajax({
            url: "{{ route('get.product.images') }}",
            type: "GET",
            data: {
                product_id: product_id,
                color: color,
                size: size
            },
            success: function(response) {
                console.log(response)

                $("#images_show-box").html(response);
                $("#images_show-box").html(response);

            }
        });


    }




    $(document).on('click', '.size-btn', function() {

        $('.size-btn').removeClass('active');
        $(this).addClass('active');

        let size = $(this).data('size');
        let color = $(".color-box.active").data('color');
        let product_id = "{{ $product->id }}";

        loadPriceAnddata(size, color, product_id);
    });


    $(document).ready(function() {

        let product_id = "{{ $product->id }}";

        // 1️⃣ Get first color
        let firstColor = $('.color-box').first().data('color');
        $('.color-box').first().addClass('active');

        // 2️⃣ Load sizes for first color
        $.ajax({
            url: "{{ route('get.sizes.by.color') }}",
            type: "GET",
            data: {
                product_id: product_id,
                color: firstColor
            },
            success: function(response) {
                $("#size-list").html(response);

                // 3️⃣ Auto-select first size
                let firstSizeBtn = $('.size-btn').first();
                firstSizeBtn.addClass('active');

                let firstSize = firstSizeBtn.data('size');

                // 4️⃣ Auto-load price + images
                loadPriceAnddata(firstSize, firstColor, product_id);
                loadImages_data(firstSize, firstColor, product_id);

            }
        });

    });


    // Active and Inactive product 

    $('body').on('click', '#switchCheckDefault', function() {
        //alert('Hello');
        var id = $(this).attr('rel');
        //alert(id)
        $.ajax({
            url: "{{ url('seller/product-status-active-inactive') }}",
            type: "get",
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            dataType: "json",
            beforeSend: function() {
                $('#loader').show()
            },
            success: function(data) {
                console.log(data.data)
                if (data.data.product_active_status == 1) {
                    toastr.success(data.message);

                } else if (data.data.product_active_status === 0) {
                    toastr.error(data.message);

                } else {
                    toastr.error("<?php echo 'Unexpected_response_from_server'; ?>");
                }

                // setInterval(() => {
                //     window.location.reload();
                // }, 1000);


            },
            error: function() {
                alert("Fail")
            },
            complete: function() {
                // Hide loader (after success or error)
                $('#loader').hide();
            }
        })
    })




    // Handle confirm delete


    $('#confirmDeleteBtn').on('click', function() {

        deleteId = $(this).data('id');
        $.ajax({
            url: '/seller/delete-product/' + deleteId, // update with your route
            type: 'get', // or POST if you use method spoofing
            data: {
                _token: '{{ csrf_token() }}', // Laravel CSRF token
            },
            success: function(response) {
                // hide modal
                $('#deleteConfirmModal').modal('hide');

                toastr.success(response.message);

                window.setTimeout(function() {
                    window.location = "{{ route('seller.products') }}";
                }, 2000);


                // remove row from table or reload
                // $('#row_' + deleteId).remove();

                // optional: show success message
                // alert('Item deleted successfully');

            },
            error: function(xhr) {
                // console.log(xhr.responseJSON);

                // alert('Something went wrong!');
                toastr.error(xhr.responseJSON.message);
                $('#deleteConfirmModal').modal('hide');


            }
        });
    });


    function checkInventory() {

        let product_id = "{{ $product->id }}";

        let color_id = $('.color-box.active').attr('data-color');
        let size_id = $('.size-btn.active').attr('data-size');


        console.log(color_id + '---' + size_id);

        $('#inventory_product_id').val(product_id);

        $.ajax({
            url: "{{ route('get.getcolorsizeaccordingdetails') }}",
            type: "GET",
            data: {
                product_id: product_id,
                color: color_id,
                size: size_id
            },
            success: function(response) {

                $('#inventory_variation_id').val(response.data.id);

                $('#Inventory_stock').val(response.data.total_stock);
                $('#Inventory_sku').val(response.data.sku);

            }
        });

    }



    // When user Submit From submit code Apply

    $(document).on('submit', 'form#editinventory', function(event) {
        event.preventDefault();
        $('p.error_container').html("");
        $("#file-error").html("");

        var form = $(this);
        var data = new FormData($(this)[0]);
        var url = form.attr("action");
        var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';

        $('.submit').attr('disabled', true);
        // $('.form-control').attr('readonly', true).addClass('disabled-link');
        $('.error-control').addClass('disabled-link');

        if ($('.submit').html() !== loadingText) {
            $('.submit').html(loadingText);

        }


        var product_id = $('#inventory_product_id').val();


        $.ajax({
            type: form.attr('method'),
            url: url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                // Show loader
                $('#loader').show();
            },
            success: function(response) {
                console.log(response);

                window.setTimeout(function() {
                    $('.customBtn, .form-control').attr('disabled', false).removeClass(
                        'disabled-link');
                    $('.submit').html('Upload');
                }, 2000);

                if (response.status === 'success') {
                    toastr.success(response.message);

                    $('.submit').attr('disabled', true);

                    window.setTimeout(function() {
                        window.location =
                            "{{ route('seller.view_inventory',$product->id  ) }}";
                    }, 1000);

                }
            },
            error: function(xhr) {
                $('.text-danger').empty(); // Clear previous errors

                let errors = xhr.responseJSON.errors ?? xhr.responseJSON.data;

                $.each(errors, function(field, messages) {

                    let errorId = "#error-" + field;

                    $(errorId).html(messages[0]);

                    // 1️⃣ Handle array fields with index → product_spe_en.0
                    if (field.includes(".")) {

                        let parts = field.split(".");
                        let fieldName = parts[0];
                        let index = parts[1];

                        // Example → #error-product_spe_en_0
                        $("#error-" + fieldName + "_" + index).html(messages[0]);

                    } else {

                        // 2️⃣ File special case
                        if (field === "file") {
                            $("#file-error").html(messages[0]);
                        }

                        // 3️⃣ Handle whole array errors (custom rule)
                        $("#error-" + field).html(messages[0]);
                    }
                });
            },
            complete: function() {
                // Hide loader (after success or error)
                $('#loader').hide();
            }

        });

        return false;
    });
    </script>