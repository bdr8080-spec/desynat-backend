@include('dealer.layout.header')

<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="{{route('seller.dashboard')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
        <!-- <h3>{{$data->title}}</h3> -->
         <h3>{{__('seller_messages.Exchange_Policy')}} </h3>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="live-pnl">

                   @if(App::getlocale()=='ar') 
                     <p>{!!$data->content_arabic!!}</p>
                  @else 
                   <p>{!!$data->content_english!!}</p>

                  @endif


            </div>
        </div>
    </div>


</div>

@include('dealer.layout.custom_code');
@include('dealer.layout.footer');

