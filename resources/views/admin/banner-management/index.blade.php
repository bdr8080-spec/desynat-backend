@extends('admin.layout.app')
@section('content')


<style>
  #editPreviewImage {
    display: block; 
}
.upload-box {
    width: 220px;
    height: 160px;
    border: 2px dotted #c8ad8d;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    position: relative;
    overflow: hidden;
    cursor: pointer;
}

.upload-icon {
    width: 60px;
    opacity: 0.5;
}

.upload-text {
    margin-top: 10px;
    font-size: 14px;
    color: #444;
}

.preview-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: absolute;
    top: 0;
    left: 0;
    display: none;
}

</style>

<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">Banner Per Day Charges</h2>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <ul class="nav nav-pills mb-3 tabs-pnl custom" id="pills-tab" role="tablist">
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-order-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order"
                    aria-selected="true">
                    Home Top
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link active customBtn2 m-0" id="pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="true">
                    Home Bottom
                </button>
            </li>

            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-return-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-return" type="button" role="tab" aria-controls="pills-return"
                    aria-selected="false">
                    Sub-Category
                </button>
            </li>
        </ul>
    </div>
    <div class="userManagecontent mb-4">
        <div class="tab-content" id="pills-tabContent">
            <!-- Exchange -->

            <div class="tab-pane fade" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab" tabindex="0">
                <div class="row">
                    <div class="align-items-end d-flex">
                        <div class="search-box" style="position: relative">
                            <i class="bi bi-search" style="
                            position: absolute;
                            left: 10px;
                            top: 50%;
                            transform: translateY(-50%);
                            font-size: 16px;
                            color: #888;
                          ">
                            </i>
                            <input type="text" class="form-control" placeholder="Search for..."
                                style="padding-left: 35px" />
                        </div>
                    </div>
                </div>

                <div class="table-responsive mb-5">
                    <table class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Country Name</th>
                                <th scope="col">Per Day Charges</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>lorem</td>
                                <td>lorem</td>
                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a class="table-button" type="button" data-bs-toggle="modal"
                                            data-bs-target="#sentModal3"><i class="bi bi-pencil-square"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>lorem</td>
                                <td>lorem</td>
                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a class="table-button" type="button" data-bs-toggle="modal"
                                            data-bs-target="#sentModal3"><i class="bi bi-pencil-square"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>lorem</td>
                                <td>lorem</td>
                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a class="table-button" type="button" data-bs-toggle="modal"
                                            data-bs-target="#sentModal3"><i class="bi bi-pencil-square"></i></a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Return -->
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                tabindex="0">
                <div class="row">
                    <div class="align-items-end d-flex">
                        <div class="search-box" style="position: relative">
                            <i class="bi bi-search" style="
                            position: absolute;
                            left: 10px;
                            top: 50%;
                            transform: translateY(-50%);
                            font-size: 16px;
                            color: #888;
                          ">
                            </i>
                            <input type="text" class="form-control" placeholder="Search for..."
                                style="padding-left: 35px" />
                        </div>
                    </div>
                </div>

                <div class="table-responsive w-100">
                    <table class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Country Name</th>
                                <th scope="col">Per Day Charges</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>lorem</td>
                                <td>lorem</td>
                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a class="table-button" type="button" data-bs-toggle="modal"
                                            data-bs-target="#sentModal3"><i class="bi bi-pencil-square"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>lorem</td>
                                <td>lorem</td>
                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a class="table-button" type="button" data-bs-toggle="modal"
                                            data-bs-target="#sentModal3"><i class="bi bi-pencil-square"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>lorem</td>
                                <td>lorem</td>
                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a class="table-button" type="button" data-bs-toggle="modal"
                                            data-bs-target="#sentModal3"><i class="bi bi-pencil-square"></i></a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>

            <!-- cancle -->

            <div class="tab-pane fade" id="pills-return" role="tabpanel" aria-labelledby="pills-return-tab"
                tabindex="0">
                <div class="row">
                    <div class="align-items-end d-flex">
                        <div class="search-box" style="position: relative">
                            <i class="bi bi-search" style="
                            position: absolute;
                            left: 10px;
                            top: 50%;
                            transform: translateY(-50%);
                            font-size: 16px;
                            color: #888;
                          ">
                            </i>
                            <input type="text" class="form-control" placeholder="Search for..."
                                style="padding-left: 35px" />
                        </div>
                    </div>
                </div>

                <div class="table-responsive w-100">
                    <table class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Country Name</th>
                                <th scope="col">Per Day Charges</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>lorem</td>
                                <td>lorem</td>
                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a class="table-button" type="button" data-bs-toggle="modal"
                                            data-bs-target="#sentModal3"><i class="bi bi-pencil-square"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>lorem</td>
                                <td>lorem</td>
                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a class="table-button" type="button" data-bs-toggle="modal"
                                            data-bs-target="#sentModal3"><i class="bi bi-pencil-square"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>lorem</td>
                                <td>lorem</td>
                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a class="table-button" type="button" data-bs-toggle="modal"
                                            data-bs-target="#sentModal3"><i class="bi bi-pencil-square"></i></a>
                                    </div>
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
<div class="modal fade" id="sentModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <!-- <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1> -->
                <h2 class="h2">Per Day Price</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group w-100">
                            <label for="from" class="form-label"> Price</label>
                            <input type="text" placeholder="Enter Amount" class="form-control"
                                aria-describedby="passwordHelpInline" />
                        </div>
                        <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                            <div class="d-flex align-items-center justify-content-center gap-3 mt-3"
                                style="margin-top: 30px">
                                <button type="button" class="btn btn-dark customBtn" href="">
                                    Save
                                </button>
                                <!-- <button type="button" class="btn btn-dark customBtn" href=""> Submit</button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery.js"></script>


@endsection