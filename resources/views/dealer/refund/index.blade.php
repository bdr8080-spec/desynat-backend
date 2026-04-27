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
                                <input type="date" class="form-control" name="from_date" id="fromDate"
                                    value="{{request()->from_date }}">
                                <p class="text-danger" id="error-start_date"></p>
                            </div>
                            <div class="date-form-pnl">
                                <input type="date" class="form-control" name="to_date" id="toDate"
                                    value="{{request()->to_date }}">

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
                            <h3>{{$refundData['total_refunds']}} KD</h3>
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
                        <!-- <th class="no-sort">Total Commission</th> -->
                         <th class="no-sort">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($refundData['orders'] as $index => $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->order->order_id }}</td>
                        <td>{{ $data->order->transaction_id ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($data->updated_at)->format('d/m/y \a\t h:iA') }}</td>
                        <td>{{ $data->user_details->full_name ?? '' }}</td>
                        <td>{{ $data->id }}</td>
                        <td>{{ $data->amount }} KD</td>
                        <!-- <td>20 KD</td> -->
                         <td>Pending</td>
                    </tr>
                    @empty

                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

</section>


@include('dealer.layout.custom_code');
@include('dealer.layout.footer');

<script>
$(document).ready(function() {
    $('#customTableSearch').on('keyup search', function() {
        let value = $(this).val().toLowerCase().trim();

        $('.tablesearch tbody tr').each(function() {
            let rowText = $(this).text().toLowerCase();

            if (value === "") {
                // input empty → show all rows
                $(this).show();
            } else {
                // match text
                $(this).toggle(rowText.indexOf(value) > -1);
            }
        });
    });
});



document.addEventListener('DOMContentLoaded', function() {

    const fromDate = document.getElementById('fromDate');
    const toDate = document.getElementById('toDate');
    const form = fromDate.form;

    const today = new Date().toISOString().split('T')[0];

    fromDate.min = today;
    toDate.min = today;

    function canSubmit() {
        return (
            fromDate.value &&
            toDate.value &&
            fromDate.value >= today &&
            toDate.value >= fromDate.value
        );
    }

    // From date change
    fromDate.addEventListener('change', function() {
        if (this.value < today) {
            this.value = '';
            // document.getElementById('error-start_date').innerText =
            // 'Start date cannot be earlier than today';
            return;
        }

        document.getElementById('error-start_date').innerText = '';
        toDate.min = this.value;

        if (toDate.value && toDate.value < this.value) {
            toDate.value = '';
        }

        if (canSubmit()) {
            form.submit();
        }
    });

    // To date change
    toDate.addEventListener('change', function() {
        if (fromDate.value && this.value < fromDate.value) {
            this.value = '';
            // document.getElementById('error-end_date').innerText =
            // 'End date cannot be earlier than start date';
            return;
        }

        document.getElementById('error-end_date').innerText = '';

        if (canSubmit()) {
            form.submit();
        }
    });

});
</script>



