@extends('user.layout.app')

@section('content')


<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="#"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
        <h3>Add Money</h3>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-6">
            <div class="gift-pnl addheight">
                <h6>Amount</h6>
                <div class="occasion-buttons mb-3">
                    <button type="button" class="amount-btn min-width-100 active" data-value="50">50 KD</button>
                    <button type="button" class="amount-btn min-width-100" data-value="100">100 KD</button>
                </div>
                <div class="form-group w-100 py-2 amountpnl">
                    <input type="text" class="form-control pline-10" placeholder="Enter Amount">
                </div>
            </div>

        </div>


        <div class="col-lg-4 col-md-6">
            <div class="paycard">
                <div class="payment-option mb-3">
                    <label class="custom-radio">
                        <input type="radio" name="payment">
                        <span class="radio-mark"></span>
                        <div class="label-content">
                            <div class="title">In-App Wallet</div>
                            <div class="balance">Available Balance : 349 KD</div>
                        </div>
                    </label>
                </div>
                <div class="payment-option">
                    <label class="custom-radio">
                        <input type="radio" name="payment">
                        <span class="radio-mark"></span>
                        <div class="label-content d-flex gap-2">
                            <span class="cod-box">COD</span>
                            <div class="title">Cash On Delivery</div>
                        </div>
                    </label>
                </div>
            </div>

            <div class="cmn-btn mt-4">
                <button type="submit" class="btn paybtn-common w-100" data-bs-target="#addamountModal" data-bs-toggle="modal">Pay Now</button>
            </div>
        </div>
    </div>

</div>

<!-- Success Modal -->
<div class="modal fade" id="addamountModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content added-modal">
            <div class="modal-body">
                <div class="text-center">
                    <img src="{{ asset('dealer') }}/assets/img/success.svg" alt="icon" class="img-fluid">
                    <h5 class="title24 py-3">Amount Added Successfully!</h5>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection