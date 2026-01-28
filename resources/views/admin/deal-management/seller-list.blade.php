@extends('admin.layout.app')
@section('content')

<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">{{ $sellers->name_english }}</h2>
        </div>

    </div>

    <div class="userManagecontent">
        <div class="mt-4">
            <form method="GET" action="{{ route('admin.sellerList', ['id' => $sellers->id]) }}" id="filterForm">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="form-group mb-5 w-100">
                        <select name="country" id="country"
                            class="form-select form-select-lg "
                            onchange="document.getElementById('filterForm').submit();">
                            <option value="">Select country</option>
                            @foreach($countries as $country)
                            <option value="{{ $country['name'] }}"
                                {{ request('country') == $country['name'] ? 'selected' : '' }}>
                                {{ $country['name'] }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
            </form>

            <div class="table-responsive mt-5 w-100">
                <table id="myTable" class="table w-100">
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
                        @if($sellers && $sellers->sellerDealrecords->isNotEmpty())
                            @foreach($sellers->sellerDealrecords as $index => $sellerRecord)
                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>{{ $sellerRecord->seller_details->first_name ?? '' }} {{ $sellerRecord->seller_details->last_name ?? '' }}</td>
                                    <td>{{ $sellerRecord->seller_details->country_details->name ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('admin.productList', [
                                                'deal_id' => $sellerRecord->deal_id, 
                                                'seller_id' => $sellerRecord->seller_id
                                            ]) }}">
                                            {{ $sellerRecord->product_count ?? 0 }} products
                                        </a>
                                    </td>
                                    <td>0</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">No sellers found.</td>
                            </tr>
                        @endif


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection