@include('dealer.layout.header')

@php
$menu_permission=SellermenuPermission();

$can_view=$menu_permission['can_view'];
$can_action=$menu_permission['can_action'];

@endphp

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24">Affiliated Commission</div>
    </div>

    <form id="editcommison" action="{{ route('seller.update_commison') }}" method="post">

        @csrf
        <div class="personl-wapper">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="sub-form">
                        <div class="label-flex">
                            <label>Set Commission % for affiliated customer</label>
                        </div>
                        <input type="text" class="form-control" placeholder="Eg. 5%"
                            value="{{$seller_details->affilate_commission}}" name="affilate_commission" min="0"
                            max="100" oninput="this.value = this.value.replace(/[^0-9]/g, ''); 
                if(this.value > 100) this.value = 100;" @if($can_action=='0') disabled @endif>
                        <p class="text-danger" id="error-affilate_commission"></p>
                    </div>
                </div>
            </div>

            @if($can_action=='1')
            
            <div class="dashboard-button mt-4">
                <button type="submit" class="btn add-fillbtn w-100">Save</button>
            </div>
            @endif

        </div>
    </form>


</section>
<script>
$(document).on('submit', 'form#editcommison', function(event) {
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
                    window.location = "{{ route('seller.update_commison') }}";
                }, 2000);
            }
        },
        error: function(xhr) {
            $('.text-danger').empty(); // Clear previous errors

            let errors = xhr.responseJSON.errors ?? xhr.responseJSON.data;

            $.each(errors, function(field, messages) {

                console.log(field);

                let errorId = "#error-" + field;

                $(errorId).html(messages[0]);


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
        // complete: function() {
        //     // Hide loader (after success or error)
        //     $('#loader').hide();
        // }


    });

    return false;
});
</script>

@include('dealer.layout.custom_code');



@include('dealer.layout.footer');