@include('dealer.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24"> {{ __('seller_messages.Subscription_Plans') }}</div>
    </div>

    <div class="tabs-panel py-4">
        <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active w-100" id="pills-listed-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-listed" type="button" role="tab" aria-controls="pills-listed"
                    aria-selected="true">   {{ __('seller_messages.Listed_Plans') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link w-100" id="pills-plan-tab" data-bs-toggle="pill" data-bs-target="#pills-plan"
                    type="button" role="tab" aria-controls="pills-plan" aria-selected="false">  {{ __('seller_messages.My_Plan') }}</button>
            </li>
        </ul>
    </div>


    <div class="tab-body-wapper">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-listed" role="tabpanel" aria-labelledby="pills-listed-tab"
                tabindex="0">
                <div class="plan-wapper-2">
                    <div class="row">
                        @forelse($allPlans as $plan)

                            @php
                                // Assign different colors based on plan name or loop index
                                $colors = ['bg-dark', 'bg-yellow-2', 'bg-success', 'bg-primary', 'bg-danger'];
                                $headerClass = $colors[$loop->index % count($colors)];
                            @endphp

                            <div class="col-lg-4 col-md-4">
                                <div class="plan-card plan-shadow">
                                    <div class="plan-header {{ $headerClass }} text-center">
                                       {{ app()->getLocale() == 'ar'
                                            ? $plan->plan_name_arabic
                                            : $plan->plan_name_english }}
                                    </div>
                                    @php
                                    if ($plan->duration_type == '1') {
                                        $amount = $plan->price;
                                    } else {
                                        if (!empty($plan->no_of_free_months) && $plan->no_of_free_months > 0) {
                                            $paidMonths = 12 - $plan->no_of_free_months;
                                            $amount = $paidMonths * $plan->price;
                                        } else {
                                            $amount = 12 * $plan->price;
                                        }
                                    }

                                    $amount = round($amount, 2);
                                @endphp

                                <div class="plan-content text-center plan-shadow">
                                    <h4> {{ __('seller_messages.KD') }} {{ number_format($amount, 2) }}</h4>
                                    <div>
                                         {{ __('seller_messages.For') }}
                                          {{ $plan->duration }}

                                         {{ $plan->duration_type == 1
                                                ? __('seller_messages.Month')
                                                : __('seller_messages.Year') }}


                                    </div>
                                </div>
                                    <div class="plan-body p-3">
                                        <ul class="list-inline">
                                            <li>
                                                <img src="{{ asset('dealer/assets/img/check-icon.svg') }}">
                                                  {{ __('seller_messages.Number_of_Products') }}:
                                                <span>{{ $plan->no_of_products }}</span>
                                            </li>

                                            <li>
                                                <img src="{{ asset('dealer/assets/img/check-icon.svg') }}">
                                               {{ __('seller_messages.Number_of_Videos') }}:
                                                <span>{{ $plan->no_of_videos }}</span>
                                            </li>

                                            <li>
                                                <img src="{{ asset('dealer/assets/img/check-icon.svg') }}">
                                                {{ __('seller_messages.Number_of_Highlights') }}:
                                                <span>{{ $plan->no_of_highlights }}</span>
                                            </li>

                                            <li>
                                                <img src="{{ asset('dealer/assets/img/check-icon.svg') }}">
                                                {{ __('seller_messages.Stories') }}:
                                                <span>{{ $plan->stories == 1 ? 'Yes' : 'No' }}</span>
                                            </li>

                                            <li>
                                                <img src="{{ asset('dealer/assets/img/check-icon.svg') }}">
                                                
                                                {{ $plan->no_of_employee }} 
                                                {{ __('seller_messages.Store_Employees') }}
                                            </li>

                                            <li>
                                                <img src="{{ asset('dealer/assets/img/check-icon.svg') }}">
                                                 {{ __('seller_messages.Commission') }}:
                                                <span>
                                                    {{ $plan->commission == 1 ? $plan->commission_percentage . '%' : '0%' }}
                                                </span>
                                            </li>
                                            @if (!empty($plan->no_of_free_months))
                                                <li><img src="{{ asset('dealer') }}/assets/img/check-icon.svg">{{ __('seller_messages.No_Of_Free_Months') }}:
                                                    <span>{{ $plan->no_of_free_months }} </span>
                                                </li>
                                            @endif
                                        </ul>
                                        <div class="py-3">
                                            @if($activePlan && $activePlan->plan_id == $plan->id)

                                                <button class="btn btn-secondary w-100" disabled>
                                                    {{ __('seller_messages.Currently') }}
                                                </button>

                                            @else

                                                <a href="{{ route('seller.single_plans', $plan->id) }}" 
                                                class="btn btn-success w-100"
                                                data-plan-id="{{ $plan->id }}">
                                                 {{ __('seller_messages.Purchase') }}
                                                </a>

                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>

                        @empty
                            <div class="col-12 text-center">
                                <h5>{{ __('seller_messages.No_Plan_Available') }}</h5>
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="pills-plan" role="tabpanel" aria-labelledby="pills-plan-tab" tabindex="0">
                @forelse($myPlans as $plan)
                    @php
                        $isExpired = $plan->is_expired == 1;
                        $isActive = $plan->status == 1 && $plan->is_expired == 0;
                    @endphp

                    <div class="rounded-4 desc-box shadow-sm bg-white mb-4">
                        
                        <div class="card-header d-flex justify-content-between p-2 planmont">
                            <div class="fw-semibold {{ $isExpired ? 'monthly-black' : 'monthly-color' }}">
                              
                                 {{ $isExpired
                                    ? __('seller_messages.Expired')
                                    : __('seller_messages.Active') }}

                            </div>
                            <div class="monthly-color fw-semibold">
                                @if($plan->plan_info->duration_type=='1')
                                 {{ __('seller_messages.Monthly') }}
                                @elseif($plan->plan_info->duration_type=='2')
                                 {{ __('seller_messages.Yearly') }}
                                @endif
                            </div>

                        </div>

                        <div class="p-3">
                            <div class="row mb-2">
                                <div class="col-6">   {{ __('seller_messages.Duration') }}</div>
                                <div class="col-6">
                                    <div class="text-end">
                                           {{ $plan->plan_info->duration }}
                                    {{ $plan->plan_info->duration_type == '1'
                                        ? __('seller_messages.Month')
                                        : __('seller_messages.Year') }}
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">  {{ __('seller_messages.Plan') }}</div>
                                <div class="col-6">
                                    <div class="text-end">
                                        {{ $plan->plan_info->plan_name_english ?? __('user_messages.na') }}
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">  {{ __('seller_messages.Purchased_On') }}</div>
                                <div class="col-6">
                                    <div class="text-end">
                                        
                                        {{formatDateTimeByLocale($plan->plan_start_date)}}
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">  {{ __('seller_messages.Expired_On') }}</div>
                                <div class="col-6">
                                    <div class="text-end">
                                        {{formatDateTimeByLocale($plan->plan_end_date)}}
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-6"> {{ __('seller_messages.Total_Amount') }}</div>
                                <div class="col-6">
                                    <div class="text-end">
                                        {{ $plan->amount }} 
                                    {{ __('seller_messages.KD') }}
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">  {{ __('seller_messages.Transaction_ID') }}</div>
                                <div class="col-6">
                                    <div class="text-end">
                                       @if(!empty($plan->online_transaction_id))
                                            {{ $plan->online_transaction_id }}
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">{{ __('seller_messages.Paid_By') }}
                                     {{ $plan->payment_method ?? '' }}</div>
                                <div class="col-6">
                                    <div class="text-end">
                                       {{ $plan->amount }}  {{ __('seller_messages.KD') }}
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"></div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <a href="#" class="btn btn-success exportbtn renew-plan-btn" data-plan-id="{{ $plan->plan_info->id }}"> {{ __('seller_messages.Renew_Plan') }}</a>
                                    </div>
                                </div>
                            </div>
                            

                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <h5> {{ __('seller_messages.No_Plan_Found') }}</h5>
                    </div>
                @endforelse

            </div>

        </div>
    </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
    //get active tab from local storage
    const lastTab = localStorage.getItem("activeTab");
    if (lastTab) {
        const triggerEl = document.querySelector(`#${lastTab}`);
        if (triggerEl) {
            const tab = new bootstrap.Tab(triggerEl);
            tab.show();
        }
    }
    //save active tab to local storage
    const tabButtons = document.querySelectorAll('button[data-bs-toggle="pill"]');
    tabButtons.forEach((button) => {
        button.addEventListener("shown.bs.tab", function() {
            localStorage.setItem("activeTab", this.id);
        });
    });
});
</script>

<script>
$(document).ready(function () {

    $(".renew-plan-btn").on("click", function () {

        let planId = $(this).data("plan-id");
        let element = $(this);

        if (!planId) return;

        $.ajax({
            url: "{{ route('seller.renew_subcription_plan_buy') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                plan_id: planId
            },
            success: function (res) {

                if (res.status === "success") {
                    window.location.href = "/seller/single-plans/" + planId;

                    // toastr.success(res.message || "Plan purchased successfully");

                    // element.addClass("disabled").text("Purchased");

                    // setTimeout(function () {
                    //     location.reload();
                    // }, 1500);

                } else {
                    toastr.error(res.message || "Something went wrong");
                }

            },
            error: function (xhr) {

                let message = "Something went wrong";

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                toastr.error(message);
            }
        });

    });

});
</script>


@include('dealer.layout.footer');
@include('dealer.product.ajax.datatablejs');