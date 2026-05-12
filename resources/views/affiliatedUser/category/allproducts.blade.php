@include('affiliatedUser.layout.header')

<section class="section dashboard">
    <div class="d-flex justify-content-between mt-4 mb-5">
        <a href="{{route('affiliate.affiliateCategory')}}" class="title24 alink">
            <i class="bi bi-chevron-left"></i> {{ __('affiliate_messages.all_products') }}
        </a>
    </div>
    <div class="search-field d-flex align-items-center">
        <div class="from-group position-relative w-100">
            <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search" class="search-icon2">
            <input type="search" class="form-control py-3" placeholder="{{ __('affiliate_messages.search') }}">
        </div>
        <button type="button" class="btn btn-success searchlin">{{ __('affiliate_messages.search') }}</button>
    </div>

    <div class="allproduct-wapper pt-5">
        <div class="row">

            @forelse($products as $key=>$product)
            <div class="col-lg-3 col-md-6">
                <div class="sub-category-pnl mb-3 pb-1">
                    <div class="sub-grid position-relative">
                        <figure>
                            <img src="{{$product['product_variants'][0]['variant_image'][0]}}" alt="image"
                                class="img-fluid">
                        </figure>
                        <div class="af-commission">

                            
                        @isset($product['affiliated_commission'])
                        {{$product['affiliated_commission']}}%
                        {{ __('affiliate_messages.commission') }}
                    @else
                        0%
                        {{ __('affiliate_messages.commission') }}
                   
                    @endisset 
                   </div>
                    </div>
                    <div class="af-content p-2">
                        <div class="sub-title"> 
                            @if(app()->getLocale() == 'en')
                            {{ substr($product['product_name_en'],0,20)}}
                            @else
                            {{ substr($product['product_name_ar'],0,20)}}
                            @endif
                        </div>
                        <div class="af-rating">
                        
                              @for($i=0;$i<$product['product_avg_rating']; $i++)
                        <i class="bi bi-star-fill"></i>
                       @endfor
                       
                            <span>({{$product['review_count']}}) </span>

                        </div>
                        <div class="af-price"> {{$product['product_variants'][0]['final_price']}} {{ __('affiliate_messages.kwd') }}</div>
                        <div class="af-price-line"><span class="text-decoration-line-through">
                                {{$product['product_variants'][0]['actual_price']}} {{ __('affiliate_messages.kwd') }} </span>

                            {{$product['product_variants'][0]['discount_value']}}

                            @if($product['product_variants'][0]['discount_type']=='1')
                            %
                            @else
                            {{ __('affiliate_messages.off') }}
                            @endif

                        </div>
                        <div class="text-center mt-2">
                            <button type="button" class="btn btn-success w-100 lh-sm get-link-btn"
                                data-bs-toggle="modal" data-bs-target="#getlink" data-product="{{$product['id']}}">
                                {{ __('affiliate_messages.get_link') }}</button>
                        </div>
                    </div>
                </div>
            </div>

            @empty
             <div class="col-lg-3 col-md-6">
                <p>{{ __('affiliate_messages.no_product_found') }}</p>
             </div>

            @endforelse

        </div>
    </div>

</section>


<!-- Get Link Modal -->
<div class="modal fade" id="getlink" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-75">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">{{ __('affiliate_messages.affiliate_link') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="AddproductToLink" action="{{route('affiliate.add_to_my_products')}}" method="post">
                <meta name="csrf-token" content="{{ csrf_token() }}">

                <div class="modal-body">
                    <div class="search-field-2 d-flex align-items-center py-4 gap-3">
                        <div class="from-group position-relative w-75">
                            <input type="search" class="form-control py-3" id="generate_url_link"
                                placeholder="Enter URL" readonly>

                            <input type="hidden" class="form-control py-3" name="product_id" id="product_id">
                        </div>
                        <button type="button" class="btn btn-success" id="copyLinkBtn">{{ __('affiliate_messages.copy_link') }}</button>
                    </div>
                    <div class="text-center mt-2">
                        <button type="submit" class="btn btn-success w-100 lh-2">{{ __('affiliate_messages.add_product') }}</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script src="{{ asset('/dealer') }}/assets/custom-file/js/jquery.min.js"></script>

<script>
$(document).on('click', '.get-link-btn', function() {

    let productId = $(this).data('product');

    $.ajax({
        url: "{{ route('affiliate.generateProductLink') }}",
        type: "GET",
        data: {
            product_id: productId
        },
        beforeSend: function() {
            // $('#getlink .modal-body').html('<p>Loading...</p>');
        },
        success: function(response) {

            $('#generate_url_link').val(response);
            $('#product_id').val(productId);

        },
        error: function() {
            alert('Something went wrong');
        }
    });

});

$(document).on('click', '#copyLinkBtn', function() {

    let copyText = $('#generate_url_link').val();

    navigator.clipboard.writeText(copyText).then(function() {
        toastr.success("{{ __('affiliate_messages.link_copied_successfully') }}");
    }).catch(function() {
        toastr.failed("Failed to copy link");
    });

});



$(document).on('submit', '#AddproductToLink', function(e) {

    e.preventDefault(); // stop normal form submit

    let form = $(this);
    let formData = form.serialize();

    $.ajax({
        url: form.attr('action'),
        type: "POST",
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            // form.find('button[type="submit"]').prop('disabled', true).text('Adding...');
        },
        success: function(response) {

            console.log(response.status);

            if (response.status == "success") {
                toastr.success(response.message);

            window.setTimeout(function() {
                location.reload();
            }, 2000);

            }

            if (response.status == "error") {
                toastr.error(response.message);
            }

          

            // Optional success message
            // alert('Product added successfully!');

            // 🔥 Refresh page
            // location.reload();

        },
        error: function(xhr) {

            alert('Something went wrong');

            form.find('button[type="submit"]').prop('disabled', false).text('Add product');
        }
    });

});
</script>



@include('affiliatedUser.layout.footer')