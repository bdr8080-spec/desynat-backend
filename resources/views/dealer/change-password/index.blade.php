@include('dealer.layout.header')


<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <h3>Change Password</h3>
    </div>

    <div class="payment-box">
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group position-relative">
                <label for="password">Old Password</label>
                <input type="password" class="form-control notapplyspace" id="password"
                    placeholder="Enter Password" name="password">
                <i class="toggle-password  bi bi-eye-slash "></i>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group position-relative">
                <label for="password">Enter New Password</label>
                <input type="password" class="form-control notapplyspace" id="password"
                    placeholder="Enter New Password" name="password">
                <i class="toggle-password  bi bi-eye-slash "></i>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group position-relative">
                <label for="password">Confirm Password</label>
                <input type="password" class="form-control notapplyspace" id="password"
                    placeholder="Re-Enter Password" name="password">
                <i class="toggle-password  bi bi-eye-slash "></i>
            </div>
        </div>
    </div>
    
    <div class="login-btn mt-5 mb-3">
        <input type="submit" class="btn btn-success w-100" name="submit" value="Save">
    </div>

</div>


</div>



@include('dealer.layout.custom_code');
@include('dealer.layout.footer');

<script>
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




