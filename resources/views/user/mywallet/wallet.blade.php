@extends('user.layout.app')

@section('content')


<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="{{route('dashboard')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
        <h3>My Wallet</h3>
    </div>

    <div class="main-content categoryDetail">
        <div class="row">
           
        </div>
    </div>

</div>






<div id="loader" style="display:none;">
    <div class="loader"></div>
</div>



@endsection