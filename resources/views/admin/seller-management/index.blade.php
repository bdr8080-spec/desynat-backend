@extends('admin.layout.app')
@section('content')

<div id="content-wrapper" class="d-flex flex-column position-relative">
    <div id="content" class="">


        <div class="inner-content management">
            <h2 class="h2">Seller management</h2>
            <div class="d-flex justify-content-center">
                <ul class="nav nav-pills tabs-pnl custom" id="pills-tab" role="tablist">
                    <li class="nav-item m-1" role="presentation">
                        <button class="nav-link customBtn2 m-0" id="pills-order-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order"
                            aria-selected="true">
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
                    <div class="tab-pane fade" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab"
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
                                        <th scope="col">Joining Date</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">First Name</th>
                                        <th scope="col">Last Name</th>
                                        <th scope="col">Mobile Number</th>
                                        <th scope="col">Email ID</th>
                                        <th scope="col">Country</th>
                                        <th scope="col">Store Name</th>
                                        <th scope="col">Store Address</th>
                                        <th scope="col">Store Mail ID</th>
                                        <th scope="col">Bio</th>
                                        <th scope="col">Uploaded ID</th>
                                        <th scope="col">Uploaded Store Document</th>
                                        <th scope="col">Bank Account Details</th>
                                        <th scope="col">Upload Account Proof</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>298071</td>
                                        <td>
                                            <img src="image/profile.jpg" alt="" width="40px" height="40px"
                                                class="square" />
                                        </td>
                                        <td>John</td>
                                        <td>Mayank Bana</td>
                                        <td>Bana</td>
                                        <td>+971616161</td>
                                        <td>Abc@gmail.com</td>
                                        <td>UAE</td>

                                        <!-- <td>Lorem</td> -->

                                        <td>$Lorem</td>
                                        <td>$Store@gmail.com</td>
                                        <td>Lorem Lorem Lorem</td>
                                        <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal4">
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal4">
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal2">
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal4">
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td>
                                            <div class="d-flex gap-3 justify-content-center">
                                                <a class="table-button" type="button"><i
                                                        class="bi bi-check-circle-fill"></i></a>

                                                <a class="table-button" data-bs-toggle="modal" data-bs-target="#xcircle"
                                                    type="button">
                                                    <i class="bi bi-x-circle-fill"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>298071</td>
                                        <td>
                                            <img src="image/profile.jpg" alt="" width="40px" height="40px"
                                                class="square" />
                                        </td>
                                        <td>John</td>
                                        <td>Mayank Bana</td>
                                        <td>Bana</td>
                                        <td>+971616161</td>
                                        <td>Abc@gmail.com</td>
                                        <td>UAE</td>

                                        <!-- <td>Lorem</td> -->

                                        <td>$Lorem</td>
                                        <td>$Store@gmail.com</td>
                                        <td>Lorem Lorem Lorem</td>
                                        <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal4">
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal4">
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal2">
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal4">
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td>
                                            <div class="d-flex gap-3 justify-content-center">
                                                <a class="table-button" type="button"><i
                                                        class="bi bi-check-circle-fill"></i></a>

                                                <a class="table-button" data-bs-toggle="modal" data-bs-target="#xcircle"
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
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                        aria-labelledby="pills-home-tab" tabindex="0">
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
                                        <th scope="col">Joining Date</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">First Name</th>
                                        <th scope="col">Last Name</th>
                                        <th scope="col">Mobile Number</th>
                                        <th scope="col">Email ID</th>
                                        <th scope="col">Country</th>
                                        <th scope="col">Store Name</th>
                                        <th scope="col">Store Address</th>
                                        <th scope="col">Store Mail ID</th>
                                        <th scope="col">Bio</th>
                                        <th scope="col">Uploaded ID</th>
                                        <th scope="col">Uploaded Store Document</th>
                                        <th scope="col">Bank Account Details</th>
                                        <th scope="col">Upload Account Proof</th>
                                        <th scope="col">Active Plan</th>
                                        <th scope="col">Total Number of Completed</th>
                                        <th scope="col">Total Number of Cancelled Order</th>
                                        <th scope="col">Total Earning</th>
                                        <th scope="col">Total Commission Paid</th>
                                        <th scope="col">Average Rating</th>
                                        <th scope="col">View Reels</th>
                                        <th scope="col">View Highlights</th>
                                        <th scope="col">Block/Unblock</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>298071</td>
                                        <td>
                                            <img src="image/profile.jpg" alt="" width="40px" height="40px"
                                                class="square" />
                                        </td>
                                        <td>John</td>
                                        <td>Mayank Bana</td>
                                        <td>Bana</td>
                                        <td>+971616161</td>
                                        <td>Abc@gmail.com</td>
                                        <td>UAE</td>

                                        <!-- <td>Lorem</td> -->

                                        <td>$Lorem</td>
                                        <td>$Store@gmail.com</td>
                                        <td>Lorem Lorem Lorem</td>
                                        <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal4">
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal4">
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal2">
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal4">
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td>Lorem </td>
                                        <td>32</td>
                                        <td>2</td>
                                        <td>KD10000</td>
                                        <td>KD 2000</td>
                                        <td>4
                                            <i class="bi bi-star-fill"></i>

                                        </td>
                                        <td> <a class="table-button" type="button" >
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td> <a class="table-button" type="button">
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td>
                                            <div class="form-check form-switch" style="justify-content: center;">
                                                <input class="form-check-input" type="checkbox" type="button"
                                                    role="switch" id="flexSwitchCheckChecked">
                                                <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>298071</td>
                                        <td>
                                            <img src="image/profile.jpg" alt="" width="40px" height="40px"
                                                class="square" />
                                        </td>
                                        <td>John</td>
                                        <td>Mayank Bana</td>
                                        <td>Bana</td>
                                        <td>+971616161</td>
                                        <td>Abc@gmail.com</td>
                                        <td>UAE</td>

                                        <!-- <td>Lorem</td> -->

                                        <td>$Lorem</td>
                                        <td>$Store@gmail.com</td>
                                        <td>Lorem Lorem Lorem</td>
                                        <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal4">
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal4">
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal2">
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal4">
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td>Lorem </td>
                                        <td>32</td>
                                        <td>2</td>
                                        <td>KD10000</td>
                                        <td>KD 2000</td>
                                        <td>4
                                            <i class="bi bi-star-fill"></i>

                                        </td>
                                        <td> <a class="table-button" type="button" >
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td> <a class="table-button" type="button">
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td>
                                            <div class="form-check form-switch" style="justify-content: center;">
                                                <input class="form-check-input" type="checkbox" type="button"
                                                    role="switch" id="flexSwitchCheckChecked">
                                                <label class="form-check-label" for="flexSwitchCheckChecked"></label>
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
                                        <th scope="col">Joining Date</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">First Name</th>
                                        <th scope="col">Last Name</th>
                                        <th scope="col">Mobile Number</th>
                                        <th scope="col">Email ID</th>
                                        <th scope="col">Country</th>
                                        <th scope="col">Store Name</th>
                                        <th scope="col">Store Address</th>
                                        <th scope="col">Store Mail ID</th>
                                        <th scope="col">Bio</th>
                                        <th scope="col">Uploaded ID</th>
                                        <th scope="col">Uploaded Store Document</th>
                                        <th scope="col">Bank Account Details</th>
                                        <th scope="col">Upload Account Proof</th>
                                        <th scope="col">Rejection Reason</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>298071</td>
                                        <td>
                                            <img src="image/profile.jpg" alt="" width="40px" height="40px"
                                                class="square" />
                                        </td>
                                        <td>John</td>
                                        <td>Mayank Bana</td>
                                        <td>Bana</td>
                                        <td>+971616161</td>
                                        <td>Abc@gmail.com</td>
                                        <td>UAE</td>

                                        <!-- <td>Lorem</td> -->

                                        <td>$Lorem</td>
                                        <td>$Store@gmail.com</td>
                                        <td>Lorem Lorem Lorem</td>
                                        <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal4">
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal4">
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal2">
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal4">
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td>LOrem </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>298071</td>
                                        <td>
                                            <img src="image/profile.jpg" alt="" width="40px" height="40px"
                                                class="square" />
                                        </td>
                                        <td>John</td>
                                        <td>Mayank Bana</td>
                                        <td>Bana</td>
                                        <td>+971616161</td>
                                        <td>Abc@gmail.com</td>
                                        <td>UAE</td>

                                        <!-- <td>Lorem</td> -->

                                        <td>$Lorem</td>
                                        <td>$Store@gmail.com</td>
                                        <td>Lorem Lorem Lorem</td>
                                        <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal2">
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal2">
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal2">
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal2">
                                                <i class="bi bi-eye-fill"></i>
                                            </a></td>
                                        <td>LOrem </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- End of Content Wrapper -->
        </div>
    </div>
