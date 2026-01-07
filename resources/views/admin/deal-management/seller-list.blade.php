@extends('admin.layout.app')
@section('content')

<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">Seller List</h2>
        </div>

    </div>

    <div class="userManagecontent">
        <div class="mt-4">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="search-box" style="position: relative;">
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

                <div class="col-lg-3 col-md-4 col-12">
                    <div class="form-group mb-5 w-100">
                        <!-- <label for="from" class="form-label">Country Name</label> -->
                        <select class="form-select form-select-lg" aria-label="Large select example">
                            <option selected>Select Country</option>
                            <option value="1">country One</option>
                            <option value="2">country Two</option>
                            <option value="3">country Three</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="table-responsive mt-5 w-100">
                <table class="table w-100">
                    <thead>
                        <tr>
                            <th scope="col">SR No.</th>
                            <th scope="col">Seller Name</th>
                            <th scope="col">Country</th>
                            <th scope="col">Number of Products Added</th>
                            <th scope="col">Number of Products Sold Till Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Lorem </td>
                            <td>UAE</td>
                            <td class="short-title"><a href="{{route('admin.productList')}}">10 sellers</a></td>
                            <td>200</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection