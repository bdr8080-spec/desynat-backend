@extends('user.layout.app')

@section('content')

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
        <a href="{{route('dashboard')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
        <h3>Home</h3>
    </div>

    <div class="main-content">


        @if (session('status') == 'success')
        <div class="alert alert-success">
            <script>
            // $('#payModalSuccess').modal('show');
            </script>
            <!-- {{ session('message') }} -->
        </div>
        @elseif (session('status') == 'error')
        <div class="alert alert-danger">
            {{ session('message') }}
        </div>
        @endif




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
            <h4 class="moreshop">There is nothing in your bag.Let's add some items</h4>
        </div>

        @else

        <div class="row">

            {{-- LEFT SIDE CART --}}
            <div class="col-lg-8">
                @foreach($cartData['cart_data'] as $item)

                @if($item->order_type=='2')
                @php continue @endphp
                @endif

                <div class="cart-panel">
                    <div class="cart-card">
                        <div class="card-left mb-2 d-flex">

                            {{-- Product Image --}}
                            <div>
                                <div class="cart-products me-3">
                                    <img src="{{ $item->product_variants->variant_image[0] }}" alt="Product"
                                        class="img-fluid">
                                </div>
                            </div>
                            {{-- Product Details --}}
                            <div class="card-right d-flex w-100 justify-content-between">

                                <div class="product-info">

                                    <h5 class="product-title">{{ $item->product->product_name_en}}</h5>

                                    <div class="psize d-flex gap-4">
                                        <span>Size: {{ $item->product_variants->size->name ?? '-' }}</span>

                                        <span class="d-flex align-items-center gap-2">
                                            Color:
                                            <div class="colorbox" style="width:15px;height:15px;border-radius:3px;
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

                                        @if($item->product_variants->discount_value!=="0")


                                        @if(!empty($item->product_variants->actual_price))
                                        <span class="price-old">
                                            {{ $item->product_variants->actual_price }} KD
                                        </span>
                                        @endif
                                        <span class="discount ms-2">
                                            @if($item->product_variants->discount_type == 1)
                                            {{ $item->product_variants->discount_value }}% Off
                                            @elseif($item->product_variants->discount_type == 2)
                                            {{ $item->product_variants->discount_value }} KD Off
                                            @endif
                                        </span>

                                        @endif

                                    </div>

                                </div>

                                {{-- Quantity Buttons --}}
                                <div class="qty-box d-flex gap-4" data-product-id="{{ $item->product_id }}"
                                    data-variant-id="{{ $item->variants_id }}">



                                    @if($item->order_type!=='2')
                                    <button class="qty-btn minus">−</button>
                                    @endif

                                    <span class="qty-number">
                                        {{ $item->quantity < 10 ? '0'.$item->quantity : $item->quantity }}
                                    </span>

                                    @if($item->order_type!=='2')
                                    <button class="qty-btn plus">+</button>
                                    @endif
                                </div>

                            </div>
                        </div>

                        @if($item->product->product_return == 1)
                        <p class="return-text mb-2">{{ $item->product->return_days }} days return available</p>
                        @else
                        <p class="return-text mb-2">Non Returnable</p>
                        @endif

                        <div class="d-flex justify-content-between">
                            <p class="delivery-label mb-2">Delivery by</p>
                            <p class="delivery-date mb-2">3-5 Working Days</p>
                        </div>

                        <div class="d-flex justify-content-between">
                            <p class="seller d-flex gap-4 mb-2">
                                <span>Seller</span>
                                {{ $item->product->seller_details->first_name }}
                                {{ $item->product->seller_details->last_name }}
                            </p>

                            <a href="{{ route('user.store_details', $item->product->store_id) }}" class="moreshop">
                                Shop More <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>

                    </div>
                </div>
                @endforeach

                <!-- Custom Product SHow In screen  -->

                <h6> Custom Product</h6>

                @foreach($cartData['cart_data'] as $item)

                @if($item->order_type=='1')
                @php continue @endphp
                @endif
                <div class="cart-panel">
                    <div class="cart-card">
                        <div class="card-left mb-2 d-flex">

                            {{-- Product Image --}}
                            <div>
                                <div class="cart-products me-3">
                                    <img src="{{ $item->product_variants->variant_image[0] }}" alt="Product"
                                        class="img-fluid">
                                </div>
                            </div>
                            {{-- Product Details --}}
                            <div class="card-right d-flex w-100 justify-content-between">

                                <div class="product-info">

                                    <h5 class="product-title">{{ $item->product->product_name_en}}</h5>

                                    <div class="psize d-flex gap-4">
                                        <span>Size: {{ $item->product_variants->size->name ?? '-' }}</span>

                                        <span class="d-flex align-items-center gap-2">
                                            Color:
                                            <div class="colorbox" style="width:15px;height:15px;border-radius:3px;
                                                    background: {{ $item->product_variants->color->hex_code }};">
                                            </div>
                                        </span>

                                        <span>Qnt: {{ $item->quantity }}</span>
                                    </div>

                                    {{-- Price --}}
                                    <div class="price">
                                        <span class="price-current">
                                            {{ $item->chatroom_data->total_amount }} KD
                                        </span>

                                        <!-- @if($item->product_variants->discount_value!=="0")


                                        @if(!empty($item->product_variants->actual_price))
                                        <span class="price-old">
                                            {{ $item->product_variants->actual_price }} KD
                                        </span>
                                        @endif
                                        <span class="discount ms-2">
                                            @if($item->product_variants->discount_type == 1)
                                            {{ $item->product_variants->discount_value }}% Off
                                            @elseif($item->product_variants->discount_type == 2)
                                            {{ $item->product_variants->discount_value }} KD Off
                                            @endif
                                        </span>

                                        @endif -->

                                    </div>

                                </div>

                                {{-- Quantity Buttons --}}
                                <div class="qty-box d-flex gap-4" data-product-id="{{ $item->product_id }}"
                                    data-variant-id="{{ $item->variants_id }}">



                                    @if($item->order_type!=='2')
                                    <button class="qty-btn minus">−</button>
                                    @endif

                                    <!-- <span class="qty-number">
                                        {{ $item->quantity < 10 ? '0'.$item->quantity : $item->quantity }}
                                    </span> -->

                                    @if($item->order_type!=='2')
                                    <button class="qty-btn plus">+</button>
                                    @endif
                                    <span class="removeCustomProduct" data-id="{{$item->id}}" class="btn">Remove
                                    </span>
                                </div>

                            </div>
                        </div>

                        <!-- @if($item->product->product_return == 1)
                        <p class="return-text mb-2">{{ $item->product->return_days }} days return available</p>
                        @else
                        <p class="return-text mb-2">Non Returnable</p>
                        @endif -->

                        <div class="d-flex justify-content-between">
                            <p class="delivery-label mb-2">Delivery by</p>
                            <p class="delivery-date mb-2">3-5 Working Days</p>
                        </div>

                        <div class="d-flex justify-content-between">
                            <p class="seller d-flex gap-4 mb-2">
                                <span>Seller</span>
                                {{ $item->product->seller_details->first_name }}
                                {{ $item->product->seller_details->last_name }}
                            </p>

                            <a href="{{ route('user.store_details', $item->product->store_id) }}" class="moreshop">
                                Shop More <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                        @if($item->order_type=='2')
                        <div class="giftinfo">
                            <div>Custom details</div>
                            <div>{{$item->chatroom_data->custom_details}}</div>
                        </div>
                        @endif

                    </div>
                </div>
                @endforeach

                <!-- custom code End here  -->


                {{-- DELIVERY ADDRESS --}}
                <div class="gift-pnl mt-4">
                    <h6>Delivering Address</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>
                                @isset($cartData['user_address']->address)


                                {{ @$cartData['user_address']->address }}
                                {{ @$cartData['user_address']->house_no }},
                                {{ @$cartData['user_address']->postal_code }},
                                {{ @$cartData['user_address']->city }},
                                {{ @$cartData['user_address']->state }},
                                {{ @$cartData['user_address']->country_name }}
                                @endisset
                            </div>
                            <input type="hidden" id="deliveryAddressId" value="{{ @$cartData['user_address']->id }}">

                            <a href="{{ route('user.view_address', ['type' => 'cart']) }}" class="moreshop">
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
                                <span id="applyPromoText">Apply PromoCode</span>
                            </div>

                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#promoModal"
                                class="moreshop" id="promoApplyLink">
                                Apply <i class="bi bi-arrow-right"></i>
                            </a>

                            <div id="cancelPromoSection" class="d-none">
                                <a href="javascript:void(0)" class="btn btn-outline cancelPromoBtn">Remove</a>
                                <!-- Same styling as Apply button -->
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BILLING DETAILS --}}
                <div class="gift-pnl mt-4">
                    <h6>Billing Details</h6>
                    @php
                        $hasOrderType1 = $cartData['cart_data']->contains('order_type', '1');
                        $hasOrderType2 = $cartData['cart_data']->contains('order_type', '2');

                        $customAmount = $cartData['cart_data']
                            ->where('order_type', '2')
                            ->sum(function ($item) {
                                return $item->amount * $item->quantity;
                            });
                    @endphp
                    <div class="border-1">
                        @if($hasOrderType1)
                        <div class="giftinfo">
                            <div>Total MRP</div>
                            <div>{{ $cartData['total_mrp'] }} KD</div>
                        </div>
                        @endif
                        @if($hasOrderType1)
                        <div class="giftinfo">
                            <div>Discount on MRP</div>
                            <div class="red-color">{{ $cartData['discount_on_mrp'] }} KD</div>
                        </div>
                        @endif
                        @if($hasOrderType2)
                        <div class="giftinfo">
                            <div>Custom Item price</div>
                            <div>{{ $customAmount }} KD</div>
                        </div>
                        @endif
                        <div class="giftinfo d-none" id="couponDiscountRow">
                            <div>Coupon Discount</div>
                            <div class="red-color" id="couponDiscountAmount">{{ $cartData['discount_coupon'] }} KD
                            </div>
                        </div>
                        <div class="giftinfo d-none" id="giftCardDiscountRow">
                            <div>Gift Card Discount</div>
                            <div class="red-color" id="giftCardDiscountAmount">0 KD</div>
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
                @if($hasOrderType1)
                <p id="promoSavingsText" class="return-text mb-2">
                    You will save {{ $cartData['discount_on_mrp'] }} KD on this
                </p>
                @endif
            </div>

            {{-- RIGHT SIDE --}}
            <div class="col-lg-4">

                <input type="hidden" id="WalletBalance" value="{{$walletBalance}}">

                <div class="gift-pnl mt-0">
                    <div class="border-1">
                        <div class="payment-option" id="paymentMethodSection">
                            <label class="custom-radio mb-3">
                                <input type="radio" name="payment_method" value="1" checked>
                                <span class="radio-mark"></span>
                                <div class="label-content">
                                    <div class="title">Online</div>
                                </div>
                            </label>
                            <!-- <label class="custom-radio mb-3">
                                <input type="radio" name="payment_method" value="2">
                                <span class="radio-mark"></span>
                                <div class="label-content">
                                    <div class="title">Wallet ( {{$walletBalance}} ) </div>
                                </div>
                            </label> -->

                            <label class="custom-radio mb-3">
                                <input type="radio" name="payment_method" value="2">
                                <span class="radio-mark"></span>
                                <div class="label-content d-flex gap-3">
                                    <img src="{{ asset('user/assets/images/wallet.svg') }}" class="img-fluid">
                                    <div class="title">
                                        In -App Wallet
                                        <div class="small-14">Available Balance : ( {{$walletBalance}} )</div>
                                    </div>
                                </div>
                            </label>

                            <label class="custom-radio mb-3">
                                <input type="radio" name="payment_method" value="3">
                                <span class="radio-mark"></span>
                                <div class="label-content">
                                    <div class="title"><span class="code-title">COD</span> Cash On Delivery</div>
                                </div>
                            </label>
                        </div>

                        <!-- <div id="paymentMethodSection">
                            <label>
                                <input type="radio" name="payment_method" value="1" checked> Online
                            </label>
                            <label>
                                <input type="radio" name="payment_method" value="2"> Wallet
                            </label>
                            <label>
                                <input type="radio" name="payment_method" value="3"> COD
                            </label>
                        </div> -->
                    </div>
                </div>

                {{-- Gift Card --}}
                <div class="gift-pnl mt-4">
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>
                                <img src="{{ asset('user/assets/images/gift-ic.svg') }}" class="img-fluid">
                                <span id="applyGiftCardText">Have a Gift Card</span>
                            </div>

                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#giftModal"
                                class="moreshop" id="applyGiftCardBtn">
                                Apply Gift Card <i class="bi bi-arrow-right"></i>
                            </a>
                            <a href="javascript:void(0)" class="moreshop d-none" id="cancelGiftCardBtn">
                                Remove Gift Card <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" id="placeOrderBtn" class="customBtn mb-3">
                        Place Order
                    </button>
                </div>

            </div>

        </div>

        @endif

    </div>

