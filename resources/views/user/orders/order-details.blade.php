@extends('user.layout.app')

@section('content')



<div class="customContainer common-padding">
    <div class="main-content">
        <div class="row">

            {{-- LEFT SIDE CART --}}
            <div class="col-lg-8">


                <div class="common-title d-flex justify-content-between align-items-center gap-3 mb-4">
                    <div class="d-flex gap-3">
                        <a href="{{ route('user.myOrders') }}">
                            <img src="{{ asset('user/assets/images/left-ic.svg') }}" class="img-fluid mt-1">
                        </a>
                        <div class="order-subtitle">
                            <h3>#{{ $orderData->order->order_id ?? 'N/A' }}</h3>
                            <p>Placed on
                                {{ \Carbon\Carbon::parse($orderData->order->created_at ?? now())->format('d/m/Y \a\t h:ia') }}
                            </p>
                        </div>
                    </div>


                    <!-- @php
                            $status = $orderData->delivery_status ?? 0;
                        @endphp -->

                    @if($orderData->payment_status == '2' || $orderData->payment_status == '3')
                    <div class="btn-outline1 btn-outline-red">Cancelled</div>
                    @elseif(in_array($orderData->delivery_status, ['1', '2']) && $orderData->payment_status !== '2' &&
                    $orderData->payment_status !== '3' )
                    <div class="btn-outline1 btn-ongoing">Ongoing</div>
                    @elseif($orderData->delivery_status == '3' && $orderData->return_type == '0')
                    <div class="btn-outline1 btn-outline-de">Delivered</div>
                    @elseif($orderData->delivery_status == '3' && $orderData->return_type == '1')
                    <div class="btn-outline1 btn-ongoing">Return Request</div>
                    @elseif($orderData->delivery_status == '3' && $orderData->return_type == '2')
                    <div class="btn-outline1 btn-ongoing">Exchange Request</div>
                    @endif
                </div>

                <div class="cart-panel">
                    <div class="cart-card">
                        <div class="card-left mb-2 d-flex">
                            <div>
                                @php
                                // Handle variant images
                                $images = is_array($orderData->variation_details->variant_image)
                                ? $orderData->variation_details->variant_image
                                : json_decode($orderData->variation_details->variant_image ?? '[]', true);

                                $image = $images[0] ?? ($orderData->product_details->image_url ??
                                asset('user/assets/images/categorie1.png'));
                                @endphp

                                <div class="cart-products me-3">
                                    <img src="{{ $image }}" alt="Product" class="img-fluid">
                                </div>
                            </div>

                            <div class="card-right d-flex w-100 justify-content-between">
                                <div class="product-info">
                                    <h5 class="product-title">
                                        {{ $orderData->product_details->product_name_en ?? 'N/A' }}</h5>

                                    <div class="psize d-flex gap-4">
                                        <span>Size: {{ $orderData->variation_details->size->name ?? 'N/A' }}</span>

                                        <span class="d-flex align-items-center gap-2">
                                            Color:
                                            <div class="colorbox"
                                                style="width:15px; height:15px; border-radius:3px; background: {{ $orderData->variation_details->color->hex_code ?? '#000' }};">
                                            </div>
                                        </span>

                                        <span>Qnt: {{ $orderData->quantity ?? 1 }}</span>
                                    </div>

                                    {{-- Price --}}
                                    <div class="price">
                                        <span
                                            class="price-current">{{ number_format($orderData->variation_details->final_price ?? 0, 2) }}
                                            KD</span>
                                        @if(isset($orderData->variation_details->actual_price) &&
                                        $orderData->variation_details->actual_price >
                                        $orderData->variation_details->final_price)
                                        <span
                                            class="price-old">{{ number_format($orderData->variation_details->actual_price, 2) }}
                                            KD</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="return-view">
                                    <!-- <div class="return-green">7 day return policy available</div> -->
                                    <div class="return-green">
                                        @if(isset($orderData->product_details))
                                        @if($orderData->product_details->product_return == '1')
                                        {{ $orderData->product_details->return_days }} day return policy available
                                        <br>
                                        @endif

                                        @if($orderData->product_details->product_exchangable == '1')
                                        {{ $orderData->product_details->exchangable_days }} day exchange policy
                                        available
                                        @endif
                                        @endif
                                    </div>
                                    @if($orderData->delivery_status !== '3' && $orderData->payment_status !== '2' &&
                                    $orderData->payment_status !== '3')
                                    <div class="d-none-1">
                                        <button class="btn btn-outline-red w-100 cancelBtn" data-bs-toggle="modal"
                                            data-bs-target="#cancelModal" data-order-id="{{ $orderData->order_id }}"
                                            data-order-details-id="{{ $orderData->id }}">
                                            Cancel Order
                                        </button>
                                    </div>
                                    @elseif($orderData->payment_status == '2')
                                    <!-- <div class="d-none-1">
                                            <button
                                                class="btn btn-outline-red w-100 cancelBtn">
                                                Cancelled
                                            </button>
                                        </div> -->
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Rating Section --}}

                    <div class="rating-pnl mt-3">
                        @if($orderData->delivery_status == '3')
                        <!-- <div class="rate-p">
                                <h5 class="product-title">Rate this product</h5>
                                <div class="order-ratings rating-widget">
                                    <div class="rating" data-bs-toggle="modal" data-bs-target="#ratingModal">
                                        @for($i = 1; $i <= 5; $i++)
                                            <label><i class="fas fa-2x fa-star"></i></label>
                                        @endfor
                                    </div>
                                </div>
                            </div> -->

                        <div class="rate-p">

                            @if(!$orderData->UserRatingReviewProvide)

                            <h5 class="product-title">Rate this product</h5>
                            <div class="order-ratings rating-widget">
                                <div class="rating" data-bs-toggle="modal" data-bs-target="#ratingModal"
                                    data-order-id="{{ $orderData->order_id }}"
                                    data-order-details-id="{{ $orderData->id }}"
                                    data-product-id="{{ $orderData->product_id }}"
                                    data-store-id="{{ $orderData->product_details->store->id }}">
                                    @for($i = 1; $i <= 5; $i++) <label><i class="fas fa-2x fa-star"></i></label>
                                        @endfor
                                </div>
                            </div>

                            @endif
                        </div>


                        @endif

                        @if($orderData->delivery_status == '3' && !in_array($orderData->return_type, ['1', '2']) &&
                        $orderData->payment_status == '1')
                        <div class="d-flex gap-3">
                            <button class="btn btn-outline-red exchangeBtn" data-bs-toggle="modal"
                                data-bs-target="#exchangeModal" data-order-id="{{ $orderData->order_id }}"
                                data-order-details-id="{{ $orderData->id }}"
                                data-product-id="{{ $orderData->product_id }}"
                                data-size-id="{{ $orderData->variation_details->size->id }}"
                                data-color-id="{{ $orderData->variation_details->color->id }}" style="width:130px;">
                                Exchange
                            </button>
                            <button class="btn btn-outline-red returnBtn" data-bs-toggle="modal"
                                data-bs-target="#returnModal" data-order-id="{{ $orderData->order_id }}"
                                data-order-details-id="{{ $orderData->id }}"
                                style="width:130px; background:#D53B36; color:#fff;">
                                Return
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
                <!-- </div> -->

                <!-- relivent product  -->


                <h1> Relevant product </h1>

                @foreach($orderData->allOtherOrderVarient as $key=>$val)

                <div class="cart-panel">

                    <div class="card-left mb-2 d-flex">
                        <div>
                            @php
                            // Handle variant images
                            $images = is_array($val->variation_details->variant_image)
                            ? $val->variation_details->variant_image
                            : json_decode($val->variation_details->variant_image ?? '[]', true);

                            $image = $images[0] ?? ($val->product_details->image_url ??
                            asset('user/assets/images/categorie1.png'));
                            @endphp

                            <div class="cart-products me-3">
                                <a href="{{ route('user.order_details', ['id' => $val->order_id]) }}?orderdetails_id={{ $val->id }}"
                                    class="link-content"> <img src="{{ $image }}" alt="Product" class="img-fluid"> </a>
                            </div>
                        </div>

                        <div class="card-right d-flex w-100 justify-content-between">
                            <div class="product-info">
                                <h5 class="product-title">
                                    {{ $val->product_details->product_name_en ?? 'N/A' }}</h5>

                                <div class="psize d-flex gap-4">
                                    <span>Size: {{ $val->variation_details->size->name ?? 'N/A' }}</span>

                                    <span class="d-flex align-items-center gap-2">
                                        Color:
                                        <div class="colorbox"
                                            style="width:15px; height:15px; border-radius:3px; background: {{ $val->variation_details->color->hex_code ?? '#000' }};">
                                        </div>
                                    </span>

                                    <span>Qnt: {{ $val->quantity ?? 1 }}</span>
                                </div>

                                {{-- Price --}}
                                <div class="price">
                                    <span
                                        class="price-current">{{ number_format($val->variation_details->final_price ?? 0, 2) }}
                                        KD</span>
                                    @if(isset($val->variation_details->actual_price) &&
                                    $val->variation_details->actual_price >
                                    $val->variation_details->final_price)
                                    <span
                                        class="price-old">{{ number_format($val->variation_details->actual_price, 2) }}
                                        KD</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- relivent product -->



                {{-- BILLING DETAILS --}}
                <div class="gift-pnl mt-4">
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>Total Quantity</div>
                            <div>{{$orderData->quantity}}</div>
                        </div>
                        <div class="giftinfo">
                            <div>Address </div>
                            <div>{{$orderData->order->delivery_details->address}}</div>
                        </div>
                        <!-- <div class="giftinfo">
                            <div>Custom details</div>
                            <div>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</div>
                        </div> -->
                    </div>
                </div>

                {{-- DELIVERY instruction --}}
                <!-- <div class="gift-pnl mt-4">
                    <h6>Delivery instruction</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio, deserunt? Quam unde
                                officiis tenetur officia, accusamus,</p>
                        </div>
                    </div>
                </div> -->
                {{-- Shipping address --}}
                <div class="gift-pnl mt-4">

                    @if((isset($orderData->return_type) && in_array($orderData->return_type, ['1','2'])))

                    <h6>Pickup Address</h6>

                    @else
                    <h6>Shipping Address</h6>

                    @endif



                    <div class="border-1">
                        <div class="giftinfo">
                            <p>{{$orderData->order->delivery_details->address}}
                                {{$orderData->order->delivery_details->state}}
                                {{$orderData->order->delivery_details->postal_code}}
                                {{$orderData->order->delivery_details->country_name}}</p>
                        </div>
                    </div>
                </div>

                {{-- Cancellation Details --}}
                @if((isset($orderData->return_type) && in_array($orderData->return_type, ['1','2'])) ||
                $orderData->payment_status === '2' )
                <div class="gift-pnl mt-4">
                    <h6>
                        @if($orderData->return_type == '1')
                        Return Details
                        @elseif($orderData->return_type == '2')
                        Exchange Details
                        @elseif($orderData->payment_status == '2')
                        Cancellation Details
                        @endif
                    </h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>
                                @if($orderData->return_type == '1')
                                Returned on
                                @elseif($orderData->return_type == '2')
                                Exchange on
                                @elseif($orderData->payment_status == '2')
                                Cancelled on

                                </br>
                                Cancellation Id

                                @endif
                            </div>

                            <div>
                                {{ \Carbon\Carbon::parse($orderData->updated_at)->format('d/m/Y \a\t h:i') }}

                                @if($orderData->payment_status == '2' || $orderData->payment_status == '3' )
                                </br />
                                {{$orderData->order->order_id}}
                                @endif

                            </div>
                        </div>




                    </div>
                </div>
                @endif

                @if(isset($orderData->return_type))
                @if($orderData->return_type == '1')
                <div class="gift-pnl mt-4">
                    <h6>Return Reason</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <p>{{ $orderData->return_reason ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                @elseif($orderData->return_type == '2')
                <div class="gift-pnl mt-4">
                    <h6>Exchange Reason</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <p>{{ $orderData->exchange_reason ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                @elseif($orderData->payment_status == '2')
                <div class="gift-pnl mt-4">
                    <h6>Cancellation Reason</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <p>{{ $orderData->cancel_reason ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                @endif
                @endif


                {{-- Uploaded images --}}

                @if(isset($orderData->return_type) && $orderData->return_type == 1)
                @php
                $returnImages = json_decode($orderData->return_image ?? '[]', true);
                @endphp

                @if(!empty($returnImages))
                <div class="gift-pnl mt-4">
                    <h6>Uploaded images</h6>
                    <div class="border-1">
                        <div class="giftinfo d-flex flex-wrap gap-2">
                            @foreach($returnImages as $img)
                            <div class="image-upload">
                                <img src="{{ $img }}" class="img-fluid" alt="Return Image">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
                @endif




            </div>

            {{-- RIGHT SIDE --}}

            <div class="col-lg-4">
                <div class="orderstatus p-3 mb-4">
                    <div class="d-flex justify-content-between">
                        <div class="order-t">Order Status</div>
                        @if($orderData->payment_status=='2' || $orderData->payment_status=='3' ||
                        $orderData->delivery_status=='4')
                        <div class="order-14">Cancelled On
                            {{ \Carbon\Carbon::parse($orderData->updated_at)->format('d/m/Y') }}</div>
                        @else
                        <div class="order-14">Expected Delivery
                            {{ \Carbon\Carbon::parse($orderData->created_at)->addDays(6)->format('d/m/Y') }}</div>
                        @endif
                    </div>

                    <!-- When Order Is cancelled  -->

                    @if($orderData->payment_status=='2' || $orderData->payment_status=='3')


                    <div class="orderstatus p-3 mb-4">
                        <div class="order-view-lists mt-3">
                            <div class="or-box">
                                <div class="fill-box">
                                    <img src="{{ asset('user/assets/images/order-ic/sing-ic.svg') }}" class="img-fluid">
                                </div>
                                <div>Confirmed</div>
                            </div>

                            <div class="or-box">
                                <div class="fill-box" style="background:#D72E04;">
                                    <img src="{{ asset('user/assets/images/order-ic/box.svg') }}" class="img-fluid"
                                        style="filter: brightness(26);">
                                </div>
                                <div style="color:#D72E04;">Cancelled</div>
                            </div>
                        </div>
                    </div>

                    @else

                    <!-- when Order is Not Cancelled -->



                    <div class="order-view-lists mt-3">
                        <div class="or-box">
                            <div class="fill-box">
                                <img src="{{ asset('user/assets/images/order-ic/sing-ic.svg') }}" class="img-fluid">
                            </div>
                            <div>Confirmed</div>
                        </div>
                        @if($orderData->delivery_status=='2.1' || $orderData->delivery_status=='2.2')
                        <div class="or-box">
                            <div class="fill-box">
                                <img src="{{ asset('user/assets/images/order-ic/sing-ic.svg') }}" class="img-fluid">
                            </div>
                            <div>Shipped</div>
                        </div>
                        @else
                        <div class="or-box">
                            <div class="fill-box">
                                <img src="{{ asset('user/assets/images/order-ic/tax.svg') }}" class="img-fluid">
                            </div>
                            <div>Shipped</div>
                        </div>
                        @endif
                        @if($orderData->delivery_status=='2.2')
                        <div class="or-box">
                            <div class="fill-box">
                                <img src="{{ asset('user/assets/images/order-ic/sing-ic.svg') }}" class="img-fluid">
                            </div>
                            <div>On the Way</div>
                        </div>
                        @else
                        <div class="or-box">
                            <div class="fill-box">
                                <img src="{{ asset('user/assets/images/order-ic/van.svg') }}" class="img-fluid">
                            </div>
                            <div>On the Way</div>
                        </div>
                        @endif
                        @if(($orderData->delivery_status=='2.1' || $orderData->delivery_status=='2.2' ||
                        $orderData->delivery_status=='3') && $orderData->return_type!=='0')
                        <div class="or-box">
                            <div class="fill-box" style="background:#fff;">
                                <img src="{{ asset('user/assets/images/order-ic/sing-ic.svg') }}" class="img-fluid">
                            </div>
                            <div>Delivered</div>
                        </div>
                        @else
                        <div class="or-box">
                            <div class="fill-box" style="background:linear-gradient(180.99deg, #DFBF8F -53.71%, #6E4527 154.28%);">
                                <img src="{{ asset('user/assets/images/order-ic/delivered-2.svg') }}" class="img-fluid">
                            </div>
                            <div>Delivered</div>
                        </div>
                        @endif
                    </div>

                    @endif
                </div>

                <!-- <div class="orderstatus p-3 mb-4">
                    <div class="d-flex justify-content-between">
                        <div class="order-t">Order Status</div>
                    </div>
                    <div class="order-view-lists mt-3">
                        <div class="or-box">
                            <div class="fill-box">
                                <img src="{{ asset('user/assets/images/order-ic/sing-ic.svg') }}" class="img-fluid">
                            </div>
                            <div>Confirmed</div>
                        </div>

                        <div class="or-box">
                            <div class="fill-box" style="background:#D72E04;">
                                <img src="{{ asset('user/assets/images/order-ic/box.svg') }}" class="img-fluid"
                                    style="filter: brightness(26);">
                            </div>
                            <div style="color:#D72E04;">Delivered</div>
                        </div>
                    </div>
                </div> -->


                <h6>Billing Details</h6>
                <div class="gift-pnl mt-0">
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>Total MRP</div>
                            <div>{{$orderData->order->total_mrp }} KD</div>
                        </div>
                        <div class="giftinfo">
                            <div>Discount on MRP </div>
                            <div class="discount">{{$orderData->order->discount_mrp }} KD</div>
                        </div>
                        @if(isset($orderData->order->promocode_value) && $orderData->order->promocode_value != 0)
                        <div class="giftinfo">
                            <div>Coupon Discount</div>
                            <div class="discount">{{ $orderData->order->promocode_value }} KD</div>
                        </div>
                        @endif

                        @if(isset($orderData->order->giftcard_amount) && $orderData->order->giftcard_amount != 0)
                        <div class="giftinfo">
                            <div>Gift Card Discount</div>
                            <div class="discount">{{ $orderData->order->giftcard_amount }} KD</div>
                        </div>
                        @endif

                        <div class="giftinfo">
                            <div>Shipping Free </div>
                            <div>{{$orderData->order->shipping_fees }} KD</div>
                        </div>
                        <div class="giftinfo">
                            <div>Tax(if any)</div>
                            <div>{{$orderData->order->tax }} KD</div>
                        </div>
                        <div class="giftinfo">
                            <div>Total Amount</div>
                            <div>{{$orderData->order->total_amount }} KD</div>
                        </div>
                    </div>
                </div>
                @php
                $discountMRP = $orderData->order->discount_mrp ?? 0;
                $couponDiscount = $orderData->order->promocode_value ?? 0;
                $giftcardDiscount = $orderData->order->giftcard_amount ?? 0;

                $totalDiscount = $discountMRP + $couponDiscount + $giftcardDiscount;
                @endphp
                <div class="return-green">You will save {{$totalDiscount }} KD on this</div>


                <div class="gift-pnl mt-3">
                    <div class="giftinfo">
                        <h6>Paid by</h6>
                        @if(isset($orderData->order->transaction_id) && $orderData->order->transaction_id != 0)
                        <div class="trans" style="color:#714829;font-size:12px;">Transaction Id:
                            {{$orderData->order->transaction_id }}</div>
                        @endif
                    </div>
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>{{$orderData->order->total_amount }} KD</div>
                            <!-- <div>Paid By Card</div> -->
                            <div>
                                @php
                                $paymentMethod = $orderData->order->payment_method ?? 0;
                                $paymentStatus = $orderData->order->payment_status ?? 0;
                                @endphp

                                @if($paymentMethod == '1')
                                Paid By Card
                                @elseif($paymentMethod == '2')
                                Paid By Wallet
                                @elseif($paymentMethod == '3')
                                @if($paymentStatus == '1')
                                Cash On Delivery
                                @else
                                COD
                                @endif
                                @else
                                Payment Info Not Available
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


                <div class="mt-4">
                    <a href="{{ url('Invoice', ['order_id' => $orderData->order->order_id]) }}" target="_blank"
                        class="customBtn8  mb-3 text-decoration-none">
                        Download Invoice
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Cancel order -->

<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Select Reason</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="reason-list">

                    @foreach ($cancelReasons as $index => $reason)
                    <label class="custom-radio mb-3">
                        <input type="radio" name="cancel_reason" value="{{ $reason->reason_english }}"
                            {{ $index === 0 ? 'checked' : '' }}>
                        <span class="radio-mark"></span>
                        <div class="label-content">
                            <div class="title">{{ $reason->reason_english }}</div>
                        </div>
                    </label>
                    @endforeach

                    <label class="custom-radio mb-3">
                        <input type="radio" name="cancel_reason" value="other">
                        <span class="radio-mark"></span>
                        <div class="label-content">
                            <div class="title">Other</div>
                        </div>
                    </label>
                </div>

                <!-- Textarea -->
                <div class="form-group mt-2 d-none" id="otherReasonWrapper">
                    <textarea id="otherReason" rows="4" class="form-control" placeholder="Write here"></textarea>

                    <small class="text-danger d-none" id="otherReasonError">
                        Please provide the reason for cancellation
                    </small>
                </div>

                <div class="mt-4">
                    <button type="button" class="customBtn white-btn" id="submitCancel">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Return Modal -->


<!-- Return Modal -->
<div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5">Return Request</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="gift-panel-list">
                    <h6>Select Reason</h6>

                    <div class="reason-list" id="returnReasonList">
                        @foreach ($returnReasons as $index => $reason)
                        <label class="custom-radio mb-3">
                            <input type="radio" name="return_reason" value="{{ $reason->reason_english }}"
                                {{ $index === 0 ? 'checked' : '' }}>
                            <span class="radio-mark"></span>
                            <div class="label-content">
                                <div class="title">{{ $reason->reason_english }}</div>
                            </div>
                        </label>
                        @endforeach
                        <label class="custom-radio mb-3">
                            <input type="radio" name="return_reason" value="other">
                            <span class="radio-mark"></span>
                            <div class="label-content">
                                <div class="title">Other</div>
                            </div>
                        </label>
                    </div>

                    <div class="form-group w-100 py-2 mb-3 d-none" id="returnOtherWrapper">
                        <textarea id="returnOtherText" rows="3" class="form-control pline-10"
                            placeholder="Write here"></textarea>
                        <small class="text-danger d-none" id="returnOtherError">Please provide the reason for
                            return</small>
                    </div>

                    <h6>Upload Image (Optional)</h6>
                    <div class="border-1 p-3">
                        <div class="text-center">
                            <label for="returnImg" class="requestbox">
                                <div class="image-upload-2 mb-1">
                                    <img src="{{ asset('user/assets/images/upload-icon.svg') }}" class="img-fluid"
                                        alt="upload">
                                </div>
                                <div style="font-size:13px;color:#7a7979;">Click to upload images</div>
                                <input type="file" id="returnImg" multiple accept="image/*" style="display:none;">
                            </label>
                        </div>
                    </div>

                    <div class="mt-2">
                        <div id="previewReturn" class="preview-box1 d-flex flex-wrap gap-2"></div>
                    </div>

                    <div class="mt-4">
                        <button type="button" class="customBtn white-btn" id="submitReturn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Exchange Modal -->

<div class="modal fade" id="exchangeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Exchange Request</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <h6>Select Reason</h6>

                <div class="reason-list">

                    @foreach ($exchangeReasons as $index => $reason)
                    <label class="custom-radio mb-3">
                        <input type="radio" name="exchange_reason" value="{{ $reason->reason_english }}"
                            {{ $index === 0 ? 'checked' : '' }}>
                        <span class="radio-mark"></span>
                        <div class="label-content">
                            <div class="title">{{ $reason->reason_english }}</div>
                        </div>
                    </label>
                    @endforeach

                    <!-- Other -->
                    <label class="custom-radio mb-3">
                        <input type="radio" name="exchange_reason" value="other">
                        <span class="radio-mark"></span>
                        <div class="label-content">
                            <div class="title">Other</div>
                        </div>
                    </label>

                </div>

                <!-- Textarea -->
                <div class="form-group mb-3 d-none" id="exchangeOtherWrapper">
                    <textarea id="exchangeOtherText" rows="3" class="form-control" placeholder="Write here"></textarea>

                    <small class="text-danger d-none" id="exchangeOtherError">
                        Please provide the reason for exchange
                    </small>
                </div>
                <h6>Select Available Size</h6>
                <!-- <div class="reason-list">
                        <label class="custom-radio mb-3">
                            <input type="radio" name="filter" value="1" checked>
                            <span class="radio-mark"></span>
                            <div class="label-content">
                                <div class="title">XS</div>
                            </div>
                        </label>
                        <label class="custom-radio mb-3">
                            <input type="radio" name="filter" value="1">
                            <span class="radio-mark"></span>
                            <div class="label-content">
                                <div class="title">M</div>
                            </div>
                        </label>
                    </div> -->
                <div class="reason-list" id="exchangeSizeWrapper">
                </div>

                <div class="mt-4">
                    <button type="button" class="customBtn white-btn" id="submitExchange">
                        Submit
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>


<!-- Rating section Modal -->
<div class="modal fade" id="ratingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5">Rate this product</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="gift-panel-list">

                    <!-- Product Rating -->
                    <div class="reason-list rating-widget ">
                        <h6>Rate Product</h6>
                        <div class="rating py-2">
                            <input id="product-rating-1" type="radio" name="raterating" value="1" />
                            <label for="product-rating-1"><i class="fas fa-2x fa-star"></i></label>
                            <input id="product-rating-2" type="radio" name="raterating" value="2" />
                            <label for="product-rating-2"><i class="fas fa-2x fa-star"></i></label>
                            <input id="product-rating-3" type="radio" name="raterating" value="3" />
                            <label for="product-rating-3"><i class="fas fa-2x fa-star"></i></label>
                            <input id="product-rating-4" type="radio" name="raterating" value="4" />
                            <label for="product-rating-4"><i class="fas fa-2x fa-star"></i></label>
                            <input id="product-rating-5" type="radio" name="raterating" value="5" checked />
                            <label for="product-rating-5"><i class="fas fa-2x fa-star"></i></label>
                        </div>
                    </div>

                    <!-- Product Review Text & Image -->
                    <div class="form-group w-100 py-2 mb-3 position-relative">
                        <p>Write Review</p>
                        <textarea rows="1" class="form-control pline-10" placeholder="Write here"></textarea>
                        <small class="text-danger product-error" style="display:none;"></small>
                        <div class="paperhover">
                            <label><input type="file" id="images" multiple accept="image/*">
                                <i class="bi bi-paperclip"></i>
                            </label>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div id="preview" class="preview-box1"></div>
                    </div>

                    <!-- Store Rating -->
                    <div class="reason-list rating-widget mt-2">
                        <h6>Rate Store</h6>
                        <div class="rating py-2">
                            <input id="store-rating-1" type="radio" name="storerating" value="1" />
                            <label for="store-rating-1"><i class="fas fa-2x fa-star"></i></label>
                            <input id="store-rating-2" type="radio" name="storerating" value="2" />
                            <label for="store-rating-2"><i class="fas fa-2x fa-star"></i></label>
                            <input id="store-rating-3" type="radio" name="storerating" value="3" />
                            <label for="store-rating-3"><i class="fas fa-2x fa-star"></i></label>
                            <input id="store-rating-4" type="radio" name="storerating" value="4" />
                            <label for="store-rating-4"><i class="fas fa-2x fa-star"></i></label>
                            <input id="store-rating-5" type="radio" name="storerating" value="5" checked />
                            <label for="store-rating-5"><i class="fas fa-2x fa-star"></i></label>
                        </div>
                    </div>

                    <!-- Store Review Text & Image -->
                    <div class="form-group w-100 py-2 mb-3 position-relative">
                        <p>Write Review</p>
                        <textarea rows="1" class="form-control pline-10" placeholder="Write here"></textarea>
                        <small class="text-danger store-error" style="display:none;"></small>
                        <div class="paperhover">
                            <label><input type="file" id="reviewpic" multiple accept="image/*">
                                <i class="bi bi-paperclip"></i>
                            </label>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div id="preview1" class="preview-box1"></div>
                    </div>

                    <!-- Submit Review Button -->
                    <div class="mt-4">
                        <button type="button" class="customBtn mb-3 white-btn">Submit Review</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>






@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    let orderId = null;
    let orderDetailsId = null;

    document.querySelectorAll('.cancelBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            orderId = this.dataset.orderId;
            // console.log(orderId);
            orderDetailsId = this.dataset.orderDetailsId;
            // console.log(orderDetailsId);
        });
    });

    const otherWrapper = document.getElementById('otherReasonWrapper');
    const otherInput = document.getElementById('otherReason');
    const errorMsg = document.getElementById('otherReasonError');
    const submitBtn = document.getElementById('submitCancel');

    if (!otherWrapper || !otherInput || !submitBtn) {
        console.error('Cancel modal elements not found');
        return;
    }

    document.querySelectorAll('input[name="cancel_reason"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'other') {
                otherWrapper.classList.remove('d-none');
            } else {
                otherWrapper.classList.add('d-none');
                otherInput.value = '';
                errorMsg.classList.add('d-none');
            }
        });
    });

    // Hide error while typing
    otherInput.addEventListener('input', function() {
        errorMsg.classList.add('d-none');
    });

    // Submit
    submitBtn.addEventListener('click', function() {

        const selectedRadio = document.querySelector('input[name="cancel_reason"]:checked');

        if (!selectedRadio) {
            toastr.error('Please select a reason');
            return;
        }

        let reason = selectedRadio.value;

        if (reason === 'other') {
            if (!otherInput.value.trim()) {
                errorMsg.classList.remove('d-none');
                return;
            }
            reason = otherInput.value.trim();
        }

        fetch("{{ route('user.cancel_order') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    order_id: orderId,
                    orderdetails_id: orderDetailsId,
                    cancel_reason: reason
                })
            })
            .then(res => res.json())
            .then(response => {
                toastr.success(response.message);

                setTimeout(() => {
                    window.location.href = "{{ route('user.myOrders') }}";
                }, 1500);
            })
            .catch(() => {
                toastr.error('Something went wrong');
            });
    });

});
</script>

<!-- exchange -->


<script>
document.addEventListener('DOMContentLoaded', function() {

    let exchangeOrderId = null;
    let orderDetailsId = null;
    let productId = null;
    let currentSizeId = null;
    let currentColorId = null; // added

    const wrapper = document.getElementById('exchangeOtherWrapper');
    const textarea = document.getElementById('exchangeOtherText');
    const error = document.getElementById('exchangeOtherError');
    const submitBtn = document.getElementById('submitExchange');
    const sizeWrapper = document.getElementById('exchangeSizeWrapper');

    // Capture order, product, size, color id
    document.querySelectorAll('.exchangeBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            exchangeOrderId = this.dataset.orderId;
            productId = this.dataset.productId;
            currentSizeId = this.dataset.sizeId;
            currentColorId = this.dataset.colorId;
            orderDetailsId = this.dataset.orderDetailsId;
            //console.log(currentColorId);

            // Fetch available sizes
            fetchAvailableSizes(productId, currentSizeId, currentColorId);
        });
    });

    // Toggle textarea for "Other" reason
    document.querySelectorAll('input[name="exchange_reason"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'other') {
                wrapper.classList.remove('d-none');
            } else {
                wrapper.classList.add('d-none');
                textarea.value = '';
                error.classList.add('d-none');
            }
        });
    });

    // Hide error while typing
    textarea.addEventListener('input', function() {
        error.classList.add('d-none');
    });

    // Submit exchange request
    submitBtn.addEventListener('click', function() {

        const selectedReason = document.querySelector('input[name="exchange_reason"]:checked').value;
        let reason = selectedReason;

        if (selectedReason === 'other') {
            if (!textarea.value.trim()) {
                error.classList.remove('d-none');
                return;
            }
            reason = textarea.value.trim();
        }

        const selectedSize = document.querySelector('input[name="exchange_size"]:checked');
        if (!selectedSize) {
            toastr.error('Please select a size');
            return;
        }

        const sizeId = selectedSize.value;

        fetch("{{ route('user.exchange_order') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    order_id: exchangeOrderId,
                    exchange_reason: reason,
                    orderdetails_id: orderDetailsId,
                    new_size: sizeId
                })
            })
            .then(res => res.json())
            .then(response => {
                if (response.status === 'success') {
                    toastr.success(response.message);
                    setTimeout(() => {
                        window.location.href = "{{ route('user.myOrders') }}";
                    }, 1500);
                } else {
                    toastr.error(response.message || 'Something went wrong');
                }
            })
            .catch(() => {
                toastr.error('Something went wrong');
            });
    });

    // Fetch available sizes function
    function fetchAvailableSizes(productId, sizeId, colorId) {
        // Show loading text
        sizeWrapper.innerHTML = '<p>Loading...</p>';

        fetch("{{ route('user.getAvailableSize') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    product_id: productId,
                    size_id: sizeId,
                    color_id: colorId
                })
            })
            .then(res => res.json())
            .then(response => {
                console.log(response);

                // Extract the actual sizes array
                const sizes = response.data.data || [];

                if (response.status === 'success' && sizes.length > 0) {
                    let html = '';
                    sizes.forEach((size, index) => {
                        html += `
                        <label class="custom-radio mb-3">
                            <input type="radio" name="exchange_size" value="${size.id}" ${index === 0 ? 'checked' : ''}>
                            <span class="radio-mark"></span>
                            <div class="label-content">
                                <div class="title">${size.name}</div>
                            </div>
                        </label>
                    `;
                    });
                    sizeWrapper.innerHTML = html;
                } else {
                    sizeWrapper.innerHTML = '<p>No available sizes</p>';
                }
            })
            .catch(err => {
                console.error("Error fetching sizes:", err);
                sizeWrapper.innerHTML = '<p>Failed to fetch sizes</p>';
            });
    }


});
</script>

