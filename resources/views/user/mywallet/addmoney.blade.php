@extends('user.layout.app')

@section('content')

@if (session('status') === 'error')
<div class="alert alert-danger">
    {{ session('message') }}
</div>
@endif

@php
    $currency = session('currency', 'KWD');
    $rate = session('rate', '1');
 
@endphp

<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="{{route('user.myWallet')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}"
                class="img-fluid"></a>
        <h3>{{ __('user_messages.add_money') }}</h3>
    </div>

    <form id="AddMoneyForm" method="post" action="{{route('user.addWalletMoney')}}">
        @csrf
        <div class="row">
            <div class="col-lg-8 col-md-6">
                <div class="gift-pnl addheight">
                    <h6>{{ __('user_messages.amount') }}</h6>
                    <div class="occasion-buttons mb-3">
                        <button type="button" class="amount-btn min-width-100 active" data-value="100">{{ number_format(convertPriceInUserWeb(100), 2) }} {{ $currency }}</button>
                        <button type="button" class="amount-btn min-width-100" data-value="500">{{ number_format(convertPriceInUserWeb(500), 2) }} {{ $currency }}</button>
                        <button type="button" class="amount-btn min-width-100" data-value="1000">{{ number_format(convertPriceInUserWeb(1000), 2) }} {{ $currency }}</button>

                    </div>
                    <div class="form-group w-100 py-2 amountpnl">
                        <input type="text" class="form-control pline-10" name="amount" placeholder="{{ __('user_messages.enter_amount') }}"
                            id="customAmount">
                    </div>
                    <p class="text-danger" id="error-amount"></p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="paycard mt-4">
                    <!-- <div class="payment-option mb-3">
                    <label class="custom-radio">
                        <input type="radio" name="payment">
                        <span class="radio-mark"></span>
                        <div class="label-content">
                            <div class="title">In-App Wallet</div>
                            <div class="balance">Available Balance : 349 KD</div>
                        </div>
                    </label>
                </div> -->
                    <div class="payment-option py-1">
                        <label class="custom-radio">
                            <input type="radio" name="payment_method" id="onlinePayment" value="1" checked>
                            <span class="radio-mark"></span>
                            <div class="label-content d-flex gap-2">
                                <span class="cod-box-2"><i class="bi bi-credit-card fs-5"></i></span>
                                <div class="title">{{ __('user_messages.online_payment') }}</div>

                            </div>
                        </label>
                    </div>
                </div>

                <div class="cmn-btn mt-4">
                    <button type="submit" class="btn paybtn-common w-100">{{ __('user_messages.pay_now') }}</button>
                </div>
            </div>
        </div>
    </form>

</div>

<!-- Success Modal -->
<div class="modal fade" id="addMoneyInWalletSuccessModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content added-modal">
            <div class="modal-body">
                <div class="text-center">
                    <img src="{{ asset('dealer') }}/assets/img/success.svg" alt="icon" class="img-fluid">
                    <h5 class="title24 py-3">{{ __('user_messages.amount_added_successfully') }}!</h5>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


@if (session('status') === 'success')
<script>
$(function() {
    $('#addMoneyInWalletSuccessModal').modal('show');
});
</script>
@endif



<script>
// $(document).ready(function() {
//     $(".amount-btn").click(function() {
//         $(".amount-btn").removeClass("active");

//         $(this).addClass("active");
//         let btnText = $(this).attr('data-value');
//         const currencyrate="{{$rate}}";
//         $("#customAmount").val(btnText);
        

//     });

// });

$(document).ready(function() {
    $(".amount-btn").click(function() {
        $(".amount-btn").removeClass("active");
        $(this).addClass("active");

        let baseAmount = parseFloat($(this).data('value'));
        let currencyrate = parseFloat("{{$rate}}");

        let convertedAmount = (baseAmount * currencyrate).toFixed(2);

        $("#customAmount").val(convertedAmount);
    });
});

$(document).on('submit', 'form#AddMoneyForm', function(event) {
    event.preventDefault();
    $('p.error_container').html("");
    $(".text-danger").html("");

    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    // var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';
    var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> {{ __("user_messages.loading") }}...';

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
            //     // Show loader
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

                $('.submit').attr('disabled', true);

                var orderid = response.data.unique_id;

                var url = "/myfatoorah/" + orderid + "?type=addMoneyinWallet";
                setTimeout(function() {
                    window.location.href = url;
                }, 2000);

            }
        },
        error: function(xhr) {
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




@endsection