@extends('user.layout.app')

@section('content')

<style>
#myfatoorah-box {
    width: 100%;
    height: 400px;
}
</style>

<style>
#loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.loader {
    border: 8px solid #f3f3f3;
    border-top: 8px solid #a97c35ff;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>

<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="{{route('user.gift_cards')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}"
                class="img-fluid"></a>
        <h3>Add Gift Card</h3>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-6">
            <div class="giftcard-type">
                <div class="row">
                    <div class="col-lg-7 col-md-6">
                        <h6>Select Occasion Type</h6>
                        <div class="occasion-buttons">
                            @foreach($giftCardCategory as $index => $category)
                            <button class="occasion-btn {{ $index === 0 ? 'active' : '' }}"
                                data-img="{{ $category['image'] }}" data-id="{{ $category['id'] }}">
                                {{ $category['name_english'] }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <div class="giftoff">
                            <img id="occasionImage" src="{{ $giftCardCategory[0]['image'] }}" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="gift-pnl">
                    <h6>Choose Amount</h6>
                    <div class="occasion-buttons">
                        <button type="button" class="amount-btn active" data-value="50">50 KD</button>
                        <button type="button" class="amount-btn" data-value="100">100 KD</button>
                        <button type="button" class="amount-btn" data-value="200">200 KD</button>
                        <button type="button" class="amount-btn" data-value="500">500 KD</button>
                        <button type="button" class="amount-btn" data-value="">Enter Amount</button>
                    </div>

                    <div class="form-group w-100 py-2 amountpnl" style="display:none;">
                        <input type="text" class="form-control pline-10" id="customAmount" placeholder="Enter Amount">
                        <span class="text-danger error-text amount-error"></span>
                    </div>
                </div>

                <form id="giftCardForm">
                    @csrf
                    <div class="gift-pnl mt-4">
                        <input type="hidden" name="amount" id="amount" value="50">
                        <input type="hidden" name="gift_card_id" id="gift_card_id"
                            value="{{ $giftCardCategory[0]['id'] }}">
                        <input type="hidden" name="notes" id="notes">
                        <input type="hidden" name="user_id" id="user_id" value="{{ auth()->id() }}">
                        <!-- <h6>Recipient Details</h6> -->
                        <div class="gift-pnl mt-4">
                            <h6>Recipient Details</h6>
                            <div class="form-group w-100 py-2">
                                <label>Name</label>
                                <input type="text" name="receiver_name" class="form-control pline-10"
                                    placeholder="Enter Name" oninput="this.value = this.value.replace(/^\s+/,'');">
                                <span class="text-danger error-text receiver_name_error"></span>
                            </div>
                            <div class="form-group w-100 py-2">
                                <label>Email ID</label>
                                <input type="text" name="receiver_email"
                                    oninput="this.value = this.value.replace(/\s+/g, '');" class="form-control pline-10"
                                    placeholder="Enter Email ID">
                                <span class="text-danger error-text receiver_email_error"></span>
                            </div>

                            <div class="form-group position-relative py-2 mobileInput">
                                <label>WhatsApp Number</label>
                                <div class="d-flex align-items-center mt-1">
                                    <div class="">
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-light border dropdown-toggle d-flex align-items-center justify-content-between w-100 form-control pline-10"
                                                type="button" id="countryDropdown"
                                                data-bs-toggle="dropdown" aria-expanded="false">

                                                <span id="selected-flag">
                                                    {{ old('country_flag', $country[0]->flag1) }}
                                                </span>
                                                <span id="selected-code" class="ms-2">
                                                    {{ old('country_code', $country[0]->dial_code) }}
                                                </span>
                                            </button>

                                            <ul class="dropdown-menu p-2 newcountrybox" aria-labelledby="countryDropdown">
                                                @foreach ($country as $index => $item)
                                                    <li>
                                                        <label
                                                            class="dropdown-item d-flex align-items-center gap-2 country-option"
                                                            style="cursor: pointer;">
                                                            <input type="radio" name="country_code"
                                                                value="{{ $item->dial_code }}"
                                                                data-flag="{{ $item->flag1 }}"
                                                                data-name="{{ $item->name }}"
                                                                class="country-radio"
                                                                {{ old('country_code', $country[0]->dial_code) == $item->dial_code ? 'checked' : '' }}
                                                                hidden>
                                                            <div width="25" height="16">
                                                                <span>{{ $item->flag1 }} {{ $item->dial_code }}
                                                                    ({{ $item->name }})
                                                                </span>
                                                            </div>

                                                        </label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="w-100">
                                        <input type="number" class="form-control pline-10" placeholder="Enter WhatsApp Number" name="" maxlength="15" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15)">
                                    </div>
                                </div>
                            </div>
                            

                        </div>
                    </div>

                    <div class="gift-pnl mt-3">
                        <h6>From</h6>
                        <div class="form-group w-100 py-2">
                            <label>Name</label>
                            <input type="text" name="sender_name" oninput="this.value = this.value.replace(/^\s+/,'');"
                                class="form-control pline-10" placeholder="Enter Name">
                            <span class="text-danger error-text sender_name_error"></span>
                        </div>
                        <div class="form-group w-100 py-2">
                            <label>Email ID</label>
                            <input type="text" name="sender_email"
                                oninput="this.value = this.value.replace(/\s+/g, '');" class="form-control pline-10"
                                placeholder="Enter Email ID">
                            <span class="text-danger error-text sender_email_error"></span>
                        </div>
                        <div class="form-group w-100 py-2">
                            <label>Wish Message</label>
                            <textarea name="wish_message" oninput="this.value = this.value.replace(/^\s+/,'');" rows="3"
                                class="form-control pline-10" placeholder="Write here"></textarea>
                            <span class="text-danger error-text wish_message_error"></span>
                        </div>
                    </div>
            </div>
        </div>


        <div class="col-lg-4 col-md-6">
            <div class="paycard">
                <div class="payment-option mb-3">
                    <label class="custom-radio">
                        <input type="radio" name="payment" id="onlinePayment" value="1" checked>
                        <span class="radio-mark"></span>
                        <div class="label-content">
                            <div class="title">Online Payment</div>
                        </div>
                    </label>
                </div>
                <div id="myfatoorah-box" style="display:none;">
                    <div id="myfatoorah-container"></div>
                </div>

                <input type="hidden" id="WalletBalance" value="{{$walletBalance}}">

                <div class="payment-option mb-3">
                    <label class="custom-radio mb-3">
                        <input type="radio" name="payment" value="2">
                        <span class="radio-mark"></span>
                        <div class="label-content d-flex gap-3">
                            <img src="{{ asset('user/assets/images/wallet.svg') }}" class="img-fluid">
                            <div class="title">
                                In -App Wallet
                                <div class="small-14">Available Balance : {{$walletBalance}} KD</div>
                            </div>
                        </div>
                    </label>
                </div>
                <!-- <div class="payment-option mb-3">
                    <label class="custom-radio">
                        <input type="radio" name="payment" >
                        <span class="radio-mark"></span>
                        <div class="label-content">
                            <div class="title">In-App Wallet</div>
                            <div class="balance">Available Balance : 349 KD</div>
                        </div>
                    </label>
                </div>
                <div class="payment-option">
                    <label class="custom-radio">
                        <input type="radio" name="payment">
                        <span class="radio-mark"></span>
                        <div class="label-content d-flex gap-2">
                            <span class="cod-box">COD</span>
                            <div class="title">Cash On Delivery</div>
                        </div>
                    </label>
                </div> -->
            </div>

            <div class="cmn-btn mt-4">
                <button type="submit" class="btn paybtn-common w-100">Pay Now</button>
            </div>
            </form>

            <div class="gift-pnl mt-4">
                <h6>Note</h6>
                <div class="note-bg">
                    <!-- <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto vero sint, odit neque
                        placeat natus voluptates assumenda, molestiae incidunt quos deserunt illum sequi. Laborum culpa
                        quaerat officia debitis labore! Facere.</p> -->
                        <textarea rows="4" class="form-control" id="noteTextarea"></textarea>
                </div>
            </div>

        </div>



    </div>