<!-- return -->
<script>
document.addEventListener('DOMContentLoaded', function() {

    const fileInput = document.getElementById('returnImg');
    const previewBox = document.getElementById('previewReturn');
    const submitBtn = document.getElementById('submitReturn');

    const otherWrapper = document.getElementById('returnOtherWrapper');
    const otherText = document.getElementById('returnOtherText');
    const otherError = document.getElementById('returnOtherError');

    let selectedFiles = [];
    let orderId = null;
    let orderDetailsId = null;

    /* ===============================
       Capture order data from button
    =============================== */
    document.querySelectorAll('.returnBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            orderId = this.dataset.orderId;
            orderDetailsId = this.dataset.orderDetailsId;
        });
    });

    /* ===============================
       Toggle Other textarea
    =============================== */
    document.querySelectorAll('input[name="return_reason"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'other') {
                otherWrapper.classList.remove('d-none');
            } else {
                otherWrapper.classList.add('d-none');
                otherText.value = '';
                otherError.classList.add('d-none');
            }
        });
    });

    otherText.addEventListener('input', function() {
        otherError.classList.add('d-none');
    });

    /* ===============================
       Image upload (append)
    =============================== */
    fileInput.addEventListener('change', function() {

        Array.from(this.files).forEach(file => {
            if (!file.type.startsWith('image/')) return;

            const exists = selectedFiles.some(
                f => f.name === file.name && f.size === file.size
            );
            if (!exists) selectedFiles.push(file);
        });

        renderPreviews();
        fileInput.value = '';
    });

    function renderPreviews() {
        previewBox.innerHTML = '';

        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = e => {
                previewBox.insertAdjacentHTML('beforeend', `
                    <div class="reviewImg position-relative" data-index="${index}">
                        <img src="${e.target.result}">
                        <span class="remove-img">&times;</span>
                    </div>
                `);
            };
            reader.readAsDataURL(file);
        });
    }

    previewBox.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-img')) {
            const index = e.target.closest('.reviewImg').dataset.index;
            selectedFiles.splice(index, 1);
            renderPreviews();
        }
    });

    /* ===============================
       Submit Return
    =============================== */
    submitBtn.addEventListener('click', function() {

        const selectedReason = document.querySelector('input[name="return_reason"]:checked');

        if (!selectedReason) {
            toastr.error('Please select a reason');
            return;
        }

        let reason = selectedReason.value;

        if (reason === 'other') {
            if (!otherText.value.trim()) {
                otherError.classList.remove('d-none');
                return;
            }
            reason = otherText.value.trim();
        }

        const formData = new FormData();
        formData.append('order_id', orderId);
        formData.append('orderdetails_id', orderDetailsId);
        formData.append('return_reason', reason);

        selectedFiles.forEach(file => {
            formData.append('images[]', file);
        });

        fetch("{{ route('user.return_order') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: formData
            })
            .then(res => res.json())
            .then(response => {
                if (response.status === 'success') {
                    toastr.success(response.message);
                    setTimeout(() => {
                        window.location.href = "{{ route('user.myOrders') }}";
                    }, 1500);
                } else if (response.status === 'error') {
                    toastr.error(response.message || 'Something went wrong');
                }
            })
            .catch(error => {
                toastr.error('Something went wrong');
            });
    });

});
</script>


