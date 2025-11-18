@include('dealer.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24">Product Management</div>
        <a href="{{ route('seller.Add_product') }}" class="btn btn-success">Add New Product</a>
    </div>

    <div class="tabs-panel py-4">
        <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active w-100" id="pills-allproduct-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-allproduct" type="button" role="tab" aria-controls="pills-allproduct"
                    aria-selected="true">All ({{ $data['all_product_count'] }})</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link w-100" id="pills-active-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-active" type="button" role="tab" aria-controls="pills-active"
                    aria-selected="false">Active ({{ $data['active_product_count'] }})</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link w-100" id="pills-inactive-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-inactive" type="button" role="tab" aria-controls="pills-inactive"
                    aria-selected="false">Inactive ({{ $data['inactive_product_count'] }})</button>
            </li>

        </ul>
    </div>

    <div class="tab-body-wapper">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-allproduct" role="tabpanel"
                aria-labelledby="pills-allproduct-tab" tabindex="0">
                <div class="datatable-wapper">
                    <div class="table-header">
                        <div class="search-field">
                            <div class="from-group position-relative">
                                <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search"
                                    class="search-icon">
                                <input type="search" class="form-control" placeholder="Search">
                            </div>
                        </div>
                        <div class="search-filter">
                            <div class="from-group">
                                <select class="form-select form-control width-50" aria-label="Default select example">
                                    <option selected>Filter by Category</option>
                                    @foreach ($category as $item)
                                        <option {{ $item->id }}>{{ $item->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="from-group">
                                <select class="form-select form-control width-50" aria-label="Default select example">
                                    <option selected>Filter by brand</option>
                                    @foreach ($brand as $item)
                                        <option value="{{ $item->id }}">{{ $item->name_english }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- All Product show --}}
                    <div class="table-responsive">
                        <table id="example" class="table datatable table-bordered">
                            <thead>
                                <tr>
                                    <th class="no-sort">S.No</th>
                                    <th class="no-sort">Image</th>
                                    <th class="no-sort">Product code</th>
                                    <th class="no-sort">Name</th>
                                    <th class="no-sort">Brand</th>
                                    <th class="no-sort">Category</th>
                                    <th class="no-sort">Added on</th>
                                    <th class="no-sort">Availability</th>
                                    <th class="no-sort">Status</th>
                                    <th class="no-sort">View more details</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($data['all_product_data'] as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            @foreach ($item->product_variants['0']->variant_image as $key1 => $img)
                                                @if ($key1 >= 1)
                                                    @php
                                                        break;
                                                    @endphp
                                                @endif
                                                <img src="{{ $img }}" class="img-fluid" alt="image"
                                                    class="pro-image" style="width:150px; height:auto;">
                                            @endforeach

                                        </td>
                                        <td>

                                            {{ $item->product_variants['0']->sku }}

                                        </td>
                                        <td> {{ $item->product_name_en }}</td>
                                        <td>{{ $item->brand->name_english }}</td>
                                        <td>{{ $item->category->name }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            @if ($item->product_variants['0']->total_stock > 1)
                                                In Stock
                                            @else
                                                Out of Stock
                                            @endif

                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="switchCheckDefault"
                                                        @if ($item->product_active_status == 1) checked @endif>
                                                    <label class="form-check-label" for="switchCheckDefault"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="#" class="eyebtn"><i class="bi bi-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="pills-active" role="tabpanel" aria-labelledby="pills-active-tab"
                tabindex="0">
                <div class="datatable-wapper">
                    <div class="table-header">
                        <div class="search-field">
                            <div class="from-group position-relative">
                                <input type="search" class="form-control" placeholder="Search">
                            </div>
                        </div>
                        <div class="search-filter">
                            <div class="from-group">
                                <select class="form-select form-control width-50" aria-label="Default select example">
                                    <option selected>Filter by Category</option>
                                    @foreach ($category as $item)
                                        <option {{ $item->id }}>{{ $item->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="from-group">
                                <select class="form-select form-control width-50" aria-label="Default select example">
                                    <option selected>Filter by brand</option>
                                    @foreach ($brand as $item)
                                        <option value="{{ $item->id }}">{{ $item->name_english }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- // Active product List  --}}
                    <div class="table-responsive">
                        <table class="table datatable table-bordered">
                            <thead>
                                <tr>
                                    <th class="no-sort">S.No</th>
                                    <th class="no-sort">Image</th>
                                    <th class="no-sort">Product code</th>
                                    <th class="no-sort">Name</th>
                                    <th class="no-sort">Brand</th>
                                    <th class="no-sort">Category</th>
                                    <th class="no-sort">Added on</th>
                                    <th class="no-sort">Availability</th>
                                    <th class="no-sort">Status</th>
                                    <th class="no-sort">View more details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['active_product'] as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            @foreach ($item->product_variants['0']->variant_image as $key1 => $img)
                                                @if ($key1 >= 1)
                                                    @php
                                                        break;
                                                    @endphp
                                                @endif
                                                <img src="{{ $img }}" class="img-fluid" alt="image"
                                                    class="pro-image" style="width:150px; height:auto;">
                                            @endforeach

                                        </td>
                                        <td>

                                            {{ $item->product_variants['0']->sku }}

                                        </td>
                                        <td> {{ $item->product_name_en }}</td>
                                        <td>{{ $item->brand->name_english }}</td>
                                        <td>{{ $item->category->name }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            @if ($item->product_variants['0']->total_stock > 1)
                                                In Stock
                                            @else
                                                Out of Stock
                                            @endif

                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="switchCheckDefault"
                                                        @if ($item->product_active_status == 1) checked @endif>
                                                    <label class="form-check-label" for="switchCheckDefault"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="#" class="eyebtn"><i class="bi bi-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="tab-pane fade" id="pills-inactive" role="tabpanel" aria-labelledby="pills-inactive-tab"
                tabindex="0">
                <div class="datatable-wapper">
                    <div class="table-header">
                        <div class="search-field">
                            <div class="from-group position-relative">
                                <input type="search" class="form-control" placeholder="Search">
                            </div>
                        </div>
                        <div class="search-filter">
                            <div class="from-group">
                                <select class="form-select form-control width-50" aria-label="Default select example">
                                    <option selected>Filter by Category</option>
                                    @foreach ($category as $item)
                                        <option {{ $item->id }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="from-group">
                                <select class="form-select form-control width-50" aria-label="Default select example">
                                    <option selected>Filter by brand</option>
                                    @foreach ($brand as $item)
                                        <option value="{{ $item->id }}">{{ $item->name_english }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table datatable table-bordered">
                            <thead>
                                <tr>
                                    <th class="no-sort">S.No</th>
                                    <th class="no-sort">Image</th>
                                    <th class="no-sort">Product code</th>
                                    <th class="no-sort">Name</th>
                                    <th class="no-sort">Brand</th>
                                    <th class="no-sort">Category</th>
                                    <th class="no-sort">Added on</th>
                                    <th class="no-sort">Availability</th>
                                    <th class="no-sort">Status</th>
                                    <th class="no-sort">View more details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['inactive_product'] as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            @foreach ($item->product_variants['0']->variant_image as $key1 => $img)
                                                @if ($key1 >= 1)
                                                    @php
                                                        break;
                                                    @endphp
                                                @endif
                                                <img src="{{ $img }}" class="img-fluid" alt="image"
                                                    class="pro-image" style="width:150px; height:auto;">
                                            @endforeach

                                        </td>
                                        <td>

                                            {{ $item->product_variants['0']->sku }}

                                        </td>
                                        <td> {{ $item->product_name_en }}</td>
                                        <td>{{ $item->brand->name_english }}</td>
                                        <td>{{ $item->category->name }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            @if ($item->product_variants['0']->total_stock > 1)
                                                In Stock
                                            @else
                                                Out of Stock
                                            @endif

                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="switchCheckDefault"
                                                        @if ($item->product_active_status == 1) checked @endif>
                                                    <label class="form-check-label" for="switchCheckDefault"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="#" class="eyebtn"><i class="bi bi-eye"></i></a>
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





    </div>




    @include('dealer.layout.footer');
