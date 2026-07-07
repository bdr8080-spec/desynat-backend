@include('dealer.layout.header')
<style>
.upload-image {
    position: relative;
    z-index: 1;
    padding-bottom: 10px;
    margin-bottom: 15px;
    /* this prevents overlap */
}

#edit_uploadChart_preview {
    position: absolute;
    z-index: 0;
}
</style>

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <a href="{{ route('seller.products') }}" class="title24 alink">
            <i class="bi bi-chevron-left"></i> {{ __('seller_messages.add_new_product') }}
        </a>
    </div>

    <form id="addproduct" action="{{ route('seller.Add_product_code') }}" method="post">
        @csrf
        <div class="pt-3">
            <div class="title24">{{ __('seller_messages.select_category') }}</div>
            <div class="row">
                <div class="col-lg-6">
                    <div
                        class="group-radio-btn d-flex gap-4 align-items-center flex-wrap py-3 pe-3 justify-content-between">

                        @foreach ($category as $key => $item)
                        <div class="check_radio">
                            <label class="radio-group">
                                <input type="radio" name="category_id" value="{{ $item->id }}"
                                    onclick="catgoryFunction({{ $item->id }})" @if ($key==0) checked @endif>
                                <span class="custom-radio"></span>
                                <span class="radio-label">
                                    @if(app::getLocale()=='en')
                                    {{ $item->name }}</span>
                                @else
                                {{ $item->name_ar }}</span>
                                @endif


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
                        <label>{{ __('seller_messages.select_sub_category') }}</label>
                    </div>
                    <select class="form-select form-control" name="subcategory_id" aria-label="Default select example"
                        id="getSubcategry">

                    </select>
                    <p class="text-danger" id="error-subcategory_id"></p>
                </div>
                <div class="sub-form" id="other-field0" style="display:none;">
                    <div class="label-flex">
                        <label>{{ __('seller_messages.other') }}</label>
                        <span>{{ __('seller_messages.in_english') }}</span>
                    </div>
                    <input type="text" oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')"
                        class="form-control" placeholder="{{ __('seller_messages.enter_brand_name') }}" name="other_en">
                    <p class="text-danger" id="error-other_en"></p>
                </div>


                <div class="sub-form">
                    <div class="label-flex">
                        <label>{{ __('seller_messages.product_name') }}</label>
                        <span>{{ __('seller_messages.in_english') }}</span>
                    </div>
                    <input type="text" oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')"
                        class="form-control" placeholder="{{ __('seller_messages.enter_product_name') }}"
                        name="product_name_en">
                    <p class="text-danger" id="error-product_name_en"></p>
                </div>
                <div class="sub-form">
                    <div class="label-flex">
                        <label>{{ __('seller_messages.description') }}</label>
                        <span>{{ __('seller_messages.in_english') }}</span>
                    </div>
                    <textarea rows="4" oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')"
                        placeholder="{{ __('seller_messages.write_here') }}" class="form-control"
                        name="description_en"></textarea>

                    <p class="text-danger" id="error-description_en"></p>
                </div>
                <div class="sub-form">
                    <div class="label-flex">
                        <label>{{ __('seller_messages.select_delivery_time') }}</label>
                    </div>

                    <select class="form-select form-control" name="delivery_time_id" id="delivery_time_id">
                        <option value="">{{ __('seller_messages.select_delivery_time') }}</option>

                        @foreach($delivery_time as $item)
                            <option value="{{ $item->id }}"
                                {{ old('delivery_time_id', session('product.delivery_time_id')) == $item->id ? 'selected' : '' }}>
                                {{ app()->getLocale() == 'ar' ? $item->name_ar : $item->name }}
                            </option>
                        @endforeach
                    </select>

                    <p class="text-danger" id="error-delivery_time_id"></p>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>{{ __('seller_messages.select_brand') }}</label>
                    </div>
                    <select class="form-select form-control" aria-label="Default select example" id="brand_id"
                        name="brand_id">

                        <option value="">{{ __('seller_messages.select_brand') }}</option>

                        @foreach ($brand as $item)
                        <option value="{{ $item->id }}">
                            @if(app::getLocale()=='en')
                            {{ $item->name_english }}</span>
                            @else
                            {{ $item->name_arabic }}</span>
                            @endif
                        </option>
                        @endforeach

                    </select>
                    <p class="text-danger" id="error-brand_id"></p>
                </div>
                <div class="sub-form " id="other-field1" style="display:none;">
                    <div class="label-flex">
                        <label>{{ __('seller_messages.other') }}</label>
                        <span>{{ __('seller_messages.in_arabic') }}</span>
                    </div>
                    <input type="text"
                        oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')"
                        class="form-control" placeholder="{{ __('seller_messages.enter_brand_name') }}" name="other_ar">

                    <p class="text-danger" id="error-other_ar"></p>
                </div>
                <div class="sub-form">
                    <div class="label-flex">
                        <label>{{ __('seller_messages.product_name') }}</label>
                        <span>{{ __('seller_messages.in_arabic') }}</span>
                    </div>
                    <input type="text"
                        oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')"
                        class="form-control" placeholder="{{ __('seller_messages.enter_product_name') }}"
                        name="product_name_ar">

                    <p class="text-danger" id="error-product_name_ar"></p>
                </div>
                <div class="sub-form">
                    <div class="label-flex">
                        <label>{{ __('seller_messages.description') }}</label>
                        <span>{{ __('seller_messages.in_arabic') }}</span>
                    </div>
                    <textarea rows="4"
                        oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')"
                        placeholder="{{ __('seller_messages.write_here') }}" class="form-control"
                        name="description_ar"></textarea>
                    <p class="text-danger" id="error-description_ar"></p>

                </div>
            </div>
        </div>

        <div class="mt-3 d-flex justify-content-between py-3">
            <div class="title24">{{ __('seller_messages.specifications') }}</div>
            <div class="sep-icon" id="addmore">
                <img src="{{ asset('/dealer') }}/assets/img/add.svg" alt="add">
            </div>
        </div>
        <div class="specifications-pnl">
            <div class="append-panel">
                <div class="specifications-row">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>{{ __('seller_messages.name') }}</label>
                                    <span>{{ __('seller_messages.in_english') }}</span>
                                </div>
                                <input type="text"
                                    oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')"
                                    class="form-control" placeholder="{{ __('seller_messages.enter_product_name') }}"
                                    value="" name="product_spe_en[]">

                                <p id="error-product_spe_en_0" class="text-danger"></p>

                            </div>


                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="append-flex">
                                <div class="sub-form">
                                    <div class="label-flex">
                                        <label>{{ __('seller_messages.name') }}</label>
                                        <span>{{ __('seller_messages.in_arabic') }}</span>

                                    </div>
                                    <input type="text"
                                        oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')"
                                        class="form-control"
                                        placeholder="{{ __('seller_messages.enter_product_name') }}"
                                        name="product_spe_ar[]" value="">
                                    <p class="text-danger" id="error-product_spe_ar_0"></p>

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>{{ __('seller_messages.feature') }}</label>
                                    <span>{{ __('seller_messages.in_english') }}</span>

                                </div>
                                <input type="text"
                                    oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')"
                                    class="form-control" placeholder="{{ __('seller_messages.enter_product_feature') }}"
                                    name="product_spe_feature_en[]" value="">
                                <p class="text-danger" id="error-product_spe_feature_en_0"></p>

                            </div>

                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="append-flex">
                                <div class="sub-form">
                                    <div class="label-flex">
                                        <label>{{ __('seller_messages.feature') }}</label>
                                        <span>{{ __('seller_messages.in_arabic') }}</span>

                                    </div>
                                    <input type="text"
                                        oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')"
                                        class="form-control"
                                        placeholder="{{ __('seller_messages.enter_product_feature') }}"
                                        name="product_spe_feature_ar[]" value="">
                                    <p class="text-danger" id="error-product_spe_feature_ar_0"></p>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!----- variant panel ------>
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="sub-form product-row">
                    <div class="label-flex">
                        <label>{{ __('seller_messages.colour') }}</label>
                    </div>

                    <select class="form-select form-control color-select" aria-label="Default select example"
                        name="color_id[]" rel="0">
                        <option value="">{{ __('seller_messages.select_colour') }}</option>
                        @foreach ($color as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-danger" id="error-color_id_0"></p>
                </div>
            </div>
        </div>

        <div class="variant-panel">

            <div class="product-pnls mt-4" id="variant_image_id0">
                <div class="upload-image" style="height:170px;">
                    <label id="uploadLabel" style="cursor:pointer;text-align:center;display:block;padding-top:2.5rem;">
                        <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg" style="width:70px">
                        <div class="mt-3" style="color:#875C3A">{{ __('seller_messages.upload_product_images') }}</div>
                        <input type="file" aaccept="image/*,video/*" multiple id="edit_imageUpload" style="opacity:0;"
                            name="variant_image[0][]" rel="0">
                    </label>

                    {{-- <p class="text-danger" id="error-variant_image"></p> --}}
                    <p class="text-danger" id="error-variant_image_0"></p>

                </div>

                <div class="product-multiple d-flex flex-wrap gap-2" id="previewContainer0"></div>
            </div>

            {{-- Add New Variationc code --}}
            <div class="mt-3 d-flex justify-content-between py-3">
                <div class="title24">{{ __('seller_messages.add_variation') }} </div>
                <div class="sep-icon " rel="0">
                    <img src="{{ asset('/dealer') }}/assets/img/add.svg" class="addmoreVariation" alt="add" rel="0">
                </div>
            </div>
            {{-- Add New Variationc code --}}


            <div class="inside_variation0 subvariant variant-panel-bg">

                <div class="wapper-header mt-2">
                    <div class="row price-block">

                        <div class="col-lg-3">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>{{ __('seller_messages.size') }}</label>
                                </div>

                                <select class="form-select form-control" aria-label="Default select example"
                                    name="size_id[0][]">
                                    <option value="">{{ __('seller_messages.select_size') }}</option>
                                    @foreach ($size as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger" id="error-size_id_0"></p>
                                <p class="text-danger" id="error-size_id_0_0"></p>

                            </div>

                        </div>

                        <div class="col-lg-3 remove_Not_in_women_Category">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>{{ __('seller_messages.bust') }}</label>
                                </div>
                                <input type="number" class="form-control notapplyspace no-zero" placeholder="Eg.10"
                                    name="bust[0][]">
                                <p class="text-danger" id="error-bust_0_0"></p>

                            </div>

                        </div>
                        <div class="col-lg-3 remove_Not_in_women_Category">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>{{ __('seller_messages.waist') }}</label>
                                </div>
                                <input type="number" class="form-control notapplyspace no-zero" placeholder="Eg.12"
                                    name="waist[0][]">

                                <p class="text-danger" id="error-waist_0_0"></p>
                            </div>

                        </div>
                        <div class="col-lg-3 remove_Not_in_women_Category">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>{{ __('seller_messages.hip') }}</label>
                                </div>
                                <input type="number" class="form-control notapplyspace no-zero" placeholder="Eg.14"
                                    name="hip[0][]">
                                <p class="text-danger" id="error-hip_0_0"></p>

                            </div>

                        </div>
                        <div class="col-lg-3 remove_Not_in_women_Category">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>{{ __('seller_messages.shoulder') }}</label>
                                </div>
                                <input type="number" class="form-control notapplyspace no-zero" placeholder="Eg.16"
                                    name="shoulder[0][]">
                                <p class="text-danger" id="error-shoulder_0_0"></p>

                            </div>

                        </div>
                        <div class="col-lg-3 remove_Not_in_women_Category">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>{{ __('seller_messages.sleeve_length') }}</label>
                                </div>
                                <input type="number" class="form-control notapplyspace no-zero" placeholder="Eg.18"
                                    name="sleeve_length[0][]">
                                <p class="text-danger" id="error-sleeve_length_0_0"></p>

                            </div>

                        </div>
                        <div class="col-lg-3 remove_Not_in_women_Category">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>{{ __('seller_messages.length') }}</label>
                                </div>
                                <input type="number" class="form-control notapplyspace no-zero" placeholder="Eg.20"
                                    name="length[0][]">

                                <p class="text-danger" id="error-length_0_0"></p>
                            </div>

                        </div>
                        <div class="col-lg-3">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>{{ __('seller_messages.total_stocks') }}</label>
                                </div>
                                <input type="number" class="form-control notapplyspace" placeholder="Eg.13208"
                                    name="total_stock[0][]">

                                <p class="text-danger" id="error-total_stock_0_0"></p>
                            </div>

                        </div>
                        <div class="col-lg-3">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>{{ __('seller_messages.sku_limit') }}</label>
                                </div>
                                <input type="number" class="form-control notapplyspace" placeholder="20019"
                                    name="sku[0][]">

                                <p class="text-danger" id="error-sku_0"></p>
                                <p class="text-danger" id="error-sku_0_0"></p>
                            </div>

                        </div>
                        {{-- <div class="col-lg-3">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>SKU Threshold value</label>
                            </div>
                            <input type="number" class="form-control notapplyspace" placeholder="20019"
                                name="sku_threshold_value[]">
                            <p class="text-danger" id="error-sku_threshold_value_0"></p>

                        </div>

                    </div> --}}

                        <div class="col-lg-3">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>{{ __('seller_messages.actual_price') }}</label>
                                </div>
                                <input type="number" class="form-control notapplyspace" placeholder="Eg. 299.00 KD"
                                    name="actual_price[0][]" id="actualprice_0_0">
                                <p class="text-danger" id="error-actual_price_0_0"></p>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="pt-3">
                    <div class="title24">{{ __('seller_messages.discounted_price') }}</div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div
                                class="group-radio-btn d-flex gap-4 align-items-center flex-wrap py-3 justify-content-between">
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="discount_type[0][0]" id="discount_type_percentage_0_0"
                                            checked value="1">
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">{{ __('seller_messages.percentage') }}</span>
                                    </label>
                                </div>
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="discount_type[0][0]" id="discount_type_fixed_0_0"
                                            value="2">
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">{{ __('seller_messages.fixed_price') }}</span>
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">


                        <div class="col-lg-6 col-md-6">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>{{ __('seller_messages.percentage') }}</label>
                                </div>
                                <input type="number" class="form-control notapplyspace" placeholder="Eg.10%"
                                    name="discount_value[0][]" id="discount_value_0_0">
                                <p class="text-danger" id="error-discount_value_0"></p>

                            </div>

                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>{{ __('seller_messages.final_price') }}</label>
                                </div>
                                <input type="number" class="form-control notapplyspace" placeholder="Eg. 299.00 KD"
                                    name="final_price[0][]" id="final_price_0_0">
                                <p class="text-danger" id="error-final_price_0_0"></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-----End variant panel ------>

        <div class="row py-3 mt-4">
            <div class="col-lg-12 col-md-12">
                <button type="button"
                    class="btn cancel-outline w-100 addVariantBtn">{{ __('seller_messages.add_another_variant') }}</button>
            </div>
        </div>

        <div class="pt-3">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="sub-form">
                        <div class="label-flex">
                            <label>{{ __('seller_messages.min_cart_quantity') }}</label>
                        </div>
                        <input type="number" class="form-control notapplyspace" placeholder="Eg.20"
                            name="min_card_quantity" id="min_card_quantity_0">
                        <p class="text-danger" id="error-min_card_quantity"></p>
                        <p class="text-danger" id="error-min_card_quantity_0"></p>

                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="sub-form">
                        <div class="label-flex">
                            <label>{{ __('seller_messages.max_cart_quantity') }}</label>
                        </div>
                        <input type="number" class="form-control notapplyspace" placeholder="Eg.20"
                            name="max_card_quantity" id="max_card_quantity_0">
                        <p class="text-danger" id="error-max_card_quantity"></p>
                        <p class="text-danger" id="error-max_card_quantity_0"></p>

                    </div>
                </div>
            </div>
        </div>


        <div class="pt-3">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="title24"> {{ __('seller_messages.product_returnable') }}</div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div
                                class="group-radio-btn d-flex gap-4 align-items-center flex-wrap py-3 justify-content-between">
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="product_return" checked value='1'>
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">{{ __('seller_messages.yes') }}</span>
                                    </label>
                                </div>
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="product_return" value='0'>
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">{{ __('seller_messages.no') }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>{{ __('seller_messages.return_days') }} </label>
                                </div>
                                <input type="number" class="form-control" placeholder="Eg.KD 299.00" name="return_days">
                                <p class="text-danger" id="error-return_days"></p>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="title24"> {{ __('seller_messages.product_exchangeable') }}</div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div
                                class="group-radio-btn d-flex gap-4 align-items-center flex-wrap py-3 justify-content-between">
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="product_exchangable" checked value="1">
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">{{ __('seller_messages.yes') }}</span>
                                    </label>
                                </div>
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="product_exchangable" value="0">
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">{{ __('seller_messages.no') }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label> {{ __('seller_messages.product_exchangeable') }}</label>
                                </div>
                                <input type="number" class="form-control" placeholder="Eg.15 days"
                                    name="exchangable_days">
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
                    <div class="title24">{{ __('seller_messages.review_rating_allowed') }} </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div
                                class="group-radio-btn d-flex gap-4 align-items-center flex-wrap py-3 justify-content-between">
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="review_rating" value="1" checked>
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">{{ __('seller_messages.yes') }}</span>
                                    </label>
                                </div>
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="review_rating" value="0">
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">{{ __('seller_messages.no') }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="title24">{{ __('seller_messages.affiliated_product') }}</div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div
                                class="group-radio-btn d-flex gap-4 align-items-center flex-wrap py-3 justify-content-between">
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="affiliated_product" checked value="1">
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">{{ __('seller_messages.yes') }}</span>
                                    </label>
                                </div>
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="affiliated_product" value="0">
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">{{ __('seller_messages.no') }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="affiliated_commissionId" style="display:none">
                        <div class="col-lg-12 col-md-12">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>{{ __('seller_messages.affiliated_commission') }}</label>
                                </div>
                                <input type="number" class="form-control" placeholder="Eg.0 to 100"
                                    name="affiliated_commission" max="100" min="0" value="10">
                                <p class="text-danger" id="error-affiliated_commission"></p>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="title24">{{ __('seller_messages.customized_product') }} </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div
                                class="group-radio-btn d-flex gap-4 align-items-center flex-wrap py-3 justify-content-between">
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="customized_product" checked value="1">
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">{{ __('seller_messages.yes') }}</span>
                                    </label>
                                </div>
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="customized_product" value="0">
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">{{ __('seller_messages.no') }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="title24">{{ __('seller_messages.ready_to_ship') }}</div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div
                                class="group-radio-btn d-flex gap-4 align-items-center flex-wrap py-3 justify-content-between">
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="ready_to_ship" checked value="1">
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">{{ __('seller_messages.yes') }}</span>
                                    </label>
                                </div>
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="ready_to_ship" value="0">
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">{{ __('seller_messages.no') }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="title24"> {{ __('seller_messages.cash_on_delivery') }}</div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div
                                class="group-radio-btn d-flex gap-4 align-items-center flex-wrap py-3 justify-content-between">
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="cash_on_delivery" checked value="1">
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">{{ __('seller_messages.yes') }}</span>
                                    </label>
                                </div>
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="cash_on_delivery" value="0">
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">{{ __('seller_messages.no') }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="title24">{{ __('seller_messages.upload_size_chart') }}</div>
        <div class="product-pnls mt-4">
            <div class="upload-image" style="height:170px;width: 270px;">
                <label id="uploadLabel" style="cursor:pointer;text-align:center;display:block;">
                    <img id="placeholderImg" src="{{ asset('/dealer') }}/assets/img/upload-icon.svg"
                        style="width:70px;object-fit:cover; border-radius:6px;padding-top:2rem;">

                    <img id="uploadedImg" src=""
                        style="width:100px; display:none; object-fit:cover; border-radius:6px;object-fit:cover; height: 110px;">

                    <div class="py-2" style="color:#875C3A">{{ __('seller_messages.upload_size_chart') }}</div>
                    <input type="file" accept="image/*" multiple id="edit_uploadChart" style="opacity:0;"
                        name="upload_size_chart">
                    <p class="text-danger" id="error-upload_size_chart"></p>
                </label>

                <div class="product-multiple d-flex flex-wrap gap-2" id="edit_uploadChart_preview"></div>
            </div>

        </div>


        <div class="dashboard-button d-flex mt-5 gap-5">
            <button type="button" class="btn cancel-outline w-100"
                onclick="location.href='{{ route('seller.products') }}'">{{ __('seller_messages.cancel') }}</button>
            <button type="submit" class="btn add-fillbtn w-100">{{ __('seller_messages.add_product') }}</button>
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


$(document).on('change', 'input[type="file"][name^="variant_image"]', function(e) {});


// Store files for each variant input
let fileStore = {};

$(document).on('change', 'input[type="file"][name^="variant_image"]', function (e) {

    let rel = $(this).attr('rel');

    if (!fileStore[rel]) {
        fileStore[rel] = new DataTransfer();
    }

    let dt = fileStore[rel];
    let files = e.target.files;

    [...files].forEach(f => {

        console.log('File Name:', f.name);
        console.log('File Type:', f.type);

        // Add file to DataTransfer
        dt.items.add(f);

        let url = URL.createObjectURL(f);

        let previewContent = '';

        // IMAGE PREVIEW
        if (f.type.startsWith('image/')) {

            previewContent = `
                <img src="${url}"
                     class="w-100 rounded"
                     style="height:150px;width:150px;object-fit:cover;">
            `;

        }

        // VIDEO PREVIEW
        else if (f.type.startsWith('video/')) {

            previewContent = `
                <video controls
                       muted
                       preload="metadata"
                       class="rounded"
                       style="height:150px;width:150px;">
                    <source src="${url}" type="${f.type}">
                    Your browser does not support the video tag.
                </video>
            `;
        }

        let mediaBox = $(`
            <div class="multiple-img position-relative"
                 data-name="${f.name}"
                 style="width:150px;height:150px;">
                 
                ${previewContent}

                <span class="remove-ic"
                      style="position:absolute;
                             top:0;
                             right:5px;
                             cursor:pointer;
                             font-size:20px;
                             color:red;
                             z-index:999;">
                    &times;
                </span>
            </div>
        `);

        mediaBox.find('.remove-ic').click(function () {

            let filename = mediaBox.data('name');

            for (let i = 0; i < dt.items.length; i++) {

                if (dt.items[i].getAsFile().name === filename) {

                    dt.items.remove(i);
                    break;
                }
            }

            document.querySelector(`input[rel="${rel}"]`).files = dt.files;

            mediaBox.remove();
        });

        $('#previewContainer' + rel).append(mediaBox);

        $('#error-variant_image_' + rel).empty();

    });

    this.files = dt.files;
});

// Upload Chart Image in footer side

$('#edit_uploadChart').on('change', e => {
    let files = e.target.files;
    $('#edit_uploadChart_preview').empty(); // clear old previews
    [...files].forEach(f => {
        let url = URL.createObjectURL(f);
        let imgBox = $(`
      <div class="position-relative">
        <img src="${url}" class="w-100 rounded">
        <span class="remove-ic" style="position:absolute;top:0;right:5px;cursor:pointer;font-size:20px;color:red;">&times;</span>
      </div>
    `);
        imgBox.find('.remove-ic').click(() => imgBox.remove());
        $('#edit_uploadChart_preview').append(imgBox);

        $('#error-upload_size_chart').empty();


    });
});

// Upload Chart Image in footer side

</script>

<script>
// ADD NEW ROW In specification

var specification_count = 1;

$("#addmore").click(function() {

    $(".append-panel").append(`

       <div class="specifications-row">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>{{ __('seller_messages.name') }}</label>
                        <span>{{ __('seller_messages.in_english') }}</span>
                    </div>
                    <input type="text" class="form-control" placeholder="{{ __('seller_messages.enter_product_name') }}" name="product_spe_en[]" value="">
                <p class="text-danger" id="error-product_spe_en_${specification_count}"></p>

             </div>
               
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="append-flex">
                    <div class="sub-form">
                        <div class="label-flex">
                            <label>{{ __('seller_messages.name') }}</label>
                            <span>{{ __('seller_messages.in_arabic') }}</span>
                        </div>
                        <input type="text" class="form-control" placeholder="{{ __('seller_messages.enter_product_name') }}" name="product_spe_ar[]" value="">
                    <p class="text-danger" id="error-product_spe_ar_${specification_count}"></p>

                        </div>
                  
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>{{ __('seller_messages.feature') }}</label>
                        <span>{{ __('seller_messages.in_english') }}</span>
                    </div>
                    <input type="text" class="form-control" placeholder="{{ __('seller_messages.enter_product_feature') }}" name="product_spe_feature_en[]" value="">
                <p class="text-danger" id="error-product_spe_feature_en_${specification_count}"></p>
           
                    </div>
             </div>
            <div class="col-lg-6 col-md-6">
                <div class="append-flex">
                    <div class="sub-form">
                        <div class="label-flex">
                            <label>{{ __('seller_messages.feature') }}</label>
                            <span>{{ __('seller_messages.in_arabic') }}</span>
                        </div>
                        <input type="text" class="form-control" placeholder="{{ __('seller_messages.enter_product_feature') }}" name="product_spe_feature_ar[]" value="">
                    <p class="text-danger" id="error-product_spe_feature_ar_${specification_count}"></p>

                        </div>
                 
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <div class="remove-btn"><i class="bi bi-x"></i> {{ __('seller_messages.remove') }} </div>
        </div>
        </div>
       `)
    specification_count++;

});

// REMOVE ROW
$(document).on("click", ".remove-btn", function() {
    $(this).closest(".specifications-row").remove();

    refreshSpecificationIndexes();
});

// remove After refresh error code 
function refreshSpecificationIndexes() {
    $(".specifications-row").each(function(index) {

        $(this).find("p[id^='error-product_spe_en_']")
            .attr("id", "error-product_spe_en_" + index);

        $(this).find("p[id^='error-product_spe_ar_']")
            .attr("id", "error-product_spe_ar_" + index);

        $(this).find("p[id^='error-product_spe_feature_en_']")
            .attr("id", "error-product_spe_feature_en_" + index);

        $(this).find("p[id^='error-product_spe_feature_ar_']")
            .attr("id", "error-product_spe_feature_ar_" + index);
    });

    // update global counter
    specification_count = $(".specifications-row").length;
}
</script>







<script>
// ADD NEW ROWs In product Variation Section

var product_Variation_count = 1;

// ADD NEW Variant
$(".addVariantBtn").click(function() {
    $(".variant-panel").append(`
        <div class="variant-panel-bg">
            <div class="product-pnls mt-4"  id="variant_image_id${product_Variation_count}">
                <div class="upload-image" style="height:170px;">
                    <label id="uploadLabel" style="cursor:pointer;text-align:center;display:block;padding-top:2.5rem;">
                        <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg">
                        <div class="mt-3">{{ __('seller_messages.upload_product_images') }}</div>
                        <input type="file" accept="image/*" multiple name="variant_image[${product_Variation_count}][]" style="opacity:0;" rel="${product_Variation_count}">
                    </label>

                    <p class="text-danger" id="error-variant_image_${product_Variation_count}"></p>

                </div>

                <div class="product-multiple d-flex flex-wrap gap-2 mt-2" id="previewContainer${product_Variation_count}"></div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="sub-form product-row">
                        <div class="label-flex">
                            <label>{{ __('seller_messages.colour') }}</label>
                        </div>
                        <select class="form-select form-control color-select" aria-label="Default select example" name="color_id[]" rel="${product_Variation_count}">
                            <option value="">{{ __('seller_messages.select_colour') }}</option>
                            @foreach ($color as $item)
                                <option value="{{ $item->id }}"">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-danger" id="error-color_id_${product_Variation_count}"></p>
                    </div>
                </div>
            </div>

            
                  {{-- Add New Variationc code --}}
             <div class="mt-3 d-flex justify-content-between py-2 align-items-center">
            <div class="title24">{{ __('seller_messages.add_variation') }}  </div>
            <div class="sep-icon" rel="${product_Variation_count}">
                <img src="{{ asset('/dealer') }}/assets/img/add.svg" class="addmoreVariation" alt="add" rel="${product_Variation_count}">
            </div>
           </div>
            {{-- Add New Variationc code --}}

            <div class="inside_variation">

            <div class="wapper-header mt-2">
                <div class="row">
            
                <div class="col-lg-3">
                    <div class="sub-form">
                        <div class="label-flex">
                            <label>{{ __('seller_messages.size') }}</label>
                        </div>

                        <select class="form-select form-control" aria-label="Default select example" name="size_id[${product_Variation_count}][]">
                               <option value="">{{ __('seller_messages.select_size') }}</option>
                           
                            @foreach ($size as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                      <p class="text-danger" id="error-size_id_${product_Variation_count}_0"></p>
                 <p class="text-danger" id="error-size_id_${product_Variation_count}"></p>

                        </div>
                   
                </div>


              
                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>{{ __('seller_messages.bust') }}</label>
                            </div>
                            <input type="number" class="form-control no-zero" placeholder="Eg.10" name="bust[${product_Variation_count}][]">
                          <p class="text-danger" id="error-bust_${product_Variation_count}_0"></p>

                            </div>

                    </div>
                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>{{ __('seller_messages.waist') }}</label>
                            </div>
                            <input type="number" class="form-control no-zero" placeholder="Eg.12" name="waist[${product_Variation_count}][]">
                          <p class="text-danger" id="error-waist_${product_Variation_count}_0"></p>

                   </div>

                    </div>
                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>{{ __('seller_messages.hip') }}</label>
                            </div>
                            <input type="number" class="form-control no-zero" placeholder="Eg.14" name="hip[${product_Variation_count}][]">
                          <p class="text-danger" id="error-hip_${product_Variation_count}_0"></p>

                            </div>                        
                    </div>

                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>{{ __('seller_messages.shoulder') }}</label>
                            </div>
                            <input type="number" class="form-control no-zero" placeholder="Eg.16" name="shoulder[${product_Variation_count}][]">
                          <p class="text-danger" id="error-shoulder_${product_Variation_count}_0"></p>

                            </div>

                    </div>

                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>{{ __('seller_messages.sleeve_length') }}</label>
                            </div>
                            <input type="number" class="form-control no-zero" placeholder="Eg.18" name="sleeve_length[${product_Variation_count}][]">
                          <p class="text-danger" id="error-sleeve_length_${product_Variation_count}_0"></p>

                            </div>

                    </div>
                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>{{ __('seller_messages.length') }}</label>
                            </div>
                            <input type="number" class="form-control no-zero" placeholder="Eg.20" name="length[${product_Variation_count}][]" >
                          <p class="text-danger" id="error-length_${product_Variation_count}_0"></p>

                            </div>

                    </div>
                    <div class="col-lg-3">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>{{ __('seller_messages.total_stocks') }}</label>
                            </div>
                            <input type="number" class="form-control" placeholder="Eg.13208" name="total_stock[${product_Variation_count}][]" >
                          <p class="text-danger" id="error-total_stock_${product_Variation_count}_0"></p>

                            </div>

                    </div>
                    <div class="col-lg-3">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>{{ __('seller_messages.sku_limit') }} </label>
                            </div>
                            <input type="number" class="form-control" placeholder="20019" name="sku[${product_Variation_count}][]">
                          <p class="text-danger" id="error-sku_${product_Variation_count}"></p>
                          <p class="text-danger" id="error-sku_${product_Variation_count}_0"></p>

                            </div>

                    </div>
                 
                  
                    <div class="col-lg-3">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>{{ __('seller_messages.actual_price') }}</label>
                            </div>
                        <input type="number"  id="actualprice_${product_Variation_count}_0" class="form-control" placeholder="Eg.299.00 KD" name="actual_price[${product_Variation_count}][]">
                          <p class="text-danger" id="error-actual_price_${product_Variation_count}_0"></p>

                            </div>
                        
                    </div>
                </div>


            <div class="pt-3">
                <div class="title24">{{ __('seller_messages.discounted_price') }}</div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="group-radio-btn d-flex gap-4 align-items-center flex-wrap py-3 justify-content-between">
                            <div class="check_radio">
                                <label class="radio-group">
                                    <input type="radio" id="discount_type_percentage_${product_Variation_count}_0" name="discount_type[${product_Variation_count}][0]" value="1" checked>
                                    <span class="custom-radio"></span>
                                    <span class="radio-label">{{ __('seller_messages.percentage') }}</span>
                                </label>
                            </div>
                            <div class="check_radio">
                                <label class="radio-group">
                                    <input type="radio" id="discount_type_fixed_${product_Variation_count}_0" name="discount_type[${product_Variation_count}][0]" value="2">
                                    <span class="custom-radio"></span>
                                    <span class="radio-label">{{ __('seller_messages.fixed_price') }}</span>
                                </label>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>{{ __('seller_messages.percentage') }}</label>
                            </div>
                           <input type="number" id="discount_value_${product_Variation_count}_0" class="form-control" placeholder="Eg.10%" name="discount_value[${product_Variation_count}][]">
                          <p class="text-danger" id="error-discount_value_${product_Variation_count}_0"></p>

                           </div>

                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>{{ __('seller_messages.final_price') }}</label>
                            </div>
                            <input type="text" id="final_price_${product_Variation_count}_0" class="form-control" placeholder="Eg.KD 299.00" name="final_price[${product_Variation_count}][]">
                          <p class="text-danger" id="error-final_price_${product_Variation_count}_0"></p>
                         </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <div class="remove-btn removerow"><i class="bi bi-x"></i> {{ __('seller_messages.remove') }} </div>
            </div>

            </div>
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

    refreshVariantIndexes();

});

// refresh variation code 
function refreshVariantIndexes() {

    $(".variant-panel-bg").each(function(variantIndex) {

        // IMAGE SECTION
        $(this).find(".product-pnls")
            .attr("id", "variant_image_id" + variantIndex);

        $(this).find("input[type='file']")
            .attr("name", `variant_image[${variantIndex}][]`)
            .attr("rel", variantIndex);

        $(this).find("[id^='error-variant_image_']")
            .attr("id", "error-variant_image_" + variantIndex);

        $(this).find("[id^='previewContainer']")
            .attr("id", "previewContainer" + variantIndex);


        // UPDATE addmoreVariation REL
        $(this).find(".addmoreVariation")
            .attr("rel", variantIndex);

        // 🔹 UPDATE PRICE FIELD IDS
        $(this).find("[id^='actualprice_']")
            .attr("id", `actualprice_${variantIndex}_0`);

        $(this).find("[id^='discount_value_']")
            .attr("id", `discount_value_${variantIndex}_0`);

        $(this).find("[id^='final_price_']")
            .attr("id", `final_price_${variantIndex}_0`);


        // COLOR
        $(this).find("select[name='color_id[]']")
            .attr("rel", variantIndex);

        $(this).find("[id^='error-color_id_']")
            .attr("id", "error-color_id_" + variantIndex);

        // ALL INPUTS WITH ARRAY INDEX
        $(this).find("input, select").each(function() {

            let name = $(this).attr("name");
            if (!name) return;

            name = name.replace(/\[\d+\]/, `[${variantIndex}]`);
            $(this).attr("name", name);
        });

        // ERROR MESSAGE IDS
        $(this).find("p[id^='error-']").each(function() {
            let newId = $(this).attr("id")
                .replace(/\_\d+(\_\d+)?$/, `_${variantIndex}_0`);
            $(this).attr("id", newId);
        });

        // DISCOUNT RADIO BUTTONS
        $(this).find("input[type='radio']").each(function() {
            let id = $(this).attr("id");
            if (id) {
                id = id.replace(/\_\d+\_\d+$/, `_${variantIndex}_0`);
                $(this).attr("id", id);
            }

            let name = $(this).attr("name");
            if (name) {
                name = name.replace(/\[\d+\]\[\d+\]/, `[${variantIndex}][0]`);
                $(this).attr("name", name);
            }
        });

    });

    // RESET GLOBAL COUNT
    product_Variation_count = $(".variant-panel-bg").length - 1;


    console.log(product_Variation_count);
}



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
        headers: {
            'Accept-Language': "{{ app()->getLocale() }}"
            // returns 'en' or 'ar'
        },
        beforeSend: function() {
            $('#loader').show()
        },
        success: function(data) {

            if (data.status == "success") {

                var subcatgory_record = data.data;

                // var htmlcontent = " <option value="
                // ">{{ __('seller_messages.Select_Sub_Category') }}</option>";
                var htmlcontent = `<option value="">{{ __('seller_messages.select_sub_category') }}</option>`;

                subcatgory_record.forEach(function(item, val) {
                    htmlcontent +=
                        `<option value="${item.id}">
                        
                        @if(App::getLocale()=='en')
                        ${item.name_english} 
                        @else 
                            ${item.name_arabic} 

                        @endif
                        
                        </option>`;
                })

                console.log(htmlcontent);

                $('#getSubcategry').empty();
                $('#getSubcategry').append(htmlcontent);
                console.log($('#getSubcategry').html());


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

$(document).on('submit', 'form#addproduct', function(event) {
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
        beforeSend: function() {
            //     // Show loader
            $('#loader').show();
        },
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

            if (xhr.status == '400') {
                toastr.error(xhr.responseJSON.message)
            }

            $('.text-danger').empty(); // Clear previous errors

            let errors = xhr.responseJSON.errors ?? xhr.responseJSON.data;

            $.each(errors, function(field, messages) {

                // 1️⃣ Handle array fields with index → product_spe_en.0
                if (field.includes(".")) {

                    let parts = field.split(".");
                    let fieldName = parts[0];
                    let index = parts[1];
                    let index1 = parts[2];


                    // Example → #error-product_spe_en_0

                    let errorId = "#error-" + fieldName + "_" + index;

                    // If second index exists, append it
                    if (typeof index1 !== "undefined" && index1 !== "") {
                        errorId += "_" + index1;
                    }
                    $(errorId).html(messages[0]);


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
        complete: function() {
            // Hide loader (after success or error)
            $('#loader').hide();
        }


    });

    return false;
});



$(document).on('change', 'input[name="product_return"]', function() {
    let value = $(this).val();

    if (value == "1") {
        // YES → show return days
        $('input[name="return_days"]').closest('.row').show();
        $('input[name="return_days"]').val('').closest('.row').removeClass('none_main');

    } else {
        // NO → hide return days & clear value
        $('input[name="return_days"]').val('').closest('.row').addClass('none_main');
    }
});


$(document).on('change', 'input[name="product_exchangable"]', function() {
    let value = $(this).val();

    if (value == "1") {
        // YES → show return days
        $('input[name="exchangable_days"]').closest('.row').show();
        $('input[name="exchangable_days"]').val('').closest('.row').removeClass('none_main');

    } else {
        // NO → hide return days & clear value
        $('input[name="exchangable_days"]').val('').closest('.row').addClass('none_main');
    }
});


$(document).on('change', 'input[name="affiliated_product"]', function() {
    let value = $(this).val();

    if (value == "1") {
        // YES → show return days
        // $('#affiliated_commissionId').show();

    } else {
        // $('#affiliated_commissionId').hide();

    }
});


// dynamic Price show after discount 
// dynamic Price show after discount 
// Listen for input changes
$(document).on("input change",
    "input[id^='actualprice_'], input[id^='discount_value_'], input[type='radio'][name^='discount_type']",
    function() {

        debugger;

        let id = $(this).attr("id");
        // let index = id.split("_").pop();


        let parts = id.split("_");

        let index = parts[parts.length - 2]; // second last
        let index1 = parts[parts.length - 1]; // last


        let actualPrice = $("#actualprice_" + index + '_' + index1).val();
        let discountInput = $("#discount_value_" + index + '_' + index1);
        let discountValue = parseFloat(discountInput.val());
        let discountType = $(`input[name='discount_type[${index}][${index1}]']:checked`).val();


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
        //   if (!actualPrice || !discountValue) {
        //             $("#final_price_" + index + '_' + index1).val("");
        //             return;
        //     }

        if (!actualPrice) {
            $("#final_price_" + index + '_' + index1).val("");
            return;
        }



        let finalPrice = 0;

        // Percentage
        if (discountType == "1") {
            finalPrice = actualPrice - (actualPrice * (discountValue / 100));

            if (Number.isInteger(finalPrice)) {
                finalPrice = finalPrice;
            } else if (!isNaN(finalPrice) && typeof finalPrice === "number") {
                finalPrice = finalPrice.toFixed(2);
            }


        }


        // Fixed price
        if (discountType == "2") {
            finalPrice = actualPrice - discountValue;
        }

        if (finalPrice < 0) finalPrice = 0;



        // $("#final_price_" + index).val(finalPrice.toFixed(2));
        $("#final_price_" + index + '_' + index1).val(finalPrice);
        $("#error-final_price_" + index + '_' + index1).empty();

    });

// Min value and Max greater then Input Field

$(document).on("input", "input[id^='min_card_quantity_'], input[id^='max_card_quantity_']", function() {

    // Get dynamic index from id
    let id = $(this).attr("id"); // example: min_card_quantity_3
    let index = id.split("_").pop(); // "3"

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



// document.querySelector('.brand-select').addEventListener('change', function () {
document.getElementById('brand_id').addEventListener('change', function() {
    const otherField = document.querySelector('#other-field0');
    const otherField1 = document.querySelector('#other-field1');

    const selectedText = this.options[this.selectedIndex].text.trim().toLowerCase();

    // console.log(selectedText);

    if (selectedText === 'other') {
        otherField.style.display = 'block';
        otherField1.style.display = 'block';

    } else {
        otherField.style.display = 'none';
        otherField1.style.display = 'none';
    }
});


// {{-- When User Select Same Color then remove Image Field --}}

$(document).ready(function() {

    // // Use event delegation for dynamically added rows
    // $(document).on('change', '.color-select', function() {

    //      let dynamic_id = $(this).attr("rel");

    //     let selectedColors = [];

    //     // Collect all selected colors
    //     $('.color-select').each(function() {
    //         let val = $(this).val();
    //         if(val !== "") selectedColors.push(val);

    //         // debugger;
    //     });

    //     // Loop through each row to hide/show image upload
    //     $('.product-row').each(function() {
    //         let rowColor = $(this).find('.color-select').val();

    //         // debugger;
    //         if(rowColor === "") return; // skip empty

    //         // Count occurrences of this color
    //         let occurrences = selectedColors.filter(c => c === rowColor).length;

    //         if(occurrences > 1){

    //         // debugger;

    //             $('#variant_image_id'+dynamic_id).hide();
    //         } else {

    //         // debugger;
    //              $('#variant_image_id'+dynamic_id).show();
    //         }

    //     });

    // });

});
</script>

{{-- // common j s --}}
@include('dealer.product.ajax.product_commonjs');


@include('dealer.layout.custom_code');