</div>

<div id="loader" style="display:none;">
    <div class="loader"></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).on("click", ".occasion-btn", function() {
    $(".occasion-btn").removeClass("active");
    $(this).addClass("active");
    let newImg = $(this).data("img");
    $("#occasionImage").attr("src", newImg);
    let giftCardId = $(this).data("id");
    $("#gift_card_id").val(giftCardId);
});


$(document).ready(function() {
    $(".amount-btn").click(function() {
        $(".amount-btn").removeClass("active");
        $(this).addClass("active");
        let btnText = $(this).text().trim();
        if (btnText === "Enter Amount") {
            $(".amountpnl").show();
            $("#customAmount").val("");
            $("#amount").val("");
        } else {
            $(".amountpnl").hide();
            let value = btnText.split(" ")[0];
            $("#amount").val(value);
        }
    });
    $(document).on("input", "#customAmount", function() {
        $("#amount").val($(this).val());
    });
});

$(document).ready(function () {
    $('#noteTextarea').on('input', function () {
        $('#notes').val($(this).val());
    });
});
</script>

<!-- <script src="https://demo.myfatoorah.com/cardview/v3/cardview.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const onlineRadio = document.getElementById("onlinePayment");
    const mfBox = document.getElementById("myfatoorah-box");

    if (onlineRadio.checked) {
    //console.log(123);
        loadMF();
    }

    onlineRadio.addEventListener("change", function () {
        if (this.checked) loadMF();
        else mfBox.style.display = "none";
    });

    function loadMF() {
         //console.log(456);
        mfBox.style.display = "block";

        // Ensure the session ID is being passed correctly
        let sessionId = "{{ $sessionId }}";
        console.log("Loaded Session ID:", sessionId);

        if (!sessionId) {
            console.error("ERROR: MyFatoorah session ID missing");
            return;
        }

        // Load the card view UI
        MyFatoorah.init({
            sessionId: sessionId,
            countryCode: "KW",
            cardViewId: "myfatoorah-container",
            onPaymentRequest: function () {
                console.log("Submitting payment...");
            },
            onError: function (error) {
                console.error("MyFatoorah Error:", error);
            }
        });
    }
});
</script> -->

<!-- <script src="https://demo.myfatoorah.com/cardview/v3/cardview.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> -->
<!-- <script src="https://portal.myfatoorah.com/payment/v1/session.js"></script> -->
<!-- <script src="https://portal.myfatoorah.com/cardview/v2/cardview.js"></script> -->

<script src="https://demo.myfatoorah.com/payment/v1/session.js"></script>


<script>
document.addEventListener("DOMContentLoaded", function() {
    const onlineRadio = document.getElementById("onlinePayment");
    const mfBox = document.getElementById("myfatoorah-box");
    const mfContainer = document.getElementById("myfatoorah-container");

    // Check if the radio button is checked on page load
    if (onlineRadio.checked) {
        console.log("Radio button is already checked, loading MyFatoorah...");
        loadMF();
    }

    // Add event listener to the radio button to show/hide the payment form
    onlineRadio.addEventListener("change", function() {
        if (this.checked) {
            console.log("Radio button checked, showing MyFatoorah...");
            loadMF();
        } else {
            console.log("Radio button unchecked, hiding MyFatoorah...");
            mfBox.style.display = "none"; // Hide MyFatoorah box when unchecked
        }
    });

});
</script>


<!-- buy guft card -->
<script>
$(document).ready(function() {
    $("#notes").val($(".note-bg p").text().trim());
    $(document).on("input", ".form-control, textarea", function() {
        $(this).siblings(".error-text").text("");
    });

    $(document).on("click", ".amount-btn", function() {
        $(".amount-btn").removeClass("active");
        $(this).addClass("active");

        let value = $(this).data("value");

        if (value === "") {
            $(".amountpnl").show();
            $("#amount").val(""); // clear hidden input
        } else {
            $(".amountpnl").hide();
            $("#customAmount").val(""); // clear custom input
            $("#amount").val(value); // set hidden input
            $(".amount-error").text(""); // clear error
        }
    });

    $("#customAmount").on("input", function() {
        $(".amount-error").text("");
    });

    $("#giftCardForm").on("submit", function(e) {
        e.preventDefault();

        $(".error-text").text("");

        let hasError = false;

        let activeBtn = $(".amount-btn.active");
        let amount = activeBtn.data("value");

        if (amount === "") {
            let customAmount = $("#customAmount").val().trim();
            if (customAmount === "" || isNaN(customAmount) || Number(customAmount) <= 0) {
                $(".amount-error").text("Please Enter Amount");
                hasError = true;
            } else {
                $("#amount").val(customAmount); // set hidden input
            }
        }

        let receiver_name = $("input[name='receiver_name']").val().trim();
        let receiver_email = $("input[name='receiver_email']").val().trim();
        let sender_name = $("input[name='sender_name']").val().trim();
        let sender_email = $("input[name='sender_email']").val().trim();
        let wish_message = $("textarea[name='wish_message']").val().trim();

        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (receiver_name === "") {
            $("input[name='receiver_name']").siblings(".error-text").text("Please enter Receiver Name");
            hasError = true;
        }
        if (receiver_email === "" || !emailRegex.test(receiver_email)) {
            $("input[name='receiver_email']").siblings(".error-text").text(
                "Please Enter Valid Email Id ");
            hasError = true;
        }
        if (sender_name === "") {
            $("input[name='sender_name']").siblings(".error-text").text("Please enter Sender Name");
            hasError = true;
        }
        if (sender_email === "" || !emailRegex.test(sender_email)) {
            $("input[name='sender_email']").siblings(".error-text").text(
                "Please Enter Valid Email Id ");
            hasError = true;
        }
        if (wish_message === "") {
            $("textarea[name='wish_message']").siblings(".error-text").text(
                "Please enter Wish Message");
            hasError = true;
        }

        if (hasError) return;


        var paymentMethod = $('input[name="payment"]:checked').val();



        if (paymentMethod == 2) {
            var wallet_Amount = $('#WalletBalance').val();
            var PayAmount = amount;
            if (wallet_Amount < PayAmount) {
                console.log("Wallet Amount is Low Please Choose Another Method");
                toastr.error('Wallet Amount is Low Please Choose Another Method');

                return false;
            }
        }

        let formData = $(this).serialize();

        $.ajax({
            url: "{{ route('user.buyGiftCard') }}",
            method: "POST",
            data: formData,
            // beforeSend: function () {
            //     $(".paybtn-common").prop("disabled", true).text("Processing...");
            // },
            success: function(response) {
                // $(".paybtn-common").prop("disabled", false).text("Pay Now");

                if (response.status === "success") {
                    $('#loader').show();

                    // toastr.success(response.message);


                    if (paymentMethod == 1) {
                   // console.log('123');

                        var orderid = response.data.data.order_id;

                        var url = "/myfatoorah/" + orderid + "?type=giftCard";
                        setTimeout(function() {
                            window.location.href = url;
                        }, 2000);
                    }


                    if (paymentMethod == 2) {

                        var orderid = response.data.data.order_id;

                        // var url = "{{ route('user.giftcard_complete_Payment') }}" +
                        //              "?order_id=" + orderid + "&type=giftCard";
                        // setTimeout(function() {
                        //     window.location.href = url;
                        // }, 2000);
                        toastr.success('Payment Paid Successfully');

                        var url = "{{ route('user.giftcard_complete_Payment') }}" +
                                "?order_id=" + orderid + "&type=giftCard";

                        setTimeout(function () {
                            window.location.href = url;
                        }, 2000);

                    }






                } else {
                    toastr.error(response.message);
                }
            },
            error: function() {
                $(".paybtn-common").prop("disabled", false).text("Pay Now");
                toastr.error("Something went wrong. Please try again!");
            }
        });

    });

});
</script>

<script>
window.addEventListener('pageshow', function(event) {
    if (event.persisted) {
        // Reload the page if it's loaded from the back/forward cache
        window.location.reload(true);
    }
});

// Optional: for older browsers
if (performance.navigation.type === 2) {
    window.location.reload(true);
}


// When a user selects a country code
$(document).ready(function() {
    $(document).on('click', '.country-option', function() {
        let radio = $(this).find('.country-radio');
        let flag = radio.data('flag');
        let code = radio.val();
        let name = radio.data('name');

        // Update the flag and code shown on the button
        $('#selected-flag').html(flag);
        $('#selected-code').text(code);

        // Set the radio input as checked
        radio.prop('checked', true);

        // Close the dropdown (Bootstrap 5)
        $('#countryDropdown').dropdown('hide');
    });
});



</script>



@endsection