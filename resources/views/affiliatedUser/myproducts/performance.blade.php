@include('affiliatedUser.layout.header')

<section class="section dashboard">
    <div class="d-flex justify-content-between mt-4 mb-5">
        <a href="{{route('affiliate.affiliateMyProduct')}}" class="title24 alink">
            <i class="bi bi-chevron-left"></i> Item Performance
        </a>
    </div>
    
    <div class="performance-pnl my-4 mb-5">
        <div class="d-flex gap-4">
            <div class="performance-img">
                <img src="{{ $performace->product->product_variants['0']->variant_image['0'] }}" alt="icon" class="img-fluid">
            </div>
            <div class="performance-content">
                <div class="sub-title"> {{ $performace->product->product_name_en}}</div>
                <!-- <div class="af-rating">

                       @for($i=0;$i<$performace->product->product_avg_rating; $i++)
                        <i class="bi bi-star-fill"></i>
                       @endfor
                        
                        <span>({{$performace->product->review_count}}) </span>
                  
                </div> -->
                <div class="af-rating">
                    @php
                        $rating = $performace->product->product_avg_rating ?? 0;
                        $maxStars = 5;
                        $filledStars = ($rating > 0) ? (int)$rating : 0;
                        $emptyStars = $maxStars - $filledStars;
                    @endphp

                    {{-- Filled stars --}}
                    @for ($i = 0; $i < $filledStars; $i++)
                        <i class="bi bi-star-fill"></i>
                    @endfor

                    {{-- Empty stars --}}
                    @for ($i = 0; $i < $emptyStars; $i++)
                        <i class="bi bi-star"></i>
                    @endfor

                    <span>({{ $performace->product->review_count ?? 0 }})</span>
                </div>
                <div class="per-size d-flex gap-2 py-1">
                    <div class="per-1">Size: <span>  {{ $performace->product->product_variants['0']->size->name }}  </span></div>
                    <div class="per-1">Color: <span>   {{ $performace->product->product_variants['0']->color->name }} </span></div>
                    <!-- <div class="per-1">Qnt: <span> 0</span></div> -->
                </div>
                <div class="af-price-line"><span class="af-price text-black">{{ $performace->product->product_variants['0']->final_price }} KD</span> <span class="text-decoration-line-through"> {{ $performace->product->product_variants['0']->actual_price }} KD </span>

                    {{$performace->product->product_variants['0']->discount_value}}

                    
                    @if($performace->product->product_variants['0']->discount_type=='1')
                    %
                    @else
                     OFF
                    @endif
                    </div>
                <div class="commission-text"> {{ $performace->product->affiliated_commission??'0'}}% Commission </div>

            </div>
        </div>
       
        <div class="link-copy">
    <div class="link-title">
        Link: 
        <span id="affiliateLink">{{ $performace->affiliate_product_link->link }}</span>
        <i class="bi bi-copy" onclick="copyLink()" style="cursor:pointer;"></i>
    </div>
</div>

    </div>


    <div class="group-radio-btn d-flex gap-4 justify-content-between flex-wrap">
        <div class="title24">Quick Summary</div>
        <div class="show-date d-flex gap-2  flex-wrap">
            <!-- <div class="date-form-pnl">
                <input type="date" class="form-control">
            </div>
            <div class="date-form-pnl">
                <input type="date" class="form-control">
            </div> -->
            <form method="GET" action="{{ route('affiliate.ProductPerformance', $id) }}" id="filterForm" class="show-date d-flex gap-2 flex-wrap">
                <div class="date-form-pnl">
                    <input type="date" name="start_date" id="start_date" class="form-control" 
                        value="{{ request()->start_date }}" 
                        onchange="document.getElementById('filterForm').submit();" />
                </div>
                <div class="date-form-pnl">
                    <input type="date" name="end_date" id="end_date" class="form-control" 
                        value="{{ request()->end_date }}" 
                        onchange="document.getElementById('filterForm').submit();" />
                </div>
            </form>
        </div>
</div>

    @php
        // Ensure $summaryArray is always an array
        $summaryArray = is_object($summary) ? (array) $summary : $summary;

        // Set defaults if keys don't exist
        $Total_revenue = $summaryArray['Total_revenue'] ?? 0;
        $my_earning = $summaryArray['my_earning'] ?? 0;
        $Total_order = $summaryArray['Total_order'] ?? 0;
        $affiliate_clicks = $summaryArray['affiliate_product_click_records_count'] ?? 0;
        $conversionrate = $summaryArray['conversionrate'] ?? 0;
    @endphp

    <div class="row">
        <div class="col-lg-6 col-xxl-6">
            <div class="py-4 pb-0">
                <div class="dash-box border20 shadow20 p20 pnl-flex total-revenue-bg">
                    <div class="dash-content ">
                        <h5 class="text-white">Total Revenue</h5>
                        <div class="title30 text-white">{{ $Total_revenue }} KD</div>
                    </div>
                    <div class="dash-circle-2">
                        <img src="{{ asset('dealer/assets/img/m3-icon/ren-icon.svg') }}" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xxl-6">
            <div class="border20 shadow20 p20 mt-4 my-earning-bg">
                <div class="total-revenu-box pnl-flex">
                    <div class="dash-content ">
                        <h5 class="text-white">My Earnings</h5>
                        <h1 class="font-34 py-3 text-white">{{ $my_earning }} KD</h1>
                    </div>
                    <div class="total-revenu-image">
                        <img src="{{ asset('dealer/assets/img/m3-icon/white-ic.svg') }}" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-2">
        <div class="row mt-3">
            <div class="col-lg-4 col-md-4">
                <div class="dash-box border20 shadow20 p20 pnl-flex mb-4 click-bg">
                    <div class="dash-content">
                        <h5>Total Clicks</h5>
                        <div class="title30">{{ $affiliate_clicks }}</div>
                    </div>
                    <div class="dash-circle-2">
                        <img src="{{ asset('dealer/assets/img/m3-icon/or-click.svg') }}" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4">
                <div class="dash-box border20 shadow20 p20 pnl-flex mb-3 order-bg-box">
                    <div class="dash-content">
                        <h5>Total Orders</h5>
                        <div class="title30">{{ $Total_order }}</div>
                    </div>
                    <div class="dash-circle-2">
                        <img src="{{ asset('dealer/assets/img/m3-icon/total-order.svg') }}" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4">
                <div class="total-revenu border20 shadow20 p20 mb-3">
                    <div class="total-revenu-box pnl-flex">
                        <div class="dash-content">
                            <h5>Conversion Rate</h5>
                            <div class="title30">{{ $conversionrate }}%</div>
                        </div>
                        <div class="total-revenu-image">
                            <img src="{{ asset('dealer/assets/img/profit.svg') }}" alt="icon" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>









</section>


<script>
function copyLink() {
    let text = document.getElementById("affiliateLink").innerText;
    navigator.clipboard.writeText(text).then(function() {
        toastr.success("Link copied!");
    });
}
</script>

<script>
    document.querySelectorAll('.show-date input[type="date"]').forEach(function(input){
        input.addEventListener('change', function(){
            input.closest('form').submit();
        });
    });
</script>

<script>
    function updateToDate() {
        const fromDate = document.getElementById('start_date').value;
        const toDateInput = document.getElementById('end_date');
        if (fromDate) {
            toDateInput.setAttribute('min', fromDate);
        } else {
            toDateInput.removeAttribute('min');
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        updateToDate();
    });
</script>



@include('affiliatedUser.layout.footer')