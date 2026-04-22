@extends('admin.layout.app')
@section('content')

<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">Refund Management</h2>
        </div>

        <div class="col-lg-3 col-md-4 col-12">
            <div class="d-flex justify-content-end">
                <a class="btn btn-dark customBtn" href="">
                    <span>Export in Excel</span>
                </a>
            </div>
        </div>
    </div>

    <div class="userManagecontent">
        <div class="mt-4">
            <div class="row align-items-end">
                <!-- From Date Filter -->
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="from" class="form-label">From:</label>
                        <input type="date" id="from" name="from_date2" class="form-control" />
                    </div>
                </div>

                <!-- To Date Filter -->
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="to" class="form-label">To:</label>
                        <input type="date" id="to" name="to_date2" class="form-control" />
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="status" class="form-label">Country-</label>
                        <select name="Country" class="form-select form-select-lg">
                            <option value="">Select</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="table-responsive w-100 mt-4">
                <table id="myTable" class="table w-100">
                    <thead>
                        <tr>
                            <th scope="col">SR No.</th>
                            <th scope="col">Transaction ID</th>
                            <th scope="col">Order ID</th>
                            <th scope="col">Order Date & Time</th>
                            <th scope="col">Cancellation Date & Time</th>
                            <th scope="col">Seller Name</th>
                            <th scope="col">User Name </th>
                            <th scope="col">Country</th>
                            <th scope="col">Reason</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Lorem</td>
                            <td>UAE</td>
                            <td>23456 </td>
                            <td>lorem</td>
                            <td>lorem</td>
                            <td>lorem</td>
                            <td>lorem</td>
                            <td>lorem</td>
                            <td>lorem</td>
                            <td>lorem</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection