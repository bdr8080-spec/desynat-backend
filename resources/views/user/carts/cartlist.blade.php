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
        @php
            $cartItems = [];

            if (is_array($cartData) && isset($cartData['cart_data'])) {
                $cartItems = $cartData['cart_data'];
            } elseif (is_object($cartData) && isset($cartData->cart_data)) {
                $cartItems = $cartData->cart_data;
            }
        @endphp
        @if(empty($cartItems) || (is_object($cartItems) && $cartItems->isEmpty()))

            {{-- EMPTY CART MESSAGE --}}
            <div class="text-center py-5">
                <h4>No product in Cart</h4>
            </div>

        @else

            <div class="row">

                {{-- LEFT SIDE CART --}}
                <div class="col-lg-8">
                    <div class="cart-panel">

                        @foreach($cartData['cart_data'] as $item)
                        <div class="cart-card mb-4">

                            <div class="card-left mb-2 d-flex">

                                {{-- Product Image --}}
                                <div class="cart-products me-3">
                                    <img src="{{ $item->product_variants->variant_image[0] }}"
                                        alt="Product" class="img-fluid">
                                </div>

                                {{-- Product Details --}}
                                <div class="card-right d-flex w-100 justify-content-between">

                                    <div class="product-info">

                                        <h5 class="product-title">{{ $item->product->name }}</h5>

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

                                    {{-- Quantity Buttons --}}
                                    <div class="qty-box d-flex gap-4"
                                        data-product-id="{{ $item->product_id }}"
                                        data-variant-id="{{ $item->variants_id }}">

                                        <button class="qty-btn minus">−</button>

                                        <span class="qty-number">
                                            {{ $item->quantity < 10 ? '0'.$item->quantity : $item->quantity }}
                                        </span>

                                        <button class="qty-btn plus">+</button>
                                    </div>

                                </div>
                            </div>

                            <p class="return-text mb-2">14 days return available</p>

                            <div class="d-flex justify-content-between">
                                <p class="delivery-label mb-2">Delivery by</p>
                                <p class="delivery-date mb-2">{{ now()->addDays(4)->format('d/m/Y') }}</p>
                            </div>

                            <div class="d-flex justify-content-between">
                                <p class="seller d-flex gap-4 mb-2">
                                    <span>Seller</span> 
                                    {{ $item->product->seller_details->first_name }} 
                                    {{ $item->product->seller_details->last_name }}
                                </p>

                                <a href="{{ route('user.store_details', $item->product->store_id) }}" 
                                class="moreshop">
                                    Shop More <i class="bi bi-arrow-right"></i>
                                </a>
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
                                    {{ $cartData['user_address']->address }}
                                    {{ $cartData['user_address']->house_no }},
                                    {{ $cartData['user_address']->postal_code }},
                                    {{ $cartData['user_address']->city }},
                                    {{ $cartData['user_address']->state }},
                                    {{ $cartData['user_address']->country_name }}
                                </div>

                                <a href="{{ route('user.view_address') }}" class="moreshop">
                                    Change <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- PROMO CODE --}}
                    <div class="gift-pnl mt-4">
                        <div class="border-1">
                            <div class="giftinfo">
                                <div>
                                    <img src="{{ asset('user/assets/images/ticket-01.svg') }}" class="img-fluid">
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
                            <div class="giftinfo"><div>Total MRP</div><div>{{ $cartData['total_mrp'] }} KD</div></div>
                            <div class="giftinfo"><div>Discount on MRP</div><div class="red-color">{{ $cartData['discount_on_mrp'] }} KD</div></div>
                            <div class="giftinfo"><div>Coupon Discount</div><div class="red-color">{{ $cartData['discount_coupon'] }} KD</div></div>
                            <div class="giftinfo"><div>Shipping Fee</div><div>{{ $cartData['shipping_fees'] }} KD</div></div>
                            <div class="giftinfo"><div>TAX (if any)</div><div>{{ $cartData['tax'] }} KD</div></div>
                            <div class="giftinfo"><div>Total Amount</div><div>{{ $cartData['total_amount'] }} KD</div></div>
                        </div>
                    </div>

                    <p class="return-text mb-2">
                        You will save {{ $cartData['discount_on_mrp'] }} KD on this
                    </p>
                </div>

                {{-- RIGHT SIDE --}}
                <div class="col-lg-4">

                    {{-- Gift Card --}}
                    <div class="gift-pnl mt-4">
                        <div class="border-1">
                            <div class="giftinfo">
                                <div>
                                    <img src="{{ asset('user/assets/images/gift-ic.svg') }}" class="img-fluid">
                                    Have a Gift Card
                                </div>

                                <a href="javascript:void(0)" 
                                data-bs-toggle="modal"
                                data-bs-target="#giftModal"
                                class="moreshop">
                                    Apply Gift Card <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="customBtn mb-3">
                            Place Order
                        </button>
                    </div>

                </div>

            </div>

        @endif

    </div>

