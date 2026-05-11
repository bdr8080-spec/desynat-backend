@extends('user.layout.app')

@section('content')

@if(request('type') !=='cart')
<div class="address-tops">
    <div class="my-profile customContainer">
        <!-- <div class="my-profie-nav d-flex align-items-center mt-3 justify-content-between">
            <a class="text-black" href="{{route('dashboard')}}" style="text-decoration: none;"><i  class="fa-solid fa-chevron-left"></i> My Saved Address</a>
        </div> -->
        <div class="my-profie-nav d-flex align-items-center mt-3 justify-content-between">
            <a class="text-black" 
            href="{{ request()->has('chat') 
                        ? route('user.userChat', ['id' => request()->get('chat')]) 
                        : route('dashboard') }}" 
            style="text-decoration: none;">
                <i class="fa-solid fa-chevron-left"></i> {{ __('user_messages.my_saved_addresses') }}
            </a>
        </div>


        <div class="saved-address-contenar mt-3">
            @forelse ($address as $item)
            <div class="saved_address_content">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span><i class="bi bi-building"></i> {{ $item->save_address_as == 1 ? __('user_messages.home') : __('user_messages.office') }}</span>
                    </div>
                    <div>
                        <a href="{{route('user.update_address',[$item->id])}}"><img
                                src="{{asset('user/assets/images/edit.svg')}}" class="img-fluid" /></a>
                        <a href="{{route('user.delete_address',[$item->id])}}"><img
                                src="{{asset('user/assets/images/delete.svg')}}" class="img-fluid" /></a>

                        @if($item->set_as_default == '0')
                        <button class="setAsdefault custom-btn3 cursor-pointer" data-id="{{ $item->id }}">
                            {{ __('user_messages.set_as_default') }}
                        </button>
                        @endif
                    </div>
                </div>
                <h6>{{$item->name}}</h6>
                <p>{{$item->address}} {{$item->house_no}} {{$item->street_no}} {{$item->postal_code}} {{$item->city}}
                    {{$item->state}} {{$item->country}}</p>
            </div>
            @empty
            <h3 class="text-center my-5" style="font-weight:500 !important;">{{ __('user_messages.no_address_added_yet') }}</h3>
            @endforelse

            <a href="{{route('user.save_address')}}" class="custom-btn3 add_new_address mb-45">+ {{ __('user_messages.add_new_address') }}</a>
        </div>
       
    </div>
</div>
@endif

<!-------- cart address ----------->
@if(request('type') === 'cart')
<div class="address-tops">
    <div class="my-profile customContainer">
        <div class="my-profie-nav d-flex align-items-center mt-3 justify-content-between">
            <a class="text-black" href="{{ route('user.view_cart') }}" style="text-decoration: none;">
                <i class="fa-solid fa-chevron-left"></i> {{ __('user_messages.select_address') }}
            </a>
        </div>

        <div class="saved-address-contenar mt-3">
            @forelse ($address as $item)
            <div class="saved_address_content">
                <label class="custom-radio mb-3 align-items-baseline">
                    <input type="radio" 
                           name="selected_address" 
                           value="{{ $item->id }}" 
                           class="address-radio" 
                           data-id="{{ $item->id }}" 
                           @if($item->set_as_default == '1') checked @endif> <!-- Check if this address is set as default -->
                    <span class="radio-mark"></span>
                    <div class="label-content w-100">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5><i class="bi bi-building"></i> {{ $item->save_address_as == 1 ? __('user_messages.home') : __('user_messages.office') }}</h5>
                            </div>
                            <div>
                                <a href="{{ route('user.update_address', [$item->id]) }}"><img
                                        src="{{ asset('user/assets/images/edit.svg') }}" class="img-fluid" /></a>
                                <a href="{{ route('user.delete_address', [$item->id]) }}"><img
                                        src="{{ asset('user/assets/images/delete.svg') }}" class="img-fluid" /></a>
                            </div>
                        </div>
                        <h6>{{ $item->name }}</h6>
                        <p>{{ $item->address }} {{ $item->house_no }} {{ $item->street_no }} {{ $item->postal_code }} 
                            {{ $item->city }} {{ $item->state }} {{ $item->country }}</p>
                    </div>
                </label>
            </div>
            @empty
            <h3 class="text-center my-5" style="font-weight:500 !important;">{{ __('user_messages.no_address_added_yet') }}</h3>
            @endforelse

            <a href="{{ route('user.save_address') }}" class="custom-btn3 add_new_address mb-45 py-3">+ {{ __('user_messages.add_new_address') }}</a>
        </div>
        <div>
            <a href="javascript:void(0);" class="btn paybtn-common w-100" id="proceedBtn">{{ __('user_messages.proceed') }}</a>
        </div>
    </div>
</div>
@endif




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).on('click', '.setAsdefault', function() {
    let id = $(this).data('id');

    $.ajax({
        url: "{{ route('user.address_set_default') }}?address_id=" + id,
        type: "GET",
        success: function(resp) {
            toastr.success(resp.message);
            setTimeout(() => {
                location.reload();
            }, 1000);

        }
    });

});
</script>

<script>
$(document).ready(function() {
    $('#proceedBtn').on('click', function() {
        // Get the selected address ID
        let selectedAddressId = $("input[name='selected_address']:checked").data('id');
        
        if (!selectedAddressId) {
            toastr.error('Please select an address.');
            return;
        }

        // Set the selected address as default
        $.ajax({
            url: "{{ route('user.address_set_default') }}?address_id=" + selectedAddressId,
            type: "GET",
            success: function(response) {
                // Show success message
                toastr.success(response.message);

                setTimeout(function() {
                    window.location.href = "{{ route('user.view_cart') }}"; 
                }, 1000);
            },
            error: function() {
                toastr.error("Something went wrong. Please try again!");
            }
        });
    });
});
</script>