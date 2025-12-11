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
                    @foreach($cartData['cart_data'] as $item)
                    <div class="cart-panel">
                        <div class="cart-card">
                            <div class="card-left mb-2 d-flex">

                                {{-- Product Image --}}
                                <div>
                                <div class="cart-products me-3">
                                    <img src="{{ $item->product_variants->variant_image[0] }}"
                                        alt="Product" class="img-fluid">
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
                    </div>
                    @endforeach

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
                                    <span id="applyPromoText">Apply PromoCode</span>
                                </div>

                                <a href="javascript:void(0)"
                                data-bs-toggle="modal"
                                data-bs-target="#promoModal"
                                class="moreshop"
                                id="promoApplyLink">
                                    Apply <i class="bi bi-arrow-right"></i>
                                </a>

                                <div id="cancelPromoSection" class="d-none">
                                    <a href="javascript:void(0)" class="btn btn-outline cancelPromoBtn">Cancel</a> <!-- Same styling as Apply button -->
                                </div>
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

                    <p id="promoSavingsText" class="return-text mb-2">
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
                                    <span id="applyGiftCardText">Have a Gift Card</span>
                                </div>

                                <a href="javascript:void(0)" 
                                data-bs-toggle="modal"
                                data-bs-target="#giftModal"
                                class="moreshop" id="applyGiftCardBtn">
                                    Apply Gift Card <i class="bi bi-arrow-right"></i>
                                </a>
                                <a href="javascript:void(0)" 
                                    class="moreshop d-none" id="cancelGiftCardBtn">
                                    Cancel Gift Card <i class="bi bi-arrow-right"></i>
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
                                                    Flat {{ $promo->discount_percent }}% off on minimum order {{ $promo->min_order_value }} KD
                                                @else
                                                    Discount details not available
                                                @endif
                                            </p>
                                        </div>
                                        <!-- <button type="button" class="btn btn-outline applyPromoBtn" data-id="{{ $promo->id }}">Apply</button> -->
                                         <button type="button" class="btn btn-outline applyPromoBtn" data-id="{{ $promo->id }}" data-name="{{ $promo->name_english }}">Apply</button>
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
                        <input type="text" id="giftCardNumber" class="form-control pline-10" placeholder="16 Digit Gift Card Number">
                        <div id="giftCardNumberError" class="text-danger text-center" style="display: none;"></div>
                    </div>
                    <div class="form-group w-100 py-2">
                        <label>Enter PIN</label>
                        <input type="text" id="giftCardPin" class="form-control pline-10" placeholder="Enter PIN">
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






