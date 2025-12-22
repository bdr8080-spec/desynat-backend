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

                                <option selected>Select Status</option>
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
                                    <a class="btn btn-dark customBtn" type="button" data-bs-toggle="modal"
                                        data-bs-target="#assignModal">
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
                                    <a class="btn btn-dark customBtn" type="button" data-bs-toggle="modal"
                                        data-bs-target="#assignModal">
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

                                <option selected>Select Status</option>
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
                                <th scope="col">Delivery B</th>
                                <th scope="col">Delivery Boy/Company</th>
                                <th scope="col">Exchange or Return</th>
                                <th scope="col">Reason</th>
                                <th scope="col">Status</th>
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
                                <td>efwehgi</td>
                                <td>Lorem </td>
                                <td>Lorem </td>

                                <td>
                                    <a class="btn btn-dark customBtn" type="button" data-bs-toggle="modal"
                                        data-bs-target="#assignModal">
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
                                <td>qwufbw</td>
                                <td>Lorem </td>
                                <td>Lorem </td>

                                <td>
                                    <a class="btn btn-dark customBtn" type="button" data-bs-toggle="modal"
                                        data-bs-target="#assignModal">
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

                                <option selected>Select Status</option>
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
                                <th scope="col">Rating & Review</th>
                                <th scope="col">Invoice</th>



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
                                <td data-bs-toggle="modal" data-bs-target="#sentModalrating" style="cursor: pointer;">
                                    <i class="bi bi-star-fill text-warning"></i> 4.5 Rating
                                </td>
                                <td>
                                    <a class="btn btn-dark customBtn">
                                        <span>Download Invoice</span>
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
                                <td data-bs-toggle="modal" data-bs-target="#sentModalrating" style="cursor: pointer;">
                                    <i class="bi bi-star-fill text-warning"></i> 4.5 Rating
                                </td>
                                <td>
                                    <a class="btn btn-dark customBtn">
                                        <span>Download Invoice</span>
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

                                <option selected>Select Status</option>
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
                                <th scope="col">Reason</th>




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
                                <td>lorem</td>


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
                                <td>lorem</td>


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
<div class="modal fade" id="sentModalrating" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <!-- <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1> -->
                <h2 class="h2">Seller rating & Review</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="overlay">
                <div class="review-modal">


                    <!-- Seller Review Box -->
                    <div class="review-box">
                        <div class="stars">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="review-text">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                            veniam.
                        </p>
                    </div>

                    <h4 class="product-title">Product Name</h4>

                    <!-- Product Review Box -->
                    <div class="review-box">
                        <div class="stars center">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>

                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="review-text">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua.
                        </p>

                        <div class="attached">
                            <p>Attached Image</p>
                            <img src="/admin/image/download.jpeg" alt="attached">
                        </div>
                    </div>

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
                                <img src="/admin/image/download.jpeg" alt="product">
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
                                <img src="/admin/image/download.jpeg" alt="product">
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
<div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <!-- <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1> -->
                <h2 class="h2">Assign Delivery Boy</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-auto mb-4">
                <div class="row">
                    <div class="col-lg-12">
                        <input type="hidden" id="editBannerId" name="banner_id">
                        <div class="form-group w-50 m-auto">
                            <!-- <label for="from" class="form-label"> Assign</label> -->
                            <select class="form-select form-select-lg mt-4" aria-label="Large select example">

                                <option selected>Select country</option>
                                <option value="1">country One</option>
                                <option value="2">country Two</option>
                                <option value="3">country Three</option>
                            </select>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                            <div class="d-flex align-items-center justify-content-center gap-3 mt-3"
                                style="margin-top: 30px">
                                <button type="submit" class="btn btn-dark customBtn">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection