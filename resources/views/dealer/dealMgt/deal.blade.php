@include('dealer.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24">Deal Management</div>

    </div>

    <div class="tabs-panel py-4">
        <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active w-100" id="pills-allproduct-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-allproduct" type="button" role="tab" aria-controls="pills-allproduct"
                    aria-selected="true">Listed Deals</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link w-100" id="pills-active-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-active" type="button" role="tab" aria-controls="pills-active"
                    aria-selected="false">Enrolled</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link w-100" id="pills-inactive-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-inactive" type="button" role="tab" aria-controls="pills-inactive"
                    aria-selected="false">Expired</button>
            </li>

        </ul>
    </div>


    <div class="tab-body-wapper">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-allproduct" role="tabpanel"
                aria-labelledby="pills-allproduct-tab" tabindex="0">
                <div class="datatable-wapper">
                    <div class="table-header mb-1">
                        <div class="search-field">
                            <div class="from-group position-relative">
                                <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search"
                                    class="search-icon">
                                <input type="search" class="form-control tableSearch" placeholder="Search"
                                    data-table="table1">

                            </div>
                        </div>
                        </form>
                    </div>

                    {{-- All Product show --}}
                    <div class="table-responsive">
                        <table class="table table-bordered datatable tablesearch" id="table1">
                            <thead>
                                <tr>
                                    <th class="no-sort">S.No</th>
                                    <th class="no-sort">Banner Image</th>
                                    <th class="no-sort">Date</th>
                                    <th class="no-sort">Duration</th>
                                    <th class="no-sort">Discount</th>
                                    <th class="no-sort">Add Products</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>01</td>
                                    <td>
                                        <div class="deal-img"></div>
                                    </td>
                                    <td>2nd July 2025</td>
                                    <td>02/02/2025 - 12/02/2025</td>
                                    <td>40 % </td>
                                    <td>
                                        <a href="#" class="addPlus-btn btn-success"><i class="bi bi-plus-lg"></i></a>
                                    </td>
                                </tr>

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
                                <input type="search" class="form-control tableSearch" placeholder="Search"
                                    data-table="table2">
                            </div>
                        </div>

                    </div>

                    {{-- // Active product List  --}}
                    <div class="table-responsive">

                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="pills-inactive" role="tabpanel" aria-labelledby="pills-inactive-tab"
                tabindex="0">
                <div class="datatable-wapper">
                    <div class="table-header">
                        <div class="search-field">
                            <div class="from-group position-relative">
                                <input type="search" class="form-control tableSearch" placeholder="Search"
                                    data-table="table3">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">

                    </div>
                </div>
            </div>



        </div>
    </div>


    </div>

    <script>

    </script>




    @include('dealer.layout.footer');
    @include('dealer.product.ajax.datatablejs');