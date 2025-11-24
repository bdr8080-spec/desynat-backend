@extends('user.layout.app')

@section('content')
    <div class="customContainer">
        <div class="owl-carousel owl-theme customcatOwlcarousel">
            <div class="item">
                <img src="{{ asset('user/') }}/assets/images/category-img.svg" class="img-fluid" />
            </div>
            <div class="item">
                <img src="{{ asset('user/') }}/assets/images/category-img.svg" class="img-fluid" />
            </div>
            <div class="item">
                <img src="{{ asset('user/') }}/assets/images/category-img.svg" class="img-fluid" />
            </div>
            <div class="item">
                <img src="{{ asset('user/') }}/assets/images/category-img.svg" class="img-fluid" />
            </div>
        </div>
    </div>

    <div class="categoryDetail customContainer">
        <div class="row">
            <div class="col-lg-4">
                <div class="category_filter">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3>Filter</h3>
                        <span>Clear</span>
                    </div>
                    <form action="{{ url('user/category-wise-store/' . request()->id) }}" method="GET">
                        <div class="form-group mt-4">
                            <h5>Ratings</h5>

                            <div class="form-check my-4">
                                <input class="form-check-input mb-1" type="checkbox" 
                                    value="2" id="rating2" name="rating[]"  {{ is_array(request()->rating) && in_array('2', request()->rating) ? 'checked' : '' }}>
                                <label class="form-check-label" for="rating2">
                                    Upto 2 Star
                                </label>
                            </div>

                            <div class="form-check my-4">
                                <input class="form-check-input" type="checkbox" 
                                    value="3" id="rating3" name="rating[]"  {{ is_array(request()->rating) && in_array('3', request()->rating) ? 'checked' : '' }}>
                                <label class="form-check-label" for="rating3">
                                    Upto 3 Star
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <h5>Availability</h5>

                            <div class="form-check my-4">
                                <input class="form-check-input" type="radio" 
                                    name="availability" value="1" id="availability_open" {{request()->availability == '1' ? 'checked' : ''}}>
                                <label class="form-check-label" for="availability_open">
                                    Open
                                </label>
                            </div>

                            <div class="form-check my-4">
                                <input class="form-check-input" type="radio" 
                                    name="availability" value="0" id="availability_busy" {{request()->availability == '0' ? 'checked' : ''}}>
                                <label class="form-check-label" for="availability_busy">
                                    Busy
                                </label>
                            </div>
                        </div>

                        <div class="form-group delivery">
                            <h5>Sort & Preference</h5>

                            <div class="form-check my-4">
                                <input class="form-check-input" name="sort[]" type="checkbox" 
                                    value="0" id="delivery_short" {{ is_array(request()->sort) && in_array('0', request()->sort) ? 'checked' : '' }}>
                                <label class="form-check-label" for="delivery_short">
                                    Shortest Delivery Time
                                </label>
                            </div>

                            <div class="form-check my-4">
                                <input class="form-check-input" name="sort[]" type="checkbox" 
                                    value="1" id="high_sale" {{ is_array(request()->sort) && in_array('1', request()->sort) ? 'checked' : '' }}>
                                <label class="form-check-label" for="high_sale">
                                    Highest Sale
                                </label>
                            </div>
                        </div>

                        <button class="customBtn customBtn5 mt-5">Apply</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="categoryDetail_content">
                    <form action="{{ url('user/category-wise-store/' . request()->id) }}" method="GET">
                        <div class="seArch">
                            <div class="form-group position-relative search">
                                <input type="text" class="form-control" placeholder="Search" name="search" value="{{request()->search}}" />
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                            <button class="customBtn customBtn5">Search</button>
                        </div>
                    </form>

                    <div class="row">

                        @forelse ($store_data as $item)
                            <div class="col-lg-4 col-md-4 col-6 my-3">
                                <a href="{{route('user.store_details',[$item->id])}}">
                                    <div class="category-store">
                                        <img src="{{ $item->store_image }}" class="img-fluid" />
                                        <div class="category-store-content">
                                            <div class="user-infoCat_detail d-flex align-items-center">
                                                <div class="user">
                                                    <img src="{{ $item->seller_information->profile_pic }}"
                                                        class="img-fluid" />
                                                </div>
                                                <p>{{ $item->seller_information->first_name }}
                                                    {{ $item->seller_information->last_name }}</p>
                                            </div>
                                            <div class="rate-content d-flex align-items-center">
                                                <div class="rate">
                                                    <span><i class="bi bi-star-fill"></i></span>
                                                    <span><i class="bi bi-star-fill"></i></span>
                                                    <span><i class="bi bi-star-fill"></i></span>
                                                    <span><i class="bi bi-star-fill"></i></span>
                                                    <span><i class="bi bi-star-fill"></i></span>
                                                </div>
                                                <p>(1K)</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        @empty

                            <h2>
                                <center> No Store Found </center>
                            </h2>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
