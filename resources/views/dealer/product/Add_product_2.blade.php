@include('dealer.layout.header')



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
                        <input type="text" class="form-control" placeholder="Enter product name">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="append-flex">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Name</label>
                                <span>In Arabic</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Enter product name">
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
                        <input type="text" class="form-control" placeholder="Enter product feature">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="append-flex">
                        <div class="sub-form">
                            <div class="label-flex">
                                <label>Feature</label>
                                <span>In Arabic</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Enter product feature">
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
                    <div class="mt-3">Upload Profile Photo</div>
                    <input type="file" accept="image/*" multiple id="edit_imageUpload" style="opacity:0;">
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
                            <option selected>Colour</option>
                            <option value="1">Red</option>
                            <option value="2">Black</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="sub-form">
                        <div class="label-flex">
                            <label>Size</label>
                        </div>

                        <select class="form-select form-control" aria-label="Default select example">
                            <option selected>Colour</option>
                            <option value="1">Red</option>
                            <option value="2">Black</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="sub-form">
                        <div class="label-flex">
                            <label>Bust</label>
                        </div>
                        <input type="text" class="form-control" placeholder="Eg.32D">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="sub-form">
                        <div class="label-flex">
                            <label>Waist</label>
                        </div>
                        <input type="text" class="form-control" placeholder="Eg.32D">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="sub-form">
                        <div class="label-flex">
                            <label>HIP</label>
                        </div>
                        <input type="text" class="form-control" placeholder="Eg.32D">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="sub-form">
                        <div class="label-flex">
                            <label>Shoulder</label>
                        </div>
                        <input type="text" class="form-control" placeholder="Eg.32D">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="sub-form">
                        <div class="label-flex">
                            <label>Sleev Length</label>
                        </div>
                        <input type="text" class="form-control" placeholder="Eg.32D">
                    </div>
                </div>
                <div class="col-lg-3">
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
    </div>
<!-----End variant panel ------>





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

</script>

<script>

   // ADD NEW ROW
    $("#addmore").click(function () {
       $(".append-panel").append(`
       <div class="specifications-row">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Name</label>
                        <span>In English</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter product name">
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="append-flex">
                    <div class="sub-form">
                        <div class="label-flex">
                            <label>Name</label>
                            <span>In Arabic</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Enter product name">
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
                    <input type="text" class="form-control" placeholder="Enter product feature">
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="append-flex">
                    <div class="sub-form">
                        <div class="label-flex">
                            <label>Feature</label>
                            <span>In Arabic</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Enter product feature">
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
    $(document).on("click", ".remove-btn", function () {
        $(this).closest(".specifications-row").remove();
    });

    
</script>