@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
    $(document).ready(function () {
        var appliedPromoId = null;

        $(document).on('click', '.applyPromoBtn', function () {
            var promoId = $(this).data('id');
            var totalAmountText = document.querySelectorAll('.giftinfo')[7].querySelectorAll('div')[1].textContent;
            var amount = parseFloat(totalAmountText.replace(' KD', '').trim());

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
                success: function (response) {
                    if (response.status === 'success' && response.data) {
                        var promoData = response.data.data ? response.data.data : response.data;
                        if (promoData && promoData.discount_code) {
                            $('#promoModal').modal('hide'); 
                            $('#applyPromoText').text(promoData.discount_code + ' applied');
                            $('#promoApplyLink').hide();
                            $('#cancelPromoSection').removeClass('d-none'); 

                            $('.giftinfo').each(function() {
                                var title = $(this).find('div').first().text().trim();
                                if (title === 'Coupon Discount') {
                                    $(this).find('div').last().text(promoData.Apply_discount_value + ' KD');
                                }
                                if (title === 'Total Amount') {
                                    $(this).find('div').last().text(promoData.final_amount + ' KD');
                                }
                            });

                            var previousSavingsText = $('#promoSavingsText').text().trim(); 
                            var previousSavingsMatch = previousSavingsText.match(/(\d+(\.\d+)?)(?=\s*KD)/); 
                            var previousSavings = previousSavingsMatch ? parseFloat(previousSavingsMatch[0]) : 0;
                            var totalSavings = previousSavings + parseFloat(promoData.Apply_discount_value); 

                            $('#promoSavingsText').text("You will save " + totalSavings + " KD on this");

                            localStorage.setItem('appliedPromo', JSON.stringify({
                                promoCode: promoData.discount_code,
                                discountValue: promoData.Apply_discount_value,
                                finalAmount: promoData.final_amount,
                                promoId: promoData.promo_id
                            }));

                            appliedPromoId = promoData.promo_id;
                            toastr.success(response.message || "Promo code applied successfully!");
                        } else {
                            toastr.error("Discount code is not available in response.");
                        }
                    } else {
                        
                        toastr.error(response.message);
                    }
                },
                error: function (response) {
                    //console.log(response)
                    toastr.error(response.responseJSON.message);
                }
            });
        });

        var savedPromoData = localStorage.getItem('appliedPromo');
        if (savedPromoData) {
            savedPromoData = JSON.parse(savedPromoData); 
            $('#applyPromoText').text(savedPromoData.promoCode + ' applied');
            $('#promoApplyLink').hide();
            $('#cancelPromoSection').removeClass('d-none');
            $('.giftinfo').each(function() {
                var title = $(this).find('div').first().text().trim();
                if (title === 'Coupon Discount') {
                    $(this).find('div').last().text(savedPromoData.discountValue + ' KD');
                }
                if (title === 'Total Amount') {
                    $(this).find('div').last().text(savedPromoData.finalAmount + ' KD');
                }
            });
            var previousSavingsText = $('#promoSavingsText').text().trim();
            var previousSavingsMatch = previousSavingsText.match(/(\d+(\.\d+)?)(?=\s*KD)/);
            var previousSavings = previousSavingsMatch ? parseFloat(previousSavingsMatch[0]) : 0;
            var totalSavings = previousSavings + savedPromoData.discountValue;
            $('#promoSavingsText').text("You will save " + totalSavings + " KD on this");
        }

        $(document).on('click', '.cancelPromoBtn', function () {
            toastr.error("Promo code removed.");
            localStorage.removeItem('appliedPromo');
            setTimeout(function() {
                location.reload();
            }, 1000);
        });
    });
</script>

<!-- gift card apply -->


