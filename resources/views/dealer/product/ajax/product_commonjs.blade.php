<script>
    // Remove 0 in women catgeory and other inout field

    document.querySelectorAll('.no-zero').forEach(function(input) {

        // Remove leading zero(s)
        input.addEventListener('input', function() {
            if (this.value.startsWith('0')) {
                this.value = this.value.replace(/^0+/, '');
            }
        });

        // Prevent typing "0" as first character
        input.addEventListener('keydown', function(e) {
            if (e.key === '0' && this.selectionStart === 0) {
                e.preventDefault();
            }
        });

    });


    // add More Variation inside Product Size



    // Add another sub Variation

    $(document).on("click", ".addmoreVariation", function() {
        let variation_id = $(this).attr("rel");

        if (variation_id == 0) {

            var data1 = $(".subvariant");

        } else {

            var data1 = $(`#variant_image_id${variation_id}`).closest(".variant-panel-bg").find(
                ".inside_variation")

        }

        data1.append(`

       <div class="inside_variation${variation_id} p-2 mt-4 newvariant subpanel" style="background:#fff7ea; background: #fff; border: 1px dashed #0d0606;
        border-radius: 10px; box-shadow: 0px 2px 4px #ddd;">
            <div class="wapper-header mt-2">
                <div class="row price-block">
                    <div class="col-lg-3">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Size</label>
                            </div>
                            <select class="form-select form-control" aria-label="Default select example" name="size_id[${variation_id}][]">
                                <option value="">Select Size</option>
                                @foreach ($size as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-danger" id="error-size_id_0"></p>
                        </div>
                    </div>
                    
                      <div class="col-lg-3 remove_Not_in_women_Category">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>Bust</label>
                                </div>
                                <input type="number" class="form-control notapplyspace no-zero" placeholder="Eg.10"
                                    name="bust[${variation_id}][]">
                                <p class="text-danger" id="error-bust_0"></p>

                            </div>
                        </div>
                        <div class="col-lg-3 remove_Not_in_women_Category">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>Waist</label>
                                </div>
                                <input type="number" class="form-control notapplyspace no-zero" placeholder="Eg.12"
                                    name="waist[${variation_id}][]">

                                <p class="text-danger" id="error-waist_0"></p>
                            </div>

                        </div>
                        <div class="col-lg-3 remove_Not_in_women_Category">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>HIP</label>
                                </div>
                                <input type="number" class="form-control notapplyspace no-zero" placeholder="Eg.14"
                                    name="[${variation_id}][]">
                                <p class="text-danger" id="error-hip_0"></p>

                            </div>

                        </div>
                        <div class="col-lg-3 remove_Not_in_women_Category">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>Shoulder</label>
                                </div>
                                <input type="number" class="form-control notapplyspace no-zero" placeholder="Eg.16"
                                    name="shoulder[${variation_id}][]">
                                <p class="text-danger" id="error-shoulder_0"></p>

                            </div>

                        </div>
                        <div class="col-lg-3 remove_Not_in_women_Category">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>Sleev Length</label>
                                </div>
                                <input type="number" class="form-control notapplyspace no-zero" placeholder="Eg.18"
                                    name="sleeve_length[${variation_id}][]">
                                <p class="text-danger" id="error-sleeve_length_0"></p>

                            </div>

                        </div>
                        <div class="col-lg-3 remove_Not_in_women_Category">
                            <div class="sub-form">
                                <div class="label-flex">
                                    <label>Length</label>
                                </div>
                                <input type="number" class="form-control notapplyspace no-zero" placeholder="Eg.20"
                                    name="length[${variation_id}][]">

                                <p class="text-danger" id="error-length_0"></p>
                            </div>

                        </div>



                    <div class="col-lg-3">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Total Stocks</label>
                            </div>
                            <input type="number" class="form-control notapplyspace" placeholder="Eg.13208" name="total_stock[${variation_id}][]">

                            <p class="text-danger" id="error-total_stock_0"></p>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>SKU Limit</label>
                            </div>
                            <input type="number" class="form-control notapplyspace" placeholder="20019" name="sku[${variation_id}][]">
                            <p class="text-danger" id="error-sku_0"></p>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Actual Price</label>
                            </div>
                            <input type="number" class="form-control notapplyspace" placeholder="Eg. 299.00 KD" name="actual_price[${variation_id}][]" id="actual_price_0">
                            <p class="text-danger" id="error-actual_price_0"></p>
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
                                    <input type="radio" name="discount_type[${variation_id}][]" id="discount_type_percentage_0" checked value="1">
                                    <span class="custom-radio"></span>
                                    <span class="radio-label">Percentage</span>
                                </label>
                            </div>
                            <div class="check_radio">
                                <label class="radio-group">
                                    <input type="radio" name="discount_type[${variation_id}][]" id="discount_type_fixed_0" value="2">
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
                            <input type="number" class="form-control notapplyspace" placeholder="Eg.10%" name="discount_value[${variation_id}][]" id="discount_value_0">
                            <p class="text-danger" id="error-discount_value_0"></p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Final Price</label>
                            </div>
                            <input type="number" class="form-control notapplyspace" placeholder="Eg. 299.00 KD" name="final_price[${variation_id}][]" id="final_price_0">
                            <p class="text-danger" id="error-final_price_0"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <div class="remove-btn22 "><i class="bi bi-x"></i> Remove</div>
            </div>
        </div>

    `);


        var checked_category = $("input[name='category_id']:checked").val();
        if (checked_category) {
            remove_Not_in_women_Category(checked_category);
        }


    });

    // REMOVE ROW
    $(document).on("click", ".remove-btn22", function() {
        $(this).closest(".subpanel").remove();
    });
</script>
