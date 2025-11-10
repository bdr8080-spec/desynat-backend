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
            <div class="col-lg-4 col-md-4 col-6 my-3 text-center categorie_cotent">
                <img src="{{$item->image}}" class="img-fluid" />
                <h3>{{$item->name_english}}</h3>
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

    <section class="bestSelling customContainer">
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

    <section class="customContainer">
        <h3>Newest Products</h3>
        <div class="row">
            <div class="col-lg-3 col-md-4 col-6">
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
            <div class="col-lg-3 col-md-4 col-6">
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
            <div class="col-lg-3 col-md-4 col-6">
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
            <div class="col-lg-3 col-md-4 col-6">
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
            <div class="col-lg-3 col-md-4 col-6">
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
            <div class="col-lg-3 col-md-4 col-6">
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
            <div class="col-lg-3 col-md-4 col-6">
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
            <div class="col-lg-3 col-md-4 col-6">
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

    <footer>
        <div class="container-fluid">
            <div class="row justify-content-between">
            <div class="col-lg-3 col-md-3 col-12">
                <div class="footer_logo">
                    <img src="{{asset('user/assets/images/logo.svg')}}" class="img-fluid" />

                </div>
                <span class="d-block">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim </span>
                <button class="customBtn1">Become an Affiliate Customer</button> 
            </div>
            <div class="col-lg-5 col-md-5 col-12">
                <div class="footerNavLink ms-20percenter">
                    <div class="footerNavLink_content">
                        <h6>Customer Policy</h6>
                        <ul class="navs list-unstyled">
                            <li>
                                <a href="">About Us</a>
                            </li>
                             <li>
                                <a href="">Terms & Condition</a>
                            </li>
                             <li>
                                <a href="">Return Policy</a>
                            </li>
                             <li>
                                <a href="">Exchange Policy</a>
                            </li>
                             <li>
                                <a href="">FAQs</a>
                            </li>
                        </ul>
                    </div>
                    <div class="footerNavLink_content">
                        <h6>Customer Policy</h6>
                        <ul class="navs list-unstyled">
                            <li>
                                <a href="">XYZgmail.com</a>
                            </li>
                             <li>
                                <a href="">+ 965 36214565</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-12">
                <div class="footerNavLink">
                    <div class="footerNavLink_content ms-lg-auto ms-md-auto">
                        <h6>Get the App</h6>
                        <div class="getTheApp gap-2 d-flex align-items-end flex-lg-column">
                            <div style="width: 40%;">
                                <img src="{{asset('user/assets/images/play-store.svg')}}" class="img-fluid" />
                            </div>
                            <div style="width: 40%;">
                                <img src="{{asset('user/assets/images/ios-app.svg')}}" class="img-fluid" />
                            </div>
                        </div>
                        <ul class="list-unstyled social_icon">
                            <li>
                                <a href=""><img src="{{asset('user/assets/images/Social icon.svg')}}" class="img-fluid" /></a>
                            </li>
                            <li>
                                <a href=""><img src="{{asset('user/assets/images/Instagram_logo_2016.svg')}}" class="img-fluid" /></a>
                            </li>
                            <li>
                                <a href=""><img src="{{asset('user/assets/images/social_facebook.svg')}}" class="img-fluid" /></a>
                            </li>
                            <li>
                                <a href=""><img src="{{asset('user/assets/images/social_x_circle 1.svg')}}" class="img-fluid" /></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </footer>



    <!-- Modal -->
    <div class="modal fade" id="changeLocation" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header  border-0">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Change Location</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div>
                <div class="form-group position-relative search">
                    <input type="text" class="form-control" placeholder="Search address" />
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <div>
                    <img src="https://staticmapmaker.com/img/google-placeholder.png" class="img-fluid" />
                </div>
                <div class="">
                    <h5>Location</h5>
                    <p>HN- 547, Street no,5 Block d new town hale, Saudi Arabia</p>
                </div>
                <button class="customBtn">Change Location</button>
            </div>

        </div>
        </div>
    </div>
    </div>
    
    <script src="{{asset('user/assets/js/jquery-3.7.1.min.js')}}" ></script>
    <!-- <script src="assets/js/all.min.js" ></script> -->
    <script src="{{asset('user/assets/js/bootstrap.bundle.min.js')}}" ></script>
    <!-- <script src="assets/js/fontawesome.min.js" ></script> -->
    <script src="{{asset('user/assets/js/owl.carousel.js')}}"></script>
    <script src="{{asset('user/assets/js/custom.js')}}"></script>

     <script>
        $('.customOwlcarousel').owlCarousel({
            loop:true,
            margin:10,
            responsiveClass:true,
            nav:false,
            dots:true,
            responsive:{
                0:{
                    items:1,
                },
                600:{
                    items:1,
                },
                1000:{
                    items:1,
                    dots:true
                }
            }
        })
    </script>

    <script>
        $('.storeCarousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            dots: true,
            // autoplay: true,
            // autoplayTimeout: 2000, 
            autoplayHoverPause: true,
            slideTransition: 'linear',
            smartSpeed: 1000, // smooth transition
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 4
                },
                1000: {
                    items: 8
                }
            },
            slideBy: 1 // slides one by one
        });

        $('.bestSellingCarousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            dots: true,
            // autoplay: true,
            // autoplayTimeout: 2000, 
            autoplayHoverPause: true,
            slideTransition: 'linear',
            smartSpeed: 1000, // smooth transition
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 4
                }
            },
            slideBy: 1 // slides one by one
        });

        $('.topRatedCarousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            dots: true,
            // autoplay: true,
            // autoplayTimeout: 2000, 
            autoplayHoverPause: true,
            slideTransition: 'linear',
            smartSpeed: 1000, // smooth transition
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 4
                }
            },
            slideBy: 1 // slides one by one
        });
    </script>
  
@endsection