</div>


<div class="modal fade" id="promoModal" tabindex="-1" aria-labelledby="promoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5" id="promoModalLabel">Promocode</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="gift-panel-list">

                    @if(isset($promoCodes) && count($promoCodes) > 0)

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
                                        Flat {{ $promo->discount_percent }}% off on minimum order
                                        {{ $promo->min_order_value }} KD
                                        @else
                                        Discount details not available
                                        @endif
                                    </p>
                                </div>
                                <!-- <button type="button" class="btn btn-outline applyPromoBtn" data-id="{{ $promo->id }}">Apply</button> -->
                                <button type="button" class="btn btn-outline applyPromoBtn" data-id="{{ $promo->id }}"
                                    data-name="{{ $promo->name_english }}">Apply</button>
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
                        <input type="text" id="giftCardNumber"
                            oninput="this.value=this.value.replace(/\D/g,'').slice(0,16)" class="form-control pline-10"
                            placeholder="16 Digit Gift Card Number">
                        <div id="giftCardNumberError" class="text-danger text-center" style="display: none;"></div>
                    </div>
                    <div class="form-group w-100 py-2">
                        <label>Enter PIN</label>
                        <input type="text" id="giftCardPin" oninput="this.value=this.value.replace(/\D/g,'').slice(0,4)"
                            class="form-control pline-10" placeholder="Enter PIN">
                        <div id="giftCardPinError" class="text-danger text-center" style="display: none;"></div>
                    </div>
                    <div class="mt-4">
                        <button type="button" id="redeemGiftCardBtn" class="customBtn mb-3 white-btn">Redeem</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="loader" style="display:none;">
    <div class="loader"></div>
