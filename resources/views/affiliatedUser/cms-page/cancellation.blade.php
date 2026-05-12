@include('affiliatedUser.layout.header')

<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="{{route('affiliate.affiliateDashboard')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
        <h3>{{ __('affiliate_messages.cancellation_policy') }}</h3>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="live-pnl">
                <p>
                    @if(app()->getLocale() == 'en')
                    {!!$data->content_english!!}
                    @else
                    {!!$data->content_arabic!!}
                    @endif
                </p>
            </div>
        </div>
    </div>


</div>

@include('affiliatedUser.layout.footer')

