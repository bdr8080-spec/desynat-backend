@include('dealer.layout.header')

@php
$menu_permission=SellermenuPermission();

$can_view=$menu_permission['can_view'];
$can_action=$menu_permission['can_action'];


@endphp


<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center mb-5">
        <a class="title24 alink" href="{{ route('seller.deal_management') }} "> <i class="bi bi-chevron-left"></i>
            {{ __('seller_messages.Details') }}</a>
    </div>

    <div class="row mt-3">
        <div class="col-lg-6">
            <div class="deals-box mb-4 ">
                <img src="{{ $single_deal['deal_data']->image}}" alt="image">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="deal-deatils">
                <h4 class="greentitle">{{ __('seller_messages.Starts_From') }} - {{ date('d M Y', strtotime($single_deal['deal_data']->from)) }}
                </h4>
                <div class="duration-table">
                    <table class="table table-borderless">
                        <tr>
                            <td>{{ __('seller_messages.Duration') }} - {{ $single_deal['deal_data']->from}} - {{ $single_deal['deal_data']->to}}
                            </td>
                            <td>{{ __('seller_messages.Category') }} - {{  $single_deal['deal_data']->category_details->name}}</td>
                        </tr>
                        <tr>
                            <td>{{ __('seller_messages.Discount') }}- {{  $single_deal['deal_data']->discount }} %</td>
                            @php
    $deal = $single_deal['deal_data'];
@endphp

<td>
    {{ __('seller_messages.Sub_Category') }} -
    @foreach($deal->subCategory_details as $subCategory)
        {{ $subCategory->name_english }}@if(!$loop->last), @endif
    @endforeach
</td>
                        </tr>

                    </table>
                    <p class="single-pad">{{  $single_deal['deal_data']->name_english }}</p>

                </div>
            </div>
        </div>
    </div>



    <div class="search-field d-flex justify-content-between align-item-center">
        <div class="d-flex gap-3" style=" align-items: baseline;">
            <h5>{{ __('seller_messages.Select_Product') }}</h5>
            <div class="from-group position-relative">
                <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search" class="search-icon">
                <input type="search" class="form-control tableSearch" placeholder="{{ __('seller_messages.search') }}" data-table="table2">
            </div>
        </div>
          @if($can_action == '1')
        <a href="{{ route('seller.add-single-deal-management',request()->id)}}">
            <img src="{{ asset('dealer') }}/assets/img/add.svg" alt="add" height="50px">
        </a>
        @endif
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
                    <td>{{$val->product_details->product_variants['0']->final_price}} {{ __('seller_messages.KD') }}</td>
                    <td>
                          @if($can_action == '1') 
                        <i class="bi bi-trash removeProductFromList fas-5" ref="{{$val->id }}"> </i>
                         @endif
                </td>
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



<!-- Modal -->
<div class="modal fade" id="succesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="p-4 text-center">
                    <img alt="image" src="{{ asset('/dealer') }}/assets/img/success.svg">
                    <h5 class="mt-3"> {{ __('seller_messages.Products_Remove_Successfully') }}</h5>
                </div>
            </div>

        </div>
    </div>
</div>


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

                // toastr.success(response.message);

                $('#succesModal').modal('show');

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
            searching: true,
            language: {
                emptyTable: "No Product found in this category",
                zeroRecords: "No Product found in this category"
            }
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