</div>






@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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
</script>


<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".qty-box").forEach(box => {

        const productId = box.dataset.productId;
        const variantId = box.dataset.variantId;

        const minusBtn = box.querySelector(".minus");
        const plusBtn = box.querySelector(".plus");
        const qtyText = box.querySelector(".qty-number");

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
                        quantity: qty
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        setTimeout(() => {
                            location.reload(); // Reload page
                        }, 1000);
                        toastr.success(data.message); // Show backend message
                    } else {
                        toastr.error(data.message);
                        setTimeout(() => {
                            location.reload(); // Reload page
                        }, 1000);
                    }
                    // After quantity change, refresh discounts UI
                    setTimeout(refreshDiscountUI, 500);
                })
                .catch((err) => {
                    toastr.error(err.message || "Request failed");
                });
        }

        plusBtn.addEventListener("click", function() {
            let qty = parseInt(qtyText.innerText);
            qty++;
            qtyText.innerText = qty < 10 ? "0" + qty : qty;
            updateQuantity(qty);
        });

        minusBtn.addEventListener("click", function() {
            let qty = parseInt(qtyText.innerText);
            qty--;
            qtyText.innerText = qty < 10 ? "0" + qty : qty;
            updateQuantity(qty);
        });

    });
});
</script>


<script>
$(document).ready(function() {
    var appliedPromoId = null;

    $(document).on('click', '.applyPromoBtn', function() {
        var promoId = $(this).data('id');
        var totalAmountText = $('.giftinfo').filter(function() {
            return $(this).find('div').first().text().trim() === 'Total Amount';
        }).find('div').last().text().replace(' KD', '').trim();
        var amount = parseFloat(totalAmountText);

        $.ajax({
            url: '/user/apply_promocode',
            method: 'POST',
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            data: {
                promo_id: promoId,
                amount: amount
            },
            success: function(response) {
                if (response.status === 'success' && response.data) {
                    var promoData = response.data.data ? response.data.data : response
                        .data;
                    if (promoData && promoData.discount_code) {
                        $('#promoModal').modal('hide');
                        $('#applyPromoText').text(promoData.discount_code + ' applied');
                        $('#promoApplyLink').hide();
                        $('#cancelPromoSection').removeClass('d-none');

                        // Save in localStorage
                        localStorage.setItem('appliedPromo', JSON.stringify({
                            promoCode: promoData.discount_code,
                            discountValue: promoData.Apply_discount_value,
                            finalAmount: promoData.final_amount,
                            promoId: promoId
                        }));

                        toastr.success(response.message);
                        setTimeout(() => {
                            location.reload(); // Reload page
                        }, 1000);
                        // refreshDiscountUI();
                    } else {
                        toastr.error("Discount code not in response");
                    }
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(response) {
                toastr.error(response.responseJSON?.message || "Failed");
            }
        });
    });

    $(document).on('click', '.cancelPromoBtn', function() {
        toastr.error("Promo code removed.");
        localStorage.removeItem('appliedPromo');
        refreshDiscountUI();
        setTimeout(() => {
            location.reload(); // Reload page
        }, 1000);
    });

    // On page load, refresh promo UI
    refreshDiscountUI();
});
</script>


<script>
$(document).ready(function() {

    $(document).on('click', '#redeemGiftCardBtn', function() {
        var giftCardNumber = $('#giftCardNumber').val().trim();
        var giftCardPin = $('#giftCardPin').val().trim();
        var isValid = true;

        $('#giftCardNumberError, #giftCardPinError').text('');

        if (!/^\d{16}$/.test(giftCardNumber)) {
            $('#giftCardNumberError').text('Please enter 16 digit gift card number').show();
            isValid = false;
        }
        if (!/^\d{4}$/.test(giftCardPin)) {
            $('#giftCardPinError').text('Please enter 4 digit pin').show();
            isValid = false;
        }

        if (isValid) {
            $.ajax({
                url: '/user/apply_giftcard',
                method: 'POST',
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                data: {
                    giftCardNo: giftCardNumber,
                    giftCardPin: giftCardPin
                },
                success: function(response) {
                    if (response.status === 'success') {
                        var giftCardData = response.data.data ? response.data.data :
                            response.data;
                        $('#giftModal').modal('hide');

                        // Save in localStorage
                        localStorage.setItem('appliedGiftCard', JSON.stringify({
                            giftCardNumber: giftCardNumber,
                            giftCardPin: giftCardPin,
                            giftCardAmount: parseFloat(giftCardData
                                .GiftCardAmount),
                            giftCardId: giftCardData.id
                        }));

                        toastr.success(response.message);
                        // refreshDiscountUI();
                        setTimeout(() => {
                            location.reload(); // Reload page
                        }, 1000);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(response) {
                    toastr.error(response.responseJSON?.message || "Failed");
                }
            });
        }
    });

    $(document).on('click', '#cancelGiftCardBtn', function() {
        toastr.error("Gift card removed.");
        localStorage.removeItem('appliedGiftCard');
        refreshDiscountUI();
        setTimeout(() => {
            location.reload(); // Reload page
        }, 1000);
    });

    // Remove error messages dynamically
    $('#giftCardNumber, #giftCardPin').on('input', function() {
        $(this).next().hide();
    });

    refreshDiscountUI();
});
</script>


<script>
function refreshDiscountUI() {
    var savedPromo = JSON.parse(localStorage.getItem('appliedPromo') || 'null');
    var savedGiftCard = JSON.parse(localStorage.getItem('appliedGiftCard') || 'null');

    // Update Promo
    if (savedPromo) {
        $('#applyPromoText').text(savedPromo.promoCode + ' applied');
        $('#promoApplyLink').hide();
        $('#cancelPromoSection').removeClass('d-none');
        // $('.giftinfo').filter(function() {
        //         return $(this).find('div').first().text().trim() === 'Coupon Discount';
        //     })
        //     .find('div').last().text(savedPromo.discountValue + ' KD');
        $('#couponDiscountAmount').text(savedPromo.discountValue + ' KD');
        $('#couponDiscountRow').removeClass('d-none');
    } else {
        $('#applyPromoText').text('Apply PromoCode');
        $('#promoApplyLink').show();
        $('#cancelPromoSection').addClass('d-none');
        // $('.giftinfo').filter(function() {
        //         return $(this).find('div').first().text().trim() === 'Coupon Discount';
        //     })
        //     .find('div').last().text('0 KD');
        $('#couponDiscountRow').addClass('d-none');
        $('#couponDiscountAmount').text('0 KD');
    }

    // Update Gift Card
    if (savedGiftCard) {
        $('#applyGiftCardText').text('Gift Card Applied');
        $('#applyGiftCardBtn').hide();
        $('#cancelGiftCardBtn').removeClass('d-none');
        // $('.giftinfo').filter(function() {
        //         return $(this).find('div').first().text().trim() === 'Gift Card Discount';
        //     })
        //     .find('div').last().text(savedGiftCard.giftCardAmount.toFixed(2) + ' KD');
        $('#giftCardDiscountAmount')
            .text(formatKD(savedGiftCard.giftCardAmount));
        $('#giftCardDiscountRow').removeClass('d-none');
    } else {
        $('#applyGiftCardText').text('Have a Gift Card');
        $('#applyGiftCardBtn').show();
        $('#cancelGiftCardBtn').addClass('d-none');
        // $('.giftinfo').filter(function() {
        //         return $(this).find('div').first().text().trim() === 'Gift Card Discount';
        //     })
        //     .find('div').last().text('0 KD');
        $('#giftCardDiscountRow').addClass('d-none');
        $('#giftCardDiscountAmount').text('0 KD');
    }

    // Recalculate Total Amount
    var baseTotal = parseFloat($('.giftinfo').filter(function() {
        return $(this).find('div').first().text().trim() === 'Total MRP';
    }).find('div').last().text().replace(' KD', '')) || 0;
    var discountOnMRP = parseFloat($('.giftinfo').filter(function() {
        return $(this).find('div').first().text().trim() === 'Discount on MRP';
    }).find('div').last().text().replace(' KD', '')) || 0;
    var shippingFee = parseFloat($('.giftinfo').filter(function() {
        return $(this).find('div').first().text().trim() === 'Shipping Fee';
    }).find('div').last().text().replace(' KD', '')) || 0;
    var tax = parseFloat($('.giftinfo').filter(function() {
        return $(this).find('div').first().text().trim() === 'TAX (if any)';
    }).find('div').last().text().replace(' KD', '')) || 0;
    var custom = parseFloat($('.giftinfo').filter(function() {
        return $(this).find('div').first().text().trim() === 'Custom Item price';
    }).find('div').last().text().replace(' KD', '')) || 0;

    var promoDiscount = savedPromo ? savedPromo.discountValue : 0;
    var giftCardDiscount = savedGiftCard ? savedGiftCard.giftCardAmount : 0;

    var finalTotal = baseTotal - discountOnMRP - promoDiscount - giftCardDiscount + shippingFee + tax + custom;
    $('.giftinfo').filter(function() {
            return $(this).find('div').first().text().trim() === 'Total Amount';
        })
        .find('div').last().text(finalTotal.toFixed(2) + ' KD');

    // Total Savings
    var totalSavings = discountOnMRP + promoDiscount + giftCardDiscount;
    $('#promoSavingsText').text("You will save " + totalSavings.toFixed(2) + " KD on this");
}
</script>

<script>
function formatKD(amount) {
    amount = parseFloat(amount) || 0;

    // If decimal part is .00 → show integer
    if (amount % 1 === 0) {
        return amount.toFixed(0) + ' KD';
    }

    // Otherwise show 2 decimals
    return amount.toFixed(2) + ' KD';
}
</script>


<script>
$(document).ready(function() {

    $('#placeOrderBtn').on('click', function(e) {
        e.preventDefault(); // Prevent default form submission

        var paymentMethod = $('input[name="payment_method"]:checked').val();

        var deliveryAddressId = document.getElementById('deliveryAddressId').value;

        if (deliveryAddressId.length == 0) {
            console.log("delivery Address check");

            toastr.error("delivery Address is required");
            return false;


        }

        // Get localStorage data
        var promoData = JSON.parse(localStorage.getItem('appliedPromo') || '{}');
        var giftCardData = JSON.parse(localStorage.getItem('appliedGiftCard') || '{}');

        // Optional: set to null if empty object
        promoData = Object.keys(promoData).length ? promoData : null;
        giftCardData = Object.keys(giftCardData).length ? giftCardData : null;

        // Fetch cart summary values from UI
        var cartSummary = {};
        $('.giftinfo').each(function() {
            var title = $(this).find('div').first().text().trim();
            var valueText = $(this).find('div').last().text().replace(' KD', '').trim();
            var value = parseFloat(valueText) || 0;

            switch (title) {
                case 'Total MRP':
                    cartSummary.totalMRP = value;
                    break;
                case 'Discount on MRP':
                    cartSummary.discountOnMRP = value;
                    break;
                case 'Coupon Discount':
                    cartSummary.couponDiscount = value;
                    break;
                case 'Gift Card Discount':
                    cartSummary.giftCardDiscount = value;
                    break;
                case 'Shipping Fee':
                    cartSummary.shippingFee = value;
                    break;
                case 'TAX (if any)':
                    cartSummary.tax = value;
                    break;
                case 'Total Amount':
                    cartSummary.totalAmount = value;
                    break;
            }
        });

        // check Wallet when Payment is Wallet 
        if (paymentMethod == 2) {
            var wallet_Amount = $('#WalletBalance').val();
            var PayAmount = cartSummary.totalAmount;
            if (wallet_Amount < PayAmount) {
                console.log("Wallet Amount is Low Please Choose Another Method");
                toastr.error('Wallet Amount is Low Please Choose Another Method');

                return false;
            }



        }

        // Prepare request payload
        var requestData = {
            promo: promoData,
            giftCard: giftCardData,
            cartSummary: cartSummary,
            Payment_method: paymentMethod,
            deliveryAddressId: deliveryAddressId
        };

        // Send AJAX request
        $.ajax({
            url: '/user/create_order',
            method: 'POST',
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            data: requestData,
            success: function(response) {
                $('#loader').show();
                // console.log(response);
                if (response.status === 'success') {
                    // toastr.success(response.message || "Order placed successfully!");
                    // Clear localStorage promo/gift card
                    localStorage.removeItem('appliedPromo');
                    localStorage.removeItem('appliedGiftCard');
                    setTimeout(() => {

                        // Redirect To Online Pyament gateway 
                        if (response.data && response.data.data.order_id &&
                            response
                            .data.data.Payment_method == '1') {

                            var orderid = response.data.data.order_id;
                            var url = "/myfatoorah/" + orderid + "?type=order";
                            window.location.href = url;

                            return false;
                        }

                        if (response.data && response.data.data.order_id) {

                            var orderid = response.data.data.order_id;
                            var url = "/user/complete-order-Payment?orderid=" +
                                orderid;
                            window.location.href = url;

                        }

                    }, 1000);
                } else {
                    toastr.error(response.message || "Failed to place order.");
                }
            },
            error: function(xhr) {
                var errMsg = xhr.responseJSON && xhr.responseJSON.message ?
                    xhr.responseJSON.message :
                    "An error occurred while placing order.";
                toastr.error(errMsg);
            }
        });
    });

});


// remove Custom product from The Card

$(document).on('click', '.removeCustomProduct', function() {
    let id = $(this).data('id');


    // Example AJAX call
    $.ajax({
        url: "{{Route('remove_custom_addtocard')}}",
        type: 'get',
        data: {
            id: id
        },
        success: function(res) {

            if (res.status == 'success') {


                toastr.success(res.message);

                setTimeout(() => {
                    window.location.href = window.location.href;
                }, 1000);


            }
            // handle success
        }
    });
});
</script>