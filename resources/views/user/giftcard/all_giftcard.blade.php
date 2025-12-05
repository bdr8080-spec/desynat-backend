@extends('user.layout.app')

@section('content')

<div class="customContainer">
    <div class="giftsearch py-5 d-flex w-100 gap-4">
        <div class="form-group w-100 d-flex">
            <div class="searchicon"><i class="bi bi-search"></i></div>
            <input type="search" class="form-control giftcontrol" placeholder="Search">
            <button class="btn btnsearch">Search</button>
        </div>
        <a href="{{route('user.add-gift-cards')}}" class="add-icon">
            <img src="{{asset('user/assets/images/add-icon.svg')}}" alt="gift image" class="img-fluid">
        </a>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-6">
            <a href="{{route('user.view-gift-cards')}}" class="gift_hover">
                <div class="giftcard">
                    <figure>
                        <img src="{{asset('user/assets/images/gift/gift1.svg')}}" alt="gift image" class="img-fluid">
                    </figure>
                    <div class="gift-card-body p-3">
                        <div class="gift-title">
                            <h5>Atif Aslam</h5>
                            <div class="giftdate">06 Aug 25, 6:15 pm</div>
                        </div>
                        <div class="gift-title">
                            <h5>239 KD</h5>
                            <div class="giftdate">Birthday Card</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-4 col-md-6">
            <a href="{{route('user.view-gift-cards')}}" class="gift_hover">
                <div class="giftcard">
                    <figure>
                        <img src="{{asset('user/assets/images/gift/gift2.svg')}}" alt="gift image" class="img-fluid">
                    </figure>
                    <div class="gift-card-body p-3">
                        <div class="gift-title">
                            <h5>Atif Aslam</h5>
                            <div class="giftdate">06 Aug 25, 6:15 pm</div>
                        </div>
                        <div class="gift-title">
                            <h5>239 KD</h5>
                            <div class="giftdate">Birthday Card</div>
                        </div>
                    </div>
                </div>
            </a>    
        </div>

        <div class="col-lg-4 col-md-6">
            <a href="{{route('user.view-gift-cards')}}" class="gift_hover">
                <div class="giftcard">
                    <figure>
                        <img src="{{asset('user/assets/images/gift/gift3.svg')}}" alt="gift image" class="img-fluid">
                    </figure>
                    <div class="gift-card-body p-3">
                        <div class="gift-title">
                            <h5>Atif Aslam</h5>
                            <div class="giftdate">06 Aug 25, 6:15 pm</div>
                        </div>
                        <div class="gift-title">
                            <h5>239 KD</h5>
                            <div class="giftdate">Birthday Card</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-6">
            <a href="{{route('user.view-gift-cards')}}" class="gift_hover">
                <div class="giftcard">
                    <figure>
                        <img src="{{asset('user/assets/images/gift/gift3.svg')}}" alt="gift image" class="img-fluid">
                    </figure>
                    <div class="gift-card-body p-3">
                        <div class="gift-title">
                            <h5>Atif Aslam</h5>
                            <div class="giftdate">06 Aug 25, 6:15 pm</div>
                        </div>
                        <div class="gift-title">
                            <h5>239 KD</h5>
                            <div class="giftdate">Birthday Card</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-6">
            <a href="{{route('user.view-gift-cards')}}" class="gift_hover">
                <div class="giftcard">
                    <figure>
                        <img src="{{asset('user/assets/images/gift/gift3.svg')}}" alt="gift image" class="img-fluid">
                    </figure>
                    <div class="gift-card-body p-3">
                        <div class="gift-title">
                            <h5>Atif Aslam</h5>
                            <div class="giftdate">06 Aug 25, 6:15 pm</div>
                        </div>
                        <div class="gift-title">
                            <h5>239 KD</h5>
                            <div class="giftdate">Birthday Card</div>
                        </div>
                    </div>
                </div>
            </a>    
        </div>
        <div class="col-lg-4 col-md-6">
            <a href="{{route('user.view-gift-cards')}}" class="gift_hover">
                <div class="giftcard">
                    <figure>
                        <img src="{{asset('user/assets/images/gift/gift3.svg')}}" alt="gift image" class="img-fluid">
                    </figure>
                    <div class="gift-card-body p-3">
                        <div class="gift-title">
                            <h5>Atif Aslam</h5>
                            <div class="giftdate">06 Aug 25, 6:15 pm</div>
                        </div>
                        <div class="gift-title">
                            <h5>239 KD</h5>
                            <div class="giftdate">Birthday Card</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>

</div>





@endsection