</div>



<div class="modal fade" id="sentModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="exampleModalLabel">
                    Bank Details
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <div class="modal-body">
                <div class="appointment-container">
                    <div class="form-group">
                        <label for="exampleFormControlInput1" class="form-label">IBAN</label>
                        <input type="text" placeholder="Eg Rolex" class="form-control"
                            aria-describedby="passwordHelpInline">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1" class="form-label">Account Number</label>
                        <input type="text" placeholder="Eg Rolex" class="form-control"
                            aria-describedby="passwordHelpInline">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1" class="form-label">Holder Name</label>
                        <input type="text" placeholder="Eg Rolex" class="form-control"
                            aria-describedby="passwordHelpInline">
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="sentModal4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <!-- <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1> -->
                <h2 class="h2">Documents</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="appointment-container">
                    <div class="image-box">
                        <img src="image/profile.jpg" alt="License Front">
                        <img src="image/profile.jpg" alt="License Back">
                    </div>



                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="xcircle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>




            </div>

        </div>
    </div>


</div>

<div class="modal fade" id="sentModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <!-- <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1> -->
                <h2 class="h2">Bank Details</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <div class="row my-3">
                    <div class="col-l2">
                        <div class="d-flex gap-2">
                            <p>Bank account number:</p>
                            <div class="location d-flex gap-2">
                                <span style="margin-left: 63px;">4879012345</span>

                            </div>


                        </div>
                        <div class="d-flex gap-2">
                            <p>Bank code:</p>
                            <div class="location d-flex gap-4">
                                <span style="margin-left:169px;"> 411111111</span>

                            </div>


                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection