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
                <form method="GET" action="{{ route('admin.dashboard') }}" id="filterForm">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h2 class="h2">WELCOME TO DASHBOARD</h2> 
                    </div>
                    <div class="col-lg-6">
                        <div class="filter-box d-flex align-items-center justify-content-end">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="radio"
                                    name="filter"
                                    value="1"
                                    {{ request()->filter == 1 ? 'checked' : '' }}
                                    onchange="document.getElementById('filterForm').submit();">
                                <label class="form-check-label">Today</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="radio"
                                    name="filter"
                                    value="2"
                                    {{ request()->filter == 2 ? 'checked' : '' }}
                                    onchange="document.getElementById('filterForm').submit();">
                                <label class="form-check-label">This Week</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="radio"
                                    name="filter"
                                    value="3"
                                    {{ request()->filter == 3 ? 'checked' : '' }}
                                    onchange="document.getElementById('filterForm').submit();">
                                <label class="form-check-label">This Month</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from_date" name="from_date" class="form-control"
                            value="{{ request()->from_date }}"
                            onchange="updateToDate(); document.getElementById('filterForm').submit();" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">To:</label>
                            <input type="date" id="to_date" name="to_date" class="form-control"
                            value="{{ request()->to_date }}"
                            onchange="updateToDate(); document.getElementById('filterForm').submit();" />
                        </div>
                    </div>
                    <!-- <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">Country Name</label>
                            <select class="form-select form-select-lg" aria-label="Large select example">
                                <option selected>Select Country</option>
                                <option value="1">country One</option>
                                <option value="2">country Two</option>
                                <option value="3">country Three</option>
                            </select>
                        </div>
                    </div> -->
                    <div class=" col-lg-3">
                        <div class="d-flex  gap-3 mt-5">
                            <a href="{{route('admin.dashboard')}}" class="btn btn-dark customBtn w-50 mt-2">
                                <span>Reset</span></a>
                                 <a href="{{ route('admin.export_dashboard_data', request()->all()) }}" class="btn btn-dark customBtns w-50 mt-2" >
                                <span>Export</span></a>
                        </div>
                    </div>
                   
                </div>
                </form>

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
                                            <span>{{$data['total_users']}}</span>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class=" text-center col-lg-6">
                                                <p>Active</p>
                                                <h5>{{$data['total_active_users']}}</h5>
                                            </div>
                                            <div class=" text-center col-lg-6">
                                                <p>Inactive</p>
                                                <h5>{{$data['total_inactive_users']}}</h5>
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
                                            <span> {{$data['total_affiliate_users']}}</span>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="text-center col-lg-6">
                                                <p>Active</p>

                                                <h5>{{$data['total_active_affiliate_users']}}</h5>

                                            </div>
                                            <div class=" text-center col-lg-6">
                                                <p>Inactive</p>
                                                <h5>{{$data['total_inactive_affiliate_users']}}</h5>
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
                                            <span> {{$data['total_delivery_boy']}}</span>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class=" text-center col-lg-6">
                                                <p>Active</p>
                                                <h5>{{$data['total_active_delivery_boy']}}</h5>
                                            </div>
                                            <div class=" text-center col-lg-6">
                                                <p>Inactive</p>
                                                <h5>{{$data['total_inactive_delivery_boy']}}</h5>
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
                                            <span>{{$data['total_sellers']}}</span>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="text-center col-lg-6">
                                                <p>Active</p>

                                                <h5>{{$data['total_active_sellers']}}</h5>

                                            </div>
                                            <div class=" text-center col-lg-6">
                                                <p>Inactive</p>
                                                <h5>{{$data['total_inactive_sellers']}}</h5>
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
                                            <span> {{$data['total_tickets']}}</span>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class=" text-center col-lg-4">
                                                <p>Raised</p>
                                                <h5>{{$data['total_tickets']}}</h5>
                                            </div>
                                            <div class=" text-center col-lg-4">
                                                <p>Un-resolved</p>
                                                <h5>{{$data['total_unresolved_tickets']}}</h5>
                                            </div>
                                            <div class=" text-center col-lg-4">
                                                <p>Resolved</p>
                                                <h5>{{$data['total_resolved_tickets']}}</h5>
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
                                            <span> {{$data['total_orders']}}</span>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="text-center col-lg-3">
                                                <p>On-going</p>

                                                <h5>{{$data['total_ongoing_orders']}}</h5>

                                            </div>
                                            <div class=" text-center col-lg-3">
                                                <p>Completed</p>
                                                <h5>{{$data['total_completed_orders']}}</h5>
                                            </div>
                                            <div class=" text-center col-lg-3">
                                                <p>Cancelled</p>
                                                <h5>{{$data['total_cancelled_orders']}}</h5>
                                            </div>
                                            <div class=" text-center col-lg-3">
                                                <p>Return</p>
                                                <h5>{{$data['total_returned_orders']}}</h5>
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
                                            <span>{{$data['total_revenue']}} KD</span>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class=" text-center col-lg-3">
                                                <p>By Orders</p>
                                                <h5>{{$data['total_order_revenue']}} KD</h5>
                                            </div>
                                            <div class=" text-center col-lg-3">
                                                <p>By Subscription Plan</p>
                                                <h5>{{$data['total_subscription_plan_revenue']}} KD</h5>
                                            </div>
                                             <div class=" text-center col-lg-3">
                                                <p>By Affilate Orders</p>
                                                <h5>{{$data['total_affiliate_orders_revenue']}} KD</h5>
                                            </div>
                                            <div class=" text-center col-lg-3">
                                                <p>By Banner</p>
                                                <h5>{{$data['total_banner_revenue']}} KD</h5>
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
                                            <span>{{$data['total_online_users']}}</span>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class=" text-center col-lg-6">
                                                <p>No.of Users Visit App</p>
                                                <h5>{{$data['total_app_visitor_users']}}</h5>
                                            </div>
                                            <div class=" text-center col-lg-6">
                                                <p>No.of User Visit Website</p>
                                                <h5>{{$data['total_website_visitor_users']}}</h5>
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

<script>
    function updateToDate() {
        const fromDate = document.getElementById('from_date').value;
        const toDateInput = document.getElementById('to_date');
        if (fromDate) {
            toDateInput.setAttribute('min', fromDate);
        } else {
            toDateInput.removeAttribute('min');
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        updateToDate();
    });

</script>


@endsection