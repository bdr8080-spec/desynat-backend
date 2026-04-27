@extends('user.layout.app')

@section('content')


<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="{{route('dashboard')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
        <h3>My Saved Cards</h3>
    </div>

    <div class="main-content categoryDetail">
        <div class="border-1 mb-3 mt-3">
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
        </div>

        <div class="border-1 mb-3 mt-3">
            <div class="giftinfo">
                <div class="d-flex gap-3 align-items-center">
                    <div>
                         <img src="{{asset('user/assets/images/master-card.png')}}" class="img-fluid" width="90px">
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
        </div>

        <div class="border-11 mb-3 mt-4">
            <a href="{{route('user.add_new_card')}}" class="card-color">
                <div> <i class="bi bi-plus-lg"></i> Add New Card</div>
            </a>
        </div>



    </div>
</div>










@endsection