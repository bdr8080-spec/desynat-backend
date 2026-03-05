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
                <div class="af-rating">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                    <span>(123K)</span>
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
                <div class="commission-text"> {{ $performace->product->affiliated_commission }} % Commission </div>

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
            <div class="date-form-pnl">
                <input type="date" class="form-control">
            </div>
            <div class="date-form-pnl">
                <input type="date" class="form-control">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-xxl-6">
            <div class="py-4 pb-0">
                <div class="dash-box border20 shadow20 p20 pnl-flex total-revenue-bg">
                    <div class="dash-content ">
                        <h5 class="text-white">Total Revenue</h5>
                        <div class="title30 text-white">120</div>
                    </div>
                    <div class="dash-circle-2">
                        <img src="{{ asset('dealer') }}/assets/img/m3-icon/ren-icon.svg" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xxl-6">
            <div class=" border20 shadow20 p20 mt-4 my-earning-bg">
                <div class="total-revenu-box pnl-flex">
                    <div class="dash-content ">
                        <h5 class="text-white">My Earnings</h5>
                        <h1 class="font-34 py-3 text-white">12,542 KD</h1>
                    </div>
                    <div class="total-revenu-image">
                        <img src="{{ asset('dealer') }}/assets/img/m3-icon/white-ic.svg" alt="icon" class="img-fluid">
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
                        <h5>Total Clicks </h5>
                        <div class="title30">120</div>
                    </div>
                    <div class="dash-circle-2">
                    <img src="{{ asset('dealer') }}/assets/img/m3-icon/or-click.svg" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="dash-box border20 shadow20 p20 pnl-flex mb-3 order-bg-box">
                    <div class="dash-content">
                        <h5>Total Orders</h5>
                        <div class="title30">50</div>
                    </div>
                    <div class="dash-circle-2">
                    <img src="{{ asset('dealer') }}/assets/img/m3-icon/total-order.svg" alt="icon" class="img-fluid">

                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="total-revenu border20 shadow20 p20 mb-3">
                    <div class="total-revenu-box pnl-flex">
                        <div class="dash-content">
                            <h5>Conversion rate</h5>
                            <div class="title30">2.3%</div>
                        </div>
                        <div class="total-revenu-image">
                            <img src="{{ asset('dealer') }}/assets/img/profit.svg" alt="icon" class="img-fluid">
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




@include('affiliatedUser.layout.footer')