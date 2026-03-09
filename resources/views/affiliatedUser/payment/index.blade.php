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
                <a href="#" class="btn btn-export withdraw-bg"  data-bs-toggle="modal" data-bs-target="#Withdrawpop"> Withdraw</a>
            </div>
        </div>
    </div>

    <div class="my-earn">

        <div class="card mb-4">
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


<!-- Withdraw money Modal -->
<div class="modal fade" id="Withdrawpop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-75">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Withdraw Money</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="search-field">
                    <div class="label-flex">
                        <label>Amount </label>
                    </div>
                    <div class="from-group position-relative w-100">
                        <span class="kd-icon">KD | </span>
                        <input type="text" class="form-control" placeholder="Enter amount">
                    </div>  
                </div>
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Select Account</label>
                    </div>
                    <div class="rounded-4 desc-box bg-white mb-3">
                       <div class="bankpnl d-flex justify-content-between align-items-center line2">
                           <div class="check_radio d-flex gap-2">
                               <label class="radio-group">
                                   <input type="radio" name="today" checked>
                                   <span class="custom-radio"></span>
                                   <span class="radio-label"></span>
                               </label>
                               <div class="account-no">XXXX24234234</div>
                           </div>
                       </div>
                   </div>
   
                   <div class="addanother d-flex gap-2">
                       <i class="bi bi-plus-lg"></i> <h5 class="mb-0">Add New</h5>
                   </div>
   
                </div>
                
                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-success w-100 lh-2">Submit Request</button>
                </div>

            </div>
        </div>
    </div>
</div>



<script src="{{ asset('/dealer') }}/assets/custom-file/js/jquery.min.js"></script>





@include('affiliatedUser.layout.footer')