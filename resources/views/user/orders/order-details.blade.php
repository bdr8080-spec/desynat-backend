@extends('user.layout.app')

@section('content')



<div class="customContainer common-padding">
    <div class="main-content">
        <div class="row">

            {{-- LEFT SIDE CART --}}
            <div class="col-lg-8">
                <div class="common-title d-flex justify-content-between align-items-center gap-3 mb-4">
                    <div class="d-flex gap-3">
                        <a href="{{route('dashboard')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
                        <div class="order-subtitle">
                            <h3>#003242</h3>
                            <p>Place on 02/02/2025 at 10:00pm</p>
                        </div>
                    </div>
                    <div class="btn-outline1 btn-ongoing">Ongoing</div>
                </div>   

                <div class="cart-panel">
                    <div class="cart-card">
                        <div class="card-left mb-2 d-flex">
                            <div>
                                <div class="cart-products me-3">
                                    <img src="{{asset('user/assets/images/categorie1.png')}}" alt="Product"
                                 class="img-fluid">
                                </div>
                            </div>

                            <div class="card-right d-flex w-100 justify-content-between">
                                <div class="product-info">
                                    <h5 class="product-title"> Mooei Pcs set</h5>
                                    <div class="psize d-flex gap-4">
                                        <span>Size:M</span>

                                        <span class="d-flex align-items-center gap-2">
                                            Color:
                                            <div class="colorbox" style="width:15px;height:15px;border-radius:3px;
                                                    background: #000;">
                                            </div>
                                        </span>

                                        <span>Qnt: 100</span>
                                    </div>

                                    {{-- Price --}}
                                    <div class="price">
                                        <span class="price-current">
                                            210 KD
                                        </span>
                                        <span class="price-old">
                                            239 KD
                                        </span>
                                        <span class="discount ms-2"></span>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                
                {{-- BILLING DETAILS --}}
                <!-- <div class="gift-pnl mt-4">
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>Total Quantity</div>
                            <div>210</div>
                        </div>
                        <div class="giftinfo">
                            <div>Address </div>
                            <div>Sectore 63,Bismilla Apartment Kuwait</div>
                        </div>
                        <div class="giftinfo">
                            <div>Custom details</div>
                            <div>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</div>
                        </div>
                    </div>
                </div> -->

                {{-- DELIVERY instruction --}}
                <div class="gift-pnl mt-4">
                    <h6>Delivery instruction</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio, deserunt? Quam unde officiis tenetur officia, accusamus,</p>
                        </div>
                    </div>
                </div>
                {{-- Shipping address --}}
                <div class="gift-pnl mt-4">
                    <h6>Shipping Address</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <p>Sectore 63,Bismilla Apartment Kuwait</p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- RIGHT SIDE --}}

            <div class="col-lg-4">

                <h6>Billing Details</h6>
                <div class="gift-pnl mt-0">
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>Total MRP</div>
                            <div>8000 KD</div>
                        </div>
                        <div class="giftinfo">
                            <div>Shipping Free </div>
                            <div>80 KD</div>
                        </div>
                        <div class="giftinfo">
                            <div>Tax</div>
                            <div>10.00 KD</div>
                        </div>
                        <div class="giftinfo">
                            <div>Total Amount</div>
                            <div>80900 KD</div>
                        </div>
                    </div>
                </div>

                
                <div class="gift-pnl mt-3">

                    <h6>Paid by</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>8000 KD</div>
                            <div>Paid By Card</div>
                        </div>
                    </div>
                </div>
                

                <div class="mt-4">
                    <button type="submit" id="placeOrderBtn" class="customBtn mb-3">
                        Cancel Order
                    </button>
                </div>

            </div>

        </div>


    </div>

</div>







@endsection

