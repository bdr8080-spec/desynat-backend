@include('affiliatedUser.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl">
        <div class="title24">Dashboard
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="bg-header mt-3 visitor-pnl">
                <div class="group-radio-btn d-flex gap-4 justify-content-between flex-wrap">
                    <div class="d-flex gap-4 align-items-center flex-wrap">
                        <div class="check_radio">
                            <label class="radio-group">
                                <input type="radio" name="today" checked>
                                <span class="custom-radio"></span>
                                <span class="radio-label">Today</span>
                            </label>
                        </div>
                        <div class="check_radio">
                            <label class="radio-group">
                                <input type="radio" name="today">
                                <span class="custom-radio"></span>
                                <span class="radio-label">This Week</span>
                            </label>
                        </div>
                        <div class="check_radio">
                            <label class="radio-group">
                                <input type="radio" name="today">
                                <span class="custom-radio"></span>
                                <span class="radio-label">This Month</span>
                            </label>
                        </div>
                    </div>
                    <div class="show-date d-flex gap-2  flex-wrap">
                        <div class="date-form-pnl">
                            <input type="date" class="form-control">
                        </div>
                        <div class="date-form-pnl">
                            <input type="date" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-xxl-6">
            <div class="py-4">
                <div class="dash-box border20 shadow20 p20 pnl-flex">
                    <div class="dash-content">
                        <h5>Active</h5>
                        <div class="title30">120</div>
                    </div>
                    <div class="dash-circle">
                        <img src="{{ asset('dealer') }}/assets/img/box.svg" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xxl-6">
            <div class="total-revenu border20 shadow20 p20 mt-4">
                <div class="total-revenu-box pnl-flex">
                    <div class="dash-content">
                        <h5>Total Revenue Generated</h5>
                        <h1 class="font-34 py-3">KD 12,542</h1>
                    </div>
                    <div class="total-revenu-image">
                        <img src="{{ asset('dealer') }}/assets/img/profit.svg" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-2">
        <div class="title24">Total Orders <span class="gold-title">(14)</span></div>
        <div class="row mt-3">
            <div class="col-lg-3 col-md-3">
                <div class="dash-box border20 shadow20 p20 pnl-flex mb-4">
                    <div class="dash-content">
                        <h5>New</h5>
                        <div class="title30">120</div>
                    </div>
                    <div class="dash-circle">
                        <img src="{{ asset('dealer') }}/assets/img/box.svg" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="dash-box border20 shadow20 p20 pnl-flex mb-3">
                    <div class="dash-content">
                        <h5>Ongoing</h5>
                        <div class="title30">50</div>
                    </div>
                    <div class="dash-circle">
                        <img src="{{ asset('dealer') }}/assets/img/box.svg" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="dash-box border20 shadow20 p20 pnl-flex">
                    <div class="dash-content">
                        <h5>Completed</h5>
                        <div class="title30">50</div>
                    </div>
                    <div class="dash-circle">
                        <img src="{{ asset('dealer') }}/assets/img/box.svg" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="dash-box border20 shadow20 p20 pnl-flex">
                    <div class="dash-content">
                        <h5>Cancelled</h5>
                        <div class="title30">51</div>
                    </div>
                    <div class="dash-circle">
                        <img src="{{ asset('dealer') }}/assets/img/box.svg" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>


<!-- Edit shipping Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="delete-body text-center p-3">
                    <div class="trash-box">
                        <i class="bi bi-trash3"></i>
                    </div>
                    <h4 class="domestic-title"> Are you sure you want to delete this domestic cost?</h4>
                </div>
                <div class="login-btn mt-4 d-flex justify-content-between gap-3">
                    <button type="button" class="btn btn-success w-100" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger-outline w-100">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

@include('affiliatedUser.layout.footer');