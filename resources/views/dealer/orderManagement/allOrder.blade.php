@include('dealer.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24">Order Management </div>
    </div>

    <div class="tabs-panel py-4">
        <ul class="nav nav-pills mb-3 nav-justified maintabs" id="pills-tab-Main" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active w-100" id="pills-allproduct-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-Normal-Order" type="button" role="tab" aria-controls="pills-allproduct"
                    aria-selected="true">Normal Orders </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link w-100" id="pills-active-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-Custom-Order" type="button" role="tab" aria-controls="pills-Custom-Order"
                    aria-selected="false">Customised Orders</button>
            </li>
        </ul>
    </div>

    <div class="tab-body-wapper">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-Normal-Order" role="tabpanel"
                aria-labelledby="pills-Normal-Order-tab" tabindex="0">
                <div class="mini-tabs-panel py-0">
                    <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active w-100" id="pills-all-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-all"
                                aria-selected="true">All ({{count($normal['All_order'])}}) </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link w-100" id="pills-ongoing-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-ongoing" type="button" role="tab" aria-controls="pills-ongoing"
                                aria-selected="false">Ongoing orders ({{count($normal['ongoing_order'])}})</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link w-100" id="pills-past-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-past" type="button" role="tab" aria-controls="pills-past"
                                aria-selected="false">Past orders ({{count($normal['past_order'])}})</button>
                        </li>
                    </ul>
                </div>


                <div class="ongoing-wapper">
                    <div class="tab-content" id="pills-tabContent2">
                        <div class="tab-pane fade show active" id="pills-all" role="tabpanel"
                            aria-labelledby="pills-all-tab" tabindex="0">
                            <div class="table-header mb-0 pt-3">
                                <div class="search-field">
                                    <div class="from-group position-relative">
                                        <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search"
                                            class="search-icon">
                                        <input type="search" class="dt-input tableSearch form-control"
                                            placeholder="Search">
                                    </div>
                                </div>

                                <form method="GET" action="">

                                    <div class="search-filter">
                                        <div class="from-group">
                                            <div class="show-date d-flex gap-2  flex-wrap">
                                                <div class="date-form-pnl-2">
                                                    <input type="date" class="form-control" name="from">
                                                </div>
                                                <div class="date-form-pnl-2">
                                                    <input type="date" class="form-control" name="to">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="from-group">
                                            <select class="form-select form-control width-50"
                                                aria-label="Default select example">
                                                <option value="">Filter by status</option>
                                                <option value="1"> Confirmed </option>
                                                <option value="2"> Packed </option>
                                                <option value="3"> Shipped </option>
                                                <option value="4"> Exchange </option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <thead>
                                        <tr>
                                            <th class="no-sort">S.No</th>
                                            <th class="no-sort">Image</th>
                                            <th class="no-sort">Order ID</th>
                                            <th class="no-sort">Date & Time</th>
                                            <th class="no-sort">Product Name</th>
                                            <th class="no-sort">Quantity</th>
                                            <th class="no-sort">Customer Name</th>
                                            <th class="no-sort">Location</th>
                                            <th class="no-sort">Total Amount</th>
                                            <th class="no-sort">Admin Commission</th>
                                            <th class="no-sort">View Details</th>
                                            <th class="no-sort">Product Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($normal['All_order'] as $key => $val)

                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>
                                                <img src="{{$val->variation_details->variant_image['0']}}"
                                                    class="img-fluid" alt="image" class="pro-image"
                                                    style="width: 80px;height: 80px;border-radius: 5%;object-fit: cover;">
                                            </td>
                                            <td> {{$val->id}}</td>
                                            <td>{{$val->created_at}} </td>
                                            <td>{{$val->product_details->product_name_en}}</td>
                                            <td> {{$val->quantity}}</td>
                                            <td>{{$val->order->user_details->full_name}}</td>
                                            <td>{{$val->order->delivery_details->address}}</td>
                                            <td>{{$val->amount}}</td>
                                            <td>{{$val->admin_commission}}</td>

                                            <td>
                                                <a href="{{ route('seller.single_order_View', $val->id ) }}"
                                                    class="eyebtn"><i class="bi bi-eye"></i></a>
                                            </td>
                                            <td>

                                                @php
                                                $order = $val->order;
                                                $orderdetail = $val;

                                                $product = $orderdetail->product_details;
                                                $variant = $orderdetail->variation_details;
                                                $color = $variant->color ?? null;
                                                $size = $variant->size ?? null;

                                                // Handle variant image (array or JSON)
                                                if (is_array($variant->variant_image)) {
                                                $images = $variant->variant_image;
                                                } else {
                                                $images = json_decode($variant->variant_image ?? '[]', true);
                                                }

                                                $image = $images[0] ?? asset('user/assets/images/categorie1.png');

                                                // Order status text
                                                $statusText = match (true) {

                                                // 1 → Cancelled Order
                                                $orderdetail->payment_status == '2' || $orderdetail->payment_status ==
                                                '3'
                                                => 'Cancelled',

                                                // 2 → confirmed
                                                $orderdetail->delivery_status == '1' &&
                                                $orderdetail->return_type == '0'
                                                => 'Ongoing',

                                                // 2 → Ongoing
                                                $orderdetail->delivery_status == '2' || $orderdetail->delivery_status ==
                                                '1' &&
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

                                                <div class="from-group">

                                                    <!-- <select class="form-select form-control"
                                                        aria-label="Default select example">
                                                        <option value="1"> Confirmed </option>
                                                        <option value="2"> Packed </option>
                                                        <option value="3"> Shipped </option>

                                                        <option value="4"> Exchange </option>
                                                        <option value="4"> Exchange </option>
                                                    </select> -->
                                                    <div class="ongoing-title" style="color:{{ $statusColor }}">
                                                        {{ $statusText }}
                                                    </div>

                                                </div>
                                            </td>
                                        </tr>

                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-ongoing" role="tabpanel"
                            aria-labelledby="pills-ongoing-tab" tabindex="0">
                            <div class="table-header mb-0 pt-3">
                                <div class="search-field">
                                    <div class="from-group position-relative">
                                        <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search"
                                            class="search-icon">
                                        <input type="search" class="dt-input tableSearch form-control"
                                            placeholder="Search">
                                    </div>
                                </div>

                                <form method="GET" action="">

                                    <div class="search-filter">
                                        <div class="from-group">
                                            <div class="show-date d-flex gap-2  flex-wrap">
                                                <div class="date-form-pnl-2">
                                                    <input type="date" class="form-control" name="from">
                                                </div>
                                                <div class="date-form-pnl-2">
                                                    <input type="date" class="form-control" name="to">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="from-group">
                                            <select class="form-select form-control width-50"
                                                aria-label="Default select example">
                                                <option value="">Filter by status</option>
                                                <option value="1"> Confirmed </option>
                                                <option value="2"> Packed </option>
                                                <option value="3"> Shipped </option>
                                                <option value="4"> Exchange </option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <thead>
                                        <tr>
                                            <th class="no-sort">S.No</th>
                                            <th class="no-sort">Image</th>
                                            <th class="no-sort">Order ID</th>
                                            <th class="no-sort">Date & Time</th>
                                            <th class="no-sort">Product Name</th>
                                            <th class="no-sort">Quantity</th>
                                            <th class="no-sort">Customer Name</th>
                                            <th class="no-sort">Location</th>
                                            <th class="no-sort">Total Amount</th>
                                            <th class="no-sort">Admin Commission</th>
                                            <th class="no-sort">View Details</th>
                                            <th class="no-sort">Product Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($normal['ongoing_order'] as $key => $val)

                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>
                                                <img src="{{$val->variation_details->variant_image['0']}}"
                                                    class="img-fluid" alt="image" class="pro-image"
                                                    style="width: 80px;height: 80px;border-radius: 5%;object-fit: cover;">
                                            </td>
                                            <td> {{$val->id}}</td>
                                            <td>{{$val->created_at}} </td>
                                            <td>{{$val->product_details->product_name_en}}</td>
                                            <td> {{$val->quantity}}</td>
                                            <td>{{$val->order->user_details->full_name}}</td>
                                            <td>{{$val->order->delivery_details->address}}</td>
                                            <td>{{$val->amount}}</td>
                                            <td>{{$val->admin_commission}}</td>

                                            <td>
                                                <a href="{{ route('seller.single_order_View', $val->id ) }}"
                                                    class="eyebtn"><i class="bi bi-eye"></i></a>
                                            </td>
                                            <td>
                                                <!-- <div class="from-group">
                                                    <select class="form-select form-control"
                                                        aria-label="Default select example">
                                                        <option value="1"> Confirmed </option>
                                                        <option value="2"> Packed </option>
                                                        <option value="3"> Shipped </option>
                                                        <option value="4"> Exchange </option>
                                                    </select>
                                                </div> -->


                                                @php
                                                $order = $val->order;
                                                $orderdetail = $val;

                                                $product = $orderdetail->product_details;
                                                $variant = $orderdetail->variation_details;
                                                $color = $variant->color ?? null;
                                                $size = $variant->size ?? null;

                                                // Handle variant image (array or JSON)
                                                if (is_array($variant->variant_image)) {
                                                $images = $variant->variant_image;
                                                } else {
                                                $images = json_decode($variant->variant_image ?? '[]', true);
                                                }

                                                $image = $images[0] ?? asset('user/assets/images/categorie1.png');

                                                // Order status text
                                                $statusText = match (true) {

                                                // 1 → Cancelled Order
                                                $orderdetail->payment_status == '2' || $orderdetail->payment_status ==
                                                '3'
                                                => 'Cancelled',

                                                // 2 → confirmed
                                                $orderdetail->delivery_status == '1' &&
                                                $orderdetail->return_type == '0'
                                                => 'Ongoing',

                                                // 2 → Ongoing
                                                $orderdetail->delivery_status == '2' || $orderdetail->delivery_status ==
                                                '1' &&
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

                                                <div class="from-group">

                                                    <!-- <select class="form-select form-control"
                                                        aria-label="Default select example">
                                                        <option value="1"> Confirmed </option>
                                                        <option value="2"> Packed </option>
                                                        <option value="3"> Shipped </option>

                                                        <option value="4"> Exchange </option>
                                                        <option value="4"> Exchange </option>
                                                    </select> -->
                                                    <div class="ongoing-title" style="color:{{ $statusColor }}">
                                                        {{ $statusText }}
                                                    </div>

                                                </div>

                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-past" role="tabpanel" aria-labelledby="pills-past-tab"
                            tabindex="0">
                            <div class="table-header mb-0 pt-3">
                                <div class="search-field">
                                    <div class="from-group position-relative">
                                        <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search"
                                            class="search-icon">
                                        <input type="search" class="dt-input tableSearch form-control"
                                            placeholder="Search">
                                    </div>
                                </div>

                                <form method="GET" action="">

                                    <div class="search-filter">
                                        <div class="from-group">
                                            <div class="show-date d-flex gap-2  flex-wrap">
                                                <div class="date-form-pnl-2">
                                                    <input type="date" class="form-control" name="from">
                                                </div>
                                                <div class="date-form-pnl-2">
                                                    <input type="date" class="form-control" name="to">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="from-group">
                                            <select class="form-select form-control width-50"
                                                aria-label="Default select example">
                                                <option value="">Filter by status</option>
                                                <option value="1"> Confirmed </option>
                                                <option value="2"> Packed </option>
                                                <option value="3"> Shipped </option>
                                                <option value="4"> Exchange </option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <thead>
                                        <tr>
                                            <th class="no-sort">S.No</th>
                                            <th class="no-sort">Image</th>
                                            <th class="no-sort">Order ID</th>
                                            <th class="no-sort">Date & Time</th>
                                            <th class="no-sort">Product Name</th>
                                            <th class="no-sort">Quantity</th>
                                            <th class="no-sort">Customer Name</th>
                                            <th class="no-sort">Location</th>
                                            <th class="no-sort">Total Amount</th>
                                            <th class="no-sort">Admin Commission</th>
                                            <th class="no-sort">View Details</th>
                                            <th class="no-sort">Product Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($normal['past_order'] as $key => $val)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>
                                                <img src="{{$val->variation_details->variant_image['0']}}"
                                                    class="img-fluid" alt="image" class="pro-image"
                                                    style="width: 80px;height: 80px;border-radius: 5%;object-fit: cover;">
                                            </td>
                                            <td> {{$val->id}}</td>
                                            <td>{{$val->created_at}} </td>
                                            <td>{{$val->product_details->product_name_en}}</td>
                                            <td> {{$val->quantity}}</td>
                                            <td>{{$val->order->user_details->full_name}}</td>
                                            <td>{{$val->order->delivery_details->address}}</td>
                                            <td>{{$val->amount}}</td>
                                            <td>{{$val->admin_commission}}</td>

                                            <td>
                                                <a href="{{ route('seller.single_order_View', $val->id ) }}"
                                                    class="eyebtn"><i class="bi bi-eye"></i></a>
                                            </td>
                                            <td>
                                                <!-- <div class="from-group-list">
                                                    <div style="color:#16B364;">Delivered</div>
                                                    <div style="color:#FF5F1B;">Returned</div>
                                                        <div style="color:#D53B36;">Cancelled</div>
                                                        <div style="color:#FF5F1B;">Exchange</div>
                                                </div> -->

                                                @php
                                                $order = $val->order;
                                                $orderdetail = $val;

                                                $product = $orderdetail->product_details;
                                                $variant = $orderdetail->variation_details;
                                                $color = $variant->color ?? null;
                                                $size = $variant->size ?? null;

                                                // Handle variant image (array or JSON)
                                                if (is_array($variant->variant_image)) {
                                                $images = $variant->variant_image;
                                                } else {
                                                $images = json_decode($variant->variant_image ?? '[]', true);
                                                }

                                                $image = $images[0] ?? asset('user/assets/images/categorie1.png');

                                                // Order status text
                                                $statusText = match (true) {

                                                // 1 → Cancelled Order
                                                $orderdetail->payment_status == '2' || $orderdetail->payment_status ==
                                                '3'
                                                => 'Cancelled',

                                                // 2 → confirmed
                                                $orderdetail->delivery_status == '1' &&
                                                $orderdetail->return_type == '0'
                                                => 'Ongoing',

                                                // 2 → Ongoing
                                                $orderdetail->delivery_status == '2' || $orderdetail->delivery_status ==
                                                '1' &&
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

                                                <div class="from-group">

                                                    <!-- <select class="form-select form-control"
                                                        aria-label="Default select example">
                                                        <option value="1"> Confirmed </option>
                                                        <option value="2"> Packed </option>
                                                        <option value="3"> Shipped </option>

                                                        <option value="4"> Exchange </option>
                                                        <option value="4"> Exchange </option>
                                                    </select> -->
                                                    <div class="ongoing-title" style="color:{{ $statusColor }}">
                                                        {{ $statusText }}
                                                    </div>

                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!---------------- End Normal Orders ----------------------->

            <div class="tab-pane fade" id="pills-Custom-Order" role="tabpanel" aria-labelledby="pills-Custom-Order-tab"
                tabindex="0">

                <div class="mini-tabs-panel py-0">
                    <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active w-100" id="pills-all2-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-all2" type="button" role="tab" aria-controls="pills-all2"
                                aria-selected="true">All ({{count($custom['All_order'])}}) </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link w-100" id="pills-ongoing2-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-ongoing2" type="button" role="tab" aria-controls="pills-ongoing2"
                                aria-selected="false">Ongoing orders ({{count($custom['ongoing_order'])}})</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link w-100" id="pills-past2-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-past2" type="button" role="tab" aria-controls="pills-past2"
                                aria-selected="false">Past orders ({{count($custom['past_order'])}})</button>
                        </li>
                    </ul>
                </div>


                <div class="ongoing-wapper">
                    <div class="tab-content" id="pills-tabContent2">
                        <div class="tab-pane fade show active" id="pills-all2" role="tabpanel"
                            aria-labelledby="pills-all2-tab" tabindex="0">
                            <div class="table-header mb-0 pt-3">
                                <div class="search-field">
                                    <div class="from-group position-relative">
                                        <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search"
                                            class="search-icon">
                                        <input type="search" class="dt-input tableSearch form-control"
                                            placeholder="Search">
                                    </div>
                                </div>

                                <form method="GET" action="">

                                    <div class="search-filter">
                                        <div class="from-group">
                                            <div class="show-date d-flex gap-2  flex-wrap">
                                                <div class="date-form-pnl-2">
                                                    <input type="date" class="form-control" name="from">
                                                </div>
                                                <div class="date-form-pnl-2">
                                                    <input type="date" class="form-control" name="to">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="from-group">
                                            <select class="form-select form-control width-50"
                                                aria-label="Default select example">
                                                <option value="">Filter by status</option>
                                                <option value="1"> Confirmed </option>
                                                <option value="2"> Packed </option>
                                                <option value="3"> Shipped </option>
                                                <option value="4"> Exchange </option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <thead>
                                        <tr>
                                            <th class="no-sort">S.No</th>
                                            <th class="no-sort">Image</th>
                                            <th class="no-sort">Order ID</th>
                                            <th class="no-sort">Date & Time</th>
                                            <th class="no-sort">Product Name</th>
                                            <th class="no-sort">Quantity</th>
                                            <th class="no-sort">Customer Name</th>
                                            <th class="no-sort">Location</th>
                                            <th class="no-sort">Total Amount</th>
                                            <th class="no-sort">Admin Commission</th>
                                            <th class="no-sort">View Details</th>
                                            <th class="no-sort">Product Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($custom['All_order'] as $key => $val)

                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>
                                                <img src="{{$val->variation_details->variant_image['0']}}"
                                                    class="img-fluid" alt="image" class="pro-image"
                                                    style="width: 80px;height: 80px;border-radius: 5%;object-fit: cover;">
                                            </td>
                                            <td> {{$val->id}}</td>
                                            <td>{{$val->created_at}} </td>
                                            <td>{{$val->product_details->product_name_en}}</td>
                                            <td> {{$val->quantity}}</td>
                                            <td>{{$val->order->user_details->full_name}}</td>
                                            <td>{{$val->order->delivery_details->address}}</td>
                                            <td>{{@$val->chatRoomrecords->price}} KD </td>
                                            <td>{{$val->admin_commission}}</td>
                                            <td>
                                                <a href="{{ route('seller.single_order_View', $val->id ) }}"
                                                    class="eyebtn"><i class="bi bi-eye"></i></a>
                                            </td>
                                            <td>

                                                <!-- <div class="from-group">
                                                    <select class="form-select form-control"
                                                        aria-label="Default select example">
                                                        <option value="1"> Confirmed </option>
                                                        <option value="2"> Packed </option>
                                                        <option value="3"> Shipped </option>
                                                        <option value="4"> Exchange </option>
                                                    </select>
                                                </div> -->


                                                @php
                                                $order = $val->order;
                                                $orderdetail = $val;

                                                $product = $orderdetail->product_details;
                                                $variant = $orderdetail->variation_details;
                                                $color = $variant->color ?? null;
                                                $size = $variant->size ?? null;

                                                // Handle variant image (array or JSON)
                                                if (is_array($variant->variant_image)) {
                                                $images = $variant->variant_image;
                                                } else {
                                                $images = json_decode($variant->variant_image ?? '[]', true);
                                                }

                                                $image = $images[0] ?? asset('user/assets/images/categorie1.png');

                                                // Order status text
                                                $statusText = match (true) {

                                                // 1 → Cancelled Order
                                                $orderdetail->payment_status == '2' || $orderdetail->payment_status ==
                                                '3'
                                                => 'Cancelled',

                                                // 2 → confirmed
                                                $orderdetail->delivery_status == '1' &&
                                                $orderdetail->return_type == '0'
                                                => 'Ongoing',

                                                // 2 → Ongoing
                                                $orderdetail->delivery_status == '2' || $orderdetail->delivery_status ==
                                                '1' &&
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

                                                <div class="from-group">

                                                    <!-- <select class="form-select form-control"
                                                        aria-label="Default select example">
                                                        <option value="1"> Confirmed </option>
                                                        <option value="2"> Packed </option>
                                                        <option value="3"> Shipped </option>

                                                        <option value="4"> Exchange </option>
                                                        <option value="4"> Exchange </option>
                                                    </select> -->
                                                    <div class="ongoing-title" style="color:{{ $statusColor }}">
                                                        {{ $statusText }}
                                                    </div>

                                                </div>



                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-ongoing2" role="tabpanel"
                            aria-labelledby="pills-ongoing2-tab" tabindex="0">
                            <div class="table-header mb-0 pt-3">
                                <div class="search-field">
                                    <div class="from-group position-relative">
                                        <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search"
                                            class="search-icon">
                                        <input type="search" class="dt-input tableSearch form-control"
                                            placeholder="Search">
                                    </div>
                                </div>

                                <form method="GET" action="">

                                    <div class="search-filter">
                                        <div class="from-group">
                                            <div class="show-date d-flex gap-2  flex-wrap">
                                                <div class="date-form-pnl-2">
                                                    <input type="date" class="form-control" name="from">
                                                </div>
                                                <div class="date-form-pnl-2">
                                                    <input type="date" class="form-control" name="to">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="from-group">
                                            <select class="form-select form-control width-50"
                                                aria-label="Default select example">
                                                <option value="">Filter by status</option>
                                                <option value="1"> Confirmed </option>
                                                <option value="2"> Packed </option>
                                                <option value="3"> Shipped </option>
                                                <option value="4"> Exchange </option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <thead>
                                        <tr>
                                            <th class="no-sort">S.No</th>
                                            <th class="no-sort">Image</th>
                                            <th class="no-sort">Order ID</th>
                                            <th class="no-sort">Date & Time</th>
                                            <th class="no-sort">Product Name</th>
                                            <th class="no-sort">Quantity</th>
                                            <th class="no-sort">Customer Name</th>
                                            <th class="no-sort">Location</th>
                                            <th class="no-sort">Total Amount</th>
                                            <th class="no-sort">Admin Commission</th>
                                            <th class="no-sort">View Details</th>
                                            <th class="no-sort">Product Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($custom['ongoing_order'] as $key => $val)

                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>
                                                <img src="{{$val->variation_details->variant_image['0']}}"
                                                    class="img-fluid" alt="image" class="pro-image"
                                                    style="width: 80px;height: 80px;border-radius: 5%;object-fit: cover;">
                                            </td>
                                            <td> {{$val->id}}</td>
                                            <td>{{$val->created_at}} </td>
                                            <td>{{$val->product_details->product_name_en}}</td>
                                            <td> {{$val->quantity}}</td>
                                            <td>{{$val->order->user_details->full_name}}</td>
                                            <td>{{$val->order->delivery_details->address}}</td>
                                            <td>{{@$val->chatRoomrecords->price}} KD</td>

                                            <td>{{$val->admin_commission}}</td>

                                            <td>
                                                <a href="{{ route('seller.single_order_View', $val->id ) }}"
                                                    class="eyebtn"><i class="bi bi-eye"></i></a>
                                            </td>
                                            <td>
                                                <!-- <div class="from-group">
                                                    <select class="form-select form-control"
                                                        aria-label="Default select example">
                                                        <option value="1"> Confirmed </option>
                                                        <option value="2"> Packed </option>
                                                        <option value="3"> Shipped </option>
                                                        <option value="4"> Exchange </option>
                                                    </select>
                                                </div> -->


                                                @php
                                                $order = $val->order;
                                                $orderdetail = $val;

                                                $product = $orderdetail->product_details;
                                                $variant = $orderdetail->variation_details;
                                                $color = $variant->color ?? null;
                                                $size = $variant->size ?? null;

                                                // Handle variant image (array or JSON)
                                                if (is_array($variant->variant_image)) {
                                                $images = $variant->variant_image;
                                                } else {
                                                $images = json_decode($variant->variant_image ?? '[]', true);
                                                }

                                                $image = $images[0] ?? asset('user/assets/images/categorie1.png');

                                                // Order status text
                                                $statusText = match (true) {

                                                // 1 → Cancelled Order
                                                $orderdetail->payment_status == '2' || $orderdetail->payment_status ==
                                                '3'
                                                => 'Cancelled',

                                                // 2 → confirmed
                                                $orderdetail->delivery_status == '1' &&
                                                $orderdetail->return_type == '0'
                                                => 'Ongoing',

                                                // 2 → Ongoing
                                                $orderdetail->delivery_status == '2' || $orderdetail->delivery_status ==
                                                '1' &&
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

                                                <div class="from-group">

                                                    <!-- <select class="form-select form-control"
                                                        aria-label="Default select example">
                                                        <option value="1"> Confirmed </option>
                                                        <option value="2"> Packed </option>
                                                        <option value="3"> Shipped </option>

                                                        <option value="4"> Exchange </option>
                                                        <option value="4"> Exchange </option>
                                                    </select> -->
                                                    <div class="ongoing-title" style="color:{{ $statusColor }}">
                                                        {{ $statusText }}
                                                    </div>

                                                </div>

                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-past2" role="tabpanel" aria-labelledby="pills-past2-tab"
                            tabindex="0">
                            <div class="table-header mb-0 pt-3">
                                <div class="search-field">
                                    <div class="from-group position-relative">
                                        <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search"
                                            class="search-icon">
                                        <input type="search" class="dt-input tableSearch form-control"
                                            placeholder="Search">
                                    </div>
                                </div>

                                <form method="GET" action="">

                                    <div class="search-filter">
                                        <div class="from-group">
                                            <div class="show-date d-flex gap-2  flex-wrap">
                                                <div class="date-form-pnl-2">
                                                    <input type="date" class="form-control" name="from">
                                                </div>
                                                <div class="date-form-pnl-2">
                                                    <input type="date" class="form-control" name="to">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="from-group">
                                            <select class="form-select form-control width-50"
                                                aria-label="Default select example">
                                                <option value="">Filter by status</option>
                                                <option value="1"> Confirmed </option>
                                                <option value="2"> Packed </option>
                                                <option value="3"> Shipped </option>
                                                <option value="4"> Exchange </option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <thead>
                                        <tr>
                                            <th class="no-sort">S.No</th>
                                            <th class="no-sort">Image</th>
                                            <th class="no-sort">Order ID</th>
                                            <th class="no-sort">Date & Time</th>
                                            <th class="no-sort">Product Name</th>
                                            <th class="no-sort">Quantity</th>
                                            <th class="no-sort">Customer Name</th>
                                            <th class="no-sort">Location</th>
                                            <th class="no-sort">Total Amount</th>
                                            <th class="no-sort">Admin Commission</th>
                                            <th class="no-sort">View Details</th>
                                            <th class="no-sort">Product Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($custom['past_order'] as $key => $val)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>
                                                <img src="{{$val->variation_details->variant_image['0']}}"
                                                    class="img-fluid" alt="image" class="pro-image"
                                                    style="width: 80px;height: 80px;border-radius: 5%;object-fit: cover;">
                                            </td>
                                            <td> {{$val->id}}</td>
                                            <td>{{$val->created_at}} </td>
                                            <td>{{$val->product_details->product_name_en}}</td>
                                            <td> {{$val->quantity}}</td>
                                            <td>{{$val->order->user_details->full_name}}</td>
                                            <td>{{$val->order->delivery_details->address}}</td>
                                            <td>{{@$val->chatRoomrecords->price}} KD </td>
                                            <td>{{$val->admin_commission}}</td>

                                            <td>
                                                <a href="{{ route('seller.single_order_View', $val->id ) }}"
                                                    class="eyebtn"><i class="bi bi-eye"></i></a>
                                            </td>
                                            <td>
                                                <!-- <div class="from-group-list">
                                                    <div style="color:#16B364;">Delivered</div> -->
                                                <!-- <div style="color:#FF5F1B;">Returned</div>
                                                        <div style="color:#D53B36;">Cancelled</div>
                                                        <div style="color:#FF5F1B;">Exchange</div> -->
                                                <!-- </div> -->


                                                @php
                                                $order = $val->order;
                                                $orderdetail = $val;

                                                $product = $orderdetail->product_details;
                                                $variant = $orderdetail->variation_details;
                                                $color = $variant->color ?? null;
                                                $size = $variant->size ?? null;

                                                // Handle variant image (array or JSON)
                                                if (is_array($variant->variant_image)) {
                                                $images = $variant->variant_image;
                                                } else {
                                                $images = json_decode($variant->variant_image ?? '[]', true);
                                                }

                                                $image = $images[0] ?? asset('user/assets/images/categorie1.png');

                                                // Order status text
                                                $statusText = match (true) {

                                                // 1 → Cancelled Order
                                                $orderdetail->payment_status == '2' || $orderdetail->payment_status ==
                                                '3'
                                                => 'Cancelled',

                                                // 2 → confirmed
                                                $orderdetail->delivery_status == '1' &&
                                                $orderdetail->return_type == '0'
                                                => 'Ongoing',

                                                // 2 → Ongoing
                                                $orderdetail->delivery_status == '2' || $orderdetail->delivery_status ==
                                                '1' &&
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

                                                <div class="from-group">

                                                    <!-- <select class="form-select form-control"
                                                        aria-label="Default select example">
                                                        <option value="1"> Confirmed </option>
                                                        <option value="2"> Packed </option>
                                                        <option value="3"> Shipped </option>

                                                        <option value="4"> Exchange </option>
                                                        <option value="4"> Exchange </option>
                                                    </select> -->
                                                    <div class="ongoing-title" style="color:{{ $statusColor }}">
                                                        {{ $statusText }}
                                                    </div>

                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>

                </div>



            </div>

        </div>

    </div>

</section>

<script>
document.addEventListener("DOMContentLoaded", function() {

    /* ===============================
       MAIN TABS (Normal / Customised)
    ================================*/
    let mainTabKey = "active_main_tab";
    let savedMainTab = localStorage.getItem(mainTabKey);

    if (savedMainTab) {
        let mainTabBtn = document.querySelector(
            `[data-bs-target="${savedMainTab}"]`
        );
        if (mainTabBtn) {
            new bootstrap.Tab(mainTabBtn).show();
        }
    }

    document.querySelectorAll('#pills-tab-Main [data-bs-toggle="pill"]').forEach(tab => {
        tab.addEventListener("shown.bs.tab", function(e) {
            localStorage.setItem(
                mainTabKey,
                e.target.getAttribute("data-bs-target")
            );
        });
    });


    /* ===============================
       INNER TABS (All / Ongoing / Past)
    ================================*/
    let innerTabKey = "active_inner_tab";
    let savedInnerTab = localStorage.getItem(innerTabKey);

    if (savedInnerTab) {
        let innerTabBtn = document.querySelector(
            `[data-bs-target="${savedInnerTab}"]`
        );
        if (innerTabBtn) {
            new bootstrap.Tab(innerTabBtn).show();
        }
    }

    document.querySelectorAll('.mini-tabs-panel [data-bs-toggle="pill"]').forEach(tab => {
        tab.addEventListener("shown.bs.tab", function(e) {
            localStorage.setItem(
                innerTabKey,
                e.target.getAttribute("data-bs-target")
            );
        });
    });

});
</script>

@include('dealer.layout.custom_code');

@include('dealer.layout.footer');