</div>


<!-- Modal -->
<!-- <div class="modal fade" id="promoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
</div> -->
<div class="modal fade" id="promoModal" tabindex="-1" aria-labelledby="promoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5" id="promoModalLabel">Promocode</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="gift-panel-list">

                    @if(isset($promoCodes) && $promoCodes->isNotEmpty())

                        <!-- <div class="giftsearch py-0 d-flex w-100 gap-0">
                            <div class="form-group w-100 d-flex">
                                <div class="searchicon"><i class="bi bi-search"></i></div>
                                <input type="search" name="search" class="form-control giftcontrol" placeholder="Search" id="promoSearch">
                            </div>
                            <button type="button" class="btn btnsearch" id="promoSearchBtn">Search</button>
                        </div> -->

                        {{-- Promo Code List --}}
                        <div id="promoList">
                            @foreach($promoCodes as $promo)
                                <div class="gift-cupon-list my-3">
                                    <div class="gift-cupon-content d-flex justify-content-between align-items-center"> 
                                        <div class="title-flat">
                                            <h6>{{ $promo->name_english }}</h6>
                                            <p>
                                                @if($promo->discount_percent)
                                                    Flat {{ $promo->discount_percent }}% off on minimum order {{ $promo->min_order_value }} KD
                                                @else
                                                    Discount details not available
                                                @endif
                                            </p>
                                        </div>
                                        <button type="button" class="btn btn-outline applyPromoBtn" data-id="{{ $promo->id }}">Apply</button>
                                    </div>
                                    <p class="mb-0">{{ $promo->description_english }}</p>
                                </div>
                            @endforeach
                        </div>

                    @else
                        {{-- No promocode found --}}
                        <div class="text-center py-3">
                            <p>No Promo Code Found.</p>
                        </div>
                    @endif

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
document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".qty-box").forEach(box => {

        const productId = box.dataset.productId;
        const variantId = box.dataset.variantId;

        const minusBtn = box.querySelector(".minus");
        const plusBtn  = box.querySelector(".plus");
        const qtyText  = box.querySelector(".qty-number");

        function updateQuantity(qty) {
            fetch("{{ route('user.addToCart') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    product_id: productId,
                    variant_id: variantId,
                    quantity: qty   // allow 0 → remove from cart
                })
            })
            .then(res => res.json())
            .then(data => {

                if (data.status === "success") {
                    toastr.success(data.message || "Updated");

                    setTimeout(() => location.reload(), 1000);

                } else {
                    toastr.error(data.message || "Something went wrong");

                    // If item removed, still reload page
                    setTimeout(() => location.reload(), 1000);
                }
            })
            .catch(() => {
                toastr.error("Request failed");
            });
        }

        plusBtn.addEventListener("click", function () {
            let qty = parseInt(qtyText.innerText);
            qty++;

            qtyText.innerText = qty < 10 ? "0" + qty : qty;
            updateQuantity(qty);
        });

        minusBtn.addEventListener("click", function () {
            let qty = parseInt(qtyText.innerText);

            qty--; 

            qtyText.innerText = qty < 10 ? "0" + qty : qty;

            updateQuantity(qty);
        });

    });

});
</script>

<!-- promocode modal -->
@if(isset($promocodes) && $promocodes->isNotEmpty())
<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById('promoSearch');
    const searchBtn = document.getElementById('promoSearchBtn');
    const promoList = document.getElementById('promoList');

    if(searchBtn){
        searchBtn.addEventListener('click', function() {
            const query = searchInput.value.toLowerCase().trim();
            let found = false;

            promoList.querySelectorAll('.gift-cupon-list').forEach(item => {
                const title = item.querySelector('h6').innerText.toLowerCase();
                const desc = item.querySelector('p').innerText.toLowerCase();
                if(title.includes(query) || desc.includes(query)){
                    item.style.display = 'block';
                    found = true;
                } else {
                    item.style.display = 'none';
                }
            });

            // Show message if no match found
            if(!found){
                if(!document.getElementById('noPromoSearch')){
                    const p = document.createElement('p');
                    p.id = 'noPromoSearch';
                    p.className = 'text-center py-3';
                    p.innerText = 'No promocode found.';
                    promoList.appendChild(p);
                }
            } else {
                const msg = document.getElementById('noPromoSearch');
                if(msg) msg.remove();
            }
        });
    }
});
</script>
@endif


