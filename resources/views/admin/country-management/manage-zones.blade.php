@extends('admin.layout.app')
@section('content')


<div id="content-wrapper" class="d-flex flex-column position-relative">
    <div id="content" class="">


        <div class="inner-content management">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 col-md-6 col-12">
                    <h2 class="h2">Manage Zone(UAE>Dubai)</h2>
                </div>

                <div class="col-lg-3 col-md-4 col-12">
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-dark customBtn" data-bs-toggle="modal" data-bs-target="#sentModal2">
                            <span>Add Zone</span>
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
                                    <th scope="col">Zone Name</th>
                                    <th scope="col">View on Map</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Dubai </td>
                                    <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                            data-bs-target="#sentModal2">
                                            <i class="bi bi-eye-fill"></i>
                                        </a></td>
                                    <td>
                                        <div class="d-flex gap-3 justify-content-center">
                                            <a class="table-button" type="button">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <a class="table-button" type="button">
                                                <i class="bi bi-trash3-fill"></i>
                                            </a>


                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Dubai </td>
                                    <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                            data-bs-target="#sentModal2">
                                            <i class="bi bi-eye-fill"></i>
                                        </a></td>
                                    <td>
                                        <div class="d-flex gap-3 justify-content-center">
                                            <a class="table-button" type="button">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <a class="table-button" type="button">
                                                <i class="bi bi-trash3-fill"></i>
                                            </a>


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



@endsection