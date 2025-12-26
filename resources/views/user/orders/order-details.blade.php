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
                                <img src="{{ asset('user/assets/images/left-ic.svg') }}" class="img-fluid">
                            </a>
                            <div class="order-subtitle">
                                <h3>#{{ $orderData->order->order_id ?? 'N/A' }}</h3>
                                <p>Placed on {{ \Carbon\Carbon::parse($orderData->order->created_at ?? now())->format('d/m/Y \a\t h:ia') }}</p>
                            </div>
                        </div>

                        @php
                            $status = $orderData->delivery_status ?? 0;
                        @endphp

                        @if($status == 2)
                            <div class="btn-outline1 btn-ongoing">Ongoing</div>
                        @elseif($orderData->payment_status = '4')
                            <div class="btn-outline1 btn-outline-red">Cancelled</div>
                        @elseif($status == 3)
                            <div class="btn-outline1 btn-outline-de">Delivered</div>
                        @elseif($status == 5)
                            <div class="btn-outline1 btn-ongoing">Return Request</div>
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

                                        $image = $images[0] ?? ($orderData->product_details->image_url ?? asset('user/assets/images/categorie1.png'));
                                    @endphp

                                    <div class="cart-products me-3">
                                        <img src="{{ $image }}" alt="Product" class="img-fluid">
                                    </div>
                                </div>

                                <div class="card-right d-flex w-100 justify-content-between">
                                    <div class="product-info">
                                        <h5 class="product-title">{{ $orderData->product_details->product_name_en ?? 'N/A' }}</h5>

                                        <div class="psize d-flex gap-4">
                                            <span>Size: {{ $orderData->variation_details->size->name ?? 'N/A' }}</span>

                                            <span class="d-flex align-items-center gap-2">
                                                Color:
                                                <div class="colorbox" style="width:15px; height:15px; border-radius:3px; background: {{ $orderData->variation_details->color->hex_code ?? '#000' }};"></div>
                                            </span>

                                            <span>Qnt: {{ $orderData->quantity ?? 1 }}</span>
                                        </div>

                                        {{-- Price --}}
                                        <div class="price">
                                            <span class="price-current">{{ number_format($orderData->variation_details->final_price ?? 0, 2) }} KD</span>
                                            @if(isset($orderData->variation_details->actual_price) && $orderData->variation_details->actual_price > $orderData->variation_details->final_price)
                                                <span class="price-old">{{ number_format($orderData->variation_details->actual_price, 2) }} KD</span>
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
                                                    {{ $orderData->product_details->exchangable_days }} day exchange policy available
                                                @endif
                                            @endif
                                        </div>
                                        @if($orderData->delivery_status !== '3' && $orderData->payment_status !== '2')
                                        <div class="d-none-1">
                                            <button
                                                class="btn btn-outline-red w-100 cancelBtn"
                                                data-bs-toggle="modal"
                                                data-bs-target="#cancelModal"
                                                data-order-id="{{ $orderData->order_id }}">
                                                Cancel Order
                                            </button>
                                        </div>
                                        @elseif($orderData->payment_status == '2')
                                        <div class="d-none-1">
                                            <button
                                                class="btn btn-outline-red w-100 cancelBtn">
                                                Cancelled
                                            </button>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Rating Section --}}
                        <div class="rating-pnl mt-3">
                            <div class="rate-p">
                                <h5 class="product-title">Rate this product</h5>
                                <div class="order-ratings rating-widget">
                                    <div class="rating" data-bs-toggle="modal" data-bs-target="#ratingModal">
                                        @for($i = 1; $i <= 5; $i++)
                                            <label><i class="fas fa-2x fa-star"></i></label>
                                        @endfor
                                    </div>
                                    <input type="hidden" id="selectedRating" value="0">
                                </div>
                            </div>

                            @if($orderData->delivery_status == '3')
                            <div class="d-flex gap-3">
                                <button
                                    class="btn btn-outline-red exchangeBtn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#exchangeModal"
                                    data-order-id="{{ $orderData->order_id }}"
                                    style="width:130px;">
                                    Exchange
                                </button>
                                <button class="btn btn-outline-red" data-bs-toggle="modal" data-bs-target="#returnModal" style="width:130px; background:#D53B36; color:#fff;">Return</button>
                            </div>
                            @endif
                        </div>
                    </div>
                <!-- </div> -->

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
                    <h6>Shipping Address</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <p>{{$orderData->order->delivery_details->address}} {{$orderData->order->delivery_details->house_no}} {{$orderData->order->delivery_details->city}} {{$orderData->order->delivery_details->state}} {{$orderData->order->delivery_details->postal_code}} {{$orderData->order->delivery_details->country_name}}</p>
                        </div>
                    </div>
                </div>

                {{-- Cancellation Details --}}
                @if((isset($orderData->return_type) && in_array($orderData->return_type, ['1','2'])) || $orderData->payment_status === '2')
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
                                    @endif
                                </div>
                                <div>
                                    {{ \Carbon\Carbon::parse($orderData->updated_at)->format('d/m/Y \a\t h:i') }}
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
                        <div class="order-14">Expected Delivery 21/02/25</div>
                    </div>
                    <div class="order-view-lists mt-3">
                        <div class="or-box">
                            <div class="fill-box">
                                <img src="{{ asset('user/assets/images/order-ic/sing-ic.svg') }}" class="img-fluid">
                            </div>
                            <div>Confirmed</div>
                        </div>
                        <div class="or-box">
                            <div class="fill-box">
                                <img src="{{ asset('user/assets/images/order-ic/tax.svg') }}" class="img-fluid">
                            </div>
                            <div>Shipped</div>
                        </div>
                        <div class="or-box">
                            <div class="fill-box">
                                <img src="{{ asset('user/assets/images/order-ic/van.svg') }}" class="img-fluid">
                            </div>
                            <div>On the Way</div>
                        </div>
                        <div class="or-box">
                            <div class="fill-box" style="background:#fff;">
                                <img src="{{ asset('user/assets/images/order-ic/box.svg') }}" class="img-fluid">
                            </div>
                            <div>Delivered</div>
                        </div>
                    </div>
                </div>

                <div class="orderstatus p-3 mb-4">
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
                </div>


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
                        <div class="trans" style="color:#714829;font-size:12px;">Transaction Id: {{$orderData->order->transaction_id }}</div>
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
                                        Payment Pending On COD
                                    @endif
                                @else
                                    Payment Info Not Available
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


                <div class="mt-4">
                    <button type="submit" class="customBtn mb-3">
                        Download Invoice
                    </button>
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
                            <input
                                type="radio"
                                name="cancel_reason"
                                value="{{ $reason->reason_english }}"
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
                    <textarea
                        id="otherReason"
                        rows="4"
                        class="form-control"
                        placeholder="Write here"></textarea>

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

