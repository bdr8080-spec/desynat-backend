@extends('admin.layout.app')
@section('content')

<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">Product List</h2>
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
                            <option selected>Select Brand</option>
                            <option value="1">Brand One</option>
                            <option value="2">Brand Two</option>
                            <option value="3">Brand Three</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="table-responsive mt-5 w-100">
                <table class="table w-100">
                    <thead>
                        <tr>
                            <th scope="col">SR No.</th>
                            <th scope="col">Image</th>
                            <th scope="col">Products Name</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Price</th>
                            <th scope="col">After Discount Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td> <img src="image/profile.jpg" alt="" width="40px" height="40px" class="square" /> </td>
                            <td>lorem</td>
                            <td>lorem</td>
                            <td>KD200</td>
                            <td>KD1200</td>
                        </tr>
                        <tr>
                            <th scope="row">1</th>
                            <td> <img src="image/profile.jpg" alt="" width="40px" height="40px" class="square" /> </td>
                            <td>lorem</td>
                            <td>lorem</td>
                            <td>KD200</td>
                            <td>KD1200</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection