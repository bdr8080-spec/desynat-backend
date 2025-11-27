@extends('user.layout.app')

@section('content')

<div class="my-profile customContainer">
    <div class="my-profie-nav d-flex align-items-center mt-3 justify-content-between">
        <a class="text-black" href="{{route('dashboard')}}"><i class="fa-solid fa-chevron-left"></i>My Saved Address</a>
    </div>

    <div class="saved-address-contenar">
        @forelse ($address as $item)
        <div class="saved_address_content">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span><i class="bi bi-building"></i> {{$item->save_address_as == 1 ? 'Home' : 'Office'}}</span>
                </div>
                <div>
                    <a href="{{route('user.update_address',[$item->id])}}"><img src="{{asset('user/assets/images/edit.svg')}}" class="img-fluid"/></a>
                    <a href="{{route('user.delete_address',[$item->id])}}"><img src="{{asset('user/assets/images/delete.svg')}}" class="img-fluid" /></a>
                    <span class="setAsdefault custom-btn3">Set as Default</span>
                </div>
            </div>
            <h6>{{$item->name}}</h6>
            <p>{{$item->address}}</p>
        </div>
        @empty
            <h3 class="text-center my-5" style="font-weight:500 !important;">No address added</h3>
        @endforelse
       
        <a href="{{route('user.save_address')}}" class="custom-btn3 add_new_address mb-45" >+ Add New Address</a>
    </div>
</div>


@endsection