@extends('admin.layout.app')
@section('content')

<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">DELIVERY BOY MANAGEMENT</h2>
        </div>


        <div class="col-lg-3 col-md-4 col-12">

            <div class="d-flex justify-content-end" style="text-align: end">
                <a class="btn btn-dark customBtn" style="margin-top: 70px">
                    <span>Export</span>
                </a>
            </div>
        </div>

    </div>

    <div class="userManagecontent mt-4">
        <div class="">
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
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="d-flex justify-content-end  mt-5">
                        <a class="btn btn-dark customBtn" data-bs-toggle="modal" data-bs-target="#sentModal2">
                            <span>Add Delivery Boy</span>
                        </a>
                    </div>
                </div>


            </div>

            <div class="table-responsive w-100 mt-5">
                <table class="table w-100">
                    <thead>
                        <tr>
                            <th scope="col">Sr.No</th>
                            <th scope="col">Joining Date</th>
                            <th scope="col">Image</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Mobile Number</th>
                            <th scope="col">Email ID</th>
                            <th scope="col">Zone</th>
                            <th scope="col">Address</th>
                            <th scope="col">Vehicle Name</th>
                            <th scope="col">Registration Number</th>
                            <th scope="col">Vehicle Image</th>
                            <th scope="col">Uploaded ID</th>
                            <th scope="col">Uploaded DL</th>
                            <th scope="col">Uploaded Vehicle Insurance</th>
                            <th scope="col">Uploaded Pollution Paper</th>
                            <th scope="col">Uploaded RC</th>
                            <th scope="col">Total Order Delivered</th>

                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>2nd September 2025</td>
                            <td>
                                <img src="image/profile.jpg" alt="" width="40px" height="40px" class="square" />
                            </td>
                            <td>srishti</td>

                            <td>+9717367373</td>
                            <td>abc@gmail.com</td>

                            <td>lorem</td>
                            <td>lorem</td>
                            <td>lorem</td>
                            <td>828282</td>
                            <td> <a class="table-button view-owner-btn" type="button" data-bs-toggle="modal"
                                    data-bs-target="#sentModal5">
                                    <i class="bi bi-eye-fill"></i>
                                </a></td>
                            <td>

                                <a class="table-button view-owner-btn" type="button" data-bs-toggle="modal"
                                    data-bs-target="#sentModal5">
                                    <i class="bi bi-eye-fill"></i>
                                </a>

                            </td>

                            <td>
                                <a class="table-button view-store-btn" type="button" data-bs-toggle="modal"
                                    data-bs-target="#sentModal5">
                                    <i class="bi bi-eye-fill"></i>
                                </a>

                            <td>
                                <a class="table-button view-bank-btn" type="button" data-bs-toggle="modal"
                                    data-bs-target="#sentModal5">
                                    <i class="bi bi-eye-fill"></i>
                                </a>

                            </td>
                            <td>
                                <a class="table-button view-account-proof-btn" type="button" data-bs-toggle="modal"
                                    data-bs-target="#sentModal5">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            <td> <a class="table-button view-owner-btn" type="button" data-bs-toggle="modal"
                                    data-bs-target="#sentModal5">
                                    <i class="bi bi-eye-fill"></i>
                                </a></td>
                            <td>437897594875</td>
                            <td>
                                <div class="d-flex gap-3 justify-content-center">
                                    <a class="table-button" type="button" data-bs-toggle="modal"
                                        data-bs-target="#sentModal3"><i class="bi bi-pencil-square"></i></a>

                                    <a class="table-button" type="button" id="delete_category">
                                        <i class="bi bi-trash3-fill"></i>
                                    </a>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckChecked" />
                                        <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="sentModal5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Upload Documnets</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="text-center mb-4" style="display: none;">


                    <div class="text-center mb-3">
                        <h5> Documents</h5>
                    </div>
                    <div class="appointment-container d-flex flex-wrap justify-content-center">
                    </div>

                </div>
            </div>
        </div>
    </div>


    @endsection