<div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5">Return Request</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="gift-panel-list">
                    <h6>Select Reason</h6>

                    <div class="reason-list">
                        <label class="custom-radio mb-3">
                            <input type="radio" name="filter" value="1" checked>
                            <span class="radio-mark"></span>
                            <div class="label-content">
                                <div class="title">Reason 1</div>
                            </div>
                        </label>
                        <label class="custom-radio mb-3">
                            <input type="radio" name="filter" value="1">
                            <span class="radio-mark"></span>
                            <div class="label-content">
                                <div class="title">Other</div>
                            </div>
                        </label>
                    </div>

                    <div class="form-group w-100 py-2 mb-3">
                        <textarea rows="3" class="form-control pline-10" placeholder="Write here"></textarea>
                    </div>
                    
                    <h6>Upload Image(Optional)</h6>
                    <div class="border-1 p-3">
                        <div class="text-center">
                            <label for="upload" class="requestbox">
                                <div class="image-upload-2 mb-1">
                                    <img src="{{asset('user/assets/images/upload-icon.svg')}}" class="img-fluid" alt="images">
                                </div>
                                <div style="font-size:13px;color:#7a7979;">Upload Profile Images</div>
                                <input type="file" id="requestimg" multiple accept="image/*">
                            </label>
                        </div>
                    </div>

                    <div class="mt-2">
                        <div id="previewRequest" class="preview-box1"></div>
                    </div>

                    <div class="mt-4">
                        <button type="button" class="customBtn mb-3 white-btn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Exchange Modal -->

