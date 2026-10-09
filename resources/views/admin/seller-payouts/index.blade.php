@extends('admin.layout.app')
@section('content')


<div id="content-wrapper" class="d-flex flex-column position-relative">
    <div id="content" class="">

        <div class="inner-content management">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 col-md-6 col-12">
                    <h2 class="h2">Seller Payouts Management</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-2 col-md-3 col-12">
                    <div class="form-group  w-100">
                        <label for="from" class="form-label">From</label>
                        <input type="date" class="form-control datepicker" />
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-12">
                    <div class="form-group  w-100">
                        <label for="from" class="form-label">To</label>
                        <input type="date" class="form-control datepicker" />
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-12">
                    <div class="form-group  w-100">
                        <label for="from" class="form-label">Country</label>
                        <select class="form-select form-select-lg">
                            <option value="">Oman</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-12 d-flex  align-items-end">
                    <h5 class="text-color" style="color:#ac875e;">Total Pending Payout:- KD 100000</h5>
                </div>

            </div>

            <div class="userManagecontent mt-4">
                <div class="table-responsive w-100">
                    <table id="myTable" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Seller Name</th>
                                <th scope="col">Country</th>
                                <th scope="col">Total Earning</th>
                                <th scope="col">Last Payout Date</th>
                                <th scope="col">Last Payout Amount</th>
                                <th scope="col">Total Pending Payout Amount</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Ajay Kumar</td>
                                <td>Oman </td>
                                <td>OMR 1000</td>
                                <td>20th Dec 2024 </td>
                                <td>KD 150</td>
                                <td>KD 500</td>
                                <td> 
                                    <a class="btn btn-dark customBtn" href="{{route('admin.view-seller-payouts')}}">
                                        <span>Manage Payout</span>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Ajay Kumar</td>
                                <td>Oman </td>
                                <td>OMR 1000</td>
                                <td>20th Dec 2024 </td>
                                <td>KD 150</td>
                                <td>KD 500</td>
                                <td> 
                                    <a class="btn btn-dark customBtn" href="{{route('admin.view-seller-payouts')}}">
                                        <span>Manage Payout</span>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection