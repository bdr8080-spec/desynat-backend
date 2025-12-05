@extends('admin.layout.app')
@section('content')


<div id="content-wrapper" class="d-flex flex-column position-relative">
    <div id="content" class="">


        <div class="inner-content management">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="d-flex align-items-center gap-3 mt-2">
                        <div class="arrow">
                            <a class="table-button" type="button" href="{{route('admin.shippingManagement')}}">
                                <i class="fas fa-angle-left"></i>
                            </a>
                        </div>
                        <h6 class="m-0">UAE </h6>
                    </div>
                </div>

                <div class="col-lg-6 col-md-4 col-12">
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-dark customBtn" data-bs-toggle="modal" data-bs-target="#sentModal2">
                            <span>Add Delivery Charges</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="userManagecontent mt-5">
                <div class="">

                    <div class="table-responsive w-100">
                        <table id="myTable" class="table w-100">
                            <thead>
                                <tr>
                                    <th scope="col">SR No.</th>
                                    <th scope="col">Range From to To (KM)</th>
                                    <th scope="col">Delivery Charges for User</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>0 Km to 10 Km</td>
                                    <td>10 KD</td>
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
    </div>
</div>


<div class="modal fade" id="sentModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Add Delivery Charges</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label">Range</label>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <label class="form-label">From</label>
                                        <select class="form-select form-select-lg mb-3"
                                            aria-label="Large select example">
                                            <option selected>0KM</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <label class="form-label">To</label>
                                        <select class="form-select form-select-lg mb-3"
                                            aria-label="Large select example">
                                            <option selected>0KM</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label">For User</label>
                                <input type="text" name="name_english" class="form-control" placeholder="Enter " />
                            </div>
                        </div>


                        <!-- Submit Button -->
                        <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                            <a type="button" id="submitBrandBtn" class="btn btn-dark customBtn mt-3">Submit</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection