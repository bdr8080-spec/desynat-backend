@extends('admin.layout.app')
@section('content')

<div class="inner-content management">
    <!-- <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            @php
                $sellerRecord = $products->sellerDealrecords->first();
            @endphp
            <h2 class="h2">{{ $sellerRecord->seller_details->first_name }} {{ $sellerRecord->seller_details->last_name }}</h2>
        </div>

    </div> -->
     <div class="d-flex align-items-center gap-3 mt-2">
            <div class="arrow">
                <a href="{{ route('admin.sellerList', ['id' => $products->id]) }}" class="table-button " type="button">
                    <i class="fas fa-angle-left"></i>
                </a>
            </div>
             @php
                $sellerRecord = $products->sellerDealrecords->first();
            @endphp
            <h2 class="h2 text-start">{{ $sellerRecord->seller_details->first_name }} {{ $sellerRecord->seller_details->last_name }}</h2>

        </div>


    <div class="userManagecontent">
        <div class="mt-4">
            <form method="GET" action="{{ route('admin.productList', ['deal_id' => $products->id, 'seller_id' => $sellerRecord->seller_id]) }}" id="filterForm">
            <div class="row">

                <div class="col-lg-3 col-md-4 col-12">
                    <div class="form-group mb-5 w-100">
                        <select name="filter" id="filter"
                            class="form-select form-select-lg "
                            onchange="document.getElementById('filterForm').submit();">
                            <option value="">Select brand</option>
                            @foreach($brands as $brand)
                            <option value="{{ $brand['name_english'] }}"
                                {{ request('filter') == $brand['name_english'] ? 'selected' : '' }}>
                                {{ $brand['name_english'] }}
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
                            <th scope="col">Image</th>
                            <th scope="col">Products Name</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Price</th>
                            <th scope="col">After Discount Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $sr = 1; @endphp
                            @foreach($products->sellerDealrecords as $sellerRecord)
                                @foreach($sellerRecord->products as $product)
                                    @php
                                        $productDetails = $product->product_details;
                                        $brand = $productDetails->brand;
                                        $variant = $productDetails->product_variants->first(); // assuming first variant for image/price
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $sr++ }}</th>
                                        <td>
                                            <img src="{{ $variant->variant_image[0] }}" 
                                                alt="{{ $productDetails->product_name_en ?? 'N/A' }}" 
                                                width="40" height="40" class="square" />
                                        </td>
                                        <td>{{ $productDetails->product_name_en ?? 'N/A' }}</td>
                                        <td>{{ $brand->name_english ?? 'N/A' }}</td>
                                        <td>{{ $variant->final_price ?? 0 }} KD</td>
                                        <td>{{ $variant->deal_discount_price ?? 0 }} KD</td>
                                    </tr>
                                @endforeach
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection