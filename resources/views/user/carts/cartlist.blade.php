@extends('user.layout.app')

@section('content')

<style>
    
</style>

<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="{{route('user.gift_cards')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}"
                class="img-fluid"></a>
        <h3>My Bag</h3>
    </div>

    <div class="main-content">
        <div class="row">
            <div class="col-lg-8">
                <div class="cart-panel">
                    <div class="cart-card">
                        <div class="card-left mb-2">
                            <div>
                                <div class="cart-products">
                                    <img src="{{ asset('user/assets/images/banner.svg') }}" alt="Product" class="product-img" />
                                </div>
                            </div>
                            <div class="card-right d-flex w-100 justify-content-between">
                                <div class="product-info">
                                    <h5 class="product-title">Mooei 3 Pcs set</h5>
                                    <div class="psize d-flex gap-4">
                                        <span>Size: M</span>
                                        <span>Color:</span>
                                        <span>Qnt:1</span>
                                    </div>
                                    <div class="price">
                                        <span class="price-current">239 KD</span>
                                        <span class="price-old">239 KD</span>
                                    </div>
                                </div>
                                <div class="qty-box d-flex gap-4">
                                    <button class="qty-btn">−</button>
                                    <span class="qty-number">01</span>
                                    <button class="qty-btn">+</button>
                                </div>
                            </div>
                        </div>
                        <p class="return-text mb-2">14 days return available</p>
                        <div class="d-flex justify-content-between">
                            <p class="delivery-label mb-2">Delivery by</p>
                            <p class="delivery-date mb-2">12/12/2024</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="seller d-flex gap-4 mb-2"><span>Seller</span> Sharukh Khan</p>
                            <a href="#" class="moreshop">Shop More </a>
                        </div>
                    </div>
                </div>

                <div class="gift-pnl mt-4">
                    <h6>Delivering Address</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>Saleem Raza- 142 Block D, Noida</div>
                            <a href="#" class="moreshop">Change </a>
                        </div>
                    </div>
                </div>

                <div class="gift-pnl mt-4">
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>Apply PromoCode</div>
                            <a href="#" class="moreshop">Apply </a>
                        </div>
                    </div>
                </div>
                <div class="gift-pnl mt-4">
                    <h6> Billing Details</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>Total MRP</div>
                            <div>400KD</div>
                        </div>
                        <div class="giftinfo">
                            <div>Discount on MRP</div>
                            <div>400KD</div>
                        </div>
                        <div class="giftinfo">
                            <div>Coupon Discount (FIR20)</div>
                            <div>400KD</div>
                        </div>
                        <div class="giftinfo">
                            <div>Shipping Fee</div>
                            <div>400KD</div>
                        </div>
                        <div class="giftinfo">
                            <div>TAX (if any)</div>
                            <div>400KD</div>
                        </div>
                        <div class="giftinfo">
                            <div>Total Amount </div>
                            <div>400KD</div>
                        </div>
                    </div>
                </div>
                <p class="return-text mb-2">You will save 100 KD on this</p>

            </div>

            <div class="col-lg-4"></div>
        </div>



    </div>
</div>



@endsection