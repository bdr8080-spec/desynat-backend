@extends('user.layout.app')

@section('content')

<style>
.order-place-grid {
    padding: 60px;
}

.order-place {
    background: var(--gradient-color);
    text-align: center;
    border-radius: 5px;
    padding: 60px 0px 0px;
}

.place-footer {
    background: var(--gradient-color);
    padding: 9px;
    color: #fff;
    border-radius: 5px;
    font-size: 25px;
}
</style>

<div class="customContainer common-padding">
    <div class="main-content">
        <div class="order-place">
            <div class="order-place-grid">
                <img src="{{asset('user')}}/assets/images/success_check_tick.gif" class="img-fluid mb-4" />
                <h3>Order Placed Successfully !</h3>
            </div>
            <div class="place-footer">
                <div>
                    {{ number_format($orderData['data']->total_amount, 2) }} KD
                    @if($orderData['data']->payment_method == 1)
                    <span>Paid Online</span>
                    @elseif($orderData['data']->payment_method == 2)
                    <span>Paid Using Wallet</span>
                    @elseif($orderData['data']->payment_method == 3)
                    <span>Cash on Delivery (COD)</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="gift-pnl mt-4 mb-4">
            <h6>Items will be delivered to</h6>
            <div class="border-1 d-flex gap-3">
                <img src="{{asset('user')}}/assets/images/gps-icon.svg" class="img-fluid" />
                <div class="giftinfo">
                    <div> {{ $orderData['data']->delivery_details->name }}
                        <p class="mb-0">
                            {{ $orderData['data']->delivery_details->address }},{{ $orderData['data']->delivery_details->house_no }},{{ $orderData['data']->delivery_details->postal_code }},{{ $orderData['data']->delivery_details->city }},{{ $orderData['data']->delivery_details->state }},{{ $orderData['data']->delivery_details->country_name }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="bag-topbar-full d-flex justify-content-between align-items-center">


            <div>Track your Order</div>

            <!-- <a href="{{ route('user.myOrders') }}"> <i class="bi bi-arrow-right arrow-icon"></i> </a> -->
             <a href="{{ route('user.myOrders', [
                    'type' => ($orderData['data']->order_type == '1') ? 'normal' : 'custom'
                ]) }}">
                <i class="bi bi-arrow-right arrow-icon"></i>
            </a>

        </div>


        <div class="my-profile mt-5">
            <a href="{{ route('dashboard') }}" class="customBtn2"> Continue Shopping</a>
        </div>

    </div>

</div>



@endsection