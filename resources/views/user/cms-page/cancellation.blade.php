@extends('user.layout.app')

@section('content')

<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="/"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
        <h3>{{ __('user_messages.cancellation_policy') }}</h3>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="live-pnl">
                @if(app()->getLocale() == 'en')
                <p>{!!$data->content_english!!}</p>
                @else
                <p>{!!$data->content_arabic!!}</p>
                @endif
            </div>
        </div>
    </div>


</div>

@endsection

