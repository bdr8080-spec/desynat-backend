@extends('user.layout.app')

@section('content')


<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href=""> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
        <h3>Chat</h3>
    </div>

    <div class="main-content">
        <div class="row">
            <div class="col-lg-8">
                <div class="cart-panel position-relative">
                    <a href="order_details" class="link-content">
                        <div class="cart-card">
                            <div class="card-left mb-2 d-flex">
                                <div>
                                    <div class="chat-odr me-3">
                                        <img src="{{asset('user/assets/images/categorie1.png')}}" alt="Product"
                                            class="img-fluid">
                                    </div>
                                </div>

                                <div class="w-100">
                                    <div class="card-right d-flex w-100 justify-content-between">
                                        <div class="product-info">
                                            <h5 class="product-title">Mooei 3 Pcs set</h5>
                                            <div class="psize d-flex gap-4 mt-2">
                                                <span>Size: M</span>
                                                <span class="d-flex align-items-center gap-2">
                                                    Color:
                                                    <div class="colorbox"
                                                        style="width:15px;height:15px;border-radius:3px;background:#000;">
                                                    </div>
                                                </span>
                                                <span>Qnt: 1</span>
                                            </div>
                                            <h6 class="product-title mt-2"> 440 KD</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="time-pnl">
                    <div class="gift-pnl mt-4">
                        <div class="border-1">
                            <div class="accordion-item">
                                <h2 class="accordion-header mb-2">
                                    <button class="accordion-button">  View Request </button>
                                </h2>
                                <div class="p-0">
                                    <div class="giftinfo">
                                        <div>Total Quantity </div>
                                        <div>60 KD</div>
                                    </div>
                                    <div class="giftinfo">
                                        <div>Address</div>
                                        <div>Sector 132 Bismilla Apartment,Kuwait</div>
                                    </div>
                                    <div class="giftinfo">
                                        <div>Custom details</div>
                                        <div>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="gift-pnl mt-4">
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>Item Price </div>
                            <div>60 KD</div>
                        </div>
                        <div class="giftinfo">
                            <div>Shipping Fees </div>
                            <div>60 KD</div>
                        </div>
                        <div class="giftinfo">
                            <div>Tax</div>
                            <div>00.60 KD</div>
                        </div>
                        <hr>
                        <div class="giftinfo">
                            <div>Total Amount </div>
                            <div>6000 KD</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="paycard mb-4 py-3">
                    <div class="payment-option mb-3">
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
                    </div>
                </div>

                <button type="submit" class="customBtn">Place Order</button> 
               
            </div>

        </div>


    </div>

</div>






<div id="loader" style="display:none;">
    <div class="loader"></div>
</div>


@endsection