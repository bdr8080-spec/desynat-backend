@include('affiliatedUser.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl">
        <div class="title24">Payments </div>
    </div>

    <div class="search-field d-flex align-items-center py-4">
        <div class="from-group position-relative w-100">
            <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search" class="search-icon2">
            <input type="search" class="form-control py-3" placeholder="Search">
        </div>
        <button type="button" class="btn btn-success searchlin">Search</button>
    </div>

    <div class="border-12 mb-3 mt-3 choose-date">
        <div class="d-flex justify-content-between date-header">
            <div class="total-balance">
                <div class="balance-title">Total Revenue</div>
                <div class="walletic d-flex gap-2 align-items-center mt-3">
                    <div class="wallet-ic-2">
                        <img src="http://www.desynat.com/user/assets/images/wallet-ic.svg" class="img-fluid">
                    </div>
                    <h5>2532.55 KD</h5>
                </div>
            </div>
            <div class="total-balance-2 d-flex gap-3 align-items-center">
                <a href="#" class="btn btn-export">Export</a>
                <a href="#" class="btn btn-export withdraw-bg">Withdraw</a>
            </div>
        </div>
    </div>

    <div class="my-earn">

        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="">
                    <p class="text-muted mb-1">My Earnings </p>
                    <h6>250 KD </h6>
                </div>
                <div class="">
                    <p class="text-muted mb-1">My Earnings </p>
                    <h6>250 KD </h6>
                </div>
            </div>

            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-1">Purchased by </p>
                    <p>Atish </p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-1">Product name</p>
                    <p>Nike T-shirt</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-1">Category</p>
                    <p>Nike</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-1">Quantity</p>
                    <p>2</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-1">Total Amount</p>
                    <p>299 KD</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-1">Purchased on</p>
                    <p>21/08/2025 at 07:00 PM</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-1">Order status</p>
                    <p>Pending</p>
                </div>
            </div>
        </div>




    </div>




</section>




<script src="{{ asset('/dealer') }}/assets/custom-file/js/jquery.min.js"></script>





@include('affiliatedUser.layout.footer')