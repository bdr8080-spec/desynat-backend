@include('affiliatedUser.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl mb-5">
        <div class="title24"> Change Password </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div class="sub-form">
                <div class="label-flex">
                    <label>Old Password </label>
                </div>
                <input type="text" class="form-control" placeholder="Enter Password">
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="sub-form">
                <div class="label-flex">
                    <label>New Password</label>
                </div>
                <input type="text" class="form-control" placeholder="Enter New Password">
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="sub-form">
                <div class="label-flex">
                    <label>Confirm Password</label>
                </div>
                <input type="text" class="form-control" placeholder="Re-enter Password">
            </div>
        </div>
    </div>
    <div class="dashboard-button mt-5">
        <button type="submit" class="btn add-fillbtn w-100">Update</button>
    </div>



</section>




@include('affiliatedUser.layout.footer')