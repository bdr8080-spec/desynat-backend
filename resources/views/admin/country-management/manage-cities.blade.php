@extends('admin.layout.app')
@section('content')

<div id="content-wrapper" class="d-flex flex-column position-relative">
    <div id="content" class="">


        <div class="inner-content management">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="d-flex align-items-center gap-3 mt-2">
                        <div class="arrow">
                            <a class="table-button" type="button" href="{{route('countryManagement')}}">
                                <i class="fas fa-angle-left"></i>
                            </a>
                        </div>
                        <h6 class="m-0">Manage City(UAE)</h6>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-12">
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-dark customBtn" data-bs-toggle="modal" data-bs-target="#sentModal2">
                            <span>Add City</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="userManagecontent">
                <div class="mt-4">
                    <div class="align-items-end d-flex">
                        <div class="search-box" style="position: relative; ">
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

                    <div class="table-responsive w-100">
                        <table class="table w-100">
                            <thead>
                                <tr>
                                    <th scope="col">SR No.</th>
                                    <th scope="col">City Name</th>
                                    <th scope="col">Manage Zones</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Dubai </td>
                                    <td> <a class="btn btn-dark customBtn" href="{{route('manageZones')}}">
                                            <span>Manage</span>
                                        </a></td>
                                    <td>
                                        <div class="d-flex gap-3 justify-content-center">


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
                                    <td>Dubai </td>
                                    <td> <a class="btn btn-dark customBtn" href="{{route('manageZones')}}">
                                            <span>Manage</span>
                                        </a></td>
                                    <td>
                                        <div class="d-flex gap-3 justify-content-center">


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
    </div>
</div>
</div>

<!-- add new model -->
<div class="modal fade" id="sentModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <!-- <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1> -->
                <h2 class="h2">Add City</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-lg-12">

                        <div class="form-group w-100">
                            <label for="from" class="form-label">City Name</label>
                            <select class="form-select form-select-lg" aria-label="Large select example">
                                <option selected>Select City</option>
                                <option value="1">City One</option>
                                <option value="2">City Two</option>
                                <option value="3">City Three</option>
                            </select>
                        </div>

                    </div>
                    <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                                <div class="d-flex align-items-center justify-content-center gap-3 mt-3"
                                    style="margin-top: 30px">
                                    <a class="btn btn-dark customBtn" href=""> Submit</a>
                                </div>
                            </div>
                </div>

            </div>
        </div>
    </div>
</div>


@endsection