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
                        {{$product['product']['product_name_en']}}
                        @else
                        {{$product['product']['product_name_ar']}}
                        @endif
                    </div>
                    <!-- <div class="af-rating">
                        

                        @for($i=0;$i<$product['average_rating']['product']; $i++)
                        <i class="bi bi-star-fill"></i>
                       @endfor
                        
                        <span>({{count($product['product']['review'] )}}) </span>
                    </div> -->
                    <div class="af-rating">
                        @php
                            $rating = $product['average_rating']['product'] ?? 0;
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

                        <span>({{ count($product['product']['review'] ?? []) }})</span>
                    </div>
                    <div class="af-price">
                        {{$product['product']['product_variants'][0]['final_price']}}
                        {{ __('affiliate_messages.kwd') }}</div>
                    <div class="af-price-line"><span class="text-decoration-line-through">
                            {{$product['product']['product_variants'][0]['actual_price']}}
                            {{ __('affiliate_messages.kwd') }} </span>

                        {{$product['product']['product_variants'][0]['discount_value']}}

                        @if($product['product']['product_variants'][0]['discount_type']=='1')
                        %
                        @else
                        {{ __('affiliate_messages.off') }}
                        @endif
                    </div>
                    <div class="text-center mt-2">
                        <a href="{{route('affiliate.ProductPerformance', $product['id'])}}"
                            class="btn btn-success w-100 lh-sm text-white">{{ __('affiliate_messages.track_performance') }}
                            </a>
                    </div>
                </div>
            </div>
        </div>


        @empty
        <div class="col-lg-4 col-md-6">

          <p>{{ __('affiliate_messages.no_product_found') }}</p>

        </div>

        @endforelse

        <!-- Product SHow Code End  Here -->


    </div>
</div>