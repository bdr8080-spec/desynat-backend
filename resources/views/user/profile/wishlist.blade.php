@extends('user.layout.app')

@section('content')

<div class="product_reels customContainer">
        <ul class="nav nav-tabs customNavTabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="product-tab" data-bs-toggle="tab" data-bs-target="#product-tab-pane" type="button" role="tab" aria-controls="product-tab-pane" aria-selected="true">Product</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="reels-tab" data-bs-toggle="tab" data-bs-target="#reels-tab-pane" type="button" role="tab" aria-controls="reels-tab-pane" aria-selected="false">Reels</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="product-tab-pane" role="tabpanel" aria-labelledby="product-tab" tabindex="0">
                <div class="categoryDetail customContainer">
                    <div class="row">
                        
                        <div class="col-lg-12">
                            <div class="categoryDetail_content">
                                <div class="row">
                                    @forelse ($wishListProduct as $item)
                                    <div class="col-lg-3 col-md-3 col-12 my-3" id="hideWisListProduct{{$item->id}}">
                                        <div class="product-card">
                                            <div class="product-img">
                                                <img src="{{ $item->product_variants->first()->variant_image[0] ?? '' }}" width="120">
                                                <button class="wishlist-btn" onclick="addWishListFunctionproduct({{$item->id}})"><i class="fa-solid fa-heart"></i></button>
                                            </div>
                                            <div class="product-content">
                                                <h5>{{$item->product_name_en}} ({{$item->user_name}})</h5>
                                                <div class="rating">
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star-half-stroke"></i>
                                                    <span>(123K)</span>
                                                </div>
                                                <div class="price">
                                                    <strong>{{ $item->product_variants[0]->actual_price }}
                                                                KD</strong>
                                                            <span
                                                                class="old-price">{{ $item->product_variants[0]->final_price }}
                                                                KD</span>
                                                            <span class="discount">
                                                                {{ $item->product_variants[0]->discount_value }}
                                                                {{ $item->product_variants[0]->discount_type == '1' ? '%' : 'Off' }}
                                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                        <h3>No WishList Found</h3>
                                    @endforelse
                                  
                                    {{-- <div class="col-lg-3 col-md-3 col-12 my-3">
                                        <div class="product-card">
                                            <div class="product-img">
                                                <img src="{{asset('user')}}/assets/images/product.svg" alt="Product">
                                                <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                                            </div>
                                            <div class="product-content">
                                                <h5>3pcs Set (by Abaya)</h5>
                                                <div class="rating">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star-half-stroke"></i>
                                                <span>(123K)</span>
                                                </div>
                                                <div class="price">
                                                <strong>KD 239</strong>
                                                <span class="old-price">KD 299</span>
                                                <span class="discount">20% off</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-12 my-3">
                                        <div class="product-card">
                                            <div class="product-img">
                                                <img src="{{asset('user')}}/assets/images/product.svg" alt="Product">
                                                <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                                            </div>
                                            <div class="product-content">
                                                <h5>3pcs Set (by Abaya)</h5>
                                                <div class="rating">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star-half-stroke"></i>
                                                <span>(123K)</span>
                                                </div>
                                                <div class="price">
                                                <strong>KD 239</strong>
                                                <span class="old-price">KD 299</span>
                                                <span class="discount">20% off</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-12 my-3">
                                        <div class="product-card">
                                            <div class="product-img">
                                                <img src="{{asset('user')}}/assets/images/product.svg" alt="Product">
                                                <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                                            </div>
                                            <div class="product-content">
                                                <h5>3pcs Set (by Abaya)</h5>
                                                <div class="rating">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star-half-stroke"></i>
                                                <span>(123K)</span>
                                                </div>
                                                <div class="price">
                                                <strong>KD 239</strong>
                                                <span class="old-price">KD 299</span>
                                                <span class="discount">20% off</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-12 my-3">
                                        <div class="product-card">
                                            <div class="product-img">
                                                <img src="{{asset('user')}}/assets/images/product.svg" alt="Product">
                                                <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                                            </div>
                                            <div class="product-content">
                                                <h5>3pcs Set (by Abaya)</h5>
                                                <div class="rating">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star-half-stroke"></i>
                                                <span>(123K)</span>
                                                </div>
                                                <div class="price">
                                                <strong>KD 239</strong>
                                                <span class="old-price">KD 299</span>
                                                <span class="discount">20% off</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-12 my-3">
                                        <div class="product-card">
                                            <div class="product-img">
                                                <img src="{{asset('user')}}/assets/images/product.svg" alt="Product">
                                                <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                                            </div>
                                            <div class="product-content">
                                                <h5>3pcs Set (by Abaya)</h5>
                                                <div class="rating">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star-half-stroke"></i>
                                                <span>(123K)</span>
                                                </div>
                                                <div class="price">
                                                <strong>KD 239</strong>
                                                <span class="old-price">KD 299</span>
                                                <span class="discount">20% off</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-12 my-3">
                                        <div class="product-card">
                                            <div class="product-img">
                                                <img src="{{asset('user')}}/assets/images/product.svg" alt="Product">
                                                <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                                            </div>
                                            <div class="product-content">
                                                <h5>3pcs Set (by Abaya)</h5>
                                                <div class="rating">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star-half-stroke"></i>
                                                <span>(123K)</span>
                                                </div>
                                                <div class="price">
                                                <strong>KD 239</strong>
                                                <span class="old-price">KD 299</span>
                                                <span class="discount">20% off</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-12 my-3">
                                        <div class="product-card">
                                            <div class="product-img">
                                                <img src="{{asset('user')}}/assets/images/product.svg" alt="Product">
                                                <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                                            </div>
                                            <div class="product-content">
                                                <h5>3pcs Set (by Abaya)</h5>
                                                <div class="rating">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star-half-stroke"></i>
                                                <span>(123K)</span>
                                                </div>
                                                <div class="price">
                                                <strong>KD 239</strong>
                                                <span class="old-price">KD 299</span>
                                                <span class="discount">20% off</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-12 my-3">
                                        <div class="product-card">
                                            <div class="product-img">
                                                <img src="{{asset('user')}}/assets/images/product.svg" alt="Product">
                                                <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                                            </div>
                                            <div class="product-content">
                                                <h5>3pcs Set (by Abaya)</h5>
                                                <div class="rating">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star-half-stroke"></i>
                                                <span>(123K)</span>
                                                </div>
                                                <div class="price">
                                                <strong>KD 239</strong>
                                                <span class="old-price">KD 299</span>
                                                <span class="discount">20% off</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="reels-tab-pane" role="tabpanel" aria-labelledby="reels-tab" tabindex="0">
                <div class="categoryDetail_content reels_content">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-12 my-3">
                            <div class="product-card">
                                <div class="product-img">
                                    <img src="{{asset('user')}}/assets/images/product.svg" alt="Product">
                                    <button class="wishlist-btn"><i class="fa-solid fa-heart"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12 my-3">
                            <div class="product-card">
                                <div class="product-img">
                                    <img src="{{asset('user')}}/assets/images/product.svg" alt="Product">
                                    <button class="wishlist-btn"><i class="fa-solid fa-heart"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12 my-3">
                            <div class="product-card">
                                <div class="product-img">
                                    <img src="{{asset('user')}}/assets/images/product.svg" alt="Product">
                                    <button class="wishlist-btn"><i class="fa-solid fa-heart"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12 my-3">
                            <div class="product-card">
                                <div class="product-img">
                                    <img src="{{asset('user')}}/assets/images/product.svg" alt="Product">
                                    <button class="wishlist-btn"><i class="fa-solid fa-heart"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12 my-3">
                            <div class="product-card">
                                <div class="product-img">
                                    <img src="{{asset('user')}}/assets/images/product.svg" alt="Product">
                                    <button class="wishlist-btn"><i class="fa-solid fa-heart"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12 my-3">
                            <div class="product-card">
                                <div class="product-img">
                                    <img src="{{asset('user')}}/assets/images/product.svg" alt="Product">
                                    <button class="wishlist-btn"><i class="fa-solid fa-heart"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12 my-3">
                            <div class="product-card">
                                <div class="product-img">
                                    <img src="{{asset('user')}}/assets/images/product.svg" alt="Product">
                                    <button class="wishlist-btn"><i class="fa-solid fa-heart"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12 my-3">
                            <div class="product-card">
                                <div class="product-img">
                                    <img src="{{asset('user')}}/assets/images/product.svg" alt="Product">
                                    <button class="wishlist-btn"><i class="fa-solid fa-heart"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection