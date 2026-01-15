@extends('user.layout.app')

@section('content')
    <div class="customContainer">
        <div class="owl-carousel owl-theme customOwlcarousel storeBanner">
            <div class="item">
                <div class="Bannerstores">
                     <img src="{{ asset('user/assets/images/active-banner.png') }}" alt="banner" class="img-fluid" />
                </div>
            </div>
            <div class="item">
                <div class="Bannerstores">
                     <img src="{{ asset('user/assets/images/active-banner.png') }}" alt="banner" class="img-fluid" />
                </div>
            </div>
        </div>
    </div>

    <section class="customContainer categorie_contenar" id="subCategorySection">
        <h3 class="mid-headng">Categories</h3>
        <div class="row">
            @forelse ($subCategory as $item)
                <div class="col-lg-4 col-md-4 col-6 my-lg-3 my-2 text-center">
                    <a class="category_detail" href="{{ route('user.category_wise_store', $item->category_id) }}">
                        <div class="categorie_cotent">
                            <div class="categorie_cotent-img">
                                <img src="{{ $item->image }}" class="img-fluid" />
                            </div>
                            <h3 class="mt-3">{{ $item->name_english }}</h3>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-lg-4 col-md-4 col-6 my-3 text-center categorie_cotent">
                    {{-- <img src="{{asset('user/assets/images/categorie1.png')}}" class="img-fluid" /> --}}
                    <h3>No Category Found</h3>
                </div>
            @endforelse
        </div>
    </section>

    <div class="customContainer suggestStore">
        <h3 class="mid-headng mb-3">Suggested Stores</h3>
        <div class="suggestStore_contenar">
            <div class="owl-carousel storeCarousel">
                @foreach($stores as $store)
                    <div class="item">
                        <div class="suggestStore_content">
                            <div class="suggestedStore_img">
                                <img src="{{ $store->store_image }}" class="img-fluid circle-image" alt="{{ $store->store_name }}" />
                            </div>
                            <h5>{{ $store->store_name }}</h5>
                        </div>
                    </div>
                @endforeach

                <!-- <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div> -->
            </div>

        </div>
        <!-- <div class="suggestStore_contenar">
            <div class="owl-carousel storeCarousel">
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="suggestStore_content">
                        <div class="suggestedStore_img">
                            <img src="{{ asset('user/assets/images/store1.jpg') }}" class="img-fluid" />
                        </div>
                        <h5>Atif Aslam</h5>
                    </div>
                </div>
            </div>

        </div> -->
    </div>

    <section class="bestSelling customContainer">
        <h3 class="mid-headng mb-3">Best Selling</h3>
        <div class="owl-carousel bestSellingCarousel">
            <div class="item">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('user/assets/images/product.svg') }}" alt="Product">
                        <button class="share-btn"><img src="{{ asset('user/assets/images/share_icon.svg') }}" /></button>
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
            <div class="item">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('user/assets/images/product.svg') }}" alt="Product">
                        <button class="share-btn"><img src="{{ asset('user/assets/images/share_icon.svg') }}" /></button>
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
            <div class="item">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('user/assets/images/product.svg') }}" alt="Product">
                        <button class="share-btn"><img src="{{ asset('user/assets/images/share_icon.svg') }}" /></button>
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
            <div class="item">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('user/assets/images/product.svg') }}" alt="Product">
                        <button class="share-btn"><img src="{{ asset('user/assets/images/share_icon.svg') }}" /></button>
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
            <div class="item">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('user/assets/images/product.svg') }}" alt="Product">
                        <button class="share-btn"><img src="{{ asset('user/assets/images/share_icon.svg') }}" /></button>
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
            <div class="item">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('user/assets/images/product.svg') }}" alt="Product">
                        <button class="share-btn"><img src="{{ asset('user/assets/images/share_icon.svg') }}" /></button>
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
        </div>
    </section>

    <div class="customContainer">
        <h3 class="mid-headng mb-3">Browse some Premium stores</h3>
        <div class="premiumImg">
            <img src="{{ asset('user/assets/images/premium.svg') }}" class="img-fluid" />
        </div>
    </div>

    <section class="bestSelling customContainer mt-3">
        <h3 class="mid-headng mb-3">Top Rated</h3>
        <div class="owl-carousel topRatedCarousel">
            <div class="item">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('user/assets/images/product.svg') }}" alt="Product">
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
            <div class="item">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('user/assets/images/product.svg') }}" alt="Product">
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
            <div class="item">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('user/assets/images/product.svg') }}" alt="Product">
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
            <div class="item">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('user/assets/images/product.svg') }}" alt="Product">
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
            <div class="item">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('user/assets/images/product.svg') }}" alt="Product">
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
            <div class="item">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('user/assets/images/product.svg') }}" alt="Product">
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
        </div>
    </section>

    <div class="customContainer">
        <h3 class="mid-headng mb-3">Browse some discounted deals</h3>
        <div class="premiumImg">
            <img src="{{ asset('user/assets/images/discount-deals.svg') }}" class="img-fluid" />
        </div>
    </div>

    <section class="customContainer mt-3">
        <h3 class="mid-headng mb-0">Newest Products</h3>
        <div class="row">
            <div class="col-lg-3 col-md-4 col-6 my-3">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('user/assets/images/product.svg') }}" alt="Product">
                        <button class="share-btn"><img src="{{ asset('user/assets/images/share_icon.svg') }}" /></button>
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
            <div class="col-lg-3 col-md-4 col-6 my-3">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('user/assets/images/product.svg') }}" alt="Product">
                        <button class="share-btn"><img src="{{ asset('user/assets/images/share_icon.svg') }}" /></button>
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
            <div class="col-lg-3 col-md-4 col-6 my-3">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('user/assets/images/product.svg') }}" alt="Product">
                        <button class="share-btn"><img src="{{ asset('user/assets/images/share_icon.svg') }}" /></button>
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
            <div class="col-lg-3 col-md-4 col-6 my-3">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('user/assets/images/product.svg') }}" alt="Product">
                        <button class="share-btn"><img src="{{ asset('user/assets/images/share_icon.svg') }}" /></button>
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
            <div class="col-lg-3 col-md-4 col-6 my-3">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('user/assets/images/product.svg') }}" alt="Product">
                        <button class="share-btn"><img src="{{ asset('user/assets/images/share_icon.svg') }}" /></button>
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
            <div class="col-lg-3 col-md-4 col-6 my-3">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('user/assets/images/product.svg') }}" alt="Product">
                        <button class="share-btn"><img src="{{ asset('user/assets/images/share_icon.svg') }}" /></button>
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
            <div class="col-lg-3 col-md-4 col-6 my-3">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('user/assets/images/product.svg') }}" alt="Product">
                        <button class="share-btn"><img src="{{ asset('user/assets/images/share_icon.svg') }}" /></button>
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
        </div>
    </section>

    <!-- banner Modal image -->
    @auth
    @if(isset($banners) && $banners->count() > 0)
    <div class="modal-wapper" id="showBanner">
        <div class="modal-content-2">
            <div class="banner-body">
                <button type="button" class="btn-skip">Skip</button>
                <div class="popbanner">
                    <div class="owl-carousel owl-theme bannerpop">
                        @foreach($banners as $banner)
                            <div class="item">
                                <div class="bannerScreen">
                                    <img src="{{ $banner->image }}" alt="Banner" class="img-fluid" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endauth


  <script>
document.addEventListener("DOMContentLoaded", function() {
    const skipBtn = document.querySelector('.btn-skip');
    const bannerModal = document.getElementById('showBanner');

    if(skipBtn){
        skipBtn.addEventListener('click', function() {

            // Hide modal immediately
            bannerModal.style.display = 'none';

            // Send AJAX request to update banner_view
            fetch("{{ route('user.updateBannerView') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({})
            })
            .then(res => res.json())
            .then(res => {
                if(res.status === 'success'){
                    //console.log('Banner marked as viewed');
                }
            })
            .catch(err => console.error('Error updating banner view', err));
        });
    }
});
</script>


    <script>
        function handleSubCategory(id) {
            $.ajax({
                url: "{{ route('dashboard') }}",
                method: "GET",
                data: {
                    id: id
                },
                beforeSend: function() {
                    $('#verifyBtn').prop('disabled', true);
                },
                success: function(resp) {
                    $('#subCategorySection').html(resp);
                },
                error: function(xhr) {

                },
                complete: function() {
                    $('#verifyBtn').prop('disabled', false);
                }
            });
        }
    </script>



@endsection


