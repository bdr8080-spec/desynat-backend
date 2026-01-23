@extends('user.layout.app')

@section('content')


<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="{{route('dashboard')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
        <h3>My Wallet</h3>
    </div>

    <div class="main-content categoryDetail">
        <div class="cart-panel position-relative">
            <div class="gift-pnl mt-0">
                <h6>Wallet Transactions</h6>

                <div class="border-1 mb-3 mt-3 bg-multiple p-3">
                    <div class="total-w d-flex justify-content-between">
                        <div class="total-balance">
                            <div class="balance-title">Total Balance</div>
                            <div class="walletic d-flex gap-2 align-items-center mt-3"> 
                                <div class="wallet-ic">
                                    <img src="{{asset('user/assets/images/wallet-ic.svg')}}" class="img-fluid">
                                </div>
                                <h5>28392.98 KD</h5>
                            </div>
                        </div>
                        <div class="total-balance-2">
                            <a href="/add-money" class="btn btn-top">Top-up Wallet</a>
                            <button type="button" class="btn btn-top" data-bs-target="#RedeemModal" data-bs-toggle="modal">Redeem Gift Card</button>
                        </div>
                    </div>

                </div>

                <div class="border-1 mb-3 mt-3">
                    <div class="giftinfo">
                        <div style="color: #48DB8F;">Credit</div>
                        <div>+100 KD</div>
                    </div>
                    <div class="giftinfo">
                        <div>Transaction Id</div>
                        <div>45625</div>
                    </div>
                    <div class="giftinfo">
                        <div>Credited On</div>
                        <div>22/02/2025, 10:00 AM</div>
                    </div>
                </div>
                <div class="border-1 mb-3">
                    <div class="giftinfo">
                        <div style="color:#E63946;">Debit</div>
                        <div>+100 KD</div>
                    </div>
                    <div class="giftinfo">
                        <div>Transaction Id</div>
                        <div>45625</div>
                    </div>
                    <div class="giftinfo">
                        <div>Order Id</div>
                        <div>45625435345</div>
                    </div>
                    <div class="giftinfo">
                        <div>Credited On</div>
                        <div>22/02/2025, 10:00 AM</div>
                    </div>
                </div>
                <div class="border-1">
                    <div class="giftinfo">
                        <div>Redeem Gift Card</div>
                        <div>+100 KD</div>
                    </div>
                    <div class="giftinfo">
                        <div>Gift Card No.</div>
                        <div>45625</div>
                    </div>
                    <div class="giftinfo">
                        <div>Redeemed On</div>
                        <div>22/02/2025, 10:00 AM</div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>




<!-- Success Modal -->
<div class="modal fade" id="RedeemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Gift Card </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>Enter Gift Card Deatils </h5>
                <div class="form-group w-100 py-2">
                    <label>16 Digit Gift Card Number </label>
                    <input type="text" class="form-control pline-10" placeholder="16 Digit Gift Card Number ">
                </div>
                <div class="form-group w-100 py-2">
                    <label>Enter PIN </label>
                    <input type="text" class="form-control pline-10" placeholder="Enter PIN">
                </div>

                <div class="cmn-btn mt-4">
                    <button type="submit" class="btn paybtn-common w-100">Redeem </button>
                </div>

            </div>
        </div>
    </div>
</div>



<div id="loader" style="display:none;">
    <div class="loader"></div>
</div>



@endsection