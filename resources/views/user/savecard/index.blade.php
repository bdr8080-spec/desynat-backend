@extends('user.layout.app')

@section('content')


<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="{{route('dashboard')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
        <h3>{{ __('user_messages.my_saved_cards') }}</h3>
    </div>

    <div class="main-content categoryDetail">

        <!-- <div class="border-1 mb-3 mt-3">
            <div class="giftinfo">
                <div class="d-flex gap-3 align-items-center">
                    <div>
                         <img src="{{asset('user/assets/images/visa-card.png')}}" class="img-fluid" width="90px">
                    </div>
                    <div class="master-card">
                        <div class="mst-title">Master Card</div>
                        <div class="mst-title">****76576667</div>
                    </div>
                </div>
                <div class="d-flex gap-3  align-items-center">
                    <label class="custom-radio">
                        <input type="radio" name="cardvisa" id="" value="1" checked="">
                        <span class="radio-mark"></span>
                    </label>
                    <a href="#"><img src="{{asset('user/assets/images/delete.svg')}}" class="img-fluid"></a>
                </div>
            </div>
        </div> -->
        @forelse($data as $item)
            <div class="border-1 mb-3 mt-3">
                <div class="giftinfo">

                    <div class="d-flex gap-3 align-items-center">

                        <div>
                            <img src="{{ $item->card_image }}"
                                class="img-fluid"
                                width="90px">
                        </div>

                        <div class="master-card">
                            <div class="mst-title">
                                @if(app()->getLocale() == 'en')
                                {{ $item->card_type }}
                                @else
                                {{ $item->card_type_ar }}
                                @endif
                            </div>
                            <div class="mst-title">{{ $item->card_number }}</div>
                        </div>

                    </div>

                    <div class="d-flex gap-3 align-items-center">

                       <label class="custom-radio">
                            <input type="radio"
                                class="defaultCard"
                                name="cardvisa"
                                value="{{ $item->id }}"
                                {{ $item->is_future == 1 ? 'checked' : '' }}>
                            <span class="radio-mark"></span>
                        </label>

                        <a href="javascript:void(0)"
                            class="delete-card"
                            data-id="{{ $item->id }}">
                                <img src="{{ asset('user/assets/images/delete.svg') }}" class="img-fluid">
                        </a>

                    </div>

                </div>
            </div>

        @empty

            <div class="text-center text-muted mt-3 mb-3">
                {{ __('user_messages.no_cards_added') }}
            </div>

        @endforelse

        <div class="border-11 mb-3 mt-4">
            <a href="{{route('user.add_new_card')}}" class="card-color">
                <div> <i class="bi bi-plus-lg"></i> {{ __('user_messages.add_new_card') }}</div>
            </a>
        </div>



    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.defaultCard').forEach(radio => {

        radio.addEventListener('change', function () {

            let cardId = this.value;

            fetch("{{ route('user.make_card_default') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    card_id: cardId
                })
            })
            .then(res => res.json())
            .then(data => {

                if (data.status === 'success') {
                    toastr.success(data.message);

                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    toastr.error(data.message);
                }

            })
            .catch(err => {
                console.log(err);
                toastr.error('Request failed');
            });

        });

    });

});
</script>

<!-- delete card -->

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.delete-card').forEach(btn => {

        btn.addEventListener('click', function () {

            let cardId = this.dataset.id;

            // if (!confirm('Are you sure you want to delete this card?')) {
            //     return;
            // }

            fetch("{{ route('user.delete_card') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    card_id: cardId
                })
            })
            .then(res => res.json())
            .then(data => {

                if (data.status === 'success') {
                    toastr.success(data.message);

                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);

                } else {
                    toastr.error(data.message || 'Something went wrong');
                }

            })
            .catch(err => {
                console.log(err);
                toastr.error('Request failed');
            });

        });

    });

});
</script>










@endsection