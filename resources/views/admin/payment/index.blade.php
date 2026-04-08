@extends('admin.layout.app')
@section('content')

<div class="inner-content management">

    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">Payment Management </h2>
        </div>
        <div class="col-lg-3 col-md-4 col-12">
            <div class="d-flex justify-content-end">
                <a class="btn btn-dark customBtn" href="#" role="button">
                    <span>Export in Excel or PDF</span>
                </a>
            </div>
        </div>


    </div>
    <div class="d-flex justify-content-center">
        <ul class="nav nav-pills tabs-pnl custom" id="pills-tab" role="tablist">
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-order-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order"
                    aria-selected="false">
                    By Order
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link active customBtn2 m-0" id="pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="true">
                    By Subcription Plan
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-return-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-return" type="button" role="tab" aria-controls="pills-return"
                    aria-selected="false">
                    By Gift Card
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-Banner-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-Banner" type="button" role="tab" aria-controls="pills-Banner"
                    aria-selected="false">
                    By Banner
                </button>
            </li>
        </ul>
    </div>
    <div class="userManagecontent">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab" tabindex="0">
                <div class="row">
                    <!-- From Date Filter -->
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from" name="from_date2" class="form-control" />
                        </div>
                    </div>

                    <!-- To Date Filter -->
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">To:</label>
                            <input type="date" id="to" name="to_date2" class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">Country</label>

                            <select name="country_id2" id="country_id" class="form-select form-select-lg">
                                <option value="">Select country</option>

                                <option value="">egjo</option>
                            </select>
                        </div>
                    </div>




                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="d-flex gap-3 justify-content-start" style="text-align: start">

                            <a class="btn btn-dark customBtn">
                                <span>Total Revenue:- KD 100000</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Transaction Id</th>
                                <th scope="col">Order Date & Time</th>
                                <th scope="col">Transaction Date & Time</th>
                                <th scope="col">Customer name</th>
                                <th scope="col">Seller name</th>
                                <th scope="col">Order Id</th>
                                <th scope="col">Country</th>
                                <th scope="col">Total Charges</th>
                                <th scope="col">Applied Promo Code</th>
                                <th scope="col">Discount</th>
                                <th scope="col">Commission</th>
                                <th scope="col">Payment Mode</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>#2345</td>
                                <td>Lorem</td>
                                <td>UAE</td>
                                <td>2nd July 2025 | 11 Am</td>
                                <td>KD 2000</td>
                                <td>KD 2000</td>
                                <td>XXXXXX626262</td>
                                <td>ygrfyr </td>
                                <td>ygrfyr </td>
                                <td>ygrfyr </td>
                                <td>ygrfyr </td>
                                <td>ygrfyr </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- approved -->
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                tabindex="0">
                <div class="row">
                    <!-- From Date Filter -->
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from" name="from_date2" class="form-control" />
                        </div>
                    </div>

                    <!-- To Date Filter -->
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">To:</label>
                            <input type="date" id="to" name="to_date2" class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">Country</label>

                            <select name="country_id2" id="country_id" class="form-select form-select-lg">
                                <option value="">Select country</option>

                                <option value="">egjo</option>
                            </select>
                        </div>
                    </div>




                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="d-flex gap-3 justify-content-start" style="text-align: start">

                            <a class="btn btn-dark customBtn">
                                <span>Total Revenue:- KD 100000</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Transaction ID</th>
                                <th scope="col">Seller Name</th>
                                <th scope="col">Country</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Plan Name</th>
                                <th scope="col">Date & Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>#2345</td>
                                <td>Lorem</td>
                                <td>UAE</td>
                                <td>2nd July 2025 | 11 Am</td>
                                <td>KD 2000</td>
                                <td>KD 2000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- rejected -->

            <div class="tab-pane fade" id="pills-return" role="tabpanel" aria-labelledby="pills-return-tab"
                tabindex="0">
                <div class="row">
                    <!-- From Date Filter -->
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from" name="from_date2" class="form-control" />
                        </div>
                    </div>

                    <!-- To Date Filter -->
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">To:</label>
                            <input type="date" id="to" name="to_date2" class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">Country</label>

                            <select name="country_id2" id="country_id" class="form-select form-select-lg">
                                <option value="">Select country</option>

                                <option value="">egjo</option>
                            </select>
                        </div>
                    </div>




                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="d-flex gap-3 justify-content-start" style="text-align: start">

                            <a class="btn btn-dark customBtn">
                                <span>Total Revenue:- KD 100000</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Transaction ID</th>
                                <th scope="col">Gift Card ID</th>
                                <th scope="col">Purchased By</th>
                                <th scope="col">Country</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Date & Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>#2345</td>
                                <td>Lorem</td>
                                <td>UAE</td>
                                <td>2nd July 2025 | 11 Am</td>
                                <td>KD 2000</td>
                                <td>KD 2000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="pills-Banner" role="tabpanel" aria-labelledby="pills-Banner-tab"
                tabindex="0">
                <div class="row">
                    <!-- From Date Filter -->
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from" name="from_date2" class="form-control" />
                        </div>
                    </div>

                    <!-- To Date Filter -->
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">To:</label>
                            <input type="date" id="to" name="to_date2" class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">Country</label>

                            <select name="country_id2" id="country_id" class="form-select form-select-lg">
                                <option value="">Select country</option>

                                <option value="">egjo</option>
                            </select>
                        </div>
                    </div>




                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="d-flex gap-3 justify-content-start" style="text-align: start">

                            <a class="btn btn-dark customBtn">
                                <span>Total Revenue:- KD 100000</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Transaction ID</th>
                                <th scope="col">Request ID</th>
                                <th scope="col">Seller Name</th>
                                <th scope="col">Country</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Date & Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>#2345</td>
                                <td>Lorem</td>
                                <td>UAE</td>
                                <td>2nd July 2025 | 11 Am</td>
                                <td>KD 2000</td>
                                <td>KD 2000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>





</div>






@endsection