<div class="allproduct-wapper pt-5">
    <div class="row">

        <!-- Product SHow Code Start Here -->


        @forelse($products as $key=>$product)

        <div class="col-lg-4 col-md-6">
            <div class="sub-category-pnl mb-3 pb-1">
                <div class="sub-grid position-relative">
                    <figure>
                        <img src="{{$product['product']['product_variants'][0]['variant_image'][0]}}" alt="image"
                            class="img-fluid">
                    </figure>
                    <div class="af-commission">

                        @isset($product['product']['affiliated_commission'])
                        {{$product['product']['affiliated_commission']}}%
                        Commission
                    @else
                        0%
                        Commission
                   
                    @endisset
                    </div>
                </div>
                <div class="af-content p-2">
                    <div class="sub-title">
                        {{$product['product']['product_name_en']}}
                    </div>
                    <div class="af-rating">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                        <span>(123K)</span>
                    </div>
                    <div class="af-price">
                        {{$product['product']['product_variants'][0]['final_price']}}
                        KD</div>
                    <div class="af-price-line"><span class="text-decoration-line-through">
                            {{$product['product']['product_variants'][0]['actual_price']}}
                            KD </span>

                        {{$product['product']['product_variants'][0]['discount_value']}}

                        @if($product['product']['product_variants'][0]['discount_type']=='1')
                        %
                        @else
                        Off
                        @endif
                    </div>
                    <div class="text-center mt-2">
                        <a href="{{route('affiliate.ProductPerformance', $product['id'])}}"
                            class="btn btn-success w-100 lh-sm text-white">Track
                            Performance</a>
                    </div>
                </div>
            </div>
        </div>


        @empty
        <div class="col-lg-4 col-md-6">

          <p>No product found</p>

        </div>

        @endforelse

        <!-- Product SHow Code End  Here -->


    </div>
</div>