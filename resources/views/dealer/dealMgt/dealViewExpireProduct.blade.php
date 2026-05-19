@include('dealer.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center mb-5">
        <a class="title24 alink" href="{{ url()->previous() }} "> <i class="bi bi-chevron-left"></i>{{ __('seller_messages.Details') }}</a>
    </div>

    <div class="row mt-3">
        <div class="col-lg-6">
            <div class="deals-box mb-4 ">
                <img src="{{ $single_deal['deal_data']->image}}" alt="image">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="deal-deatils">
                <h4 style="color:red">{{ __('seller_messages.Expired_On') }}- {{ date('d M Y', strtotime($single_deal['deal_data']->to)) }}</h4>
                <div class="duration-table">
                    <table class="table table-borderless">
                        <tr>
                            <td>{{ __('seller_messages.Duration') }} - {{ $single_deal['deal_data']->from}} - {{ $single_deal['deal_data']->to}}
                            </td>
                            <td>{{ __('seller_messages.Category') }}  - {{  $single_deal['deal_data']->category_details->name}}</td>
                        </tr>
                        <tr>
                            <td>{{ __('seller_messages.Discount') }} - {{  $single_deal['deal_data']->discount }} %</td>
                            <td>{{ __('seller_messages.Sub_Category') }}  - {{  $single_deal['deal_data']->subCategory_details->name_english}}</td>
                        </tr>
                    </table>

                    <p class="single-pad">{{  $single_deal['deal_data']->name_english }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="search-field d-flex justify-content-between align-item-center">
        <!-- <h5>Select Product</h5> -->
        <div>
            <div class="from-group position-relative">
                <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search" class="search-icon">
                <input type="search" class="form-control tableSearch" placeholder="{{ __('seller_messages.search') }}" data-table="table2">
            </div>
        </div>

        <div class="total-bg d-flex gap-3">
            <h6>{{ __('seller_messages.Total_Revenue') }}</h6>
            <h2><strong>0 KD</strong></h2>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered datatable tablesearch" id="table2">
            <thead>
                <tr>
                     <th class="no-sort">
                        {{ __('seller_messages.Add') }}
                    </th>
                    <th class="no-sort">
                        {{ __('seller_messages.S_No') }}
                    </th>
                    <th class="no-sort">
                        {{ __('seller_messages.Banner_Image') }}
                    </th>
                    <th class="no-sort">
                        {{ __('seller_messages.Name') }}
                    </th>
                    <th class="no-sort">
                        {{ __('seller_messages.Brand') }}
                    </th>
                    <th class="no-sort">
                        {{ __('seller_messages.Rating') }}
                    </th>
                    <th class="no-sort">
                        {{ __('seller_messages.Price') }}
                    </th>
                </tr>
            </thead>
            <tbody>

                @foreach($single_deal['added_products'] as $key=>$val)

                <tr>
                    <td>{{$key+1}}</td>
                    <td>
                        <div class="deal-img">
                            <img src="{{$val->product_details->product_variants['0']->variant_image['0'] }}" alt="image"
                                class="img-fluid">
                        </div>
                    </td>
                     <td>
                          @if(App::getLocale()=='en')
                                  {{$val->product_details->product_name_en }}
                                    @else
                                  {{$val->product_details->product_name_ar }}
                            @endif

                        </td>
                        <td>
                        @if(App::getLocale()=='en')    
                            {{$val->product_details->brand->name_english }}
                        @else 
                            {{$val->product_details->brand->name_arabic }}
                        @endif
                    </td>
                    <td><i class="bi bi-star-fill yellow-star"></i> {{$val->avg_product_rating ?? 0 }}</td>
                    <td>{{$val->product_details->product_variants['0']->final_price}}   {{ __('seller_messages.KD') }}</td>
                    <td> 0 </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <!-- 
    <div class="dashboard-button mt-4">
        <button type="submit" class="btn add-fillbtn w-100">Add to Deals</button>
    </div> -->



</section>


<script>
$(document).ready(function() {

    $('.removeProductFromList').on('click', function() {

        let refId = $(this).attr('ref');
        let deal_id = "{{Request()->id}}";

        $.ajax({
            url: "{{ route('seller.Remove-product-single-deal')}}", // your Laravel route
            type: "POST",
            data: {
                id: refId,
                deal_id: deal_id,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                // alert('Products added to deals successfully!');
                console.log(response);

                toastr.success(response.message);

                window.setTimeout(function() {
                    window.location =
                        "{{ route('seller.View-single-deal-management',request()->id)}}";
                }, 1000);

            },
            error: function(xhr) {
                console.log(xhr.responseText);
                toastr.error("Something went wrong");
                // alert('Something went wrong.');
            }
        });
    });

});

// Data Table Search Code 
$(document).ready(function() {
    let table2;
    if (!$.fn.DataTable.isDataTable('#table2')) {
        table2 = $('#table2').DataTable({
            paging: true,
            ordering: true,
            info: true,
            searching: true
        });
    } else {
        table2 = $('#table2').DataTable();
    }

    $('.tableSearch').on('keyup', function() {
        table2.search(this.value).draw();
    });
});
</script>

@include('dealer.layout.custom_code');

@include('dealer.layout.footer');