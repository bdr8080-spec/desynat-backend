@include('affiliatedUser.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl">
        <div class="title24">My Withdrawals </div>
    </div>


    <div class="border-12 mb-4 mt-3 choose-date">
        <div class="d-flex justify-content-between date-header">
            <div class="total-balance">
                <div class="balance-title">Total Withdrawals</div>
                <div class="walletic d-flex gap-2 align-items-center mt-3">
                    <div class="wallet-ic-2">
                        <img src="http://www.desynat.com/user/assets/images/wallet-ic.svg" class="img-fluid">
                    </div>
                    <h5>
                        {{ 
                            intval($pendingReq['total_withdrawals']) == $pendingReq['total_withdrawals'] 
                                ? intval($pendingReq['total_withdrawals']) 
                                : number_format($pendingReq['total_withdrawals'], 2) 
                        }} KD
                    </h5>
                </div>
            </div>
            <!-- <div class="total-balance-2 d-flex gap-3 align-items-center">
                <a href="#" class="btn btn-export">Export</a>
                <a href="#" class="btn btn-export withdraw-bg"  data-bs-toggle="modal" data-bs-target="#Withdrawpop"> Withdraw</a>
            </div> -->
        </div>
    </div>

    <div class="my-earn">
        <div class="tabs-panel py-3">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item w-50" role="presentation">
                    <button class="nav-link active w-100" id="pills-upcoming-tab" data-bs-toggle="pill" data-bs-target="#pills-upcoming" type="button" role="tab" aria-controls="pills-upcoming" aria-selected="true">Upcoming</button>
                </li>
                <li class="nav-item w-50" role="presentation">
                    <button class="nav-link w-100" id="pills-completed-tab" data-bs-toggle="pill" data-bs-target="#pills-completed" type="button" role="tab" aria-controls="pills-completed" aria-selected="false"> Completed</button>
                </li>
            </ul>
        </div>    

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-upcoming" role="tabpanel" aria-labelledby="pills-upcoming-tab" tabindex="0">
                <div class="my-penal">
                    @foreach($pendingReq['withdraw_requests'] as $withdraw)
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between">
                            <div class="my-request">
                                <p class="text-muted mb-1">Request id </p>
                                <h6>#{{$withdraw['request_id']}}</h6>
                            </div>
                            <div class="my-request">
                                <p class="text-muted mb-1">Requested On </p>
                                <h6>{{ \Carbon\Carbon::parse($withdraw['created_at'])->format('d/m/Y \a\t h:i A') }}</h6>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <p class="text-muted mb-1"> Account No. </p>
                                <p>{{$withdraw['bank_details']['account_no']??'N/A'}} </p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-muted mb-1">Total Amount</p>
                                <p>{{$withdraw['amount']}} KD</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-muted mb-1">Status</p>
                                <p><span class="pending-text">
                                    @if($withdraw['admin_verify']=='0')
                                    Pending
                                    @elseif($withdraw['admin_verify']=='1')
                                    Accepted
                                    @else
                                    Rejected
                                    @endif
                                </span></p>
                            </div>
                        </div>
                        
                    </div>
                    @endforeach

                </div>

            </div>

            <div class="tab-pane fade" id="pills-completed" role="tabpanel" aria-labelledby="pills-completed-tab" tabindex="0">
                <div class="my-penal">
                    @foreach($approveRejectedReq['withdraw_requests'] as $withdraw)
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between">
                            <div class="my-request">
                                <p class="text-muted mb-1">Request id </p>
                                <h6>#{{$withdraw['request_id']}}</h6>
                            </div>
                            <div class="my-request">
                                <p class="text-muted mb-1">Requested On </p>
                                <h6>{{ \Carbon\Carbon::parse($withdraw['created_at'])->format('d/m/Y \a\t h:i A') }}</h6>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <p class="text-muted mb-1"> Account No. </p>
                                <p>{{$withdraw['bank_details']['account_no']??'N/A'}} </p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-muted mb-1">Total Amount</p>
                                <p>{{$withdraw['amount']}} KD</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-muted mb-1">Status</p>
                                <p>
                                    @if($withdraw->admin_verify == '1')
                                        <span style="color:#28a745;">Credit</span>
                                    @elseif($withdraw->admin_verify == '2')
                                        <span style="color:#E70000;">Rejected</span>
                                    @else
                                        <span class="pending-text">Pending</span>
                                    @endif
                                </p>
                            </div>
                            @if($withdraw->admin_verify == '2')
                            <div class="d-flex justify-content-between">
                                <p class="text-muted mb-1">Reason</p>
                                <p>
                                    {{$withdraw->reject_reason }}
                                </p>
                            </div>
                            @endif
                        </div>
                        
                    </div>
                    @endforeach
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

<script>
document.addEventListener("DOMContentLoaded", function() {
    //get active tab from local storage
    const lastTab = localStorage.getItem("activeTab");
    if (lastTab) {
        const triggerEl = document.querySelector(`#${lastTab}`);
        if (triggerEl) {
            const tab = new bootstrap.Tab(triggerEl);
            tab.show();
        }
    }
    //save active tab to local storage
    const tabButtons = document.querySelectorAll('button[data-bs-toggle="pill"]');
    tabButtons.forEach((button) => {
        button.addEventListener("shown.bs.tab", function() {
            localStorage.setItem("activeTab", this.id);
        });
    });
});
</script>




@include('affiliatedUser.layout.footer')