<!-- <script>
    document.addEventListener('DOMContentLoaded', function () {

    // ===== STAR RATING FUNCTION =====
    function setupRating(ratingName) {
        const inputs = document.querySelectorAll(`#ratingModal input[name="${ratingName}"]`);
        inputs.forEach((input, idx) => {
            input.addEventListener('change', () => {
                inputs.forEach((i, j) => {
                    const label = i.nextElementSibling;
                    if (j <= idx) label.classList.add('selected');
                    else label.classList.remove('selected');
                });
            });

            // Initialize 5-star selection
            if (input.value === '5') {
                input.checked = true;
                input.dispatchEvent(new Event('change'));
            }
        });
    }

    setupRating('raterating'); // Product
    setupRating('storerating'); // Store

    // ===== IMAGE PREVIEW =====
    function setupImagePreview(fileInputId, previewId, textarea) {
        const input = document.getElementById(fileInputId);
        const preview = document.getElementById(previewId);

        input.addEventListener('change', function () {
            [...this.files].forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const div = document.createElement('div');
                    div.className = 'reviewImg position-relative d-inline-block me-2 mb-2';
                    div.innerHTML = `
                        <img src="${e.target.result}" style="width:80px; height:80px; object-fit:cover; border-radius:5px;">
                        <span style="
                            position:absolute;
                            top:-5px;
                            right:-5px;
                            background:red;
                            color:white;
                            width:18px;
                            height:18px;
                            text-align:center;
                            line-height:18px;
                            border-radius:50%;
                            cursor:pointer;
                            font-weight:bold;">&times;</span>`;
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            });

            const error = textarea.parentElement.querySelector('.text-danger');
            if (error) error.classList.add('d-none');
        });

        preview.addEventListener('click', function (e) {
            if (e.target.tagName === 'SPAN') e.target.parentElement.remove();
        });

        textarea.addEventListener('input', () => {
            const error = textarea.parentElement.querySelector('.text-danger');
            if (error) error.classList.add('d-none');
        });
    }

    const textareas = document.querySelectorAll('#ratingModal .form-group textarea');
    setupImagePreview('images', 'preview', textareas[0]);
    setupImagePreview('reviewpic', 'preview1', textareas[1]);

    // ===== SET MODAL DATA ON OPEN =====
    const ratingTriggers = document.querySelectorAll('.order-ratings .rating');
    const submitBtn = document.querySelector('#ratingModal .customBtn');

    ratingTriggers.forEach(trigger => {
        trigger.addEventListener('click', function () {
            submitBtn.dataset.orderId = this.dataset.orderId;
            submitBtn.dataset.orderDetailsId = this.dataset.orderDetailsId;
            submitBtn.dataset.productId = this.dataset.productId;
            submitBtn.dataset.storeId = this.dataset.storeId;

            // Reset previous form
            textareas.forEach(t => t.value = '');
            document.getElementById('preview').innerHTML = '';
            document.getElementById('preview1').innerHTML = '';

            // Reset stars to 5
            setupRating('raterating');
            setupRating('storerating');
        });
    });

    // ===== SUBMIT REVIEW =====
    submitBtn.addEventListener('click', function () {
        const productTextarea = textareas[0];
        const storeTextarea = textareas[1];
        const productImages = document.getElementById('preview').querySelectorAll('img');
        const storeImages = document.getElementById('preview1').querySelectorAll('img');

        let valid = true;
        document.querySelectorAll('#ratingModal .text-danger').forEach(e => e.remove());

        if (!productTextarea.value.trim() && productImages.length === 0) {
            const error = document.createElement('small');
            error.className = 'text-danger d-block';
            error.textContent = 'Please enter a product review or upload an image.';
            productTextarea.parentElement.appendChild(error);
            valid = false;
        }

        if (!storeTextarea.value.trim() && storeImages.length === 0) {
            const error = document.createElement('small');
            error.className = 'text-danger d-block';
            error.textContent = 'Please enter a store review or upload an image.';
            storeTextarea.parentElement.appendChild(error);
            valid = false;
        }

        if (!valid) return;

        const productRating = document.querySelector('input[name="raterating"]:checked').value;
        const storeRating = document.querySelector('input[name="storerating"]:checked').value;

        const formData = new FormData();
        formData.append('order_id', submitBtn.dataset.orderId);
        formData.append('orderdetails_id', submitBtn.dataset.orderDetailsId);
        formData.append('product_id', submitBtn.dataset.productId);
        formData.append('store_id', submitBtn.dataset.storeId);
        formData.append('product_rating', productRating);
        formData.append('store_rating', storeRating);
        if (productTextarea.value.trim()) formData.append('product_review', productTextarea.value.trim());
        if (storeTextarea.value.trim()) formData.append('store_review', storeTextarea.value.trim());

        productImages.forEach((img) => formData.append('product_image[]', img.src));
        storeImages.forEach((img) => formData.append('store_image[]', img.src));

        fetch("{{ route('user.submitRating') }}", {
            method: 'POST',
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: formData
        })
        .then(res => res.json())
        .then(response => {
            if (response.status === 'success') {
                toastr.success(response.message);
                const modal = bootstrap.Modal.getInstance(document.getElementById('ratingModal'));
                modal.hide();
            } else {
                toastr.error(response.message || 'Something went wrong');
            }
        })
        .catch(() => toastr.error('Something went wrong'));
    });
});

