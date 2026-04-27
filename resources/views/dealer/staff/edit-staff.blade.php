@include('dealer.layout.header')

<section class="section dashboard">
  
    <div class="d-flex justify-content-between mt-4">
        <a href="#" class="title24 alink"> <i class="bi bi-chevron-left"></i>edit Staff </a>
    </div>

    <form id="addBanner" action="#" method="post">
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="product-pnls2 mt-3">
                    <div class="upload-image" style="position:relative;height:30%">
                     
                    <label id="bannerUploadLabel" style="cursor:pointer;text-align:center;display:block;position:relative;">
                    <!-- Placeholder -->
                    <div id="bannerPlaceholderImg" style="{{ !empty($view_staff->profile_pic) ? 'display:none;' : '' }}">
                        <img src="{{ asset('/dealer') }}/assets/img/upload-icon.svg"
                             style="width:70px;object-fit:cover;border-radius:6px;padding-top:2rem;">
                        <div class="py-2" style="color:#875C3A">
                            Upload Profile
                        </div>
                    </div>

                    <!-- Uploaded Image -->
                    <div class="profileImg" style="display:none;" id="showProfile">
                    <img id="bannerUploadedImg"
                         src="{{ !empty($view_staff->profile_pic) ? asset($view_staff->profile_pic) : '' }}"
                         class="img-fluid uploadbnr"
                         style="{{ empty($view_staff->profile_pic) ? 'display:none;' : '' }}">
                    </div>

                    <!-- File Input -->
                    <input type="file"
                           accept="image/*"
                           id="banner_image_upload"
                           name="profile_pic"
                           style="opacity:0;position:absolute;top:0;left:0;width:100%;height:100%;cursor:pointer;">
                </label>

                    <p class="text-danger" id="error-file"></p>

                    </div>
                </div>
            </div>
        </div>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <input type="hidden" id="old_profile_pic" name="old_profile_pic" value="{{$view_staff->profile_pic}}">

    <input type="hidden" oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')" name="id" value="{{$view_staff->id}}">

    <div class="row">
            <div class="col-lg-6">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Full Name</label>
                        <span>In English</span>
                    </div>
                    <input type="text" oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')" name="full_name" class="form-control" placeholder="Enter Full name" value="{{$view_staff->first_name}}">
                   <p class="text-danger" id="error-full_name"></p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Full Name</label>
                        <span>In Arabic</span>
                    </div>
                    <input type="text" dir="rtl" style="text-align: right;" oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')" class="form-control" placeholder="Enter Full name" name="name_ar" value="{{$view_staff->name_ar}}">
                 <p class="text-danger" id="error-name_ar"></p>
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
                                        <label>Store Phone Number </label>
                                    </div>

                                    <div class="form-group d-flex gap-2 w-100">
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-light border dropdown-toggle d-flex align-items-center justify-content-between w-100 form-control"
                                                type="button" id="countryDropdown" data-bs-toggle="dropdown"
                                                aria-expanded="false">

                                                <span id="selected-flag">
                                                    <img src="{{@$view_staff->country_details->flag1}}"
                                                        alt="flag" width="25" height="16">
                                                    {{$view_staff->country_code}}
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
                                                            value="{{ $item->dial_code }} " data-flag="{{ $item->flag }}"
                                                            data-name="{{ $item->name }}" class="country-radio" @if($item->dial_code==$view_staff->country_code) checked @endif
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
                                                value="{{$view_staff->mobile}}"
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
                    <input type="text"  class="form-control" placeholder="Enter Email" name="email" value="{{$view_staff->email}}">
                     <p class="text-danger" id="error-email"></p>
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
                            <input type="radio" name="select_category" value="{{$val->id}}" @if($val->id==$view_staff->select_category) checked  @endif >
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
             <div class="sub-form position-relative">
                    <div class="label-flex">
                        <label>Password</label>
                    </div>
                    <input type="text"  class="form-control" placeholder="Enter Password" name="password" value="{{$view_staff->save_password}}">
                    <i class="toggle-password  bi bi-eye-slash "></i>  
                    <p class="text-danger" id="error-password"></p>
                
                </div>
            </div>
            <div class="col-lg-6">
             <div class="sub-form position-relative">
                    <div class="label-flex">
                        <label>Confirm Password</label>
                    </div>
                    <input type="text"  class="form-control" placeholder="Enter Confirm Password" name="confirm_password"  value="{{$view_staff->save_password}}">
                    <i class="toggle-password  bi bi-eye-slash "></i>  
                    <p class="text-danger" id="error-confirm_password"></p>
                </div>
            </div>
        </div>
        <div class="module-lists mt-3 mb-4">
            <label class="banner-text py-3">Access Module</label>

            <div class="row">
                <div class="col-lg-5">

                 <p class="text-danger" id="error-menuSelect"></p>

                @foreach($sellerMenu as $key=>$menu)


                @php

                $firstMenu='';
                $secondMenu='';
                $thirdMenu='';


                foreach($view_staff->Role_Action as $key1=>$dbmenu){

                if($menu->id==$dbmenu->menu_id){
                    $firstMenu="checked";
                }

                if($menu->id==$dbmenu->menu_id &&  $dbmenu->can_view=='1'){
                    $secondMenu="checked";
                }

                if($menu->id==$dbmenu->menu_id &&  $dbmenu->can_action=='1'){
                    $thirdMenu="checked";
                }

                }

                @endphp


                <div class="d-flex gap-2 justify-content-between w-100 mb-4">
                <!-- MAIN MENU -->
                <div class="view-width">
                <div class="form-check">
                <input class="form-check-input menu-checkbox"
                type="checkbox"
                value="{{$menu->id}}"  {{$firstMenu}}>
                <label class="form-check-label">
                {{$menu->title}}
                </label>
                </div>
            </div>

                <!-- VIEW -->
                <div class="form-check">
                <input class="form-check-input view-checkbox"
                type="checkbox"
                data-id="{{$menu->id}}"  {{$secondMenu}}>
                <label class="form-check-label">View</label>
                </div>

                <!-- ACTION -->
                <div class="form-check">
                <input class="form-check-input action-checkbox"
                type="checkbox"
                data-id="{{$menu->id}}"  {{$thirdMenu}}>
                <label class="form-check-label">Action</label>
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

     $('#error-file').text('');
     $('#old_profile_pic').val('');

    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('bannerUploadedImg').src = e.target.result;
        document.getElementById('bannerUploadedImg').style.display = 'block';
        document.getElementById('showProfile').style.display = 'block';
        document.getElementById('bannerPlaceholderImg').style.display = 'none';
    };
    reader.readAsDataURL(file);
});



