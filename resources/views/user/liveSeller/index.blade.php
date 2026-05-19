@extends('user.layout.app')

@section('content')

<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="/"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
        <h3>{{ __('user_messages.seller_live') }}</h3>
    </div>



    <div class="row">
        <div class="col-lg-12">

            @forelse($live_records as $val)

            <div class="live-pnl">
                <div class="cart-panel position-relative">
                    <a href="#" class="link-content w-100">
                        <div class="cart-card d-flex justifry-content-between w-100 align-items-center">
                            <div class="card-left mb-2 d-flex align-items-center w-100">
                                <div>
                                    <div class="chat-user-circle me-3">
                                        <img src="{{$val->seller_details->profile_pic}}" alt="seller-image"
                                            class="img-fluid">
                                    </div>
                                </div>
                                <div class="w-100">
                                    <div class="card-right d-flex w-100 justify-content-between align-items-baseline">
                                        <div class="product-info">
                                            <h6 class="product-title linkgold"> {{$val->seller_details->first_name}}
                                                {{$val->seller_details->last_name}}</h6>
                                            <div class="chat-user-light"> {{$val->timeslot_details->date}}
                                            </div>

                                            <div class="chat-user-light"> {{$val->timeslot_details->from}} -
                                                {{$val->timeslot_details->to}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="join-btn-{{ $val->id }}"></div>

                        </div>
                    </a>
                </div>
            </div>

            @empty
            <div class="col-12 text-center">
                <h5>{{ __('user_messages.no_live_request_found') }}</h5>
            </div>
            @endforelse

        </div>


    </div>


</div>

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
const chatRooms = @json(collect($live_records ?? []));

// const chatRooms = @json(
//     collect($live_records ?? [])->map(function($val) {
//         return {
//             id: $val.id,
//             channel_id: $val.channel_id
//         };
//     }).values()
// );


function checkAllLive() {

    chatRooms.forEach(room => {

        fetch(`/check-live-join-time-status/${room.id}`)
            .then(res => res.json())
            .then(data => {

                let btnDiv = document.getElementById('join-btn-' + room.id);

                if (!btnDiv) return;

                if (data.live) {
                    btnDiv.innerHTML = `
                        <a href="/user/View-live-seller-records?channel_id=${room.channel_id}"
                           class="btn customBtn5 text-white"
                           style="width:130px;">
                           {{ __('user_messages.watch_live') }}
                        </a>
                    `;
                } else {
                    btnDiv.innerHTML = "";
                }

            })
            .catch(err => console.log(err));

    });

}

// run immediately
checkAllLive();

// run every 5 seconds
setInterval(checkAllLive, 5000);
</script>