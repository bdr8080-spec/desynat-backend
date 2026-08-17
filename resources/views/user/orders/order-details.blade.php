@extends('user.layout.app')

@section('content')

@php

if(App::getLocale()=='en'){
$currency = session('currency', 'KWD');
}else{
$currency = session('currencyAr', 'دينار كويتي');
}

    $rate = session('rate', '1');
 
@endphp



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
                            <h3>#{{ $orderData->id ??  __('user_messages.na')  }}</h3>
                            <p>{{ __('user_messages.placed_on') }}
                                {{ \Carbon\Carbon::parse($orderData->order->created_at ?? now())
                            ->timezone('Asia/Kolkata')
                            ->format('d/m/Y \a\t h:ia') }}
                            </p>
                        </div>
                    </div>


                    <!-- @php
                            $status = $orderData->delivery_status ?? 0;
                        @endphp -->


                    @if($orderData->payment_status == '2' || $orderData->payment_status == '3')
                    <div class="btn-outline1 btn-outline-red">{{ __('user_messages.cancelled') }}</div>
                    @elseif(in_array($orderData->delivery_status, ['1', '2']) && $orderData->payment_status !== '2' &&
                    $orderData->payment_status !== '3' )
                    <div class="btn-outline1 btn-ongoing">{{ __('user_messages.ongoing') }}</div>
                    @elseif($orderData->delivery_status == '3' && $orderData->return_type == '0')
                    <div class="btn-outline1 btn-outline-de">{{ __('user_messages.delivered') }}</div>
                    @elseif($orderData->delivery_status == '3' && $orderData->return_type == '1')
                    <div class="btn-outline1 btn-ongoing">{{ __('user_messages.return_request') }}</div>
                    @elseif($orderData->delivery_status == '3' && $orderData->return_type == '2')
                    <div class="btn-outline1 btn-ongoing">{{ __('user_messages.exchange_request') }}</div>
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

                            <div class="card-right d-flex w-100 justify-content-between ">
                                <div class="product-info">
                                    <h5 class="product-title">
                                        @if(app()->getLocale() == 'en')
                                        {{ $orderData->product_details->product_name_en ?? __('user_messages.na') }}
                                        @else
                                        {{ $orderData->product_details->product_name_ar ?? __('user_messages.na') }}
                                        @endif
                                    </h5>

                                    <div class="psize d-flex gap-4">
                                        <span>{{ __('user_messages.size') }}: @if(app()->getLocale() == 'en'){{ $orderData->variation_details->size->name ?? __('user_messages.na') }}@else{{ $orderData->variation_details->size->name_ar ?? __('user_messages.na') }}@endif</span>

                                        <span class="d-flex align-items-center gap-2">
                                            {{ __('user_messages.color') }}:
                                            <div class="colorbox"
                                                style="width:15px; height:15px; border-radius:3px; background: {{ $orderData->variation_details->color->hex_code ?? '#000' }};">
                                            </div>
                                        </span>

                                        <span>{{ __('user_messages.qty') }}: {{ $orderData->quantity ?? 1 }}</span>
                                    </div>

                                    {{-- Price --}}
                                    @if($orderData->order_type=='1')
                                    <div class="price">
                                        <span
                                            class="price-current"> {{ number_format(convertPriceInUserWeb($orderData->variation_details->final_price), 2) }}  {{ $currency }}
                                            </span>
                                        @if(isset($orderData->variation_details->actual_price) &&
                                        $orderData->variation_details->actual_price >
                                        $orderData->variation_details->final_price)
                                        <span
                                            class="price-old"> {{ number_format(convertPriceInUserWeb($orderData->variation_details->actual_price), 2) }}  {{ $currency }}
                                            </span>
                                        @if($orderData->variation_details->discount_type == '1')
                                        <span class="discount ms-2">{{ $orderData->variation_details->discount_value }}%
                                            {{ __('user_messages.off') }}</span>
                                        @endif
                                        @endif
                                    </div>
                                    @endif
                                    @if($orderData->order_type=='2')
                                    <div class="price">
                                        <span class="price-current"> {{ number_format(convertPriceInUserWeb($orderData->amount), 2) }}  {{ $currency }}
                                            </span>
                                    </div>
                                    @endif
                                </div>

                                <div class="return-view">
                                    <!-- <div class="return-green">7 day return policy available</div> -->
                                     @if($orderData->order_type=='1')
                                    <div class="return-green">
                                        @if(isset($orderData->product_details))
                                        @if($orderData->product_details->product_return == '1')
                                        {{ $orderData->product_details->return_days }} {{ __('user_messages.days_return_policy_available') }}
                                        <br>
                                        @endif

                                        @if($orderData->product_details->product_exchangable == '1')
                                        {{ $orderData->product_details->exchangable_days }} {{ __('user_messages.days_exchange_policy_available') }}
                                        @endif
                                        @endif
                                    </div>
                                    @endif
                                    @if($orderData->delivery_status !== '3' && $orderData->payment_status !== '2' &&
                                    $orderData->payment_status !== '3' && $orderData->order->order_type == '1')
                                    <div class="d-none-1">
                                        <button class="btn btn-outline-red w-100 cancelBtn" data-bs-toggle="modal"
                                            data-bs-target="#cancelModal" data-order-id="{{ $orderData->order_id }}"
                                            data-order-details-id="{{ $orderData->id }}">
                                            {{ __('user_messages.cancel_order') }}
                                        </button>
                                    </div>
                                    @elseif($orderData->delivery_status !== '3' && $orderData->payment_status !== '2' &&
                                            $orderData->payment_status !== '3' && $orderData->order->order_type == '2')
                                    <!-- @php
                                    $cancelDays = 3; 
                                    $orderCreated = \Carbon\Carbon::parse($orderData->order->created_at);
                                    $cancelLastDate = $orderCreated->copy()->addDays($cancelDays);
                                    $cancelAllowed = \Carbon\Carbon::today()->lte($cancelLastDate);
                                    @endphp -->
                                    @php
                                        $cancelHours = 3;
                                        $orderCreated = \Carbon\Carbon::parse($orderData->order->created_at);
                                        $cancelLastTime = $orderCreated->copy()->addHours($cancelHours);
                                        $cancelAllowed = now()->lte($cancelLastTime);
                                    @endphp
                                    @if($cancelAllowed)
                                     <div class="d-none-1">
                                        <button class="btn btn-outline-red w-100 cancelBtn" data-bs-toggle="modal"
                                            data-bs-target="#cancelModal" data-order-id="{{ $orderData->order_id }}"
                                            data-order-details-id="{{ $orderData->id }}">
                                            {{ __('user_messages.cancel_order') }}
                                        </button>
                                    </div>
                                    @endif
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

                            <h5 class="product-title">{{ __('user_messages.rate_this_product') }}</h5>
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
                        $orderData->payment_status == '1' && $orderData->order->order_type == '1')
                        <div class="d-flex gap-3">
                            @php
                                $exchangeAllowed = false;

                                if (
                                    $orderData->product_details->product_exchangable == '1' &&
                                    !empty($orderData->product_details->exchangable_days)
                                ) {
                                    $exchangeDays = (int) $orderData->product_details->exchangable_days;

                                    $exchangeLastDate = \Carbon\Carbon::parse($orderData->created_at)
                                        ->addDays($exchangeDays);

                                    $exchangeAllowed = \Carbon\Carbon::today()->lte($exchangeLastDate);
                                }

                                $returnAllowed = false;

                                if (
                                    $orderData->product_details->product_return == '1' &&
                                    !empty($orderData->product_details->return_days)
                                ) {
                                    $returnDays = (int) $orderData->product_details->return_days;

                                    $returnLastDate = \Carbon\Carbon::parse($orderData->created_at)
                                        ->addDays($returnDays);

                                    $returnAllowed = now()->lte($returnLastDate);
                                }
                            @endphp
                            @if($exchangeAllowed)
                            <button class="btn btn-outline-red exchangeBtn" data-bs-toggle="modal"
                                data-bs-target="#exchangeModal" data-order-id="{{ $orderData->order_id }}"
                                data-order-details-id="{{ $orderData->id }}"
                                data-product-id="{{ $orderData->product_id }}"
                                data-size-id="{{ $orderData->variation_details->size->id }}"
                                data-color-id="{{ $orderData->variation_details->color->id }}" style="width:130px;">
                                {{ __('user_messages.exchange') }}
                            </button>
                            @endif
                            @if($returnAllowed)
                            <button class="btn btn-outline-red returnBtn" data-bs-toggle="modal"
                                data-bs-target="#returnModal" data-order-id="{{ $orderData->order_id }}"
                                data-order-details-id="{{ $orderData->id }}"
                                style="width:130px; background:#D53B36; color:#fff;">
                                {{ __('user_messages.return') }}
                            </button>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
                <!-- </div> -->

                <!-- relivent product  -->


                <!-- <h1> Relevant product </h1> -->

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
                                    @if(app()->getLocale() == 'en')
                                    {{ $val->product_details->product_name_en ?? __('user_messages.na') }}
                                    @else
                                    {{ $val->product_details->product_name_ar ?? __('user_messages.na') }}
                                    @endif
                                </h5>

                                <div class="psize d-flex gap-4">
                                    <span>{{ __('user_messages.size') }}: @if(app()->getLocale() == 'en'){{ $val->variation_details->size->name ?? __('user_messages.na') }}@else{{ $val->variation_details->size->name_ar ?? __('user_messages.na') }}@endif</span>

                                    <span class="d-flex align-items-center gap-2">
                                        {{ __('user_messages.color') }}:
                                        <div class="colorbox"
                                            style="width:15px; height:15px; border-radius:3px; background: {{ $val->variation_details->color->hex_code ?? '#000' }};">
                                        </div>
                                    </span>

                                    <span>{{ __('user_messages.qty') }}: {{ $val->quantity ?? 1 }}</span>
                                </div>

                                {{-- Price --}}
                                @if($val->order_type=='1')
                                <div class="price">
                                    <span
                                        class="price-current"> {{ number_format(convertPriceInUserWeb($val->variation_details->final_price ), 2) }}  {{ $currency }}
                                        </span>
                                    @if(isset($val->variation_details->actual_price) &&
                                    $val->variation_details->actual_price >
                                    $val->variation_details->final_price)
                                    <span
                                        class="price-old"> {{ number_format(convertPriceInUserWeb($val->variation_details->actual_price ), 2) }}  {{ $currency }}
                                        </span>
                                    @if($val->variation_details->discount_type == '1')
                                    <span class="discount ms-2">{{ $val->variation_details->discount_value }}%
                                        {{ __('user_messages.off') }}</span>
                                    @endif
                                    @endif
                                </div>
                                @endif
                                @if($val->order_type=='2')
                                <div class="price">
                                    <span
                                        class="price-current"> {{ number_format(convertPriceInUserWeb($val->ChatroomRecordtable->total_amount ), 2) }}  {{ $currency }}
                                        </span>
                                </div>
                                @endif

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
                            <div>{{ __('user_messages.total_quantity') }}</div>
                            <div>{{$orderData->quantity}}</div>
                        </div>
                        @if($orderData->order_type == '2')
                        <!-- <div class="giftinfo">
                            <div>Address </div>
                            <div>
                              {{$orderData->order->delivery_details->address}}
                                {{$orderData->order->delivery_details->state}}
                                {{$orderData->order->delivery_details->postal_code}}
                                {{$orderData->order->delivery_details->country_name}}
                            </div>
                        </div> -->
                        <div class="giftinfo">
                            <div>{{ __('user_messages.custom_details') }}</div>
                            <div>{{$orderData->ChatroomRecordtable->custom_details}}</div>
                        </div>
                        @endif
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

                    <h6>{{ __('user_messages.pickup_address') }}</h6>

                    @else
                    <h6>{{ __('user_messages.delivery_address') }}</h6>

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
                        {{ __('user_messages.return_details') }}
                        @elseif($orderData->return_type == '2')
                        {{ __('user_messages.exchange_details') }}
                        @elseif($orderData->payment_status == '2')
                        {{ __('user_messages.cancellation_details') }}
                        @endif
                    </h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>
                                @if($orderData->return_type == '1')
                                {{ __('user_messages.returned_on') }}
                                @elseif($orderData->return_type == '2')
                                {{ __('user_messages.exchanged_on') }}
                                @elseif($orderData->payment_status == '2')
                                {{ __('user_messages.cancelled_on') }}

                                </br>
                                {{ __('user_messages.cancellation_id') }}

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
                    <h6>{{ __('user_messages.return_reason') }}</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <p>{{ $orderData->return_reason ?? __('user_messages.na') }}</p>
                        </div>
                    </div>
                </div>
                @elseif($orderData->return_type == '2')
                <div class="gift-pnl mt-4">
                    <h6>{{ __('user_messages.exchange_reason') }}</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <p>{{ $orderData->exchange_reason ?? __('user_messages.na') }}</p>
                        </div>
                    </div>
                </div>
                @elseif($orderData->payment_status == '2')
                <div class="gift-pnl mt-4">
                    <h6>{{ __('user_messages.cancellation_reason') }}</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <p>{{ $orderData->cancel_reason ?? __('user_messages.na') }}</p>
                        </div>
                    </div>
                </div>
                @endif
                @endif


                {{-- Uploaded images --}}

                @if(isset($orderData->return_type) && $orderData->return_type == 1)
                @php
                $returnImages = $orderData->return_image ?? '[]';
                @endphp

                @if(!empty($returnImages))
                <div class="gift-pnl mt-4">
                    <h6>{{ __('user_messages.uploaded_images') }}</h6>
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
                        <div class="order-t">{{ __('user_messages.order_status') }}</div>
                        @if($orderData->payment_status=='2' || $orderData->payment_status=='3' ||
                        $orderData->delivery_status=='4')
                        <div class="order-14">{{ __('user_messages.cancelled_on') }}
                            {{ formatDateTimeByLocale($orderData->updated_at) }}</div>
                        @elseif($orderData->return_type!=='0')
                        <div class="order-14">{{ __('user_messages.expected_pickup_date') }}:
                            <!-- 3-5 Working Days -->
                            {{ formatDateTimeByLocale($orderData->updated_at->copy()->addDays(6)) }}

                        </div>
                        @else
                        <div class="order-14">{{ __('user_messages.expected_delivery') }}:
                            <!-- {{ \Carbon\Carbon::parse($orderData->created_at)->addDays(6)->format('d/m/Y') }}</div> -->
                            <!-- 3-5 Working Days -->

                            {{ formatDateTimeByLocale($orderData->updated_at->copy()->addDays(6)) }}

                        </div>
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
                                <div>{{ __('user_messages.confirmed') }}</div>
                            </div>

                            <div class="or-box">
                                <div class="fill-box" style="background:#D72E04;">
                                    <img src="{{ asset('user/assets/images/order-ic/box.svg') }}" class="img-fluid"
                                        style="filter: brightness(26);">
                                </div>
                                <div style="color:#D72E04;">{{ __('user_messages.cancelled') }}</div>
                            </div>
                        </div>
                    </div>

                    @elseif($orderData->return_type!=='0')

                    <!-- when Order In Return State  -->

                    <div class="orderstatus p-3 mb-4">
                        <div class="order-view-lists mt-3">

                            <!-- Status Code Start      -->

                            @if($orderData->return_type!=='0' && $orderData->r_e_approve=='1')

                            <div class="or-box">
                                <div class="fill-box">
                                    <img src="{{ asset('user/assets/images/order-ic/sing-ic.svg') }}" class="img-fluid">
                                </div>
                                <div>{{ __('user_messages.confirmed') }} </div>
                            </div>

                            @else

                            <div class="or-box">
                                <div class="fill-box">
                                    <img src="{{ asset('user/assets/images/order-ic/confirm-white.svg') }}"
                                        class="img-fluid">
                                </div>
                                <div>{{ __('user_messages.confirmed') }}</div>
                            </div>

                            @endif

                            @if($orderData->return_type!=='0' && $orderData->r_e_approve=='1' &&
                            $orderData->assign_status=='1')
                            <div class="or-box">
                                <div class="fill-box">
                                    <img src="{{ asset('user/assets/images/order-ic/tax.svg') }}" class="img-fluid">
                                </div>
                                <div>{{ __('user_messages.in_progress') }}</div>
                            </div>
                            @else
                            <div class="or-box">
                                <div class="fill-box">
                                    <img src="{{ asset('user/assets/images/order-ic/shipped-white.svg') }}"
                                        class="img-fluid">
                                </div>
                                <div>{{ __('user_messages.in_progress') }}</div>
                            </div>
                            @endif
                            @if($orderData->return_type!=='0' && $orderData->r_e_approve=='1' &&
                            $orderData->is_picked=='1')
                            <div class="or-box">
                                <div class="fill-box">
                                    <img src="{{ asset('user/assets/images/order-ic/van.svg') }}" class="img-fluid">
                                </div>

                                @if($orderData->return_type==1)
                                <div>{{ __('user_messages.picked_up') }} </div>
                                @else
                                <div>{{ __('user_messages.pickup_&_exchange') }}</div>
                                @endif

                            </div>
                            @else
                            <div class="or-box">
                                <div class="fill-box">
                                    <img src="{{ asset('user/assets/images/order-ic/on-the-way.svg') }}"
                                        class="img-fluid">
                                </div>

                                @if($orderData->return_type==1)
                                <div>{{ __('user_messages.picked_up') }} </div>
                                @else
                                <div>{{ __('user_messages.picked_up') }}</div>
                                @endif

                            </div>
                            @endif

                            <!--  -->

                            @if($orderData->delivery_status=='3' && $orderData->r_e_approve=='1' &&
                            $orderData->assign_status=='1'  && $orderData->is_picked=='1' )
                            <div class="or-box">
                                <div class="fill-box">
                                    <img src="{{ asset('user/assets/images/order-ic/delivered-2.svg') }}"
                                        class="img-fluid">
                                </div>
                                <div>{{ __('user_messages.completed') }}</div>
                            </div>

                            @else
                            <div class="or-box">
                                <div class="fill-box"
                                    style="background:linear-gradient(180.99deg, #DFBF8F -53.71%, #6E4527 154.28%);">
                                    <img src="{{ asset('user/assets/images/order-ic/delivered-white.svg') }}"
                                        class="img-fluid">
                                </div>
                                <div>{{ __('user_messages.completed') }}</div>
                            </div>
                            @endif

                            <!-- Status Code End Here  -->

                        </div>
                    </div>

                    @else


                    <!-- when Order is Not Cancelled -->
                    <div class="order-view-lists mt-3">
                        <div class="or-box">
                            <div class="fill-box">
                                <img src="{{ asset('user/assets/images/order-ic/sing-ic.svg') }}" class="img-fluid">
                            </div>
                            <div>{{ __('user_messages.confirmed') }}</div>
                        </div>
                        @if($orderData->delivery_status=='2.1' || $orderData->delivery_status=='2.2' ||
                        $orderData->delivery_status=='3' || $orderData->delivery_status=='7')
                        <div class="or-box">
                            <div class="fill-box">
                                <img src="{{ asset('user/assets/images/order-ic/tax.svg') }}" class="img-fluid">
                            </div>
                            <div>{{ __('user_messages.shipped') }}</div>
                        </div>
                        @else
                        <div class="or-box">
                            <div class="fill-box">
                                <img src="{{ asset('user/assets/images/order-ic/shipped-white.svg') }}"
                                    class="img-fluid">
                            </div>
                            <div>{{ __('user_messages.shipped') }}</div>
                        </div>
                        @endif
                        @if($orderData->delivery_status=='7' || $orderData->delivery_status=='3')
                        <div class="or-box">
                            <div class="fill-box">
                                <img src="{{ asset('user/assets/images/order-ic/van.svg') }}" class="img-fluid">
                            </div>
                            <div>{{ __('user_messages.on_the_way') }}</div>
                        </div>
                        @else
                        <div class="or-box">
                            <div class="fill-box">
                                <img src="{{ asset('user/assets/images/order-ic/on-the-way.svg') }}" class="img-fluid">
                            </div>
                            <div>{{ __('user_messages.on_the_way') }}</div>
                        </div>
                        @endif

                        <!--  -->

                        @if(($orderData->delivery_status=='3' ) && ($orderData->return_type=='0' ))
                        <div class="or-box">
                            <div class="fill-box">
                                <img src="{{ asset('user/assets/images/order-ic/delivered-2.svg') }}" class="img-fluid">
                            </div>
                            <div>{{ __('user_messages.delivered') }}</div>
                        </div>

                        @else
                        <div class="or-box">
                            <div class="fill-box"
                                style="background:linear-gradient(180.99deg, #DFBF8F -53.71%, #6E4527 154.28%);">
                                <img src="{{ asset('user/assets/images/order-ic/delivered-white.svg') }}"
                                    class="img-fluid">
                            </div>
                            <div>{{ __('user_messages.delivered') }}</div>
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


                <h6>{{ __('user_messages.billing_details') }}</h6>
                <div class="gift-pnl mt-0">
                    <!-- <div class="border-1">
                        <div class="giftinfo">
                            @if($orderData->order->order_type=='1')
                            <div>Total MRP</div>
                            @elseif($orderData->order->order_type=='2')
                            <div>Item Price({{ $orderData->amount}} KD *{{$orderData->quantity}})</div>
                            @endif
                            @if($orderData->order->order_type=='1')
                            <div>{{$orderData->order->total_mrp }} KD</div>
                            @endif
                            @if($orderData->order->order_type=='2')
                            <div>{{ $orderData->amount * $orderData->quantity }} KD</div>
                            @endif
                        </div>
                        @if($orderData->order->order_type=='1')
                        <div class="giftinfo">
                            <div>Discount on MRP </div>
                            <div class="discount">{{$orderData->order->discount_mrp }} KD</div>
                        </div>
                        @endif
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
                            @if($orderData->order->order_type=='1')
                            <div>{{$orderData->order->total_amount }} KD</div>
                            @else
                            <div>{{ rtrim(rtrim(str_replace(',', '', number_format($orderData->order->total_amount, 2)), '0'), '.') }} KD</div>
                            @endif

                        </div>
                    </div> -->
                    @php
                        $allItems = collect([$orderData])
                                        ->merge($orderData->allOtherOrderVarient);

                        $hasOrderType1 = $allItems->contains('order_type', '1');
                        $hasOrderType2 = $allItems->contains('order_type', '2');

                        // Total custom price (order_type = 2)
                        $customAmount = $allItems
                            ->where('order_type', '2')
                            ->sum(fn ($item) => $item->amount * $item->quantity);

                        // Total MRP items (order_type = 1)
                        $totalMrp = $allItems
                            ->where('order_type', '1')
                            ->sum(fn ($item) => $item->amount * $item->quantity);

                        $discountMrp = $orderData->order->discount_mrp ?? 0;
                    @endphp
                    <div class="border-1">

                        {{-- ORDER TYPE 1 --}}
                        @if($hasOrderType1)
                            <div class="giftinfo">
                                <div>{{ __('user_messages.total_mrp') }}</div>
                                <div> {{ number_format(convertPriceInUserWeb($totalMrp ), 2) }}  {{ $currency }}</div>
                            </div>

                            <div class="giftinfo">
                                <div>{{ __('user_messages.discount_on_mrp') }}</div>
                                <div class="discount"> {{ number_format(convertPriceInUserWeb($discountMrp ), 2) }}  {{ $currency }} </div>
                            </div>
                        @endif

                        {{-- ORDER TYPE 2 --}}
                        @if($hasOrderType2)
                            <div class="giftinfo">
                                <div>{{ __('user_messages.custom_item_price') }}</div>
                                <div> {{ number_format(convertPriceInUserWeb($customAmount ), 2) }} {{ $currency }}</div>
                            </div>
                        @endif

                        {{-- COUPON --}}
                        @if(!empty($orderData->order->promocode_value))
                            <div class="giftinfo">
                                <div>{{ __('user_messages.coupon_discount') }}</div>
                                <div class="discount"> {{ number_format(convertPriceInUserWeb($orderData->order->promocode_value ), 2) }} {{ $currency }}</div>
                            </div>
                        @endif

                        {{-- GIFT CARD --}}
                        @if(!empty($orderData->order->giftcard_amount))
                            <div class="giftinfo">
                                <div>{{ __('user_messages.gift_card_discount') }}</div>
                                <div class="discount">{{ number_format(convertPriceInUserWeb($orderData->order->giftcard_amount ), 2) }} {{ $currency }}</div>
                            </div>
                        @endif

                        @if(($orderData->order->shipping_fees ?? 0) > 0)
                            <div class="giftinfo">
                                <div>{{ __('user_messages.shipping_fee') }}</div>
                                <div> {{ number_format(convertPriceInUserWeb($orderData->order->shipping_fees ), 2) }} {{ $currency }}</div>
                            </div>
                        @else
                            <div class="giftinfo">
                                <div>{{ __('user_messages.shipping_fee') }}</div>
                                <div>{{ __('user_messages.free_shipping') }}</div>
                            </div>
                        @endif


                        {{-- Tax --}}
                        @if(($orderData->order->tax ?? 0) > 0)
                            <div class="giftinfo">
                                <div>{{ __('user_messages.tax_if_any') }}</div>
                                <div> {{ number_format(convertPriceInUserWeb($orderData->order->tax ), 2) }} {{ $currency }}</div>
                            </div>
                        @endif

                        <div class="giftinfo">
                            <div>{{ __('user_messages.total_amount') }}</div>
                            <div>
                                 {{ number_format(convertPriceInUserWeb($orderData->order->total_amount ), 2) }} {{ $currency }}
                            </div>
                        </div>

                    </div>


                </div>
                @php
                $discountMRP = $orderData->order->discount_mrp ?? 0;
                $couponDiscount = $orderData->order->promocode_value ?? 0;
                $giftcardDiscount = $orderData->order->giftcard_amount ?? 0;

                $totalDiscount = $discountMRP + $couponDiscount + $giftcardDiscount;
                @endphp
                @if($orderData->order->order_type=='1')
                <div class="return-green">You will save  {{ number_format(convertPriceInUserWeb($totalDiscount ), 2) }} {{ $currency }} on this</div>
                @endif


                <div class="gift-pnl mt-3">
                    <div class="giftinfo">
                        <h6>{{ __('user_messages.paid_by') }}</h6>
                        @if(isset($orderData->order->transaction_id) && $orderData->order->transaction_id != 0)
                        <div class="trans" style="color:#714829;font-size:12px;">{{ __('user_messages.transaction_id') }}:
                            {{$orderData->order->transaction_id }}</div>
                        @endif
                    </div>
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>{{ number_format(convertPriceInUserWeb($orderData->order->total_amount ), 2) }} {{ $currency }}</div>
                            <!-- <div>Paid By Card</div> -->
                            <div>
                                @php
                                $paymentMethod = $orderData->order->payment_method ?? 0;
                                $paymentStatus = $orderData->order->payment_status ?? 0;
                                @endphp

                                @if($paymentMethod == '1')
                                {{ __('user_messages.paid_by_card') }}
                                @elseif($paymentMethod == '2')
                                {{ __('user_messages.paid_by_wallet') }}
                                @elseif($paymentMethod == '3')
                                @if($paymentStatus == '1')
                                {{ __('user_messages.cash_on_delivery') }}
                                @else
                                {{ __('user_messages.cod') }}
                                @endif
                                @else
                                {{ __('user_messages.payment_info_not_available') }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- @if($orderData->order->order_type == '1') -->
                <div class="mt-4 text-center">
                    <a href="{{ url('InvoiceUser', ['order_id' => $orderData->order->order_id]) }}" target="_blank"
                        class="customBtn8 mb-3 text-decoration-none">
                        {{ __('user_messages.download_invoice') }}
                    </a>
                </div>
                <!-- @endif -->
                <!-- @if($orderData->delivery_status !== '3' && $orderData->payment_status !== '2' &&
                        $orderData->payment_status !== '3' && $orderData->order->order_type == '2')
                @php
                 $cancelDays = 3; 
                $orderCreated = \Carbon\Carbon::parse($orderData->order->created_at);
                $cancelLastDate = $orderCreated->copy()->addDays($cancelDays);
                $cancelAllowed = \Carbon\Carbon::today()->lte($cancelLastDate);
                @endphp
                @if($cancelAllowed)
                <div class="mt-4 text-center">
                    <button class="btn btn-outline-red W-100 mb-3 text-decoration-none cancelBtn lineheight-2" data-bs-toggle="modal"
                        data-bs-target="#cancelModal" data-order-id="{{ $orderData->order_id }}"
                        data-order-details-id="{{ $orderData->id }}">
                        Cancel Order
                    </button>
                </div>
                @endif
                @endif -->
            </div>
        </div>
    </div>
</div>


<!-- Cancel order -->

<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('user_messages.select_reason') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="reason-list">

                    @foreach ($cancelReasons as $index => $reason)
                    <label class="custom-radio mb-3">
                        <input type="radio" name="cancel_reason" value="{{ app()->getLocale() == 'en' ? $reason->reason_english : $reason->reason_arabic }}"
                            {{ $index === 0 ? 'checked' : '' }}>
                        <span class="radio-mark"></span>
                        <div class="label-content">
                            <div class="title">
                                @if(app()->getLocale() == 'en')
                                {{ $reason->reason_english }}
                                @else
                                {{ $reason->reason_arabic }}
                                @endif
                            </div>
                        </div>
                    </label>
                    @endforeach

                    <label class="custom-radio mb-3">
                        <input type="radio" name="cancel_reason" value="other">
                        <span class="radio-mark"></span>
                        <div class="label-content">
                            <div class="title">{{ __('user_messages.other') }}</div>
                        </div>
                    </label>
                </div>

                <!-- Textarea -->
                <div class="form-group mt-2 d-none" id="otherReasonWrapper">
                    <textarea id="otherReason" rows="4" class="form-control" placeholder="{{ __('user_messages.write_here') }}"></textarea>

                    <small class="text-danger d-none" id="otherReasonError">
                        {{ __('user_messages.please_provide_the_reason_for_cancellation') }}
                    </small>
                </div>

                <div class="mt-4">
                    <button type="button" class="customBtn white-btn" id="submitCancel">
                        {{ __('user_messages.submit') }}
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
                <h4 class="modal-title fs-5">{{ __('user_messages.return_request') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="gift-panel-list">
                    <h6>{{ __('user_messages.select_reason') }}</h6>

                    <div class="reason-list" id="returnReasonList">
                        @foreach ($returnReasons as $index => $reason)
                        <label class="custom-radio mb-3">
                            <input type="radio" name="return_reason" value="{{ app()->getLocale() == 'en' ? $reason->reason_english : $reason->reason_arabic }}"
                                {{ $index === 0 ? 'checked' : '' }}>
                            <span class="radio-mark"></span>
                            <div class="label-content">
                                <div class="title">
                                    @if(app()->getLocale() == 'en')
                                {{ $reason->reason_english }}
                                @else
                                {{ $reason->reason_arabic }}
                                @endif
                                </div>
                            </div>
                        </label>
                        @endforeach
                        <label class="custom-radio mb-3">
                            <input type="radio" name="return_reason" value="other">
                            <span class="radio-mark"></span>
                            <div class="label-content">
                                <div class="title">{{ __('user_messages.other') }}</div>
                            </div>
                        </label>
                    </div>

                    <div class="form-group w-100 py-2 mb-3 d-none" id="returnOtherWrapper">
                        <textarea id="returnOtherText" rows="3" class="form-control pline-10"
                            placeholder="{{ __('user_messages.write_here') }}"></textarea>
                        <small class="text-danger d-none" id="returnOtherError">{{ __('user_messages.please_provide_the_reason_for_return') }}
                            </small>
                    </div>

                    <h6>{{ __('user_messages.upload_image_optional') }}</h6>
                    <div class="border-1 p-3">
                        <div class="text-center">
                            <label for="returnImg" class="requestbox">
                                <div class="image-upload-2 mb-1">
                                    <img src="{{ asset('user/assets/images/upload-icon.svg') }}" class="img-fluid"
                                        alt="upload">
                                </div>
                                <div style="font-size:13px;color:#7a7979;">{{ __('user_messages.click_to_upload_image') }}</div>
                                <input type="file" id="returnImg" multiple accept="image/*" style="display:none;">
                            </label>
                        </div>
                    </div>

                    <div class="mt-2">
                        <div id="previewReturn" class="preview-box1 d-flex flex-wrap gap-2"></div>
                    </div>

                    <div class="mt-4">
                        <button type="button" class="customBtn white-btn" id="submitReturn">{{ __('user_messages.submit') }}</button>
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
                <h4 class="modal-title">{{ __('user_messages.exchange_request') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <h6>{{ __('user_messages.select_reason') }}</h6>

                <div class="reason-list">

                    @foreach ($exchangeReasons as $index => $reason)
                    <label class="custom-radio mb-3">
                        <input type="radio" name="exchange_reason" value="{{ app()->getLocale() == 'en' ? $reason->reason_english : $reason->reason_arabic }}"
                            {{ $index === 0 ? 'checked' : '' }}>
                        <span class="radio-mark"></span>
                        <div class="label-content">
                            <div class="title">
                                @if(app()->getLocale() == 'en')
                                {{ $reason->reason_english }}
                                @else
                                {{ $reason->reason_arabic }}
                                @endif
                            </div>
                        </div>
                    </label>
                    @endforeach

                    <!-- Other -->
                    <label class="custom-radio mb-3">
                        <input type="radio" name="exchange_reason" value="other">
                        <span class="radio-mark"></span>
                        <div class="label-content">
                            <div class="title">{{ __('user_messages.other') }}</div>
                        </div>
                    </label>

                </div>

                <!-- Textarea -->
                <div class="form-group mb-3 d-none" id="exchangeOtherWrapper">
                    <textarea id="exchangeOtherText" rows="3" class="form-control" placeholder="{{ __('user_messages.write_here') }}"></textarea>

                    <small class="text-danger d-none" id="exchangeOtherError">
                        {{ __('user_messages.please_provide_the_reason_for_exchange') }}
                    </small>
                </div>
                <h6>{{ __('user_messages.select_available_size') }}</h6>
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
                        {{ __('user_messages.submit') }}
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<input type="text" id="user_id" value="{{ optional(Auth::guard('web')->user())->id ?? '' }}">
<!-- Rating section Modal -->
<div class="modal fade" id="ratingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5">{{ __('user_messages.rate_this_product') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="gift-panel-list">

                    <!-- Product Rating -->
                    <div class="reason-list rating-widget ">
                        <h6>{{ __('user_messages.rate_product') }}</h6>
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
                        <p>{{ __('user_messages.write_review') }}</p>
                        <textarea rows="1" class="form-control pline-10" placeholder="{{ __('user_messages.write_here') }}"></textarea>
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
                        <h6>{{ __('user_messages.rate_store') }}</h6>
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
                        <p>{{ __('user_messages.write_review') }}</p>
                        <textarea rows="1" class="form-control pline-10" placeholder="{{ __('user_messages.write_here') }}"></textarea>
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
                        <button type="button" class="customBtn mb-3 white-btn">{{ __('user_messages.write_here') }}</button>
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
            toastr.error("{{ __('user_messages.please_select_a_reason') }}");
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
            toastr.error("{{ __('user_messages.please_select_a_size') }}");
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
        // sizeWrapper.innerHTML = '<p>Loading...</p>';
        sizeWrapper.innerHTML = '<p>{{ __("user_messages.loading") }}...</p>';

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
                                <div class="title">
                                {{ app()->getLocale() == 'en' ? '${size.name}' : '${size.name_ar}' }}
                                </div>
                            </div>
                        </label>
                    `;
                    });
                    sizeWrapper.innerHTML = html;
                } else {
                    sizeWrapper.innerHTML = '<p>{{ __("user_messages.no_size_available") }}</p>';
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
            toastr.error("{{ __('user_messages.please_select_a_reason') }}");
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
     const userId = document.getElementById('user_id').value;
       if (!userId) {
            toastr.error('Please login first');

            setTimeout(() => {
                window.location.href = "{{ route('login') }}";
            }, 1000);

            return;
        }

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