@include('dealer.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24">Refund Management</div>
        <a href="#" class="btn btn-success">Export</a>
    </div>

    <div class="datatable-wapper mt-5">
        <div class="table-header mb-2">
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
                        <select class="form-select form-control width-50" aria-label="Default select example">
                            <option value="">Payment Mode</option>
                            <option value="1"> Complete </option>
                            <option value="2"> Pending </option>
                        </select>
                    </div>
                    <div class="from-group">
                        <div class="total-refund d-flex gap-3">
                            <h6>Total Refund</h6>
                            <h3>102829.00 KD</h3>
                        </div>
                    </div>


                </div>

            </form>
        </div>


        <div class="table-responsive">
            <table class="table table-bordered datatable tablesearch" id="table1">
                <thead>
                    <tr>
                        <th class="no-sort">S.No</th>
                        <th class="no-sort">Refund ID</th>
                        <th class="no-sort">Transaction ID</th>
                        <th class="no-sort">Order Date & Time</th>
                        <th class="no-sort">Customer name</th>
                        <th class="no-sort">Order ID</th>
                        <th class="no-sort">Total Amount</th>
                        <th class="no-sort">Total Commission</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>1</td>
                        <td>#9898y98</td>
                        <td>#r5r57655 </td>
                        <td>21/08/25 at 07:30PM</td>
                        <td>Ajay kumar</td>
                        <td>#76777</td>
                        <td>20 KD</td>
                        <td>20 KD</td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

</section>


@include('dealer.layout.custom_code');
@include('dealer.layout.footer');



