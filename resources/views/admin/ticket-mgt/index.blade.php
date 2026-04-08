@extends('admin.layout.app')
@section('content')


<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">Tickets Management </h2>
        </div>
        <div class="col-lg-3 col-md-4 col-12">
            <div class="d-flex justify-content-end">
                <a class="btn btn-dark customBtn" href="#" role="button">
                    <span>Export</span>
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
                    New
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link active customBtn2 m-0" id="pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="true">
                    Ongoing
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-return-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-return" type="button" role="tab" aria-controls="pills-return"
                    aria-selected="false">
                    Past
                </button>
            </li>
        </ul>
    </div>
    <div class="userManagecontent">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab" tabindex="0">
                <div class="row">
                    <!-- From Date Filter -->
                    <div class="col-lg-2 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from" name="from_date2" class="form-control" />
                        </div>
                    </div>

                    <!-- To Date Filter -->
                    <div class="col-lg-2 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">To:</label>
                            <input type="date" id="to" name="to_date2" class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">Ticket type</label>

                            <select name="country_id2" id="country_id" class="form-select form-select-lg">
                                <option value="">Select Ticket</option>

                                <option value="">egjo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">Country</label>

                            <select name="country_id2" id="country_id" class="form-select form-select-lg">
                                <option value="">Select country</option>

                                <option value="">egjo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">Submitted by</label>

                            <select name="country_id2" id="country_id" class="form-select form-select-lg">
                                <option value="">Select country</option>

                                <option value="">egjo</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Ticket Id </th>
                                <th scope="col">Order Id</th>
                                <th scope="col"> Submitted by</th>
                                <th scope="col">Country</th>
                                <th scope="col">Raised Date & Time</th>
                                <th scope="col"> User name</th>
                                <th scope="col"> Ride Date & Time</th>
                                <th scope="col">View Reason & Attachment</th>
                                <th scope="col">Type</th>
                                <th scope="col">Update Status</th>

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
                                <td>ygrfyr </td>

                                <td>
                                    <a class="table-button" type="button" data-bs-toggle="modal"
                                        data-bs-target="#sentModal1">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                </td>
                                <td>ygrfyr </td>

                                <td>
                                    <div class="form-group mt-4 w-100">
                                        <select name="country_id2" id="country_id" class="form-select form-select-lg">
                                            <option value=""> Pending</option>
                                            <option value="">Processed</option>
                                        </select>
                                    </div>
                                </td>

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
                    <div class="col-lg-2 col-md-3 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from" name="from_date2" class="form-control" />
                        </div>
                    </div>

                    <!-- To Date Filter -->
                    <div class="col-lg-2 col-md-3 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">To:</label>
                            <input type="date" id="to" name="to_date2" class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">Ticket type</label>

                            <select name="country_id2" id="country_id" class="form-select form-select-lg">
                                <option value="">Select Ticket</option>

                                <option value="">egjo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">Country</label>

                            <select name="country_id2" id="country_id" class="form-select form-select-lg">
                                <option value="">Select country</option>

                                <option value="">egjo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">Submitted by</label>

                            <select name="country_id2" id="country_id" class="form-select form-select-lg">
                                <option value="">Select country</option>

                                <option value="">egjo</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Ticket Id </th>
                                <th scope="col">Order Id</th>
                                <th scope="col"> Submitted by</th>
                                <th scope="col">Country</th>
                                <th scope="col">Raised Date & Time</th>
                                <th scope="col"> User name</th>
                                <th scope="col"> Ride Date & Time</th>
                                <th scope="col">View Reason & Attachment</th>
                                <th scope="col">Type</th>
                                <th scope="col">Update Status</th>

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
                                <td>ygrfyr </td>

                                <td>
                                    <a class="table-button" type="button" data-bs-toggle="modal"
                                        data-bs-target="#sentModal1">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                </td>
                                <td>ygrfyr </td>

                                <td>
                                    <div class="form-group mt-4 w-100">
                                        <select name="country_id2" id="country_id" class="form-select form-select-lg">
                                            <option value=""> Pending</option>
                                            <option value="">Processed</option>
                                        </select>
                                    </div>
                                </td>

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
                    <div class="col-lg-2 col-md-3 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from" name="from_date2" class="form-control" />
                        </div>
                    </div>

                    <!-- To Date Filter -->
                    <div class="col-lg-2 col-md-3 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">To:</label>
                            <input type="date" id="to" name="to_date2" class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">Ticket type</label>

                            <select name="country_id2" id="country_id" class="form-select form-select-lg">
                                <option value="">Select Ticket</option>

                                <option value="">egjo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">Country</label>

                            <select name="country_id2" id="country_id" class="form-select form-select-lg">
                                <option value="">Select country</option>

                                <option value="">egjo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">Submitted by</label>

                            <select name="country_id2" id="country_id" class="form-select form-select-lg">
                                <option value="">Select country</option>

                                <option value="">egjo</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Ticket Id </th>
                                <th scope="col">Order Id</th>
                                <th scope="col"> Submitted by</th>
                                <th scope="col">Country</th>
                                <th scope="col">Raised Date & Time</th>
                                <th scope="col"> User name</th>
                                <th scope="col"> Ride Date & Time</th>
                                <th scope="col">View Reason & Attachment</th>
                                <th scope="col">Type</th>
                                <th scope="col">Update Status</th>

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
                                <td>ygrfyr </td>

                                <td>
                                    <a class="table-button" type="button" data-bs-toggle="modal"
                                        data-bs-target="#sentModal1">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                </td>
                                <td>ygrfyr </td>

                                <td>
                                    <div class="form-group mt-4 w-100">
                                        <select name="country_id2" id="country_id" class="form-select form-select-lg">
                                            <option value="">Select Status</option>
                                            <option value="">Pending</option>
                                            <option value="">Processed</option>
                                        </select>
                                    </div>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>



<div class="modal fade" id="sentModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header management border-0">

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">

                            <div class="mb-3">
                                <label class="form-group">Title</label>
                                <input type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">

                            <div class="mb-3">
                                <label for="description" class="form-label">Reason</label>
                                <textarea id="description" class="form-control" rows="3" readOnly></textarea>
                            </div>
                        </div>


                    </div>
                    <button type="button" class="btn btn-dark customBtn m-auto px-4">submit</button>


                </div>
            </div>
        </div>
    </div>
</div>



@endsection