<!-- <div class="modal fade" id="exchangeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5">Exchange Request</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="gift-panel-list">
                    <h6>Select Reason</h6>

                    <div class="reason-list">
                        <label class="custom-radio mb-3">
                            <input type="radio" name="filter" value="1" checked>
                            <span class="radio-mark"></span>
                            <div class="label-content">
                                <div class="title">Reason 1</div>
                            </div>
                        </label>
                        <label class="custom-radio mb-3">
                            <input type="radio" name="filter" value="1">
                            <span class="radio-mark"></span>
                            <div class="label-content">
                                <div class="title">Other</div>
                            </div>
                        </label>
                    </div>

                    <div class="form-group w-100 py-2 mb-3">
                        <textarea rows="3" class="form-control pline-10" placeholder="Write here"></textarea>
                    </div>
                    
                    <h6>Select Available Size</h6>
                    <div class="reason-list">
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
                    </div>

                    <div class="mt-4">
                        <button type="button" class="customBtn mb-3 white-btn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
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
                            <input
                                type="radio"
                                name="exchange_reason"
                                value="{{ $reason->reason_english }}"
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
                    <textarea
                        id="exchangeOtherText"
                        rows="3"
                        class="form-control"
                        placeholder="Write here"></textarea>

                    <small class="text-danger d-none" id="exchangeOtherError">
                        Please provide the reason for exchange
                    </small>
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
<div class="modal fade" id="ratingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5">Rate this product</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="gift-panel-list">
                    <div class="reason-list rating-widget ">
                        <h6>Rate Nike T-Shirt</h6>
                        <div class="rating py-2">
                            <input id="rating-1" type="radio" name="raterating" value="1" checked /><label for="rating-1"><i class="fas fa-2x fa-star"></i></label>
                            <input id="rating-2" type="radio" name="raterating" value="2" /><label for="rating-2"><i class="fas fa-2x fa-star"></i></label>
                            <input id="rating-3" type="radio" name="raterating" value="3"/><label for="rating-3"><i class="fas fa-2x fa-star"></i></label>
                            <input id="rating-4" type="radio" name="raterating" value="4" /><label for="rating-4"><i class="fas fa-2x fa-star"></i></label>
                            <input id="rating-5" type="radio" name="raterating" value="5"/><label for="rating-5"><i class="fas fa-2x fa-star"></i></label>
                        </div>
                    </div>

                    <div class="form-group w-100 py-2 mb-3 position-relative">
                        <p>Write Review</p>
                        <textarea rows="1" class="form-control pline-10" placeholder="Write here"></textarea>
                        <div class="paperhover">
                            <label><input type="file" id="images" multiple accept="image/*">
                            <i class="bi bi-paperclip"></i>
                            </label>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div id="preview" class="preview-box1"></div>
                    </div>

                    <div class="reason-list rating-widget mt-2">
                        <h6>Rate Store</h6>
                        <div class="rating py-2">
                            <input id="rating-1" type="radio" name="raterating" value="1" checked /><label for="rating-1"><i class="fas fa-2x fa-star"></i></label>
                            <input id="rating-2" type="radio" name="raterating" value="2" /><label for="rating-2"><i class="fas fa-2x fa-star"></i></label>
                            <input id="rating-3" type="radio" name="raterating" value="3"/><label for="rating-3"><i class="fas fa-2x fa-star"></i></label>
                            <input id="rating-4" type="radio" name="raterating" value="4" /><label for="rating-4"><i class="fas fa-2x fa-star"></i></label>
                            <input id="rating-5" type="radio" name="raterating" value="5"/><label for="rating-5"><i class="fas fa-2x fa-star"></i></label>
                        </div>
                    </div>

                    <div class="form-group w-100 py-2 mb-3 position-relative">
                        <p>Write Review</p>
                        <textarea rows="1" class="form-control pline-10" placeholder="Write here"></textarea>
                        <div class="paperhover">
                            <label><input type="file" id="reviewpic" multiple accept="image/*">
                            <i class="bi bi-paperclip"></i>
                            </label>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div id="preview1" class="preview-box1"></div>
                    </div>

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
$(function () {
  $('#images').on('change', function () {
    $('#preview').html('');
    [...this.files].forEach(file => {
      let reader = new FileReader();
      reader.onload = e =>
        $('#preview').append(
          `<div class="reviewImg">
             <img src="${e.target.result}">
             <span>&times;</span>
           </div>`
        );
      reader.readAsDataURL(file);
    });
  });

  $('#preview').on('click', 'span', function () {
    $(this).parent().remove();
  });
});


$(function () {
  $('#reviewpic').on('change', function () {
    $('#preview1').html('');
    [...this.files].forEach(file => {
      let reader = new FileReader();
      reader.onload = e =>
        $('#preview1').append(
          `<div class="reviewImg">
             <img src="${e.target.result}">
             <span>&times;</span>
           </div>`
        );
      reader.readAsDataURL(file);
    });
  });

  $('#preview1').on('click', 'span', function () {
    $(this).parent().remove();
  });
});

//Request image
$(function () {
  $('#requestimg').on('change', function () {
    $('#previewRequest').html('');
    [...this.files].forEach(file => {
      let reader = new FileReader();
      reader.onload = e =>
        $('#previewRequest').append(
          `<div class="reviewImg">
             <img src="${e.target.result}">
             <span>&times;</span>
           </div>`
        );
      reader.readAsDataURL(file);
    });
  });

  $('#previewRequest').on('click', 'span', function () {
    $(this).parent().remove();
  });
});

</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    let orderId = null;

    // Capture order id
    document.querySelectorAll('.cancelBtn').forEach(btn => {
        btn.addEventListener('click', function () {
            orderId = this.dataset.orderId;
        });
    });

    const otherWrapper = document.getElementById('otherReasonWrapper');
    const otherInput   = document.getElementById('otherReason');
    const errorMsg     = document.getElementById('otherReasonError');
    const submitBtn    = document.getElementById('submitCancel');

    // SAFETY CHECK (optional but recommended)
    if (!otherWrapper || !otherInput || !submitBtn) {
        console.error('Cancel modal elements not found');
        return;
    }

    // Radio change handler
    document.querySelectorAll('input[name="cancel_reason"]').forEach(radio => {
        radio.addEventListener('change', function () {
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
    otherInput.addEventListener('input', function () {
        errorMsg.classList.add('d-none');
    });

    // Submit
    submitBtn.addEventListener('click', function () {

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
document.addEventListener('DOMContentLoaded', function () {

    let exchangeOrderId = null;

    // Capture order id
    document.querySelectorAll('.exchangeBtn').forEach(btn => {
        btn.addEventListener('click', function () {
            exchangeOrderId = this.dataset.orderId;
        });
    });

    const wrapper = document.getElementById('exchangeOtherWrapper');
    const textarea = document.getElementById('exchangeOtherText');
    const error = document.getElementById('exchangeOtherError');
    const submitBtn = document.getElementById('submitExchange');

    // Toggle textarea
    document.querySelectorAll('input[name="exchange_reason"]').forEach(radio => {
        radio.addEventListener('change', function () {
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
    textarea.addEventListener('input', function () {
        error.classList.add('d-none');
    });

    // Submit
    submitBtn.addEventListener('click', function () {

        const selected = document.querySelector('input[name="exchange_reason"]:checked').value;
        let reason = selected;

        if (selected === 'other') {
            if (!textarea.value.trim()) {
                error.classList.remove('d-none');
                return;
            }
            reason = textarea.value.trim();
        }

        fetch("{{ route('user.exchange_order') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                order_id: exchangeOrderId,
                exchange_reason: reason
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




