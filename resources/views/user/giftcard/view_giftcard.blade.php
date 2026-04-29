@extends('user.layout.app')

@section('content')

@php
    $currency = session('currency', 'KWD');
    $rate = session('rate', '1');
 
@endphp

<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="{{ route('user.gift_cards') }}"> 
            <img src="{{ asset('user/assets/images/left-ic.svg') }}" class="img-fluid">
        </a>
        <h3>Details</h3>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="giftoff">
                <img src="{{ $giftCard->gift_details->image }}" class="img-fluid" alt="Gift Card Image">
            </div>
        </div>

        <div class="col-lg-8 col-md-6">
            <div class="giftcard-type">
                <div class="border-1 giftinfo">
                    <div>{{ $giftCard->gift_details->name_english }}</div>
                    <div> {{ number_format(convertPriceInUserWeb($giftCard->amount), 2) }}  {{ $currency }}</div>
                </div>

                <div class="gift-pnl mt-4">
                    <h6>Recipient Details</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>Name</div>
                            <div>{{ $giftCard->receiver_name }}</div>
                        </div>
                        <div class="giftinfo">
                            <div>Email Id</div>
                            <div>{{ $giftCard->receiver_email }}</div>
                        </div>
                    </div>
                </div>

                <div class="gift-pnl mt-4">
                    <h6>From</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>Name</div>
                            <div>{{ $giftCard->sender_name }}</div>
                        </div>
                        <div class="giftinfo">
                            <div>Email</div>
                            <div>{{ $giftCard->sender_email }}</div>
                        </div>
                    </div>
                </div>

                <div class="gift-pnl mt-4">
                    <h6>Wish Message</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>{{ $giftCard->wish_message }}</div>
                        </div>
                    </div>
                </div>

                <div class="gift-pnl mt-4">
                    <h6>Paid by</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>{{ number_format(convertPriceInUserWeb($giftCard->amount), 2) }}  {{ $currency }}</div>
                            <div>Paid By Card</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   

</script>


@endsection

