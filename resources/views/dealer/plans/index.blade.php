@include('dealer.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24">Subscription Plans</div>
    </div>

    <div class="tabs-panel py-4">
        <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active w-100" id="pills-listed-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-listed" type="button" role="tab" aria-controls="pills-listed"
                    aria-selected="true">Listed Plans</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link w-100" id="pills-plan-tab" data-bs-toggle="pill" data-bs-target="#pills-plan"
                    type="button" role="tab" aria-controls="pills-plan" aria-selected="false">My Plan</button>
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
                                        {{ $plan->plan_name_english }}
                                    </div>
                                    <div class="plan-content text-center plan-shadow">
                                        <h4>KD {{ number_format($plan->price, 2) }}</h4>
                                        <div>
                                            for {{ $plan->duration }}
                                            {{ $plan->duration_type == 1 ? 'Month' : 'Year' }}
                                        </div>
                                    </div>
                                    <div class="plan-body p-3">
                                        <ul class="list-inline">
                                            <li>
                                                <img src="{{ asset('dealer/assets/img/check-icon.svg') }}">
                                                Number of Products:
                                                <span>{{ $plan->no_of_products }}</span>
                                            </li>

                                            <li>
                                                <img src="{{ asset('dealer/assets/img/check-icon.svg') }}">
                                                Number of Videos (Reels):
                                                <span>{{ $plan->no_of_videos }}</span>
                                            </li>

                                            <li>
                                                <img src="{{ asset('dealer/assets/img/check-icon.svg') }}">
                                                Number of Highlights:
                                                <span>{{ $plan->no_of_highlights }}</span>
                                            </li>

                                            <li>
                                                <img src="{{ asset('dealer/assets/img/check-icon.svg') }}">
                                                Stories :
                                                <span>{{ $plan->stories == 1 ? 'Yes' : 'No' }}</span>
                                            </li>

                                            <li>
                                                <img src="{{ asset('dealer/assets/img/check-icon.svg') }}">
                                                
                                                {{ $plan->no_of_employee }} Store Employees
                                            </li>

                                            <li>
                                                <img src="{{ asset('dealer/assets/img/check-icon.svg') }}">
                                                Commission :
                                                <span>
                                                    {{ $plan->commission == 1 ? $plan->commission_percentage . '%' : '0%' }}
                                                </span>
                                            </li>
                                        </ul>
                                        <div class="py-3">
                                            @if($activePlan && $activePlan->plan_id == $plan->id)

                                                <button class="btn btn-secondary w-100" disabled>
                                                    Currently
                                                </button>

                                            @else

                                                <a href="{{ route('seller.single_plans', $plan->id) }}" 
                                                class="btn btn-success w-100"
                                                data-plan-id="{{ $plan->id }}">
                                                Purchase
                                                </a>

                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>

                        @empty
                            <div class="col-12 text-center">
                                <h5>No plan available</h5>
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>

            <!-------------  my plan ------------>

            <!-- <div class="tab-pane fade" id="pills-plan" role="tabpanel" aria-labelledby="pills-plan-tab" tabindex="0">
                
                <div class="rounded-4 desc-box shadow-sm bg-white mb-4">
                    <div class="card-header d-flex justify-content-between p-2 planmont">
                        <div class="monthly-color fw-semibold">Active</div>
                        <div class="monthly-color fw-semibold">Monthly</div>
                    </div>
                    <div class="p-3">
                        <div class="row mb-2">
                            <div class="col-6">Purchased On</div>
                            <div class="col-6">
                                <div class="text-end">21/03/2026 at 10:00 AM  </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">Amount </div>
                            <div class="col-6">
                                <div class="text-end">200 KD</div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">Plan </div>
                            <div class="col-6">
                                <div class="text-end">Pro Plan </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-4 desc-box shadow-sm bg-white mb-4">
                    <div class="card-header d-flex justify-content-between p-2 planmont">
                        <div class="monthly-black fw-semibold">Expired</div>
                        <div class="monthly-color fw-semibold">Monthly</div>
                    </div>
                    <div class="p-3">
                        <div class="row mb-2">
                            <div class="col-6">Purchased On</div>
                            <div class="col-6">
                                <div class="text-end">21/03/2026 at 10:00 AM  </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">Amount </div>
                            <div class="col-6">
                                <div class="text-end">200 KD</div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">Plan </div>
                            <div class="col-6">
                                <div class="text-end">Pro Plan </div>
                            </div>
                        </div>
                    </div>
                </div>

                


            </div> -->
            <div class="tab-pane fade" id="pills-plan" role="tabpanel" aria-labelledby="pills-plan-tab" tabindex="0">
                @forelse($myPlans as $plan)
                    @php
                        $isExpired = $plan->is_expired == 1;
                        $isActive = $plan->status == 1 && $plan->is_expired == 0;
                    @endphp

                    <div class="rounded-4 desc-box shadow-sm bg-white mb-4">
                        
                        <div class="card-header d-flex justify-content-between p-2 planmont">
                            <div class="fw-semibold {{ $isExpired ? 'monthly-black' : 'monthly-color' }}">
                                {{ $isExpired ? 'Expired' : 'Active' }}
                            </div>
                            <div class="monthly-color fw-semibold">
                                @if($plan->plan_info->duration_type=='1')
                                Monthly
                                @elseif($plan->plan_info->duration_type=='2')
                                Yearly
                                @endif
                            </div>

                        </div>

                        <div class="p-3">
                            <div class="row mb-2">
                                <div class="col-6">Duration</div>
                                <div class="col-6">
                                    <div class="text-end">
                                        @if($plan->plan_info->duration_type == '1')
                                            {{ $plan->plan_info->duration  }} Month
                                        @elseif($plan->plan_info->duration_type == '2')
                                            {{ $plan->plan_info->duration  }} Year
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">Plan</div>
                                <div class="col-6">
                                    <div class="text-end">
                                        {{ $plan->plan_info->plan_name_english ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">Purchased On</div>
                                <div class="col-6">
                                    <div class="text-end">
                                        {{ \Carbon\Carbon::parse($plan->plan_start_date)->format('d/m/Y \a\t h:i A') }}
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">Expired on</div>
                                <div class="col-6">
                                    <div class="text-end">
                                        {{ \Carbon\Carbon::parse($plan->plan_end_date)->format('d/m/Y \a\t h:i A') }}
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">Total Amount</div>
                                <div class="col-6">
                                    <div class="text-end">
                                        {{ $plan->amount }} KD
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">Transaction id</div>
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
                                <div class="col-6">Paid By {{ $plan->payment_method ?? '' }}</div>
                                <div class="col-6">
                                    <div class="text-end">
                                       {{ $plan->amount }} KD
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"></div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <a href="#" class="btn btn-success exportbtn renew-plan-btn" data-plan-id="{{ $plan->plan_info->id }}">Renew Plan</a>
                                    </div>
                                </div>
                            </div>
                            

                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <h5>No plan found</h5>
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