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
            <h2 class="h2">{{ __('admin_messages.refund_management') }}</h2>
        </div>

        <div class="col-lg-3 col-md-4 col-12">
            @if(in_array(32, $permissions) || $admin->type == 1)
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.export_refund_data_new', request()->all()) }}" class="btn btn-dark customBtn" href="">
                    <span>{{ __('admin_messages.export') }}</span>
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
                        <label for="from_date" class="form-label">{{ __('admin_messages.from') }}:</label>
                        <input type="date" id="from_date" name="from_date" class="form-control datepicker"
                            value="{{ request()->from_date }}"
                            onchange="updateToDate(); document.getElementById('filterForm').submit();" />
                    </div>
                </div>

                <!-- To Date Filter -->
                <div class="col-lg-2 col-md-4 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="to_date" class="form-label">{{ __('admin_messages.to') }}:</label>
                        <input type="date" id="to_date" name="to_date" class="form-control datepicker"
                            value="{{ request()->to_date }}"
                            onchange="updateToDate(); document.getElementById('filterForm').submit();" />
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="status" class="form-label">{{ __('admin_messages.select_country') }}</label>
                        <select name="country_name" id="country_name" onchange="document.getElementById('filterForm').submit();" class="form-select form-select-lg">
                            <option value="">{{ __('admin_messages.select_country') }}</option>

                            @foreach($countries as $country)
                                <option value="{{ $country->name }}"
                                    {{ request('country_name') == $country->name ? 'selected' : '' }}>
                                    @if(app()->getLocale() == 'en')
                                    {{ $country->name }}
                                    @else
                                    {{ $country->name_ar }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-12 col-12">
                    <div class="d-dlex justify-content-end mt-5">
                        <a href="{{route('admin.refundManagement')}}" class="btn btn-dark customBtn w-50 mt-2">
                            <span>{{ __('admin_messages.reset') }}</span></a>
                    </div>
                </div>
                

            </div>
            </form>

            <div class="table-responsive w-100 mt-4">
                <table id="myTable" class="table w-100">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('admin_messages.s_no') }}</th>
                            <th scope="col">{{ __('admin_messages.transaction_id') }}</th>
                            <th scope="col">{{ __('admin_messages.order_id') }}</th>
                            <th scope="col">{{ __('admin_messages.order_date_time') }}</th>
                            <th scope="col">{{ __('admin_messages.cancellation_date_&_time') }}</th>
                            <th scope="col">{{ __('admin_messages.seller_name') }}</th>
                            <th scope="col">{{ __('admin_messages.user_name') }} </th>
                            <th scope="col">{{ __('admin_messages.country') }}</th>
                            <th scope="col">{{ __('admin_messages.reason') }}</th>
                            <th scope="col">{{ __('admin_messages.amount') }}</th>
                            <th scope="col">{{ __('admin_messages.status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($refundData['data'] as $data)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{$data->order->transaction_id ?? __('admin_messages.na')}}</td>
                            <td>{{$data->order->order_id ?? __('admin_messages.na')}}</td>
                            <td>{{ formatDateTimeByLocale($data->created_at ?? '') }}</td>
                            <td>{{ formatDateTimeByLocale($data->updated_at ?? '') }}</td>
                            <td>{{$data->product_details->seller_details->first_name ?? __('admin_messages.na')}} {{$data->product_details->seller_details->last_name ?? ''}}</td>
                            <td>{{$data->user_details->full_name ?? __('admin_messages.na')}}</td>
                            <td>
                                @if(app()->getLocale() == 'en')
                                {{$data->user_details->country_info->name ?? __('admin_messages.na')}}
                                @else
                                {{$data->user_details->country_info->name_ar ?? __('admin_messages.na')}}
                                @endif
                            </td>
                            <td>@if(!empty($data->cancel_reason))
                                    <a class="table-button view-owner-btn"
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#sentModal4"
                                    data-reason="{{ $data->cancel_reason }}">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                @else
                                    {{__('admin_messages.na')}}
                                @endif
                            </td>
                            <td>{{$data->amount}} {{__('admin_messages.kd')}}</td>
                            <td>{{__('admin_messages.pending')}}</td>
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
                <h2 class="h2">{{__('admin_messages.reason')}}</h2>
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