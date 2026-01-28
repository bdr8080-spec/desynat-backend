@extends('admin.layout.app')
@section('content')

<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">Product List</h2>
        </div>

    </div>

    <div class="userManagecontent">
        <div class="mt-4">
            <div class="row">
                <!-- <div class="col-lg-3 col-md-4 col-12">
                    <div class="search-box" style="position: relative;">
                        <i class="bi bi-search" style="
                        position: absolute;
                        left: 10px;
                        top: 50%;
                        transform: translateY(-50%);
                        font-size: 16px;
                        color: #888;
                      ">
                        </i>
                        <input type="text" class="form-control" placeholder="Search for..."
                            style="padding-left: 35px" />
                    </div>
                </div> -->

                <!-- <div class="col-lg-3 col-md-4 col-12">
                    <div class="form-group mb-5 w-100">
                        <select class="form-select form-select-lg" aria-label="Large select example">
                            <option selected>Select Brand</option>
                            <option value="1">Brand One</option>
                            <option value="2">Brand Two</option>
                            <option value="3">Brand Three</option>
                        </select>
                    </div>
                </div> -->

            </div>

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