@extends('user.layout.app')

@section('content')

<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="{{route('user.gift_cards')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
        <h3>Details</h3>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="giftoff">
                <img src="{{asset('user/assets/images/gift/gift1.svg')}}" class="img-fluid">
            </div>
        </div>

        <div class="col-lg-8 col-md-6">
            <div class="giftcard-type">
                <div class="border-1 giftinfo">
                    <div>Birthday Card</div>
                    <div>239 KD</div>
                </div>
                <div class="gift-pnl mt-4">
                    <h6>Recipient Details</h6>

                    <div class="border-1">
                        <div class="giftinfo">
                            <div>Name</div>
                            <div>Atif Aslam</div>
                        </div>
                        <div class="giftinfo">
                            <div>Email Id</div>
                            <div>Atif23@gmail.com</div>
                        </div>
                        <div class="giftinfo">
                            <div>Total Quantity-2</div>
                            <div>2</div>
                        </div>
                    </div>
                </div>
                <div class="gift-pnl mt-4">
                    <h6>From</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>Name</div>
                            <div>Atif Aslam</div>
                        </div>
                    </div>
                </div>
                <div class="gift-pnl mt-4">
                    <h6>Wish Message</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>lorem ipsum dolor sit amet, consectetur dolor do adipisicing elit, sed do eiusmod
tempor elit incididunt  et dolore magna. lorem ipsum dolor sit amet, consectetur dolor do adipisicing elit, sed do eiusmod
tempor elit incididunt  et dolore magna.</div>
                        </div>
                    </div>
                </div>

                <div class="gift-pnl mt-4">
                    <h6>Paid by</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>299 KD</div>
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

