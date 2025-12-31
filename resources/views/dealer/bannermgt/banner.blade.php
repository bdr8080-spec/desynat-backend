@include('dealer.layout.header')

<style>
td img {
    width: 65px;
    height: 65px !important;
    border-radius: 50%;
    object-fit: fill;
    "

}

td {
    max-width: 200px;
    text: truncate;
}

table#table1 {
    text-align: center;
}
</style>

<section class="section dashboard">


    @if (session('status') == 'success')
    <div class="alert alert-success">
        <script>
        $('#payModalSuccess').modal('show');
        </script>
        <!-- {{ session('message') }} -->
    </div>
    @elseif (session('status') == 'error')
    <div class="alert alert-danger">
        {{ session('message') }}
    </div>
    @endif

    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24">Banner Management</div>
        <a href="{{route('seller.add_banner')}}" class="btn btn-success">Add New Banner</a>

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
                            <option value="1" @if(request()->banner_filter==1 ) selected @endif > Active </option>
                            <option value="2" @if(request()->banner_filter==2 ) selected @endif > confirmed </option>
                            <option value="3" @if(request()->banner_filter==3 ) selected @endif > Pending </option>
                            <option value="4" @if(request()->banner_filter==4 ) selected @endif > Expired </option>
                            <option value="5" @if(request()->banner_filter==5 ) selected @endif > Rejected </option>
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
                        <th class="no-sort"> Banner Image</th>
                        <th class="no-sort">Request Id</th>
                        <th class="no-sort">Requested On</th>
                        <th class="no-sort">Total Amount</th>
                        <th class="no-sort">status</th>
                        <th class="no-sort">
                            View more details
                        </th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($banners as $key=>$val)

                    <tr>
                        <td>{{$key+1}}</td>
                        <td>

                            <img src="{{$val->upload_banner}}" class="img-fluid" alt="image" class="pro-image"
                                style="width: 105px;height: 65px;border-radius: 5%;object-fit: cover;">
                        </td>
                        <td> {{$val->order_id}}</td>
                        <td>{{$val->created_at->format('d/m/Y \a\t h:i A') }}</td>
                        <td> {{$val->price}} KD </td>
                        <td>
                            @if ($val->Admin_verify == '0')
                            Pending

                            @elseif (
                            $val->Admin_verify == '1' &&
                            $val->payment_status == '1' &&
                            $val->start_date <= now() && $val->end_date >= now()
                                )
                                Active

                                @elseif (
                                $val->Admin_verify == '1' &&
                                $val->payment_status == '1' &&
                                $val->end_date < now() ) Expired @elseif ($val->Admin_verify == '1' &&
                                    $val->payment_status == '1')
                                    Confirmed

                                    @elseif ($val->Admin_verify == '1' && $val->payment_status == '3' )
                                    Rejected

                                    @elseif ($val->Admin_verify == '1' && $val->payment_status == '0' )
                                    Confirmed

                                    @else
                                    Rejected
                                    @endif
                        </td>
                        <td>
                            <a href="{{route('seller.show_single_banner',$val->id)}}" class="eyebtn"><i
                                    class="bi bi-eye"></i></a>
                        </td>
                    </tr>

                    @endforeach




                </tbody>
            </table>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="payModalSuccess" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="p-4 text-center">
                        <img alt="image" src="{{ asset('/dealer') }}/assets/img/success.svg">
                        <h5 class="mt-3">Banner Purchased Successfully</h5>
                    </div>
                </div>

            </div>
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