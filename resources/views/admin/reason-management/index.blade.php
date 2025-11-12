@extends('admin.layout.app')
@section('content')


<div class="inner-content management">
    <h2 class="h2">REASON MANAGEMENT</h2>

    <div class="d-flex justify-content-center">
        <ul class="nav nav-pills  tabs-pnl custom" id="pills-tab" role="tablist">
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-order-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order"
                    aria-selected="true">
                    Exchange
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link active customBtn2 m-0" id="pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="true">
                    Return
                </button>
            </li>

            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-return-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-return" type="button" role="tab" aria-controls="pills-return"
                    aria-selected="false">
                    Cancel
                </button>
            </li>
        </ul>
    </div>
    <div class="userManagecontent mb-4">
        <div class="tab-content" id="pills-tabContent">

            <!-- Exchange -->

            <div class="tab-pane fade" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab" tabindex="0">
                <div class="row align-items-end justify-content-end">


                    <div class="col-lg-6 col-md-4 col-12">
                        <div class="d-flex justify-content-end">
                            <a class="btn btn-dark customBtn button" data-bs-toggle="modal"
                                data-bs-target="#sentModal2">
                                <span>Add</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mb-5">
                    <table class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Exchange Reason</th>
                                <th scope="col">Action</th>


                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>lorem</td>
                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a class="table-button" type="button" data-bs-toggle="modal"
                                            data-bs-target="#sentModal3"><i class="bi bi-pencil-square"></i></a>

                                        <a class="table-button" type="button">
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
                            <tr>
                                <th scope="row">1</th>
                                <td>lorem</td>
                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a class="table-button" type="button" data-bs-toggle="modal"
                                            data-bs-target="#sentModal3"><i class="bi bi-pencil-square"></i></a>

                                        <a class="table-button" type="button">
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

            <!-- Return -->
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                tabindex="0">
                <div class="row align-items-end justify-content-end">


                    <div class="col-lg-6 col-md-4 col-12">
                        <div class="d-flex justify-content-end">
                            <a class="btn btn-dark customBtn button" data-bs-toggle="modal"
                                data-bs-target="#sentModal2">
                                <span>Add</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mb-5">
                    <table class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Return Reason</th>
                                <th scope="col">Action</th>


                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>lorem</td>
                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a class="table-button" type="button" data-bs-toggle="modal"
                                            data-bs-target="#sentModal3"><i class="bi bi-pencil-square"></i></a>

                                        <a class="table-button" type="button">
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
                            <tr>
                                <th scope="row">1</th>
                                <td>lorem</td>
                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a class="table-button" type="button" data-bs-toggle="modal"
                                            data-bs-target="#sentModal3"><i class="bi bi-pencil-square"></i></a>

                                        <a class="table-button" type="button">
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

            <!-- cancle -->

            <div class="tab-pane fade" id="pills-return" role="tabpanel" aria-labelledby="pills-return-tab"
                tabindex="0">
               <div class="row align-items-end justify-content-end">


                    <div class="col-lg-6 col-md-4 col-12">
                        <div class="d-flex justify-content-end">
                            <a class="btn btn-dark customBtn button" data-bs-toggle="modal"
                                data-bs-target="#sentModal2">
                                <span>Add</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mb-5">
                    <table class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Cancle Reason</th>
                                <th scope="col">Action</th>


                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>lorem</td>
                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a class="table-button" type="button" data-bs-toggle="modal"
                                            data-bs-target="#sentModal3"><i class="bi bi-pencil-square"></i></a>

                                        <a class="table-button" type="button">
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
                            <tr>
                                <th scope="row">1</th>
                                <td>lorem</td>
                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a class="table-button" type="button" data-bs-toggle="modal"
                                            data-bs-target="#sentModal3"><i class="bi bi-pencil-square"></i></a>

                                        <a class="table-button" type="button">
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

    <!-- End of Content Wrapper -->
</div>


<!-- add new model -->
<div class="modal fade" id="sentModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <!-- <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1> -->
                <h2 class="h2">Add Reason</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="appointment-container">
                    <form>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1" class="form-label">Reason
                                            (English)</label>
                                        <input type="text" placeholder="Enter Reason" class="form-control"
                                            aria-describedby="passwordHelpInline" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1" class="form-label">Reason (Arabic)</label>
                                        <input type="text" placeholder="Enter Reason" class="form-control"
                                            aria-describedby="passwordHelpInline" />
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                                <div class="d-flex align-items-center justify-content-center gap-3 mt-3"
                                    style="margin-top: 30px">
                                    <button class="btn btn-dark customBtn" href=""> Cancle</button>

                                    <button class="btn btn-dark customBtn" href=""> Add</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection