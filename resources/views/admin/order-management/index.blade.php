@extends('admin.layout.app')
@section('content')


<div class="inner-content management">
    <h2 class="h2">Order Management</h2>
    <div class="d-flex justify-content-center">
        <ul class="nav nav-pills tabs-pnl custom" id="pills-tab" role="tablist">
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-order-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order"
                    aria-selected="false">
                    Active Orders
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link active customBtn2 m-0" id="pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="true">
                    Return & Exchange
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-return-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-return" type="button" role="tab" aria-controls="pills-return"
                    aria-selected="false">
                    Completed
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-cancelled-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-cancelled" type="button" role="tab" aria-controls="pills-cancelled"
                    aria-selected="false">
                    Cancelled
                </button>
            </li>
        </ul>
    </div>
    <div class="userManagecontent">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab" tabindex="0">
                <div class="row">
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
                    <div class="col-lg-2 col-md-12 col-12">
                        <div class="d-dlex justify-content-end" style="text-align: end">
                            <a class="btn btn-dark customBtn w-100" style="margin-top: 56px">
                                <span>Export</span></a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Order ID</th>
                                <th scope="col">Seller Name</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Country</th>
                                <th scope="col">Product details</th>
                                <th scope="col">Delivery Address</th>
                                <th scope="col">Order Amount</th>
                                <th scope="col">Admin Commission</th>
                                <th scope="col">Order Type</th>
                                <th scope="col">Delivery Boy</th>
                                <th scope="col">Delivery Boy/Company Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Invoice</th>
                                <th scope="col">Zone</th>
                                <th scope="col">Assign Driver</th>


                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>298071</td>
                                <td>lorem</td>
                                <td>lorem</td>
                                <td>Kuwait</td>
                                <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                        data-bs-target="#sentModal1">
                                        <i class="bi bi-eye-fill"></i>
                                    </a></td>
                                <td>142 Loejmw Lorwem</td>
                                <td>KD 2000</td>
                                <td>KD 2000</td>
                                <td>Normal</td>
                                <td>Delivery Boy</td>
                                <td>Mayank</td>
                                <td>Pending</td>
                                <td>
                                    <a class="btn btn-dark customBtn">
                                        <span>Download Invoice</span>
                                    </a>
                                </td>
                                <td>Lorem </td>
                                <td>
                                    <a class="btn btn-dark customBtn">
                                        <span>Assign Delivery Boy</span>
                                    </a>
                                </td>

                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>298071</td>
                                <td>lorem</td>
                                <td>lorem</td>
                                <td>Kuwait</td>
                                <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                        data-bs-target="#sentModal1">
                                        <i class="bi bi-eye-fill"></i>
                                    </a></td>
                                <td>142 Loejmw Lorwem</td>
                                <td>KD 2000</td>
                                <td>KD 2000</td>
                                <td>Normal</td>
                                <td>Delivery Boy</td>
                                <td>Mayank</td>
                                <td>Pending</td>
                                <td>
                                    <a class="btn btn-dark customBtn">
                                        <span>Download Invoice</span>
                                    </a>
                                </td>
                                <td>Lorem </td>
                                <td>
                                    <a class="btn btn-dark customBtn">
                                        <span>Assign Delivery Boy</span>
                                    </a>
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
                    <div class="col-lg-2 col-md-12 col-12">
                        <div class="d-dlex justify-content-end" style="text-align: end">
                            <a class="btn btn-dark customBtn w-100" style="margin-top: 56px">
                                <span>Export</span></a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Order ID</th>
                                <th scope="col">Seller Name</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Country</th>
                                <th scope="col">Product details</th>
                                <th scope="col">Delivery Address</th>
                                <th scope="col">Order Amount</th>
                                <th scope="col">Admin Commission</th>
                                <th scope="col">Order Type</th>
                                <th scope="col">Delivery Boy</th>
                                <th scope="col">Delivery Boy/Company Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Invoice</th>
                                <th scope="col">Zone</th>
                                <th scope="col">Assign Driver</th>


                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>298071</td>
                                <td>lorem</td>
                                <td>lorem</td>
                                <td>Kuwait</td>
                                <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                        data-bs-target="#sentModal1">
                                        <i class="bi bi-eye-fill"></i>
                                    </a></td>
                                <td>142 Loejmw Lorwem</td>
                                <td>KD 2000</td>
                                <td>KD 2000</td>
                                <td>Normal</td>
                                <td>Delivery Boy</td>
                                <td>Mayank</td>
                                <td>Pending</td>
                                <td>
                                    <a class="btn btn-dark customBtn">
                                        <span>Download Invoice</span>
                                    </a>
                                </td>
                                <td>Lorem </td>
                                <td>
                                    <a class="btn btn-dark customBtn">
                                        <span>Assign Delivery Boy</span>
                                    </a>
                                </td>

                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>298071</td>
                                <td>lorem</td>
                                <td>lorem</td>
                                <td>Kuwait</td>
                                <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                        data-bs-target="#sentModal1">
                                        <i class="bi bi-eye-fill"></i>
                                    </a></td>
                                <td>142 Loejmw Lorwem</td>
                                <td>KD 2000</td>
                                <td>KD 2000</td>
                                <td>Normal</td>
                                <td>Delivery Boy</td>
                                <td>Mayank</td>
                                <td>Pending</td>
                                <td>
                                    <a class="btn btn-dark customBtn">
                                        <span>Download Invoice</span>
                                    </a>
                                </td>
                                <td>Lorem </td>
                                <td>
                                    <a class="btn btn-dark customBtn">
                                        <span>Assign Delivery Boy</span>
                                    </a>
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
                    <div class="col-lg-2 col-md-12 col-12">
                        <div class="d-dlex justify-content-end" style="text-align: end">
                            <a class="btn btn-dark customBtn w-100" style="margin-top: 56px">
                                <span>Export</span></a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Order ID</th>
                                <th scope="col">Seller Name</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Country</th>
                                <th scope="col">Product details</th>
                                <th scope="col">Delivery Address</th>
                                <th scope="col">Order Amount</th>
                                <th scope="col">Admin Commission</th>
                                <th scope="col">Order Type</th>
                                <th scope="col">Delivery Boy</th>
                                <th scope="col">Delivery Boy/Company Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Invoice</th>
                                <th scope="col">Zone</th>
                                <th scope="col">Assign Driver</th>


                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>298071</td>
                                <td>lorem</td>
                                <td>lorem</td>
                                <td>Kuwait</td>
                                <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                        data-bs-target="#sentModal2">
                                        <i class="bi bi-eye-fill"></i>
                                    </a></td>
                                <td>142 Loejmw Lorwem</td>
                                <td>KD 2000</td>
                                <td>KD 2000</td>
                                <td>Normal</td>
                                <td>Delivery Boy</td>
                                <td>Mayank</td>
                                <td>Pending</td>
                                <td>
                                    <a class="btn btn-dark customBtn">
                                        <span>Download Invoice</span>
                                    </a>
                                </td>
                                <td>Lorem </td>
                                <td>
                                    <a class="btn btn-dark customBtn">
                                        <span>Assign Delivery Boy</span>
                                    </a>
                                </td>

                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>298071</td>
                                <td>lorem</td>
                                <td>lorem</td>
                                <td>Kuwait</td>
                                <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                        data-bs-target="#sentModal2">
                                        <i class="bi bi-eye-fill"></i>
                                    </a></td>
                                <td>142 Loejmw Lorwem</td>
                                <td>KD 2000</td>
                                <td>KD 2000</td>
                                <td>Normal</td>
                                <td>Delivery Boy</td>
                                <td>Mayank</td>
                                <td>Pending</td>
                                <td>
                                    <a class="btn btn-dark customBtn">
                                        <span>Download Invoice</span>
                                    </a>
                                </td>
                                <td>Lorem </td>
                                <td>
                                    <a class="btn btn-dark customBtn">
                                        <span>Assign Delivery Boy</span>
                                    </a>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-cancelled" role="tabpanel" aria-labelledby="pills-cancelled-tab"
                tabindex="0">
                <div class="row">
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
                    <div class="col-lg-2 col-md-12 col-12">
                        <div class="d-dlex justify-content-end" style="text-align: end">
                            <a class="btn btn-dark customBtn w-100" style="margin-top: 56px">
                                <span>Export</span></a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Order ID</th>
                                <th scope="col">Seller Name</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Country</th>
                                <th scope="col">Product details</th>
                                <th scope="col">Delivery Address</th>
                                <th scope="col">Order Amount</th>
                                <th scope="col">Admin Commission</th>
                                <th scope="col">Order Type</th>
                                <th scope="col">Delivery Boy</th>
                                <th scope="col">Delivery Boy/Company Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Invoice</th>
                                <th scope="col">Zone</th>
                                <th scope="col">Assign Driver</th>


                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>298071</td>
                                <td>lorem</td>
                                <td>lorem</td>
                                <td>Kuwait</td>
                                <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                        data-bs-target="#sentModal2">
                                        <i class="bi bi-eye-fill"></i>
                                    </a></td>
                                <td>142 Loejmw Lorwem</td>
                                <td>KD 2000</td>
                                <td>KD 2000</td>
                                <td>Normal</td>
                                <td>Delivery Boy</td>
                                <td>Mayank</td>
                                <td>Pending</td>
                                <td>
                                    <a class="btn btn-dark customBtn">
                                        <span>Download Invoice</span>
                                    </a>
                                </td>
                                <td>Lorem </td>
                                <td>
                                    <a class="btn btn-dark customBtn">
                                        <span>Assign Delivery Boy</span>
                                    </a>
                                </td>

                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>298071</td>
                                <td>lorem</td>
                                <td>lorem</td>
                                <td>Kuwait</td>
                                <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                        data-bs-target="#sentModal2">
                                        <i class="bi bi-eye-fill"></i>
                                    </a></td>
                                <td>142 Loejmw Lorwem</td>
                                <td>KD 2000</td>
                                <td>KD 2000</td>
                                <td>Normal</td>
                                <td>Delivery Boy</td>
                                <td>Mayank</td>
                                <td>Pending</td>
                                <td>
                                    <a class="btn btn-dark customBtn">
                                        <span>Download Invoice</span>
                                    </a>
                                </td>
                                <td>Lorem </td>
                                <td>
                                    <a class="btn btn-dark customBtn">
                                        <span>Assign Delivery Boy</span>
                                    </a>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- End of Content Wrapper -->
