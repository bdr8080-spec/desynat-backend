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
                    <div class="btn-outline1 btn-ongoing">Return Request</div>
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
                                    <div class="d-none-1">
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
                                <div class="rating" data-bs-toggle="modal" data-bs-target="#ratingModal">
                                    <label for="rating-1"><i class="fas fa-2x fa-star"></i></label>
                                    <label for="rating-2"><i class="fas fa-2x fa-star"></i></label>
                                    <label for="rating-3"><i class="fas fa-2x fa-star"></i></label>
                                    <label for="rating-4"><i class="fas fa-2x fa-star"></i></label>
                                    <label for="rating-5"><i class="fas fa-2x fa-star"></i></label>
                                </div>

                                <input type="hidden" id="selectedRating" value="0">
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
                <div class="gift-pnl mt-4">
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
                </div>

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

                {{-- Uploaded images --}}

                <div class="gift-pnl mt-4">
                    <h6>Uploaded images </h6>
                    <div class="border-1">
                        <div class="giftinfo">
                           <div class="image-upload">
                                <img src="{{asset('user/assets/images/simliar6.jpg')}}" class="img-fluid" alt="images">
                           </div>
                        </div>
                    </div>
                </div>



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
                    <div class="giftinfo">
                        <h6>Paid by</h6>
                        <div class="trans" style="color:#714829;font-size:12px;">Transaction Id: 124359526</div>
                    </div>
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
    <div class="modal-dialog modal-dialog-centered modal-lg">
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
                    <div class="border-1 p-3">
                        <div class="text-center">
                            <label for="upload" class="requestbox">
                                <div class="image-upload-2 mb-1">
                                    <img src="{{asset('user/assets/images/upload-icon.svg')}}" class="img-fluid" alt="images">
                                </div>
                                <div style="font-size:13px;color:#7a7979;">Upload Profile Images</div>
                                <input type="file" id="requestimg" multiple accept="image/*">
                            </label>
                        </div>
                    </div>

                    <div class="mt-2">
                        <div id="previewRequest" class="preview-box1"></div>
                    </div>

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
    <div class="modal-dialog modal-dialog-centered modal-lg">
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
                    <div class="reason-list">
                        <label class="custom-radio mb-3">
                            <input type="radio" name="filter" value="1" checked>
                            <span class="radio-mark"></span>
                            <div class="label-content">
                                <div class="title">XS</div>
                            </div>
                        </label>
                        <label class="custom-radio mb-3">
                            <input type="radio" name="filter" value="1">
                            <span class="radio-mark"></span>
                            <div class="label-content">
                                <div class="title">M</div>
                            </div>
                        </label>
                    </div>

                    <div class="mt-4">
                        <button type="button" class="customBtn mb-3 white-btn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Rating section Modal -->
<div class="modal fade" id="ratingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5">Rate this product</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="gift-panel-list">
                    <div class="reason-list rating-widget ">
                        <h6>Rate Nike T-Shirt</h6>
                        <div class="rating py-2">
                            <input id="rating-1" type="radio" name="raterating" value="1" checked /><label for="rating-1"><i class="fas fa-2x fa-star"></i></label>
                            <input id="rating-2" type="radio" name="raterating" value="2" /><label for="rating-2"><i class="fas fa-2x fa-star"></i></label>
                            <input id="rating-3" type="radio" name="raterating" value="3"/><label for="rating-3"><i class="fas fa-2x fa-star"></i></label>
                            <input id="rating-4" type="radio" name="raterating" value="4" /><label for="rating-4"><i class="fas fa-2x fa-star"></i></label>
                            <input id="rating-5" type="radio" name="raterating" value="5"/><label for="rating-5"><i class="fas fa-2x fa-star"></i></label>
                        </div>
                    </div>

                    <div class="form-group w-100 py-2 mb-3 position-relative">
                        <p>Write Review</p>
                        <textarea rows="1" class="form-control pline-10" placeholder="Write here"></textarea>
                        <div class="paperhover">
                            <label><input type="file" id="images" multiple accept="image/*">
                            <i class="bi bi-paperclip"></i>
                            </label>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div id="preview" class="preview-box1"></div>
                    </div>

                    <div class="reason-list rating-widget mt-2">
                        <h6>Rate Store</h6>
                        <div class="rating py-2">
                            <input id="rating-1" type="radio" name="raterating" value="1" checked /><label for="rating-1"><i class="fas fa-2x fa-star"></i></label>
                            <input id="rating-2" type="radio" name="raterating" value="2" /><label for="rating-2"><i class="fas fa-2x fa-star"></i></label>
                            <input id="rating-3" type="radio" name="raterating" value="3"/><label for="rating-3"><i class="fas fa-2x fa-star"></i></label>
                            <input id="rating-4" type="radio" name="raterating" value="4" /><label for="rating-4"><i class="fas fa-2x fa-star"></i></label>
                            <input id="rating-5" type="radio" name="raterating" value="5"/><label for="rating-5"><i class="fas fa-2x fa-star"></i></label>
                        </div>
                    </div>

                    <div class="form-group w-100 py-2 mb-3 position-relative">
                        <p>Write Review</p>
                        <textarea rows="1" class="form-control pline-10" placeholder="Write here"></textarea>
                        <div class="paperhover">
                            <label><input type="file" id="reviewpic" multiple accept="image/*">
                            <i class="bi bi-paperclip"></i>
                            </label>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div id="preview1" class="preview-box1"></div>
                    </div>

                    <div class="mt-4">
                        <button type="button" class="customBtn mb-3 white-btn">Submit Review</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(function () {
  $('#images').on('change', function () {
    $('#preview').html('');
    [...this.files].forEach(file => {
      let reader = new FileReader();
      reader.onload = e =>
        $('#preview').append(
          `<div class="reviewImg">
             <img src="${e.target.result}">
             <span>&times;</span>
           </div>`
        );
      reader.readAsDataURL(file);
    });
  });

  $('#preview').on('click', 'span', function () {
    $(this).parent().remove();
  });
});


$(function () {
  $('#reviewpic').on('change', function () {
    $('#preview1').html('');
    [...this.files].forEach(file => {
      let reader = new FileReader();
      reader.onload = e =>
        $('#preview1').append(
          `<div class="reviewImg">
             <img src="${e.target.result}">
             <span>&times;</span>
           </div>`
        );
      reader.readAsDataURL(file);
    });
  });

  $('#preview1').on('click', 'span', function () {
    $(this).parent().remove();
  });
});

//Request image
$(function () {
  $('#requestimg').on('change', function () {
    $('#previewRequest').html('');
    [...this.files].forEach(file => {
      let reader = new FileReader();
      reader.onload = e =>
        $('#previewRequest').append(
          `<div class="reviewImg">
             <img src="${e.target.result}">
             <span>&times;</span>
           </div>`
        );
      reader.readAsDataURL(file);
    });
  });

  $('#previewRequest').on('click', 'span', function () {
    $(this).parent().remove();
  });
});

</script>

