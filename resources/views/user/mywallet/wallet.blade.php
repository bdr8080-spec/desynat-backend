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
                                <h5>{{ rtrim(rtrim(number_format($walletData['wallet_balance'], 2, '.', ''), '0'), '.') }} KD</h5>
                            </div>
                        </div>
                        <div class="total-balance-2">
                            <a href="{{route('user.addWalletMoney')}}" class="btn btn-top">Top-up Wallet</a>
                            <button type="button" class="btn btn-top" data-bs-target="#RedeemModal" data-bs-toggle="modal">Redeem Gift Card</button>
                        </div>
                    </div>

                </div>

                @if($walletData['history']->count())
                    @foreach($walletData['history'] as $history)
                        <div class="border-1 mb-3 mt-3">
                            <div class="giftinfo">
                                @php
                                    $isCredit = in_array($history->type, [1, 3]);
                                @endphp

                                <div style="color: {{ $isCredit ? '#48DB8F' : '#FF6B6B' }}">
                                    @if($history->type == 1)
                                        Credit
                                    @elseif($history->type == 3)
                                        Reedem Gift Card
                                    @else
                                        Debit
                                    @endif
                                </div>

                                <div>
                                    {{ $isCredit ? '+' : '-' }}
                                    {{ rtrim(rtrim(number_format($history->amount, 2), '0'), '.') }} KD
                                </div>
                            </div>

                            <div class="giftinfo">
                                <div>Transaction Id</div>
                                <div>{{ $history->transaction_id }}</div>
                            </div>

                            <div class="giftinfo">
                                <div>Credited On</div>
                                <div>
                                    {{ \Carbon\Carbon::parse($history->created_at)->timezone('Asia/Kolkata')->format('d/m/Y, h:i A') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center text-muted mt-3">
                        No wallet history found
                    </div>
                @endif

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