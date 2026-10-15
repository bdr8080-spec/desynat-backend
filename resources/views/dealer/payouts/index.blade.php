@include('dealer.layout.header')

<style>
    .paymentTitle p {
        font-size: 15px;
        line-height: 28px;
    }
    .btn-export{
    background: var(--all-btn-bg);
    border-radius: 4px;
    color:#fff;
    width: 130px;
    font-size:16px;
    }
    .form-select{
        width: 210px;
    }
</style>

@php
    $currency = $transactionsData['currency_code'] ?? $payoutsData['currency_code'] ?? 'KD';
    $currency = $currency === 'KWD' ? 'KD' : $currency;
    $transactions = $transactionsData['transactions'] ?? collect();
    $payouts = $payoutsData['payouts'] ?? collect();
@endphp

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24"> Payments </div>
    </div>
    <div class="tabs-panel py-4">
        <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">

            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $activeTab === 'transactions' ? 'active' : '' }} w-100" id="pills-transactions-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-transactions" type="button" role="tab" aria-controls="pills-transactions"
                    aria-selected="{{ $activeTab === 'transactions' ? 'true' : 'false' }}">

                    All Transactions
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $activeTab === 'payouts' ? 'active' : '' }} w-100" id="pills-payouts-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-payouts" type="button" role="tab" aria-controls="pills-payouts"
                    aria-selected="{{ $activeTab === 'payouts' ? 'true' : 'false' }}">

                    My Payouts
                </button>
            </li>
        </ul>
    </div>

    <div class="tab-body-wapper">
        <div class="tab-content" id="pills-tabContent">

            {{-- All transactions --}}
            <div class="tab-pane fade {{ $activeTab === 'transactions' ? 'show active' : '' }}" id="pills-transactions" role="tabpanel"
                aria-labelledby="pills-transactions-tab" tabindex="0">

                <div class="datatable-wapper paymentTitle">
                    <form method="GET" action="{{ route('seller.payments') }}" id="transactionFilterForm">
                    <input type="hidden" name="tab" value="transactions">
                    <div class="d-flex gap-4 align-items-center mb-3 justify-content-between">
                            <div class="from-group">
                                <div class="total-refund d-flex gap-3">
                                    <h6>Total Revenue</h6>
                                    <h3>{{ $transactionsData['total_revenue'] ?? '0.000' }} {{ $currency }}</h3>
                                </div>
                            </div>
                            <a href="{{ route('seller.export_payments_data', array_merge(request()->except('page', 'payout_page'), ['tab' => 'transactions'])) }}" class="btn btn-export">Export</a>
                    </div>

                    <div class="d-flex justify-content-between mb-4 align-items-center flex-wrap gap-3">
                        <div class="d-flex gap-2 align-items-center flex-wrap">
                            <div class="search-field">
                                <div class="from-group position-relative">
                                    <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search" class="search-icon">
                                    <input type="search" name="search" class="dt-input tableSearch form-control" id="transactionSearch"
                                        value="{{ request()->search }}" placeholder="{{__('seller_messages.search')}}">
                                </div>
                            </div>
                            <div class="date-form-pnl">
                                <input type="date" class="form-control datepicker" name="from_date" id="fromDate"
                                    value="{{ request()->from_date }}">
                            </div>
                            <div class="date-form-pnl">
                                <input type="date" class="form-control datepicker" name="to_date" id="toDate"
                                    value="{{ request()->to_date }}">
                            </div>
                            <select name="transaction_type" class="form-select form-control" onchange="this.form.submit()">
                                <option value="0" {{ request('transaction_type', '0') == '0' ? 'selected' : '' }}>All</option>
                                <option value="1" {{ request('transaction_type') == '1' ? 'selected' : '' }}>Credit</option>
                                <option value="2" {{ request('transaction_type') == '2' ? 'selected' : '' }}>Debit</option>
                            </select>
                            <a href="{{ route('seller.payments') }}" class="btn btn-export">Reset</a>
                        </div>

                       
                    </div>
                     
                        
                    </form>

                    <div class="row">
                        @forelse($transactions as $transaction)
                        <div class="col-lg-4">
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="ticket">
                                        <p class="text-muted mb-0">{{ $transaction->transaction_type == 1 ? 'Order ID' : 'Transaction ID' }}</p>
                                        <p class="fst-500 mb-0">
                                            #{{ $transaction->transaction_type == 1 ? $transaction->reference_id : ($transaction->transaction_id ?? $transaction->reference_id) }}
                                        </p>
                                    </div>
                                    <div class="ticket">
                                        <p class="text-muted mb-0"> Date & Time </p>
                                        <p class="fst-500 mb-0">{{ $transaction->transaction_date ? \Carbon\Carbon::parse($transaction->transaction_date)->format('d/m/Y \a\t h:i A') : '-' }}</p>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0">Type</p>
                                        <p class="fst-500 mb-0 {{ $transaction->transaction_type == 1 ? 'text-success' : 'text-danger' }}">
                                            {{ $transaction->transaction_type == 1 ? 'Credit' : 'Debit (Payout)' }}
                                        </p>
                                    </div>

                                    @if($transaction->transaction_type == 1)
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0"> Customer Name</p>
                                        <p class="fst-500 mb-0">{{ $transaction->customer_name ?? '-' }}</p>
                                    </div>
                                    @endif

                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0">Total Amount</p>
                                        <p class="fst-500 mb-0">{{ $transaction->amount }} {{ $currency }}</p>
                                    </div>

                                    @if($transaction->transaction_type == 1)
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0">Total Commission</p>
                                        <p class="fst-500 mb-0">{{ $transaction->commission ?? '0.000' }} {{ $currency }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <p class="text-center text-muted py-5">No transactions found</p>
                        </div>
                        @endforelse
                    </div>

                    @if($transactions instanceof \Illuminate\Pagination\LengthAwarePaginator && $transactions->hasPages())
                    <div class="d-flex justify-content-center">
                        {{ $transactions->appends(array_merge(request()->except('page'), ['tab' => 'transactions']))->links('pagination::bootstrap-5') }}
                    </div>
                    @endif

                </div>
            </div>


            {{-- Payouts --}}
            <div class="tab-pane fade {{ $activeTab === 'payouts' ? 'show active' : '' }}" id="pills-payouts" role="tabpanel" aria-labelledby="pills-payouts-tab"
                tabindex="0">

                 <div class="datatable-wapper paymentTitle">

                    <form method="GET" action="{{ route('seller.payments') }}" id="payoutFilterForm">
                    <input type="hidden" name="tab" value="payouts">

                    <div class="d-flex gap-4 align-items-center mb-3">
                            <div class="from-group">
                                <div class="total-refund d-flex gap-3">
                                   <h6>Total Payout Received</h6>
                                    <h3>{{ $payoutsData['total_paid'] ?? '0.000' }} {{ $currency }}</h3>
                                </div>
                            </div>
                            <div class="from-group">
                                <div class="total-refund d-flex gap-3">
                                   <h6>Pending Payout</h6>
                                    <h3>{{ $payoutsData['pending_amount'] ?? '0.000' }} {{ $currency }}</h3>
                                </div>
                            </div>
                            <a href="{{ route('seller.export_payments_data', array_merge(request()->except('page', 'payout_page'), ['tab' => 'payouts'])) }}" class="btn btn-export">Export</a>
                        </div>

                    <div class="d-flex justify-content-between mb-4 align-items-center flex-wrap gap-3">
                        <div class="d-flex gap-2 align-items-center flex-wrap">
                            <div class="search-field">
                                <div class="from-group position-relative">
                                    <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search" class="search-icon">
                                    <input type="search" name="payout_search" class="dt-input tableSearch form-control" id="payoutSearch"
                                        value="{{ request()->payout_search }}" placeholder="{{__('seller_messages.search')}}">
                                </div>
                            </div>
                            <div class="date-form-pnl">
                                <input type="date" class="form-control datepicker" name="payout_from_date" id="payoutFromDate"
                                    value="{{ request()->payout_from_date }}">
                            </div>
                            <div class="date-form-pnl">
                                <input type="date" class="form-control datepicker" name="payout_to_date" id="payoutToDate"
                                    value="{{ request()->payout_to_date }}">
                            </div>
                            <a href="{{ route('seller.payments', ['tab' => 'payouts']) }}" class="btn btn-export">Reset</a>
                        </div>
                        
                    </div>
                    </form>


                    <div class="row">
                        @forelse($payouts as $payout)
                        <div class="col-lg-4">
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="ticket">
                                        <p class="text-muted mb-0"> From</p>
                                        <p class="fst-500 mb-0">{{ $payout->from_date ? \Carbon\Carbon::parse($payout->from_date)->format('d/m/Y') : '-' }}</p>
                                    </div>
                                    <div class="ticket">
                                        <p class="text-muted mb-0"> To</p>
                                        <p class="fst-500 mb-0">{{ $payout->to_date ? \Carbon\Carbon::parse($payout->to_date)->format('d/m/Y') : '-' }}</p>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0"> Transaction ID</p>
                                        <p class="fst-500 mb-0">{{ $payout->transaction_id ? '#' . $payout->transaction_id : 'N/A' }}</p>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0">Payout received at</p>
                                        <p class="fst-500 mb-0">{{ $payout->payment_receive_date ? \Carbon\Carbon::parse($payout->payment_receive_date)->format('d/m/Y \a\t h:i A') : '-' }}</p>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0">Total Amount received </p>
                                        <p class="fst-500 mb-0">{{ $payout->amount }} {{ $currency }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <p class="text-center text-muted py-5">No payouts found</p>
                        </div>
                        @endforelse
                    </div>

                    @if($payouts instanceof \Illuminate\Pagination\LengthAwarePaginator && $payouts->hasPages())
                    <div class="d-flex justify-content-center">
                        {{ $payouts->appends(array_merge(request()->except('payout_page'), ['tab' => 'payouts']))->links('pagination::bootstrap-5') }}
                    </div>
                    @endif

                </div>

            </div>

        </div>
    </div>

</section>



@include('dealer.layout.custom_code');
@include('dealer.layout.footer');

<script>
document.addEventListener('DOMContentLoaded', function() {

    // Submit the search after the user stops typing, or when the field is cleared
    [['transactionSearch', 'transactionFilterForm'], ['payoutSearch', 'payoutFilterForm']].forEach(function([inputId, formId]) {
        const input = document.getElementById(inputId);
        let timer = null;
        input.addEventListener('keyup', function(e) {
            clearTimeout(timer);
            if (e.key === 'Enter') return;
            timer = setTimeout(() => document.getElementById(formId).submit(), 800);
        });
        input.addEventListener('search', function() {
            if (this.value === '') document.getElementById(formId).submit();
        });
    });

    // Date range: "to" can't be before "from"; submit once the range is valid
    [['fromDate', 'toDate'], ['payoutFromDate', 'payoutToDate']].forEach(function([fromId, toId]) {
        const fromDate = document.getElementById(fromId);
        const toDate = document.getElementById(toId);
        const form = fromDate.form;

        if (fromDate.value) toDate.min = fromDate.value;

        fromDate.addEventListener('change', function() {
            toDate.min = this.value;
            if (toDate.value && toDate.value < this.value) {
                toDate.value = '';
            }
            form.submit();
        });

        toDate.addEventListener('change', function() {
            if (fromDate.value && this.value < fromDate.value) {
                this.value = '';
                return;
            }
            form.submit();
        });
    });

    @if(session('error'))
    toastr.error("{{ session('error') }}");
    @endif
});
</script>
