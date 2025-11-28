@extends('user.layout.app')

@section('content')

<div class="my-profile customContainer">
    <div class="my-profie-nav d-flex align-items-center mt-3 justify-content-between">
        <a class="text-black" href="{{route('dashboard')}}" style="text-decoration: none;"><i class="fa-solid fa-chevron-left"></i>My Saved Address</a>
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

                  @if($item->set_as_default == '0')
                        <button class="setAsdefault custom-btn3 cursor-pointer" data-id="{{ $item->id }}">
                            Set as Default
                        </button>
                    @endif


                
                </div>
            </div>
            <h6>{{$item->name}}</h6>
            <p>{{$item->address}} {{$item->house_no}} {{$item->street_no}} {{$item->postal_code}} {{$item->city}} {{$item->state}} {{$item->country}}</p>
        </div>
        @empty
            <h3 class="text-center my-5" style="font-weight:500 !important;">No address added</h3>
        @endforelse
       
        <a href="{{route('user.save_address')}}" class="custom-btn3 add_new_address mb-45" >+ Add New Address</a>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

        $(document).on('click', '.setAsdefault', function () {
            let id = $(this).data('id');

                $.ajax({
                    url: "{{ route('user.address_set_default') }}?address_id=" + id,
                    type: "GET",
                    success: function (resp) {
                            toastr.success(resp.message);
                        setTimeout(() => {
                           location.reload();
                        }, 1000);
                      
                    }
                });

        });


</script>
@endsection