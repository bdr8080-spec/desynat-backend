@extends('admin.layout.app')
@section('content')
@php
    $admin = auth('admin')->user();

    $permissions = \App\Models\AdminPermission::where('admin_id', $admin->id)
        ->where('can_view', 1)
        ->pluck('module_id')
        ->toArray();
@endphp
<div id="content-wrapper" class="d-flex flex-column position-relative">
    <div id="content">

        @if(in_array(1, $permissions) || $admin->type == 1)
        <div class="inner-content">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h2 class="h2">WELCOME TO DASHBOARD</h2> 
                    </div>
                    <div class="col-lg-6">
                        <div class="filter-box d-flex align-items-center justify-content-end">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="radioDefault" checked />
                                <label class="form-check-label">Today</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="radioDefault" />
                                <label class="form-check-label">This Week</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="radioDefault" />
                                <label class="form-check-label">This Month</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-5 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from" class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-5 w-100">
                            <label for="from" class="form-label">To:</label>
                            <input type="date" id="from" class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-5 w-100">
                            <label for="from" class="form-label">Country Name</label>
                            <select class="form-select form-select-lg" aria-label="Large select example">
                                <option selected>Select Country</option>
                                <option value="1">country One</option>
                                <option value="2">country Two</option>
                                <option value="3">country Three</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-lg-3 col-12 mt-5">
                        <div class="d-dlex justify-content-end" style="text-align: end">
                            <a class="btn btn-dark customBtns w-100" style="margin-top: 30px">
                                <span>Export in Excel or PDF</span></a>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <hr />
                </div>

                <div class="row justify-content-center">
                    <div class="page-wapper dashboard-pnl">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="card border-radious-10">
                                    <div class="card-header">
                                        <div class="total-revenue justify-content-center">
                                            <h5>Total users registered</h5>
                                        </div>
                                        <div class="dolor-icon">
                                            <span> 1900</span>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class=" text-center col-lg-6">
                                                <p>Active</p>
                                                <h5>500</h5>
                                            </div>
                                            <div class=" text-center col-lg-6">
                                                <p>Inactive</p>
                                                <h5>200</h5>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-5">
                                <div class="card border-radious-10">
                                    <div class="card-header">
                                        <div class="total-revenue">
                                            <h5>Total Number of Affiliated Users</h5>
                                        </div>
                                        <div class="dolor-icon">
                                            <span> 2000</span>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="text-center col-lg-6">
                                                <p>Active</p>

                                                <h5>500</h5>

                                            </div>
                                            <div class=" text-center col-lg-6">
                                                <p>Inactive</p>
                                                <h5>200</h5>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="page-wapper dashboard-pnl">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="card border-radious-10">
                                    <div class="card-header">
                                        <div class="total-revenue justify-content-center">
                                            <h5>Total Number of Delivery Partners</h5>
                                        </div>
                                        <div class="dolor-icon">
                                            <span> 2000</span>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class=" text-center col-lg-6">
                                                <p>Active</p>
                                                <h5>500</h5>
                                            </div>
                                            <div class=" text-center col-lg-6">
                                                <p>Inactive</p>
                                                <h5>200</h5>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-5">
                                <div class="card border-radious-10">
                                    <div class="card-header">
                                        <div class="total-revenue">
                                            <h5>Total Number of Sellers</h5>
                                        </div>
                                        <div class="dolor-icon">
                                            <span>2000</span>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="text-center col-lg-6">
                                                <p>Active</p>

                                                <h5>500</h5>

                                            </div>
                                            <div class=" text-center col-lg-6">
                                                <p>Inactive</p>
                                                <h5>200</h5>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="page-wapper dashboard-pnl">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="card border-radious-10">
                                    <div class="card-header">
                                        <div class="total-revenue justify-content-center">
                                            <h5>Total tickets</h5>
                                        </div>
                                        <div class="dolor-icon">
                                            <span> 1500</span>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class=" text-center col-lg-4">
                                                <p>Raised</p>
                                                <h5>500</h5>
                                            </div>
                                            <div class=" text-center col-lg-4">
                                                <p>Un-resolved</p>
                                                <h5>200</h5>
                                            </div>
                                            <div class=" text-center col-lg-4">
                                                <p>Resolved</p>
                                                <h5>200</h5>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-5">
                                <div class="card border-radious-10">
                                    <div class="card-header">
                                        <div class="total-revenue">
                                            <h5>Total Number of Orders</h5>
                                        </div>
                                        <div class="dolor-icon">
                                            <span> 2000</span>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="text-center col-lg-3">
                                                <p>On-going</p>

                                                <h5>500</h5>

                                            </div>
                                            <div class=" text-center col-lg-3">
                                                <p>Completed</p>
                                                <h5>200</h5>
                                            </div>
                                            <div class=" text-center col-lg-3">
                                                <p>Cancelled</p>
                                                <h5>200</h5>
                                            </div>
                                            <div class=" text-center col-lg-3">
                                                <p>Return</p>
                                                <h5>200</h5>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="page-wapper dashboard-pnl">
                        <div class="row">
                            <div class="col-lg-12 col-md-6">
                                <div class="card border-radious-10">
                                    <div class="card-header">
                                        <div class="total-revenue justify-content-center">
                                            <h5>Total Revenue</h5>
                                        </div>
                                        <div class="dolor-icon">
                                            <span> $ 150000</span>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class=" text-center col-lg-3">
                                                <p>By Orders</p>
                                                <h5>$ 500</h5>
                                            </div>
                                            <div class=" text-center col-lg-3">
                                                <p>By Subscription Plan</p>
                                                <h5>$ 200</h5>
                                            </div>
                                             <div class=" text-center col-lg-3">
                                                <p>By Affilate Orders</p>
                                                <h5>$ 200</h5>
                                            </div>
                                            <div class=" text-center col-lg-3">
                                                <p>By Banner</p>
                                                <h5>$ 200</h5>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                         
                        </div>
                    </div>
                    <div class="page-wapper dashboard-pnl">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="card border-radious-10">
                                    <div class="card-header">
                                        <div class="total-revenue justify-content-center">
                                            <h5>Total Online Users</h5>
                                        </div>
                                        <div class="dolor-icon">
                                            <span> 2000</span>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class=" text-center col-lg-6">
                                                <p>No.of Users Visit App</p>
                                                <h5>500</h5>
                                            </div>
                                            <div class=" text-center col-lg-6">
                                                <p>No.of User Visit Website</p>
                                                <h5>500</h5>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="inner-content">
          <h5>You don't have dashboard access</h5>
        </div>
        @endif
    </div>

</div>
</div>

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Select "Logout" below if you are ready to end your current session.
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">
                    Cancel
                </button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>
@endsection