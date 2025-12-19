@extends('user.layout.app')

@section('content')



<div class="customContainer common-padding">
    <div class="main-content">
        <div class="row">

            {{-- LEFT SIDE CART --}}
            <div class="col-lg-8">
                <div class="common-title d-flex justify-content-between align-items-center gap-3 mb-4">
                    <div class="d-flex gap-3">
                        <a href="{{route('dashboard')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}"
                                class="img-fluid"></a>
                        <div class="order-subtitle">
                            <h3>#003242</h3>
                            <p>Place on 02/02/2025 at 10:00pm</p>
                        </div>
                    </div>
                    <div class="btn-outline1 btn-ongoing">Ongoing</div>
                    <div class="btn-outline1 btn-outline-red">Cancelled</div>
                    <div class="btn-outline1 btn-outline-de">Delivered</div>
                </div>

                <div class="cart-panel">
                    <div class="cart-card">
                        <div class="card-left mb-2 d-flex">
                            <div>
                                <div class="cart-products me-3">
                                    <img src="{{asset('user/assets/images/categorie1.png')}}" alt="Product"
                                        class="img-fluid">
                                </div>
                            </div>

                            <div class="card-right d-flex w-100 justify-content-between">
                                <div class="product-info">
                                    <h5 class="product-title"> Mooei Pcs set</h5>
                                    <div class="psize d-flex gap-4">
                                        <span>Size:M</span>

                                        <span class="d-flex align-items-center gap-2">
                                            Color:
                                            <div class="colorbox" style="width:15px;height:15px;border-radius:3px;
                                                    background: #000;">
                                            </div>
                                        </span>

                                        <span>Qnt: 100</span>
                                    </div>

                                    {{-- Price --}}
                                    <div class="price">
                                        <span class="price-current">
                                            210 KD
                                        </span>
                                        <span class="price-old">
                                            239 KD
                                        </span>
                                        <span class="discount ms-2"></span>
                                    </div>
                                </div>
                                <div class="return-view">
                                    <div class="return-green">7 day return policy available</div>
                                    <div class="d-none">
                                        <button class="btn btn-outline-red w-100" data-bs-toggle="modal"
                                            data-bs-target="#cancelModal">Cancel Order</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="rating-pnl mt-3">
                        <div class="rate-p">
                            <h5 class="product-title"> Rate this product</h5>
                            <div class="order-ratings rating-widget">
                                <div class="rating">
                                    <input id="rating-5" type="radio" name="rating" value="5"/><label for="rating-5"><i class="fas fa-2x fa-star"></i></label>
                                    <input id="rating-4" type="radio" name="rating" value="4" /><label for="rating-4"><i class="fas fa-2x fa-star"></i></label>
                                    <input id="rating-3" type="radio" name="rating" value="3"/><label for="rating-3"><i class="fas fa-2x fa-star"></i></label>
                                    <input id="rating-2" type="radio" name="rating" value="2" checked/><label for="rating-2"><i class="fas fa-2x fa-star"></i></label>
                                    <input id="rating-1" type="radio" name="rating" value="1"/><label for="rating-1"><i class="fas fa-2x fa-star"></i></label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-3">
                            <button class="btn btn-outline-red" data-bs-toggle="modal" data-bs-target="#exchangeModal"
                                style="width:130px;">Exchange</button>
                            <button class="btn btn-outline-red" data-bs-toggle="modal" data-bs-target="#returnModal"
                                style="width:130px;background:#D53B36;color:#fff;">Return</button>
                        </div>
                    </div>


                </div>

                {{-- BILLING DETAILS --}}
                <!-- <div class="gift-pnl mt-4">
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>Total Quantity</div>
                            <div>210</div>
                        </div>
                        <div class="giftinfo">
                            <div>Address </div>
                            <div>Sectore 63,Bismilla Apartment Kuwait</div>
                        </div>
                        <div class="giftinfo">
                            <div>Custom details</div>
                            <div>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</div>
                        </div>
                    </div>
                </div> -->

                {{-- DELIVERY instruction --}}
                <div class="gift-pnl mt-4">
                    <h6>Delivery instruction</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio, deserunt? Quam unde
                                officiis tenetur officia, accusamus,</p>
                        </div>
                    </div>
                </div>
                {{-- Shipping address --}}
                <div class="gift-pnl mt-4">
                    <h6>Shipping Address</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <p>Sectore 63,Bismilla Apartment Kuwait</p>
                        </div>
                    </div>
                </div>

                {{-- Cancellation Details --}}
                <div class="gift-pnl mt-4">
                    <h6>Cancellation details</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>Cancellation ID</div>
                            <div>#9876y999</div>
                        </div>
                        <div class="giftinfo">
                            <div>Cancelled on</div>
                            <div>02/02/2025 at 10:00</div>
                        </div>
                    </div>
                </div>
                <div class="gift-pnl mt-4">
                    <h6>Reason </h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio, deserunt? Quam unde
                                officiis tenetur officia, accusamus,</p>
                        </div>
                    </div>
                </div>

                {{-- Cancellation Details --}}




            </div>

            {{-- RIGHT SIDE --}}

            <div class="col-lg-4">
                <div class="orderstatus p-3 mb-4">
                    <div class="d-flex justify-content-between">
                        <div class="order-t">Order Status</div>
                        <div class="order-14">Expected Delivery 21/02/25</div>
                    </div>
                    <div class="order-view-lists mt-3">
                        <div class="or-box">
                            <div class="fill-box">
                                <img src="{{ asset('user/assets/images/order-ic/sing-ic.svg') }}" class="img-fluid">
                            </div>
                            <div>Confirmed</div>
                        </div>
                        <div class="or-box">
                            <div class="fill-box">
                                <img src="{{ asset('user/assets/images/order-ic/tax.svg') }}" class="img-fluid">
                            </div>
                            <div>Shipped</div>
                        </div>
                        <div class="or-box">
                            <div class="fill-box">
                                <img src="{{ asset('user/assets/images/order-ic/van.svg') }}" class="img-fluid">
                            </div>
                            <div>On the Way</div>
                        </div>
                        <div class="or-box">
                            <div class="fill-box" style="background:#fff;">
                                <img src="{{ asset('user/assets/images/order-ic/box.svg') }}" class="img-fluid">
                            </div>
                            <div>Delivered</div>
                        </div>
                    </div>
                </div>

                <div class="orderstatus p-3 mb-4">
                    <div class="d-flex justify-content-between">
                        <div class="order-t">Order Status</div>
                    </div>
                    <div class="order-view-lists mt-3">
                        <div class="or-box">
                            <div class="fill-box">
                                <img src="{{ asset('user/assets/images/order-ic/sing-ic.svg') }}" class="img-fluid">
                            </div>
                            <div>Confirmed</div>
                        </div>

                        <div class="or-box">
                            <div class="fill-box" style="background:#D72E04;">
                                <img src="{{ asset('user/assets/images/order-ic/box.svg') }}" class="img-fluid"
                                    style="filter: brightness(26);">
                            </div>
                            <div style="color:#D72E04;">Delivered</div>
                        </div>
                    </div>
                </div>


                <h6>Billing Details</h6>
                <div class="gift-pnl mt-0">
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>Total MRP</div>
                            <div>8000 KD</div>
                        </div>
                        <div class="giftinfo">
                            <div>Discount on MRP </div>
                            <div class="discount">80 KD</div>
                        </div>
                        <div class="giftinfo">
                            <div>Coupon Discount (FIR20)</div>
                            <div class="discount">80 KD</div>
                        </div>
                        <div class="giftinfo">
                            <div>Shipping Free </div>
                            <div>80 KD</div>
                        </div>
                        <div class="giftinfo">
                            <div>Tax(if any)</div>
                            <div>10.00 KD</div>
                        </div>
                        <div class="giftinfo">
                            <div>Total Amount</div>
                            <div>80900 KD</div>
                        </div>
                    </div>
                </div>
                <div class="return-green">You will save 100 KD on this</div>


                <div class="gift-pnl mt-3">

                    <h6>Paid by</h6>
                    <div class="border-1">
                        <div class="giftinfo">
                            <div>8000 KD</div>
                            <div>Paid By Card</div>
                        </div>
                    </div>
                </div>


                <div class="mt-4">
                    <button type="submit" class="customBtn mb-3">
                        Download Invoice
                    </button>
                </div>

            </div>

        </div>


    </div>

