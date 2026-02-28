@include('affiliatedUser.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl mb-5">
        <div class="title24"> Change Password </div>
    </div>

    <form id="Affiliate_changePassword" action="{{route('affiliate.change-password')}}" method="Post">
        @csrf
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Old Password </label>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter Password" name="old_password">
                </div>
                <p class="text-danger" id="error-old_password"></p>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>New Password</label>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter New Password" name="password">
                </div>
                <p class="text-danger" id="error-password"></p>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Confirm Password</label>
                    </div>
                    <input type="text" class="form-control" placeholder="Re-enter Password" name="confirm_password">
                </div>
                <p class="text-danger" id="error-confirm_password"></p>
            </div>
        </div>
        <div class="dashboard-button mt-5">
            <button type="submit" class="btn add-fillbtn w-100">Update</button>
        </div>

    </form>


</section>



<script src="{{ asset('/dealer') }}/assets/custom-file/js/jquery.min.js"></script>

<script>
$(document).on('submit', 'form#Affiliate_changePassword', function(event) {
    event.preventDefault();
    $('p.error_container').html("");
    $(".text-danger").html("");

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

                setTimeout(() => {
                    location.href =
                        `/affiliate-profile`;
                }, 1000);

            }
        },
        error: function(xhr) {
            $('.text-danger').empty(); // Clear previous errors

            if (xhr.status == '400') {
                toastr.error(xhr.responseJSON.message)
            }

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
</script>




@include('affiliatedUser.layout.footer')