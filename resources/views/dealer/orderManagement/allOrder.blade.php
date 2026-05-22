@include('dealer.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24"> {{ __('seller_messages.order_management') }} </div>
    </div>

    <div class="tabs-panel py-4">
      
    </div>

    <div class="tab-body-wapper">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-Normal-Order" role="tabpanel"
                aria-labelledby="pills-Normal-Order-tab" tabindex="0">
                <div class="mini-tabs-panel py-0">
                    <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active w-100" id="pills-all-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-all"
                                aria-selected="true">{{ __('seller_messages.all') }} ({{count($normal['All_order'])}}) </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link w-100" id="pills-ongoing-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-ongoing" type="button" role="tab" aria-controls="pills-ongoing"
                                aria-selected="false"> {{ __('seller_messages.ongoing_orders') }} ({{count($normal['ongoing_order'])}})</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link w-100" id="pills-past-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-past" type="button" role="tab" aria-controls="pills-past"
                                aria-selected="false">{{ __('seller_messages.past_orders') }} ({{count($normal['past_order'])}})</button>
                        </li>
                    </ul>
                </div>


                <div class="ongoing-wapper">
                    <div class="tab-content" id="pills-tabContent2">
                        <div class="tab-pane fade show active" id="pills-all" role="tabpanel"
                            aria-labelledby="pills-all-tab" tabindex="0">
                            <div class="table-header mb-0 pt-3">
                        <div class="search-field">
                        <div class="from-group position-relative">
                        <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search" class="search-icon">
                        <input type="search" class="dt-input tableSearch form-control" id="customTableSearch"
                        placeholder="{{__('seller_messages.search')}}" data-table="table1">
                        </div>
                        </div>

                                <form method="GET" action="">

                                    <input type="hidden" name="type" value="1">
                                    <input type="hidden" name="tabs" value="1">

                                    <div class="search-filter">
                                        <div class="from-group">
                                            <div class="show-date d-flex gap-2  flex-wrap">
                                                <div class="date-form-pnl-2">
                                                    <input type="date" class="form-control datepicker" name="from_date"
                                                        @if(request()->type==1 && request()->tabs==1)
                                                    value="{{request()->from_date}}" @endif>
                                                </div>
                                                <div class="date-form-pnl-2">
                                                    <input type="date" class="form-control datepicker" name="to_date"
                                                        onchange="this.form.submit()" @if(request()->type==1 &&
                                                    request()->tabs==1)
                                                    value="{{request()->to_date}}" @endif>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="from-group">
                                            <select class="form-select form-control width-50"
                                                aria-label="Default select example" onchange="this.form.submit()"
                                                name="filters">
                                                <option value=""> {{ __('seller_messages.filter_by_status') }} </option>
                                                <option value="1" @if(request()->type==1 &&
                                                    request()->tabs==1 && request()->filters==1) selected @endif>
                                                     {{ __('seller_messages.confirmed') }} </option>
                                                <option value="2" @if(request()->type==1 &&
                                                    request()->tabs==1 && request()->filters==2) selected @endif>  {{ __('seller_messages.packed') }}
                                                </option>
                                                <option value="3" @if(request()->type==1 &&
                                                    request()->tabs==1 && request()->filters==3) selected @endif>
                                                      {{ __('seller_messages.shipped') }} </option>
                                                <option value="4" @if(request()->type==1 &&
                                                    request()->tabs==1 && request()->filters==4) selected @endif>
                                                      {{ __('seller_messages.exchange') }} </option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <div class="table-responsive">
                                <table class="table table-bordered datatable" id="table1"> 
                                    <thead>
                                        <tr>
                                             <th>{{ __('seller_messages.s_no') }}</th>
                                            <th>{{ __('seller_messages.image') }}</th>
                                            <th>{{ __('seller_messages.order_id') }}</th>
                                            <th>{{ __('seller_messages.date_time') }}</th>
                                            <th>{{ __('seller_messages.product_name') }}</th>
                                            <th>{{ __('seller_messages.order_type') }}</th>
                                            <th>{{ __('seller_messages.quantity') }}</th>
                                            <th>{{ __('seller_messages.customer_name') }}</th>
                                            <th>{{ __('seller_messages.location') }}</th>
                                            <th>{{ __('seller_messages.total_amount') }}</th>
                                            <th>{{ __('seller_messages.admin_commission') }}</th>
                                            <th>{{ __('seller_messages.view_details') }}</th>
                                            <th>{{ __('seller_messages.product_status') }}</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($normal['All_order'] as $key => $val)

                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>
                                                <img src="{{@$val->variation_details->variant_image['0']}}"
                                                    class="img-fluid" alt="image" class="pro-image"
                                                    style="width: 80px;height: 80px;border-radius: 5%;object-fit: cover;">
                                            </td>
                                            <td> {{$val->id}}</td>
                                            <td>{{ formatDateTimeByLocale($val->created_at) }}</td>
                                            <td>
                                                {{ App::getLocale() == 'en'
                                                    ? ($val->product_details->product_name_en ?? __('admin_messages.na'))
                                                    : ($val->product_details->product_name_ar ?? __('admin_messages.na'))
                                                }}
                                            </td>
                                            <td>
                                                @if($val->order_type=='1')
                                                 {{ __('seller_messages.normal') }}
                                                @elseif($val->order_type=='2')
                                                  {{ __('seller_messages.custom') }}
                                                @endif
                                            </td>
                                            <td> {{$val->quantity}}</td>
                                            <td>{{$val->order->user_details->full_name}}</td>
                                            <td>{{$val->order->delivery_details->address}}</td>

                                            @php

                                            $Total_Amount=0;
                                            $Total_Amount= $val->amount * $val->quantity;
                                            $Total_Amount+=$val->tax + $val->shipping_fees;

                                            @endphp

                                            <td>{{$Total_Amount}}  {{ __('seller_messages.KD') }}</td>
                                            <td>{{$val->admin_commission}}  {{ __('seller_messages.KD') }}</td>

                                            <td>
                                                <a href="{{ route('seller.single_order_View', $val->id ) }}"
                                                    class="eyebtn"><i class="bi bi-eye"></i></a>
                                            </td>
                                            <td>

                                                @php
                                                $statusCode = Seller_orderItemViewData($val);
                                                @endphp
                                                <div class="from-group">
                                                    <div class="ongoing-title"
                                                        style="color:{{ $statusCode['statusColor'] }};">
                                                        {{ $statusCode['statusText'] }}
                                                    </div>

                                                </div>
                                            </td>
                                        </tr>

                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-ongoing" role="tabpanel"
                            aria-labelledby="pills-ongoing-tab" tabindex="0">
                            <div class="table-header mb-0 pt-3">
                                <div class="search-field">
                                    <div class="from-group position-relative">
                                        <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search"
                                            class="search-icon">
                                        <input type="search" class="dt-input tableSearch form-control"
                                            placeholder=" {{ __('seller_messages.search') }}" data-table="table2">
                                    </div>
                                </div>

                                <form method="GET" action="">

                                    <input type="hidden" name="type" value="1">
                                    <input type="hidden" name="tabs" value="2">

                                    <div class="search-filter">
                                        <div class="from-group">
                                            <div class="show-date d-flex gap-2  flex-wrap">
                                                <div class="date-form-pnl-2">
                                                    <input type="date" class="form-control datepicker" name="from_date"
                                                        @if(request()->type==1 && request()->tabs==2)
                                                    value="{{request()->from_date}}" @endif>
                                                </div>
                                                <div class="date-form-pnl-2">
                                                    <input type="date" class="form-control datepicker" name="to_date"
                                                        onchange="this.form.submit()" @if(request()->type==1 &&
                                                    request()->tabs==2)
                                                    value="{{request()->to_date}}" @endif>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="from-group">
                                            <select class="form-select form-control width-50"
                                                aria-label="Default select example" onchange="this.form.submit()"
                                                name="filters">
                                                <option value=""> {{ __('seller_messages.filter_by_status') }} </option>
                                                <option value="1" @if(request()->type==1 &&
                                                    request()->tabs==2 && request()->filters==1) selected @endif>
                                                     {{ __('seller_messages.confirmed') }}  </option>
                                                <option value="2" @if(request()->type==1 &&
                                                    request()->tabs==2 && request()->filters==2) selected @endif>  {{ __('seller_messages.packed') }}
                                                </option>
                                                <option value="3" @if(request()->type==1 &&
                                                    request()->tabs==2 && request()->filters==3) selected @endif>
                                                      {{ __('seller_messages.shipped') }}  </option>
                                                <option value="4" @if(request()->type==1 &&
                                                    request()->tabs==2 && request()->filters==4) selected @endif>
                                                     {{ __('seller_messages.exchange') }} </option>
                                            </select>
                                        </div>
                                    </div>
                                </form>

                            </div>


                            <div class="table-responsive">
                                <table class="table table-bordered datatable" id="table2">
                                    <thead>
                                        <tr>

                                            <th class="no-sort" >{{ __('seller_messages.s_no') }}</th>
                                            <th class="no-sort" >{{ __('seller_messages.image') }}</th>
                                            <th class="no-sort" >{{ __('seller_messages.order_id') }}</th>
                                            <th class="no-sort" >{{ __('seller_messages.date_time') }}</th>
                                            <th class="no-sort" >{{ __('seller_messages.product_name') }}</th>
                                            <th class="no-sort" >{{ __('seller_messages.order_type') }}</th>
                                            <th class="no-sort" >{{ __('seller_messages.quantity') }}</th>
                                            <th class="no-sort" >{{ __('seller_messages.customer_name') }}</th>
                                            <th class="no-sort" >{{ __('seller_messages.location') }}</th>
                                            <th class="no-sort" >{{ __('seller_messages.total_amount') }}</th>
                                            <th class="no-sort" >{{ __('seller_messages.admin_commission') }}</th>
                                            <th class="no-sort" >{{ __('seller_messages.view_details') }}</th>
                                            <th class="no-sort" >{{ __('seller_messages.product_status') }}</th>

                                            
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($normal['ongoing_order'] as $key => $val)

                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>
                                                <img src="{{@$val->variation_details->variant_image['0']}}"
                                                    class="img-fluid" alt="image" class="pro-image"
                                                    style="width: 80px;height: 80px;border-radius: 5%;object-fit: cover;">
                                            </td>
                                            <td> {{$val->id}}</td>
                                            <td>{{ formatDateTimeByLocale($val->created_at) }}</td>
                                            <td>
                                                {{ App::getLocale() == 'en'
                                                    ? ($val->product_details->product_name_en ?? __('admin_messages.na'))
                                                    : ($val->product_details->product_name_ar ?? __('admin_messages.na'))
                                                }}
                                            </td>
                                            <td>
                                                @if($val->order_type=='1')
                                                  {{ __('seller_messages.normal') }}
                                                @elseif($val->order_type=='2')
                                                  {{ __('seller_messages.custom') }}
                                                @endif
                                            </td>
                                            <td> {{$val->quantity}}</td>
                                            <td>{{$val->order->user_details->full_name}}</td>
                                            <td>{{$val->order->delivery_details->address}}</td>

                                            @php

                                            $Total_Amount=0;
                                            $Total_Amount= $val->amount * $val->quantity;
                                            $Total_Amount+=$val->tax + $val->shipping_fees;

                                            @endphp

                                            <td>{{$Total_Amount}} KD</td>
                                            <td>{{$val->admin_commission}} KD</td>

                                            <td>
                                                <a href="{{ route('seller.single_order_View', $val->id ) }}"
                                                    class="eyebtn"><i class="bi bi-eye"></i></a>
                                            </td>
                                            <td>

                                                @php
                                                $statusCode = Seller_orderItemViewData($val);
                                                @endphp
                                                <div class="from-group">
                                                    <div class="ongoing-title"
                                                        style="color:{{ $statusCode['statusColor'] }};">
                                                        {{ $statusCode['statusText'] }}
                                                    </div>

                                                </div>

                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-past" role="tabpanel" aria-labelledby="pills-past-tab"
                            tabindex="0">
                            <div class="table-header mb-0 pt-3">
                                <div class="search-field">
                                    <div class="from-group position-relative">
                                        <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search"
                                            class="search-icon">
                                        <input type="search" class="dt-input tableSearch form-control"
                                            placeholder="  {{ __('seller_messages.search') }}" data-table="table3">
                                    </div>
                                </div>

                                <form method="GET" action="">

                                    <input type="hidden" name="type" value="1">
                                    <input type="hidden" name="tabs" value="3">

                                    <div class="search-filter">
                                        <div class="from-group">
                                            <div class="show-date d-flex gap-2  flex-wrap">
                                                <div class="date-form-pnl-2">
                                                    <input type="date" class="form-control datepicker" name="from_date"
                                                        @if(request()->type==1 && request()->tabs==3)
                                                    value="{{request()->from_date}}" @endif>
                                                </div>
                                                <div class="date-form-pnl-2">
                                                    <input type="date" class="form-control datepicker" name="to_date"
                                                        onchange="this.form.submit()" @if(request()->type==1 &&
                                                    request()->tabs==3)
                                                    value="{{request()->to_date}}" @endif>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="from-group">
                                            <select class="form-select form-control width-50"
                                                aria-label="Default select example" onchange="this.form.submit()"
                                                name="filters">
                                                <option value="">  {{ __('seller_messages.filter_by_status') }}</option>
                                                <option value="1" @if(request()->type==1 &&
                                                    request()->tabs==3 && request()->filters==1) selected @endif>
                                                        {{ __('seller_messages.confirmed') }} </option>
                                                <option value="2" @if(request()->type==1 &&
                                                    request()->tabs==3 && request()->filters==2) selected @endif>   {{ __('seller_messages.packed') }}
                                                </option>
                                                <option value="3" @if(request()->type==1 &&
                                                    request()->tabs==3 && request()->filters==3) selected @endif>
                                                      {{ __('seller_messages.shipped') }} </option>
                                                <option value="4" @if(request()->type==1 &&
                                                    request()->tabs==3 && request()->filters==4) selected @endif>
                                                     {{ __('seller_messages.exchange') }} </option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <div class="table-responsive">
                                <table class="table table-bordered datatable" id="table3">
                                    <thead>
                                        <tr>
                                               <th class="no-sort" >{{ __('seller_messages.s_no') }}</th>
                                            <th class="no-sort" >{{ __('seller_messages.image') }}</th>
                                            <th class="no-sort" >{{ __('seller_messages.order_id') }}</th>
                                            <th class="no-sort" >{{ __('seller_messages.date_time') }}</th>
                                            <th class="no-sort" >{{ __('seller_messages.product_name') }}</th>
                                            <th class="no-sort" >{{ __('seller_messages.order_type') }}</th>
                                            <th class="no-sort" >{{ __('seller_messages.quantity') }}</th>
                                            <th class="no-sort" >{{ __('seller_messages.customer_name') }}</th>
                                            <th class="no-sort" >{{ __('seller_messages.location') }}</th>
                                            <th class="no-sort" >{{ __('seller_messages.total_amount') }}</th>
                                            <th class="no-sort" >{{ __('seller_messages.admin_commission') }}</th>
                                            <th class="no-sort" >{{ __('seller_messages.view_details') }}</th>
                                            <th class="no-sort" >{{ __('seller_messages.product_status') }}</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($normal['past_order'] as $key => $val)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>
                                                <img src="{{@$val->variation_details->variant_image['0']}}"
                                                    class="img-fluid" alt="image" class="pro-image"
                                                    style="width: 80px;height: 80px;border-radius: 5%;object-fit: cover;">
                                            </td>
                                            <td> {{$val->id}}</td>
                                            <td>{{ formatDateTimeByLocale($val->created_at) }}</td>
                                            <td>
                                                {{ App::getLocale() == 'en'
                                                    ? ($val->product_details->product_name_en ?? __('admin_messages.na'))
                                                    : ($val->product_details->product_name_ar ?? __('admin_messages.na'))
                                                }}
                                            </td>
                                            <td>
                                                @if($val->order_type=='1')
                                                Normal
                                                @elseif($val->order_type=='2')
                                                Custom
                                                @endif
                                            </td>
                                            <td> {{$val->quantity}}</td>
                                            <td>{{$val->order->user_details->full_name}}</td>
                                            <td>{{$val->order->delivery_details->address}}</td>
                                            @php
                                            $Total_Amount=0;
                                            $Total_Amount= $val->amount * $val->quantity;
                                            $Total_Amount+=$val->tax + $val->shipping_fees;

                                            @endphp

                                            <td>{{$Total_Amount}} KD</td>

                                            <td>{{$val->admin_commission}} KD</td>

                                            <td>
                                                <a href="{{ route('seller.single_order_View', $val->id ) }}"
                                                    class="eyebtn"><i class="bi bi-eye"></i></a>
                                            </td>
                                            <td>

                                                @php
                                                $statusCode = Seller_orderItemViewData($val);
                                                @endphp
                                                <div class="from-group">
                                                    <div class="ongoing-title"
                                                        style="color:{{ $statusCode['statusColor'] }};">
                                                        {{ $statusCode['statusText'] }}
                                                    </div>

                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!---------------- End Normal Orders ----------------------->

        </div>

    </div>

</section>

<script>
document.addEventListener("DOMContentLoaded", function() {

    /* ===============================
       MAIN TABS (Normal / Customised)
    ================================*/
    let mainTabKey = "active_main_tab";
    let savedMainTab = localStorage.getItem(mainTabKey);

    if (savedMainTab) {
        let mainTabBtn = document.querySelector(
            `[data-bs-target="${savedMainTab}"]`
        );
        if (mainTabBtn) {
            new bootstrap.Tab(mainTabBtn).show();
        }
    }

    document.querySelectorAll('#pills-tab-Main [data-bs-toggle="pill"]').forEach(tab => {
        tab.addEventListener("shown.bs.tab", function(e) {
            localStorage.setItem(
                mainTabKey,
                e.target.getAttribute("data-bs-target")
            );
        });
    });


    /* ===============================
       INNER TABS (All / Ongoing / Past)
    ================================*/
    let innerTabKey = "active_inner_tab";
    let savedInnerTab = localStorage.getItem(innerTabKey);

    if (savedInnerTab) {
        let innerTabBtn = document.querySelector(
            `[data-bs-target="${savedInnerTab}"]`
        );
        if (innerTabBtn) {
            new bootstrap.Tab(innerTabBtn).show();
        }
    }

    document.querySelectorAll('.mini-tabs-panel [data-bs-toggle="pill"]').forEach(tab => {
        tab.addEventListener("shown.bs.tab", function(e) {
            localStorage.setItem(
                innerTabKey,
                e.target.getAttribute("data-bs-target")
            );
        });
    });

});
</script>




@include('dealer.layout.custom_code');

@include('dealer.layout.footer');


@include('dealer.layout.languagetableCode');

