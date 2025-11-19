@include('dealer.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <a href="{{ route('seller.products') }}" class="title24 alink">
            <i class="bi bi-chevron-left"></i> Add New Product
        </a>
    </div>

    <form id="addproduct" action="{{ route('seller.Add_product_code') }}" method="post">
        @csrf


        <div class="pt-3">
            <div class="title24">Select Category</div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="group-radio-btn d-flex gap-4 align-items-center flex-wrap py-3 justify-content-between">

                        @foreach ($category as $item)
                            <div class="check_radio">
                                <label class="radio-group">
                                    <input type="radio" name="category_id" value="{{ $item->id }}"
                                        onclick="catgoryFunction({{ $item->id }})">
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
                    <input type="text" class="form-control" placeholder="Enter Brand name" name="other_en">
                    <p class="text-danger" id="error-other_en"></p>
                </div>
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Product Name</label>
                        <span>In English</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter Product name" name="product_name_en">
                    <p class="text-danger" id="error-product_name_en"></p>
                </div>
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Description</label>
                        <span>In English</span>
                    </div>
                    <textarea rows="4" placeholder="Write Here" class="form-control" name="description_en"></textarea>

                    <p class="text-danger" id="error-description_en"></p>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Select Brand</label>
                    </div>
                    <select class="form-select form-control" aria-label="Default select example" name="brand_id">

                        @foreach ($brand as $item)
                            <option value="{{ $item->id }}">{{ $item->name_english }}</option>
                        @endforeach
                    </select>
                    <p class="text-danger" id="error-brand_id"></p>
                </div>
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Other</label>
                        <span>In Arabic</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter Brand name" name="other_ar">

                    <p class="text-danger" id="error-other_ar"></p>
                </div>
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Product Name</label>
                        <span>In Arabic</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter Product name" name="product_name_ar">

                    <p class="text-danger" id="error-product_name_ar"></p>
                </div>
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Description</label>
                        <span>In Arabic</span>
                    </div>
                    <textarea rows="4" placeholder="Write Here" class="form-control" name="description_ar"></textarea>
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
            <div class="append-panel">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Name</label>
                                <span>In English</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Enter product name"
                                name="product_spe_en[]">
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
                                    name="product_spe_ar[]">
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
                                name="product_spe_feature_en[]">
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
                                    name="product_spe_feature_ar[]">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!----- variant panel ------>
        <div class="variant-panel">
            <div class="product-pnls mt-4">
                <div class="upload-image" style="height:170px;">
                    <label id="uploadLabel" style="cursor:pointer;text-align:center;display:block;">
                        <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg">
                        <div class="mt-3">Upload Product Photo</div>
                        <input type="file" accept="image/*" multiple id="edit_imageUpload" style="opacity:0;"
                            name="variant_image[][]">
                    </label>
                </div>

                <div class="product-multiple d-flex flex-wrap gap-2 mt-2" id="previewContainer"></div>
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
                                <option selected>Select Colour</option>
                                @foreach ($color as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Size</label>
                            </div>

                            <select class="form-select form-control" aria-label="Default select example"
                                name="size_id[]">
                                <option selected>Select Size</option>
                                @foreach ($size as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Bust</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Eg.32D" name="bust[]">
                        </div>
                    </div>
                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Waist</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Eg.32D" name="waist[]">
                        </div>
                    </div>
                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>HIP</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Eg.32D" name="hip[]">
                        </div>
                    </div>
                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Shoulder</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Eg.32D" name="shoulder[]">
                        </div>
                    </div>
                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Sleev Length</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Eg.32D" name="sleeve_length[]">
                        </div>
                    </div>
                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Length</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Eg.32D" name="length[]">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Total Stocks</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Eg.13208" name="total_stock[]">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>SKU</label>
                            </div>
                            <input type="text" class="form-control" placeholder="20019" name="sku[]">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>SKU Threshold value</label>
                            </div>
                            <input type="text" class="form-control" placeholder="20019"
                                name="sku_threshold_value[]">
                        </div>
                    </div>
                    {{-- <div class="col-lg-3">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Price</label>
                            </div>
                            <input type="text" class="form-control" placeholder="KD299" name="actual_price">
                        </div>
                    </div> --}}
                    <div class="col-lg-3">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Actual Price</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Eg.KD 299.00"
                                name="actual_price[]">
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
                                    <input type="radio" name="discount_type[]" checked value="1">
                                    <span class="custom-radio"></span>
                                    <span class="radio-label">Percentage</span>
                                </label>
                            </div>
                            <div class="check_radio">
                                <label class="radio-group">
                                    <input type="radio" name="discount_type[]" value="2">
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
                            <input type="text" class="form-control" placeholder="Eg.10%" name="discount_value[]">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Final Price</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Eg.KD 299.00"
                                name="final_price[]">
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                        <input type="text" class="form-control" placeholder="Eg.20" name="min_card_quantity">
                    </div>
                    <p class="text-danger" id="error-min_card_quantity"></p>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="sub-form">
                        <div class="label-flex">
                            <label>Set Max.cart quantity</label>
                        </div>
                        <input type="text" class="form-control" placeholder="Eg.20" name="max_card_quantity">
                    </div>
                    <p class="text-danger" id="error-max_card_quantity"></p>
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
                                        <input type="radio" name="product_return" checked value='0'>
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">Yes</span>
                                    </label>
                                </div>
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="product_return" value='1'>
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>If Yes,Total days for returning</label>
                                </div>
                                <input type="number" class="form-control" placeholder="Eg.KD 299.00"
                                    name="return_days">
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
                                        <input type="radio" name="product_exchangable" checked name="0">
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">Yes</span>
                                    </label>
                                </div>
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="product_exchangable" name="1">
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>Is this product exchangeable?</label>
                                </div>
                                <input type="number" class="form-control" placeholder="Eg.15 days"
                                    name="exchangable_days">
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
                                        <input type="radio" name="review_rating" value="1" checked>
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">Yes</span>
                                    </label>
                                </div>
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="review_rating" value="0">
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
                                        <input type="radio" name="affiliated_product" checked value="1">
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">Yes</span>
                                    </label>
                                </div>
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="affiliated_product" value="0">
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
                                        <input type="radio" name="customized_product" checked value="1">
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">Yes</span>
                                    </label>
                                </div>
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="customized_product" value="0">
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
                                        <input type="radio" name="ready_to_ship" checked value="1">
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">Yes</span>
                                    </label>
                                </div>
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="ready_to_ship" value="0">
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
                                        <input type="radio" name="cash_on_delivery" checked value="1">
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">Yes</span>
                                    </label>
                                </div>
                                <div class="check_radio">
                                    <label class="radio-group">
                                        <input type="radio" name="cash_on_delivery" value="0">
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
            </div>

            <div class="product-multiple d-flex flex-wrap gap-2 mt-2" id="edit_uploadChart_preview"></div>
        </div>

        <div class="dashboard-button d-flex mt-5 gap-5">
            <button type="button" class="btn cancel-outline w-100"
                onclick="location.href='{{ route('seller.products') }}'">Cancel</button>
            <button type="submit" class="btn add-fillbtn w-100">Add Product</button>
        </div>
    </form>

</section>





@include('dealer.layout.footer');

<script>
    $('#edit_imageUpload').on('change', e => {
        let files = e.target.files;
        $('#previewContainer').empty(); // clear old previews
        [...files].forEach(f => {
            let url = URL.createObjectURL(f);
            let imgBox = $(`
      <div class="multiple-img position-relative">
        <img src="${url}" class="w-100 rounded">
        <span class="remove-ic" style="position:absolute;top:0;right:5px;cursor:pointer;font-size:20px;color:red;">&times;</span>
      </div>
    `);
            imgBox.find('.remove-ic').click(() => imgBox.remove());
            $('#previewContainer').append(imgBox);
        });
    });


    // Upload Chart Image
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
    // ADD NEW ROW
    $("#addmore").click(function() {
        $(".append-panel").append(`
       <div class="specifications-row">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Name</label>
                        <span>In English</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter product name" name="product_spe_en[]">
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="append-flex">
                    <div class="sub-form">
                        <div class="label-flex">
                            <label>Name</label>
                            <span>In Arabic</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Enter product name" name="product_spe_ar[]">
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
                    <input type="text" class="form-control" placeholder="Enter product feature" name="product_spe_feature_en[]">
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="append-flex">
                    <div class="sub-form">
                        <div class="label-flex">
                            <label>Feature</label>
                            <span>In Arabic</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Enter product feature" name="product_spe_feature_ar[]">
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <div class="remove-btn"><i class="bi bi-x"></i> Remove </div>
        </div>
        </div>
       `)

    });

    // REMOVE ROW
    $(document).on("click", ".remove-btn", function() {
        $(this).closest(".specifications-row").remove();
    });
</script>

<script>
    // ADD NEW Variant
    $(".addVariantBtn").click(function() {
        $(".variant-panel").append(`
        <div class="variant-panel-bg">
            <div class="product-pnls mt-4">
                <div class="upload-image" style="height:170px;">
                    <label id="uploadLabel" style="cursor:pointer;text-align:center;display:block;">
                        <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg">
                        <div class="mt-3">Upload Profile Photo</div>
                        <input type="file" accept="image/*" multiple id="variant_image[][]" style="opacity:0;">
                    </label>
                </div>

                <div class="product-multiple d-flex flex-wrap gap-2 mt-2" id="previewContainer"></div>
            </div>

            <div class="wapper-header mt-4">
                <div class="row">
                
                     <div class="col-lg-3">
                    <div class="sub-form">
                        <div class="label-flex">
                            <label>Colour</label>
                        </div>

                        <select class="form-select form-control" aria-label="Default select example">
                            <option selected>Select Colour</option>
                            @foreach ($color as $item)
                                <option {{ $item->id }}>{{ $item->name }}</option>
                            @endforeach
                        </select>

                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="sub-form">
                        <div class="label-flex">
                            <label>Size</label>
                        </div>

                        <select class="form-select form-control" aria-label="Default select example">
                            <option selected>Select Size</option>
                            @foreach ($size as $item)
                                <option {{ $item->id }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Bust</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Eg.32D">
                        </div>
                    </div>
                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Waist</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Eg.32D">
                        </div>
                    </div>
                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>HIP</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Eg.32D">
                        </div>
                    </div>
                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Shoulder</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Eg.32D">
                        </div>
                    </div>
                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Sleev Length</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Eg.32D">
                        </div>
                    </div>
                    <div class="col-lg-3 remove_Not_in_women_Category">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Length</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Eg.32D">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Total Stocks</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Eg.13208">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>SKU</label>
                            </div>
                            <input type="text" class="form-control" placeholder="20019">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>SKU Threshold value</label>
                            </div>
                            <input type="text" class="form-control" placeholder="20019">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Price</label>
                            </div>
                            <input type="text" class="form-control" placeholder="KD299">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Actual Price</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Eg.KD 299.00">
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
                                    <input type="radio" name="percentage" checked>
                                    <span class="custom-radio"></span>
                                    <span class="radio-label">Percentage</span>
                                </label>
                            </div>
                            <div class="check_radio">
                                <label class="radio-group">
                                    <input type="radio" name="percentage">
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
                           <input type="text" class="form-control" placeholder="Eg.10%">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Final Price</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Eg.KD 299.00">
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <div class="remove-btn removerow"><i class="bi bi-x"></i> Remove </div>
            </div>

        </div>

       `)
        var checked_category = $("input[name='categoryName']:checked").val();
        if (checked_category) {
            remove_Not_in_women_Category(checked_category);
        }

    });

    // REMOVE ROW
    $(document).on("click", ".removerow", function() {
        $(this).closest(".variant-panel-bg").remove();
    });

    // Product Variation Show according to product

    function remove_Not_in_women_Category(val) {

        if (val != '2') {
            $('.remove_Not_in_women_Category').hide();
        } else {
            $('.remove_Not_in_women_Category').show();
        }

    }


    // sub category show data
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

                    var htmlcontent = '';

                    subcatgory_record.forEach(function(item, val) {
                        htmlcontent +=
                            `<option value="${item.id}">${item.name_english} </option>`;
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
            }
        })


    }

    // From submit code Apply




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
            success: function(response) {
                console.log(response);

                window.setTimeout(function() {
                    $('.customBtn, .form-control').attr('disabled', false).removeClass(
                        'disabled-link');
                    $('.submit').html('Upload');
                }, 2000);

                if (response.success === true) {
                    toastr.success("<?php echo __('admin_messages.product_added_successfully'); ?>");
                    $('.submit').attr('disabled', true);
                    window.setTimeout(function() {
                        window.location = "{{ url('/') }}" +
                            "/admin/inventory-mangement";
                    }, 2000);
                }

                if (response.success === false) {
                    console.log(response.errors); // Debugging line
                    $("p.error_container").html("");

                    $.each(response.errors, function(field, messages) {
                        if (field === "file" || field.startsWith("file.")) {
                            $("#file-error").html(messages[0]);
                        } else {
                            // Handle indexed fields (e.g., productdetails_name_en.0)
                            let fieldName = field.replace(/\.\d+$/, ''); // Remove the index
                            $('#error-' + fieldName).html(messages[0]);
                        }
                    });
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown); // Debugging line
            }
        });

        return false;
    });
</script>
