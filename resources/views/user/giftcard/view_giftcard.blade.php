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
        <h3>{{ __('user_messages.details') }}</h3>
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
                    <div>
                        @if(app()->getLocale() == 'en')
                        {{ $giftCard->gift_details->name_english }}
                        @else
                        {{ $giftCard->gift_details->name_arabic }}
                        @endif
                    </div>
                    <div> {{ number_format(convertPriceInUserWeb($giftCard->amount), 2) }}  {{ $currency }}</div>
                </div>

                <div class="gift-pnl mt-4">
                    <h6>{{ __('user_messages.recipient_details') }}</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>{{ __('user_messages.name') }}</div>
                            <div>{{ $giftCard->receiver_name }}</div>
                        </div>
                        <div class="giftinfo">
                            <div>{{ __('user_messages.email_id') }}</div>
                            <div>{{ $giftCard->receiver_email }}</div>
                        </div>
                    </div>
                </div>

                <div class="gift-pnl mt-4">
                    <h6>{{ __('user_messages.from') }}</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>{{ __('user_messages.name') }}</div>
                            <div>{{ $giftCard->sender_name }}</div>
                        </div>
                        <div class="giftinfo">
                            <div>{{ __('user_messages.email_id') }}</div>
                            <div>{{ $giftCard->sender_email }}</div>
                        </div>
                    </div>
                </div>

                <div class="gift-pnl mt-4">
                    <h6>{{ __('user_messages.wish_message') }}</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>{{ $giftCard->wish_message }}</div>
                        </div>
                    </div>
                </div>

                <div class="gift-pnl mt-4">
                    <h6>{{ __('user_messages.paid_by') }}</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>{{ number_format(convertPriceInUserWeb($giftCard->amount), 2) }}  {{ $currency }}</div>
                            <div>
                                @if($giftCard->payment_method==2)
                                {{ __('user_messages.paid_by_wallet') }}
                                @else
                                {{ __('user_messages.paid_by_card') }}
                                @endif
                            </div>
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

