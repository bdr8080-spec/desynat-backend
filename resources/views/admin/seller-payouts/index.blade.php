@extends('admin.layout.app')
@section('content')
@php $currency = $currency === 'KWD' ? 'KD' : $currency; @endphp


<div id="content-wrapper" class="d-flex flex-column position-relative">
    <div id="content" class="">

        <div class="inner-content management">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 col-md-6 col-12">
                    <h2 class="h2">Seller Payouts Management</h2>
                </div>
            </div>

            <form method="GET" action="{{ route('admin.payouts') }}" id="filterForm">
            <div class="row">
                <div class="col-lg-2 col-md-3 col-12">
                    <div class="form-group  w-100">
                        <label for="from_date" class="form-label">From</label>
                        <input type="date" id="from_date" name="from_date" class="form-control datepicker"
                            value="{{ request()->from_date }}"
                            onchange="updateToDate(); document.getElementById('filterForm').submit();" />
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-12">
                    <div class="form-group  w-100">
                        <label for="to_date" class="form-label">To</label>
                        <input type="date" id="to_date" name="to_date" class="form-control datepicker"
                            value="{{ request()->to_date }}"
                            onchange="document.getElementById('filterForm').submit();" />
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-12">
                    <div class="form-group  w-100">
                        <label for="countryId" class="form-label">Country</label>
                        <select name="countryId" id="countryId" class="form-select form-select-lg"
                            onchange="document.getElementById('filterForm').submit();">
                            <option value="">{{ __('admin_messages.select_country') }}</option>
                            @foreach($countries as $country)
                            <option value="{{ $country['id'] }}" {{ request('countryId') == $country['id'] ? 'selected' : '' }}>
                                {{ app()->getLocale() == 'en' ? $country['name'] : $country['name_ar'] }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-12 d-flex align-items-end">
                    <a href="{{ route('admin.payouts') }}" class="btn btn-dark customBtn mt-3">
                        <span>{{ __('admin_messages.reset') }}</span>
                    </a>
                </div>

                <div class="col-lg-4 col-md-12 col-12 d-flex  align-items-end">
                    <h5 class="text-color" style="color:#ac875e;">Total Pending Payout:- {{ $currency }} {{ $totalPending }}</h5>
                </div>

            </div>
            </form>

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
                            @foreach($sellers as $index => $seller)
                            @php
                                $sellerCurrency = $seller->currency_code ?? 'KD';
                                $sellerCurrency = $sellerCurrency === 'KWD' ? 'KD' : $sellerCurrency;
                            @endphp
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $seller->seller_name ?: __('admin_messages.na') }}</td>
                                <td>{{ $seller->country_name ?? __('admin_messages.na') }}</td>
                                <td>{{ $sellerCurrency }} {{ $seller->total_earning }}</td>
                                <td>{{ $seller->last_payout_date ? \Carbon\Carbon::parse($seller->last_payout_date)->format('jS M Y') : __('admin_messages.na') }}</td>
                                <td>{{ $sellerCurrency }} {{ $seller->last_payout }}</td>
                                <td>{{ $sellerCurrency }} {{ $seller->pending_amount }}</td>
                                <td>
                                    <a class="btn btn-dark customBtn" href="{{ route('admin.view-seller-payouts', ['seller_id' => $seller->id]) }}">
                                        <span>Manage Payout</span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
            if (toDateInput.value && toDateInput.value < fromDate) {
                toDateInput.value = '';
            }
        } else {
            toDateInput.removeAttribute('min');
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        updateToDate();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
        toastr.success("{{ session('success') }}");
        @endif
        @if(session('error'))
        toastr.error("{{ session('error') }}");
        @endif
    });
</script>

@endsection