$(document).ready(function() {


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

});


// Add Staff Code 

$('#addBanner').on('submit', function(e) {
    e.preventDefault();

    let id = $('input[name="id"]').val().trim();
    let full_name = $('input[name="full_name"]').val().trim();
    let full_name_ar = $('input[name="name_ar"]').val().trim();
    
    let country_code = $('input[name="country_code"]:checked').val();

    // alert(country_code);
    // return false;

    let mobile = $('input[name="mobile"]').val().trim();


    let email = $('input[name="email"]').val().trim();
    let password = $('input[name="password"]').val();
    let confirm_password = $('input[name="confirm_password"]').val();
    let file = $('#banner_image_upload')[0].files[0];

    let old_profile_pic=$('input[name="old_profile_pic"]').val().trim();
        
    console.log(file);

    let error = false;

    // Clear old errors
    $('.text-danger').text('');

    if (!full_name) {
        error = true;
        // alert('Full name is required');
        $('#error-full_name').text('Please Enter full Name');
    }

     if (!full_name_ar) {
        error = true;
        // alert('Full name is required');
        $('#error-name_ar').text('Please Enter full Name');
    }

    if (!mobile || mobile.length < 8) {
        error = true;
        $('#error-mobile').text('Enter valid mobile number');
    }

    if (!email || !/^\S+@\S+\.\S+$/.test(email)) {
        error = true;
        // alert('Enter valid email');
        $('#error-email').text('Please Enter email Address');

    }

    if (!password || password.length < 6) {
        error = true;
        // alert('Password must be at least 6 characters');

        $('#error-password').text('Please Enter Password');
    }

     if (!confirm_password || confirm_password.length < 6) {
        error = true;
        // alert('Password must be at least 6 characters');

        $('#error-confirm_password').text('Please Enter Password');
    }

    if (password !== confirm_password) {
        error = true;
        // alert('Passwords do not match');
        $('#error-confirm_password').text('Please match password and confirm Password');
    }

     if (!old_profile_pic) {

        if (!file) {
            error = true;
            // alert('Profile image is required');
            $('#error-file').text('Please Upload profile');
        }

     }


      // File upload
   


    // At least one menu selected
    if ($('.menu-checkbox:checked').length === 0) {
        error = true;
        // alert('Select at least one module');
        $('#error-menuSelect').text('Please Select at least one module');
    }

    if (error) return;

    let menuData = [];

    $('.menu-checkbox').each(function() {
        let id = $(this).val();

        let can_view = $('.view-checkbox[data-id="'+id+'"]').is(':checked') ? 1 : 0;
        let can_action = $('.action-checkbox[data-id="'+id+'"]').is(':checked') ? 1 : 0;

        if ($(this).is(':checked')) {
            menuData.push({
                id: parseInt(id),
                can_view: can_view,
                can_action: can_action
            });
        }
    });


    let formData = new FormData();

    // Text fields
    formData.append('id', $('input[name="id"]').val());
    formData.append('full_name', $('input[name="full_name"]').val());
    formData.append('name_ar', $('input[name="name_ar"]').val());
    formData.append('country_code', $('input[name="country_code"]:checked').val());
    formData.append('mobile', $('input[name="mobile"]').val());
    formData.append('email', $('input[name="email"]').val());
    formData.append('select_category', $('input[name="select_category"]:checked').val());
    formData.append('password', $('input[name="password"]').val());
    formData.append('confirm_password', $('input[name="confirm_password"]').val());

    formData.append('old_profile_pic', $('input[name="old_profile_pic"]').val());
    

    // ✅ Image
    formData.append('profile_pic', file);

    // ✅ Menu array
    menuData.forEach((item, index) => {
        formData.append(`menu_id[${index}][id]`, item.id);
        formData.append(`menu_id[${index}][can_view]`, item.can_view);
        formData.append(`menu_id[${index}][can_action]`, item.can_action);
    });

    $.ajax({
        url: '/seller/edit-staff/'+id,
        type: 'POST',
        data: formData,
        processData: false,   // REQUIRED
        contentType: false,   // REQUIRED
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {

             if (res.status === 'success') {
                    toastr.success(res.message);
                    setTimeout(() => window.location.href='/seller/staff-management', 2000);
                } else {
                    toastr.error(res.message || 'Something went wrong');
                }

            console.log(res);
        },
        error: function(err) {

        if (err.status === 422) {

        let errors = err.responseJSON.errors;

        // Loop all validation errors
        for (let key in errors) {
            $(`#error-${key}`).html(errors[key][0]); // show first error
        }

        toastr.error('Please fix validation errors');

    } else if (err.responseJSON && err.responseJSON.message) {
        toastr.error(err.responseJSON.message);
    } else {
        toastr.error('Something went wrong');
    }

           
        }
    });

    console.log(formData); // debug

});



// document.addEventListener("change", function (e) {

//     // 🔹 When MENU is clicked
//     if (e.target.classList.contains("menu-checkbox")) {

//         let parent = e.target.closest(".d-flex");

//         let view = parent.querySelector(".view-checkbox");
//         let action = parent.querySelector(".action-checkbox");

//         if (e.target.checked) {
//             view.checked = true;
//             action.checked = true;
//         } else {
//             view.checked = false;
//             action.checked = false;
//         }
//     }

//     // 🔹 When VIEW is clicked
//     if (e.target.classList.contains("view-checkbox")) {

//         let parent = e.target.closest(".d-flex");
//         let menu = parent.querySelector(".menu-checkbox");

//         if (e.target.checked) {
//             menu.checked = true;
//         } else {
//             // if both view & action unchecked → uncheck menu
//             let action = parent.querySelector(".action-checkbox");
//             if (!action.checked) {
//                 menu.checked = false;
//             }
//         }
//     }

//     // 🔹 When ACTION is clicked
//     if (e.target.classList.contains("action-checkbox")) {

//         let parent = e.target.closest(".d-flex");
//         let menu = parent.querySelector(".menu-checkbox");

//         if (e.target.checked) {
//             menu.checked = true;
//         } else {
//             // if both view & action unchecked → uncheck menu
//             let view = parent.querySelector(".view-checkbox");
//             if (!view.checked) {
//                 menu.checked = false;
//             }
//         }
//     }

// });

document.addEventListener("change", function (e) {

    let parent = e.target.closest(".d-flex");
    if (!parent) return;

    let menu = parent.querySelector(".menu-checkbox");
    let view = parent.querySelector(".view-checkbox");
    let action = parent.querySelector(".action-checkbox");

    // =========================
    // MENU CLICK
    // =========================
    if (e.target.classList.contains("menu-checkbox")) {

        if (menu.checked) {
            view.checked = true;
            action.checked = true;
        } else {
            view.checked = false;
            action.checked = false;
        }
    }

    // =========================
    // VIEW CLICK
    // =========================
    if (e.target.classList.contains("view-checkbox")) {

        if (view.checked) {
            menu.checked = true;
        } else {
            // If VIEW removed → ACTION must also go off
            action.checked = false;
            menu.checked = false;
        }
    }

    // =========================
    // ACTION CLICK
    // =========================
    if (e.target.classList.contains("action-checkbox")) {

        if (action.checked) {
            menu.checked = true;
            view.checked = true;
        } else {
            // if ACTION removed → check remaining state
            if (!view.checked) {
                menu.checked = false;
            }
        }
    }

});


// add stuff code End here 

$(".toggle-password").click(function() {
        $(this).toggleClass("bi-eye bi-eye-slash");
        input = $(this).parent().find("input");
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

</script>


@include('dealer.layout.custom_code');
@include('dealer.layout.footer');