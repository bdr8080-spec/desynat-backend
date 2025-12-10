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
        <!-- <div class="row">
            <div class="col-lg-8">
                <div class="cart-panel">
                    <div class="cart-card">
                        <div class="card-left mb-2">
                            <div>
                                <div class="cart-products">
                                    <img src="{{ asset('user/assets/images/banner.svg') }}" alt="Product" class="img-fluid" />
                                </div>
                            </div>
                            <div class="card-right d-flex w-100 justify-content-between">
                                <div class="product-info">
                                    <h5 class="product-title">Mooei 3 Pcs set</h5>
                                    <div class="psize d-flex gap-4">
                                        <span>Size: M</span>
                                        <span class="d-flex g-3 align-items-center">Color:<div class="colorbox bg-dark"></div></span>
                                        <span>Qnt:1</span>
                                    </div>
                                    <div class="price">
                                        <span class="price-current">239 KD</span>
                                        <span class="price-old">239 KD</span>
                                    </div>
                                </div>
                                <div class="qty-box d-flex gap-4">
                                    <button class="qty-btn" onclick="decreaseQty()">−</button>
                                    <span class="qty-number" id="qtyNumber">01</span>
                                    <button class="qty-btn" onclick="increaseQty()">+</button>
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
                            <a href="#" class="moreshop">Shop More <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="gift-pnl mt-4">
                    <h6>Delivering Address</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>Saleem Raza- 142 Block D, Noida</div>
                            <a href="#" class="moreshop">Change <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="gift-pnl mt-4">
                    <div class="border-1">
                        <div class="giftinfo">
                            <div> <img src="{{ asset('user/assets/images/ticket-01.svg') }}" alt="Product" class="img-fluid" /> Apply PromoCode</div>
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#promoModal" class="moreshop">Apply <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="gift-pnl mt-4">
                    <h6> Billing Details</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>Total MRP</div>
                            <div>400 KD</div>
                        </div>
                        <div class="giftinfo">
                            <div>Discount on MRP</div>
                            <div class="red-color">400 KD</div>
                        </div>
                        <div class="giftinfo">
                            <div>Coupon Discount (FIR20)</div>
                            <div class="red-color">400 KD</div>
                        </div>
                        <div class="giftinfo">
                            <div>Shipping Fee</div>
                            <div>400 KD</div>
                        </div>
                        <div class="giftinfo">
                            <div>TAX (if any)</div>
                            <div>400 KD</div>
                        </div>
                        <div class="giftinfo">
                            <div>Total Amount </div>
                            <div>400 KD</div>
                        </div>
                    </div>
                </div>
                <p class="return-text mb-2">You will save 100 KD on this</p>
            </div>

            <div class="col-lg-4">
                <div class="cart-panel">
                    
                </div>
                <div class="gift-pnl mt-4">
                    <div class="border-1">
                        <div class="giftinfo">
                            <div> <img src="{{ asset('user/assets/images/gift-ic.svg') }}" alt="Product" class="img-fluid" /> Have a GIft Card</div>
                            <a href="javascript:void(0)" class="moreshop" data-bs-toggle="modal" data-bs-target="#giftModal">Apply Gift Card <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="customBtn mb-3" id="loginButtom">Place Order </button>
                </div>

            </div>
        </div> -->
        <div class="row">
            <div class="col-lg-8">
                <div class="cart-panel">
                    @foreach($cartData['cart_data'] as $item)
                    <div class="cart-card mb-4">
                        <div class="card-left mb-2 d-flex">

                            {{-- Product Image --}}
                            <div class="cart-products me-3">
                                <img src="{{ $item->product_variants->variant_image[0] }}"
                                    alt="Product"
                                    class="img-fluid">
                            </div>

                            {{-- Product Details --}}
                            <div class="card-right d-flex w-100 justify-content-between">

                                <div class="product-info">

                                    {{-- Product Name --}}
                                    <h5 class="product-title">
                                        {{ $item->product->name }}
                                    </h5>

                                    {{-- Size, Color, Quantity --}}
                                    <div class="psize d-flex gap-4">

                                        <span>Size: {{ $item->product_variants->size->name ?? '-' }}</span>

                                        <span class="d-flex align-items-center gap-2">
                                            Color:
                                            <div class="colorbox"
                                                style="width:15px;height:15px;border-radius:3px;
                                                background: {{ $item->product_variants->color->hex_code }};">
                                            </div>
                                        </span>

                                        <span>Qnt: {{ $item->quantity }}</span>

                                    </div>

                                    {{-- Price --}}
                                    <div class="price">
                                        <span class="price-current">
                                            {{ $item->product_variants->final_price }} KD
                                        </span>

                                        @if(!empty($item->product_variants->actual_price))
                                        <span class="price-old">
                                            {{ $item->product_variants->actual_price }} KD
                                        </span>
                                        @endif
                                    </div>

                                </div>

                                {{-- Quantity buttons (front-end only now) --}}
                                <div class="qty-box d-flex gap-4">
                                    <button class="qty-btn">−</button>
                                    <span class="qty-number">{{ $item->quantity }}</span>
                                    <button class="qty-btn">+</button>
                                </div>

                            </div>
                        </div>

                        {{-- Return --}}
                        <p class="return-text mb-2">14 days return available</p>

                        {{-- Delivery Date --}}
                        <div class="d-flex justify-content-between">
                            <p class="delivery-label mb-2">Delivery by</p>
                            <p class="delivery-date mb-2">{{ now()->addDays(4)->format('d/m/Y') }}</p>
                        </div>

                        {{-- Seller --}}
                        <div class="d-flex justify-content-between">
                            <p class="seller d-flex gap-4 mb-2">
                                <span>Seller</span> 
                                {{ $item->product->seller_details->name ?? 'Unknown Seller' }}
                            </p>
                            <a href="#" class="moreshop">Shop More <i class="bi bi-arrow-right"></i></a>
                        </div>

                    </div>
                    @endforeach

                </div>

                {{-- DELIVERY ADDRESS --}}
                <div class="gift-pnl mt-4">
                    <h6>Delivering Address</h6>
                    <div class="border-1">
                        <div class="giftinfo">

                            <div>
                                {{ $cartData['user_address']->full_name ?? '' }} -
                                {{ $cartData['user_address']->address ?? 'No Address Found' }}
                            </div>

                            <a href="#" class="moreshop">Change <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                {{-- PROMO CODE --}}
                <div class="gift-pnl mt-4">
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>
                                <img src="{{ asset('user/assets/images/ticket-01.svg') }}" class="img-fluid" />
                                Apply PromoCode
                            </div>
                            <a href="javascript:void(0)"
                            data-bs-toggle="modal"
                            data-bs-target="#promoModal"
                            class="moreshop">
                            Apply <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- BILLING DETAILS --}}
                <div class="gift-pnl mt-4">
                    <h6>Billing Details</h6>
                    <div class="border-1">

                        <div class="giftinfo">
                            <div>Total MRP</div>
                            <div>{{ $cartData['total_mrp'] }} KD</div>
                        </div>

                        <div class="giftinfo">
                            <div>Discount on MRP</div>
                            <div class="red-color">{{ $cartData['discount_on_mrp'] }} KD</div>
                        </div>

                        <div class="giftinfo">
                            <div>Coupon Discount</div>
                            <div class="red-color">{{ $cartData['discount_coupon'] }} KD</div>
                        </div>

                        <div class="giftinfo">
                            <div>Shipping Fee</div>
                            <div>{{ $cartData['shipping_fees'] }} KD</div>
                        </div>

                        <div class="giftinfo">
                            <div>TAX (if any)</div>
                            <div>{{ $cartData['tax'] }} KD</div>
                        </div>

                        <div class="giftinfo">
                            <div>Total Amount</div>
                            <div>{{ $cartData['total_amount'] }} KD</div>
                        </div>

                    </div>
                </div>

                <p class="return-text mb-2">
                    You will save {{ $cartData['discount_on_mrp'] }} KD on this
                </p>

            </div>

            {{-- RIGHT SIDE --}}
            <div class="col-lg-4">
                <div class="cart-panel"></div>

                {{-- Gift Card --}}
                <div class="gift-pnl mt-4">
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>
                                <img src="{{ asset('user/assets/images/gift-ic.svg') }}" class="img-fluid" />
                                Have a Gift Card
                            </div>
                            <a href="javascript:void(0)" class="moreshop"
                            data-bs-toggle="modal"
                            data-bs-target="#giftModal">
                                Apply Gift Card <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Place Order Button --}}
                <div class="mt-4">
                    <button type="submit" class="customBtn mb-3" id="loginButtom">
                        Place Order
                    </button>
                </div>

            </div>
        </div>

    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="promoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title fs-5" id="exampleModalLabel">Promocode</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <div class="gift-panel-list">
                <div class="giftsearch py-0 d-flex w-100 gap-0">
                    <div class="form-group w-100 d-flex">
                        <div class="searchicon"><i class="bi bi-search"></i></div>
                        <input type="search" name="search" class="form-control giftcontrol" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btnsearch">Search</button>
                </div>

                <div class="gift-cupon-list my-3">
                    <div class="gift-cupon-content d-flex justify-content-between  align-items-center"> 
                        <div class="title-flat">
                            <h6>FLAT20</h6>
                            <p>Flat 20% off on minimum order 299 KD</p>
                        </div>
                        <button type="button" class="btn btn-outline">Apply</button>
                    </div>
                    <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                </div>
                <div class="gift-cupon-list my-3">
                    <div class="gift-cupon-content d-flex justify-content-between  align-items-center"> 
                        <div class="title-flat">
                            <h6>FLAT20</h6>
                            <p>Flat 20% off on minimum order 299 KD</p>
                        </div>
                        <button type="button" class="btn btn-outline">Apply</button>
                    </div>
                    <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- gift card Modal -->
<div class="modal fade" id="giftModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title fs-5" id="exampleModalLabel">Gift Card</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <div class="gift-panel-list">
                <div class="form-group w-100 py-2">
                    <label>16 Digit Gift Card Number</label>
                    <input type="text" class="form-control pline-10" placeholder="16 Digit Gift Card Number">
                </div>
                <div class="form-group w-100 py-2">
                    <label>Enter PIN</label>
                    <input type="text" class="form-control pline-10" placeholder="Enter PIN">
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="customBtn mb-3 white-btn">Redeem </button>
                </div>
                
            </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection

<script>

    let qty = 1;
    const updateQty = () =>
    document.getElementById("qtyNumber").innerText = String(qty).padStart(2, "0");

    const increaseQty = () => updateQty(++qty);
    const decreaseQty = () => qty > 1 && updateQty(--qty);

</script>