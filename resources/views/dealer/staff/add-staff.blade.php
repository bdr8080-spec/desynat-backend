@include('dealer.layout.header')

<section class="section dashboard">
  
    <div class="d-flex justify-content-between mt-4">
        <a href="#" class="title24 alink"> <i class="bi bi-chevron-left"></i>Add Staff </a>
    </div>

    <form id="addBanner" action="#" method="post">
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="product-pnls2 mt-3">
                    <div class="upload-image" style="height:250px;">
                        <label id="bannerUploadLabel" style="cursor:pointer;text-align:center;display:block;">
                            <!-- Placeholder -->
                            <div id="bannerPlaceholderImg">
                                <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg"
                                    style="width:70px;object-fit:cover;border-radius:6px;padding-top:2rem;">
                                <div class="py-2" style="color:#875C3A">
                                    Upload Profile
                                </div>
                            </div>
                            <!-- Uploaded Image -->
                            <img id="bannerUploadedImg" src="" alt="image" class="img-fluid uploadbnr"
                                style="display:none;">
                            <!-- SINGLE IMAGE -->
                            <input type="file" accept="image/*" id="banner_image_upload"
                                style="opacity:0;position: absolute;" name="profile_pic">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Full Name</label>
                        <span>In English</span>
                    </div>
                    <input type="text" oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')" name="full_name" class="form-control" placeholder="Enter Full name">
                
                </div>
            </div>
            <div class="col-lg-6">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Full Name</label>
                        <span>In Arabic</span>
                    </div>
                    <input type="text" oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')" class="form-control" placeholder="Enter Full name" name="name_ar">
                </div>
            </div>
        </div>
        <div class="row">
        <!-- <div class="col-lg-1">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Country Code</label>
                    </div>
                    <input type="text"  class="form-control" placeholder="Enter country code" name="country_code">
                </div>
        </div> -->

        <!-- <div class="col-lg-5">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Phone Number</label>
                    </div>
                    <input type="text"  class="form-control" placeholder="Enter Phone Number" name="mobile">
                </div>
        </div> -->

         <div class="col-lg-6 col-md-6">
                                    <div class="label-flex">
                                        <label>Store Phone Number</label>
                                    </div>

                                    <div class="form-group d-flex gap-0 w-100">
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-light border dropdown-toggle d-flex align-items-center justify-content-between w-100 form-control"
                                                type="button" id="countryDropdown" data-bs-toggle="dropdown"
                                                aria-expanded="false">

                                                <span id="selected-flag">
                                                    <img src="{{$all_country[0]->flag1}}"
                                                        alt="flag" width="25" height="16">
                                                    {{$all_country[0]->dial_code}}
                                                </span>

                                                <span id="selected-code" class="ms-2">
                                                </span>
                                            </button>
                                            <ul class="dropdown-menu p-2" aria-labelledby="countryDropdown">
                                                @foreach ($all_country as $index => $item)
                                                <li>
                                                    <label
                                                        class="dropdown-item d-flex align-items-center gap-2 country-option"
                                                        style="cursor: pointer;">
                                                        <input type="radio" name="country_code"
                                                            value="{{ $item->dial_code }}" data-flag="{{ $item->flag }}"
                                                            data-name="{{ $item->name }}" class="country-radio"
                                                            hidden>

                                                        <div width="25" height="16">
                                                            <span>{{ $item->flag }}
                                                                {{ $item->dial_code }} {{ $item->name }}
                                                            </span>
                                                        </div>
                                                    </label>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="w-100">
                                            <input class="form-control notapplyspace" type="number" id="phone"
                                                placeholder="Enter mobile Number" name="mobile"
                                                value="{{ old('mobile') }}"
                                                oninput="if(this.value.length > 15) this.value = this.value.slice(0, 15);">
                                            <p class="text-danger" id="error-mobile"></p>
                                        </div>

                                    </div>

                                </div>

            <div class="col-lg-6">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Email</label>
                    </div>
                    <input type="text"  class="form-control" placeholder="Enter Email" name="email">
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label class="banner-text">Select Category</label>
                <div class="group-radio-btn d-flex gap-5 align-items-center flex-wrap py-3 pe-3">

                @foreach($staff_category as $key=>$val)
                    <div class="check_radio">
                        <label class="radio-group">
                            <input type="radio" name="select_category" value="{{$val->id}}" checked>
                            <span class="custom-radio"></span>
                            <span class="radio-label">{{$val->name_en}}</span>
                        </label>
                    </div>
                @endforeach


                   
                </div>
            </div>
          
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Password</label>
                    </div>
                    <input type="text"  class="form-control" placeholder="Enter Password" name="password">
                
                </div>
            </div>
            <div class="col-lg-6">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Confirm Password</label>
                    </div>
                    <input type="text"  class="form-control" placeholder="Enter Confirm Password" name="confirm_password">
                </div>
            </div>
        </div>
        <div class="module-lists mt-3 mb-4">
            <label class="banner-text py-3">Access Module</label>

            <div class="row">
                <div class="col-lg-5">

                @foreach($sellerMenu as $key=>$menu)

                    <div class="d-flex gap-2 justify-content-between w-100 mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="checkDefault" name="">
                            <label class="form-check-label" for="checkDefault">
                                {{$menu->title}}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="checkDefault">
                            <label class="form-check-label" for="checkDefault">
                                View
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="checkDefault">
                            <label class="form-check-label" for="checkDefault">
                                Action
                            </label>
                        </div>
                    </div>

                    @endforeach
                    
                </div>
            </div>
            
                
            


        </div>


        <div class="mb-5">
            <div class="dashboard-button  mt-5 gap-5">
                <button type="submit" class="btn add-fillbtn w-100">Submit</button>
            </div>

        </div>

    </form>

</section>




<script>
document.getElementById('banner_image_upload').addEventListener('change', function(event) {
    const file = event.target.files[0];

    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('bannerUploadedImg').src = e.target.result;
        document.getElementById('bannerUploadedImg').style.display = 'block';
        document.getElementById('bannerPlaceholderImg').style.display = 'none';
    };
    reader.readAsDataURL(file);
});



$(document).ready(function() {
    // When a user selects a country (clicks a label)
    $(document).on('click', '.country-option', function() {
        let radio = $(this).find('.country-radio');
        let flag = radio.data('flag');
        let code = radio.val();
        let name = radio.data('name');

        // Update the flag and code shown on the button
        $('#selected-flag').html(flag);
        $('#selected-code').text(code);

        // Set the radio input as checked
        radio.prop('checked', true);

        // Close the dropdown (Bootstrap 5)
        $('#countryDropdown').dropdown('hide');
    });


    $(document).on('click', '.country-option1', function() {
        let radio = $(this).find('.country-radio1');
        let flag = radio.data('flag');
        let code = radio.val();
        let name = radio.data('name');

        // Update the flag and code shown on the button
        $('#selected-flag1').html('');
        $('#selected-code1').text(flag + ' ' + ' ' + name);

        // Set the radio input as checked
        radio.prop('checked', true);

        // Close the dropdown (Bootstrap 5)
        $('#countryDropdown1').dropdown('hide');
    });

});

</script>


@include('dealer.layout.custom_code');
@include('dealer.layout.footer');