</script> -->

<script>
document.addEventListener('DOMContentLoaded', function() {

    // ===== STAR RATING FUNCTION =====
    function setupRating(ratingName) {
        const inputs = document.querySelectorAll(`input[name="${ratingName}"]`);
        inputs.forEach((input, idx) => {
            input.addEventListener('change', () => {
                inputs.forEach((i, j) => {
                    const label = i.nextElementSibling;
                    if (j <= idx) label.classList.add('selected');
                    else label.classList.remove('selected');
                });
            });

            // Initialize 5-star selection
            if (input.value === '5') {
                input.checked = true;
                input.dispatchEvent(new Event('change'));
            }
        });
    }

    setupRating('raterating'); // Product
    setupRating('storerating'); // Store

    // ===== IMAGE PREVIEW =====
    let selectedProductFiles = [];
    let selectedStoreFiles = [];

    function setupImagePreview(fileInputId, previewId, textarea, isProduct = true) {
        const input = document.getElementById(fileInputId);
        const preview = document.getElementById(previewId);

        input.addEventListener('change', function() {
            const files = [...this.files];

            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const div = document.createElement('div');
                    div.className = 'reviewImg position-relative d-inline-block me-2 mb-2';
                    div.innerHTML = `
                        <img src="${e.target.result}" style="width:80px; height:80px; object-fit:cover; border-radius:5px;">
                        <span style="
                            position:absolute;
                            top:0px;
                            right:0px;
                            background:red;
                            color:white;
                            width:18px;
                            height:18px;
                            text-align:center;
                            line-height:18px;
                            border-radius:50%;
                            cursor:pointer;
                            font-weight:bold;">&times;</span>`;
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            });

            // Save files
            if (isProduct) selectedProductFiles.push(...files);
            else selectedStoreFiles.push(...files);

            // Remove error if exists
            const error = textarea.parentElement.querySelector('.text-danger');
            if (error) error.classList.add('d-none');
        });

        // Remove image on cross click
        preview.addEventListener('click', function(e) {
            if (e.target.tagName === 'SPAN') {
                const imgIndex = Array.from(preview.children).indexOf(e.target.parentElement);
                if (isProduct) selectedProductFiles.splice(imgIndex, 1);
                else selectedStoreFiles.splice(imgIndex, 1);

                e.target.parentElement.remove();
            }
        });

        // Remove error on typing
        textarea.addEventListener('input', () => {
            const error = textarea.parentElement.querySelector('.text-danger');
            if (error) error.classList.add('d-none');
        });
    }

    const textareas = document.querySelectorAll('#ratingModal .form-group textarea');
    setupImagePreview('images', 'preview', textareas[0], true); // Product
    setupImagePreview('reviewpic', 'preview1', textareas[1], false); // Store

    // ===== SUBMIT REVIEW =====
    const submitBtn = document.querySelector('#ratingModal .customBtn');
    submitBtn.addEventListener('click', function() {
        const productTextarea = textareas[0];
        const storeTextarea = textareas[1];

        const productImages = selectedProductFiles;
        const storeImages = selectedStoreFiles;

        let valid = true;

        // Remove old errors
        document.querySelectorAll('#ratingModal .text-danger').forEach(e => e.remove());

        // Product validation
        /* if (!productTextarea.value.trim() && productImages.length === 0) {
            const error = document.createElement('small');
            error.className = 'text-danger d-block';
            error.textContent = 'Please enter a product review or upload an image.';
            productTextarea.parentElement.appendChild(error);
            valid = false;
        }

        // Store validation
        if (!storeTextarea.value.trim() && storeImages.length === 0) {
            const error = document.createElement('small');
            error.className = 'text-danger d-block';
            error.textContent = 'Please enter a store review or upload an image.';
            storeTextarea.parentElement.appendChild(error);
            valid = false;
        }
        */

        if (!valid) return;

        // Prepare form data
        const productRating = document.querySelector('input[name="raterating"]:checked').value;
        const storeRating = document.querySelector('input[name="storerating"]:checked').value;

        const formData = new FormData();
        formData.append('order_id', submitBtn.dataset.orderId || '');
        formData.append('orderdetails_id', submitBtn.dataset.orderDetailsId || '');
        formData.append('product_id', submitBtn.dataset.productId || '');
        formData.append('store_id', submitBtn.dataset.storeId || '');
        formData.append('product_rating', productRating);
        formData.append('store_rating', storeRating);
        if (productTextarea.value.trim()) formData.append('product_review', productTextarea.value
            .trim());
        if (storeTextarea.value.trim()) formData.append('store_review', storeTextarea.value.trim());

        productImages.forEach(file => formData.append('product_image[]', file));
        storeImages.forEach(file => formData.append('store_image[]', file));

        // Send AJAX
        fetch("{{ route('user.submitRating') }}", {
                method: 'POST',
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: formData
            })
            .then(res => res.json())
            .then(response => {
                if (response.status === 'success') {
                    toastr.success(response.message);
                    const modal = bootstrap.Modal.getInstance(document.getElementById(
                        'ratingModal'));
                    modal.hide();
                    setTimeout(() => {
                        window.location.href = "{{ route('user.myOrders') }}";
                    }, 1500);
                } else {
                    toastr.error(response.message || 'Something went wrong');
                }
            })
            .catch(() => toastr.error('Something went wrong'));
    });

    // ===== PASS DATA TO MODAL FROM CLICK =====
    document.querySelectorAll('.order-ratings .rating').forEach(el => {
        el.addEventListener('click', () => {
            submitBtn.dataset.orderId = el.dataset.orderId;
            submitBtn.dataset.orderDetailsId = el.dataset.orderDetailsId;
            submitBtn.dataset.productId = el.dataset.productId;
            submitBtn.dataset.storeId = el.dataset.storeId;
        });
    });

});
</script>