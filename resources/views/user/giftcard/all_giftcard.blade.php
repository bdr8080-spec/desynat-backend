@extends('user.layout.app')

@section('content')

@php
    $currency = session('currency', 'KWD');
    $rate = session('rate', '1');
 
@endphp



<div class="customContainer">
    <div class="giftsearch py-5 d-flex w-100 gap-4">
        <form action="{{ route('user.gift_cards') }}" method="GET" class="w-100 d-flex gap-2">
            <div class="form-group w-100 d-flex">
                <div class="searchicon"><i class="bi bi-search"></i></div>
                <input type="search" name="search" class="form-control giftcontrol" placeholder="Search"
                    value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn btnsearch">Search</button>
        </form>

        <a href="{{ route('user.add_gift_cards') }}" class="add-icon">
            <img src="{{ asset('user/assets/images/add-icon.svg') }}" alt="gift image" class="img-fluid">
        </a>
    </div>


    <!-- @if (session('status') == 'success')
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @elseif (session('status') == 'error')
    <div class="alert alert-danger">
        {{ session('message') }}
    </div>
    @endif -->

    <div class="row">
        @forelse($giftCards as $gift)
        <div class="col-lg-4 col-md-6">
            <a href="{{ route('user.view_gift_card',$gift->id) }}" class="gift_hover">
                <div class="giftcard">
                    <figure>
                        <img src="{{ $gift->gift_details->image }}" alt="gift image" class="img-fluid">
                    </figure>
                    <div class="gift-card-body p-3">
                        <div class="gift-title">
                            <h5>{{ $gift->sender_name ?? 'N/A' }}</h5>
                            <div class="giftdate">{{ $gift->created_at->format('d M y, h:i a') }}</div>
                        </div>
                        <div class="gift-title">
                            <h5>{{ number_format(convertPriceInUserWeb($gift->amount), 2) }}  {{ $currency }}</h5>
                            <div class="giftdate">{{ $gift->gift_details->name_english ?? 'Gift Card' }}</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <h5>No gift card found</h5>
        </div>
        @endforelse


    </div>

</div>



@endsection