</div>




<!-- Cancel order -->

<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5" id="exampleModalLabel">Select Reason</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="gift-panel-list">
                    <div class="reason-list">
                        <label class="custom-radio mb-3">
                            <input type="radio" name="filter" value="1" checked>
                            <span class="radio-mark"></span>
                            <div class="label-content">
                                <div class="title">Reason 1</div>
                            </div>
                        </label>
                        <label class="custom-radio mb-3">
                            <input type="radio" name="filter" value="1">
                            <span class="radio-mark"></span>
                            <div class="label-content">
                                <div class="title">Reason 2</div>
                            </div>
                        </label>
                        <label class="custom-radio mb-3">
                            <input type="radio" name="filter" value="1">
                            <span class="radio-mark"></span>
                            <div class="label-content">
                                <div class="title">Other</div>
                            </div>
                        </label>
                    </div>

                    <div class="form-group w-100 py-2">
                        <textarea rows="4" class="form-control pline-10" placeholder="Write here"></textarea>
                    </div>
                    <div class="mt-4">
                        <button type="button" class="customBtn mb-3 white-btn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Return Modal -->

<div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5">Return Request</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="gift-panel-list">
                    <h6>Select Reason</h6>

                    <div class="reason-list">
                        <label class="custom-radio mb-3">
                            <input type="radio" name="filter" value="1" checked>
                            <span class="radio-mark"></span>
                            <div class="label-content">
                                <div class="title">Reason 1</div>
                            </div>
                        </label>
                        <label class="custom-radio mb-3">
                            <input type="radio" name="filter" value="1">
                            <span class="radio-mark"></span>
                            <div class="label-content">
                                <div class="title">Other</div>
                            </div>
                        </label>
                    </div>

                    <div class="form-group w-100 py-2 mb-3">
                        <textarea rows="3" class="form-control pline-10" placeholder="Write here"></textarea>
                    </div>
                    
                    <h6>Upload Image(Optional)</h6>

                    <div class="mt-4">
                        <button type="button" class="customBtn mb-3 white-btn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Exchange Modal -->

<div class="modal fade" id="exchangeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5">Exchange Request</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="gift-panel-list">
                    <h6>Select Reason</h6>

                    <div class="reason-list">
                        <label class="custom-radio mb-3">
                            <input type="radio" name="filter" value="1" checked>
                            <span class="radio-mark"></span>
                            <div class="label-content">
                                <div class="title">Reason 1</div>
                            </div>
                        </label>
                        <label class="custom-radio mb-3">
                            <input type="radio" name="filter" value="1">
                            <span class="radio-mark"></span>
                            <div class="label-content">
                                <div class="title">Other</div>
                            </div>
                        </label>
                    </div>

                    <div class="form-group w-100 py-2 mb-3">
                        <textarea rows="3" class="form-control pline-10" placeholder="Write here"></textarea>
                    </div>
                    
                    <h6>Select Available Size</h6>

                    <div class="mt-4">
                        <button type="button" class="customBtn mb-3 white-btn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    
</script>

