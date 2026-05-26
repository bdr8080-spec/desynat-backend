@extends('admin.layout.app')
@section('content')

<style>
    a.btn.btn-dark.customBtn {
    border: 1px solid rgba(168, 130, 79, 1);
    background: linear-gradient(to bottom left, #F9DBAB, #7D532F);
    color: #fff;
    line-height: 22px;
    font-size: 18px;
    padding: 10px;
}
</style>

<div id="content-wrapper" class="d-flex flex-column position-relative">
    <div id="content" class="">


        <div class="inner-content management">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="d-flex align-items-center gap-3 mt-2">
                        <div class="arrow">
                            <a class="table-button" type="button" href="{{route('admin.shippingManagement')}}">
                                <i class="fas fa-angle-left"></i>
                            </a>
                        </div>
                        <h6 class="m-0">
                            @if(app()->getLocale() == 'en')
                            {{$country->name}}
                            @else
                            {{$country->name_ar}}
                            @endif
                        </h6>
                    </div>
                </div>

                <div class="col-lg-6 col-md-4 col-12">
                    <div class="d-flex justify-content-end gap-2  align-items-center">
                         <div class="">
                            <div class="form-group mgtrtl">
                                <label class="form-label">{{ __('admin_messages.default_delivery_charge') }}</label>
                                <div style="position: relative;">
                                    <input type="text" id="default_shipping_fee_display" class="form-control" placeholder="{{ __('admin_messages.enter_tax') }}" data-bs-toggle="modal" data-bs-target="#sentModal1" value="{{$defaultShippingCharge->shipping_fee}}" readOnly/>
                                    <span style=" position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #6c757d; pointer-events: none; font-weight: 500; " >
                                     <i class="bi bi-pencil-square" ></i>
                                    </span>

                                </div>
                            </div>
                        </div>
                        <a class="btn btn-dark customBtn mt-4" data-bs-toggle="modal" data-bs-target="#sentModal2">
                            <span>{{ __('admin_messages.add_delivery_charges') }}</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="userManagecontent mt-5">
                <div class="">

                    <div class="table-responsive w-100">
                        <table id="myTable" class="table w-100">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('admin_messages.s_no') }}</th>
                                    <th scope="col">{{ __('admin_messages.range_from_to_to_km') }}</th>
                                    <th scope="col">{{ __('admin_messages.shipping_price') }}</th>
                                    <th scope="col">{{ __('admin_messages.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($shippingCharges as $key => $charge)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>{{ rtrim(rtrim(number_format($charge['range_from'], 2, '.', ''), '0'), '.') }}{{ __('admin_messages.km') }}
                                        {{ __('admin_messages.to') }}
                                        {{ rtrim(rtrim(number_format($charge['range_to'], 2, '.', ''), '0'), '.') }}{{ __('admin_messages.km') }}
                                    </td>

                                    <td>{{ rtrim(rtrim(number_format($charge['shipping_fee'], 2, '.', ''), '0'), '.') }}
                                        {{ __('admin_messages.kd') }}</td>
                                    <td>
                                        <div class="d-flex gap-3 justify-content-center">
                                            <a class="table-button editShippingBtn" data-id="{{ $charge['id'] }}"
                                                data-from="{{ $charge['range_from'] }}"
                                                data-to="{{ $charge['range_to'] }}"
                                                data-fee="{{ $charge['shipping_fee'] }}" data-bs-toggle="modal"
                                                data-bs-target="#sentModal3">

                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <!-- Delete button  -->
                                            <a href="javascript:void(0);"
                                                class="table-button text-danger deleteShippingCharge mt-1 mb-1"
                                                data-id="{{ $charge->id }}">
                                                <i class="bi bi-trash3-fill"></i>
                                            </a>

                                            <!-- Toggle switch -->
                                            <div class="form-check form-switch">
                                                <input class="form-check-input toggleStatus" type="checkbox"
                                                    role="switch" id="switch{{ $charge->id }}"
                                                    data-id="{{ $charge->id }}"
                                                    {{ $charge->status == 1 ? 'checked' : '' }} />
                                            </div>
                                        </div>

                                    </td>

                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">{{ __('admin_messages.no_data_found') }}</td>
                                </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Shipping Fee Modal -->
<!-- <div class="modal fade" id="sentModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Edit</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <div class="row">
                        <div class="col-lg-12 col-md-6">
                            <div class="form-group">
                                <div style="position: relative;">
                                    <input type="text" class="form-control" placeholder="60 KD" />
                                  

                                </div>
                            </div>
                        </div>
                      

                      
                        <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                            <a type="button" class="btn btn-dark customBtn mt-3">
                                Update
                            </a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div> -->
<div class="modal fade" id="sentModal1" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">{{ __('admin_messages.edit') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
     
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" id="id" name="id" value="{{ $defaultShippingCharge->id }}">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <div style="position: relative;">
                                <input type="text"
                                       id="default_shipping_fee_input"
                                       class="form-control"
                                       placeholder="{{ __('admin_messages.enter_delivery_price') }}" />
                            </div>
                            <small id="defaultShippingFeeError"
                                   style="color:red; display:none;"></small>
                        </div>
                    </div>

                    <div class="col-lg-12 d-flex justify-content-center">
                        <button type="button"
                                id="updateDefaultShippingBtn"
                                class="btn btn-dark customBtn mt-3">
                            {{ __('admin_messages.update') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="sentModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">{{ __('admin_messages.add_delivery_charges') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <div class="row">

                        <input type="hidden" id="country_id" name="country_id" value="{{ $country->id }}">

                        <!-- Range Section -->
                        <!-- <div class="col-lg-12 col-md-12 col-12">
                            <label class="form-label  mb-4">Range</label>
                            <div class="form-group">
                                <div class="row">

                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">From</label>
                                            <div style="position: relative;">
                                                <input type="text" name="range_from"
                                                    oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^(\d{7}).*/,'$1')"
                                                    class="form-control" placeholder="Enter range from" />
                                                <span style="
                                                        position: absolute;
                                                        right: 12px;
                                                        top: 50%;
                                                        transform: translateY(-50%);
                                                        color: #6c757d;
                                                        pointer-events: none;
                                                        font-weight: 500;
                                                    ">
                                                    KM
                                                </span>

                                            </div>
                                            <span id="rangeFromError" class="text-danger" style="display:none"></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">To</label>
                                            <div style="position: relative;">
                                                <input type="text" name="range_to"
                                                    oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'').replace(/^(\d{7}).*/,'$1')"
                                                    class="form-control" placeholder="Enter range to" />
                                                <span style="
                                                        position: absolute;
                                                        right: 12px;
                                                        top: 50%;
                                                        transform: translateY(-50%);
                                                        color: #6c757d;
                                                        pointer-events: none;
                                                        font-weight: 500;
                                                    ">
                                                    KM
                                                </span>

                                            </div>
                                            <span id="rangeToError" class="text-danger" style="display:none"></span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div> -->

                        <div class="col-lg-6">

                        </div>

                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group">
                                <h5 class="form-label">{{ __('admin_messages.range') }}-</h5>

                                <div class="d-flex align-items-center gap-4 ">

                                    <!-- From -->
                                    <div class="d-flex align-items-center" style="gap: 10px;">
                                        <label class="form-label mb-0">{{ __('admin_messages.from') }}</label>
                                        <div class="mgtrtl" style="position: relative; ">
                                            <input type="text" name="range_from"
                                                oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^(\d{7}).*/,'$1')"
                                                class="form-control" placeholder="{{ __('admin_messages.enter_from') }}" />
                                            <span style="
                                                            position: absolute;
                                                            right: 12px;
                                                            top: 50%;
                                                            transform: translateY(-50%);
                                                            color: #6c757d;
                                                            pointer-events: none;
                                                            font-weight: 500;
                                                        ">
                                                {{ __('admin_messages.km') }}
                                            </span>

                                        </div>
                                        <!-- <span id="rangeFromError" class="text-danger" style="display:none"></span> -->

                                    </div>
                                    <div class="d-flex align-items-center" style="gap: 10px;">
                                        <label class="form-label mb-0">{{ __('admin_messages.to') }}</label>
                                        <div class="mgtrtl" style="position: relative;">
                                            <input type="text" name="range_to"
                                                oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'').replace(/^(\d{7}).*/,'$1')"
                                                class="form-control" placeholder="{{ __('admin_messages.enter_to') }}" />
                                            <span style="
                                                            position: absolute;
                                                            right: 12px;
                                                            top: 50%;
                                                            transform: translateY(-50%);
                                                            color: #6c757d;
                                                            pointer-events: none;
                                                            font-weight: 500;
                                                        ">
                                                {{ __('admin_messages.km') }}
                                            </span>

                                        </div>
                                        <!-- <span id="rangeToError" class="text-danger" style="display:none"></span> -->


                                    </div>
                                </div>
                                <div class="d-flex align-items-center " style="justify-content: space-between;">
                                    <span id="rangeFromError" class="text-danger" style="display:none"></span>


                                    <span id="rangeToError" class="text-danger" style="display:none"></span>

                                </div>

                            </div>

                        </div>


                        <!-- Shipping Fee -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group mt-2">
                                <label class="form-label">{{ __('admin_messages.enter_delivery_price') }}</label>
                                <input type="text" name="shipping_fee"
                                    oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/^0+([1-9])/,'$1').replace(/(\..*?)\..*/,'$1').replace(/(\.\d{2}).*/,'$1').replace(/^(\d{7})\d*/,'$1').replace(/^(\d{7}\.\d{2})\d*/,'$1')"
                                    class="form-control" placeholder="{{ __('admin_messages.enter_delivery_price') }}" />
                                <span id="shippingFeeError" class="text-danger" style="display:none"></span>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                            <a type="button" id="submitBrandBtn" class="btn btn-dark customBtn mt-3">
                                {{ __('admin_messages.submit') }}
                            </a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Edit Shipping Fee Modal -->
<div class="modal fade" id="sentModal3" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header management border-0">
                <h2 class="h2">{{ __('admin_messages.edit_delivery_charges') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <div class="row">

                        <input type="hidden" id="edit_charge_id">
                        <input type="hidden" id="edit_country_id" value="{{ $country->id }}">

                        <!-- Range -->
                        <!-- <div class="col-lg-12 col-md-12 col-12">
                            <label class="form-label mb-4">Range</label>
                            <div class="form-group">

                                <div class="row">

                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">From</label>
                                            <div style="position: relative;">
                                                <input type="text" id="edit_range_from"
                                                    oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^(\d{7}).*/,'$1')"
                                                    class="form-control" placeholder="Enter range from">
                                                <span style="
                                                            position: absolute;
                                                            right: 12px;
                                                            top: 50%;
                                                            transform: translateY(-50%);
                                                            color: #6c757d;
                                                            pointer-events: none;
                                                            font-weight: 500;
                                                        ">
                                                    KM
                                                </span>
                                            </div>
                                            <span id="editRangeFromError" class="text-danger"
                                                style="display:none"></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">To</label>
                                            <div style="position: relative;">
                                                <input type="text" id="edit_range_to"
                                                    oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'').replace(/^(\d{7}).*/,'$1')"
                                                    class="form-control" placeholder="Enter range to">

                                                <span style="
                                                                position: absolute;
                                                                right: 12px;
                                                                top: 50%;
                                                                transform: translateY(-50%);
                                                                color: #6c757d;
                                                                pointer-events: none;
                                                                font-weight: 500;
                                                            ">
                                                    KM
                                                </span>
                                            </div>
                                            <span id="editRangeToError" class="text-danger" style="display:none"></span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div> -->


                        <div class="col-lg-12 col-md-12 col-12">
                            <label class="form-label mb-3">{{ __('admin_messages.range') }}</label>

                            <div class="d-flex align-items-center gap-4 flex-wrap">

                                <!-- From -->
                                <div class="d-flex align-items-center" style="gap: 10px;">
                                    <label class="form-label mb-0">{{ __('admin_messages.from') }}</label>
                                    <div class="mgtrtl" style="position: relative; width: 145px;">
                                        <input type="text" id="edit_range_from"
                                            oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'').replace(/^(\d{7}).*/,'$1')"
                                            class="form-control" placeholder="{{ __('admin_messages.enter_from') }}">
                                        <span style="
                                                        position: absolute;
                                                        right: 12px;
                                                        top: 50%;
                                                        transform: translateY(-50%);
                                                        color: #6c757d;
                                                        pointer-events: none;
                                                        font-weight: 500;
                                                    ">
                                            {{ __('admin_messages.km') }}
                                        </span>

                                    </div>
                                    <!-- <span id="editRangeFromError" class="text-danger" style="display:none"></span> -->

                                </div>
                                <div class="d-flex align-items-center" style="gap: 10px;">
                                    <label class="form-label mb-0">{{ __('admin_messages.to') }}</label>
                                    <div class="mgtrtl" style="position: relative; width: 145px;">
                                        <input type="text" id="edit_range_to"
                                            oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'').replace(/^(\d{7}).*/,'$1')"
                                            class="form-control" placeholder="{{ __('admin_messages.enter_to') }}">
                                        <span style="
                                                        position: absolute;
                                                        right: 12px;
                                                        top: 50%;
                                                        transform: translateY(-50%);
                                                        color: #6c757d;
                                                        pointer-events: none;
                                                        font-weight: 500;
                                                    ">
                                            {{ __('admin_messages.km') }}
                                        </span>

                                    </div>
                                    <!-- <span id="editRangeToError" class="text-danger" style="display:none"></span> -->


                                </div>
                            </div>
                            <div class="d-flex align-items-center " style="justify-content: space-between;">
                                <span id="editRangeFromError" class="text-danger" style="display:none"></span>


                                <span id="editRangeToError" class="text-danger" style="display:none"></span>

                            </div>

                        </div>

                        <!-- Shipping Fee -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group mt-2">
                                <label class="form-label">{{ __('admin_messages.enter_delivery_price') }}</label>
                                <input type="text" id="edit_shipping_fee"
                                    oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/^0+([1-9])/,'$1').replace(/(\..*?)\..*/,'$1').replace(/(\.\d{2}).*/,'$1').replace(/^(\d{7})\d*/,'$1').replace(/^(\d{7}\.\d{2})\d*/,'$1')"
                                    class="form-control" placeholder="{{ __('admin_messages.enter_delivery_price') }}">

                                <span id="editShippingFeeError" class="text-danger" style="display:none"></span>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                            <a id="updateShippingBtn" class="btn btn-dark customBtn mt-3">{{ __('admin_messages.update') }}</a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- Delete -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.deleteShippingCharge').forEach(button => {
        button.addEventListener('click', function() {
            let shippingId = this.getAttribute('data-id');

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
                    fetch(`/admin/deleteShippingCharge/${shippingId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status == "success") {
                                toastr.success(data.message);
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
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

<!-- Update Status -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.toggleStatus').forEach(toggle => {
        toggle.addEventListener('change', function() {
            let shippingId = this.getAttribute('data-id');

            fetch(`/admin/updateShippingChargeStatus/${shippingId}`, {
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

<!-- add -->
<script>
document.addEventListener("DOMContentLoaded", function() {

    const rangeFrom = document.querySelector("input[name='range_from']");
    const rangeTo = document.querySelector("input[name='range_to']");
    const shippingFee = document.querySelector("input[name='shipping_fee']");
    const countryId = document.getElementById("country_id");
    const submitBtn = document.getElementById("submitBrandBtn");

    const rangeFromError = document.getElementById("rangeFromError");
    const rangeToError = document.getElementById("rangeToError");
    const shippingFeeError = document.getElementById("shippingFeeError");

    // Remove errors on typing
    rangeFrom.addEventListener("input", () => rangeFromError.style.display = "none");
    rangeTo.addEventListener("input", () => rangeToError.style.display = "none");
    shippingFee.addEventListener("input", () => shippingFeeError.style.display = "none");

    submitBtn.addEventListener("click", function(e) {
        e.preventDefault();

        let hasError = false;

        // Validate Range From
        if (rangeFrom.value.trim() === "") {
            rangeFromError.innerText = "{{ __('admin_messages.please_enter_from') }}";
            rangeFromError.style.display = "block";
            hasError = true;
        }

        // Validate Range To
        if (rangeTo.value.trim() === "") {
            rangeToError.innerText = "{{ __('admin_messages.please_enter_to') }}";
            rangeToError.style.display = "block";
            hasError = true;
        }

        // Compare Ranges
        if (rangeFrom.value && rangeTo.value && Number(rangeTo.value) <= Number(rangeFrom.value)) {
            rangeToError.innerText = "{{ __('admin_messages.range_to_greater_than_from') }}";
            rangeToError.style.display = "block";
            hasError = true;
        }

        // Validate Shipping Fee
        if (shippingFee.value.trim() === "") {
            shippingFeeError.innerText = "{{ __('admin_messages.please_enter_delivery_price') }}";
            shippingFeeError.style.display = "block";
            hasError = true;
        } else if (isNaN(shippingFee.value.trim())) {
            shippingFeeError.innerText = "Shipping fee must be a number";
            shippingFeeError.style.display = "block";
            hasError = true;
        }

        if (hasError) return;

        // Data to send
        const dataToSend = {
            country_id: countryId.value,
            range_from: rangeFrom.value.trim(),
            range_to: rangeTo.value.trim(),
            shipping_fee: shippingFee.value.trim()
        };

        // AJAX Request
        fetch("/admin/add_shipping_fee", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify(dataToSend)
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {

                    toastr.success(data.message);

                    const modal = bootstrap.Modal.getInstance(document.getElementById(
                        "sentModal2"));
                    modal.hide();

                    // Reset form
                    rangeFrom.value = "";
                    rangeTo.value = "";
                    shippingFee.value = "";

                    setTimeout(() => location.reload(), 1500);

                } else {
                    toastr.error(data.message || "Failed to add shipping fee");
                }
            })
            .catch(() => {
                toastr.error("Something went wrong");
            });
    });

});
</script>

<!-- update -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const rangeFrom = document.getElementById("edit_range_from");
    const rangeTo = document.getElementById("edit_range_to");
    const shippingFee = document.getElementById("edit_shipping_fee");

    const idField = document.getElementById("edit_charge_id");
    const countryId = document.getElementById("edit_country_id");

    rangeFrom.addEventListener("input", function() {
        this.value = this.value.replace(/[^0-9]/g, '').replace(/^(\d{7}).*/, '$1');
    });

    rangeTo.addEventListener("input", function() {
        this.value = this.value.replace(/[^0-9]/g, '').replace(/^0+/, '').replace(/^(\d{7}).*/, '$1');
    });

    shippingFee.addEventListener("input", function() {
        this.value = this.value
            .replace(/[^0-9.]/g, '')
            .replace(/^0+([1-9])/, '$1')
            // .replace(/^0+$/, '')
            .replace(/(\..*?)\..*/, '$1')
            .replace(/(\.\d{2}).*/, '$1')
            .replace(/^(\d{7})\d*/, '$1')
            .replace(/^(\d{7}\.\d{2})\d*/, '$1');
    });

    const errFrom = document.getElementById("editRangeFromError");
    const errTo = document.getElementById("editRangeToError");
    const errFee = document.getElementById("editShippingFeeError");

    const updateBtn = document.getElementById("updateShippingBtn");

    function cleanNumber(value) {

        if (!value) return "";

        return value
            .toString()
            .replace(/\.00$/, ""); // remove .00 at end
    }

    document.querySelectorAll(".editShippingBtn").forEach(button => {

        button.addEventListener("click", function() {

            idField.value = this.dataset.id;

            rangeFrom.value = cleanNumber(this.dataset.from);
            rangeTo.value = cleanNumber(this.dataset.to);
            shippingFee.value = cleanNumber(this.dataset.fee);

            // remove error messages
            errFrom.style.display = "none";
            errTo.style.display = "none";
            errFee.style.display = "none";
        });
    });

    rangeFrom.oninput = () => errFrom.style.display = "none";
    rangeTo.oninput = () => errTo.style.display = "none";
    shippingFee.oninput = () => errFee.style.display = "none";

    updateBtn.addEventListener("click", function(e) {
        e.preventDefault();

        let hasError = false;

        // Validate range from
        if (rangeFrom.value.trim() === "") {
            errFrom.innerText = "{{ __('admin_messages.please_enter_from') }}";
            errFrom.style.display = "block";
            hasError = true;
        }

        // Validate range to
        if (rangeTo.value.trim() === "") {
            errTo.innerText = "{{ __('admin_messages.please_enter_to') }}";
            errTo.style.display = "block";
            hasError = true;
        }

        // Validate correct order
        if (rangeFrom.value && rangeTo.value && Number(rangeTo.value) <= Number(rangeFrom.value)) {
            errTo.innerText = "{{ __('admin_messages.range_to_greater_than_from') }}";
            errTo.style.display = "block";
            hasError = true;
        }

        // Validate shipping fee
        if (shippingFee.value.trim() === "") {
            errFee.innerText = "{{ __('admin_messages.please_enter_delivery_price') }}";
            errFee.style.display = "block";
            hasError = true;
        }

        if (hasError) return;

        const payload = {
            shipping_charge_id: idField.value,
            // country_id: countryId.value,
            range_from: rangeFrom.value,
            range_to: rangeTo.value,
            shipping_fee: shippingFee.value
        };

        fetch("/admin/update_shipping_fee", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {

                if (data.status === "success") {

                    toastr.success(data.message);

                    const modal = bootstrap.Modal.getInstance(
                        document.getElementById("sentModal3")
                    );

                    modal.hide();

                    setTimeout(() => location.reload(), 1500);
                } else {
                    toastr.error(data.message || "Failed to update shipping fee");
                }
            })
            .catch(() => {
                toastr.error("Something went wrong");
            });

    });

});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('sentModal2');
    modal.addEventListener('hidden.bs.modal', function() {
        location.reload();
    });
});
</script>

<!-- update default shipping fee -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const modalElement = document.getElementById("sentModal1");
    const displayInput = document.getElementById("default_shipping_fee_display");
    const modalInput = document.getElementById("default_shipping_fee_input");
    const updateBtn = document.getElementById("updateDefaultShippingBtn");
    const errorField = document.getElementById("defaultShippingFeeError");
    const idField = document.getElementById("id"); 

    // Allow only numbers and 2 decimals
    modalInput.addEventListener("input", function () {
        this.value = this.value
            .replace(/[^0-9.]/g, '')          // allow numbers & dot
            .replace(/(\..*?)\..*/, '$1')     // single dot only
            //.replace(/^0+/, '')               //  remove starting 0 completely
            .replace(/(\.\d{2}).*/, '$1');    // limit 2 decimals

        errorField.style.display = "none";
    });

    modalElement.addEventListener("show.bs.modal", function () {
        modalInput.value = displayInput.value;
        errorField.style.display = "none";
    });

    updateBtn.addEventListener("click", function () {

        if (modalInput.value.trim() === "") {
            errorField.innerText = "{{ __('admin_messages.please_enter_delivery_price') }}";
            errorField.style.display = "block";
            return;
        }

        fetch("{{ route('admin.update_default_shipping_fee') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                id: idField.value,              
                shipping_fee: modalInput.value
            })
        })
        .then(res => res.json())
        .then(data => {

            if (data.status === "success") {

                toastr.success(data.message);

                const modal = bootstrap.Modal.getInstance(modalElement);
                modal.hide();

                setTimeout(() => location.reload(), 1500);

            } else {
                toastr.error(data.message || "Failed to update delivery charge");
            }

        })
        .catch(() => {
            toastr.error("Something went wrong");
        });

    });

});
</script>






@endsection