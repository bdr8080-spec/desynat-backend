@extends('user.layout.app')

@section('content')


<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="{{route('dashboard')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
        <h3>My Wallet</h3>
    </div>

    <div class="main-content categoryDetail">
        <div class="cart-panel position-relative">
            <div class="gift-pnl mt-0">
                <h6>Wallet Transactions</h6>

                <div class="border-1 mb-3 mt-3 bg-multiple p-3">
                    <div class="total-w d-flex justify-content-between">
                        <div class="total-balance">
                            <div class="balance-title">Total Balance</div>
                            <div class="walletic d-flex gap-2 align-items-center mt-3">
                                <div class="wallet-ic">
                                    <img src="{{asset('user/assets/images/wallet-ic.svg')}}" class="img-fluid">
                                </div>
                                <h5>{{ rtrim(rtrim(number_format($walletData['wallet_balance'], 2, '.', ''), '0'), '.') }}
                                    KD</h5>
                            </div>
                        </div>
                        <div class="total-balance-2">
                            <a href="{{route('user.addWalletMoney')}}" class="btn btn-top">Top-up Wallet</a>
                            <button type="button" class="btn btn-top" data-bs-target="#RedeemModal"
                                data-bs-toggle="modal">Redeem Gift Card</button>
                        </div>
                    </div>

                </div>

                @if($walletData['history']->count())
                @foreach($walletData['history'] as $history)
                <div class="border-1 mb-3 mt-3">
                    <div class="giftinfo">
                        @php
                        $isCredit = in_array($history->type, [1, 3]);
                        @endphp

                        <div style="color: {{ $isCredit ? '#48DB8F' : '#FF6B6B' }}">
                            @if($history->type == 1)
                            Credit
                            @elseif($history->type == 3)
                            Reedem Gift Card
                            @else
                            Debit
                            @endif
                        </div>

                        <div>
                            {{ $isCredit ? '+' : '-' }}
                            {{ rtrim(rtrim(number_format($history->amount, 2), '0'), '.') }} KD
                        </div>
                    </div>

                    <div class="giftinfo">
                        <div>Transaction Id</div>
                        <div>{{ $history->transaction_id }}</div>
                    </div>

                    <div class="giftinfo">
                        <div>Credited On</div>
                        <div>
                            {{ \Carbon\Carbon::parse($history->created_at)->timezone('Asia/Kolkata')->format('d/m/Y, h:i A') }}
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="text-center text-muted mt-3">
                    No wallet history found
                </div>
                @endif

            </div>

        </div>

    </div>

</div>




<!-- Success Modal -->
<div class="modal fade" id="RedeemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Gift Card </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="ReddemgiftCardMoney" method="post" action="{{route('user.redeemgiftCardinUser')}}">
                @csrf

                <div class="modal-body">
                    <h5>Enter Gift Card Deatils </h5>
                    <div class="form-group w-100 py-2">
                        <label>16 Digit Gift Card Number </label>
                        <input type="text" class="form-control pline-10" name="giftCardNo"
                            placeholder="16 Digit Gift Card Number ">
                        <p class="text-danger" id="error-giftCardNo"></p>
                    </div>

                    <div class="form-group w-100 py-2">
                        <label>Enter PIN </label>
                        <input type="text" class="form-control pline-10" name="giftCardPin" placeholder="Enter PIN">
                        <p class="text-danger" id="error-giftCardPin"></p>
                    </div>

                    <div class="cmn-btn mt-4">
                        <button type="submit" class="btn paybtn-common w-100">Redeem </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>



<div id="loader" style="display:none;">
    <div class="loader"></div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).on('submit', 'form#ReddemgiftCardMoney', function(event) {
    event.preventDefault();
    $('p.error_container').html("");
    $(".text-danger").html("");

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
                toastr.success(response.message);

                setTimeout(function() {
                    window.location.href = window.location.href;
                }, 2000);

            }
        },
        error: function(xhr) {
            $('.text-danger').empty(); // Clear previous errors

            if (xhr.status == 400) {

                toastr.error(xhr.responseJSON.message);

            } else {

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

            }

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