@extends('user.layout.app')

@section('content')


<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="{{route('dashboard')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
        <h3>Add Money </h3>
    </div>

    <div class="main-content categoryDetail">
        <div class="cart-panel position-relative">
            <div class="gift-pnl mt-0">
                <h6>Wallet Transactions</h6>

                
                
               
               

            </div>

        </div>

    </div>

</div>














<div id="loader" style="display:none;">
    <div class="loader"></div>
</div>



@endsection