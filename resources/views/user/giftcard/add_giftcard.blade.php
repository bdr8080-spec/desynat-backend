@extends('user.layout.app')

@section('content')

<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="{{route('user.gift_cards')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
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
                                <button 
                                    class="occasion-btn {{ $index === 0 ? 'active' : '' }}" 
                                    data-img="{{ $category['image'] }}"
                                    data-id="{{ $category['id'] }}">
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
                    <input type="hidden" name="gift_card_id" id="gift_card_id" value="{{ $giftCardCategory[0]['id'] }}">
                    <input type="hidden" name="notes" id="notes">
                    <input type="hidden" name="user_id" id="user_id" value="{{ auth()->id() }}">
                    <h6>Recipient Details</h6>
                    <div class="gift-pnl mt-4">
                    <h6>Recipient Details</h6>
                    <div class="form-group w-100 py-2">
                        <label>Name</label>
                        <input type="text" name="receiver_name" class="form-control pline-10" placeholder="Name">
                        <span class="text-danger error-text receiver_name_error"></span>
                    </div>
                    <div class="form-group w-100 py-2">
                        <label>Email ID</label>
                        <input type="text" name="receiver_email" class="form-control pline-10" placeholder="Email ID">
                        <span class="text-danger error-text receiver_email_error"></span>
                    </div>
                </div>
                </div>
                <div class="gift-pnl">
                    <h6>From</h6>
                    <div class="form-group w-100 py-2">
                        <label>Name</label>
                        <input type="text" name="sender_name" class="form-control pline-10" placeholder="Name">
                        <span class="text-danger error-text sender_name_error"></span>
                    </div>
                    <div class="form-group w-100 py-2">
                        <label>Email ID</label>
                        <input type="text" name="sender_email" class="form-control pline-10" placeholder="Email ID">
                        <span class="text-danger error-text sender_email_error"></span>
                    </div>
                    <div class="form-group w-100 py-2">
                        <label>Wish Message</label>
                        <textarea name="wish_message" rows="3" class="form-control pline-10" placeholder="Write here"></textarea>
                        <span class="text-danger error-text wish_message_error"></span>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-4 col-md-6">
            <div class="paycard">
                <div class="payment-option mb-3">
                    <label class="custom-radio">
                        <input type="radio" name="payment" id="onlinePayment" value="online" checked>
                        <span class="radio-mark"></span>
                        <div class="label-content">
                            <div class="title">Online Payment</div>
                        </div>
                    </label>
                </div>
                <div id="myfatoorah-box" style="display:none;">
                    <div id="myfatoorah-container"></div> 
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
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto vero sint, odit neque placeat natus voluptates assumenda, molestiae incidunt quos deserunt illum sequi. Laborum culpa quaerat officia debitis labore! Facere.</p>
                </div>
            </div>

        </div>

       

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).on("click", ".occasion-btn", function () {
        $(".occasion-btn").removeClass("active");
        $(this).addClass("active");
        let newImg = $(this).data("img");
        $("#occasionImage").attr("src", newImg);
        let giftCardId = $(this).data("id");
        $("#gift_card_id").val(giftCardId);
    });


    $(document).ready(function () {
        $(".amount-btn").click(function () {
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
        $(document).on("input", "#customAmount", function () {
            $("#amount").val($(this).val());
        });
    });
    
    $(document).ready(function () {
        let noteText = $(".note-bg p").text().trim();
        $("#notes").val(noteText);
    });


</script>

<script src="https://demo.myfatoorah.com/cardview/v3/cardview.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const onlineRadio = document.getElementById("onlinePayment");
    const mfBox = document.getElementById("myfatoorah-box");

    if (onlineRadio.checked) {
        loadMF();
    }

    onlineRadio.addEventListener("change", function () {
        if (this.checked) loadMF();
        else mfBox.style.display = "none";
    });

    function loadMF() {
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
</script>

<!-- buy guft card -->
<script>
$(document).ready(function () {
    $("#notes").val($(".note-bg p").text().trim());
    $(document).on("input", ".form-control, textarea", function () {
        $(this).siblings(".error-text").text("");
    });

    $(document).on("click", ".amount-btn", function () {
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

    $("#customAmount").on("input", function () {
        $(".amount-error").text("");
    });

    $("#giftCardForm").on("submit", function (e) {
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
            $("input[name='receiver_email']").siblings(".error-text").text("Please enter valid Receiver Email");
            hasError = true;
        }
        if (sender_name === "") {
            $("input[name='sender_name']").siblings(".error-text").text("Please enter Sender Name");
            hasError = true;
        }
        if (sender_email === "" || !emailRegex.test(sender_email)) {
            $("input[name='sender_email']").siblings(".error-text").text("Please enter valid Sender Email");
            hasError = true;
        }
        if (wish_message === "") {
            $("textarea[name='wish_message']").siblings(".error-text").text("Please enter Wish Message");
            hasError = true;
        }

        if (hasError) return;

        let formData = $(this).serialize();

        $.ajax({
            url: "{{ route('user.buyGiftCard') }}",
            method: "POST",
            data: formData,
            // beforeSend: function () {
            //     $(".paybtn-common").prop("disabled", true).text("Processing...");
            // },
            success: function (response) {
                // $(".paybtn-common").prop("disabled", false).text("Pay Now");

                if (response.status === "success") {
                    toastr.success(response.message);
                    setTimeout(function () {
                        window.location.href = "{{ route('user.gift_cards') }}";
                    }, 2000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function () {
                $(".paybtn-common").prop("disabled", false).text("Pay Now");
                toastr.error("Something went wrong. Please try again!");
            }
        });

    });

});
</script>



@endsection

