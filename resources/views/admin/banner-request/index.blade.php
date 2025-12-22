@extends('admin.layout.app')
@section('content')


<div class="inner-content management">
    <h2 class="h2">Banner Requests Management</h2>
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
                    Approved
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-return-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-return" type="button" role="tab" aria-controls="pills-return"
                    aria-selected="false">
                    Rejected
                </button>
            </li>
        </ul>
    </div>
    <div class="userManagecontent">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab" tabindex="0">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from" class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">To:</label>
                            <input type="date" id="from" class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="form-group mt-4 w-100">
                            <select class="form-select form-select-lg mt-4" aria-label="Large select example">

                                <option selected>Select country</option>
                                <option value="1">country One</option>
                                <option value="2">country Two</option>
                                <option value="3">country Three</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="table-responsive mt-5">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Request ID</th>
                                <th scope="col">Seller Name</th>
                                <th scope="col">Seller Country</th>
                                <th scope="col">Request On</th>
                                <th scope="col">Banner Image</th>
                                <th scope="col">Banner Place</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">No. of Days</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>298071</td>

                                <td>John</td>
                                <td>Mayank Bana</td>
                                <td>Bana</td>
                                <td>
                                    <img src="image/profile.jpg" alt="" width="40px" height="40px" class="square" />
                                </td>
                                <td>Home Top</td>
                                <td>10th September 2025</td>
                                <td>10th September 2025</td>

                                <td>5 days</td>

                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a class="table-button" type="button"><i
                                                class="bi bi-check-circle-fill"></i></a>

                                        <a class="table-button" data-bs-toggle="modal" data-bs-target="#rejectmodel"
                                            type="button">
                                            <i class="bi bi-x-circle-fill"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>298071</td>

                                <td>John</td>
                                <td>Mayank Bana</td>
                                <td>Bana</td>
                                <td>
                                    <img src="image/profile.jpg" alt="" width="40px" height="40px" class="square" />
                                </td>
                                <td>Home Top</td>
                                <td>10th September 2025</td>
                                <td>10th September 2025</td>

                                <td>5 days</td>

                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a class="table-button" type="button"><i
                                                class="bi bi-check-circle-fill"></i></a>

                                        <a class="table-button" data-bs-toggle="modal" data-bs-target="#rejectmodel "
                                            type="button">
                                            <i class="bi bi-x-circle-fill"></i>
                                        </a>
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
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from" class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">To:</label>
                            <input type="date" id="from" class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="form-group mt-4 w-100">
                            <select class="form-select form-select-lg mt-4" aria-label="Large select example">

                                <option selected>Select country</option>
                                <option value="1">country One</option>
                                <option value="2">country Two</option>
                                <option value="3">country Three</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="table-responsive mt-5">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Request ID</th>
                                <th scope="col">Seller Name</th>
                                <th scope="col">Seller Country</th>
                                <th scope="col">Request On</th>
                                <th scope="col">Banner Image</th>
                                <th scope="col">Position</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">No. of Days</th>
                                <th scope="col">Seller Posted</th>
                                <th scope="col">Amount Paid</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>298071</td>

                                <td>John</td>
                                <td>Mayank Bana</td>
                                <td>Bana</td>
                                <td>
                                    <img src="image/profile.jpg" alt="" width="40px" height="40px" class="square" />
                                </td>
                                <td>Home Top</td>
                                <td>10th September 2025</td>
                                <td>10th September 2025</td>

                                <td>5 days</td>

                                <td>yes </td>
                                <td>KD 10 </td>

                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>298071</td>

                                <td>John</td>
                                <td>Mayank Bana</td>
                                <td>Bana</td>
                                <td>
                                    <img src="image/profile.jpg" alt="" width="40px" height="40px" class="square" />
                                </td>
                                <td>Home Top</td>
                                <td>10th September 2025</td>
                                <td>10th September 2025</td>

                                <td>5 days</td>

                                <td>yes </td>
                                <td>KD 10 </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- rejected -->

            <div class="tab-pane fade" id="pills-return" role="tabpanel" aria-labelledby="pills-return-tab"
                tabindex="0">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from" class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">To:</label>
                            <input type="date" id="from" class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="form-group mt-4 w-100">
                            <select class="form-select form-select-lg mt-4" aria-label="Large select example">

                                <option selected>Select country</option>
                                <option value="1">country One</option>
                                <option value="2">country Two</option>
                                <option value="3">country Three</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="table-responsive mt-5 mt-5">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Request ID</th>
                                <th scope="col">Seller Name</th>
                                <th scope="col">Seller Country</th>
                                <th scope="col">Request On</th>
                                <th scope="col">Banner Image</th>
                                <th scope="col">Banner Place</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">No. of Days</th>
                                <th scope="col">Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>298071</td>

                                <td>John</td>
                                <td>Mayank Bana</td>
                                <td>Bana</td>
                                <td>
                                    <img src="image/profile.jpg" alt="" width="40px" height="40px" class="square" />
                                </td>
                                <td>Home Top</td>
                                <td>10th September 2025</td>
                                <td>10th September 2025</td>

                                <td>5 days</td>

                                <td>Lorem </td>
                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>298071</td>

                                <td>John</td>
                                <td>Mayank Bana</td>
                                <td>Bana</td>
                                <td>
                                    <img src="image/profile.jpg" alt="" width="40px" height="40px" class="square" />
                                </td>
                                <td>Home Top</td>
                                <td>10th September 2025</td>
                                <td>10th September 2025</td>

                                <td>5 days</td>
                                <td>Lorem </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- End of Content Wrapper -->
</div>


<div class="modal fade" id="rejectmodel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="div">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Reason For Rejection</label>
                                <textarea class="form-control" id="rejectReason" rows="3"></textarea>
                                <div id="error-message" class="text-danger mt-2" style="display:none;">Please Enter
                                    Reason</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center mt-3">
                    <a type="button" class="btn btn-dark customBtn" id="submitReject">Submit</a>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection