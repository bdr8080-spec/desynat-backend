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
            <h2 class="h2 text-start">Edit Promo Code</h2>

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
                                    <label>Select Country-</label>
                                    <select name="country_id" id="update_country_id" class="form-select">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" 
                                                @if($country->id == $promoCode->country_id) selected @endif>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="update_countryError" class="text-danger small" style="display:none;"></div>
                                </div>
                            </div>

                            <!-- Promocode Name English -->
                            <div class="col-lg-6 col-md-12 col-12">
                                <div class="form-group">
                                    <label class="form-label">Promocode Name (English)</label>
                                    <input type="text" id="update_nameEnglish" name="name_english"
                                        class="form-control" placeholder="Enter Promocode in English" 
                                        value="{{ old('name_english', $promoCode->name_english) }}" />
                                    <div id="update_nameEnglishError" class="text-danger small" style="display:none;"></div>
                                </div>
                            </div>

                            <!-- Promocode Name Arabic -->
                            <div class="col-lg-6 col-md-12 col-12">
                                <div class="form-group">
                                    <label class="form-label">Promocode Name (Arabic)</label>
                                    <input type="text" id="update_nameArabic" name="name_arabic"
                                        class="form-control" placeholder="Enter Promocode in Arabic" 
                                        value="{{ old('name_arabic', $promoCode->name_arabic) }}" />
                                    <div id="update_nameArabicError" class="text-danger small" style="display:none;"></div>
                                </div>
                            </div>

                            <!-- Description English -->
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="mb-3">
                                    <label for="update_descriptionEnglish" class="form-label">Description (English)</label>
                                    <textarea id="update_descriptionEnglish" name="description_english" 
                                            class="form-control" rows="3">{{ old('description_english', $promoCode->description_english) }}</textarea>
                                    <div id="update_descriptionEnglishError" class="text-danger small" style="display:none;"></div>
                                </div>
                            </div>

                            <!-- Description Arabic -->
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="mb-3">
                                    <label for="update_descriptionArabic" class="form-label">Description (Arabic)</label>
                                    <textarea id="update_descriptionArabic" name="description_arabic" 
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
                                    <label>Applicable for-</label>
                                    <select id="update_applicableFor" name="applicable_for" class="form-select">
                                        <option value="">Select Applicable</option>
                                        <option value="1" @if($promoCode->applicable_for == 1) selected @endif>First Order</option>
                                        <option value="2" @if($promoCode->applicable_for == 2) selected @endif>Every Order</option>
                                    </select>
                                    <div id="update_applicableForError" class="text-danger small" style="display:none;"></div>
                                </div>
                            </div>

                            <!-- Discount Percent -->
                            <div class="col-lg-6 ">
                                <div class="form-group mb-3">
                                    <label class="form-label">Discount %</label>
                                    <input type="text" id="update_discountPercent" name="discount_percent" 
                                        class="form-control" placeholder="Enter Discount %" 
                                        value="{{ old('discount_percent', $promoCode->discount_percent) }}" />
                                    <div id="update_discountPercentError" class="text-danger small" style="display:none;"></div>
                                </div>
                            </div>

                            <!-- Minimum Order Value -->
                            <div class="col-lg-6 ">
                                <div class="form-group mb-3">
                                    <label class="form-label">Minimum Order Value</label>
                                    <input type="text" id="update_minOrderValue" name="min_order_value" 
                                        class="form-control" placeholder="Enter Minimum Order Value"
                                        value="{{ old('min_order_value', $promoCode->min_order_value) }}" />
                                    <div id="update_minOrderValueError" class="text-danger small" style="display:none;"></div>
                                </div>
                            </div>

                            <!-- Upto Discount -->
                            <div class="col-lg-12 ">
                                <div class="form-group mb-3">
                                    <label class="form-label">Upto Discount</label>
                                    <input type="text" id="update_uptoDiscount" name="upto_discount" 
                                        class="form-control" placeholder="Enter Upto Discount"
                                        value="{{ old('upto_discount', $promoCode->upto_discount) }}" />
                                    <div id="update_uptoDiscountError" class="text-danger small" style="display:none;"></div>
                                </div>
                            </div>

                            <!-- Start Date -->
                            <div class="col-lg-6 col-md-4 col-12">
                                <div class="form-group mb-3">
                                    <label for="update_startDate" class="form-label">From:</label>
                                    <input type="date" id="update_startDate" name="start_date"
                                        class="form-control" 
                                        value="{{ old('start_date', \Carbon\Carbon::parse($promoCode->start_date)->format('Y-m-d')) }}" />
                                    <div id="update_startDateError" class="text-danger small" style="display:none;"></div>
                                </div>
                            </div>

                            <!-- End Date -->
                            <div class="col-lg-6 col-md-4 col-12">
                                <div class="form-group mb-3">
                                    <label for="update_endDate" class="form-label">To:</label>
                                    <input type="date" id="update_endDate" name="end_date"
                                        class="form-control" 
                                        value="{{ old('end_date', \Carbon\Carbon::parse($promoCode->end_date)->format('Y-m-d')) }}" />
                                    <div id="update_endDateError" class="text-danger small" style="display:none;"></div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                                <button type="submit" id="updatePromocodeBtn" class="btn btn-dark customBtn mt-3">Submit</button>
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
        if (countrySelect.value === "") { countryError.innerText = "Please select country"; countryError.style.display="block"; hasError=true; }
        if (nameEnglish.value.trim() === "") { nameEnError.innerText="Please enter promocode name in English"; nameEnError.style.display="block"; hasError=true; }
        if (nameArabic.value.trim() === "") { nameArError.innerText="Please enter promocode name in Arabic"; nameArError.style.display="block"; hasError=true; }
        if (descEnglish.value.trim() === "") { descEnError.innerText="Please enter description in English"; descEnError.style.display="block"; hasError=true; }
        if (descArabic.value.trim() === "") { descArError.innerText="Please enter description in Arabic"; descArError.style.display="block"; hasError=true; }
        if (applicableFor.value === "") { applicableError.innerText="Please select applicable for"; applicableError.style.display="block"; hasError=true; }

        if (discountPercent.value.trim() === "" || isNaN(discountPercent.value)) { discountError.innerText="Please enter discount"; discountError.style.display="block"; hasError=true; }
        if (minOrderValue.value.trim() === "" || isNaN(minOrderValue.value)) { minOrderError.innerText="Please enter minimum order value"; minOrderError.style.display="block"; hasError=true; }
        if (uptoDiscount.value.trim() === "" || isNaN(uptoDiscount.value)) { uptoError.innerText="Please enter upto discount"; uptoError.style.display="block"; hasError=true; }

        if (startDate.value === "") { startDateError.innerText="Please select start date"; startDateError.style.display="block"; hasError=true; }
        if (endDate.value === "") { endDateError.innerText="Please select end date"; endDateError.style.display="block"; hasError=true; }

        if (startDate.value !== "" && endDate.value !== "" && new Date(endDate.value) <= new Date(startDate.value)) {
            endDateError.innerText = "End date must be greater than start date";
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