@extends('user.layout.app')

@section('content')

@if (session('status') === 'error')
<div class="alert alert-danger">
    {{ session('message') }}
</div>
@endif

<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="/"> <img src="{{asset('user/assets/images/left-ic.svg')}}"
                class="img-fluid"></a>
        <h3>Seller Live</h3>
    </div>


    
            <div class="row">
                <div class="col-lg-12">

                    @forelse($live_records as $val)

                    <div class="live-pnl">
                        <div class="cart-panel position-relative">
                            <a href="#" class="link-content w-100">
                                <div class="cart-card d-flex justifry-content-between w-100 align-items-center">
                                    <div class="card-left mb-2 d-flex align-items-center">
                                        <div>
                                            <div class="chat-user-circle me-3">
                                                <img src="{{$val->seller_details->profile_pic}}" alt="seller-image"
                                                    class="img-fluid">
                                            </div>
                                        </div>
                                        <div class="w-100">
                                            <div
                                                class="card-right d-flex w-100 justify-content-between align-items-baseline">
                                                <div class="product-info">
                                                    <h6 class="product-title linkgold"> {{$val->order_id}}</h6>
                                                    <div class="chat-user-light"> {{$val->timeslot_details->date}}
                                                    </div>
                                                    <div class="chat-user-light"> {{$val->timeslot_details->from}} -
                                                        {{$val->timeslot_details->to}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <a href="{{route('user.ViewLiveSellerRecords',['channel_id'=>$val->channel_id ])}}"
                                        class="btn btn-info text-white" style="width:100px;">Join us</a>
                                </div>
                            </a>
                        </div>
                    </div>

                    @empty
                    <div class="col-12 text-center">
                        <h5>No Live Request Found</h5>
                    </div>
                    @endforelse

                </div>


            </div>


</div>


@endsection