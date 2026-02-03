@include('dealer.layout.header')


<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24">Live Coverage Requests</div>
        <a href="#" class="btn btn-success">Export</a>

    </div>
    <div class="datatable-wapper mt-4">
        <div class="table-header">
            <div class="search-field">
                <div class="from-group position-relative">
                    <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search" class="search-icon">
                    <input type="search" class="dt-input tableSearch form-control" id="customTableSearch"
                        placeholder="Search" aria-controls="table1">
                </div>
            </div>

            <form method="GET" action="">

                <div class="search-filter">
                    <div class="from-group">
                        <div class="show-date d-flex gap-2  flex-wrap">
                            <div class="date-form-pnl">
                                <input type="date" class="form-control" name="from" id="fromDate"
                                    value="{{request()->from }}">
                                <p class="text-danger" id="error-start_date"></p>
                            </div>
                            <div class="date-form-pnl">
                                <input type="date" class="form-control" name="to" id="toDate"
                                    value="{{request()->to }}">

                                <p class="text-danger" id="error-end_date"></p>
                            </div>
                        </div>
                    </div>


                    <div class="from-group">
                        <select class="form-select form-control width-50" aria-label="Default select example"
                            name="banner_filter" onchange="this.form.submit()">
                            <option value="">Filter by status</option>
                            
                        </select>
                    </div>


                </div>

            </form>
        </div>


        <div class="table-responsive">
            <table class="table table-bordered datatable tablesearch" id="table1">
                <thead>
                    <tr>
                        <th class="no-sort">S.No</th>
                        <th class="no-sort">Request ID</th>
                        <th class="no-sort">Requested On </th>
                        <th class="no-sort">Live Request </th>
                        <th class="no-sort">Status</th>
                        <th class="no-sort">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                    </tr>

                


                </tbody>
            </table>
        </div>
    </div>


   





</section>


@include('dealer.layout.custom_code');
@include('dealer.layout.footer');

<script>


</script>