</div>


<!-- add new model -->
<div class="modal fade" id="sentModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <!-- <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1> -->
                <h2 class="h2">Add Plan</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="appointment-container">
                    <form>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1" class="form-label">Plan Name
                                            (English)</label>
                                        <input type="text" placeholder="" class="form-control"
                                            aria-describedby="passwordHelpInline" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1" class="form-label">Plan Name
                                            (Arabic)</label>
                                        <input type="text" placeholder="" class="form-control"
                                            aria-describedby="passwordHelpInline" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1" class="form-label">Duration</label>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <input type="text" placeholder="" class="form-control"
                                                    aria-describedby="passwordHelpInline" />
                                            </div>
                                            <div class="col-lg-6">
                                                <select class="form-select form-select-lg"
                                                    aria-label="Large select example">
                                                    <option selected>Select Duration</option>
                                                    <option value="1">Week</option>
                                                    <option value="2">Days</option>
                                                    <option value="3">Months</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1" class="form-label">No. of Videos</label>
                                        <input type="text" placeholder="" class="form-control"
                                            aria-describedby="passwordHelpInline" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1" class="form-label">No. of Products</label>
                                        <input type="text" placeholder="" class="form-control"
                                            aria-describedby="passwordHelpInline" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1" class="form-label">No. of
                                            Highlights</label>
                                        <input type="text" placeholder="" class="form-control"
                                            aria-describedby="passwordHelpInline" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1" class="form-label">No. of Employee</label>
                                        <input type="text" placeholder="" class="form-control"
                                            aria-describedby="passwordHelpInline" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1" class="form-label">Charges</label>
                                        <input type="text" placeholder="" class="form-control"
                                            aria-describedby="passwordHelpInline" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1" class="form-label">Stories</label>
                                    <div class="row">
                                        <div class="col-lg-6 d-flex align-items-center">
                                            <input type="radio" id="chargesYes" name="charges" value="yes"
                                                class="form-check-input me-2" />
                                            <label for="chargesYes" class="form-check-label">Yes</label>
                                        </div>
                                        <div class="col-lg-6 d-flex align-items-center">
                                            <input type="radio" id="chargesNo" name="charges" value="no"
                                                class="form-check-input me-2" />
                                            <label for="chargesNo" class="form-check-label">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1" class="form-label">Commission</label>
                                    <div class="row">
                                        <div class="col-lg-6 d-flex align-items-center">
                                            <input type="radio" id="commissionYes" name="commission" value="yes"
                                                class="form-check-input me-2" />
                                            <label for="commissionYes" class="form-check-label">Yes</label>
                                        </div>
                                        <div class="col-lg-6 d-flex align-items-center">
                                            <input type="radio" id="commissionNo" name="commission" value="no"
                                                class="form-check-input me-2" />
                                            <label for="commissionNo" class="form-check-label">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                                <div class="d-flex align-items-center justify-content-center gap-3 mt-3"
                                    style="margin-top: 30px">
                                    <a class="btn btn-dark customBtn" href=""> Submit</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="sentModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <!-- <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1> -->
                <h2 class="h2">Product Details</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="overlay">
                    <div class="product-modal">


                        <!-- Product Card -->
                        <div class="product-card">
                            <div class="product-img">
                                <img src="https://via.placeholder.com/80" alt="product">
                            </div>

                            <div class="product-info">
                                <div class="left">
                                    <p><strong>Name</strong></p>
                                    <p>Category</p>
                                    <p>Brand</p>
                                </div>

                                <div class="right">
                                    <p><strong>Sub-Category</strong></p>
                                    <p>Price</p>
                                </div>
                            </div>
                        </div>

                        <!-- Product Card -->
                        <div class="product-card">
                            <div class="product-img">
                                <img src="https://via.placeholder.com/80" alt="product">
                            </div>

                            <div class="product-info">
                                <div class="left">
                                    <p><strong>Name</strong></p>
                                    <p>Category</p>
                                    <p>Brand</p>
                                </div>

                                <div class="right">
                                    <p><strong>Sub-Category</strong></p>
                                    <p>Price</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection