@include('dealer.layout.header')


<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24">Live Join Requests</div>
        <!-- <a href="#" class="btn btn-success exportbtn">Export</a> -->

    </div>
    <div class="datatable-wapper mt-4">
        <div class="table-header-3">

            <!-- $liverequest['future_requests'] -->

            <div class="row">
                <div class="col-lg-12">

                    @forelse($liverequest['current_requests'] as $val)

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

                                    {{-- <a href="{{route('sellerLive',['channel_id'=>$val->channel_id ])}}"
                                        class="btn-success text-white" style="width:100px;">Join us</a> --}}
                                        
                                 <div id="join-btn-{{ $val->id }}"></div>


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

    </div>

</section>

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24">Future Join Requests</div>
        <!-- <a href="#" class="btn btn-success exportbtn">Export</a> -->

    </div>
    <div class="datatable-wapper mt-4">
        <div class="table-header-3">

            <!-- $liverequest['future_requests'] -->

            <div class="row">
                <div class="col-lg-12">

                    @forelse($liverequest['future_requests'] as $val)

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

                                    <a href="#" class="btn-success text-white" style="width:100px;">Join us</a>
                                </div>
                            </a>
                        </div>
                    </div>

                    @empty
                    <div class="col-12 text-center">
                        <h5>No Future Live Request Found</h5>
                    </div>
                    @endforelse

                </div>


            </div>

        </div>

    </div>

</section>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

const chatRooms = @json(
    collect($liverequest['current_requests'] ?? [])->map(function($val) {
        return [
            'id' => $val->id,
            'channel_id' => $val->channel_id
        ];
    })->values()
);

function checkAllLive() {

    if (!chatRooms.length) return;

    chatRooms.forEach(room => {

        fetch(`/check-live-join-time-status/${room.id}`)
            .then(res => res.json())
            .then(data => {

                let btnDiv = document.getElementById('join-btn-' + room.id);

                if (!btnDiv) return;

                if (data.live) {
                    btnDiv.innerHTML = `
                        <a href="/seller/seller-live-view?channel_id=${room.channel_id}"
                           class="btn btn-red text-white"
                           style="width:100px;">
                          Go Live
                        </a>
                    `;
                } else {
                    btnDiv.innerHTML = "";
                }

            })
            .catch(err => console.log(err));

    });

}

// initial run
checkAllLive();

// every 5 seconds
setInterval(checkAllLive, 5000);

</script>



@include('dealer.layout.custom_code');
@include('dealer.layout.footer');