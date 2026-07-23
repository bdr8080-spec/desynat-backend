@extends('admin.layout.app')
@section('content')


<div id="content-wrapper" class="d-flex flex-column position-relative">
    <div id="content" class="">


        <div class="inner-content management">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="d-flex align-items-center gap-3 mt-2">
                        <div class="arrow">
                            <a class="table-button" type="button" href="{{route('planManagement')}}">
                                <i class="fas fa-angle-left"></i>
                            </a>
                        </div>
                        <h6 class="m-0">{{ __('admin_messages.manage_plan') }}</h6>
                    </div>
                </div>

                <div class="col-lg-6 col-md-4 col-12">
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-dark customBtn" data-bs-toggle="modal" data-bs-target="#sentModal2">
                            <span>{{ __('admin_messages.add_subscription_plan') }}</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="userManagecontent mt-5">
                <div class="">
                    <!-- <div class="align-items-end d-flex">
                        <div class="search-box" style="position: relative">
                            <i class="bi bi-search" style="
                        position: absolute;
                        left: 10px;
                        top: 50%;
                        transform: translateY(-50%);
                        font-size: 16px;
                        color: #888;
                      ">
                            </i>
                            <input type="text" class="form-control" placeholder="Search for..."
                                style="padding-left: 35px" />
                        </div>
                    </div> -->

                    <div class="table-responsive w-100">
                        <table id="myTable" class="table w-100">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('admin_messages.s_no') }}</th>
                                    <th scope="col">{{ __('admin_messages.plan_name_english') }}</th>
                                    <th scope="col">{{ __('admin_messages.plan_name_arabic') }}</th>
                                    <th scope="col">{{ __('admin_messages.duration') }}</th>
                                    <th scope="col">{{ __('admin_messages.no_of_products') }}</th>
                                    <th scope="col">{{ __('admin_messages.no_of_videos') }}</th>
                                    <th scope="col">{{ __('admin_messages.no_of_highlights') }}</th>
                                    <th scope="col">{{ __('admin_messages.stories') }}</th>
                                    <th scope="col">{{ __('admin_messages.no_of_employees') }}</th>
                                    <th scope="col">{{ __('admin_messages.plan_price') }}</th>
                                    <th scope="col">{{ __('admin_messages.new_plan_price') }}</th>
                                    <th scope="col">{{ __('admin_messages.commission(%)') }}</th>
                                    <th scope="col">{{ __('admin_messages.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($plans as $plan)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $plan->plan_name_english }}</td>
                                    <td>{{ $plan->plan_name_arabic }}</td>
                                    <td>
                                        {{ $plan->duration }}
                                        @if($plan->duration_type == 1)
                                        {{ __('admin_messages.months') }}
                                        @elseif($plan->duration_type == 2)
                                        {{ __('admin_messages.years') }}
                                        @else
                                        {{ __('admin_messages.n/a') }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $plan->product_type == 1 
                                            ? __('admin_messages.unlimited') 
                                            : $plan->no_of_products 
                                        }}
                                    </td>
                                    <td>{{ $plan->no_of_videos }}</td>
                                    <td>{{ $plan->no_of_highlights }}</td>
                                    <td>
                                        @if($plan->stories == 0)
                                        {{ __('admin_messages.no') }}
                                        @elseif($plan->stories == 1)
                                        {{ __('admin_messages.yes') }}
                                        @else
                                        {{ __('admin_messages.n/a') }}
                                        @endif
                                    </td>
                                    <td>{{ $plan->no_of_employee }}</td>
                                    <td>{{ $plan->price }} {{ __('admin_messages.kd') }}</td>
                                    <td>
                                        {{ $plan->discounted_price 
                                            ? $plan->discounted_price . ' ' . __('admin_messages.kd') 
                                            : __('admin_messages.n/a') 
                                        }}
                                    </td>
                                    <td>
                                        {{ $plan->commission_percentage === null
                                            ? __('admin_messages.no')
                                            : $plan->commission_percentage . '%'
                                        }}
                                    </td>
                                    <td>
                                        <div class="d-flex gap-3 justify-content-center">
                                            <!-- <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $plan->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </a> -->
                                            <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#editModal"
                                                data-plan-id="{{ $plan->id }}"
                                                data-english-name="{{ $plan->plan_name_english }}"
                                                data-arabic-name="{{ $plan->plan_name_arabic }}"
                                                data-duration="{{ $plan->duration }}"
                                                data-duration-type="{{ $plan->duration_type }}"
                                                data-new-duration="{{ $plan->new_duration }}"
                                                data-new-duration-type="{{ $plan->new_duration_type }}"
                                                data-no-of-videos="{{ $plan->no_of_videos }}"
                                                data-no-of-products="{{ $plan->no_of_products }}"
                                                data-no-of-highlights="{{ $plan->no_of_highlights }}"
                                                data-no-of-employees="{{ $plan->no_of_employee }}"
                                                data-price="{{ $plan->price }}"
                                                data-discounted-price="{{ $plan->discounted_price }}"
                                                data-stories="{{ $plan->stories }}"
                                                data-is-recommended-store="{{ $plan->is_recommended_store }}"
                                                data-commission="{{ $plan->commission }}"
                                                data-commission-percentage="{{ $plan->commission_percentage }}"
                                                data-product-type="{{ $plan->product_type }}"
                                                data-free-months-option="{{ $plan->is_free_months ? 1 : 0 }}"
                                                data-free-months="{{ $plan->no_of_free_months }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <a href="javascript:void(0);" class="table-button text-danger deletePlan mb-1 mt-1"
                                                data-id="{{ $plan->id }}">
                                                <i class="bi bi-trash3-fill"></i>
                                            </a>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input toggleStatus" type="checkbox"
                                                    role="switch" id="switch{{ $plan->id }}" data-id="{{ $plan->id }}"
                                                    {{ $plan->status == 1 ? 'checked' : '' }} />
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty

                                @endforelse
                            </tbody>

                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- add new model -->
<div class="modal fade" id="sentModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">{{ __('admin_messages.add_subscription_plan') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="appointment-container">
                    <form id="addPlanForm">
                        <div class="row">
                            <input type="hidden" name="country_id" value="{{ request()->segment(3) }}">
                            <!-- Plan Name English -->
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin_messages.plan_name_english') }}</label>
                                    <input type="text" name="plan_name_english" placeholder="{{ __('admin_messages.enter_plan_name_in_english') }}"
                                        oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')"
                                        class="form-control">
                                    <span class="text-danger error-text plan_name_english_err"></span>
                                </div>
                            </div>

                            <!-- Plan Name Arabic -->
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin_messages.plan_name_arabic') }}</label>
                                    <input type="text" name="plan_name_arabic" placeholder="{{ __('admin_messages.enter_plan_name_in_arabic') }}"
                                        oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')"
                                        class="form-control">
                                    <span class="text-danger error-text plan_name_arabic_err"></span>
                                </div>
                            </div>

                            <!-- Duration -->
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin_messages.duration') }}</label>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input type="text" name="duration" placeholder="{{ __('admin_messages.set_duration') }}"
                                                oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')"
                                                maxlength="2" class="form-control">
                                            <span class="text-danger error-text duration_err"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <select name="duration_type" class="form-select">
                                                <option value="1">{{ __('admin_messages.months') }}</option>
                                                <option value="2">{{ __('admin_messages.years') }}</option>
                                            </select>
                                            <span class="text-danger error-text duration_type_err"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- No. of Videos -->
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin_messages.no_of_videos') }}</label>
                                    <input type="text" name="no_of_videos" placeholder="{{ __('admin_messages.enter_no_of_videos') }}"
                                        oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')"
                                        maxlength="3" class="form-control">
                                    <span class="text-danger error-text no_of_videos_err"></span>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin_messages.product_type') }}</label>
                                    <div class="row">
                                        <div class="col-lg-4 d-flex align-items-center">
                                            <input type="radio" name="product_type" value="0" class="form-check-input me-2" checked>
                                            <label class="form-check-label">{{ __('admin_messages.defined') }}</label>
                                        </div>
                                        <div class="col-lg-6 d-flex align-items-center">
                                            <input type="radio" name="product_type" value="1" class="form-check-input me-2">
                                            <label class="form-check-label">{{ __('admin_messages.unlimited') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- No. of Products -->
                            <div class="col-lg-6" id="productsInput">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin_messages.no_of_products') }}</label>
                                    <input type="text" name="no_of_products" placeholder="{{ __('admin_messages.enter_no_of_products') }}"
                                        oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')"
                                        maxlength="4" class="form-control">
                                    <span class="text-danger error-text no_of_products_err"></span>
                                </div>
                            </div>

                            <!-- No. of Highlights -->
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin_messages.no_of_highlights') }}</label>
                                    <input type="text" name="no_of_highlights" placeholder="{{ __('admin_messages.enter_no_of_highlights') }}"
                                        oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')"
                                        maxlength="3" class="form-control">
                                    <span class="text-danger error-text no_of_highlights_err"></span>
                                </div>
                            </div>

                            <!-- No. of Employee -->
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin_messages.no_of_employees') }}</label>
                                    <input type="text" name="no_of_employee" placeholder="{{ __('admin_messages.enter_no_of_employees') }}"
                                        oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')"
                                        maxlength="4" class="form-control">
                                    <span class="text-danger error-text no_of_employee_err"></span>
                                </div>
                            </div>

                            <!-- Charges -->
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin_messages.plan_price') }}</label>
                                    <input type="text" name="price" placeholder="{{ __('admin_messages.enter_plan_price') }}"
                                        oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/^0+([1-9])/,'$1').replace(/^0+$/,'').replace(/(\..*?)\..*/,'$1').replace(/(\.\d{2}).*/,'$1')"
                                        class="form-control">
                                    <span class="text-danger error-text price_err"></span>
                                </div>
                            </div>

                            <!-- Stories -->
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin_messages.stories') }}</label>
                                    <div class="row">
                                        <div class="col-lg-4 d-flex align-items-center">
                                            <input type="radio" id="storiesYes" name="stories" value="yes"
                                                class="form-check-input me-2" checked>
                                            <label for="storiesYes" class="form-check-label">{{ __('admin_messages.yes') }}</label>
                                        </div>
                                        <div class="col-lg-6 d-flex align-items-center">
                                            <input type="radio" id="storiesNo" name="stories" value="no"
                                                class="form-check-input me-2">
                                            <label for="storiesNo" class="form-check-label">{{ __('admin_messages.no') }}</label>
                                        </div>
                                    </div>
                                    <span class="text-danger error-text stories_err"></span>
                                </div>
                            </div>

                            <!-- recommended store -->
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin_messages.recommended_store') }}</label>
                                    <div class="row">
                                        <div class="col-lg-4 d-flex align-items-center">
                                            <input type="radio" id="storeYes" name="is_recommended_store" value="yes"
                                                class="form-check-input me-2" checked>
                                            <label for="storiesYes" class="form-check-label">{{ __('admin_messages.yes') }}</label>
                                        </div>
                                        <div class="col-lg-6 d-flex align-items-center">
                                            <input type="radio" id="storeNo" name="is_recommended_store" value="no"
                                                class="form-check-input me-2">
                                            <label for="storiesNo" class="form-check-label">{{ __('admin_messages.no') }}</label>
                                        </div>
                                    </div>
                                    <span class="text-danger error-text is_recommended_store_err"></span>
                                </div>
                            </div>

                            <!-- Commission -->
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin_messages.commission(%)') }}</label>
                                    <div class="row">
                                        <div class="col-lg-4 d-flex align-items-center">
                                            <input type="radio" id="commissionYes" name="commission" value="yes"
                                                class="form-check-input me-2">
                                            <label for="commissionYes" class="form-check-label">{{ __('admin_messages.yes') }}</label>
                                        </div>
                                        <div class="col-lg-6 d-flex align-items-center">
                                            <input type="radio" id="commissionNo" name="commission" value="no"
                                                class="form-check-input me-2" checked>
                                            <label for="commissionNo" class="form-check-label">{{ __('admin_messages.no') }}</label>
                                        </div>
                                    </div>
                                    <span class="text-danger error-text commission_err"></span>

                                    <!-- Commission Percentage -->
                                    <div id="commissionInput" style="display:none; margin-top:10px;">
                                        <div class="input-with-percent">
                                            <input type="text" name="commission_percentage"
                                                oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'');if(parseInt(this.value)>100)this.value='100';"
                                                placeholder="{{ __('admin_messages.enter_commission_percentage') }}" class="form-control w-50">
                                            <span class="percent-symbol">%</span>
                                        </div>

                                        <span class="text-danger error-text commission_percentage_err"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Free Months -->
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin_messages.free_months') }}</label>
                                    <div class="row">
                                        <div class="col-lg-4 d-flex align-items-center">
                                            <input type="radio" name="free_months_option" value="1" class="form-check-input me-2">
                                            <label class="form-check-label">{{ __('admin_messages.yes') }}</label>
                                        </div>
                                        <div class="col-lg-6 d-flex align-items-center">
                                            <input type="radio" name="free_months_option" value="0" class="form-check-input me-2" checked>
                                            <label class="form-check-label">{{ __('admin_messages.no') }}</label>
                                        </div>
                                    </div>
                                    <span class="text-danger error-text free_months_option_err"></span>

                                    <!-- Free Months Input -->
                                    <div id="freeMonthsInput" style="display:none; margin-top:10px;">
                                        <input type="text" name="free_months"
                                            placeholder="{{ __('admin_messages.enter_no_of_free_months') }}"
                                            oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')"
                                            maxlength="2" class="form-control w-50">

                                        <span class="text-danger error-text free_months_err"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-lg-12 d-flex justify-content-center mt-3">
                                <button type="submit" class="btn btn-dark customBtn">{{ __('admin_messages.submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Plan Modal -->
<!-- <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Edit Plan</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <form class="editPlanForm">
                        <input type="hidden" name="plan_id" value="">
                        <input type="hidden" name="country_id" value="{{ request()->segment(3) }}">

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label>Plan Name (English)</label>
                                    <input type="text" name="plan_name_english" value=""
                                        oninput="this.value=this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')"
                                        class="form-control">
                                    <span class="text-danger error-text plan_name_english_err"></span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label>Plan Name (Arabic)</label>
                                    <input type="text" name="plan_name_arabic" value=""
                                        oninput="this.value=this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')"
                                        class="form-control">
                                    <span class="text-danger error-text plan_name_arabic_err"></span>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label>Duration</label>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input type="text" name="duration" value="" placeholder="Enter duration"
                                                oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')"
                                                maxlength="2" class="form-control">
                                            <span class="text-danger error-text duration_err"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <select name="duration_type" class="form-select">
                                                <option value="">Select Duration</option>
                                                <option value="1">Months</option>
                                                <option value="2">Years</option>
                                            </select>
                                            <span class="text-danger error-text duration_type_err"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label>New Duration</label>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input type="text" name="new_duration" value=""
                                                placeholder="Enter new duration"
                                                oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')"
                                                maxlength="2" class="form-control">
                                            <span class="text-danger error-text new_duration_err"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <select name="new_duration_type" class="form-select">
                                                <option value="">Select New Duration</option>
                                                <option value="1">Months</option>
                                                <option value="2">Years</option>
                                            </select>
                                            <span class="text-danger error-text duration_type_err"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label>No. of Videos</label>
                                    <input type="text" name="no_of_videos" value=""
                                        oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')"
                                        class="form-control">
                                    <span class="text-danger error-text no_of_videos_err"></span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label>No. of Products</label>
                                    <input type="text" name="no_of_products" value=""
                                        oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')"
                                        class="form-control">
                                    <span class="text-danger error-text no_of_products_err"></span>
                                </div>

                            </div>


                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label>No. of Highlights</label>
                                    <input type="text" name="no_of_highlights" value=""
                                        oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')"
                                        class="form-control">
                                    <span class="text-danger error-text no_of_highlights_err"></span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label>No. of Employees</label>
                                    <input type="text" name="no_of_employee" value=""
                                        oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')"
                                        class="form-control">
                                    <span class="text-danger error-text no_of_employee_err"></span>
                                </div>

                            </div>

                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label>Plan Price</label>
                                    <input type="text" name="price" value=""
                                        oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/^0+([1-9])/,'$1').replace(/^0+$/,'').replace(/(\..*?)\..*/,'$1').replace(/(\.\d{2}).*/,'$1')"
                                        class="form-control">
                                    <span class="text-danger error-text price_err"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label>New Plan Price</label>
                                    <input type="text" name="discounted_price" value=""
                                        oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/^0+([1-9])/,'$1').replace(/^0+$/,'').replace(/(\..*?)\..*/,'$1').replace(/(\.\d{2}).*/,'$1')"
                                        class="form-control">
                                    <span class="text-danger error-text price_err"></span>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <label>Stories</label>
                                <div class="row">
                                    <div class="col-lg-4 d-flex align-items-center">
                                        <input type="radio" name="stories" value="yes" style="
    margin: 7px;"> Yes
                                    </div>
                                    <div class="col-lg-6 d-flex align-items-center">
                                        <input type="radio" name="stories" value="no" style="
    margin: 7px;"> No
                                    </div>
                                </div>
                                <span class="text-danger error-text stories_err"></span>
                            </div>

                            <div class="col-lg-12">
                                <label>Commission</label>
                                <div class="row">
                                    <div class="col-lg-4 d-flex align-items-center">
                                        <input type="radio" class="commissionRadio" name="commission" value="yes" style="
    margin: 7px;"> Yes
                                    </div>
                                    <div class="col-lg-6 d-flex align-items-center">
                                        <input type="radio" class="commissionRadio" name="commission" value="no" style="
    margin: 7px;"> No
                                    </div>
                                </div>
                                <span class="text-danger error-text commission_err"></span>

                                <div class="commissionInput" style="margin-top:10px;">
                                    <div class="input-with-percent">
                                        <input type="text" name="commission_percentage" value=""
                                            oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'');if(parseInt(this.value)>100)this.value='100';"
                                            placeholder="Enter commission percentage" class="form-control w-50">
                                        <span class="percent-symbol">%</span>
                                    </div>

                                    <span class="text-danger error-text commission_percentage_err"></span>
                                </div>
                            </div>

                            <div class="col-lg-12 d-flex justify-content-center mt-3">
                                <button type="submit" class="btn btn-dark customBtn">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">{{ __('admin_messages.edit_subscription_plan') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <form class="editPlanForm">
                        <input type="hidden" name="plan_id" value="">
                        <input type="hidden" name="country_id" value="{{ request()->segment(3) }}">

                        <div class="row">
                            <!-- Plan Name English -->
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin_messages.plan_name_english') }}</label>
                                    <input type="text" name="plan_name_english" value=""
                                        oninput="this.value=this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')"
                                        class="form-control" placeholder="{{ __('admin_messages.enter_plan_name_in_english') }}">
                                    <span class="text-danger error-text plan_name_english_err"></span>
                                </div>
                            </div>

                            <!-- Plan Name Arabic -->
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin_messages.plan_name_arabic') }}</label>
                                    <input type="text" name="plan_name_arabic" value=""
                                        oninput="this.value=this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')"
                                        class="form-control" placeholder="{{ __('admin_messages.enter_plan_name_in_arabic') }}">
                                    <span class="text-danger error-text plan_name_arabic_err"></span>
                                </div>
                            </div>

                            <!-- Duration -->
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin_messages.duration') }}</label>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input type="text" name="duration" value="" placeholder="{{ __('admin_messages.set_duration') }}"
                                                oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')"
                                                maxlength="2" class="form-control">
                                            <span class="text-danger error-text duration_err"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <select name="duration_type" class="form-select">
                                                <!-- <option value="">Select Duration</option> -->
                                                <option value="1">{{ __('admin_messages.months') }}</option>
                                                <option value="2">{{ __('admin_messages.years') }}</option>
                                            </select>
                                            <span class="text-danger error-text duration_type_err"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- New Duration -->
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin_messages.new_duration') }}</label>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input type="text" name="new_duration" value=""
                                                placeholder="{{ __('admin_messages.enter_new_duration') }}"
                                                oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')"
                                                maxlength="2" class="form-control">
                                            <span class="text-danger error-text new_duration_err"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <select name="new_duration_type" class="form-select">
                                                <!-- <option value="">Select New Duration</option> -->
                                                <option value="1">{{ __('admin_messages.months') }}</option>
                                                <option value="2">{{ __('admin_messages.years') }}</option>
                                            </select>
                                            <span class="text-danger error-text duration_type_err"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Videos -->
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin_messages.no_of_videos') }}</label>
                                    <input type="text" name="no_of_videos" value=""
                                        oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')"
                                        class="form-control" placeholder="{{ __('admin_messages.enter_no_of_videos') }}">
                                    <span class="text-danger error-text no_of_videos_err"></span>
                                </div>
                            </div>

                            <!-- Product Type (Defined / Unlimited) -->
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin_messages.product_type') }}</label>
                                    <div class="row">
                                        <div class="col-lg-4 d-flex align-items-center">
                                            <input type="radio" name="product_type" value="0" class="form-check-input me-2"> {{ __('admin_messages.defined') }}
                                        </div>
                                        <div class="col-lg-6 d-flex align-items-center">
                                            <input type="radio" name="product_type" value="1" class="form-check-input me-2"> {{ __('admin_messages.unlimited') }}
                                        </div>
                                    </div>
                                    <span class="text-danger error-text product_type_err"></span>
                                </div>
                            </div>

                            <!-- Products (only show if Defined) -->
                            <div class="col-lg-6" id="productsInput">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin_messages.no_of_products') }}</label>
                                    <input type="text" name="no_of_products" value=""
                                        oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')"
                                        class="form-control" placeholder="{{ __('admin_messages.enter_no_of_products') }}">
                                    <span class="text-danger error-text no_of_products_err"></span>
                                </div>
                            </div>

                            <!-- Highlights -->
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin_messages.no_of_highlights') }}</label>
                                    <input type="text" name="no_of_highlights" value=""
                                        oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')"
                                        class="form-control" placeholder="{{ __('admin_messages.enter_no_of_highlights') }}">
                                    <span class="text-danger error-text no_of_highlights_err"></span>
                                </div>
                            </div>

                            <!-- Employees -->
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin_messages.no_of_employees') }}</label>
                                    <input type="text" name="no_of_employee" value=""
                                        oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')"
                                        class="form-control" placeholder="{{ __('admin_messages.enter_no_of_employees') }}">
                                    <span class="text-danger error-text no_of_employee_err"></span>
                                </div>
                            </div>

                            <!-- Plan Price -->
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin_messages.plan_price') }}</label>
                                    <input type="text" name="price" value=""
                                        oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/^0+([1-9])/,'$1').replace(/^0+$/,'').replace(/(\..*?)\..*/,'$1').replace(/(\.\d{2}).*/,'$1')"
                                        class="form-control" placeholder="{{ __('admin_messages.enter_plan_price') }}">
                                    <span class="text-danger error-text price_err"></span>
                                </div>
                            </div>

                            <!-- New Plan Price -->
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin_messages.new_plan_price') }}</label>
                                    <input type="text" name="discounted_price" value=""
                                        oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/^0+([1-9])/,'$1').replace(/^0+$/,'').replace(/(\..*?)\..*/,'$1').replace(/(\.\d{2}).*/,'$1')"
                                        class="form-control" placeholder="{{ __('admin_messages.enter_plan_price') }}">
                                    <span class="text-danger error-text discounted_price_err"></span>
                                </div>
                            </div>

                            <!-- Stories -->
                            <div class="col-lg-12">
                                <label>{{ __('admin_messages.stories') }}</label>
                                <div class="row">
                                    <div class="col-lg-4 d-flex align-items-center">
                                        <input type="radio" name="stories" value="yes" style="margin:7px;"> {{ __('admin_messages.yes') }}
                                    </div>
                                    <div class="col-lg-6 d-flex align-items-center">
                                        <input type="radio" name="stories" value="no" style="margin:7px;"> {{ __('admin_messages.no') }}
                                    </div>
                                </div>
                                <span class="text-danger error-text stories_err"></span>
                            </div>

                            <!-- recommended store -->
                            <div class="col-lg-12">
                                <label>{{ __('admin_messages.recommended_store') }}</label>
                                <div class="row">
                                    <div class="col-lg-4 d-flex align-items-center">
                                        <input type="radio" name="is_recommended_store" value="yes" style="margin:7px;"> {{ __('admin_messages.yes') }}
                                    </div>
                                    <div class="col-lg-6 d-flex align-items-center">
                                        <input type="radio" name="is_recommended_store" value="no" style="margin:7px;"> {{ __('admin_messages.no') }}
                                    </div>
                                </div>
                                <span class="text-danger error-text is_recommended_store_err"></span>
                            </div>

                            <!-- Commission -->
                            <div class="col-lg-12">
                                <label>{{ __('admin_messages.commission(%)') }}</label>
                                <div class="row">
                                    <div class="col-lg-4 d-flex align-items-center">
                                        <input type="radio" class="commissionRadio" name="commission" value="yes" style="margin:7px;"> {{ __('admin_messages.yes') }}
                                    </div>
                                    <div class="col-lg-6 d-flex align-items-center">
                                        <input type="radio" class="commissionRadio" name="commission" value="no" style="margin:7px;"> {{ __('admin_messages.no') }}
                                    </div>
                                </div>
                                <span class="text-danger error-text commission_err"></span>

                                <div class="commissionInput" style="margin-top:10px;">
                                    <div class="input-with-percent">
                                        <input type="text" name="commission_percentage" value=""
                                            oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'');if(parseInt(this.value)>100)this.value='100';"
                                            placeholder="{{ __('admin_messages.enter_commission_percentage') }}" class="form-control w-50">
                                        <span class="percent-symbol">%</span>
                                    </div>

                                    <span class="text-danger error-text commission_percentage_err"></span>
                                </div>
                            </div>

                            <!-- Free Months -->
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin_messages.free_months') }}</label>
                                    <div class="row">
                                        <div class="col-lg-4 d-flex align-items-center">
                                            <input type="radio" name="free_months_option" value="1" class="form-check-input me-2"> {{ __('admin_messages.yes') }}
                                        </div>
                                        <div class="col-lg-6 d-flex align-items-center">
                                            <input type="radio" name="free_months_option" value="0" class="form-check-input me-2"> {{ __('admin_messages.no') }}
                                        </div>
                                    </div>
                                    <span class="text-danger error-text free_months_option_err"></span>

                                    <div id="freeMonthsInput" style="display:none; margin-top:10px;">
                                        <input type="text" name="free_months" placeholder="{{ __('admin_messages.enter_no_of_free_months') }}"
                                            oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')"
                                            maxlength="2" class="form-control w-50">
                                        <span class="text-danger error-text free_months_err"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="col-lg-12 d-flex justify-content-center mt-3">
                                <button type="submit" class="btn btn-dark customBtn">{{ __('admin_messages.update') }}</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>









@endsection
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Update plan status -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.toggleStatus').forEach(toggle => {
        toggle.addEventListener('change', function() {
            let planId = this.getAttribute('data-id');

            fetch(`/admin/change_plan_status/${planId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // toastr.success(data.message);
                        if (data.status == 1) {
                            toastr.success(data.message); // Green for active
                        } else {
                            toastr.error(data.message); // Red for deactivated
                        }
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    } else {
                        toastr.error(data.message);
                    }
                })
                .catch(error => {
                    //console.error(error);
                    toastr.error('Something went wrong while updating status.');
                });
        });
    });
});
</script>

<!-- Delete Plan -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.deletePlan').forEach(button => {
        button.addEventListener('click', function() {
            let planId = this.getAttribute('data-id');

            Swal.fire({
                title: "{{ __('admin_messages.are_you_sure?') }}",
                text: "{{ __('admin_messages.you_wont_be_able_to_revert_this') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "{{ __('admin_messages.yes_delete_it') }}",
                cancelButtonText: "{{ __('admin_messages.cancel') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/deletePlan/${planId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                toastr.success(data.message);
                                this.closest('tr').remove();
                            } else {
                                toastr.error(data.message);
                            }
                        })
                        .catch(() => {
                            toastr.error('Something went wrong.');
                        });
                }
            });
        });
    });
});
</script>


<script>
$(document).ready(function() {

    // Duration logic
    $('select[name="duration_type"]').change(function() {
        let durationType = $(this).val();

        if (durationType === '2') { // Years
            $('input[name="duration"]').val(1);
            $('input[name="duration"]').prop('readonly', true);
        } else { // Months
            $('input[name="duration"]').val('');
            $('input[name="duration"]').prop('readonly', false);
        }
    });

    // Product type toggle (0 = defined, 1 = unlimited)
    $('input[name="product_type"]').change(function() {
        let type = $(this).val();

        if (type == '1') {
            $('#productsInput').hide();
            $('input[name="no_of_products"]').val('');
            $('.no_of_products_err').text('');
        } else {
            $('#productsInput').show();
        }
    });

    // Commission toggle
    $('input[name="commission"]').change(function() {
        if ($(this).val() === 'yes') {
            $('#commissionInput').show();
        } else {
            $('#commissionInput').hide();
            $('input[name="commission_percentage"]').val('');
            $('.commission_percentage_err').text('');
        }
    });

    // Free months toggle (1 = yes, 0 = no)
    $('input[name="free_months_option"]').change(function() {
        let val = $(this).val();

        if (val == '1') {
            $('#freeMonthsInput').show();
        } else {
            $('#freeMonthsInput').hide();
            $('input[name="free_months"]').val('');
            $('.free_months_err').text('');
        }
    });

    // Remove error on input/change
    $('#addPlanForm').on('input change', 'input, select', function() {
        let name = $(this).attr('name');
        $('.' + name + '_err').text('');
    });

    // Form submit
    $('#addPlanForm').submit(function(e) {
        e.preventDefault();
        $('.error-text').text('');

        let plan_name_english = $('input[name="plan_name_english"]').val().trim();
        let plan_name_arabic = $('input[name="plan_name_arabic"]').val().trim();
        let duration = $('input[name="duration"]').val().trim();
        let duration_type = $('select[name="duration_type"]').val();
        let no_of_videos = $('input[name="no_of_videos"]').val().trim();
        let no_of_products = $('input[name="no_of_products"]').val().trim();
        let product_type = $('input[name="product_type"]:checked').val();
        let no_of_highlights = $('input[name="no_of_highlights"]').val().trim();
        let no_of_employee = $('input[name="no_of_employee"]').val().trim();
        let stories = $('input[name="stories"]:checked').val();
        let price = $('input[name="price"]').val().trim();
        let commission = $('input[name="commission"]:checked').val();
        let commission_percentage = $('input[name="commission_percentage"]').val().trim();
        let country_id = $('input[name="country_id"]').val().trim();
        let is_recommended_store = $('input[name="is_recommended_store"]:checked').val();

        // Free months
        let free_months_option = $('input[name="free_months_option"]:checked').val();
        let free_months = $('input[name="free_months"]').val().trim();

        let valid = true;

        if (!plan_name_english) {
            $('.plan_name_english_err').text("{{ __('admin_messages.enter_plan_name_in_english') }}");
            valid = false;
        }

        if (!plan_name_arabic) {
            $('.plan_name_arabic_err').text("{{ __('admin_messages.enter_plan_name_in_arabic') }}");
            valid = false;
        }

        if (!duration) {
            $('.duration_err').text("{{ __('admin_messages.enter_duration') }}");
            valid = false;
        }

        if (!duration_type) {
            $('.duration_type_err').text("{{ __('admin_messages.select_duration_type') }}");
            valid = false;
        }

        if (!no_of_videos) {
            $('.no_of_videos_err').text("{{ __('admin_messages.enter_no_of_videos') }}");
            valid = false;
        }

        if (product_type == '0' && !no_of_products) {
            $('.no_of_products_err').text("{{ __('admin_messages.enter_no_of_products') }}");
            valid = false;
        }

        if (!no_of_highlights) {
            $('.no_of_highlights_err').text("{{ __('admin_messages.enter_no_of_highlights') }}");
            valid = false;
        }

        if (!no_of_employee) {
            $('.no_of_employee_err').text("{{ __('admin_messages.enter_no_of_employees') }}");
            valid = false;
        }

        if (!stories) {
            $('.stories_err').text('Please Select Stories');
            valid = false;
        }

        if (!price) {
            $('.price_err').text("{{ __('admin_messages.enter_plan_price') }}");
            valid = false;
        }

        if (!commission) {
            $('.commission_err').text('Please Select Commission');
            valid = false;
        }

        if (commission === 'yes' && !commission_percentage) {
            $('.commission_percentage_err').text("{{ __('admin_messages.enter_commission_percentage') }}");
            valid = false;
        }

        if (duration_type === '1' && parseInt(duration) > 11) {
            $('.duration_err').text("{{ __('admin_messages.duration_can_not_be_more_than_11_months') }}");
            valid = false;
        }

        // ✅ Free months validation
        if (free_months_option == '1') {

            if (!free_months) {
                $('.free_months_err').text("{{ __('admin_messages.enter_no_of_free_months') }}");
                valid = false;
            }

            if (duration_type === '1') {
                $('.free_months_err').text("{{ __('admin_messages.you_can_not_provide_free_months_for_monthly_plan') }}");
                valid = false;
            }

            if (duration_type === '2' && parseInt(free_months) > 11) {
                $('.free_months_err').text("{{ __('admin_messages.duration_can_not_be_more_than_11_months') }}");
                valid = false;
            }
        }

        if (!valid) return;

        let formData = {
            plan_name_english: plan_name_english,
            plan_name_arabic: plan_name_arabic,
            duration: duration,
            duration_type: duration_type,
            no_of_videos: no_of_videos,
            product_type: product_type,
            no_of_highlights: no_of_highlights,
            no_of_employee: no_of_employee,
            stories: stories,
            price: price,
            commission: commission,
            commission_percentage: commission_percentage,
            country_id: country_id,
            is_recommended_store: is_recommended_store,

            // Free months
            is_free_months: free_months_option,
            no_of_free_months: free_months_option == '1' ? free_months : 0
        };

        if (product_type == '0') {
            formData.no_of_products = no_of_products;
        }

        console.log(formData);

        $.ajax({
            url: "{{ route('admin.add_plan') }}",
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status === 'success') {
                    toastr.success(response.message);
                    setTimeout(() => {
                        $('#sentModal2').modal('hide');
                        location.reload();
                    }, 2000);
                } else {
                    toastr.error(response.message || 'Something went wrong', 'Error');
                }
            },
            error: function(xhr) {
                toastr.error('Something went wrong! Please try again.', 'Error');
                console.log(xhr.responseText);
            }
        });
    });

    // Trigger defaults
    $('select[name="duration_type"]').trigger('change');
    $('input[name="product_type"]:checked').trigger('change');
    $('input[name="free_months_option"]:checked').trigger('change');

});
</script>


<!-- page refresh while closing add modal -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('sentModal2');
    modal.addEventListener('hidden.bs.modal', function() {
        location.reload();
    });
    var modal = document.getElementById('editModal');
    modal.addEventListener('hidden.bs.modal', function() {
        location.reload();
    });
});
</script>



<!-- <script>
$(document).ready(function() {

    // When edit button is clicked
    $(document).on('click', '[data-bs-target="#editModal"]', function() {
        var button = $(this);
        var modal = $('#editModal');

        // --- Get all data attributes ---
        var plan_id = button.data('plan-id');
        var english_name = button.data('english-name');
        var arabic_name = button.data('arabic-name');
        var duration = button.data('duration');
        var duration_type = button.data('duration-type');
        var new_duration = button.data('new-duration');
        var new_duration_type = button.data('new-duration-type');
        var no_of_videos = button.data('no-of-videos');
        var no_of_products = button.data('no-of-products');
        var no_of_highlights = button.data('no-of-highlights');
        var no_of_employees = button.data('no-of-employees');
        var price = button.data('price');
        var discounted_price = button.data('discounted-price');
        var stories = button.data('stories'); // 0=no, 1=yes
        var commission = button.data('commission'); // 0=no, 1=yes
        var commission_percentage = button.data('commission-percentage');
        var product_type = button.data('product-type'); // 0=defined, 1=unlimited
        var is_free_months = button.data('free-months-option'); // 0=no, 1=yes
        var free_months = button.data('free-months');

        // --- Set input values ---
        modal.find('input[name="plan_id"]').val(plan_id);
        modal.find('input[name="plan_name_english"]').val(english_name);
        modal.find('input[name="plan_name_arabic"]').val(arabic_name);
        modal.find('input[name="duration"]').val(duration);
        modal.find('select[name="duration_type"]').val(duration_type);
        modal.find('input[name="new_duration"]').val(new_duration);
        modal.find('select[name="new_duration_type"]').val(new_duration_type);
        modal.find('input[name="no_of_videos"]').val(no_of_videos);
        modal.find('input[name="no_of_products"]').val(no_of_products);
        modal.find('input[name="no_of_highlights"]').val(no_of_highlights);
        modal.find('input[name="no_of_employee"]').val(no_of_employees);
        modal.find('input[name="price"]').val(price);
        modal.find('input[name="discounted_price"]').val(discounted_price);

        // --- Stories ---
        modal.find('input[name="stories"]').prop('checked', false);
        var storiesVal = stories == 1 ? 'yes' : 'no';
        modal.find('input[name="stories"][value="' + storiesVal + '"]').prop('checked', true);

        // --- Commission ---
        modal.find('input[name="commission"]').prop('checked', false);
        var commissionVal = commission == 1 ? 'yes' : 'no';
        modal.find('input[name="commission"][value="' + commissionVal + '"]').prop('checked', true);
        if (commissionVal === 'yes') {
            modal.find('.commissionInput').show();
            modal.find('input[name="commission_percentage"]').val(commission_percentage);
        } else {
            modal.find('.commissionInput').hide();
            modal.find('input[name="commission_percentage"]').val('');
        }

        // --- Product Type ---
        modal.find('input[name="product_type"]').prop('checked', false);
        modal.find('input[name="product_type"]').each(function() {
            if ($(this).val() == String(product_type)) {
                $(this).prop('checked', true);
            }
        });
        if (product_type == 1) {
            modal.find('#productsInput').hide();
            modal.find('input[name="no_of_products"]').val('');
        } else {
            modal.find('#productsInput').show();
        }

        // --- Free Months ---
        modal.find('input[name="is_free_months"]').prop('checked', false);
        modal.find('input[name="is_free_months"][value="' + String(is_free_months) + '"]').prop('checked', true);
        if (is_free_months == 1) {
            modal.find('#freeMonthsInput').show();
            modal.find('input[name="no_of_free_months"]').val(free_months);
        } else {
            modal.find('#freeMonthsInput').hide();
            modal.find('input[name="no_of_free_months"]').val('');
        }

        // --- Duration readonly for years ---
        if (duration_type == '2') {
            modal.find('input[name="duration"]').prop('readonly', true);
        } else {
            modal.find('input[name="duration"]').prop('readonly', false);
        }
    });

    // --- Duration type change ---
    $(document).on('change', 'select[name="duration_type"]', function() {
        let durationType = $(this).val();
        let durationInput = $(this).closest('.modal').find('input[name="duration"]');
        if (durationType === '2') {
            durationInput.val(1);
            durationInput.prop('readonly', true);
        } else {
            durationInput.val('');
            durationInput.prop('readonly', false);
        }
    });

    // --- Product type toggle ---
    $(document).on('change', 'input[name="product_type"]', function() {
        let type = $(this).val();
        let modal = $(this).closest('.modal');
        if (type == '1') {
            modal.find('#productsInput').hide();
            modal.find('input[name="no_of_products"]').val('');
            modal.find('.no_of_products_err').text('');
        } else {
            modal.find('#productsInput').show();
        }
    });

    // --- Commission toggle ---
    $(document).on('change', 'input[name="commission"]', function() {
        let modal = $(this).closest('.modal');
        if ($(this).val() === 'yes') {
            modal.find('.commissionInput').show();
        } else {
            modal.find('.commissionInput').hide();
            modal.find('input[name="commission_percentage"]').val('');
            modal.find('.commission_percentage_err').text('');
        }
    });

    // --- Free months toggle ---
    $(document).on('change', 'input[name="is_free_months"]', function() {
        let modal = $(this).closest('.modal');
        if ($(this).val() === '1') {
            modal.find('#freeMonthsInput').show();
        } else {
            modal.find('#freeMonthsInput').hide();
            modal.find('input[name="no_of_free_months"]').val('');
            modal.find('.free_months_err').text('');
        }
    });

    // --- Form submit ---
    $(document).on('submit', '.editPlanForm', function(e) {
        e.preventDefault();
        var form = $(this);
        var modal = form.closest('.modal');
        modal.find('.error-text').text('');

        var formData = form.serializeArray().reduce((obj, item) => {
            obj[item.name] = item.value.trim();
            return obj;
        }, {});

        // --- Validation ---
        let valid = true;
        if (!formData.plan_name_english) { modal.find('.plan_name_english_err').text('Please Enter Plan Name (English)'); valid = false; }
        if (!formData.plan_name_arabic) { modal.find('.plan_name_arabic_err').text('Please Enter Plan Name (Arabic)'); valid = false; }
        if (!formData.duration) { modal.find('.duration_err').text('Please Enter Duration'); valid = false; }
        if (!formData.duration_type) { modal.find('.duration_type_err').text('Please Select Duration Type'); valid = false; }
        if (!formData.no_of_videos) { modal.find('.no_of_videos_err').text('Please Enter Number Of Videos'); valid = false; }
        if (formData.product_type == '0' && !formData.no_of_products) { modal.find('.no_of_products_err').text('Please Enter Number Of Products'); valid = false; }
        if (!formData.no_of_highlights) { modal.find('.no_of_highlights_err').text('Please Enter Number Of Highlights'); valid = false; }
        if (!formData.no_of_employee) { modal.find('.no_of_employee_err').text('Please Enter Number Of Employees'); valid = false; }
        if (!formData.stories) { modal.find('.stories_err').text('Please Select Stories'); valid = false; }
        if (!formData.price) { modal.find('.price_err').text('Please Enter Charges'); valid = false; }
        if (!formData.commission) { modal.find('.commission_err').text('Please Select Commission'); valid = false; }
        if (formData.commission === 'yes' && !formData.commission_percentage) { modal.find('.commission_percentage_err').text('Please Enter Commission Percentage'); valid = false; }
        if (formData.is_free_months === '1') {
            if (!formData.no_of_free_months) { modal.find('.free_months_err').text('Please enter free months'); valid = false; }
            if (formData.duration_type === '1') { modal.find('.free_months_err').text("You can't provide free months for Monthly plan"); valid = false; }
            if (formData.duration_type === '2' && parseInt(formData.no_of_free_months) > 11) { modal.find('.free_months_err').text('No of months should not be greater than 11'); valid = false; }
        }

        if (!valid) return;

        // --- AJAX submit ---
        $.ajax({
            url: "{{ route('admin.update_plan') }}",
            method: "POST",
            data: formData,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: function(response) {
                if (response.status === 'success') {
                    toastr.success(response.message);
                    setTimeout(() => {
                        modal.modal('hide');
                        location.reload();
                    }, 1500);
                } else {
                    toastr.error(response.message || 'Failed to update plan');
                }
            },
            error: function(xhr) {
                toastr.error('Something went wrong! Please try again.');
                console.log(xhr.responseText);
            }
        });
    });

});
</script> -->

<script>
$(document).ready(function() {

    // --- Open Edit Modal ---
    $(document).on('click', '[data-bs-target="#editModal"]', function() {
        var button = $(this);
        var modal = $('#editModal');

        // --- Get all data attributes ---
        var plan_id = button.data('plan-id');
        var english_name = button.data('english-name');
        var arabic_name = button.data('arabic-name');
        var duration = button.data('duration');
        var duration_type = button.data('duration-type');
        var new_duration = button.data('new-duration');
        var new_duration_type = button.data('new-duration-type');
        var no_of_videos = button.data('no-of-videos');
        var no_of_products = button.data('no-of-products');
        var no_of_highlights = button.data('no-of-highlights');
        var no_of_employees = button.data('no-of-employees');
        var price = button.data('price');
        var discount_price = button.data('discounted-price');
        var stories = button.data('stories'); // 0 = no, 1 = yes
        var commission = button.data('commission'); // 0 = no, 1 = yes
        var commission_percentage = button.data('commission-percentage');
        var product_type = button.data('product-type'); // 0 = defined, 1 = unlimited
        var free_months_option = button.data('free-months-option'); // 0 = no, 1 = yes
        var free_months = button.data('free-months');
        var is_recommended_store = button.data('is-recommended-store');

        // --- Set basic inputs ---
        modal.find('input[name="plan_id"]').val(plan_id);
        modal.find('input[name="plan_name_english"]').val(english_name);
        modal.find('input[name="plan_name_arabic"]').val(arabic_name);
        modal.find('input[name="duration"]').val(duration);
        modal.find('select[name="duration_type"]').val(duration_type);
        modal.find('input[name="new_duration"]').val(new_duration);
        modal.find('select[name="new_duration_type"]').val(new_duration_type);
        modal.find('input[name="no_of_videos"]').val(no_of_videos);
        modal.find('input[name="no_of_products"]').val(no_of_products);
        modal.find('input[name="no_of_highlights"]').val(no_of_highlights);
        modal.find('input[name="no_of_employee"]').val(no_of_employees);
        modal.find('input[name="price"]').val(price);
        modal.find('input[name="discounted_price"]').val(discount_price);

        // --- Stories ---
        modal.find('input[name="stories"]').prop('checked', false);
        modal.find('input[name="stories"][value="' + (stories == 1 ? 'yes' : 'no') + '"]').prop('checked', true);

        modal.find('input[name="is_recommended_store"]').prop('checked', false);
        modal.find('input[name="is_recommended_store"][value="' + (is_recommended_store == 1 ? 'yes' : 'no') + '"]').prop('checked', true);

        // --- Commission ---
        modal.find('input[name="commission"]').prop('checked', false);
        var commissionVal = commission == 1 ? 'yes' : 'no';
        modal.find('input[name="commission"][value="' + commissionVal + '"]').prop('checked', true);
        if (commissionVal === 'yes') {
            modal.find('.commissionInput').show();
            modal.find('input[name="commission_percentage"]').val(commission_percentage);
        } else {
            modal.find('.commissionInput').hide();
            modal.find('input[name="commission_percentage"]').val('');
        }

        // --- Product Type ---
        modal.find('input[name="product_type"]').prop('checked', false);
        modal.find('input[name="product_type"]').each(function() {
            if ($(this).val() === String(product_type)) {
                $(this).prop('checked', true);
            }
        });
        if (product_type == 1) { // Unlimited
            modal.find('#productsInput').hide();
            modal.find('input[name="no_of_products"]').val('');
        } else {
            modal.find('#productsInput').show();
        }

        // --- Free Months ---
        modal.find('input[name="free_months_option"]').prop('checked', false);
        modal.find('input[name="free_months_option"][value="' + String(free_months_option) + '"]').prop('checked', true);
        if (free_months_option == 1) {
            modal.find('#freeMonthsInput').show();
            modal.find('input[name="free_months"]').val(free_months);
        } else {
            modal.find('#freeMonthsInput').hide();
            modal.find('input[name="free_months"]').val('');
        }

        // --- Handle readonly for duration if years ---
        if (duration_type == '2') {
            modal.find('input[name="duration"]').prop('readonly', true);
        } else {
            modal.find('input[name="duration"]').prop('readonly', false);
        }
    });

    // --- Duration Type Change ---
    $(document).on('change', 'select[name="duration_type"]', function() {
        let durationType = $(this).val();
        let durationInput = $(this).closest('.modal').find('input[name="duration"]');
        if (durationType === '2') {
            durationInput.val(1).prop('readonly', true);
        } else {
            durationInput.val('').prop('readonly', false);
        }
    });

    // --- Product Type Change ---
    $(document).on('change', 'input[name="product_type"]', function() {
        let type = $(this).val();
        let modal = $(this).closest('.modal');
        if (type == '1') {
            modal.find('#productsInput').hide();
            modal.find('input[name="no_of_products"]').val('');
        } else {
            modal.find('#productsInput').show();
        }
    });

    // --- Commission Change ---
    $(document).on('change', 'input[name="commission"]', function() {
        let modal = $(this).closest('.modal');
        if ($(this).val() === 'yes') {
            modal.find('.commissionInput').show();
        } else {
            modal.find('.commissionInput').hide();
            modal.find('input[name="commission_percentage"]').val('');
        }
    });

    // --- Free Months Change ---
    $(document).on('change', 'input[name="free_months_option"]', function() {
        let modal = $(this).closest('.modal');
        if ($(this).val() == '1') {
            modal.find('#freeMonthsInput').show();
        } else {
            modal.find('#freeMonthsInput').hide();
            modal.find('input[name="free_months"]').val('');
        }
    });

    // --- Submit Form ---
    $(document).on('submit', '.editPlanForm', function(e) {
        e.preventDefault();
        var form = $(this);
        var modal = form.closest('.modal');

        // Clear previous errors
        modal.find('.error-text').text('');

        // --- Collect Form Data ---
        var formData = form.serializeArray().reduce((obj, item) => {
            obj[item.name] = item.value.trim();
            return obj;
        }, {});

        // Add missing fields explicitly
        formData['new_duration'] = modal.find('input[name="new_duration"]').val().trim();
        formData['new_duration_type'] = modal.find('select[name="new_duration_type"]').val();
        formData['discounted_price'] = modal.find('input[name="discounted_price"]').val().trim();
        formData['is_free_months'] = modal.find('input[name="free_months_option"]:checked').val() || '0';
        formData['no_of_free_months'] = modal.find('input[name="free_months"]').val().trim();

        // --- Validation ---
        let valid = true;
        if (!formData.plan_name_english) { modal.find('.plan_name_english_err').text("{{ __('admin_messages.enter_plan_name_in_english') }}"); valid = false; }
        if (!formData.plan_name_arabic) { modal.find('.plan_name_arabic_err').text("{{ __('admin_messages.enter_plan_name_in_arabic') }}"); valid = false; }
        if (!formData.duration) { modal.find('.duration_err').text("{{ __('admin_messages.enter_duration') }}"); valid = false; }
        if (!formData.duration_type) { modal.find('.duration_type_err').text("{{ __('admin_messages.select_duration_type') }}"); valid = false; }
        if (!formData.no_of_videos) { modal.find('.no_of_videos_err').text("{{ __('admin_messages.enter_no_of_videos') }}"); valid = false; }
        if (formData.product_type == '0' && !formData.no_of_products) { modal.find('.no_of_products_err').text("{{ __('admin_messages.enter_no_of_products') }}"); valid = false; }
        if (!formData.no_of_highlights) { modal.find('.no_of_highlights_err').text("{{ __('admin_messages.enter_no_of_highlights') }}"); valid = false; }
        if (!formData.no_of_employee) { modal.find('.no_of_employee_err').text("{{ __('admin_messages.enter_no_of_employees') }}"); valid = false; }
        if (!formData.stories) { modal.find('.stories_err').text('Please Select Stories'); valid = false; }
        if (!formData.price) { modal.find('.price_err').text("{{ __('admin_messages.enter_plan_price') }}"); valid = false; }
        if (!formData.commission) { modal.find('.commission_err').text('Please Select Commission'); valid = false; }
        if (formData.commission === 'yes' && !formData.commission_percentage) { modal.find('.commission_percentage_err').text("{{ __('admin_messages.enter_commission_percentage') }}"); valid = false; }

        if (formData.is_free_months === '1') {
            if (!formData.no_of_free_months) { modal.find('.free_months_err').text("{{ __('admin_messages.enter_no_of_free_months') }}"); valid = false; }
            if (formData.duration_type === '1') { modal.find('.free_months_err').text("{{ __('admin_messages.you_can_not_provide_free_months_for_monthly_plan') }}"); valid = false; }
            if (formData.duration_type === '2' && parseInt(formData.no_of_free_months) > 11) { modal.find('.free_months_err').text("{{ __('admin_messages.duration_can_not_be_more_than_11_months') }}"); valid = false; }
        }

        if (!valid) return;

        // --- AJAX Submit ---
        $.ajax({
            url: "{{ route('admin.update_plan') }}",
            method: "POST",
            data: formData,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: function(response) {
                if (response.status === 'success') {
                    toastr.success(response.message);
                    setTimeout(() => {
                        modal.modal('hide');
                        location.reload();
                    }, 1500);
                } else {
                    toastr.error(response.message || 'Failed to update plan');
                }
            },
            error: function(xhr) {
                toastr.error('Something went wrong! Please try again.');
                console.log(xhr.responseText);
            }
        });
    });

});
</script>





