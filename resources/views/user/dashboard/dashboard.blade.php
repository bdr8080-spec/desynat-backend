@extends('user.layout.app')

@section('content')


    <div class="customContainer">
        <div class="owl-carousel owl-theme customOwlcarousel">
            <div class="item">
                <img src="{{asset('user/assets/images/banner.svg')}}" class="img-fluid" />
            </div>
            <div class="item">
                <img src="{{asset('user/assets/images/banner.svg')}}" class="img-fluid" />
            </div>
            <div class="item">
                <img src="{{asset('user/assets/images/banner.svg')}}" class="img-fluid" />
            </div>
            <div class="item">
                <img src="{{asset('user/assets/images/banner.svg')}}" class="img-fluid" />
            </div>
        </div>
    </div>

    <section class="customContainer categorie_contenar">
        <h3>Categories</h3>
        <div class="row">
          @forelse ($subCategory as $item)
            <div class="col-lg-4 col-md-4 col-6 my-lg-3 my-2 text-center">
                <div class="categorie_cotent">
                    <div class="categorie_cotent-img">
                        <img src="{{$item->image}}" class="img-fluid" />
                    </div>
                    <h3>{{$item->name_english}}</h3>
                </div>
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
        <h3>Suggested Stores</h3>
        <div class="suggestStore_contenar">
            <div class="owl-carousel storeCarousel">
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            </div>
            
        </div>
        <div class="suggestStore_contenar">
            <div class="owl-carousel storeCarousel">
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            <div class="item">
                <div class="suggestStore_content">
                    <div class="suggestedStore_img">
                        <img src="{{asset('user/assets/images/store1.jpg')}}" class="img-fluid" />
                    </div>
                    <h5>Atif Aslam</h5>
                </div>
            </div>
            </div>
            
        </div>
    </div>

    <section class="bestSelling customContainer">
        <h3>Best Selling</h3>
        <div class="owl-carousel bestSellingCarousel">
            <div class="item">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
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
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
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
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
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
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
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
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
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
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
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
        <h3>Browse some Premium stores</h3>
        <div class="premiumImg">
            <img src="{{asset('user/assets/images/premium.svg')}}" class="img-fluid" />
        </div>
    </div>

    <section class="bestSelling customContainer mt-3">
        <h3>Top Rated</h3>
        <div class="owl-carousel topRatedCarousel">
            <div class="item">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
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
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
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
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
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
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
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
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
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
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
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
        <h3>Browse some discounted deals</h3>
        <div class="premiumImg">
            <img src="{{asset('user/assets/images/discount-deals.svg')}}" class="img-fluid" />
        </div>
    </div>

    <section class="customContainer mt-3">
        <h3>Newest Products</h3>
        <div class="row">
            <div class="col-lg-3 col-md-4 col-6 my-3">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
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
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
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
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
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
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
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
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
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
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
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
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
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
                        <img src="{{asset('user/assets/images/product.svg')}}" alt="Product">
                        <button class="share-btn"><i class="fa-solid fa-share"></i></button>
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

    

    
    
  
@endsection