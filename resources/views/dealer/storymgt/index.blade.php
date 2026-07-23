@include('dealer.layout.header')


@php
$menu_permission=SellermenuPermission();

$can_view=$menu_permission['can_view'];
$can_action=$menu_permission['can_action'];

@endphp

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24"> Story Management </div>
    </div>

    <form method="GET">
        <div class="search-field d-flex align-items-center py-4 gap-3">
            <div class="search-field d-flex align-items-center w-100">
                <div class="from-group position-relative w-100">
                    <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search" class="search-icon2">
                    <input type="search" name="search" class="form-control py-3"
                        placeholder="{{ __('seller_messages.Search') }}">
                </div>
                <button type="submit" class="btn btn-success searchlin"> {{ __('seller_messages.Search') }} </button>
            </div>

            <a href="#"><img src="{{ asset('user') }}/assets/images/add-icon.svg" alt="add icon"
                    class="add_ticket-btn"></a>

        </div>
    </form>


    <div class="ticket-pnl mt-0 storypnl">
        <div class="filtericon">
            <i class="bi bi-funnel" data-bs-toggle="modal" data-bs-target="#storyfilter"></i>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="card mb-4 w-100">
                    <div class="story-figure">
                        <img src="{{ asset('dealer') }}/assets/img/reel-5.jpeg" alt="image" class="img-fluid">
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted mb-1"> Request ID </p>
                            <p class="fst-500">#7677678</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted mb-1"> Total Amount </p>
                            <p class="fst-500">400 KD</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted mb-1"> Requested on </p>
                            <p class="fst-500">21/07/2026 at 10:15 AM</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted mb-1"> Status </p>
                            <p class="fst-500">Pending</p>
                        </div>

                        <div class="pt-3 text-center">
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#storyGrid"
                                class="btn btn-success w-100">Pay Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4">
                <div class="card mb-4 w-100">
                    <div class="story-figure">
                        <img src="{{ asset('dealer') }}/assets/img/reel-5.jpeg" alt="image" class="img-fluid">
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted mb-1"> Request ID </p>
                            <p class="fst-500">#7677678</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted mb-1"> Total Amount </p>
                            <p class="fst-500">400 KD</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted mb-1"> Requested on </p>
                            <p class="fst-500">21/07/2026 at 10:15 AM</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted mb-1"> Status </p>
                            <p class="fst-500">Pending</p>
                        </div>

                        <div class="pt-3 text-center">
                            <a href="#" class="btn btn-success w-100">Pay Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="card mb-4 w-100">
                    <div class="story-figure">
                        <img src="{{ asset('dealer') }}/assets/img/reel-5.jpeg" alt="image" class="img-fluid">
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted mb-1"> Request ID </p>
                            <p class="fst-500">#7677678</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted mb-1"> Total Amount </p>
                            <p class="fst-500">400 KD</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted mb-1"> Requested on </p>
                            <p class="fst-500">21/07/2026 at 10:15 AM</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted mb-1"> Status </p>
                            <p class="fst-500">Pending</p>
                        </div>


                    </div>
                </div>
            </div>
        </div>


    </div>



</section>


<!-- Pay now story Modal -->
<div class="modal fade" id="storyGrid" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5"> Details </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card mb-4 w-100">
                    <div class="story-figure">
                        <img src="{{ asset('dealer') }}/assets/img/reel-5.jpeg" alt="image" class="img-fluid">
                    </div>
                    <div class="card-body p-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted mb-1"> Request ID </p>
                            <p class="fst-500">#7677678</p>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted mb-1"> Requested on </p>
                            <p class="fst-500">21/07/2026 at 10:15 AM</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted mb-1"> Status </p>
                            <p class="fst-500">Pending</p>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <p class="text-muted mb-1"> Date Selected </p>
                    <p class="fst-500">21/07/2026</p>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <p class="text-muted mb-1"> Total Amount </p>
                    <p class="fst-500">400 KD</p>
                </div>


                <div class="cmn-btn mt-4">
                    <button type="button" class="btn add-fillbtn w-100">Pay Now</button>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- story filter Modal -->
<div class="modal fade" id="storyfilter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5"> Filter </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="form-check">
                    <input class="form-check-input action-checkbox" type="checkbox">
                    <label class="form-check-label">Active</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input action-checkbox" type="checkbox">
                    <label class="form-check-label">Pending</label>
                </div>

                <p class="text-muted mb-1 mt-3"> Filter By Date </p>
                <div class="d-flex justify-between gap-3">
                    <input type="date" class="form-control">
                    <input type="date" class="form-control">
                </div>

                <div class="cmn-btn mt-4 d-flex justify-between gap-3">
                    <button type="button" class="btn add-fillbtn w-100">Clear</button>
                    <button type="button" class="btn add-fillbtn w-100">Apply</button>
                </div>
            </div>

        </div>
    </div>
</div>



@include('dealer.layout.footer');
@include('dealer.product.ajax.datatablejs');