@include('dealer.layout.header')

<section class="section dashboard">
    <!-- <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <a class="title24 alink"> <i class="bi bi-chevron-left"></i>Details</a>
    </div> -->



    <div class="d-flex justify-content-between mt-4">
        <a class="title24 alink" href="{{route('seller.show_banner')}}"> <i class="bi bi-chevron-left"></i>Details</a>

        @if($single_banner->Admin_verify=='0')
        <span class="upper-text"> Pending </span>
        @elseif($single_banner->Admin_verify=='1')
        <span class="upper-text"> Confirmed </span>
        @else
        <span class="upper-text text-danger"> Rejected </span>
        @endif

    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="banner-box showb mb-4">
                <img src="{{$single_banner->upload_banner}}" alt="image">
            </div>

            <label class="banner-text">Banner position</label>

            @if($single_banner->banner_position=='1')

            <input type="text" class="form-control" value="Homepage - Top" />

            @elseif($single_banner->banner_position=='2')
            <input type="text" class="form-control" value="Home Banner" />
            @else
            <input type="text" class="form-control" value="category" />
            @endif

            <div class="d-flex justify-content-between mt-4">
                <h6 class="banner-texts">Select Duration</h6>
                <span class="banner-texts">Total days - {{$single_banner->total_days}}</span>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <label class="banner-text">From</label>
                    <input type="date" class="form-control mb-4" value="{{$single_banner->start_date}}" />
                </div>
                <div class="col-md-12">
                    <label class="banner-text">To</label>
                    <input type="date" class="form-control" value="{{$single_banner->end_date}}" />
                </div>
            </div>
        </div>


        @if($single_banner->Admin_verify=='1' && $single_banner->payment_status=='0')
        <div class="col-md-6">
            <h6>SELECT PAYMENT METHOD</h6>
            <div class="payment-box">
                <div class="check_radio">
                    <label class="radio-group">
                        <input type="radio" name="payment" id="onlinePayment" value="1" checked>
                        <span class="custom-radio"></span>
                        <img src="dealer/assets/img/credit-card.svg">
                        <span class="radio-label"> Online Payment</span>
                    </label>
                </div>
                <!-- 
                <div class="card-option">
                    <label class="radio-group">
                        <input type="radio" name="category_id">
                        <span class="custom-radio"></span>
                        <span class="radio-label"> XXXXXXXX2783</span>
                    </label>
                </div>

                <div class="card-option">
                    <label class="radio-group">
                        <input type="radio" name="category_id">
                        <span class="custom-radio"></span>
                        <span class="radio-label"> XXXXXXXX2783</span>
                    </label>
                </div>

                <button class="add-card" id="openAddCard">+ Add new card</button> -->
            </div>




        </div>

        @elseif($single_banner->Admin_verify=='1' && $single_banner->payment_status=='1')
        Payment is Paid
        @elseif($single_banner->Admin_verify=='1' && $single_banner->payment_status=='2')
        Payment Is rejected
        @endif

        <div class="dashboard-button d-flex mt-5 gap-5">
            <div class="row">
                <div class="col-lg-6">
                    <button type="button" class="btn total-outline w-100">Total Price
                    <strong>{{$single_banner->price}}KD</strong></button>
                </div>
                <div class="col-lg-6">
                        <form id="bannerBuyForm">
                        @csrf


                        @if($single_banner->Admin_verify=='1' && $single_banner->payment_status=='0')
                        <button type="submit" class="btn add-fillbtn w-100">Pay Now</button>

                        @endif
                    </form>
                </div>
            </div>
           
        </div>

</section>

<!-- OVERLAY -->
<div class="overlay" id="overlay"></div>

<!-- ADD CARD DRAWER -->
<div class="add-card-drawer" id="addCardDrawer">
    <div class="drawer-header">
        <h5>Add Card</h5>
        <span class="close-btn" id="closeDrawer">&times;</span>
    </div>
    <div class="drawer-body">

        <!-- CARD INPUT BOX -->
        <div class="card-form-box">
            <label>Card Holder Name</label>
            <input type="text" placeholder="Card Holder Name" />

            <label>Card Number</label>
            <input type="text" placeholder="Card Number" />

            <div class="row">
                <div class="col-8">
                    <label>Expiry Date</label>
                    <input type="text" placeholder="MM / YY" />
                </div>
                <div class="col-4">
                    <label>CVV</label>
                    <input type="password" placeholder="CVV" />
                </div>
            </div>
        </div>

        <!-- ✅ CHECKBOX OUTSIDE BOX -->
        <!-- <div class="save-card">
            <input type="checkbox" />
            <span>Save Card for Future</span>
        </div> -->

        <div class="check-field">
            <input type='checkbox' />
            <span>Save Card For Future </span>
        </div>

    </div>


    <div class="drawer-footer">
        <button class="pay-btn">Pay Now</button>
    </div>
</div>


<script>
// const openBtn = document.getElementById("openAddCard");
// const closeBtn = document.getElementById("closeDrawer");
// const drawer = document.getElementById("addCardDrawer");
// const overlay = document.getElementById("overlay");

// openBtn.addEventListener("click", () => {
//     drawer.classList.add("active");
//     overlay.classList.add("active");
// });

// closeBtn.addEventListener("click", closeDrawer);
// overlay.addEventListener("click", closeDrawer);

// function closeDrawer() {
//     drawer.classList.remove("active");
//     overlay.classList.remove("active");
// }





$("#bannerBuyForm").on("submit", function(e) {
    e.preventDefault();


    var paymentMethod = $('input[name="payment"]:checked').val();

    let formData = $(this).serialize();

    var orderid = "{{$single_banner->order_id}}";

    var url = "/myfatoorah/" + orderid + "?type=bannerBuy";
    setTimeout(function() {
        window.location.href = url;
    }, 2000);


});
</script>


@include('dealer.layout.custom_code');



@include('dealer.layout.footer');