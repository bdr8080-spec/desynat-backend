@extends('admin.layout.app')
@section('content')
@php $currency = $currency === 'KWD' ? 'KD' : $currency; @endphp
@php
    $admin = auth('admin')->user();

    $permissions = \App\Models\AdminPermission::where('admin_id', $admin->id)
        ->where('can_action', 1)
        ->pluck('module_id')
        ->toArray();
@endphp


<div id="content-wrapper" class="d-flex flex-column position-relative">
    <div id="content" class="">

        <div class="inner-content management">
            <div class="d-flex align-items-center gap-3 mt-2 justify-content-between">
                <div class="d-flex align-items-center gap-3 mt-2">
                    <div class="arrow">
                        <a href="{{route('admin.payouts')}}" class="table-button">
                            <i class="fas fa-angle-left"></i>
                        </a>
                    </div>
                    <h2 class="h2 text-start">View Seller Payouts - {{ $sellerName }}</h2>
                </div>

                @if(in_array(33, $permissions) || $admin->type == 1)
                <a class="btn btn-dark customBtn" data-bs-toggle="modal" data-bs-target="#addModal2"> <span>Add
                        Payout</span></a>
                @endif
            </div>

            <form method="GET" action="{{ route('admin.view-seller-payouts') }}" id="filterForm">
            <input type="hidden" name="seller_id" value="{{ $sellerDetails->id }}">
            <div class="row">
                <div class="col-lg-2 col-md-3 col-12">
                    <div class="form-group  w-100">
                        <label for="from_date" class="form-label">From</label>
                        <input type="date" id="from_date" name="from_date" class="form-control datepicker"
                            value="{{ request()->from_date }}"
                            onchange="updateToDate(); document.getElementById('filterForm').submit();" />
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-12">
                    <div class="form-group  w-100">
                        <label for="to_date" class="form-label">To</label>
                        <input type="date" id="to_date" name="to_date" class="form-control datepicker"
                            value="{{ request()->to_date }}"
                            onchange="document.getElementById('filterForm').submit();" />
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-12 d-flex align-items-end">
                    <a href="{{ route('admin.view-seller-payouts', ['seller_id' => $sellerDetails->id]) }}" class="btn btn-dark customBtn mt-3">
                        <span>{{ __('admin_messages.reset') }}</span>
                    </a>
                </div>

                <div class="col-lg-6 col-md-6 col-12 d-flex flex-column justify-content-end">
                    <h5 class="text-color" style="color:#ac875e;">Total Paid:- {{ $currency }} {{ $totalPaid }}</h5>
                    <h5 class="text-color" style="color:#ac875e;">Total Pending Payout:- {{ $currency }} {{ $pendingAmount }}</h5>
                </div>

            </div>
            </form>

            <div class="userManagecontent mt-4">
                <div class="table-responsive w-100">
                    <table id="myTable" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Date</th>
                                <th scope="col">Payout Amount</th>
                                <th scope="col">Transaction ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payouts as $index => $payout)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($payout->payout_date)->format('jS M Y') }}</td>
                                <td>{{ $currency }} {{ $payout->amount }}</td>
                                <td>{{ $payout->transaction_id ? '#' . $payout->transaction_id : __('admin_messages.na') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Add Payout Modal -->
<div class="modal fade" id="addModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Add Payout</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <form id="addPayoutForm">
                        <div class="row">
                            <!-- Amount -->
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="payoutAmount">Amount ({{ $currency }})</label>
                                    <input type="text" id="payoutAmount" class="form-control" placeholder="Enter Amount"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g,'').replace(/(\..*)\./g,'$1').replace(/(\.\d{3})\d+/,'$1')" />
                                    <small class="text-muted mt-2">Pending: {{ $currency }} {{ $pendingAmount }}</small>
                                </div>
                            </div>

                            <!--Transaction  -->
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="payoutTransactionId">Transaction ID </label>
                                    <input type="text" id="payoutTransactionId" class="form-control" placeholder="Enter Transaction ID" maxlength="255">
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                                <button type="button" id="submitPayoutBtn" class="btn btn-dark customBtn mt-3">Submit</button>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateToDate() {
        const fromDate = document.getElementById('from_date').value;
        const toDateInput = document.getElementById('to_date');
        if (fromDate) {
            toDateInput.setAttribute('min', fromDate);
            if (toDateInput.value && toDateInput.value < fromDate) {
                toDateInput.value = '';
            }
        } else {
            toDateInput.removeAttribute('min');
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        updateToDate();
    });
</script>

<!-- add seller payout -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const submitBtn = document.getElementById('submitPayoutBtn');
    if (!submitBtn) return;

    const pendingAmount = parseFloat("{{ $pendingAmount }}");

    submitBtn.addEventListener('click', function () {

        const amount = document.getElementById('payoutAmount').value.trim();
        const transactionId = document.getElementById('payoutTransactionId').value.trim();

        if (amount === '' || isNaN(amount) || parseFloat(amount) <= 0) {
            toastr.error("Please enter a valid amount.");
            return;
        }
        if (parseFloat(amount) > pendingAmount) {
            toastr.error("Payout amount exceeds the seller pending amount.");
            return;
        }
        if (transactionId === '') {
            toastr.error("Please enter transaction ID.");
            return;
        }

        submitBtn.disabled = true;

        fetch("{{ route('admin.add-seller-payout') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: JSON.stringify({
                seller_id: {{ $sellerDetails->id }},
                amount: amount,
                transaction_id: transactionId
            })
        })
        .then(res => res.json())
        .then(data => {

            if (data.status === 'success') {

                toastr.success(data.message);

                setTimeout(() => {
                    $('#addModal2').modal('hide');
                    location.reload();
                }, 1500);

            } else {
                submitBtn.disabled = false;
                toastr.error(data.message);
            }

        })
        .catch(() => {
            submitBtn.disabled = false;
            toastr.error("Something went wrong.");
        });

    });

});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
        toastr.success("{{ session('success') }}");
        @endif
        @if(session('error'))
        toastr.error("{{ session('error') }}");
        @endif
    });
</script>

@endsection
