@extends('user.layout.app')

@section('content')
    
    <div class="categoryDetail customContainer">

        <div class="tabs-panel py-4">
            <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active w-100" id="pills-allproduct-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-orders" type="button" role="tab" aria-controls="pills-orders"
                        aria-selected="true">Orders</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link w-100" id="pills-ordercustom-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-ordercustom" type="button" role="tab" aria-controls="pills-ordercustom"
                        aria-selected="false">Custom Orders</button>
                </li>
            </ul>
        </div>

        <div class="tab-body-wapper">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-orders" role="tabpanel"
                    aria-labelledby="pills-orders-tab" tabindex="0">

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="category_filter">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h3>Filter</h3>
                                    <a href="{{ url('user/category-wise-store/' . request()->id)}}">Clear</a>
                                </div>

                                <form action="{{ url('user/category-wise-store/' . request()->id) }}" method="GET">
                                    <div class="form-group mt-4">
                                        <h5>Ratings</h5>

                                        
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

                                <div class="cart-panel position-relative">
                                    <div class="cart-card bottom-pd">
                                        <div class="card-left mb-2 d-flex">
                                            <div>
                                                <div class="cart-products order-images me-3">
                                                    <img src="{{asset('user/assets/images/categorie1.png')}}" alt="Product"
                                                        class="img-fluid">
                                                </div>
                                            </div>

                                            <div class="w-100">
                                                <div class="card-right d-flex w-100 justify-content-between">
                                                    <div class="product-info">
                                                        <h5 class="product-title"> Order ID :# <span>123456789</span></h5>
                                                        <div class="price-current"> Mooei Pcs set</div>
                                                        <div class="psize d-flex gap-4 mt-2">
                                                            <span>Size: M</span>
                                                            <span class="d-flex align-items-center gap-2">
                                                                Color:
                                                                <div class="colorbox" style="width:15px;height:15px;border-radius:3px;">
                                                                </div>
                                                            </span>
                                                            <span>Qnt: 1</span>
                                                        </div>
                                                        
                                                    </div>
                                                    <h5 class="product-title"> 440 KD</h5>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="delivery-label mb-2">Placed</p>
                                                    <p class="delivery-date mb-2">7PM | 21-02-2025</p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="expert-date">Expected Delivery Date : 12 SEP 25</div>
                                </div>

                                <div class="cart-panel position-relative">
                                    <div class="cart-card bottom-pd">
                                        <div class="card-left mb-2 d-flex">
                                            <div>
                                                <div class="cart-products order-images me-3">
                                                    <img src="{{asset('user/assets/images/categorie1.png')}}" alt="Product"
                                                        class="img-fluid">
                                                </div>
                                            </div>

                                            <div class="w-100">
                                                <div class="card-right d-flex w-100 justify-content-between">
                                                    <div class="product-info">
                                                        <h5 class="product-title"> Order ID :# <span>123456789</span></h5>
                                                        <div class="price-current"> Mooei Pcs set</div>
                                                        <div class="psize d-flex gap-4 mt-2">
                                                            <span>Size: M</span>
                                                            <span class="d-flex align-items-center gap-2">
                                                                Color:
                                                                <div class="colorbox" style="width:15px;height:15px;border-radius:3px;">
                                                                </div>
                                                            </span>
                                                            <span>Qnt: 1</span>
                                                        </div>
                                                        
                                                    </div>
                                                    <h5 class="product-title"> 440 KD</h5>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="delivery-label mb-2">Placed</p>
                                                    <p class="delivery-date mb-2">7PM | 21-02-2025</p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="expert-date" style="background:#E700001A;color:#E70000;">Cancelled  Date : 12 SEP 25</div>
                                </div>

                                <div class="cart-panel position-relative">
                                    <div class="cart-card bottom-pd">
                                        <div class="card-left mb-2 d-flex">
                                            <div>
                                                <div class="cart-products order-images me-3">
                                                    <img src="{{asset('user/assets/images/categorie1.png')}}" alt="Product"
                                                        class="img-fluid">
                                                </div>
                                            </div>

                                            <div class="w-100">
                                                <div class="card-right d-flex w-100 justify-content-between">
                                                    <div class="product-info">
                                                        <h5 class="product-title"> Order ID :# <span>123456789</span></h5>
                                                        <div class="price-current"> Mooei Pcs set</div>
                                                        <div class="psize d-flex gap-4 mt-2">
                                                            <span>Size: M</span>
                                                            <span class="d-flex align-items-center gap-2">
                                                                Color:
                                                                <div class="colorbox" style="width:15px;height:15px;border-radius:3px;">
                                                                </div>
                                                            </span>
                                                            <span>Qnt: 1</span>
                                                        </div>
                                                        
                                                    </div>
                                                    <h5 class="product-title"> 440 KD</h5>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="delivery-label mb-2">Placed</p>
                                                    <p class="delivery-date mb-2">7PM | 21-02-2025</p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="expert-date" style="background:#FF5F1B1A;color:#FF5F1B;">Pickup Date : 12 SEP 25</div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>   

                
                <div class="tab-pane fade" id="pills-ordercustom" role="tabpanel"
                    aria-labelledby="pills-ordercustom-tab" tabindex="0">

                </div>   



            </div>     
        </div>   




        
    </div>
@endsection
