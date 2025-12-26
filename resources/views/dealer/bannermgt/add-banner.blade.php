@include('dealer.layout.header')

<section class="section dashboard">
    <!-- <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <a class="title24 alink"> <i class="bi bi-chevron-left"></i>Details</a>
 
    </div> -->
    <div class="d-flex justify-content-between mt-4">
        <a href="#" class="title24 alink"> <i class="bi bi-chevron-left"></i>Add New Banner</a>
    </div>

    <form id="addBanner" action="{{ route('seller.add_banner') }}" method="post">
        @csrf

        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="col-md-6">

                    <!-- Banner Position -->
                    <label class="banner-text">Banner position</label>
                    <div class="group-radio-btn d-flex gap-5 align-items-center flex-wrap py-3 pe-3">

                        <div class="check_radio">
                            <label class="radio-group">
                                <input type="radio" name="banner_position" value="1" checked>
                                <span class="custom-radio"></span>
                                <span class="radio-label">Home Top</span>
                            </label>
                        </div>

                        <div class="check_radio">
                            <label class="radio-group">
                                <input type="radio" name="banner_position" value="2">
                                <span class="custom-radio"></span>
                                <span class="radio-label">Home Bottom</span>
                            </label>
                        </div>

                        <div class="check_radio">
                            <label class="radio-group">
                                <input type="radio" name="banner_position" value="3">
                                <span class="custom-radio"></span>
                                <span class="radio-label">Category</span>
                            </label>
                        </div>
                    </div>

                    <p class="text-danger" id="error-banner_position"></p>

                </div>
                <!-- CATEGORY FIELDS -->
                <div id="categoryFields" class="row mt-3" style="display: none;">
                    <div class="col-md-6">
                        <label>Category name</label>
                        <select class="form-control" name="category" onclick="catgoryFunction(this.value)">
                            @foreach($category as $cat)
                            <option value="{{$cat->id}}">{{$cat->name}}
                            </option>
                            @endforeach

                        </select>

                        <p class="text-danger" id="error-category"></p>

                    </div>

                    <div class="col-md-6">
                        <label>Sub-category name</label>
                        <select class="form-control" name="subcatgory" id="getSubcategry">

                        </select>
                        <p class="text-danger" id="error-subcatgory"></p>

                    </div>
                </div>

                <div class="col-lg-12">
                    <!-- Duration -->
                    <div class="d-flex justify-content-between mt-4">
                        <h6 class="banner-texts">Select Duration</h6>
                        <input type="hidden" name="total_days" id="totalDaysValue" value="">
                        <span class="banner-texts" id="totalDays">Total days - 00</span>
                    </div>
                    <p class="text-danger" id="error-total_days"></p>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="banner-text">From</label>
                            <input type="date" id="fromDate" class="form-control" min="<?= date('Y-m-d');?>"
                                name="start_date">

                            <p class="text-danger" id="error-start_date"></p>

                        </div>
                        <div class="col-md-6">
                            <label class="banner-text">To</label>
                            <input type="date" id="toDate" class="form-control" min="<?= date('Y-m-d');?>"
                                name="end_date">
                            <p class="text-danger" id="error-end_date"></p>

                        </div>


                    </div>


                </div>
                <div class="col-lg-12">
                    <div class="product-pnls2 mt-3">
                        <div class="upload-image" style="height:100%;">
                            <label id="bannerUploadLabel" style="cursor:pointer;text-align:center;display:block;">

                                <!-- Placeholder -->
                                <img id="bannerPlaceholderImg" src="{{ asset('/dealer') }}/assets/img/upload-icon.svg"
                                    style="width:70px;object-fit:cover;border-radius:6px;padding-top:2rem;">

                                <!-- Uploaded Image -->
                                <img id="bannerUploadedImg" src="" style="width:100px;display:none;object-fit:cover;border-radius:6px;height:110px; margin:auto;">

                                <div class="py-2" style="color:#875C3A">
                                    Upload Banner
                                </div>

                                <!-- SINGLE IMAGE -->
                                <input type="file" accept="image/*" id="banner_image_upload" style="opacity:0;"
                                    name="upload_banner">

                                <p class="text-danger" id="error-upload_banner"></p>

                            </label>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div class="mb-5">
            <div class="dashboard-button d-flex mt-5 gap-5">
                <input type="hidden" name="price" id="amount">

                <button type="button" class="btn total-outline w-100">Total Price <strong id="AmountPrice">
                        0 </strong> KD</button>
                <button type="submit" class="btn add-fillbtn w-100">Send Request</button>
            </div>

        </div>

    </form>

