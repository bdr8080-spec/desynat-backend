@include('dealer.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24">Ticket Management</div>
    </div>

    <div class="search-field d-flex align-items-center py-4 gap-3">
        <div class="search-field d-flex align-items-center w-100">
            <div class="from-group position-relative w-100">
                <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search" class="search-icon2">
                <input type="search" name="search" class="form-control py-3" placeholder="Search" value="">
            </div>
            <button type="submit" class="btn btn-success searchlin"> Search </button>
        </div>
        <img src="{{ asset('user') }}/assets/images/add-icon.svg" alt="add icon">
    </div>


    <div class="ticket-pnl mt-5">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <div class="ticket">
                    <p class="text-muted mb-1">Ticket Type </p>
                </div>
                <div class="ticket">
                    <p class="text-muted mb-1"> Lorem Ipsum </p>
                </div>
            </div>

            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="text-muted mb-1">Ticket ID </p>
                    <p class="fst-500">723KL </p>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <p class="text-muted mb-1">Raised on</p>
                    <p class="fst-500">06 Apr 2026, 14:00 PM</p>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <p class="text-muted mb-1">Status</p>
                    <p class="fst-500">
                        <span class="text-red">In progress</span>
                    </p>
                </div>
            </div>
        </div>



    </div>





</section>





@include('dealer.layout.footer');
@include('dealer.product.ajax.datatablejs');