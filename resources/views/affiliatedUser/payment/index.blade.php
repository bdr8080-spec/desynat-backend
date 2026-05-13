@include('affiliatedUser.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl">
        <div class="title24">{{ __('affiliate_messages.payments') }} </div>
    </div>

    <!-- <div class="search-field d-flex align-items-center py-4">
        <div class="from-group position-relative w-100">
            <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search" class="search-icon2">
            <input type="search" class="form-control py-3" placeholder="Search">
        </div>
        <button type="button" class="btn btn-success searchlin">Search</button>
    </div> -->
    <form action="{{ route('affiliate.payment') }}" method="GET">
        <div class="search-field d-flex align-items-center py-4">
            <div class="from-group position-relative w-100">
                <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" 
                    alt="search" class="search-icon2">

                <input type="search"
                    name="search"
                    class="form-control py-3"
                    placeholder="{{ __('affiliate_messages.search') }}"
                    value="{{ request('search') }}">
            </div>

            <button type="submit" class="btn btn-success searchlin">
                {{ __('affiliate_messages.search') }}
            </button>
        </div>
    </form>

    <div class="border-12 mb-3 mt-3 choose-date">
        <div class="d-flex justify-content-between date-header">
            <div class="total-balance">
                <div class="balance-title">{{ __('affiliate_messages.total_revenue') }}</div>
                <div class="walletic d-flex gap-2 align-items-center mt-3">
                    <div class="wallet-ic-2">
                        <img src="{{ asset('/dealer') }}/assets/img/wallet-ic.svg" class="img-fluid">
                    </div>
                    <h5>
                      {{ 
                            intval($allOrders['total_earning']) == $allOrders['total_earning'] 
                                ? intval($allOrders['total_earning']) 
                                : number_format($allOrders['total_earning'], 2) 
                        }} {{ __('affiliate_messages.kwd') }}
                    </h5>
                </div>
            </div>
            <div class="total-balance-2 d-flex gap-3 align-items-center">
                <!-- <a href="#" class="btn btn-export">Export</a> -->
                <a href="#" class="btn btn-export withdraw-bg"  data-bs-toggle="modal" data-bs-target="#Withdrawpop"> {{ __('affiliate_messages.withdraw') }}</a>
            </div>
        </div>
    </div>

    <div class="my-earn">
        @foreach($allOrders['orders'] as $index => $order)
                        @php
                            $orderdetail = $order;

                            // Order status text
                            $statusText = match (true) {

                            // 1 → Cancelled Order
                            $orderdetail->payment_status == '2' || $orderdetail->payment_status == '3'
                            => __('affiliate_messages.cancelled'),

                            // 2 → confirmed
                            $orderdetail->delivery_status == '1' &&
                            $orderdetail->return_type == '0'
                            => __('affiliate_messages.pending'),

                            // 2 → Ongoing
                            $orderdetail->delivery_status == '2' || $orderdetail->delivery_status == '1' &&
                            $orderdetail->return_type == '0'
                            => __('affiliate_messages.ongoing'),

                            // 2.1 → shipped
                            $orderdetail->delivery_status == '2.1' &&
                            $orderdetail->return_type == '0'
                            => __('affiliate_messages.shipped'),

                            // 2.2 → shipped
                            $orderdetail->delivery_status == '2.2' &&
                            $orderdetail->return_type == '0'
                            => __('affiliate_messages.on_the_way'),

                            // 3 → Delivered
                            $orderdetail->delivery_status == '3' &&
                            $orderdetail->return_type == '0'
                            =>  __('affiliate_messages.completed'),

                            // 4 → Cancelled
                            $orderdetail->payment_status == '2'
                            =>  __('affiliate_messages.cancelled'),

                            // 5 → Returned / Failed
                            $orderdetail->delivery_status == '3' && $orderdetail->return_type == '2'
                            => __('affiliate_messages.exchange_request'),

                            // 5 → Exchange / Failed
                            $orderdetail->delivery_status == '3' && $orderdetail->return_type == '1'
                            => __('affiliate_messages.return_request'),

                            // Default
                            default => __('affiliate_messages.ongoing'),
                            };

                            [$statusColor, $bgColor] = match ($statusText) {

                            __('affiliate_messages.completed') => ['#28a745', '#28a7451A'],

                            __('affiliate_messages.cancelled') => ['#E70000', '#E700001A'],

                            __('affiliate_messages.exchange_request')=>['#FF5F1B', 'rgba(255, 95, 27, 0.1)'],
                            __('affiliate_messages.return_request')=>['#FF5F1B', 'rgba(255, 95, 27, 0.1)'],

                            default => ['#FF5F1B', '#79d69d1a'],
                            };
                        @endphp
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <div class="">
                    <p class="text-muted mb-1">{{ __('affiliate_messages.my_earnings') }} </p>
                    <h6 class="fst-500">{{ 
                            intval($order['affiliate_commission']) == $order['affiliate_commission'] 
                                ? intval($order['affiliate_commission']) 
                                : number_format($order['affiliate_commission'], 2) 
                        }} {{ __('affiliate_messages.kwd') }}
                    </h6>
                </div>
                <div class="">
                    <p class="text-muted mb-1">{{ __('affiliate_messages.transaction_id') }} </p>
                    <h6 class="fst-500">#{{ $order['id'] }} </h6>
                </div>
            </div>

            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-1">{{ __('affiliate_messages.purchased_by') }} </p>
                    <p class="fst-500">{{ $order['user_details']['full_name'] ?? __('affiliate_messages.na')  }} </p>
                </div> 
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-1">{{ __('affiliate_messages.product_name') }}</p>
                    <p class="fst-500">
                        @if(app()->getLocale() == 'en')
                        {{ $order['product_details']['product_name_en'] }}
                        @else
                        {{ $order['product_details']['product_name_ar'] }}
                        @endif
                    </p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-1">{{ __('affiliate_messages.category') }}</p>
                    <p class="fst-500">
                        @if(app()->getLocale() == 'en')
                        {{ $order['product_details']['category']['name'] }}
                        @else
                        {{ $order['product_details']['category']['name_ar'] }}
                        @endif
                    </p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-1">{{ __('affiliate_messages.quantity') }}</p>
                    <p class="fst-500">{{ $order['quantity'] }}</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-1">{{ __('affiliate_messages.total_amount') }}</p>
                    <p class="fst-500">{{ $order['amount'] }} {{ __('affiliate_messages.kwd') }}</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-1">{{ __('affiliate_messages.purchased_on') }}</p>
                    <p class="fst-500">{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y \a\t h:i A') }}</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="text-muted mb-1">{{ __('affiliate_messages.order_status') }}</p>
                    <p style="color: {{ $statusColor }}; background-color: {{ $bgColor }};
                            padding:4px 10px; border-radius:6px; font-size:13px;">
                        {{ $statusText }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach


    </div>

</section>


<!-- Withdraw money Modal -->
<div class="modal fade" id="Withdrawpop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-75">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">{{ __('affiliate_messages.withdraw_money') }}</h1>
                <button type="button" id="withdraw_close_btn" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="search-field">
                    <div class="label-flex">
                        <label>{{ __('affiliate_messages.amount') }} </label>
                    </div>
                    <div class="from-group position-relative w-100">
                        <span class="kd-icon">{{ __('affiliate_messages.kwd') }} | </span>
                        <input type="text" class="form-control" name="amount" placeholder="{{ __('affiliate_messages.enter_amount') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '').replace(/^0+([1-9])/, '$1').replace(/^0+$/, '0').replace(/(\.\d{0,2}).*/g, '$1')">
                        <span id="error_amount" class="text-danger"></span>
                    </div>  
                </div>
                <div class="sub-form">
                    <div class="label-flex">
                        <label>{{ __('affiliate_messages.select_account') }}</label>
                    </div>
                    @foreach($affilatedUser->bank_details as $key=>$val)
                    <div class="rounded-4 desc-box bg-white mb-3">
                       <div class="bankpnl d-flex justify-content-between align-items-center line2">
                        
                           <div class="check_radio d-flex gap-2">
                               <label class="radio-group">
                                   <input type="radio" name="selected_account" {{ $loop->first ? 'checked' : '' }} value="{{ $val->id }}">
                                   <span class="custom-radio"></span>
                                   <span class="radio-label"></span>
                               </label>
                               <div class="account-no">{{$val->account_no}}</div>
                           </div>
                       </div>
                       
                   </div>
                   @endforeach
   
                   <div class="addanother d-flex gap-2" data-bs-toggle="modal" data-bs-target="#bankDetails">
                       <i class="bi bi-plus-lg"></i> <h5 class="mb-0">{{ __('affiliate_messages.add_another_account') }}</h5>
                   </div>
   
                </div>
                
                <div class="text-center mt-5">
                    <button type="submit" id="submit_withdraw_btn" class="btn btn-success w-100 lh-2">{{ __('affiliate_messages.submit_request') }}</button>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Add bank details -->
<div class="modal fade" id="bankDetails" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered w-75">
    <div class="modal-content">

      <div class="modal-header">
        <h1 class="modal-title fs-5">{{ __('affiliate_messages.add_account') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="account-form">

          <div class="sub-form mb-2">
            <label>{{ __('affiliate_messages.bank_name') }}</label>
            <input type="text" id="bank_name" class="form-control" placeholder="{{ __('affiliate_messages.enter_bank_name') }}">
            <small class="text-danger" id="error_bank_name"></small>
          </div>

          <div class="sub-form mb-2">
            <label>{{ __('affiliate_messages.account_holder_name') }}</label>
            <input type="text" id="account_holder_name" class="form-control" placeholder="{{ __('affiliate_messages.enter_account_holder_name') }}">
            <small class="text-danger" id="error_account_holder_name"></small>
          </div>

          <div class="sub-form mb-2">
            <label>{{ __('affiliate_messages.account_number') }}</label>
            <input type="text" id="account_no" placeholder="{{ __('affiliate_messages.enter_account_number') }}" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            <small class="text-danger" id="error_account_no"></small>
          </div>

          <div class="sub-form mb-2">
            <label>{{ __('affiliate_messages.confirm_account_number') }}</label>
            <input type="text" id="confirm_account_no" placeholder="{{ __('affiliate_messages.re_enter_account_number') }}" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            <small class="text-danger" id="error_confirm_account_no"></small>
          </div>

          <div class="sub-form mb-2">
            <label>{{ __('affiliate_messages.iban') }}</label>
            <input type="text" id="iban" class="form-control" placeholder="{{ __('affiliate_messages.enter_iban') }}">
            <small class="text-danger" id="error_iban"></small>
          </div>

          <div class="sub-form mb-2">
            <label>{{ __('affiliate_messages.swift_bic') }}</label>
            <input type="text" id="swift" class="form-control" placeholder="{{ __('affiliate_messages.enter_swift_bic') }}">
            <small class="text-danger" id="error_swift"></small>
          </div>

        </div>

        <div class="text-center mt-4">
          <button type="button" id="submit_bank_btn" class="btn btn-success w-100">
            {{ __('affiliate_messages.submit') }} 
          </button>
        </div>

      </div>
    </div>
  </div>
</div>



<script src="{{ asset('/dealer') }}/assets/custom-file/js/jquery.min.js"></script>

<!-- add bank account -->
<script>
$(document).ready(function() {

    function clearErrors() {
        $('[id^="error_"]').text('');
    }

    function showError(fieldId, message) {
        $('#error_' + fieldId).text(message);
    }

    $(document).on('input', '#bankDetails input', function () {
        let fieldId = $(this).attr('id');
        $('#error_' + fieldId).text('');
    });

    $('#submit_bank_btn').on('click', function() {

        clearErrors();

        let bankName = $('#bank_name').val().trim();
        let accountHolder = $('#account_holder_name').val().trim();
        let accountNo = $('#account_no').val().trim();
        let confirmAccountNo = $('#confirm_account_no').val().trim();
        let iban = $('#iban').val().trim();
        let swift = $('#swift').val().trim();

        let isValid = true;

        if(bankName === '') {
            showError('bank_name', "{{ __('affiliate_messages.please_enter_bank_name') }}");
            isValid = false;
        }

        if(accountHolder === '') {
            showError('account_holder_name', "{{ __('affiliate_messages.please_enter_account_holder_name') }}");
            isValid = false;
        }

        if(accountNo === '') {
            showError('account_no', "{{ __('affiliate_messages.please_enter_account_number') }}");
            isValid = false;
        }

        if(confirmAccountNo === '') {
            showError('confirm_account_no', "{{ __('affiliate_messages.please_confirm_account_number') }}");
            isValid = false;
        }

        if(accountNo !== '' && confirmAccountNo !== '' && accountNo !== confirmAccountNo) {
            showError('confirm_account_no', "{{ __('affiliate_messages.account_numbers_do_not_match') }}");
            isValid = false;
        }

        if(iban === '') {
            showError('iban', "{{ __('affiliate_messages.please_enter_iban') }}");
            isValid = false;
        }

        if(swift === '') {
            showError('swift', "{{ __('affiliate_messages.please_enter_swift_bic') }}");
            isValid = false;
        }

        if(!isValid) return;

        $.ajax({
            url: "{{ route('affiliate.addAnotherBankDetails') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                bank_name: bankName,
                account_holder_name: accountHolder,
                account_no: accountNo,
                confirm_account_no: confirmAccountNo,
                iban: iban,
                swift: swift,
            },
            beforeSend: function() {
                $('#submit_bank_btn').prop('disabled', true).text('Processing...');
            },
            success: function(response) {
                if(response.status === 'success') {
                    toastr.success(response.message);
                    $('#bankDetails').modal('hide');
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                if(xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        toastr.error(value[0]);
                    });
                } else {
                    toastr.error("Something went wrong");
                }
            },
            complete: function() {
                $('#submit_bank_btn').prop('disabled', false).text('Submit Request');
            }
        });

    });

});
</script>

 <!-- Submit withdraw request -->
<script>
$(document).ready(function() {

    function clearErrors() {
        $('#error_amount').text('');
    }

    function showError(fieldId, message) {
        $('#error_' + fieldId).text(message);
    }

    $(document).on('input', 'input[name="amount"]', function () {
        $('#error_amount').text('');
    });

    $(document).on('click', '.desc-box', function() {
        $('.desc-box').removeClass('selected');
        $(this).addClass('selected');
        $(this).find('input[name="selected_account"]').prop('checked', true);
    });


    $(document).on('click', '#submit_withdraw_btn', function(e) {
        e.preventDefault();
        clearErrors();

        let amount = $('input[name="amount"]').val().trim();
        let bankdetails_id = $('input[name="selected_account"]:checked').val();

        let isValid = true;

        if(amount === '') {
            showError('amount', "{{ __('affiliate_messages.please_enter_amount') }}");
            isValid = false;
        }

        if(!bankdetails_id) {
            toastr.error("{{ __('affiliate_messages.please_select_account') }}");
            isValid = false;
        }

        if(!isValid) return;

        $.ajax({
            url: "{{ route('affiliate.affiliate_submit_withdraw_request') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                amount: amount,
                bankdetails_id: bankdetails_id
            },
            beforeSend: function() {
                $('#submit_withdraw_btn').prop('disabled', true).text('Processing...');
            },
            success: function(response) {
                if(response.status === 'success') {
                    toastr.success(response.message);
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else if(response.status === 'error') {
                    toastr.error(response.message);
                } else {
                    toastr.error("Something went wrong");
                }
            },
            error: function(xhr) {
                if (xhr.responseJSON) {
                    // Show validation errors first
                    if (xhr.responseJSON.errors) {
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            if(key === 'amount') {
                                showError('amount', value[0]);
                            } else {
                                toastr.error(value[0]);
                            }
                        });
                    } 
                    // Show general error message if present
                    else if (xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                    } else {
                        toastr.error("Something went wrong");
                    }
                } else {
                    toastr.error("Something went wrong");
                }
            },
            complete: function() {
                $('#submit_withdraw_btn').prop('disabled', false).text('Submit Request');
            }
        });

    });

});
</script>

<script>
$(document).ready(function() {
    $(document).on('click', '#withdraw_close_btn', function() {
        location.reload();
    });
});
</script>




@include('affiliatedUser.layout.footer')