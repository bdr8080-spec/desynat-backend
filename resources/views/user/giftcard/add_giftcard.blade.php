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
                            <button class="occasion-btn active" data-img="{{asset('user/assets/images/gift/gift1.svg')}}">Birthday</button>
                            <button class="occasion-btn" data-img="{{asset('user/assets/images/gift/gift2.svg')}}">Anniversary</button>
                            <button class="occasion-btn" data-img="{{asset('user/assets/images/gift/gift3.svg')}}">Diwali</button>
                            <button class="occasion-btn" data-img="{{asset('user/assets/images/gift/gift1.svg')}}">Ramadan</button>
                            <button class="occasion-btn" data-img="{{asset('user/assets/images/gift/gift2.svg')}}">Wedding</button>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <div class="giftoff">
                            <img id="occasionImage" src="{{asset('user/assets/images/gift/gift1.svg')}}" class="img-fluid">
                        </div>
                    </div>
                </div>

                <div class="gift-pnl">
                    <h6>Choose Amount </h6>
                    <div class="occasion-buttons">
                        <button class="amount-btn active">499 KD</button>
                        <button class="amount-btn">99 KD</button>
                        <button class="amount-btn">100 KD</button>
                        <button class="amount-btn">150 KD</button>
                        <button class="amount-btn">Enter Amount</button>
                    </div>
                    <div class="form-group w-100 py-2 amountpnl" style="display:none;">
                        <input type="text" class="form-control pline-10" placeholder="Enter Amount">
                    </div>
                </div>

                <div class="gift-pnl mt-4">
                    <h6>Recipient Details</h6>
                    <div class="form-group w-100 py-2">
                        <label>Name</label>
                        <input type="text" class="form-control pline-10" placeholder="Name">
                    </div>
                    <div class="form-group w-100 py-2">
                        <label>Email ID</label>
                        <input type="text" class="form-control pline-10" placeholder="Email ID">
                    </div>
                </div>
                <div class="gift-pnl">
                    <h6>From</h6>
                    <div class="form-group w-100 py-2">
                        <label>Name</label>
                        <input type="text" class="form-control pline-10" placeholder="Name">
                    </div>
                    <div class="form-group w-100 py-2">
                        <label>Wish Message</label>
                        <textarea type="text" rows="3" class="form-control pline-10" placeholder="Write here"></textarea>
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
                <a href="#" class="btn paybtn-common w-100">Pay Now</a>
            </div>

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
    });

    $(document).ready(function () {
        $(".amount-btn").click(function () {
            $(".amount-btn").removeClass("active"); 
            $(this).addClass("active"); // add active to clicked

            if ($(this).text().trim() === "Enter Amount") {
                $(".amountpnl").show();  // show input box
            } else {
                $(".amountpnl").hide();   // hide input box
            }
        });
    });

</script>




@endsection

