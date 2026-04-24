@extends('user.layout.app')

@section('content')


<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="{{route('dashboard')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
        <h3>My Saved Cards</h3>
    </div>

    <div class="main-content categoryDetail">
        <div class="border-1 mb-3 mt-3">
            

        </div>
    </div>
</div>










@endsection