<script>
    $(document).ready(function () {

    $(document).on('click', '#redeemGiftCardBtn', function () {
        var giftCardNumber = $('#giftCardNumber').val().trim();
        var giftCardPin = $('#giftCardPin').val().trim();
        var isValid = true;

        $('#giftCardNumberError').text(''); 
        $('#giftCardPinError').text('');  

        if (giftCardNumber === '' || giftCardNumber.length !== 16 || !/^\d{16}$/.test(giftCardNumber)) {
            $('#giftCardNumberError').text('Please enter 16 digit gift card number').css('display', 'block');
            isValid = false;
        }

        if (giftCardPin === '' || giftCardPin.length !== 4 || !/^\d{4}$/.test(giftCardPin)) {
            $('#giftCardPinError').text('Please enter 4 digit pin').css('display', 'block');
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
                success: function (response) {
                    if (response.status === 'success') {
                        var giftCardData = response.data.data ? response.data.data : response.data;
                        console.log(giftCardData);
                        $('#giftModal').modal('hide');
                        
                        $('#applyGiftCardBtn').hide(); 
                        $('#cancelGiftCardBtn').removeClass('d-none');
                        $('#applyGiftCardText').text('Gift Card Applied'); 
                        
                        var giftCardAmount = parseFloat(giftCardData.GiftCardAmount); 
                        var totalAmount = parseFloat($('.giftinfo').filter(function() {
                            return $(this).find('div').first().text().trim() === 'Total Amount';
                        }).find('div').last().text().replace(' KD', '').trim()); 

                        var updatedTotalAmount = totalAmount - giftCardAmount;
                        
                        $('.giftinfo').each(function() {
                            var title = $(this).find('div').first().text().trim();
                            if (title === 'Total Amount') {
                                $(this).find('div').last().text(updatedTotalAmount % 1 === 0 ? updatedTotalAmount.toFixed(0) + ' KD' : updatedTotalAmount.toFixed(2) + ' KD');
                            }
                        });
                        var previousSavingsText = $('#promoSavingsText').text().trim();
                        var previousSavingsMatch = previousSavingsText.match(/(\d+(\.\d+)?)(?=\s*KD)/);
                        var previousSavings = previousSavingsMatch ? parseFloat(previousSavingsMatch[0]) : 0;
                        var totalSavings = previousSavings + giftCardAmount; // Add gift card amount to total savings

                        $('#promoSavingsText').text("You will save " + (totalSavings % 1 === 0 ? totalSavings.toFixed(0) : totalSavings.toFixed(2)) + " KD on this");

                        // Add Gift Card Discount under Coupon Discount
                        $('.giftinfo').each(function() {
                            var title = $(this).find('div').first().text().trim();
                            if (title === 'Coupon Discount') {
                                $(this).after(`
                                    <div class="giftinfo">
                                        <div>Gift Card Discount</div>
                                        <div class="red-color">${giftCardAmount % 1 === 0 ? giftCardAmount.toFixed(0) : giftCardAmount.toFixed(2)} KD</div>
                                    </div>
                                `); 
                            }
                        });

                        // Store gift card and total savings data in localStorage (not removing promo code data)
                        var savedPromoData = JSON.parse(localStorage.getItem('appliedPromo')) || {};
                        var appliedGiftCardData = {
                            giftCardNumber: giftCardNumber,
                            giftCardPin: giftCardPin,
                            finalAmount: updatedTotalAmount,
                            totalSavings: totalSavings // Store total savings in localStorage
                        };
                        localStorage.setItem('appliedGiftCard', JSON.stringify(appliedGiftCardData));
                        localStorage.setItem('appliedPromo', JSON.stringify(savedPromoData));

                        // Show success message
                        toastr.success("Gift Card applied successfully!");
                    } else {
                        toastr.error(response.message || "Failed to apply gift card.");
                    }
                },
                error: function () {
                    toastr.error("An error occurred while applying the gift card.");
                }
            });
        }
    });

    // Handle cancel gift card action
    $(document).on('click', '#cancelGiftCardBtn', function () {
        toastr.error("Gift card removed.");
        localStorage.removeItem('appliedGiftCard');
        // Reset button and text
        $('#applyGiftCardBtn').show();  // Show the Apply Gift Card button
        $('#cancelGiftCardBtn').addClass('d-none');  // Hide the Cancel Gift Card button
        $('#applyGiftCardText').text('Have a Gift Card'); // Reset text
        
        // Optionally reset other UI elements (e.g., Total Amount) to original values
        setTimeout(function() {
            location.reload(); // Reload the page after closing modal to revert any changes
        }, 1500);  // Delay to show the toast message
    });

    // Handle removing error message dynamically while typing in the Gift Card Number field
    $('#giftCardNumber').on('input', function () {
        $('#giftCardNumberError').css('display', 'none');
    });

    // Handle removing error message dynamically while typing in the Gift Card PIN field
    $('#giftCardPin').on('input', function () {
        $('#giftCardPinError').css('display', 'none');
    });

    // Load saved gift card data from localStorage and update UI on page refresh
    var savedGiftCardData = localStorage.getItem('appliedGiftCard');
    if (savedGiftCardData) {
        savedGiftCardData = JSON.parse(savedGiftCardData);
        
        // Update text outside modal
        $('#applyGiftCardText').text('Gift Card Applied');
        $('#applyGiftCardBtn').text('Cancel');
        $('#applyGiftCardBtn').attr('id', 'cancelGiftCardBtn');

        // Update Total Amount and "You will save" text
        $('.giftinfo').each(function() {
            var title = $(this).find('div').first().text().trim();
            if (title === 'Total Amount') {
                $(this).find('div').last().text(savedGiftCardData.finalAmount.toFixed(2) + ' KD');
            }
        });

        var totalSavings = savedGiftCardData.totalSavings;
        $('#promoSavingsText').text("You will save " + totalSavings.toFixed(2) + " KD on this");
    }
});

</script>












































