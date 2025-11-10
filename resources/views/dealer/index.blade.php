@include('dealer.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl">
        <div class="title24">Dashboard</div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-xxl-6">
            <div class="bg-header d-flex justify-content-between mt-3 align-items-center">
                <div class="title24">Store availability</div>
                <div class="d-flex gap-3">
                    <div class="buy">Busy/On</div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault">
                        <label class="form-check-label" for="switchCheckDefault"></label>
                    </div>
                </div>
            </div>

            <div class="py-4">
                <div class="title24">Total Products <span class="gold-title">(127)</span></div>
                <div class="row mt-3">
                    <div class="col-lg-6">
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
                    <div class="col-lg-6">
                        <div class="dash-box border20 shadow20 p20 pnl-flex">
                            <div class="dash-content">
                                <h5>In-Active</h5>
                                <div class="title30">50</div>
                            </div>
                            <div class="dash-circle">
                                <img src="{{ asset('dealer') }}/assets/img/box.svg" alt="icon" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-2">
                <div class="title24">Total Orders <span class="gold-title">(14)</span></div>
                <div class="row mt-3">
                    <div class="col-lg-6">
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
                    <div class="col-lg-6">
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
                    <div class="col-lg-6">
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
                    <div class="col-lg-6">
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

            <div class="py-4">
                <div class="title24">Total Staffs <span class="gold-title">(07)</span></div>
                <div class="row mt-3">
                    <div class="col-lg-6">
                        <div class="dash-box border20 shadow20 p20 pnl-flex py-3">
                            <div class="dash-content">
                                <h5>Active</h5>
                                <div class="title30">120</div>
                            </div>
                            <div class="dash-circle">
                                <img src="{{ asset('dealer') }}/assets/img/female.svg" alt="icon" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="dash-box border20 shadow20 p20 pnl-flex py-3">
                            <div class="dash-content">
                                <h5>In-Active</h5>
                                <div class="title30">50</div>
                            </div>
                            <div class="dash-circle">
                                <img src="{{ asset('dealer') }}/assets/img/female.svg" alt="icon" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-6 col-xxl-6">
            <div class="bg-header mt-3">
                <div class="group-radio-btn d-flex gap-4 align-items-center">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="radio" id="r1" checked>
                        <label class="form-check-label" for="r1">Today</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="radio" id="r2">
                        <label class="form-check-label" for="r2">This week</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="radio" id="r3">
                        <label class="form-check-label" for="r3">This Month</label>
                    </div>
                    <div class="show-date d-flex gap-2">
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


@include('dealer.layout.footer');
