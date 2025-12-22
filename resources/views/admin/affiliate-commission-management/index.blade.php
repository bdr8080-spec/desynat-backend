@extends('admin.layout.app')
@section('content')



<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">Affiliate Commission Management </h2>
        </div>
    </div>

    <div class="userManagecontent">
        <div class="mt-4">
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
                    <input type="text" class="form-control" placeholder="Search for..." style="padding-left: 35px" />
                </div>
            </div>

            <div class="table-responsive mt-5 w-100">
                <table class="table w-100">
                    <thead>
                        <tr>
                            <th scope="col">SR No.</th>
                            <th scope="col">Country Name</th>
                            <th scope="col">Commission Percentage</th>
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
<div class="modal fade" id="sentModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <!-- <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1> -->
                <h2 class="h2">Affiliate Commission Percentage</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-auto mb-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group w-100 m-auto">
                            <label for="from" class="form-label">Set Commission</label>
                            <input type="text" class="w-100" placeholder="Enter Commission" class="form-control"
                                aria-describedby="passwordHelpInline" />
                            <span style="
                      position: absolute;
                      right: 8px;
                      top: 69%;
                      transform: translateY(-50%);
                      color: #6c757d;
                      pointer-events: none;
                      font-weight: 500;
                    ">
                                %
                            </span>
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


@endsection