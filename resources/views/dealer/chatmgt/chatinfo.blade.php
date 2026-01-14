@include('dealer.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <a class="title24 alink"> Chat Info</a>
    </div>


    <div class="main-content categoryDetail mt-4">
        <div class="row">

            @if($single_chats['record']->type=='2')

            <div class="col-lg-4">
                <div class="cart-panel position-relative">
                    <div class="link-content">
                        <div class="cart-card">
                            <div class="pb-2 d-flex justify-content-between">
                                <div class="request-title">Request id # {{ $single_chats['record']->unique_id }}</div>
                                <!-- <div class="yellow-bg" style="color:#EA9413;background:#EA94131A;">New</div> -->
                                <!-- <div class="yellow-bg" style="color:#172B85;background:#172B851A;">Quotation Received</div> -->
                                <!-- <div class="yellow-bg" style="color:#17854C;background:#17854C1A;">Quotation Accepted
                                </div> -->


                                @if($single_chats['record']->type=='2' &&
                                $single_chats['record']->product_request=='1' && $single_chats['record']->action=='0')

                                <div class="yellow-bg" style="color:#172B85;background:#172B851A;">Request
                                    Quotation
                                </div>

                                @elseif($single_chats['record']->type=='2' &&
                                $single_chats['record']->product_request=='1' && $single_chats['record']->action=='1'
                                || $single_chats['record']->action=='2' )

                                <div class="yellow-bg" style="color:#17854C;background:#17854C1A;">Quotation
                                    Send</div>

                                @elseif($single_chats['record']->type=='2' &&
                                $single_chats['record']->product_request=='1' && $single_chats['record']->action=='3'
                                || $single_chats['record']->action=='4')

                                <div class="red-bg" style="color:#EA9413;background:##fb0b0b;">Request
                                    Cancelled
                                </div>

                                @elseif($single_chats['record']->type=='2' &&
                                $single_chats['record']->product_request=='1' && $single_chats['record']->action=='5')

                                <div class="red-bg" style="color:#172B85;background:#172B851A;">
                                    Quotation Accepted
                                </div>

                                @else
                                <div class="yellow-bg" style="color:#EA9413;background:#EA94131A;">Waiting
                                </div>
                                @endif



                            </div>
                            <div class="card-left mb-2 d-flex">
                                <div>
                                    <div class="chat-odr me-3">
                                        <img src="{{ $single_chats['record']->product_variation->variant_image[0]}}"
                                            alt="Product" class="img-fluid">
                                    </div>
                                </div>

                                <div class="w-100">
                                    <div class="card-right d-flex w-100 justify-content-between">
                                        <div class="product-info">
                                            <h5 class="product-title">
                                                {{ $single_chats['record']->product_variation->product_details->product_name_en  }}
                                            </h5>
                                            <div class="psize d-flex gap-4 mt-2">
                                                <span>Size:
                                                    {{ $single_chats['record']->product_variation->size->name  }}</span>
                                                <span class="d-flex align-items-center gap-2">
                                                    Color:
                                                    <div class="colorbox"
                                                        style="width:15px;height:15px;border-radius:3px;background:{{ $single_chats['record']->product_variation->color->hex_code }};">
                                                    </div>
                                                </span>

                                            </div>
                                            <h6 class="product-title mt-2">
                                                {{ $single_chats['record']->product_variation->final_price }} KD</h6>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="gift-pnl mt-4">
                    <div class="border-1">
                        <table class="table table-borderless table-font">
                            <tr>
                                <td>
                                    <div class="width-120">Total Quantity</div>
                                </td>
                                <td>
                                    <div> {{ $single_chats['record']->quantity }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="width-120">Address</div>
                                </td>
                                <td>
                                    <div> {{ @$single_chats['record']->delivery_details->address}} </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="width-120">Custom details</div>
                                </td>
                                <td>
                                    <div class="mb-0">{{ $single_chats['record']->custom_details}} </div>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>


                <!-- Show Quetasion Code  -->
                @if($single_chats['record']->product_request=='1' && $single_chats['record']->action=='0')

                <form id="SendQuotation" action="{{ route('seller.Modify_custom_order_price')}}" method="post">
                    @csrf

                    <input type="hidden" class="form-control notapplyspace " placeholder="Eg 20 KD"
                        value="{{ $single_chats['record']->quantity }}" name="quantity" id="quantity1">

                    <input type="hidden" class="form-control notapplyspace " placeholder="Eg 20 KD"
                        value="{{ $single_chats['record']->unique_id}}" name="unique_id">


                    <div class="quation-pnl mt-3">
                        <h5>Quotation</h5>
                        <div class="form-group sub-form">
                            <label for="item" class="size14">Per Item Price</label>
                            <input type="text" class="form-control notapplyspace applynumberOnly" placeholder="Eg 20 KD"
                                name="price" id="price1">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group sub-form">
                                    <label for="item" class="size14">Shipping Fees </label>
                                    <input type="text" class="form-control notapplyspace applynumberOnly"
                                        placeholder="Eg 20 KD" name="shipping" id="shipping1">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group sub-form">
                                    <label for="item" class="size14">Tax</label>
                                    <input type="text" class="form-control notapplyspace applynumberOnly"
                                        placeholder="Eg 20 KD" name="tax" id="tax1">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group sub-form">
                                    <label for="item" class="size14">Total Amount</label>
                                    <input type="text" class="form-control notapplyspace applynumberOnly"
                                        name="total_amount" id="total_amount1" placeholder="Eg 20 KD">
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn add-fillbtn w-100">Send Quotation</button>
                        </div>
                    </div>

                </form>

                @endif


                @if($single_chats['record']->product_request=='1' || $single_chats['record']->action=='0')

                <div class="time-pnl">
                    <div class="gift-pnl mt-4">
                        <div class="border-12">
                            <div class="accordion" id="accordionPanelsStayOpenExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#viewRequest" aria-expanded="true"
                                            aria-controls="viewRequest">
                                            View Request
                                        </button>
                                    </h2>
                                    <div id="viewRequest" class="accordion-collapse collapse p-3">
                                        <table class="table table-borderless table-font">
                                            <tr>
                                                <td>
                                                    <div class="width-120">Item Price</div>
                                                </td>
                                                <td>
                                                    <div>{{ $single_chats['record']->price}} KD</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="width-120">Shipping Fees</div>
                                                </td>
                                                <td>
                                                    <div>{{ $single_chats['record']->shipping}} KD</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="width-120">Tax</div>
                                                </td>
                                                <td>
                                                    <div>{{ $single_chats['record']->tax}} KD</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="width-120">Total Amount </div>
                                                </td>
                                                <td>
                                                    <div>{{ $single_chats['record']->total_amount}} KD</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @endif

                @if($single_chats['record']->action=='2' || $single_chats['record']->action=='3')

                <div class="time-pnl">
                    <div class="gift-pnl mt-4">
                        <h5>Quotation</h5>

                        <div class="border-1">
                            <table class="table table-borderless table-font mb-0">
                                <tr>
                                    <td>
                                        <div class="width-120">Per Item Price</div>
                                    </td>
                                    <td>
                                        <div>{{ $single_chats['record']->price}} KD</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="width-120">Shipping Fees</div>
                                    </td>
                                    <td>
                                        <div>{{ $single_chats['record']->shipping}} KD</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="width-120">Tax</div>
                                    </td>
                                    <td>
                                        <div>{{ $single_chats['record']->tax}} KD</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="width-120">Total Amount </div>
                                    </td>
                                    <td>
                                        <div>{{ $single_chats['record']->total_amount}} KD</div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn add-fillbtn w-100" data-bs-toggle="modal"
                            data-bs-target="#modifyModal">Modify Quotation</button>
                    </div>
                </div>
                @endif

            </div>


            @endif


            <div class="col-lg-8">
                <div class="categoryDetail_content">
                    <div class="msger card">
                        <header class="msger-header d-flex gap-2 align-items-center">
                            <div class="chat-user-1 me-3">
                                <img src="{{ $single_chats['record']->user_details->profile_image}}" alt="Product"
                                    class="img-fluid">
                            </div>
                            <h5 class="msger-header-title">{{ $single_chats['record']->user_details->full_name}}
                            </h5>
                        </header>

                        <main class="msger-chat chatfull">

                            @foreach($single_chats['firbase_chat'] as $key=>$val)

                            <div class="msg w-100  @if($val['by']=='user') left-msg  @else right-msg  @endif">
                                <div class="msg-bubble">
                                    <div class="msg-text">
                                        @if($val['type']=='0')
                                        {{$val['message']}}
                                        @else
                                        <img src="{{$val['message']}}" width="100px">
                                        @endif


                                    </div>
                                    <div class="msg-info @if($val['by']=='user')  @else text-end  @endif ">
                                        <div class="msg-info-time"> {{ formatChatTime( $val['times'])}} </div>
                                    </div>
                                </div>
                            </div>

                            @endforeach

                        </main>

                        <form class="msger-inputarea d-flex position-relative">
                            <div class="attached-icon">
                                <i class="bi bi-paperclip"></i>
                                <input type="file" id="imageUpload" accept="image/*">
                            </div>

                            <input type="text" class="form-control msger-input" placeholder="Type Message here...">
                            <button type="submit" class="msger-send-btn"><i class="bi bi-send-fill"></i></button>
                        </form>
                    </div>


                </div>
            </div>
        </div>


    </div>

</section>


<!-- Modal -->
<div class="modal fade" id="modifyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Modify Quotation </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="ModifyPrice" action="{{ route('seller.Modify_custom_order_price')}}" method="post">
                @csrf

                <input type="hidden" class="form-control notapplyspace " placeholder="Eg 20 KD"
                    value="{{ $single_chats['record']->quantity}}" name="quantity" id="quantity0">

                <input type="hidden" class="form-control notapplyspace " placeholder="Eg 20 KD"
                    value="{{ $single_chats['record']->unique_id}}" name="unique_id">

                <div class="modal-body p-4">
                    <div class="quation-pnl mt-1">
                        <div class="form-group sub-form">
                            <label for="item" class="size14">Per Item Price</label>
                            <input type="text" class="form-control notapplyspace applynumberOnly" placeholder="Eg 20 KD"
                                name="price" id="price0" value="{{ $single_chats['record']->price}}">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group sub-form">
                                    <label for="item" class="size14">Shipping Fees </label>
                                    <input type="text" class="form-control notapplyspace applynumberOnly"
                                        placeholder="Eg 20 KD" value="{{ $single_chats['record']->shipping}}"
                                        name="shipping" id="shipping0">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group sub-form">
                                    <label for="item" class="size14">Tax</label>
                                    <input type="text" class="form-control notapplyspace applynumberOnly"
                                        placeholder="Eg 20 KD" value="{{ $single_chats['record']->tax}}" name="tax"
                                        id="tax0">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group sub-form">
                                    <label for="item" class="size14">Total Amount</label>
                                    <input type="text" class="form-control notapplyspace applynumberOnly"
                                        placeholder="Eg 20 KD" value="{{ $single_chats['record']->total_amount}}"
                                        name="total_amount" id="total_amount0">
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn add-fillbtn w-100">Confirm & Modify</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>


<!-- jQuery (required by Toastr) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function calculateTotal(val) {
    let price = parseFloat(document.getElementById('price' + val).value) || 0;
    let shipping = parseFloat(document.getElementById('shipping' + val).value) || 0;
    let tax = parseFloat(document.getElementById('tax' + val).value) || 0;
    let quantity = parseFloat(document.getElementById('quantity' + val).value) || 1;

    let total = (price * quantity) + shipping + tax;

    document.getElementById('total_amount' + val).value = total.toFixed(2);
}

// Row 0
document.getElementById('price0').addEventListener('input', () => calculateTotal(0));
document.getElementById('shipping0').addEventListener('input', () => calculateTotal(0));
document.getElementById('tax0').addEventListener('input', () => calculateTotal(0));
document.getElementById('quantity0').addEventListener('input', () => calculateTotal(0));

// Row 1
document.getElementById('price1').addEventListener('input', () => calculateTotal(1));
document.getElementById('shipping1').addEventListener('input', () => calculateTotal(1));
document.getElementById('tax1').addEventListener('input', () => calculateTotal(1));
document.getElementById('quantity1').addEventListener('input', () => calculateTotal(1));



// // modify Orders Code 
$(document).on('submit', 'form#SendQuotation', function(event) {
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
                // toastr.success(response.message);
                toastr.success("Send Quotation Request Send Successfully");

                // $('#RequestBanner').modal('show');

                $('.submit').attr('disabled', true);
                window.setTimeout(function() {
                    window.location =
                        "{{ route('seller.single-chat-info', request()->id) }}";
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


// modify Orders Code 
$(document).on('submit', 'form#ModifyPrice', function(event) {
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
                // toastr.success(response.message);

                $('#RequestBanner').modal('show');

                $('.submit').attr('disabled', true);
                window.setTimeout(function() {
                    window.location =
                        "{{ route('seller.single-chat-info', request()->id) }}";
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