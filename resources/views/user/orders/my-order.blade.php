@extends('user.layout.app')

@section('content')

@php
    $currency = session('currency', 'KWD');
    $rate = session('rate', '1');
 
@endphp

<div class="categoryDetail customContainer">

    <!-- <div class="tabs-panel py-4">
        <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active w-100" id="pills-allproduct-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-orders" type="button" role="tab" aria-controls="pills-orders"
                    aria-selected="true">Orders</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link w-100" id="pills-ordercustom-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-ordercustom" type="button" role="tab" aria-controls="pills-ordercustom"
                    aria-selected="false">Custom Orders</button>
            </li>
        </ul>
    </div> -->
    @php
    $type = request('type', 'normal'); // default = normal
    @endphp

    <div class="tabs-panel py-4">
        <!-- <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">

            <li class="nav-item" role="presentation">
                <button class="nav-link w-100 {{ $type == 'normal' ? 'active' : '' }}" id="pills-orders-tab"
                    data-bs-toggle="pill" data-bs-target="#pills-orders" type="button" role="tab"
                    aria-controls="pills-orders" aria-selected="{{ $type == 'normal' ? 'true' : 'false' }}">
                    Orders
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link w-100 {{ $type == 'custom' ? 'active' : '' }}" id="pills-ordercustom-tab"
                    data-bs-toggle="pill" data-bs-target="#pills-ordercustom" type="button" role="tab"
                    aria-controls="pills-ordercustom" aria-selected="{{ $type == 'custom' ? 'true' : 'false' }}">
                    Custom Orders
                </button>
            </li>

        </ul> -->
    </div>


    <div class="tab-body-wapper">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-orders" role="tabpanel" aria-labelledby="pills-orders-tab"
                tabindex="0">

                <div class="row">
                    <div class="col-lg-4">
                        <div class="category_filter">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h3 class="mb-0">{{ __('user_messages.filter') }}</h3>
                                <a href="{{route('user.myOrders')}}">{{ __('user_messages.clear') }}</a>
                            </div>
                            <form method="GET" action="{{ route('user.myOrders') }}">
                                <div class="orderfilter">
                                    <label class="custom-radio mb-3">
                                        <input type="radio" name="filter" value=""
                                            {{ request('filter') == null ? 'checked' : '' }}>
                                        <span class="radio-mark"></span>
                                        <div class="label-content">
                                            <div class="title">{{ __('user_messages.all') }}</div>
                                        </div>
                                    </label>
                                    <label class="custom-radio mb-3">
                                        <input type="radio" name="filter" value="2"
                                            {{ request('filter') == '2' ? 'checked' : '' }}>
                                        <span class="radio-mark"></span>
                                        <div class="label-content">
                                            <div class="title">{{ __('user_messages.ongoing') }}</div>
                                        </div>
                                    </label>
                                    <label class="custom-radio mb-3">
                                        <input type="radio" name="filter" value="3"
                                            {{ request('filter') == '3' ? 'checked' : '' }}>
                                        <span class="radio-mark"></span>
                                        <div class="label-content">
                                            <div class="title">{{ __('user_messages.delivered') }}</div>
                                        </div>
                                    </label>
                                    <label class="custom-radio mb-3">
                                        <input type="radio" name="filter" value="4"
                                            {{ request('filter') == '4' ? 'checked' : '' }}>
                                        <span class="radio-mark"></span>
                                        <div class="label-content">
                                            <div class="title">{{ __('user_messages.cancelled') }}</div>
                                        </div>
                                    </label>
                                    <label class="custom-radio mb-3">
                                        <input type="radio" name="filter" value="5"
                                            {{ request('filter') == '5' ? 'checked' : '' }}>
                                        <span class="radio-mark"></span>
                                        <div class="label-content">
                                            <div class="title">{{ __('user_messages.return') }}</div>
                                        </div>
                                    </label>

                                </div>

                                <button type="submit" class="customBtn customBtn5 mt-5">
                                    {{ __('user_messages.apply') }}
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="categoryDetail_content">
                            <form action="{{ route('user.myOrders') }}" method="GET">
                                <div class="seArch">
                                    <div class="form-group position-relative search">
                                        <input type="text" class="form-control" placeholder="{{ __('user_messages.search') }}" name="search"
                                            value="{{ request()->search }}" />
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </div>
                                    <button type="submit" class="customBtn customBtn5">
                                        {{ __('user_messages.search') }}
                                    </button>
                                </div>
                            </form>


                            <!-- <div class="cart-panel position-relative">
                                    <a href="order_details" class="link-content">
                                        <div class="cart-card bottom-pd">
                                            <div class="card-left mb-2 d-flex">
                                                <div>
                                                    <div class="ongoing-title" style="color:#FF5F1B;">Ongoing</div>
                                                    <div class="cart-products order-images me-3">
                                                        <img src="{{asset('user/assets/images/categorie1.png')}}" alt="Product"
                                                            class="img-fluid">
                                                    </div>
                                                </div>

                                                <div class="w-100">
                                                    <div class="card-right d-flex w-100 justify-content-between">
                                                        <div class="product-info">
                                                            <h5 class="product-title"> Order ID :# <span>123456789</span></h5>
                                                            <div class="price-current"> Mooei Pcs set</div>
                                                            <div class="psize d-flex gap-4 mt-2">
                                                                <span>Size: M</span>
                                                                <span class="d-flex align-items-center gap-2">
                                                                    Color:
                                                                    <div class="colorbox" style="width:15px;height:15px;border-radius:3px;background:#000;">
                                                                    </div>
                                                                </span>
                                                                <span>Qnt: 1</span>
                                                            </div>
                                                            
                                                        </div>
                                                        <h5 class="product-title"> 440 KD</h5>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <p class="delivery-label mb-2">Placed</p>
                                                        <p class="delivery-date mb-2">7PM | 21-02-2025</p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="expert-date">Expected Delivery Date : 12 SEP 25</div>
                                    </a>
                                </div> -->

                            @forelse($orderData as $orderDetail)

                            @php
                            $order = $orderDetail->order;
                            $orderdetail = $orderDetail;
                            $product = $orderDetail->product_details;
                            $variant = $orderDetail->variation_details;
                            $color = $variant->color ?? null;
                            $size = $variant->size ?? null;

                            // Handle variant image (array or JSON)
                            if (is_array($variant->variant_image)) {
                            $images = $variant->variant_image;
                            } else {
                            $images = json_decode($variant->variant_image ?? '[]', true);
                            }

                            $image = $images[0] ?? asset('user/assets/images/categorie1.png');

                            // Order status text
                            $statusText = match (true) {

                            // 1 → Cancelled Order
                            $orderdetail->payment_status == '2' || $orderdetail->payment_status == '3'
                            => __('user_messages.cancelled'),

                            // 2 → confirmed
                            $orderdetail->delivery_status == '1' &&
                            $orderdetail->return_type == '0'
                            => __('user_messages.ongoing'),

                            // 2 → Ongoing
                            $orderdetail->delivery_status == '2' || $orderdetail->delivery_status == '1' &&
                            $orderdetail->return_type == '0'
                            => __('user_messages.ongoing'),

                            // 2.1 → shipped
                            $orderdetail->delivery_status == '2.1' &&
                            $orderdetail->return_type == '0'
                            => __('user_messages.shipped'),

                            // 2.2 → shipped
                            $orderdetail->delivery_status == '2.2' &&
                            $orderdetail->return_type == '0'
                            => __('user_messages.on_the_way'),

                            // 3 → Delivered
                            $orderdetail->delivery_status == '3' &&
                            $orderdetail->return_type == '0'
                            => __('user_messages.delivered'),

                            // 4 → Cancelled
                            $orderdetail->payment_status == '2'
                            => __('user_messages.cancelled'),

                            // 5 → Returned / Failed
                            $orderdetail->delivery_status == '3' && $orderdetail->return_type == '2'
                            => __('user_messages.exchange_request'),

                            // 5 → Exchange / Failed
                            $orderdetail->delivery_status == '3' && $orderdetail->return_type == '1'
                            => __('user_messages.return_request'),

                            // Default
                            default => __('user_messages.ongoing'),
                            };

                            [$statusColor, $bgColor] = match ($statusText) {

                            __('user_messages.delivered') => ['#28a745', '#28a7451A'],

                            __('user_messages.cancelled') => ['#E70000', '#E700001A'],

                            __('user_messages.exchange_request')=>['#FF5F1B', 'rgba(255, 95, 27, 0.1)'],
                            __('user_messages.return_request')=>['#FF5F1B', 'rgba(255, 95, 27, 0.1)'],

                            default => ['#FF5F1B', '#79d69d1a'],
                            };
                            @endphp

                            <div class="cart-panel position-relative">
                                <!-- <a href="{{ route('user.order_details', ['id' => $orderDetail->order->order_id]) }}" class="link-content"> -->
                                <a href="{{ route('user.order_details', ['id' => $orderDetail->order->id]) }}?orderdetails_id={{ $orderDetail->id }}"
                                    class="link-content">

                                    <div class="cart-card bottom-pd">
                                        <div class="card-left mb-2 d-flex">

                                            <div>
                                                <div class="ongoing-title" style="color:{{ $statusColor }}">
                                                    {{ $statusText }}
                                                </div>

                                                <div class="cart-products order-images me-3">
                                                    <img src="{{ $image }}" alt="Product" class="img-fluid">
                                                </div>
                                            </div>

                                            <div class="w-100">
                                                <div class="card-right d-flex w-100 justify-content-between">
                                                    <div class="product-info">
                                                        <h5 class="product-title">
                                                            {{ __('user_messages.order_id') }} :#
                                                            <span>{{ $orderDetail->id }}</span>
                                                        </h5>

                                                        <div class="price-current">
                                                            @if(app()->getLocale() == 'en')
                                                            {{ $product->product_name_en ?? __('user_messages.na') }}
                                                            @else
                                                            {{ $product->product_name_ar ?? __('user_messages.na') }}
                                                            @endif
                                                        </div>

                                                        <div class="psize d-flex gap-4 mt-2">
                                                            @if($size)
                                                            <span>{{ __('user_messages.size') }}: @if(app()->getLocale() == 'en'){{ $size->name }}@else{{ $size->name_ar }}@endif</span>
                                                            @endif

                                                            @if($color)
                                                            <span class="d-flex align-items-center gap-2">
                                                                {{ __('user_messages.color') }}:
                                                                <div class="colorbox"
                                                                    style="width:15px;height:15px;border-radius:3px;
                                                                                    background:{{ $color->hex_code }};">
                                                                </div>
                                                            </span>
                                                            @endif

                                                            <span>{{ __('user_messages.qty') }}: {{ $orderDetail->quantity }}</span>
                                                        </div>
                                                    </div>

                                                    <h5 class="product-title">

                                                        {{ number_format(convertPriceInUserWeb($variant['final_price']), 2) }}  {{ $currency }}

                                                    </h5>
                                                </div>

                                                <div class="d-flex justify-content-between">
                                                    <!-- <p class="delivery-label mb-2">{{ $statusText }}</p> -->
                                                    <p class="delivery-label mb-2">{{ __('user_messages.placed') }}</p>
                                                    <p class="delivery-date mb-2">
                                                        {{ $order->created_at->timezone('Asia/Kolkata')->format('h:i A | d-m-Y') }}
                                                    </p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    @if(in_array($orderdetail->delivery_status, ['1', '2','2.1','2.2','8']) &&
                                    $orderdetail->payment_status !== '2' && $orderdetail->payment_status !== '3' )
                                    <div class="expert-date" style="background:{{ $bgColor }}; color:#28a745">
                                        <!-- Expected Delivery Date : -->
                                        <!-- {{ $orderdetail->updated_at->copy()->addDays(6)->format('d M Y') }} -->
                                        {{ __('user_messages.expected_delivery_date') }} : {{ __('user_messages.3_5_working_days') }}
                                    </div>
                                    @elseif($orderdetail->payment_status == '2' || $orderdetail->payment_status == '3' )
                                    <div class="expert-date"
                                        style="background:{{ $bgColor }}; color:{{ $statusColor }}">
                                        {{ __('user_messages.cancelled_date') }} : {{ $orderdetail->updated_at->format('d M Y') }}
                                    </div>
                                    @elseif($orderdetail->delivery_status == '3' && $orderdetail->return_type == '2')
                                    <div class="expert-date"
                                        style="background:{{ $bgColor }}; color:{{ $statusColor }}">
                                        {{ __('user_messages.exchange_date') }} :
                                        {{ $orderdetail->updated_at->copy()->addDays(6)->format('d M Y') }}
                                    </div>
                                    @elseif($orderdetail->delivery_status == '3' && $orderdetail->return_type == '1')
                                    <div class="expert-date"
                                        style="background:{{ $bgColor }}; color:{{ $statusColor }}">
                                        {{ __('user_messages.pickup_date') }} :
                                        {{ $orderdetail->updated_at->copy()->addDays(6)->format('d M Y') }}

                                    </div>
                                    @elseif($orderdetail->delivery_status == '3' && $orderdetail->payment_status == '1'
                                    && $orderdetail->return_type == '0')
                                    <div class="expert-date"
                                        style="background:{{ $bgColor }}; color:{{ $statusColor }}">
                                        {{ __('user_messages.delivered_date') }} : {{ $orderdetail->updated_at->format('d M Y') }}
                                    </div>
                                    @endif
                                </a>
                            </div>

                            @empty
                            <div class="text-center py-5">
                                <h5 class="mt-3">{{ __('user_messages.no_order_found') }}</h5>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>


            <div class="tab-pane fade" id="pills-ordercustom" role="tabpanel" aria-labelledby="pills-ordercustom-tab"
                tabindex="0">

                <!-- <div class="row">
                    <div class="col-lg-4">
                        <div class="category_filter">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h3 class="mb-0">Filter</h3>
                                <a href="#">Apply</a>
                            </div>

                            <form action="{{ url('user/category-wise-store/' . request()->id) }}" method="GET">
                                <div class="orderfilter">
                                    <label class="custom-radio mb-3">
                                        <input type="radio" name="filter" value="1" checked>
                                        <span class="radio-mark"></span>
                                        <div class="label-content">
                                            <div class="title">All</div>
                                        </div>
                                    </label>
                                    <label class="custom-radio mb-3">
                                        <input type="radio" name="filter" value="1">
                                        <span class="radio-mark"></span>
                                        <div class="label-content">
                                            <div class="title">Ongoing</div>
                                        </div>
                                    </label>
                                    <label class="custom-radio mb-3">
                                        <input type="radio" name="filter" value="1">
                                        <span class="radio-mark"></span>
                                        <div class="label-content">
                                            <div class="title">Delivered</div>
                                        </div>
                                    </label>
                                    <label class="custom-radio mb-3">
                                        <input type="radio" name="filter" value="1">
                                        <span class="radio-mark"></span>
                                        <div class="label-content">
                                            <div class="title">Cancelled </div>
                                        </div>
                                    </label>
                                    <label class="custom-radio mb-3">
                                        <input type="radio" name="filter" value="1">
                                        <span class="radio-mark"></span>
                                        <div class="label-content">
                                            <div class="title">Return </div>
                                        </div>
                                    </label>
                                </div>

                                <button class="customBtn customBtn5 mt-5">Apply</button>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="categoryDetail_content">
                            <form action="{{ url('user/category-wise-store/' . request()->id) }}" method="GET">
                                <div class="seArch">
                                    <div class="form-group position-relative search">
                                        <input type="text" class="form-control" placeholder="Search" name="search"
                                            value="{{request()->search}}" />
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </div>
                                    <button class="customBtn customBtn5">Search</button>
                                </div>
                            </form>

                            <div class="cart-panel position-relative">
                                <div class="cart-card bottom-pd">
                                    <div class="card-left mb-2 d-flex">
                                        <div>
                                            <div class="cart-products order-images me-3">
                                                <img src="{{asset('user/assets/images/categorie1.png')}}" alt="Product"
                                                    class="img-fluid">
                                            </div>
                                        </div>

                                        <div class="w-100">
                                            <div class="card-right d-flex w-100 justify-content-between">
                                                <div class="product-info">
                                                    <h5 class="product-title"> Order ID :# <span>123456789</span></h5>
                                                    <div class="price-current"> Mooei Pcs set</div>
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

                                                </div>
                                                <h5 class="product-title"> 440 KD</h5>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <p class="delivery-label mb-2">Placed</p>
                                                <p class="delivery-date mb-2">7PM | 21-02-2025</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="expert-date">Expected Delivery Date : 12 SEP 25</div>
                            </div>

                            <div class="cart-panel position-relative">
                                <div class="cart-card bottom-pd">
                                    <div class="card-left mb-2 d-flex">
                                        <div>
                                            <div class="cart-products order-images me-3">
                                                <img src="{{asset('user/assets/images/categorie1.png')}}" alt="Product"
                                                    class="img-fluid">
                                            </div>
                                        </div>

                                        <div class="w-100">
                                            <div class="card-right d-flex w-100 justify-content-between">
                                                <div class="product-info">
                                                    <h5 class="product-title"> Order ID :# <span>123456789</span></h5>
                                                    <div class="price-current"> Mooei Pcs set</div>
                                                    <div class="psize d-flex gap-4 mt-2">
                                                        <span>Size: M</span>
                                                        <span class="d-flex align-items-center gap-2">
                                                            Color:
                                                            <div class="colorbox"
                                                                style="width:15px;height:15px;border-radius:3px;">
                                                            </div>
                                                        </span>
                                                        <span>Qnt: 1</span>
                                                    </div>

                                                </div>
                                                <h5 class="product-title"> 440 KD</h5>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <p class="delivery-label mb-2">Placed</p>
                                                <p class="delivery-date mb-2">7PM | 21-02-2025</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="expert-date" style="background:#E700001A;color:#E70000;">Cancelled Date : 12
                                    SEP 25</div>
                            </div>

                            <div class="cart-panel position-relative">
                                <div class="cart-card bottom-pd">
                                    <div class="card-left mb-2 d-flex">
                                        <div>
                                            <div class="cart-products order-images me-3">
                                                <img src="{{asset('user/assets/images/categorie1.png')}}" alt="Product"
                                                    class="img-fluid">
                                            </div>
                                        </div>

                                        <div class="w-100">
                                            <div class="card-right d-flex w-100 justify-content-between">
                                                <div class="product-info">
                                                    <h5 class="product-title"> Order ID :# <span>123456789</span></h5>
                                                    <div class="price-current"> Mooei Pcs set</div>
                                                    <div class="psize d-flex gap-4 mt-2">
                                                        <span>Size: M</span>
                                                        <span class="d-flex align-items-center gap-2">
                                                            Color:
                                                            <div class="colorbox"
                                                                style="width:15px;height:15px;border-radius:3px;">
                                                            </div>
                                                        </span>
                                                        <span>Qnt: 1</span>
                                                    </div>

                                                </div>
                                                <h5 class="product-title"> 440 KD</h5>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <p class="delivery-label mb-2">Placed</p>
                                                <p class="delivery-date mb-2">7PM | 21-02-2025</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="expert-date" style="background:#FF5F1B1A;color:#FF5F1B;">Pickup Date : 12
                                    SEP 25</div>
                            </div>

                        </div>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-lg-4">
                        <div class="category_filter">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h3 class="mb-0">Filter</h3>
                                <a href="{{route('user.myOrders')}}">Clear</a>
                            </div>
                            <form method="GET" action="{{ route('user.myOrders') }}">
                                <div class="orderfilter">
                                    <label class="custom-radio mb-3">
                                        <input type="radio" name="filter1" value=""
                                            {{ request('filter1') == null ? 'checked' : '' }}>
                                        <span class="radio-mark"></span>
                                        <div class="label-content">
                                            <div class="title">All</div>
                                        </div>
                                    </label>
                                    <label class="custom-radio mb-3">
                                        <input type="radio" name="filter1" value="2"
                                            {{ request('filter1') == '2' ? 'checked' : '' }}>
                                        <span class="radio-mark"></span>
                                        <div class="label-content">
                                            <div class="title">Ongoing</div>
                                        </div>
                                    </label>
                                    <label class="custom-radio mb-3">
                                        <input type="radio" name="filter1" value="3"
                                            {{ request('filter1') == '3' ? 'checked' : '' }}>
                                        <span class="radio-mark"></span>
                                        <div class="label-content">
                                            <div class="title">Delivered</div>
                                        </div>
                                    </label>
                                    <label class="custom-radio mb-3">
                                        <input type="radio" name="filter1" value="4"
                                            {{ request('filter1') == '4' ? 'checked' : '' }}>
                                        <span class="radio-mark"></span>
                                        <div class="label-content">
                                            <div class="title">Cancelled</div>
                                        </div>
                                    </label>
                                    <label class="custom-radio mb-3">
                                        <input type="radio" name="filter1" value="5"
                                            {{ request('filter1') == '5' ? 'checked' : '' }}>
                                        <span class="radio-mark"></span>
                                        <div class="label-content">
                                            <div class="title">Return</div>
                                        </div>
                                    </label>

                                </div>

                                <button type="submit" class="customBtn customBtn5 mt-5">
                                    Apply
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="categoryDetail_content">
                            <form action="{{ route('user.myOrders') }}" method="GET">
                                <div class="seArch">
                                    <div class="form-group position-relative search">
                                        <input type="text" class="form-control" placeholder="Search" name="search1"
                                            value="{{ request()->search1 }}" />
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </div>
                                    <button type="submit" class="customBtn customBtn5">
                                        Search
                                    </button>
                                </div>
                            </form>


                            <!-- <div class="cart-panel position-relative">
                                    <a href="order_details" class="link-content">
                                        <div class="cart-card bottom-pd">
                                            <div class="card-left mb-2 d-flex">
                                                <div>
                                                    <div class="ongoing-title" style="color:#FF5F1B;">Ongoing</div>
                                                    <div class="cart-products order-images me-3">
                                                        <img src="{{asset('user/assets/images/categorie1.png')}}" alt="Product"
                                                            class="img-fluid">
                                                    </div>
                                                </div>

                                                <div class="w-100">
                                                    <div class="card-right d-flex w-100 justify-content-between">
                                                        <div class="product-info">
                                                            <h5 class="product-title"> Order ID :# <span>123456789</span></h5>
                                                            <div class="price-current"> Mooei Pcs set</div>
                                                            <div class="psize d-flex gap-4 mt-2">
                                                                <span>Size: M</span>
                                                                <span class="d-flex align-items-center gap-2">
                                                                    Color:
                                                                    <div class="colorbox" style="width:15px;height:15px;border-radius:3px;background:#000;">
                                                                    </div>
                                                                </span>
                                                                <span>Qnt: 1</span>
                                                            </div>
                                                            
                                                        </div>
                                                        <h5 class="product-title"> 440 KD</h5>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <p class="delivery-label mb-2">Placed</p>
                                                        <p class="delivery-date mb-2">7PM | 21-02-2025</p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="expert-date">Expected Delivery Date : 12 SEP 25</div>
                                    </a>
                                </div> -->

                            @forelse($customOrderData as $orderDetail)

                            @php
                            $order = $orderDetail->order;
                            $orderdetail = $orderDetail;
                            $product = $orderDetail->product_details;
                            $variant = $orderDetail->variation_details;
                            $color = $variant->color ?? null;
                            $size = $variant->size ?? null;

                            // Handle variant image (array or JSON)
                            if (is_array($variant->variant_image)) {
                            $images = $variant->variant_image;
                            } else {
                            $images = json_decode($variant->variant_image ?? '[]', true);
                            }

                            $image = $images[0] ?? asset('user/assets/images/categorie1.png');

                            // Order status text
                            $statusText = match (true) {

                            // 1 → Cancelled Order
                            $orderdetail->payment_status == '2' || $orderdetail->payment_status == '3'
                            => 'Cancelled',

                            // 2 → confirmed
                            $orderdetail->delivery_status == '1' &&
                            $orderdetail->return_type == '0'
                            => 'Ongoing',

                            // 2 → Ongoing
                            $orderdetail->delivery_status == '2' || $orderdetail->delivery_status == '1' &&
                            $orderdetail->return_type == '0'
                            => 'Ongoing',

                            // 2.1 → shipped
                            $orderdetail->delivery_status == '2.1' &&
                            $orderdetail->return_type == '0'
                            => 'Shipped',

                            // 2.2 → shipped
                            $orderdetail->delivery_status == '2.2' &&
                            $orderdetail->return_type == '0'
                            => 'On The Way',

                            // 3 → Delivered
                            $orderdetail->delivery_status == '3' &&
                            $orderdetail->return_type == '0'
                            => 'Delivered',

                            // 4 → Cancelled
                            $orderdetail->payment_status == '2'
                            => 'Cancelled',

                            // 5 → Returned / Failed
                            $orderdetail->delivery_status == '3' && $orderdetail->return_type == '2'
                            => 'Exchange Request',

                            // 5 → Exchange / Failed
                            $orderdetail->delivery_status == '3' && $orderdetail->return_type == '1'
                            => 'Return Request',

                            // Default
                            default => 'On Going',
                            };

                            [$statusColor, $bgColor] = match ($statusText) {

                            'Delivered' => ['#28a745', '#28a7451A'],

                            'Cancelled' => ['#E70000', '#E700001A'],

                            "Exchange Request"=>['#FF5F1B', 'rgba(255, 95, 27, 0.1)'],
                            "Return Request"=>['#FF5F1B', 'rgba(255, 95, 27, 0.1)'],

                            default => ['#FF5F1B', '#79d69d1a'],
                            };
                            @endphp

                            <div class="cart-panel position-relative">
                                <!-- <a href="{{ route('user.order_details', ['id' => $orderDetail->order->order_id]) }}" class="link-content"> -->
                                <a href="{{ route('user.order_details', ['id' => $orderDetail->order->id]) }}?orderdetails_id={{ $orderDetail->id }}"
                                    class="link-content">

                                    <div class="cart-card bottom-pd">
                                        <div class="card-left mb-2 d-flex">

                                            <div>
                                                <div class="ongoing-title" style="color:{{ $statusColor }}">
                                                    {{ $statusText }}
                                                </div>

                                                <div class="cart-products order-images me-3">
                                                    <img src="{{ $image }}" alt="Product" class="img-fluid">
                                                </div>
                                            </div>

                                            <div class="w-100">
                                                <div class="card-right d-flex w-100 justify-content-between">
                                                    <div class="product-info">
                                                        <h5 class="product-title">
                                                            Order ID :#
                                                            <span>{{ $orderDetail->id }}</span>
                                                        </h5>

                                                        <div class="price-current">
                                                            {{ $product->product_name_en ?? 'N/A' }}
                                                        </div>

                                                        <div class="psize d-flex gap-4 mt-2">
                                                            @if($size)
                                                            <span>Size: {{ $size->name }}</span>
                                                            @endif

                                                            @if($color)
                                                            <span class="d-flex align-items-center gap-2">
                                                                Color:
                                                                <div class="colorbox"
                                                                    style="width:15px;height:15px;border-radius:3px;
                                                                                    background:{{ $color->hex_code }};">
                                                                </div>
                                                            </span>
                                                            @endif

                                                            <span>Qnt: {{ $orderDetail->quantity }}</span>
                                                        </div>
                                                    </div>

                                                    <h5 class="product-title">
                                                        {{ floor($order->total_mrp) }}
                                                        KD

                                                    </h5>
                                                </div>

                                                <div class="d-flex justify-content-between">
                                                    <!-- <p class="delivery-label mb-2">{{ $statusText }}</p> -->
                                                    <p class="delivery-label mb-2">Placed</p>
                                                    <p class="delivery-date mb-2">
                                                        {{ $order->created_at->format('h:i A | d-m-Y') }}
                                                    </p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    @if(in_array($orderdetail->delivery_status, ['1', '2','2.1','2.2','8']) &&
                                    $orderdetail->payment_status !== '2' && $orderdetail->payment_status !== '3' )
                                    <div class="expert-date" style="background:{{ $bgColor }}; color:#28a745">
                                        <!-- Expected Delivery Date : -->
                                        <!-- {{ $orderdetail->updated_at->copy()->addDays(6)->format('d M Y') }} -->
                                        Expected Delivery Date : 3-5 Working Days
                                    </div>
                                    @elseif($orderdetail->payment_status == '2' || $orderdetail->payment_status == '3' )
                                    <div class="expert-date"
                                        style="background:{{ $bgColor }}; color:{{ $statusColor }}">
                                        Cancelled Date : {{ $orderdetail->updated_at->format('d M Y') }}
                                    </div>
                                    @elseif($orderdetail->delivery_status == '3' && $orderdetail->return_type == '2')
                                    <div class="expert-date"
                                        style="background:{{ $bgColor }}; color:{{ $statusColor }}">
                                        Exchange Date :
                                        {{ $orderdetail->updated_at->copy()->addDays(6)->format('d M Y') }}
                                    </div>
                                    @elseif($orderdetail->delivery_status == '3' && $orderdetail->return_type == '1')
                                    <div class="expert-date"
                                        style="background:{{ $bgColor }}; color:{{ $statusColor }}">
                                        Pickup Date :
                                        {{ $orderdetail->updated_at->copy()->addDays(6)->format('d M Y') }}

                                    </div>
                                    @elseif($orderdetail->delivery_status == '3' && $orderdetail->payment_status == '1'
                                    && $orderdetail->return_type == '0')
                                    <div class="expert-date"
                                        style="background:{{ $bgColor }}; color:{{ $statusColor }}">
                                        Delivered Date : {{ $orderdetail->updated_at->format('d M Y') }}
                                    </div>
                                    @endif
                                </a>
                            </div>

                            @empty
                            <div class="text-center py-5">
                                <h5 class="mt-3">No Order Found</h5>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>



        </div>
    </div>





</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Get last active tab from localStorage
    const lastTab = localStorage.getItem("activeTab");
    if (lastTab) {
        const triggerEl = document.querySelector(`#${lastTab}`);
        if (triggerEl) {
            const tab = new bootstrap.Tab(triggerEl);
            tab.show();
        }
    }

    // Save active tab to localStorage when switched
    const tabButtons = document.querySelectorAll('button[data-bs-toggle="pill"]');
    tabButtons.forEach((button) => {
        button.addEventListener("shown.bs.tab", function() {
            localStorage.setItem("activeTab", this.id);
        });
    });
});
</script>


@endsection