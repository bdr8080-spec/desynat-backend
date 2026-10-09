@include('dealer.layout.header')

<style>
    .paymentTitle p {
        font-size: 15px;
        line-height: 28px;
    }
    .btn-export{
    background: var(--all-btn-bg);
    border-radius: 4px;
    color:#fff;
    width: 130px;
    font-size:16px;
    }
</style>

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24"> Payments </div>
    </div>
    <div class="tabs-panel py-4">
        <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">

            <li class="nav-item" role="presentation">
                <button class="nav-link active w-100" id="pills-transactions-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-transactions" type="button" role="tab" aria-controls="pills-allproduct"
                    aria-selected="true">

                    All Transactions
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link w-100" id="pills-payouts-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-payouts" type="button" role="tab" aria-controls="pills-payouts"
                    aria-selected="false">

                    My Payouts
                </button>
            </li>
        </ul>
    </div>

    <div class="tab-body-wapper">
        <div class="tab-content" id="pills-tabContent">

            {{-- All transactions --}}
            <div class="tab-pane fade show active" id="pills-transactions" role="tabpanel"
                aria-labelledby="pills-transactions-tab" tabindex="0">

                <div class="datatable-wapper paymentTitle">
                    <div class="d-flex justify-content-between mb-4  align-items-center">
                        <div class="search-field">
                            <div class="from-group position-relative">
                                <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search" class="search-icon">
                                <input type="search" class="dt-input tableSearch form-control" id="customTableSearch"
                                    placeholder="{{__('seller_messages.search')}}" aria-controls="table1">
                            </div>
                        </div>
                        <div class="d-flex gap-4 align-items-center">
                            <div class="from-group">
                                <div class="total-refund d-flex gap-3">
                                    <h6>Total Revenue</h6>
                                    <h3>299 KD</h3>
                                </div>
                            </div>
                            <a href="#" class="btn btn-export">Export</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="ticket">
                                        <p class="text-muted mb-0"> Transaction ID</p>
                                         <p class="fst-500 mb-0">#97696</p>
                                    </div>
                                    <div class="ticket">
                                        <p class="text-muted mb-0"> Date & Time </p>
                                         <p class="fst-500 mb-0">03/09/2026 at 03:00 PM</p>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0"> Customer Name</p>
                                        <p class="fst-500 mb-0">Ajay Kumar</p>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0">Total Amount</p>
                                        <p class="fst-500 mb-0">
                                            299 KD
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0">Total Commission</p>
                                        <p class="fst-500 mb-0">
                                            299 KD
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0">Payment Mode</p>
                                        <p class="fst-500 mb-0">
                                            UPI
                                        </p>
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="ticket">
                                        <p class="text-muted mb-0"> Transaction ID</p>
                                         <p class="fst-500 mb-0">#97696</p>
                                    </div>
                                    <div class="ticket">
                                        <p class="text-muted mb-0"> Date & Time </p>
                                         <p class="fst-500 mb-0">03/09/2026 at 03:00 PM</p>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0"> Customer Name</p>
                                        <p class="fst-500 mb-0">Ajay Kumar</p>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0">Total Amount</p>
                                        <p class="fst-500 mb-0">
                                            299 KD
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0">Total Commission</p>
                                        <p class="fst-500 mb-0">
                                            299 KD
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0">Payment Mode</p>
                                        <p class="fst-500 mb-0">
                                            UPI
                                        </p>
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="ticket">
                                        <p class="text-muted mb-0"> Transaction ID</p>
                                         <p class="fst-500 mb-0">#97696</p>
                                    </div>
                                    <div class="ticket">
                                        <p class="text-muted mb-0"> Date & Time </p>
                                         <p class="fst-500 mb-0">03/09/2026 at 03:00 PM</p>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0"> Customer Name</p>
                                        <p class="fst-500 mb-0">Ajay Kumar</p>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0">Total Amount</p>
                                        <p class="fst-500 mb-0">
                                            299 KD
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0">Total Commission</p>
                                        <p class="fst-500 mb-0">
                                            299 KD
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0">Payment Mode</p>
                                        <p class="fst-500 mb-0">
                                            UPI
                                        </p>
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            {{-- Payouts --}}
            <div class="tab-pane fade" id="pills-payouts" role="tabpanel" aria-labelledby="pills-payouts-tab"
                tabindex="0">

                 <div class="datatable-wapper paymentTitle">
                    
                     <div class="d-flex justify-content-between mb-4  align-items-center">
                        <div class="search-field">
                            <div class="from-group position-relative">
                                <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search" class="search-icon">
                                <input type="search" class="dt-input tableSearch form-control" id="customTableSearch"
                                    placeholder="{{__('seller_messages.search')}}" aria-controls="table1">
                            </div>
                        </div>
                        <div class="d-flex gap-4 align-items-center">
                            <div class="from-group">
                                <div class="total-refund d-flex gap-3">
                                   <h6>Total Payout Received</h6>
                                    <h3>299 KD</h3>
                                </div>
                            </div>
                            <a href="#" class="btn btn-export">Export</a>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="ticket">
                                        <p class="text-muted mb-0"> From</p>
                                         <p class="fst-500 mb-0">03/09/2026</p>
                                    </div>
                                    <div class="ticket">
                                        <p class="text-muted mb-0"> To</p>
                                         <p class="fst-500 mb-0">03/09/2026</p>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0"> Transaction ID</p>
                                        <p class="fst-500 mb-0">#87676</p>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0">Payout received at</p>
                                        <p class="fst-500 mb-0">03/09/2026 at 03:00 PM</p>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0">Total Amount received </p>
                                        <p class="fst-500 mb-0">
                                            299 KD
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0">Total Commission</p>
                                        <p class="fst-500 mb-0">
                                            10 kD
                                        </p>
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                         <div class="col-lg-4">
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="ticket">
                                        <p class="text-muted mb-0"> From</p>
                                         <p class="fst-500 mb-0">03/09/2026</p>
                                    </div>
                                    <div class="ticket">
                                        <p class="text-muted mb-0"> To</p>
                                         <p class="fst-500 mb-0">03/09/2026</p>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0"> Transaction ID</p>
                                        <p class="fst-500 mb-0">#87676</p>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0">Payout received at</p>
                                        <p class="fst-500 mb-0">03/09/2026 at 03:00 PM</p>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0">Total Amount received </p>
                                        <p class="fst-500 mb-0">
                                            299 KD
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0">Total Commission</p>
                                        <p class="fst-500 mb-0">
                                            10 kD
                                        </p>
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                       
                       
                    </div>

                </div>

            </div>

        </div>
    </div>

</section>



@include('dealer.layout.custom_code');
@include('dealer.layout.footer');