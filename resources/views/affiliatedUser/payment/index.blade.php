@include('affiliatedUser.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl">
        <div class="title24">Payments </div>
    </div>

    <!-- <div class="search-field d-flex align-items-center py-4">
        <div class="from-group position-relative w-100">
            <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search" class="search-icon2">
            <input type="search" class="form-control py-3" placeholder="Search">
        </div>
        <button type="button" class="btn btn-success searchlin">Search</button>
    </div> -->
    <form action="{{ route('affiliate.payment') }}" method="GET">
        <div class="search-field d-flex align-items-center py-4">
            <div class="from-group position-relative w-100">
                <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" 
                    alt="search" class="search-icon2">

                <input type="search"
                    name="search"
                    class="form-control py-3"
                    placeholder="Search"
                    value="{{ request('search') }}">
            </div>

            <button type="submit" class="btn btn-success searchlin">
                Search
            </button>
        </div>
    </form>

    <div class="border-12 mb-3 mt-3 choose-date">
        <div class="d-flex justify-content-between date-header">
            <div class="total-balance">
                <div class="balance-title">Total Revenue</div>
                <div class="walletic d-flex gap-2 align-items-center mt-3">
                    <div class="wallet-ic-2">
                        <img src="http://www.desynat.com/user/assets/images/wallet-ic.svg" class="img-fluid">
                    </div>
                    <h5>
                      {{ 
                            intval($allOrders['total_earning']) == $allOrders['total_earning'] 
                                ? intval($allOrders['total_earning']) 
                                : number_format($allOrders['total_earning'], 2) 
                        }} KD
                    </h5>
                </div>
            </div>
            <div class="total-balance-2 d-flex gap-3 align-items-center">
                <a href="#" class="btn btn-export">Export</a>
                <a href="#" class="btn btn-export withdraw-bg"  data-bs-toggle="modal" data-bs-target="#Withdrawpop"> Withdraw</a>
            </div>
        </div>
    </div>

    <div class="my-earn">
        @foreach($allOrders['orders'] as $index => $order)
                        @php
                            $orderdetail = $order;

                            // Order status text
                            $statusText = match (true) {

                            // 1 → Cancelled Order
                            $orderdetail->payment_status == '2' || $orderdetail->payment_status == '3'
                            => 'Cancelled',

                            // 2 → confirmed
                            $orderdetail->delivery_status == '1' &&
                            $orderdetail->return_type == '0'
                            => 'Pending',

                            // 2 → Ongoing
                            $orderdetail->delivery_status == '2' || $orderdetail->delivery_status == '1' &&
                            $orderdetail->return_type == '0'
                            => 'Ongoing',

                            // 2.1 → shipped
                            $orderdetail->delivery_status == '2.1' &&
                            $orderdetail->return_type == '0'
                            => 'Shipped',

                            // 2.2 → shipped
                            $orderdetail->delivery_status == '2.2' &&
                            $orderdetail->return_type == '0'
                            => 'On The Way',

                            // 3 → Delivered
                            $orderdetail->delivery_status == '3' &&
                            $orderdetail->return_type == '0'
                            => 'Delivered',

                            // 4 → Cancelled
                            $orderdetail->payment_status == '2'
                            => 'Cancelled',

                            // 5 → Returned / Failed
                            $orderdetail->delivery_status == '3' && $orderdetail->return_type == '2'
                            => 'Exchange Request',

                            // 5 → Exchange / Failed
                            $orderdetail->delivery_status == '3' && $orderdetail->return_type == '1'
                            => 'Return Request',

                            // Default
                            default => 'On Going',
                            };

                            [$statusColor, $bgColor] = match ($statusText) {

                            'Delivered' => ['#28a745', '#28a7451A'],

                            'Cancelled' => ['#E70000', '#E700001A'],

                            "Exchange Request"=>['#FF5F1B', 'rgba(255, 95, 27, 0.1)'],
                            "Return Request"=>['#FF5F1B', 'rgba(255, 95, 27, 0.1)'],

                            default => ['#FF5F1B', '#79d69d1a'],
                            };
                        @endphp
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <div class="">
                    <p class="text-muted mb-1">My Earnings </p>
                    <h6>{{ $order['affiliate_commission'] }} KD </h6>
                </div>
                <div class="">
                    <p class="text-muted mb-1">My Earnings </p>
                    <h6>{{ $order['affiliate_commission'] }} KD </h6>
                </div>
            </div>

            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-1">Purchased by </p>
                    <p>{{ $order['user_details']['full_name'] }} </p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-1">Product name</p>
                    <p>{{ $order['product_details']['product_name_en'] }}</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-1">Category</p>
                    <p>{{ $order['product_details']['category']['name'] }}</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-1">Quantity</p>
                    <p>{{ $order['quantity'] }}</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-1">Total Amount</p>
                    <p>{{ $order['amount'] }} KD</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-1">Purchased on</p>
                    <p>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y \a\t h:i A') }}</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-1">Order status</p>
                    <p style="color: {{ $statusColor }}; background-color: {{ $bgColor }};
                            padding:4px 10px; border-radius:6px; font-size:13px;">
                        {{ $statusText }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach


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