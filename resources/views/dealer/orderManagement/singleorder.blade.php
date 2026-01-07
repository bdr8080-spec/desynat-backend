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
        <a class="title24 alink" href="#"> <i class="bi bi-chevron-left"></i> Details</a>
        <div class="from-group-list">
            <div style="color:#16B364;">Confirmed</div>
            <!-- <div style="color:#FF5F1B;">Returned</div>
            <div style="color:#D53B36;">Cancelled</div>
            <div style="color:#FF5F1B;">Exchange</div> -->
        </div>
    </div>


    <div class="order-box border-radious-10 box-shadow mt-4">
        <div class="row">
            <div class="col">
                <div class="order-ic d-flex gap-2">
                    <img src="{{ asset('dealer') }}/assets/img/all-icons/order.svg" alt="icon" class="img-fluid">
                    <div class="order-cont">
                        <div class="title-light">Order ID</div>
                        <p>#98777897</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="order-ic">
                    <div class="order-cont">
                        <div class="title-light">Order Type</div>
                        <p>By Customer</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="order-ic">
                    <div class="order-cont">
                        <div class="title-light">Date & Time </div>
                        <p>21/01/2025 at 16:14 PM</p>
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
                        <div class="order-cont">
                            <p>Jimmy Wilson</p>
                            <div class="title-light">Phone:<span>+12345678958</span></div>
                        </div>
                    </div>
                    <div class="cust-deatils">
                        <div class="order-cont">
                            <div class="title-light">Shipping Location</div>
                            <p>Flat No. 123 New Delhi </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="order-box border-radious-10 box-shadow mt-4">
                <h6>Delivery Instruction</h6>
                <div class="cust-deatils-pnl">
                    <p class="font-15">lorem ipsum dolor sit amet, consectetur adipisici elit, sed do eiusmod temo
                        incididunt
                        labore et dolore magna aliqua. Ut enim ad lorem ipsum dolor sit amet, consectetur is adipisici
                        elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim adlorem ipsum
                        dolor sit amet, consectetur adipisici elit, sed do eiusmod tempor incididunt ut labore et dolore
                        magna aliqua. Ut enim ad</p>
                </div>
            </div>

            <div class="order-box border-radious-10 box-shadow mt-4">
                <h6>Payment Summary</h6>

                <div class="pay-sum">
                    <div class="summary-title-1">Transaction id</div>
                    <div class="summary-value">#455545</div>
                </div>
                <div class="pay-sum">
                    <div class="summary-title-1">Sub Total</div>
                    <div class="summary-value">1054.0 KD</div>
                </div>
                <div class="pay-sum">
                    <div class="summary-title-1">Coupon Applied</div>
                    <div class="summary-value">20 KD</div>
                </div>
                <div class="pay-sum">
                    <div class="summary-title-1">Shipping Charges</div>
                    <div class="summary-value">20 KD</div>
                </div>
                <div class="pay-sum">
                    <div class="summary-title-1">Total</div>
                    <div class="summary-value">105.5 KD</div>
                </div>
                <div class="pay-sum">
                    <div class="summary-title-1">Paid By Customer</div>
                    <div class="summary-value">105.5 KD</div>
                </div>
                <div class="pay-sum">
                    <div class="summary-title-1">Admin Commission</div>
                    <div class="summary-value">105.5 KD</div>
                </div>
            </div>

        </div>


        <div class="col-lg-6 col-md-6">
            <div class="order-light mt-4">
                <div class="order-p-pnl">
                    <div class="prodimg">
                        <figure>
                            <img src="{{ asset('dealer') }}/assets/img/reel-3.svg" alt="icon" class="img-fluid">
                        </figure>
                    </div>

                    <div class="w-100">
                        <div class="pay-sum">
                            <div class="summary-title-1">Nike Shirt</div>
                            <div class="summary-value">20.5 KD</div>
                        </div>
                        <div class="pay-sum">
                            <div class="summary-title-1">Size</div>
                            <div class="summary-value">M</div>
                        </div>
                        <div class="pay-sum">
                            <div class="summary-title-1">Color </div>
                            <div class="summary-value">Black</div>
                        </div>
                        <div class="pay-sum">
                            <div class="summary-title-1">Category </div>
                            <div class="summary-value">Men</div>
                        </div>
                        <div class="pay-sum">
                            <div class="summary-title-1">Quantity</div>
                            <div class="summary-value">20.5 KD * 4</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="order-box border-radious-10 box-shadow mt-4">
                <h6>Customer Ratings</h6>
                <div class="star-rating mt-1">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>

                </div>
                <div class="cust-deatils-pnl mt-4">
                    <h6>Review</h6>
                    <p class="font-15">lorem ipsum dolor sit amet, consectetur adipisici elit, sed do eiusmod temo
                        incididunt
                        labore et dolore magna aliqua. Ut enim ad lorem ipsum dolor sit amet, consectetur is adipisici
                        elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim adlorem ipsum
                        dolor sit amet, consectetur adipisici elit, sed do eiusmod tempor incididunt ut labore et dolore
                        magna aliqua. Ut enim ad</p>
                </div>
            </div>

            <div class="order-box border-radious-10 box-shadow mt-4">
                <h6>Return Details</h6>

                <div class="pay-sum">
                    <div class="summary-title-1">Return Id</div>
                    <div class="summary-value">#455545</div>
                </div>
                <div class="pay-sum">
                    <div class="summary-title-1">Requested on</div>
                    <div class="summary-value">27/10/2024 at 07:30PM</div>
                </div>
                <div class="pay-sum">
                    <div class="summary-title-1">Reason</div>
                    <div class="summary-value">Lorem </div>
                </div>

            </div>
            <div class="mt-4">

                <h6>Uploaded image</h6>
                <div class="order-box border-radious-10 box-shadow mt-4 d-flex justify-content-center">
                    <div class="prodimg">
                        <figure>
                            <img src="/dealer/assets/img/image33.png" alt="icon" class="img-fluid">
                        </figure>
                    </div>

                </div>
            </div>

              <div class="order-box border-radious-10 box-shadow mt-4">
                <h6>Exchange Details</h6>

                <div class="pay-sum">
                    <div class="summary-title-1">Exchange Id</div>
                    <div class="summary-value">#455545</div>
                </div>
                <div class="pay-sum">
                    <div class="summary-title-1">Exchange requested on</div>
                    <div class="summary-value">27/10/2024 at 07:30PM</div>
                </div>
                <div class="pay-sum">
                    <div class="summary-title-1">Reason</div>
                    <div class="summary-value">Lorem,</div>
                </div>
                <div class="pay-sum">
                    <div class="summary-title-1">Exchange size</div>
                    <div class="summary-value">M </div>
                </div>

            </div>
            <div class="dashboard-button d-flex mt-5 gap-5">
                <div class="from-group  w-100">
                    <select class="form-select form-control option width-50" aria-label="Default select example">
                        <option value="">Confirmed</option>
                        <option value="1"> Confirmed </option>
                        <option value="2"> Packed </option>
                        <option value="3"> Shipped </option>
                        <option value="4"> Exchange </option>
                    </select>
                </div>
                <button type="submit" class="btn add-fillbtn w-100">Update Status</button>
            </div>



        </div>


    </div>




</section>

<!-- OVERLAY -->
<div class="overlay" id="overlay"></div>



@include('dealer.layout.custom_code');



@include('dealer.layout.footer');