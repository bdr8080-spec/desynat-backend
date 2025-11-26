@include('dealer.layout.header')

@php
 
   $specification_count = 0;
  $product_Variation_count=0;
 
@endphp

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <a href="{{ route('seller.products') }}" class="title24 alink">
            <i class="bi bi-chevron-left"></i> Edit Product
        </a>
    </div>

    <form id="editproduct" action="{{ route('seller.edit_product_code',request()->id) }}" method="post">
        @csrf

          <input type="hidden" class="form-control"  name="product_id" value="{{$product_details->id}}">
        
        <div class="pt-3">
            <div class="title24">Select Category</div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="group-radio-btn d-flex gap-4 align-items-center flex-wrap py-3 justify-content-between">

                        @foreach ($category as $key => $item)
                            <div class="check_radio">
                                <label class="radio-group">
                                    <input type="radio" name="category_id" value="{{ $item->id }}"
                                        onclick="catgoryFunction({{ $item->id }})"
                                        @if ($product_details->category_id  ==  $item->id) checked @endif>
                                    <span class="custom-radio"></span>
                                    <span class="radio-label">{{ $item->name }}</span>
                                </label>
                            </div>
                        @endforeach

                    </div>
                    <p class="text-danger" id="error-category_id"></p>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Select Sub-Category</label>
                    </div>
                    <select class="form-select form-control" name="subcategory_id" aria-label="Default select example"
                        id="getSubcategry">

                    </select>
                    <p class="text-danger" id="error-subcategory_id"></p>
                </div>
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Other</label>
                        <span>In English</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter Brand name" name="other_en" value="{{$product_details->other_en}}">
                    <p class="text-danger" id="error-other_en"></p>
                </div>
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Product Name</label>
                        <span>In English</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter Product name" name="product_name_en" value="{{$product_details->product_name_en}}">
                    <p class="text-danger" id="error-product_name_en"></p>
                </div>
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Description</label>
                        <span>In English</span>
                    </div>
                    <textarea rows="4" placeholder="Write Here" class="form-control" name="description_en"> {{$product_details->description_en}}</textarea>

                    <p class="text-danger" id="error-description_en"></p>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Select Brand</label>
                    </div>
                    <select class="form-select form-control" aria-label="Default select example" name="brand_id">

                        <option value="">Select Brand</option>

                        @foreach ($brand as $item)
                            <option value="{{ $item->id }}"  @if ($product_details->brand_id  ==  $item->id) selected @endif>{{ $item->name_english }}</option>
                        @endforeach
                    </select>
                    <p class="text-danger" id="error-brand_id"></p>
                </div>
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Other</label>
                        <span>In Arabic</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter Brand name" name="other_ar" value="{{$product_details->other_ar}}">

                    <p class="text-danger" id="error-other_ar"></p>
                </div>
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Product Name</label>
                        <span>In Arabic</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter Product name" name="product_name_ar" value="{{$product_details->product_name_ar}}">

                    <p class="text-danger" id="error-product_name_ar"></p>
                </div>
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Description</label>
                        <span>In Arabic</span>
                    </div>
                    <textarea rows="4" placeholder="Write Here" class="form-control" name="description_ar">{{$product_details->description_ar}} </textarea>
                    <p class="text-danger" id="error-description_ar"></p>

                </div>
            </div>
        </div>

        <div class="mt-3 d-flex justify-content-between py-3">
            <div class="title24">Specifications</div>
            <div class="sep-icon" id="addmore">
                <img src="{{ asset('/dealer') }}/assets/img/add.svg" alt="add">
            </div>
        </div>
        <div class="specifications-pnl">
           
        @foreach ($product_details['product_specifications'] as $item)

              <div class="append-panel specifications-row">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Name</label>
                                <span>In English</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Enter product name"
                                value="{{$item->name_en}}" name="product_spe_en[]">

                            <p id="error-product_spe_en_{{$specification_count}}" class="text-danger"></p>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="append-flex">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>Name</label>
                                    <span>In Arabic</span>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter product name"
                                    name="product_spe_ar[]"  value="{{$item->name_ar}}">
                                <p class="text-danger" id="error-product_spe_ar_{{$specification_count}}"></p>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Feature</label>
                                <span>In English</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Enter product feature"
                                name="product_spe_feature_en[]"   value="{{$item->feature_en}}">
                            <p class="text-danger" id="error-product_spe_feature_en_{{$specification_count}}"></p>

                        </div>

                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="append-flex">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>Feature</label>
                                    <span>In Arabic</span>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter product feature"
                                    name="product_spe_feature_ar[]"   value="{{$item->feature_ar}}">
                                <p class="text-danger" id="error-product_spe_feature_ar_{{$specification_count}}"></p>

                            </div>

                        </div>
                    </div>
                </div>

        @if($specification_count >= 1)
        <div class="d-flex justify-content-end">
            <div class="remove-btn"><i class="bi bi-x"></i> Remove </div>
        </div>
        @endif

            </div>

          

       @php
       $specification_count++;
       @endphp

        @endforeach
        </div>

      
        <!----- variant panel ------>
          @foreach ($product_details['product_variants'] as $key=> $item)
         
        <div class="variant-panel specifications-row variant-panel-bg">
            <div class="product-pnls mt-4">
                <div class="upload-image" style="height:170px;">
                    <label id="uploadLabel" style="cursor:pointer;text-align:center;display:block;">
                        <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg">
                        <div class="mt-3">Upload Product Photo</div>
                        <input type="file" accept="image/*" multiple id="edit_imageUpload" style="opacity:0;"
                            name="variant_image[{{$product_Variation_count}}][]" rel="{{$product_Variation_count}}">
                    </label>

                    <p class="text-danger" id="error-variant_image_{{$product_Variation_count}}"></p>
                
                    @if($product_Variation_count >= 1)
                    <p class="text-danger" id="error-variant_image"></p>
                    @endif

                </div>
                
                {{-- database image code --}}

                    @if(!empty($item->variant_image))
                        @foreach($item->variant_image as $key0=> $chart)
                    <div class="multiple-img position-relative">
                    <img src="{{$chart}}" class="w-100 rounded">
                    <span class="remove-ic remove-image" style="position:absolute;top:0;right:5px;cursor:pointer;font-size:20px;color:red;">&times;</span>
               
                     <input type="text" accept="image/*" multiple id="edit_imageUpload" style="opacity:0;"
                            name="old_variant_image[{{$product_Variation_count}}][{{$key0}}]" value="{{$chart}}" rel="{{$product_Variation_count}}">
                 
                </div>
                        @endforeach
                    @endif
                            {{-- database image code end Here --}}

                <div class="product-multiple d-flex flex-wrap gap-2" id="previewContainer{{$product_Variation_count}}"></div>
            </div>

            <div class="wapper-header mt-4">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Colour</label>
                            </div>

                            <select class="form-select form-control" aria-label="Default select example"
                                name="color_id[]">
                                @foreach ($color as $item1)
                                    <option value="{{ $item1->id }}" @if($item->color_id== $item1->id ) selected  @endif >{{ $item1->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-danger" id="error-color_id_{{$product_Variation_count}}"></p>

                        </div>

                    </div>
                    <div class="col-lg-3">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Size</label>
                            </div>

                            <select class="form-select form-control" aria-label="Default select example"
                                name="size_id[]">
                                @foreach ($size as $item1)
                                    <option value="{{ $item1->id }}" @if($item->size_id== $item1->id ) selected  @endif >{{ $item1->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-danger" id="error-size_id_{{$product_Variation_count}}"></p>

                        </div>

                    </div>

                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Bust </label>
                            </div>
                            <input type="number" class="form-control notapplyspace" placeholder="Eg.32"
                                name="bust[]" value="{{$item->bust}}">
                            <p class="text-danger" id="error-bust_{{$product_Variation_count}}"></p>

                        </div>

                    </div>
                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Waist</label>
                            </div>
                            <input type="number" class="form-control notapplyspace" placeholder="Eg.32"
                                name="waist[]" value="{{$item->waist}}">

                            <p class="text-danger" id="error-waist_{{$product_Variation_count}}"></p>
                        </div>

                    </div>
                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>HIP</label>
                            </div>
                            <input type="number" class="form-control notapplyspace" placeholder="Eg.32"
                                name="hip[]"  value="{{$item->hip}}">
                            <p class="text-danger" id="error-hip_{{$product_Variation_count}}"></p>

                        </div>

                    </div>
                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Shoulder</label>
                            </div>
                            <input type="number" class="form-control notapplyspace" placeholder="Eg.32"
                                name="shoulder[]"  value="{{$item->shoulder}}">
                            <p class="text-danger" id="error-shoulder_{{$product_Variation_count}}"></p>

                        </div>

                    </div>
                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Sleev Length</label>
                            </div>
                            <input type="number" class="form-control notapplyspace" placeholder="Eg.32"
                                name="sleeve_length[]"  value="{{$item->sleeve_length}}">
                            <p class="text-danger" id="error-sleeve_length_{{$product_Variation_count}}"></p>

                        </div>

                    </div>
                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Length</label>
                            </div>
                            <input type="number" class="form-control notapplyspace" placeholder="Eg.32"
                                name="length[]"  value="{{$item->length}}">

                            <p class="text-danger" id="error-length_{{$product_Variation_count}}"></p>
                        </div>

                    </div>
                    <div class="col-lg-3">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Total Stocks</label>
                            </div>
                            <input type="number" class="form-control notapplyspace" placeholder="Eg.13208"
                                name="total_stock[]"  value="{{$item->total_stock}}">

                            <p class="text-danger" id="error-total_stock_{{$product_Variation_count}}"></p>
                        </div>

                    </div>
                    <div class="col-lg-3">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>SKU</label>
                            </div>
                            <input type="text" class="form-control notapplyspace" placeholder="20019"
                                name="sku[]"  value="{{$item->sku}}">

                            <p class="text-danger" id="error-sku_{{$product_Variation_count}}"></p>
                        </div>

                    </div>
                    <div class="col-lg-3">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>SKU Threshold value</label>
                            </div>
                            <input type="number" class="form-control notapplyspace" placeholder="20019"
                                name="sku_threshold_value[]"  value="{{$item->sku_threshold_value}}">
                            <p class="text-danger" id="error-sku_threshold_value_{{$product_Variation_count}}"></p>

                        </div>

                    </div>

                    <div class="col-lg-3">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Actual Price</label>
                            </div>
                            <input type="number" id="actual_price_{{$product_Variation_count}}" class="form-control notapplyspace" placeholder="Eg.KD 299.00"
                                name="actual_price[]"  value="{{$item->actual_price}}">
                            <p class="text-danger" id="error-actual_price_{{$product_Variation_count}}"></p>

                        </div>

                    </div>
                </div>
            </div>

            <div class="pt-3">
                <div class="title24">Discounted Price</div>
                <div class="row">
                    <div class="col-lg-4">
                        <div
                            class="group-radio-btn d-flex gap-4 align-items-center flex-wrap py-3 justify-content-between">
                            <div class="check_radio">
                                <label class="radio-group">
                                    <input type="radio" name="discount_type[{{$product_Variation_count}}]"  id="discount_type_percentage_{{$product_Variation_count}}" @if($item['discount_type']== 1) checked  @endif value="1">
                                    <span class="custom-radio"></span>
                                    <span class="radio-label">Percentage</span>
                                </label>
                            </div>
                            <div class="check_radio">
                                <label class="radio-group">
                                    <input type="radio" name="discount_type[{{$product_Variation_count}}]" id="discount_type_fixed_{{$product_Variation_count}}"   @if($item['discount_type']== 2) checked  @endif value="2">
                                    <span class="custom-radio"></span>
                                    <span class="radio-label">Fixed Price</span>
                                </label>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Percentage</label>
                            </div>
                            <input type="number" class="form-control notapplyspace" placeholder="Eg.10%"
                                name="discount_value[]"   id="discount_value_{{$product_Variation_count}}"  value="{{$item['discount_value']}}">
                            <p class="text-danger" id="error-discount_value_{{$product_Variation_count}}"></p>

                        </div>

                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Final Price</label>
                            </div>
                            <input type="number" class="form-control notapplyspace" placeholder="Eg.KD 299.00"
                                name="final_price[]"  value="{{$item['final_price']}}" id="final_price_{{$product_Variation_count}}">
                            <p class="text-danger" id="error-final_price_{{$product_Variation_count}}"></p>
                        </div>
                    </div>
                </div>
            </div>

              @if($product_Variation_count >= 1)
              <div class="d-flex justify-content-end">
                <div class="remove-btn removerow"><i class="bi bi-x"></i> Remove </div>
            </div> 
            @endif
        </div>
        
       @php
       $product_Variation_count++;
       @endphp

    @endforeach
        <!-----End variant panel ------>

        <div class="row py-3 mt-4">
            <div class="col-lg-12 col-md-12">
                <button type="button" class="btn cancel-outline w-100 addVariantBtn">Add Another Variant</button>
            </div>
        </div>

        <div class="pt-3">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="sub-form">
                        <div class="label-flex">
                            <label>Set Min.cart quantity</label>
                        </div>
                        <input type="number" class="form-control notapplyspace" placeholder="Eg.20"
                            name="min_card_quantity" value="{{$product_details->min_card_quantity}}" id="min_card_quantity_0">
                        <p class="text-danger" id="error-min_card_quantity"></p>
                         <p class="text-danger" id="error-min_card_quantity_0"></p>


                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="sub-form">
                        <div class="label-flex">
                            <label>Set Max.cart quantity</label>
                        </div>
                        <input type="number" class="form-control notapplyspace" placeholder="Eg.20"
                            name="max_card_quantity" value="{{$product_details->max_card_quantity}}" id="max_card_quantity_0">
                        <p class="text-danger" id="error-max_card_quantity"></p>
                         <p class="text-danger" id="error-max_card_quantity_0"></p>


                    </div>
                </div>
            </div>
        </div>


        <div class="pt-3">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="title24">Is this product returnable?</div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div
                                class="group-radio-btn d-flex gap-4 align-items-center flex-wrap py-3 justify-content-between">
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="product_return" checked value='1'  @if($product_details->product_return== 1) selcted  @endif>
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">Yes</span>
                                    </label>
                                </div>
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="product_return" value='0'  @if($product_details->product_return== 0) selcted  @endif>
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="@if($product_details->product_return== 0) display:none;  @endif">
                        <div class="col-lg-12 col-md-12">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>If Yes,Total days for returning</label>
                                </div>
                                <input type="number" class="form-control" placeholder="Eg.KD 299.00"
                                    name="return_days" value="{{$product_details->return_days}}" >
                                <p class="text-danger" id="error-return_days"></p>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="title24">Is this product Exchangable ?</div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div
                                class="group-radio-btn d-flex gap-4 align-items-center flex-wrap py-3 justify-content-between">
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="product_exchangable" checked value="1"   @if($product_details->product_exchangable== 1) checked  @endif>
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">Yes</span>
                                    </label>
                                </div>
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="product_exchangable" value="0"  @if($product_details->product_exchangable== 0) checked  @endif>
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="@if($product_details->product_exchangable== 0) display:none;  @endif" >
                        <div class="col-lg-12 col-md-12">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>Is this product exchangeable?</label>
                                </div>
                                <input type="number" class="form-control" placeholder="Eg.15 days"
                                    name="exchangable_days"  value="{{$product_details->exchangable_days}}" >
                                <p class="text-danger" id="error-exchangable_days"></p>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="pt-3">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="title24">Review & ratings allowed?</div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div
                                class="group-radio-btn d-flex gap-4 align-items-center flex-wrap py-3 justify-content-between">
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="review_rating" value="1"    @if($product_details->review_rating== 1) checked  @endif>
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">Yes</span>
                                    </label>
                                </div>
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="review_rating" value="0" @if($product_details->review_rating== 0) checked  @endif>
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="title24">Affiliated Product?</div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div
                                class="group-radio-btn d-flex gap-4 align-items-center flex-wrap py-3 justify-content-between">
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="affiliated_product" checked value="1" @if($product_details->affiliated_product== 1) checked  @endif>
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">Yes</span>
                                    </label>
                                </div>
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="affiliated_product" value="0"  @if($product_details->affiliated_product== 0) checked  @endif>
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="title24">Customized products?</div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div
                                class="group-radio-btn d-flex gap-4 align-items-center flex-wrap py-3 justify-content-between">
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="customized_product" value="1"  @if($product_details->customized_product== 1) checked  @endif>
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">Yes</span>
                                    </label>
                                </div>
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="customized_product" value="0" @if($product_details->customized_product== 0) checked  @endif>
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="title24">Ready to ship?</div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div
                                class="group-radio-btn d-flex gap-4 align-items-center flex-wrap py-3 justify-content-between">
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="ready_to_ship"  value="1" @if($product_details->ready_to_ship== 1) checked  @endif>
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">Yes</span>
                                    </label>
                                </div>
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="ready_to_ship" value="0" @if($product_details->ready_to_ship== 0) checked  @endif>
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="title24">Cash on delivery allowed?</div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div
                                class="group-radio-btn d-flex gap-4 align-items-center flex-wrap py-3 justify-content-between">
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="cash_on_delivery" value="1"  @if($product_details->cash_on_delivery== 1) checked  @endif>
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">Yes</span>
                                    </label>
                                </div>
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="cash_on_delivery" value="0"   @if($product_details->cash_on_delivery== 0) checked  @endif>
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="title24">Upload Size Chart</div>
        <div class="product-pnls mt-4">
            <div class="upload-image" style="height:170px;">
                <label id="uploadLabel" style="cursor:pointer;text-align:center;display:block;">
                    <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg">
                    <div class="py-2">Upload Size Chart</div>
                    <input type="file" accept="image/*" multiple id="edit_uploadChart" style="opacity:0;"
                        name="upload_size_chart">
                </label>
                <p class="text-danger" id="error-upload_size_chart"></p>

            </div>

             <div class="product-multiple d-flex flex-wrap gap-2" id="edit_uploadChart_preview">
        @if(!empty($product_details->upload_size_chart))
                <div class="position-relative multiple-img"  >
                    <img src="{{ $product_details->upload_size_chart }}" 
                         style="width:100%;height:100%;object-fit:cover;border-radius:8px;">
                    <span class="remove-ic remove-image" style="position:absolute;top:0;right:5px;cursor:pointer;font-size:20px;color:red;">&times;</span>

                     <input type="hidden" accept="image/*" value="{{ $product_details->upload_size_chart }}"
                        name="old_upload_size_chart">


                </div>
                        @endif
    </div>

            {{-- <div class="product-multiple d-flex flex-wrap gap-2 mt-2" id="edit_uploadChart_preview"></div> --}}
        </div>

        <div class="dashboard-button d-flex mt-5 gap-5">
            <button type="button" class="btn cancel-outline w-100"
                onclick="location.href='{{ route('seller.view_product',Request()->id) }}'">Cancel</button>
            <button type="submit" class="btn add-fillbtn w-100">Edit Product</button>
        </div>
    </form>

</section>





@include('dealer.layout.footer');

<script>
    // When The Page Load Then auto select Category
    $(document).ready(function() {
        var checked_category = $("input[name='category_id']:checked").val();
        if (checked_category) {
            catgoryFunction(checked_category);
        }
    });


    $(document).on('change', 'input[type="file"][name^="variant_image"]', function(e) {





    });




    // When User select Image vartion Then Show dynamic Image Preview
    $(document).on('change', 'input[type="file"][name^="variant_image"]', function(e) {
        let rel = $(this).attr('rel');
        let files = e.target.files;
        // $('#previewContainer').empty(); // clear old previews
        [...files].forEach(f => {
            let url = URL.createObjectURL(f);
            let imgBox = $(`
      <div class="multiple-img position-relative">
        <img src="${url}" class="w-100 rounded">
        <span class="remove-ic" style="position:absolute;top:0;right:5px;cursor:pointer;font-size:20px;color:red;">&times;</span>
      </div>
    `);
            imgBox.find('.remove-ic').click(() => imgBox.remove());
            $('#previewContainer' + rel).append(imgBox);
        });
    });


    // Upload Chart Image in footer side
    $('#edit_uploadChart').on('change', e => {
        let files = e.target.files;
        $('#edit_uploadChart_preview').empty(); // clear old previews
        [...files].forEach(f => {
            let url = URL.createObjectURL(f);
            let imgBox = $(`
      <div class="multiple-img position-relative">
        <img src="${url}" class="w-100 rounded">
        <span class="remove-ic" style="position:absolute;top:0;right:5px;cursor:pointer;font-size:20px;color:red;">&times;</span>
      </div>
    `);
            imgBox.find('.remove-ic').click(() => imgBox.remove());
            $('#edit_uploadChart_preview').append(imgBox);
        });
    });
</script>

<script>
    // ADD NEW ROW In specification

    $("#addmore").click(function() {

        specification_count={{$specification_count}}

        $(".append-panel").append(`

       <div class="specifications-row">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Name</label>
                        <span>In English</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter product name" name="product_spe_en[]" value="">
                <p class="text-danger" id="error-product_spe_en_${specification_count}"></p>

             </div>
               
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="append-flex">
                    <div class="sub-form">
                        <div class="label-flex">
                            <label>Name</label>
                            <span>In Arabic</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Enter product name" name="product_spe_ar[]" value="">
                    <p class="text-danger" id="error-product_spe_ar_${specification_count}"></p>

                        </div>
                  
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Feature Name</label>
                        <span>In English</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter product feature" name="product_spe_feature_en[]" value="">
                <p class="text-danger" id="error-product_spe_feature_en_${specification_count}"></p>
           
                    </div>
             </div>
            <div class="col-lg-6 col-md-6">
                <div class="append-flex">
                    <div class="sub-form">
                        <div class="label-flex">
                            <label>Feature</label>
                            <span>In Arabic</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Enter product feature" name="product_spe_feature_ar[]" value="">
                    <p class="text-danger" id="error-product_spe_feature_ar_${specification_count}"></p>

                        </div>
                 
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <div class="remove-btn"><i class="bi bi-x"></i> Remove </div>
        </div>
        </div>
       `)
        specification_count++;

    });

    // REMOVE ROW
    $(document).on("click", ".remove-btn", function() {
        $(this).closest(".specifications-row").remove();
    });
</script>

<script>

      var product_Variation_count = {{$product_Variation_count}};

    // ADD NEW Variant
    $(".addVariantBtn").click(function() {
        $(".variant-panel").append(`
        <div class="variant-panel-bg">
            <div class="product-pnls mt-4">
                <div class="upload-image" style="height:170px;">
                    <label id="uploadLabel" style="cursor:pointer;text-align:center;display:block;">
                        <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg">
                        <div class="mt-3">Upload Profile Photo</div>
                        <input type="file" accept="image/*" multiple name="variant_image[${product_Variation_count}][]" style="opacity:0;" rel="${product_Variation_count}">
                    </label>

                    <p class="text-danger" id="error-variant_image_${product_Variation_count}"></p>

                </div>

                <div class="product-multiple d-flex flex-wrap gap-2 mt-2" id="previewContainer${product_Variation_count}"></div>
            </div>

            <div class="wapper-header mt-4">
                <div class="row">
                
                     <div class="col-lg-3">
                    <div class="sub-form">
                        <div class="label-flex">
                            <label>Colour</label>
                        </div>

                        <select class="form-select form-control" aria-label="Default select example" name="color_id[]">
                            @foreach ($color as $item)
                                <option value="{{ $item->id }}"">{{ $item->name }}</option>
                            @endforeach
                        </select>
      <p class="text-danger" id="error-color_id_${product_Variation_count}"></p>

                    </div>
                    
                </div>
                <div class="col-lg-3">
                    <div class="sub-form">
                        <div class="label-flex">
                            <label>Size</label>
                        </div>

                        <select class="form-select form-control" aria-label="Default select example" name="size_id[]">
                            @foreach ($size as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                      <p class="text-danger" id="error-size_id_${product_Variation_count}"></p>

                        </div>
                   
                </div>


                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Bust</label>
                            </div>
                            <input type="number" class="form-control" placeholder="Eg.32" name="bust[]">
                          <p class="text-danger" id="error-bust_${product_Variation_count}"></p>

                            </div>

                    </div>
                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Waist</label>
                            </div>
                            <input type="number" class="form-control" placeholder="Eg.32" name="waist[]">
                          <p class="text-danger" id="error-waist_${product_Variation_count}"></p>

                   </div>

                    </div>
                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>HIP</label>
                            </div>
                            <input type="number" class="form-control" placeholder="Eg.32" name="hip[]">
                          <p class="text-danger" id="error-hip_${product_Variation_count}"></p>

                            </div>
                        
                    </div>
                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Shoulder</label>
                            </div>
                            <input type="number" class="form-control" placeholder="Eg.32" name="shoulder[]">
                          <p class="text-danger" id="error-shoulder_${product_Variation_count}"></p>

                            </div>

                    </div>
                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Sleev Length</label>
                            </div>
                            <input type="number" class="form-control" placeholder="Eg.32" name="sleeve_length[]">
                          <p class="text-danger" id="error-sleeve_length_${product_Variation_count}"></p>

                            </div>

                    </div>
                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Length</label>
                            </div>
                            <input type="number" class="form-control" placeholder="Eg.32" name="length[]" >
                          <p class="text-danger" id="error-length_${product_Variation_count}"></p>

                            </div>

                    </div>
                    <div class="col-lg-3">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Total Stocks</label>
                            </div>
                            <input type="number" class="form-control" placeholder="Eg.13208" name="total_stock[]" >
                          <p class="text-danger" id="error-total_stock_${product_Variation_count}"></p>

                            </div>

                    </div>
                    <div class="col-lg-3">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>SKU</label>
                            </div>
                            <input type="text" class="form-control" placeholder="20019" name="sku[]">
                          <p class="text-danger" id="error-sku_${product_Variation_count}"></p>

                            </div>

                    </div>
                    <div class="col-lg-3">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>SKU Threshold value</label>
                            </div>
                            <input type="number" class="form-control" placeholder="20019" name="sku_threshold_value[]">
                          <p class="text-danger" id="error-sku_threshold_value_${product_Variation_count}"></p>

                            </div>

                    </div>
                  
                    <div class="col-lg-3">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Actual Price</label>
                            </div>
                            <input type="number"  id="actual_price_${product_Variation_count}" class="form-control" placeholder="Eg.KD 299.00" name="actual_price[]">
                          <p class="text-danger" id="error-actual_price_${product_Variation_count}"></p>

                            </div>

                        
                    </div>
                </div>
            </div>

            <div class="pt-3">
                <div class="title24">Discounted Price</div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="group-radio-btn d-flex gap-4 align-items-center flex-wrap py-3 justify-content-between">
                            <div class="check_radio">
                                <label class="radio-group">
                                    <input type="radio" id="discount_type_percentage_${product_Variation_count}" name="discount_type[${product_Variation_count}]" value="1" checked>
                                    <span class="custom-radio"></span>
                                    <span class="radio-label">Percentage</span>
                                </label>
                            </div>
                            <div class="check_radio">
                                <label class="radio-group">
                                    <input type="radio" id="discount_type_fixed_${product_Variation_count} name="discount_type[${product_Variation_count}]" value="2">
                                    <span class="custom-radio"></span>
                                    <span class="radio-label">Fixed Price</span>
                                </label>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Percentage</label>
                            </div>
                           <input type="number" class="form-control"  id="discount_value_${product_Variation_count}" placeholder="Eg.10%" name="discount_value[]">
                          <p class="text-danger" id="error-discount_value_${product_Variation_count}"></p>

                           </div>

                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Final Price</label>
                            </div>
                            <input type="number" class="form-control"  id="final_price_${product_Variation_count}" placeholder="Eg.KD 299.00" name="final_price[]">
                          <p class="text-danger" id="error-final_price_${product_Variation_count}"></p>

                         </div>

                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <div class="remove-btn removerow"><i class="bi bi-x"></i> Remove </div>
            </div>

        </div>

       `)
        var checked_category = $("input[name='category_id']:checked").val();
        if (checked_category) {
            remove_Not_in_women_Category(checked_category);
        }

        product_Variation_count++; // Update Product Quantity

    });

    // REMOVE ROW
    $(document).on("click", ".removerow", function() {
        $(this).closest(".variant-panel-bg").remove();
    });

    // When User select Again Category Then remove Error Message 
    function remove_Not_in_women_Category(val) {
        $('.text-danger').empty();
        if (val != '2') {
            $('.remove_Not_in_women_Category').hide();
        } else {
            $('.remove_Not_in_women_Category').show();
        }

    }

    //Category Wise Show sub-category data
    function catgoryFunction(val) {

        remove_Not_in_women_Category(val); // remove extra field in Product

        $.ajax({
            url: "{{ url('api/seller/sub-category?category_id=') }}" + val,
            type: "get",
            data: {
                "_token": "{{ csrf_token() }}",
                id: val
            },
            dataType: "json",
            beforeSend: function() {
                $('#loader').show()
            },
            success: function(data) {

                if (data.status == "success") {

                    var subcatgory_record = data.data;

                    var htmlcontent = ' <option value="">Select SubCategory</option>';

                    let selectedCategoryId = "{{ $product_details->subcategory_id }}";

                    subcatgory_record.forEach(function(item, val) {
                          let selected = (item.id == selectedCategoryId) ? "selected" : "";
                        htmlcontent +=
                            `<option value="${item.id}" ${selected} >${item.name_english} </option>`;
                    })

                    $('#getSubcategry').empty();
                    $('#getSubcategry').append(htmlcontent);


                } else {
                    toastr.error("<?php echo 'Unexpected_response_from_server'; ?>");
                }

                // setInterval(() => {
                //     window.location.reload();
                // }, 1000);


            },
            error: function() {
                alert("Fail")
            },
            complete: function() {
                // Hide loader (after success or error)
                $('#loader').hide();
            }

        })
    }

    // When user Submit From submit code Apply

    $(document).on('submit', 'form#editproduct', function(event) {
        event.preventDefault();
        $('p.error_container').html("");
        $("#file-error").html("");

        var form = $(this);
        var data = new FormData($(this)[0]);
        var url = form.attr("action");
        var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';

        $('.submit').attr('disabled', true);
        // $('.form-control').attr('readonly', true).addClass('disabled-link');
        $('.error-control').addClass('disabled-link');

        if ($('.submit').html() !== loadingText) {
            $('.submit').html(loadingText);
        }

        $.ajax({
            type: form.attr('method'),
            url: url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            // beforeSend: function() {
            //     // Show loader
            //     $('#loader').show();
            // },
            success: function(response) {
                console.log(response);

                window.setTimeout(function() {
                    $('.customBtn, .form-control').attr('disabled', false).removeClass(
                        'disabled-link');
                    $('.submit').html('Upload');
                }, 2000);

                if (response.status === 'success') {
                    toastr.success(response.message);

                    $('.submit').attr('disabled', true);
                    window.setTimeout(function() {
                        window.location = "{{ route('seller.products') }}";
                    }, 2000);
                }
            },
            error: function(xhr) {
                $('.text-danger').empty(); // Clear previous errors

                let errors = xhr.responseJSON.errors ?? xhr.responseJSON.data;

                $.each(errors, function(field, messages) {

                    // 1️⃣ Handle array fields with index → product_spe_en.0
                    if (field.includes(".")) {

                        let parts = field.split(".");
                        let fieldName = parts[0];
                        let index = parts[1];

                        // Example → #error-product_spe_en_0
                        $("#error-" + fieldName + "_" + index).html(messages[0]);

                    } else {

                        // 2️⃣ File special case
                        if (field === "file") {
                            $("#file-error").html(messages[0]);
                        }

                        // 3️⃣ Handle whole array errors (custom rule)
                        $("#error-" + field).html(messages[0]);
                    }
                });
            },
            // complete: function() {
            //     // Hide loader (after success or error)
            //     $('#loader').hide();
            // }




        });

        return false;
    });



    $(document).on('change', 'input[name="product_return"]', function() {
        let value = $(this).val();

        if (value == "1") {
            // YES → show return days
            $('input[name="return_days"]').closest('.row').show();
        } else {
            // NO → hide return days & clear value
            $('input[name="return_days"]').val('').closest('.row').hide();
        }
    });


    $(document).on('change', 'input[name="product_exchangable"]', function() {
        let value = $(this).val();

        if (value == "1") {
            // YES → show return days
            $('input[name="exchangable_days"]').closest('.row').show();
        } else {
            // NO → hide return days & clear value
            $('input[name="exchangable_days"]').val('').closest('.row').hide();
        }
    });

    // Remove Image from database get
    document.addEventListener("click", function(e) {
    if(e.target.classList.contains("remove-image")) {
        let imgDiv = e.target.closest("div.position-relative");
        imgDiv.remove();
    }
});




    // dynamic Price show after discount 
    // Listen for input changes
$(document).on("input change", 
    "input[id^='actual_price_'], input[id^='discount_value_'], input[type='radio'][name^='discount_type']",
    function () {

    let id = $(this).attr("id");
    let index = id.split("_").pop();

    let actualPrice = parseFloat($("#actual_price_" + index).val());
    let discountInput = $("#discount_value_" + index);
    let discountValue = parseFloat(discountInput.val());
    let discountType = $(`input[name='discount_type[${index}]']:checked`).val();

    // -----------------------------------------
    // 👉 RUN THIS VALIDATION ONLY IF TYPE = 1
    // -----------------------------------------
    if (discountType == "1") {  
        if (discountValue > 100) {
            discountInput.val(100);
            discountValue = 100;
        }
        if (discountValue < 0) {
            discountInput.val(0);
            discountValue = 0;
        }
    } else if (discountType == "2") {
        // Fixed price → cannot exceed actual price
        if (discountValue > actualPrice) {
            discountInput.val(actualPrice);
            discountValue = actualPrice;
        }
        if (discountValue < 0) {
            discountInput.val(0);
            discountValue = 0;
        }
    }
    // Type=2 (Fixed price) → No restriction
    // -----------------------------------------

    if (!actualPrice || !discountValue) {
        $("#final_price_" + index).val("");
        return;
    }

    let finalPrice = 0;

    // Percentage
    if (discountType == "1") {
        finalPrice = actualPrice - (actualPrice * (discountValue / 100));
    }

    // Fixed price
    if (discountType == "2") {
        finalPrice = actualPrice - discountValue;
    }

    if (finalPrice < 0) finalPrice = 0;

    $("#final_price_" + index).val(finalPrice.toFixed(2));
});



// Min value and Max greater then Input Field

$(document).on("input", "input[id^='min_card_quantity_'], input[id^='max_card_quantity_']", function () {

    // Get dynamic index from id
    let id = $(this).attr("id");                  // example: min_card_quantity_3
    let index = id.split("_").pop();              // "3"

    // Get values using dynamic IDs
    let minQty = parseInt($("#min_card_quantity_" + index).val()) || 0;
    let maxQty = parseInt($("#max_card_quantity_" + index).val()) || 0;

    // Clear previous errors
    $("#error-min_card_quantity_" + index).text("");
    $("#error-max_card_quantity_" + index).text("");

    // Validate only if both have values
    if (minQty > 0 && maxQty > 0) {

        // ❌ Min cannot be greater than Max
        if (minQty > maxQty) {
            $("#error-min_card_quantity_" + index).text(
                "Min quantity cannot be greater than max quantity"
            );
            $("#min_card_quantity_" + index).val(maxQty); // auto-fix
        }

        // ❌ Max cannot be less than Min
        if (maxQty < minQty) {
            $("#error-max_card_quantity_" + index).text(
                "Max quantity cannot be less than min quantity"
            );
            $("#max_card_quantity_" + index).val(minQty); // auto-fix
        }
    }
});



</script>


@include('dealer.layout.custom_code');
