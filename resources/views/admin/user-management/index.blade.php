@extends('admin.layout.app')
@section('content')


<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">USER MANAGEMENT</h2>
        </div>
    </div>

    <div class="userManagecontent mb-4">
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
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="from" class="form-label">Country Name</label>
                        <select class="form-select form-select-lg" aria-label="Large select example">
                            <option selected>Select Country</option>
                            <option value="1">country One</option>
                            <option value="2">country Two</option>
                            <option value="3">country Three</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2 col-lg-1 col-12 mt-5">
                    <div class="d-dlex justify-content-end" style="text-align: end">
                        <a class="btn btn-dark customBtn button">
                            <span>Export </span></a>
                    </div>
                </div>
            </div>

            <div class="table-responsive w-100">
                <table class="table w-100">
                    <thead>
                        <tr>
                            <th scope="col">SR No.</th>
                            <th scope="col">Joining Date</th>
                            <th scope="col">Name</th>
                            <th scope="col">Image</th>
                            <th scope="col">Phone number</th>
                            <th scope="col">Country</th>
                            <th scope="col">Email</th>
                            <th scope="col">Total Number of Completed Order</th>
                            <th scope="col">Total Number of Cancelled Orders</th>
                            <th scope="col">Wallet Amount</th>
                            <th scope="col">Add Amount in Wallet</th>
                            <th scope="col">Block/Unblock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>

                            <td>25/02/25</td>
                            <td>srishti</td>
                            <td>
                                <img src="image/profile.jpg" alt="" width="40px" height="40px" class="square" />
                            </td>
                            <td>234567890</td>
                            <td>lorem</td>
                            <td>srishti@gmail.com</td>
                            <td>32</td>
                            <td>2</td>
                            <td>KD 300</td>
                            <td>
                                <a class="btn btn-dark customBtn" data-bs-toggle="modal" data-bs-target="#sentModal2">
                                    <span>Add</span>
                                </a>
                            </td>
                            <td>
                                <div class="d-flex gap-3 justify-content-center">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckChecked" />
                                        <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">1</th>

                            <td>25/02/25</td>
                            <td>srishti</td>
                            <td>
                                <img src="image/profile.jpg" alt="" width="40px" height="40px" class="square" />
                            </td>
                            <td>234567890</td>
                            <td>lorem</td>
                            <td>srishti@gmail.com</td>
                            <td>32</td>
                            <td>2</td>
                            <td>KD 300</td>
                            <td>
                                <a class="btn btn-dark customBtn" data-bs-toggle="modal" data-bs-target="#sentModal2">
                                    <span>Add</span>
                                </a>
                            </td>
                            <td>
                                <div class="d-flex gap-3 justify-content-center">
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



<div class="modal fade" id="sentModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <!-- <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1> -->
                <h2 class="h2">Add</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-auto mb-2  ">

                <div class="row">
                    <div class="col-lg-12">

                        <div class="form-group w-100">
                            <label for="from" class="form-label">Add Amount</label>
                            <input type="text" placeholder="" class="form-control w-100"
                                aria-describedby="passwordHelpInline" />
                        </div>
                        <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                            <div class="d-flex align-items-center justify-content-center gap-3 mt-3"
                                style="margin-top: 30px">
                                <button type="button" class="btn btn-dark customBtn" href=""> Cancel</button>
                                <button type="button" class="btn btn-dark customBtn" href=""> Submit</button>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



@endsection