@extends('admin.layout.app')
@section('content')

@php
    $admin = auth('admin')->user();

    $permissions = \App\Models\AdminPermission::where('admin_id', $admin->id)
        ->where('can_action', 1)
        ->pluck('module_id')
        ->toArray();
@endphp

<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">Refund Management</h2>
        </div>

        <div class="col-lg-3 col-md-4 col-12">
            @if(in_array(32, $permissions) || $admin->type == 1)
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.export_refund_data', request()->all()) }}" class="btn btn-dark customBtn" href="">
                    <span>Export</span>
                </a>
            </div>
            @endif
        </div>
    </div>

    <div class="userManagecontent">
        
        <div class="mt-4">
            <form method="GET" action="{{ route('admin.refundManagement') }}" id="filterForm">
            <div class="row align-items-end">
                <!-- From Date Filter -->
                <div class="col-lg-2 col-md-4 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="from_date" class="form-label">From:</label>
                        <input type="date" id="from_date" name="from_date" class="form-control"
                            value="{{ request()->from_date }}"
                            onchange="updateToDate(); document.getElementById('filterForm').submit();" />
                    </div>
                </div>

                <!-- To Date Filter -->
                <div class="col-lg-2 col-md-4 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="to_date" class="form-label">To:</label>
                        <input type="date" id="to_date" name="to_date" class="form-control"
                            value="{{ request()->to_date }}"
                            onchange="updateToDate(); document.getElementById('filterForm').submit();" />
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="status" class="form-label">Country</label>
                        <select name="country_name" id="country_name" onchange="document.getElementById('filterForm').submit();" class="form-select form-select-lg">
                            <option value="">Select country</option>

                            @foreach($countries as $country)
                                <option value="{{ $country->name }}"
                                    {{ request('country_name') == $country->name ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-12 col-12">
                    <div class="d-dlex justify-content-end mt-5">
                        <a href="{{route('admin.refundManagement')}}" class="btn btn-dark customBtn w-50 mt-2">
                            <span>Reset</span></a>
                    </div>
                </div>
                

            </div>
            </form>

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
                            <th scope="col">User Country</th>
                            <th scope="col">Reason</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($refundData['data'] as $data)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{$data->order->transaction_id ?? 'N/A'}}</td>
                            <td>{{$data->order->order_id ?? 'N/A'}}</td>
                            <td>{{ $data->created_at->format('jS F Y | g:i A') }} </td>
                            <td>{{ $data->updated_at->format('jS F Y | g:i A') }}</td>
                            <td>{{$data->product_details->seller_details->first_name}} {{$data->product_details->seller_details->last_name}}</td>
                            <td>{{$data->user_details->full_name}}</td>
                            <td>{{$data->user_details->country_info->name}}</td>
                            <td>@if(!empty($data->cancel_reason))
                                    <a class="table-button view-owner-btn"
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#sentModal4"
                                    data-reason="{{ $data->cancel_reason }}">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{$data->amount}} KD</td>
                            <td>Pending</td>
                        </tr>
                         @empty

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="sentModal4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Reason</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="reasonContainer" class="appointment-container d-flex flex-wrap  justify-content-center">
                </div>
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

<script>
document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".view-owner-btn");
    const reasonContainer = document.getElementById("reasonContainer");

    buttons.forEach(button => {
        button.addEventListener("click", function () {
            const reason = this.getAttribute("data-reason");

            reasonContainer.innerHTML = `<p style="font-size: 16px; line-height: 1.5;font-weight: 500;">${reason}</p>`;
        });
    });
});
</script>


@endsection