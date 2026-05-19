@extends('admin.layout.app')
@section('content')

<div class="inner-content management">
    <!-- <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">{{ $sellers->name_english }}</h2>
        </div>

    </div> -->
      <div class="d-flex align-items-center gap-3 mt-2">
            <div class="arrow">
                <a href="{{route('admin.dealManagement')}}" class="table-button " type="button">
                    <i class="fas fa-angle-left"></i>
                </a>
            </div>
            
        </div>
        <h2 class="h2 text-start"  style="font-size: 27px;margin-left: 13px;margin: 26px;">@if(app()->getLocale() == 'en'){{ $sellers->name_english }}@else{{ $sellers->name_arabic }}@endif</h2>

    <div class="userManagecontent">
        <div class="mt-4">
            <form method="GET" action="{{ route('admin.sellerList', ['id' => $sellers->id]) }}" id="filterForm">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="form-group  w-100">
                        <select name="country" id="country"
                            class="form-select form-select-lg "
                            onchange="document.getElementById('filterForm').submit();">
                            <option value="">{{ __('admin_messages.select_country') }}</option>
                            @foreach($countries as $country)
                            <option value="{{ $country['name'] }}"
                                {{ request('country') == $country['name'] ? 'selected' : '' }}>
                                @if(app()->getLocale() == 'en')
                                {{ $country['name'] }}
                                @else
                                {{ $country['name_ar'] }}
                                @endif
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
            </form>

            <div class="table-responsive mt-3 w-100">
                <table id="myTable" class="table w-100">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('admin_messages.s_no') }}</th>
                            <th scope="col">{{ __('admin_messages.seller_name') }}</th>
                            <th scope="col">{{ __('admin_messages.country') }}</th>
                            <th scope="col">{{ __('admin_messages.number_of_products_added') }}</th>
                            <th scope="col">{{ __('admin_messages.number_of_products_sold_till_date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($sellers && $sellers->sellerDealrecords->isNotEmpty())
                            @foreach($sellers->sellerDealrecords as $index => $sellerRecord)
                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>{{ $sellerRecord->seller_details->first_name ?? '' }} {{ $sellerRecord->seller_details->last_name ?? '' }}</td>
                                    <td>
                                        @if(app()->getLocale() == 'en')
                                        {{ $sellerRecord->seller_details->country_details->name ?? __('admin_messages.na') }}
                                        @else
                                        {{ $sellerRecord->seller_details->country_details->name_ar ?? __('admin_messages.na') }}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.productList', [
                                                'deal_id' => $sellerRecord->deal_id, 
                                                'seller_id' => $sellerRecord->seller_id
                                            ]) }}" class="text">
                                            {{ $sellerRecord->product_count ?? 0 }} {{ __('admin_messages.products') }}
                                        </a>
                                    </td>
                                    <td>0</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">{{ __('admin_messages.no_data_found') }}</td>
                            </tr>
                        @endif


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection