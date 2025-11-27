
@foreach ($sizes as $key1 => $item1)

<div id="size" class="size-section" 
         style="">

           @if($product_data_called->category_id==2)

            <div class="p-4 desc-box rounded-4 my-2 shadow-sm" style="background:#fff;" >
                <div class="row mb-2">
                    <div class="col-6">Bust</div>
                    <div class="col-6 text-end">{{$item1['bust']}}  </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">Waist</div>
                    <div class="col-6 text-end">{{$item1['waist']}} </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">Hip</div>
                    <div class="col-6 text-end">{{$item1['hip']}} </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">Shoulder</div>
                    <div class="col-6 text-end">{{$item1['shoulder']}} </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">Sleeve length</div>
                    <div class="col-6 text-end">{{$item1['sleeve_length']}} </div>
                </div>
                <div class="row">
                    <div class="col-6">Length</div>
                    <div class="col-6 text-end">{{$item1['length']}} </div>
                </div>
            </div>
            @endif
            
        <div class="p-4 rounded-4 desc-box shadow-sm bg-white">
            <div class="row mb-2">
                <div class="col-6">Total Stocks</div>
                <div class="col-6 text-end">{{ $item1['total_stock'] }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-6">SKU</div>
                <div class="col-6 text-end">{{ $item1['sku'] }}</div>
            </div>

            {{-- <div class="row mb-2">
                <div class="col-6">SKU Threshold</div>
                <div class="col-6 text-end">{{ $item1['sku_threshold_value'] }}</div>
            </div> --}}
        </div>

    </div>
    @endforeach