</section>
<script>
document.getElementById('banner_image_upload').addEventListener('change', function(event) {
    const file = event.target.files[0];

    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('bannerUploadedImg').src = e.target.result;
        document.getElementById('bannerUploadedImg').style.display = 'block';
        document.getElementById('bannerPlaceholderImg').style.display = 'none';
    };
    reader.readAsDataURL(file);
});
</script>

<script>
const radios = document.querySelectorAll(
    'input[name="banner_position"]'
);
const categoryFields = document.getElementById('categoryFields');

radios.forEach(radio => {
    radio.addEventListener('change', function() {

        console.log(this.value);

        if (this.value === '3') {
            categoryFields.style.display = 'flex';
        } else {
            categoryFields.style.display = 'none';
        }
    });
});


// count Days 

const fromDate = document.getElementById('fromDate');
const toDate = document.getElementById('toDate');
const totalDays = document.getElementById('totalDays');

function calculateDays() {
    if (fromDate.value && toDate.value) {
        const start = new Date(fromDate.value);
        const end = new Date(toDate.value);

        // Difference in milliseconds
        const diffTime = end - start;

        if (diffTime >= 0) {
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            totalDays.textContent = `Total days - ${String(diffDays).padStart(2, '0')}`;

            // call ajax Code for price 

            var checkedbanner = document.querySelector(
                'input[name="banner_position"]:checked'
            );

            checkedbanner = checkedbanner.value;

            console.log(checkedbanner);

            $.ajax({
                url: "{{ url('seller/seller_banner_price?type=') }}" + checkedbanner,
                type: "get",
                data: {
                    "_token": "{{ csrf_token() }}",
                    type: checkedbanner
                },
                dataType: "json",
                beforeSend: function() {
                    // $('#loader').show()
                },
                success: function(data) {

                    if (data.status == "success") {

                        var price_data = data.data;

                        var price_amount = price_data[0].per_day_price;

                        var new_Amount = price_amount * diffDays;

                        $('#totalDaysValue').val(diffDays);

                        $('#amount').val(new_Amount);
                        $('#AmountPrice').text(new_Amount);


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
                    // $('#loader').hide();
                }

            });



        } else {
            totalDays.textContent = 'Total days - 00';
        }
    }
}

fromDate.addEventListener('change', calculateDays);
toDate.addEventListener('change', calculateDays);


// Show sub catgeory Code 


catgoryFunction();

//Category Wise Show sub-category data
function catgoryFunction(val) {


    // if no Category select on first Time;
    if (!val) {
        var checkedbanner = document.querySelector(
            'input[name="banner_position"]:checked'
        );

        val = checkedbanner.value;
    }


    $.ajax({
        url: "{{ url('api/seller/sub-category?category_id=') }}" + val,
        type: "get",
        data: {
            "_token": "{{ csrf_token() }}",
            id: val
        },
        dataType: "json",
        beforeSend: function() {
            $('#loader').show()
        },
        success: function(data) {

            if (data.status == "success") {

                var subcatgory_record = data.data;

                var htmlcontent = ' <option value="">Select Sub Category</option>';

                subcatgory_record.forEach(function(item, val) {
                    htmlcontent +=
                        `<option value="${item.id}">${item.name_english} </option>`;
                })

                $('#getSubcategry').empty();
                $('#getSubcategry').append(htmlcontent);


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
}

// Add Banner Code 

$(document).on('submit', 'form#addBanner', function(event) {
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
                    window.location = "{{ route('seller.show_banner') }}";
                }, 2000);
            }
        },
        error: function(xhr) {

            $('#loader').hide();
            $('.text-danger').empty(); // Clear previous errors

            let errors = xhr.responseJSON.errors ?? xhr.responseJSON.data;

            $.each(errors, function(field, messages) {

                // 1️⃣ Handle array fields with index → product_spe_en.0
                if (field.includes(".")) {

                    let parts = field.split(".");
                    let fieldName = parts[0];
                    let index = parts[1];
                    let index1 = parts[2];


                    // Example → #error-product_spe_en_0

                    let errorId = "#error-" + fieldName + "_" + index;

                    // If second index exists, append it
                    if (typeof index1 !== "undefined" && index1 !== "") {
                        errorId += "_" + index1;
                    }
                    $(errorId).html(messages[0]);


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



@include('dealer.layout.custom_code');
@include('dealer.layout.footer');