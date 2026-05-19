@extends('admin.layout.app')
@section('content')

<style>
    .card-body {
    background: #6c757d0a;
}
</style>

<div class="inner-content management">
    <div class="d-flex flex-column align-items-start back-btn-box">

        <div class="d-flex align-items-center gap-3 mt-2">
            <div class="arrow">
                <a href="{{route('admin.promoCodeManagement')}}" class="table-button " type="button">
                    <i class="fas fa-angle-left"></i>
                </a>
            </div>
            <h2 class="h2 text-start">{{ __('admin_messages.edit_promo_code') }}</h2>

        </div>
        <div class="content">
            <div class="card p-3 mt-4">
                <div class="card-body">
                    <form id="updatePromocodeForm" method="POST">
                        @csrf
                        
                        <div class="row">
                            <input type="hidden" id="promocode_id" value="{{  $promoCode->id }}">
                            <!-- Country Select -->
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin_messages.select_country') }}</label>
                                    <select name="country_id" id="update_country_id" class="form-select">
                                        <option value="">{{ __('admin_messages.select_country') }}</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" 
                                                @if($country->id == $promoCode->country_id) selected @endif>
                                                @if(app()->getLocale() == 'en')
                                                {{ $country->name }}
                                                @else
                                                {{ $country->name_ar }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="update_countryError" class="text-danger small" style="display:none;"></div>
                                </div>
                            </div>

                            <!-- Promocode Name English -->
                            <div class="col-lg-6 col-md-12 col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('admin_messages.promocode_name_english') }}</label>
                                    <input type="text" id="update_nameEnglish" oninput="this.value = this.value.replace(/[^A-Za-z0-9 ]/g,'').replace(/^\s+/,'')" name="name_english"
                                        class="form-control" placeholder="{{ __('admin_messages.please_enter_promocode_name_in_english') }}" 
                                        value="{{ old('name_english', $promoCode->name_english) }}" />
                                    <div id="update_nameEnglishError" class="text-danger small" style="display:none;"></div>
                                </div>
                            </div>

                            <!-- Promocode Name Arabic -->
                            <div class="col-lg-6 col-md-12 col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('admin_messages.promocode_name_arabic') }}</label>
                                    <input type="text" id="update_nameArabic" name="name_arabic" oninput="this.value=this.value.replace(/[^0-9\u0600-\u06FF ]/g,'').replace(/^\s+/,'')"
                                        class="form-control" placeholder="{{ __('admin_messages.please_enter_promocode_name_in_arabic') }}" 
                                        value="{{ old('name_arabic', $promoCode->name_arabic) }}" />
                                    <div id="update_nameArabicError" class="text-danger small" style="display:none;"></div>
                                </div>
                            </div>

                            <!-- Description English -->
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="mb-3">
                                    <label for="update_descriptionEnglish" class="form-label">{{ __('admin_messages.description_english') }}</label>
                                    <textarea id="update_descriptionEnglish" oninput="this.value = this.value.replace(/[^A-Za-z0-9 \n]/g,'').replace(/^\s+/,'')" name="description_english" 
                                            class="form-control" rows="3">{{ old('description_english', $promoCode->description_english) }}</textarea>
                                    <div id="update_descriptionEnglishError" class="text-danger small" style="display:none;"></div>
                                </div>
                            </div>

                            <!-- Description Arabic -->
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="mb-3">
                                    <label for="update_descriptionArabic" class="form-label">{{ __('admin_messages.description_arabic') }}</label>
                                    <textarea id="update_descriptionArabic" oninput="this.value=this.value.replace(/[^0-9\u0600-\u06FF \n]/g,'').replace(/^\s+/,'')" name="description_arabic" 
                                            class="form-control" rows="3">{{ old('description_arabic', $promoCode->description_arabic) }}</textarea>
                                    <div id="update_descriptionArabicError" class="text-danger small" style="display:none;"></div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <hr>
                            </div>

                            <!-- Applicable for -->
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group mb-3">
                                    <label>{{ __('admin_messages.applicable_for') }}</label>
                                    <select id="update_applicableFor" name="applicable_for" class="form-select">
                                        <option value="">{{ __('admin_messages.select_applicable') }}</option>
                                        <option value="1" @if($promoCode->applicable_for == 1) selected @endif>{{ __('admin_messages.first_order') }}</option>
                                        <option value="2" @if($promoCode->applicable_for == 2) selected @endif>{{ __('admin_messages.every_order') }}</option>
                                    </select>
                                    <div id="update_applicableForError" class="text-danger small" style="display:none;"></div>
                                </div>
                            </div>

                            <!-- Discount Percent -->
                            <div class="col-lg-6 ">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('admin_messages.discount') }} %</label>
                                    <input type="text" oninput="this.value = this.value.replace(/\D/g, '').replace(/^0+/, '').slice(0, 3); if (this.value > 100) this.value = 100;" id="update_discountPercent" name="discount_percent" 
                                        class="form-control" placeholder="{{ __('admin_messages.enter_discount_percentage') }}" 
                                        value="{{ old('discount_percent', fmod($promoCode->discount_percent, 1) == 0 ? (int)$promoCode->discount_percent : number_format($promoCode->discount_percent, 2)) }}" />
                                    <div id="update_discountPercentError" class="text-danger small" style="display:none;"></div>
                                </div>
                            </div>

                            <!-- Minimum Order Value -->
                            <div class="col-lg-6 ">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('admin_messages.minimum_order_value') }}</label>
                                    <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/^0+([1-9])/,'$1').replace(/^0+$/,'').replace(/(\..*?)\..*/,'$1').replace(/(\.\d{2}).*/,'$1').replace(/^(\d{7})\d*/,'$1').replace(/^(\d{7}\.\d{2})\d*/,'$1')" id="update_minOrderValue" name="min_order_value" 
                                        class="form-control" placeholder="{{ __('admin_messages.enter_minimum_order_value') }}"
                                        value="{{ old('min_order_value', $promoCode->min_order_value) }}" />
                                    <div id="update_minOrderValueError" class="text-danger small" style="display:none;"></div>
                                </div>
                            </div>

                            <!-- Upto Discount -->
                            <div class="col-lg-12 ">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('admin_messages.upto_discount') }}</label>
                                    <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/^0+([1-9])/,'$1').replace(/^0+$/,'').replace(/(\..*?)\..*/,'$1').replace(/(\.\d{2}).*/,'$1').replace(/^(\d{7})\d*/,'$1').replace(/^(\d{7}\.\d{2})\d*/,'$1')" id="update_uptoDiscount" name="upto_discount" 
                                        class="form-control" placeholder="{{ __('admin_messages.enter_upto_discount') }}"
                                        value="{{ old('upto_discount', $promoCode->upto_discount) }}" />
                                    <div id="update_uptoDiscountError" class="text-danger small" style="display:none;"></div>
                                </div>
                            </div>

                            <!-- Start Date -->
                            <div class="col-lg-6 col-md-4 col-12">
                                <div class="form-group mb-3">
                                    <label for="update_startDate" class="form-label">{{ __('admin_messages.from') }}:</label>
                                    <input type="date" id="update_startDate" name="start_date"
                                        class="form-control" 
                                        value="{{ old('start_date', \Carbon\Carbon::parse($promoCode->start_date)->format('Y-m-d')) }}" />
                                    <div id="update_startDateError" class="text-danger small" style="display:none;"></div>
                                </div>
                            </div>

                            <!-- End Date -->
                            <div class="col-lg-6 col-md-4 col-12">
                                <div class="form-group mb-3">
                                    <label for="update_endDate" class="form-label">{{ __('admin_messages.to') }}:</label>
                                    <input type="date" id="update_endDate" name="end_date"
                                        class="form-control" 
                                        value="{{ old('end_date', \Carbon\Carbon::parse($promoCode->end_date)->format('Y-m-d')) }}" />
                                    <div id="update_endDateError" class="text-danger small" style="display:none;"></div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                                <button type="submit" id="updatePromocodeBtn" class="btn btn-dark customBtn mt-3">{{ __('admin_messages.submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const countrySelect   = document.getElementById("update_country_id");
    const nameEnglish     = document.getElementById("update_nameEnglish");
    const nameArabic      = document.getElementById("update_nameArabic");
    const descEnglish     = document.getElementById("update_descriptionEnglish");
    const descArabic      = document.getElementById("update_descriptionArabic");
    const applicableFor   = document.getElementById("update_applicableFor");
    const discountPercent = document.getElementById("update_discountPercent");
    const minOrderValue   = document.getElementById("update_minOrderValue");
    const uptoDiscount    = document.getElementById("update_uptoDiscount");
    const startDate       = document.getElementById("update_startDate");
    const endDate         = document.getElementById("update_endDate");

    const countryError   = document.getElementById("update_countryError");
    const nameEnError    = document.getElementById("update_nameEnglishError");
    const nameArError    = document.getElementById("update_nameArabicError");
    const descEnError    = document.getElementById("update_descriptionEnglishError");
    const descArError    = document.getElementById("update_descriptionArabicError");
    const applicableError= document.getElementById("update_applicableForError");
    const discountError  = document.getElementById("update_discountPercentError");
    const minOrderError  = document.getElementById("update_minOrderValueError");
    const uptoError      = document.getElementById("update_uptoDiscountError");
    const startDateError = document.getElementById("update_startDateError");
    const endDateError   = document.getElementById("update_endDateError");

    countrySelect.addEventListener("change", () => countryError.style.display = "none");
    nameEnglish.addEventListener("input", () => nameEnError.style.display = "none");
    nameArabic.addEventListener("input", () => nameArError.style.display = "none");
    descEnglish.addEventListener("input", () => descEnError.style.display = "none");
    descArabic.addEventListener("input", () => descArError.style.display = "none");
    applicableFor.addEventListener("change", () => applicableError.style.display = "none");
    discountPercent.addEventListener("input", () => discountError.style.display = "none");
    minOrderValue.addEventListener("input", () => minOrderError.style.display = "none");
    uptoDiscount.addEventListener("input", () => uptoError.style.display = "none");
    startDate.addEventListener("change", () => startDateError.style.display = "none");
    endDate.addEventListener("change", () => endDateError.style.display = "none");

    document.getElementById("updatePromocodeBtn").addEventListener("click", function (e) {
        e.preventDefault();

        let hasError = false;

        // VALIDATIONS (same as add)
        if (countrySelect.value === "") { countryError.innerText = "{{ __('admin_messages.please_select_a_country') }}"; countryError.style.display="block"; hasError=true; }
        if (nameEnglish.value.trim() === "") { nameEnError.innerText="{{ __('admin_messages.please_enter_promocode_name_in_english') }}"; nameEnError.style.display="block"; hasError=true; }
        if (nameArabic.value.trim() === "") { nameArError.innerText="{{ __('admin_messages.please_enter_promocode_name_in_arabic') }}"; nameArError.style.display="block"; hasError=true; }
        if (descEnglish.value.trim() === "") { descEnError.innerText="{{ __('admin_messages.please_enter_description_in_english') }}"; descEnError.style.display="block"; hasError=true; }
        if (descArabic.value.trim() === "") { descArError.innerText="{{ __('admin_messages.please_enter_description_in_arabic') }}"; descArError.style.display="block"; hasError=true; }
        if (applicableFor.value === "") { applicableError.innerText="{{ __('admin_messages.please_select_applicable_for') }}"; applicableError.style.display="block"; hasError=true; }

        if (discountPercent.value.trim() === "" || isNaN(discountPercent.value)) { discountError.innerText="{{ __('admin_messages.please_enter_discount_percentage') }}"; discountError.style.display="block"; hasError=true; }
        if (minOrderValue.value.trim() === "" || isNaN(minOrderValue.value)) { minOrderError.innerText="{{ __('admin_messages.please_enter_minimum_order_value') }}"; minOrderError.style.display="block"; hasError=true; }
        if (uptoDiscount.value.trim() === "" || isNaN(uptoDiscount.value)) { uptoError.innerText="{{ __('admin_messages.please_enter_upto_discount') }}"; uptoError.style.display="block"; hasError=true; }

        if (startDate.value === "") { startDateError.innerText="{{ __('admin_messages.please_select_from_date') }}"; startDateError.style.display="block"; hasError=true; }
        if (endDate.value === "") { endDateError.innerText="{{ __('admin_messages.please_select_to_date') }}"; endDateError.style.display="block"; hasError=true; }

        if (startDate.value !== "" && endDate.value !== "" && new Date(endDate.value) <= new Date(startDate.value)) {
            endDateError.innerText = "{{ __('admin_messages.from_date_must_be_greater_than_to_date') }}";
            endDateError.style.display = "block";
            hasError = true;
        }

        if (hasError) return;

        const payload = {
            promocode_id: document.getElementById("promocode_id").value,
            country_id: countrySelect.value,
            name_english: nameEnglish.value,
            name_arabic: nameArabic.value,
            description_english: descEnglish.value,
            description_arabic: descArabic.value,
            applicable_for: applicableFor.value,
            discount_percent: discountPercent.value,
            min_order_value: minOrderValue.value,
            upto_discount: uptoDiscount.value,
            start_date: startDate.value,
            end_date: endDate.value
        };

        fetch("/admin/update_promocode", {
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
                setTimeout(() => {
                    window.location.href = "{{ route('admin.promoCodeManagement') }}";
                }, 2000);
            } else {
                toastr.error(data.message || "Failed to update promocode");
            }
        })
        .catch(err => {
           // console.error(err);
            toastr.error("Something went wrong");
        });

    });

});
</script>

<script>
    function updateToDate2() {
        const fromDate = document.getElementById('update_startDate').value;
        const toDateInput = document.getElementById('update_endDate');
        
        if (fromDate) {
            const minDate = new Date(fromDate);
            minDate.setDate(minDate.getDate() + 1); 
            toDateInput.setAttribute('min', minDate.toISOString().split('T')[0]);
        } else {
            toDateInput.removeAttribute('min');
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        updateToDate2(); 
        document.getElementById('update_startDate').addEventListener('input', updateToDate2);
    });
</script>





@endsection