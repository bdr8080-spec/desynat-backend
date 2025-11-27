@include('dealer.layout.header')
<style>
    td img{
        width: 65px;height: 65px !important;border-radius: 50%;object-fit: fill;"
    }
</style>
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

    <meta name="csrf-token" content="{{ csrf_token() }}">


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
                                  <input type="search" class="form-control tableSearch" placeholder="Search"  data-table="table1">
                           
                            </div>
                        </div>

                        <form method="GET" action="">

                            <input type="hidden" name="type" value="0">

                            <div class="search-filter">
                                <div class="from-group">
                                    <select class="form-select form-control width-50"
                                        aria-label="Default select example" name="cargory_filter"
                                        onchange="this.form.submit()">
                                        <option value="">Filter by Category</option>
                                        @foreach ($category as $item)
                                            <option value="{{ $item->id }}"
                                                @if (request()->type == 0 && request()->cargory_filter == $item->id) selected @endif>{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="from-group">
                                    <select class="form-select form-control width-50"
                                        aria-label="Default select example" name="brand_filter"
                                        onchange="this.form.submit()">
                                        <option value="">Filter by brand</option>
                                        @foreach ($brand as $item)
                                            <option value="{{ $item->id }}"
                                                @if (request()->type == 0 && request()->brand_filter == $item->id) selected @endif>
                                                {{ $item->name_english }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </form>
                    </div>

                    {{-- All Product show --}}
                    <div class="table-responsive">
                        <table  class="table  table-bordered @if(count($data['all_product_data']) > 0 ) datatable @endif" id="table1">
                            <thead>
                                <tr>
                                    <th class="no-sort">S.No</th>
                                    <th class="no-sort">Image</th>
                                    <th class="no-sort">Product code</th>
                                    <th class="no-sort">Product Name</th>
                                    <th class="no-sort">Brand</th>
                                    <th class="no-sort">Category</th>
                                    <th class="no-sort">Added on</th>
                                    <th class="no-sort">Availability</th>
                                    <th class="no-sort">Active/Inactive</th>
                                    <th class="no-sort">
                                        View more details
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($data['all_product_data'] as $key => $item)
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
                                                    class="pro-image" style="width: 65px;height: 65px;border-radius: 50%;object-fit: cover;">
                                            @endforeach

                                        </td>
                                        <td>

                                            {{-- {{ $item->product_variants['0']->sku }} --}}

                                            {{ $item->id }}

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
                                                        id="switchCheckDefault" rel="{{ $item->id }}"
                                                        @if ($item->product_active_status == 1) checked @endif>
                                                    <label class="form-check-label" for="switchCheckDefault"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('seller.view_product', $item->id) }}" class="eyebtn"><i
                                                    class="bi bi-eye"></i></a>
                                        </td>
                                    </tr>
                                {{-- @endforeach --}}

                                 @empty
                          <tr>
                              <td colspan="10" class="text-center text-muted">No Product found</td>
                          </tr>
                      @endforelse

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
                                <input type="search" class="form-control tableSearch" placeholder="Search"  data-table="table2">
                            </div>
                        </div>
                        <form method="GET" action="">

                            <input type="hidden" name="type" value="1">

                            <div class="search-filter">
                                <div class="from-group">
                                    <select class="form-select form-control width-50"
                                        aria-label="Default select example" name="cargory_filter"
                                        onchange="this.form.submit()">
                                        <option value="">Filter by Category</option>
                                        @foreach ($category as $item)
                                            <option value="{{ $item->id }}"
                                                @if (request()->type == 1 && request()->cargory_filter == $item->id) selected @endif>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="from-group">
                                    <select class="form-select form-control width-50"
                                        aria-label="Default select example" name="brand_filter"
                                        onchange="this.form.submit()">
                                        <option value="">Filter by brand</option>
                                        @foreach ($brand as $item)
                                            <option value="{{ $item->id }}"
                                                @if (request()->type == 1 && request()->brand_filter == $item->id) selected @endif>
                                                {{ $item->name_english }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </form>
                    </div>

                    {{-- // Active product List  --}}
                    <div class="table-responsive">
                        <table class="table table-bordered @if(count($data['active_product']) > 0 ) datatable   @endif" id="table2">
                            <thead>
                                <tr>
                                    <th class="no-sort">S.No</th>
                                    <th class="no-sort">Image</th>
                                    <th class="no-sort">Product code</th>
                                    <th class="no-sort">Product Name</th>
                                    <th class="no-sort">Brand</th>
                                    <th class="no-sort">Category</th>
                                    <th class="no-sort">Added on</th>
                                    <th class="no-sort">Availability</th>
                                    <th class="no-sort">Active/Inactive</th>
                                    <th class="no-sort">View more details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data['active_product'] as $key => $item)
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
                                                    class="img-fluid" >
                                            @endforeach

                                        </td>
                                        <td>

                                            {{-- {{ $item->product_variants['0']->sku }} --}}
                                            {{ $item->id }}

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
                                                        id="switchCheckDefault" rel="{{ $item->id }}"
                                                        @if ($item->product_active_status == 1) checked @endif>
                                                    <label class="form-check-label" for="switchCheckDefault"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('seller.view_product', $item->id) }}" class="eyebtn"><i
                                                    class="bi bi-eye"></i></a>
                                        </td>
                                    </tr>
                                {{-- @endforeach --}}
                                 @empty
                          <tr>
                              <td colspan="10" class="text-center text-muted">No Product found</td>
                          </tr>
                      @endforelse

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
                                <input type="search" class="form-control tableSearch" placeholder="Search" data-table="table3">
                            </div>
                        </div>

                        <form method="GET" action="">

                            <input type="hidden" name="type" value="2">

                            <div class="search-filter">
                                <div class="from-group">
                                    <select class="form-select form-control width-50"
                                        aria-label="Default select example" name="cargory_filter"
                                        onchange="this.form.submit()">
                                        <option value="">Filter by Category</option>
                                        @foreach ($category as $item)
                                            <option value="{{ $item->id }}"
                                                @if (request()->type == 2 && request()->cargory_filter == $item->id) selected @endif>{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="from-group">
                                    <select class="form-select form-control width-50"
                                        aria-label="Default select example" name="brand_filter"
                                        onchange="this.form.submit()">
                                        <option value="">Filter by brand</option>
                                        @foreach ($brand as $item)
                                            <option value="{{ $item->id }}"
                                                @if (request()->type == 2 && request()->brand_filter == $item->id) selected @endif>
                                                {{ $item->name_english }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered  @if(count($data['inactive_product']) > 0 ) datatable  @endif" id="table3">
                            <thead>
                                <tr>
                                    <th class="no-sort">S.No</th>
                                    <th class="no-sort">Image</th>
                                    <th class="no-sort">Product code</th>
                                    <th class="no-sort">Product Name</th>
                                    <th class="no-sort">Brand</th>
                                    <th class="no-sort">Category</th>
                                    <th class="no-sort">Added on</th>
                                    <th class="no-sort">Availability</th>
                                    <th class="no-sort">Active/Inactive</th>
                                    <th class="no-sort">View more details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data['inactive_product'] as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            @foreach ($item->product_variants['0']->variant_image as $key1 => $img)
                                                @if ($key1 >= 1)
                                                    @php
                                                        break;
                                                    @endphp
                                                @endif
                                                <img src="{{ $img }}" class="img-fluid" alt="image">
                                            @endforeach

                                        </td>
                                        <td>

                                            {{-- {{ $item->product_variants['0']->sku }} --}}
                                            {{ $item->id }}

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
                                                        @if ($item->product_active_status == 1) checked @endif
                                                        rel="{{ $item->id }}">
                                                    <label class="form-check-label" for="switchCheckDefault"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('seller.view_product', $item->id) }}" class="eyebtn"><i
                                                    class="bi bi-eye"></i></a>
                                        </td>
                                    </tr>
                                {{-- @endforeach --}}

                                 @empty
                          <tr>
                              <td colspan="10" class="text-center text-muted">No product found</td>
                          </tr>
                      @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>



    </div>


    <script>
        $('body').on('click', '#switchCheckDefault', function() {
            //alert('Hello');
            var id = $(this).attr('rel');
            //alert(id)
            $.ajax({
                url: "{{ url('seller/product-status-active-inactive') }}",
                type: "get",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                dataType: "json",
                beforeSend: function() {
                    $('#loader').show()
                },
                success: function(data) {
                    console.log(data.data)
                    if (data.data.product_active_status == 1) {
                        toastr.success(data.message);

                    } else if (data.data.product_active_status === 0) {
                        toastr.error(data.message);

                    } else {
                        toastr.error("<?php echo 'Unexpected_response_from_server'; ?>");
                    }

                    setInterval(() => {
                        window.location.reload();
                    }, 1000);


                },
                error: function() {
                    alert("Fail")
                }
            })
        })
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // 1️⃣ Restore last active tab
            let activeTab = localStorage.getItem("active_product_tab");
            if (activeTab) {
                let tabEl = document.querySelector(`[data-bs-target="${activeTab}"]`);
                if (tabEl) {
                    new bootstrap.Tab(tabEl).show();
                }
            }

            // 2️⃣ Save clicked tab
            document.querySelectorAll('[data-bs-toggle="pill"]').forEach(tabBtn => {
                tabBtn.addEventListener("shown.bs.tab", function(e) {
                    localStorage.setItem("active_product_tab", e.target.getAttribute(
                        "data-bs-target"));
                });
            });

        });
    </script>



@include('dealer.layout.footer');

{{-- datatable show code --}}
@include('dealer.product.ajax.datatablejs'); 