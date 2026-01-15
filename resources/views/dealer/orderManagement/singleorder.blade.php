@include('dealer.layout.header')
<style>
.star-rating i,
.star-rating {
    color: #FFA41B;
    font-size: 38px;

}
</style>

<section class="section dashboard">

    <div class="d-flex justify-content-between mt-2">
        <a class="title24 alink" href="{{route('seller.order_management')}}"> <i class="bi bi-chevron-left"></i>
            Details</a>
        <div class="from-group-list">

            <!-- <div style="color:#FF5F1B;">Returned</div>
            <div style="color:#D53B36;">Cancelled</div>
            <div style="color:#FF5F1B;">Exchange</div> -->
            <!-- 
            @if($order_details->return_type=="1")
            <div style="color:#FF5F1B;">Returned</div>

            @elseif($order_details->return_type=="2")
            <div style="color:#FF5F1B;">Exchange1</div>

            @elseif($order_details->payment_status=="2" || $order_details->payment_status=="2" || @$order_details->order->payment_method!=="3")
            <div style="color:#D53B36;">Cancelled</div>


            @elseif($order_details->payment_status!=="1" && @$order_details->order->payment_method!=="3")
            <div style="color:#D53B36;">Cancelled</div>

            @else
            <div style="color:#16B364;">Confirmed</div>
            @endif -->

            @if($order_details->payment_status == '2' || $order_details->payment_status == '3')
            <div class="btn-outline1 btn-outline-red" style="color:#D53B36;">Cancelled</div>
            @elseif(in_array($order_details->delivery_status, ['1', '2']) && $order_details->payment_status !== '2' &&
            $order_details->payment_status !== '3' )
            <div class="btn-outline1 btn-ongoing" style="color:#16B364;">Ongoing</div>
            @elseif($order_details->delivery_status == '3' && $order_details->return_type == '0')
            <div class="btn-outline1 btn-outline-de" style="color:#16B364;">Delivered</div>
            @elseif($order_details->delivery_status == '3' && $order_details->return_type == '1')
            <div class="btn-outline1 btn-ongoing" style="color:#FF5F1B;">Return Request</div>
            @elseif($order_details->delivery_status == '3' && $order_details->return_type == '2')
            <div class="btn-outline1 btn-ongoing" style="color:#FF5F1B;">Exchange Request</div>
            @endif



        </div>
    </div>


    <div class="order-box border-radious-10 box-shadow mt-4">
        <div class="row">
            <div class="col rightline">
                <div class="order-ic d-flex gap-2">
                    <img src="{{ asset('dealer') }}/assets/img/all-icons/order.svg" alt="icon" class="img-fluid">
                    <div class="order-cont">
                        <div class="title-light">Order ID</div>
                        <p>#{{ $order_details->id}}</p>
                    </div>
                </div>
            </div>
            <div class="col rightline">
                <div class="order-ic">
                    <div class="order-cont">
                        <div class="title-light">Order Type</div>
                        <p>
                            @if($order_details->order->order_type=='1')
                            Normal Order
                            @else
                            Custom Order
                            @endif

                        </p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="order-ic">
                    <div class="order-cont">
                        <div class="title-light">Date & Time </div>
                        <p>{{$order_details->created_at}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div class="order-box border-radious-10 box-shadow mt-4">
                <h6>Customer Detail</h6>

                <div class="cust-deatils-pnl d-flex justify-content-between">
                    <div class="cust-deatils">
                        <div class="d-flex gap-3">
                            <div class="user-box1">


                                <img src="{{ $order_details->order->user_details->profile_image }}" alt="icon"
                                    class="img-fluid">
                            </div>
                            <div class="order-cont">
                                <p>{{$order_details->order->delivery_details->name}}</p>
                                <div class="title-light">
                                    Phone:<span>{{$order_details->order->delivery_details->country_code}}
                                        {{$order_details->order->delivery_details->mobile}}</span></div>
                            </div>
                        </div>
                        <div class="title-light mt-2">
                            Mail id:<span> {{ $order_details->order->user_details->email }}</span>
                        </div>
                    </div>
                    <div class="cust-deatils">
                        <div class="order-cont">
                            <div class="title-light">Shipping Address</div>
                            <p>{{$order_details->order->delivery_details->address}} </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="order-box border-radious-10 box-shadow mt-4">
                <h6>Delivery Instruction</h6>
                <div class="cust-deatils-pnl">
                    <p class="font-15">lorem ipsum dolor sit amet, consectetur adipisici elit, sed do eiusmod temo
                        incididunt
                        labore et dolore magna aliqua. Ut enim ad lorem ipsum dolor sit amet, consectetur is adipisici
                        elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim adlorem ipsum
                        dolor sit amet, consectetur adipisici elit, sed do eiusmod tempor incididunt ut labore et dolore
                        magna aliqua. Ut enim ad</p>
                </div>
            </div> -->

            <div class="order-box border-radious-10 box-shadow mt-4">
                <h6>Payment Summary</h6>

                @isset($order_details->order->transaction_id)
                <div class="pay-sum">
                    <div class="summary-title-1">Transaction id</div>
                    <div class="summary-value">#{{$order_details->order->transaction_id}} </div>
                </div>
                @endisset
                <div class="pay-sum">
                    <div class="summary-title-1">Sub Total</div>
                    <div class="summary-value">{{$order_details->amount}} KD</div>
                </div>

                @isset($order_details->promocode_value)
                <div class="pay-sum">
                    <div class="summary-title-1">Coupon Applied</div>
                    <div class="summary-value">{{$order_details->promocode_value}} KD</div>
                </div>
                @endIsset

                <div class="pay-sum">
                    <div class="summary-title-1">Shipping Charges</div>
                    <div class="summary-value">{{$order_details->shipping_fees}} KD</div>
                </div>

                <div class="pay-sum">
                    <div class="summary-title-1">tax</div>
                    <div class="summary-value">{{$order_details->tax}} KD</div>
                </div>

                <div class="pay-sum">
                    <div class="summary-title-1">Total</div>

                    @php

                    $user_Paid_amount= $order_details->amount + $order_details->tax
                    + $order_details->shipping_fees;

                    $total_amount= $order_details->amount + $order_details->tax +
                    $order_details->promocode_value + $order_details->shipping_fees +$order_details->giftcard_amount ;

                    @endphp

                    <div class="summary-value">{{$total_amount}} KD</div>
                </div>
                <div class="pay-sum">
                    <div class="summary-title-1">Paid By Customer</div>
                    <div class="summary-value">{{$user_Paid_amount}} KD</div>
                </div>

                <div class="pay-sum">
                    <div class="summary-title-1">Admin Commission</div>
                    <div class="summary-value">{{$order_details->admin_commission}} KD</div>
                </div>
            </div>

        </div>


        <div class="col-lg-6 col-md-6">
            <div class="order-light mt-4">
                <div class="order-p-pnl">
                    <div class="prodimg">
                        <figure>
                            <img src="{{ $order_details->variation_details->variant_image[0] }}" alt="icon"
                                class="img-fluid">
                        </figure>
                    </div>

                    <div class="w-100">
                        <div class="pay-sum">
                            <div class="summary-title-1">{{ $order_details->product_details->product_name_en }}</div>
                            <div class="summary-value">{{$order_details->variation_details->final_price }} KD</div>
                        </div>
                        <div class="pay-sum">
                            <div class="summary-title-1">Size</div>
                            <div class="summary-value">{{ $order_details->variation_details->size->name }}</div>
                        </div>
                        <div class="pay-sum">
                            <div class="summary-title-1">Color </div>
                            <div class="summary-value">{{ $order_details->variation_details->color->name }}</div>
                        </div>
                        <div class="pay-sum">
                            <div class="summary-title-1">Category </div>
                            <div class="summary-value">{{ $order_details->product_details->category->name }}</div>
                        </div>
                        <div class="pay-sum">
                            <div class="summary-title-1">Quantity</div>
                            <div class="summary-value">{{ $order_details->quantity}}</div>
                        </div>
                    </div>
                </div>
            </div>
            @isset($order_details->UserRatingReviewProvide)
            <div class="order-box border-radious-10 box-shadow mt-4">
                <h6>Customer Ratings</h6>

                <div class="star-rating mt-1">

                    @for ($i = 0; $i < $order_details->UserRatingReviewProvide->product_rating ; $i++)
                        <i class="bi bi-star-fill"></i>
                        @endfor
                </div>

                <div class="cust-deatils-pnl mt-4">
                    <!-- <h6>Review</h6> -->
                    <p class="font-15">
                        {{$order_details->UserRatingReviewProvide->product_review}}
                    </p>
                </div>

                <!-- Store rating  -->
                <h6>Store Ratings</h6>
                <div class="star-rating mt-1">

                    @for ($i = 0; $i < $order_details->UserRatingReviewProvide->store_rating ; $i++)
                        <i class="bi bi-star-fill"></i>
                        @endfor
                </div>

                <div class="cust-deatils-pnl mt-4">
                    <!-- <h6>Review</h6> -->
                    <p class="font-15">
                        {{$order_details->UserRatingReviewProvide->store_review}}
                    </p>
                </div>


            </div>

            @endisset

            <!-- Product return Code  Start -->

            @if($order_details->return_type==!'0' && $order_details->return_type=='1' )

            <div class="order-box border-radious-10 box-shadow mt-4">
                <h6>Return Details</h6>

                <div class="pay-sum">
                    <div class="summary-title-1">Return Id</div>
                    <div class="summary-value">#{{$order_details->id }}</div>
                </div>
                <div class="pay-sum">
                    <div class="summary-title-1">Requested on</div>
                    <div class="summary-value">{{$order_details->updated_at }}</div>
                </div>
                <div class="pay-sum">
                    <div class="summary-title-1">Reason</div>
                    <div class="summary-value">{{$order_details->return_reason }} </div>
                </div>

            </div>
            <div class="mt-4">

                <h6>Uploaded image</h6>
                <div class="order-box border-radious-10 box-shadow mt-4 d-flex justify-content-center">
                    <div class="prodimg">
                        <figure>
                            <img src="{{@$order_details->return_image[0] }}" alt="icon" class="img-fluid">
                        </figure>
                    </div>

                </div>
            </div>

            @endif

            <!-- Product return Code  End  -->

            <!-- Product Exchange Code  Start -->

            @if($order_details->return_type!=='0' && $order_details->return_type=='2' )


            <div class="order-box border-radious-10 box-shadow mt-4">
                <h6>Exchange Details</h6>

                <div class="pay-sum">
                    <div class="summary-title-1">Exchange Id</div>
                    <div class="summary-value">#{{$order_details->id }}</div>
                </div>
                <div class="pay-sum">
                    <div class="summary-title-1">Exchange requested on</div>
                    <div class="summary-value"> {{$order_details->updated_at }}</div>
                </div>
                <div class="pay-sum">
                    <div class="summary-title-1">Reason</div>
                    <div class="summary-value">{{$order_details->exchange_reason }}</div>
                </div>
                <div class="pay-sum">
                    <div class="summary-title-1">Exchange size</div>
                    <div class="summary-value">{{@$order_details->exchange_new_size_data->name}}</div>
                </div>
            </div>

            @endif

            <!-- Product Exchange Code  End Here  -->

            <!-- Return Acceopt and reject Submit Form -->
            @if($order_details->return_type!=='0' && $order_details->return_type=='1' &&
            $order_details->r_e_approve=='0' )

            <form id="updateReturnStatus" action="{{ route('seller.update-return-exchange') }}" method="post">
                @csrf

                <input type="hidden" name="id" value="{{ request()->id}}">

                <div class="dashboard-button d-flex mt-5 gap-5">
                    <div class="from-group  w-100">
                        <select class="form-select form-control option width-50" aria-label="Default select example"
                            name="status">
                            <option value="">Select Return </option>
                            <option value="1"> Accept </option>
                            <option value="2"> Reject </option>

                        </select>
                    </div>
                    <button type="submit" class="btn add-fillbtn w-100">Update Status</button>
                </div>

            </form>

            @endif


            <!-- Exchnage Accept and reject Submit Form -->
            @if($order_details->return_type!=='0' && $order_details->return_type=='2' &&
            $order_details->r_e_approve=='0' )

            <form id="updateexchnageStatus" action="{{ route('seller.update-return-exchange') }}" method="post">
                @csrf

                <input type="hidden" name="id" value="{{ request()->id}}">

                <div class="dashboard-button d-flex mt-5 gap-5">
                    <div class="from-group  w-100">
                        <select class="form-select form-control option width-50" aria-label="Default select example"
                            name="status">
                            <option value="">Select Exchange request </option>
                            <option value="1"> Accept </option>
                            <option value="2"> Reject </option>

                        </select>
                    </div>
                    <button type="submit" class="btn add-fillbtn w-100">Update Status</button>
                </div>

            </form>

            @endif

            <!-- If Delivery Form in Process  -->

            @if($order_details->return_type=="0" && !in_array($order_details->payment_status, ["2", "3"]) &&
            in_array($order_details->delivery_status,['1','2','2.1','2.2']))

            <form id="updateDeliveryStatus" action="{{ route('seller.update-delivery-status') }}" method="post">
                @csrf

                <input type="hidden" name="id" value="{{ request()->id}}">
                <div class="dashboard-button d-flex mt-5 gap-5">
                    <div class="from-group  w-100">
                        <select class="form-select form-control option width-50" aria-label="Default select example"
                            name="status">
                            <!-- <option value="">Delivery process</option> -->
                            <option value="1" @if($order_details->delivery_status=="1") selected @endif > Confirmed
                            </option>
                            <!-- <option value="2.1" @if($order_details->delivery_status=="2.1") selected @endif > Packed
                            </option> -->
                            <option value="2.2" @if($order_details->delivery_status=="2.2") selected @endif> Shipped
                            </option>
                        </select>
                    </div>

                    <button type="submit" class="btn add-fillbtn w-100">Update Status</button>
                </div>

            </form>

            @endif

        </div>
    </div>

</section>

<script>
$(document).on('submit', 'form#updateDeliveryStatus', function(event) {
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

                window.setTimeout(function() {
                    window.location = window.location.href;
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


// return accept and reject status code 

$(document).on('submit', 'form#updateReturnStatus', function(event) {
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

                window.setTimeout(function() {
                    window.location = window.location.href;
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


// exchnage Accept and reject Code 

$(document).on('submit', 'form#updateexchnageStatus', function(event) {
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

                window.setTimeout(function() {
                    window.location = window.location.href;
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


<!-- OVERLAY -->
<div class="overlay" id="overlay"></div>



@include('dealer.layout.custom_code');



@include('dealer.layout.footer');