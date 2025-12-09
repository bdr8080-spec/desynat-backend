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
            <h2 class="h2 text-start">Add Promo Code</h2>

        </div>
        <div class="content">
            <div class="card p-3 mt-4">
                <div class="card-body">
                    <div class="row">
                        <!-- Country Select -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group mb-3">
                                <label>Select Country-</label>
                                <select name="country_id" id="country_id1" class="form-select">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <div id="countryError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Promocode Name English -->
                        <div class="col-lg-6 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label">Promocode Name (English)</label>
                                <input type="text" id="nameEnglish" name="name_english"
                                    oninput="this.value = this.value.replace(/[^A-Za-z0-9 ]/g,'').replace(/^\s+/,'')"
                                    class="form-control" placeholder="Enter Promocode in English" />
                                <div id="nameEnglishError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Promocode Name Arabic -->
                        <div class="col-lg-6 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label">Promocode Name (Arabic)</label>
                                <input type="text" id="nameArabic" name="name_arabic"
                                    oninput="this.value=this.value.replace(/[^0-9\u0600-\u06FF ]/g,'').replace(/^\s+/,'')"
                                    class="form-control" placeholder="Enter Promocode in Arabic" />
                                <div id="nameArabicError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Description English -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="mb-3">
                                <label for="descriptionEnglish" class="form-label">Description (English)</label>
                                <textarea id="descriptionEnglish" name="description_english"
                                    oninput="this.value = this.value.replace(/[^A-Za-z0-9 \n]/g,'').replace(/^\s+/,'')"
                                    class="form-control" rows="3"></textarea>
                                <div id="descriptionEnglishError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Description Arabic -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="mb-3">
                                <label for="descriptionArabic" class="form-label">Description (Arabic)</label>
                                <textarea id="descriptionArabic" name="description_arabic"
                                    oninput="this.value=this.value.replace(/[^0-9\u0600-\u06FF \n]/g,'').replace(/^\s+/,'')"
                                    class="form-control" rows="3"></textarea>
                                <div id="descriptionArabicError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <hr>
                        </div>

                        <!-- Applicable for -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group mb-3">
                                <label>Applicable for-</label>
                                <select id="applicableFor" name="applicable_for" class="form-select">
                                    <option value="">Select Applicable</option>
                                    <option value="1">First Order</option>
                                    <option value="2">Every Order</option>
                                </select>
                                <div id="applicableForError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Discount Percent -->
                        <div class="col-lg-6 ">
                            <div class="form-group mb-3">
                                <label class="form-label">Discount %</label>
                                <input type="text"
                                    oninput="this.value = this.value.replace(/\D/g, '').replace(/^0+/, '').slice(0, 3); if (this.value > 100) this.value = 100;"
                                    id="discountPercent" name="discount_percent" class="form-control"
                                    placeholder="Enter Discount %" />
                                <div id="discountPercentError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Minimum Order Value -->
                        <div class="col-lg-6 ">
                            <div class="form-group mb-3">
                                <label class="form-label">Minimum Order Value</label>
                                <input type="text" id="minOrderValue"
                                    oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/^0+([1-9])/,'$1').replace(/^0+$/,'').replace(/(\..*?)\..*/,'$1').replace(/(\.\d{2}).*/,'$1').replace(/^(\d{7})\d*/,'$1').replace(/^(\d{7}\.\d{2})\d*/,'$1')"
                                    name="min_order_value" class="form-control"
                                    placeholder="Enter Minimum Order Value" />
                                <div id="minOrderValueError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Upto Discount -->
                        <div class="col-lg-12 ">
                            <div class="form-group mb-3">
                                <label class="form-label">Upto Discount</label>
                                <input type="text"
                                    oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/^0+([1-9])/,'$1').replace(/^0+$/,'').replace(/(\..*?)\..*/,'$1').replace(/(\.\d{2}).*/,'$1').replace(/^(\d{7})\d*/,'$1').replace(/^(\d{7}\.\d{2})\d*/,'$1')"
                                    id="uptoDiscount" name="upto_discount" class="form-control"
                                    placeholder="Enter Upto Discount" />
                                <div id="uptoDiscountError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Start Date -->
                        <div class="col-lg-6 col-md-4 col-12">
                            <div class="form-group mb-3">
                                <label for="startDate" class="form-label">From:</label>
                                <input type="date" onchange="updateToDate1();" id="startDate" name="start_date"
                                    class="form-control" />
                                <div id="startDateError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- End Date -->
                        <div class="col-lg-6 col-md-4 col-12">
                            <div class="form-group mb-3">
                                <label for="endDate" class="form-label">To:</label>
                                <input type="date" onchange="updateToDate1();" id="endDate" name="end_date"
                                    class="form-control" />
                                <div id="endDateError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                            <button type="button" id="submitBrandBtn"
                                class="btn btn-dark customBtn mt-3">Submit</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const countrySelect = document.getElementById("country_id1");
    const nameEnglishInput = document.getElementById("nameEnglish");
    const nameArabicInput = document.getElementById("nameArabic");
    const descriptionEnglishInput = document.getElementById("descriptionEnglish");
    const descriptionArabicInput = document.getElementById("descriptionArabic");
    const applicableForSelect = document.getElementById("applicableFor");
    const discountPercentInput = document.getElementById("discountPercent");
    const minOrderValueInput = document.getElementById("minOrderValue");
    const uptoDiscountInput = document.getElementById("uptoDiscount");
    const startDateInput = document.getElementById("startDate");
    const endDateInput = document.getElementById("endDate");

    const countryError = document.getElementById("countryError");
    const nameEnglishError = document.getElementById("nameEnglishError");
    const nameArabicError = document.getElementById("nameArabicError");
    const descriptionEnglishError = document.getElementById("descriptionEnglishError");
    const descriptionArabicError = document.getElementById("descriptionArabicError");
    const applicableForError = document.getElementById("applicableForError");
    const discountPercentError = document.getElementById("discountPercentError");
    const minOrderValueError = document.getElementById("minOrderValueError");
    const uptoDiscountError = document.getElementById("uptoDiscountError");
    const startDateError = document.getElementById("startDateError");
    const endDateError = document.getElementById("endDateError");

    const submitBtn = document.getElementById("submitBrandBtn");

    countrySelect.addEventListener("change", function() {
        if(this.value !== "") countryError.style.display = "none";
    });
    nameEnglishInput.addEventListener("input", () => nameEnglishError.style.display = "none");
    nameArabicInput.addEventListener("input", () => nameArabicError.style.display = "none");
    descriptionEnglishInput.addEventListener("input", () => descriptionEnglishError.style.display = "none");
    descriptionArabicInput.addEventListener("input", () => descriptionArabicError.style.display = "none");
    applicableForSelect.addEventListener("change", function() {
        if(this.value !== "") applicableForError.style.display = "none";
    });
    discountPercentInput.addEventListener("input", () => discountPercentError.style.display = "none");
    minOrderValueInput.addEventListener("input", () => minOrderValueError.style.display = "none");
    uptoDiscountInput.addEventListener("input", () => uptoDiscountError.style.display = "none");
    startDateInput.addEventListener("change", () => startDateError.style.display = "none");
    endDateInput.addEventListener("change", () => endDateError.style.display = "none");

    submitBtn.addEventListener("click", function(e) {
        e.preventDefault();

        let hasError = false;

        if(countrySelect.value === "") {
            countryError.innerText = "Please select a country";
            countryError.style.display = "block";
            hasError = true;
        }

        if(nameEnglishInput.value.trim() === "") {
            nameEnglishError.innerText = "Please enter promocode name in English";
            nameEnglishError.style.display = "block";
            hasError = true;
        }

        if(nameArabicInput.value.trim() === "") {
            nameArabicError.innerText = "Please enter promocode name in Arabic";
            nameArabicError.style.display = "block";
            hasError = true;
        }

        if(descriptionEnglishInput.value.trim() === "") {
            descriptionEnglishError.innerText = "Please enter description in English";
            descriptionEnglishError.style.display = "block";
            hasError = true;
        }

        if(descriptionArabicInput.value.trim() === "") {
            descriptionArabicError.innerText = "Please enter description in Arabic";
            descriptionArabicError.style.display = "block";
            hasError = true;
        }

        if(applicableForSelect.value === "") {
            applicableForError.innerText = "Please select applicable for";
            applicableForError.style.display = "block";
            hasError = true;
        }

        if(discountPercentInput.value.trim() === "") {
            discountPercentError.innerText = "Please enter discount percent";
            discountPercentError.style.display = "block";
            hasError = true;
        } else if (isNaN(discountPercentInput.value.trim())) {
            discountPercentError.innerText = "Discount percent must be a number";
            discountPercentError.style.display = "block";
            hasError = true;
        }

        if(minOrderValueInput.value.trim() === "") {
            minOrderValueError.innerText = "Please enter minimum order value";
            minOrderValueError.style.display = "block";
            hasError = true;
        } else if (isNaN(minOrderValueInput.value.trim())) {
            minOrderValueError.innerText = "Minimum order value must be a number";
            minOrderValueError.style.display = "block";
            hasError = true;
        }

        if(uptoDiscountInput.value.trim() === "") {
            uptoDiscountError.innerText = "Please enter upto discount";
            uptoDiscountError.style.display = "block";
            hasError = true;
        } else if (isNaN(uptoDiscountInput.value.trim())) {
            uptoDiscountError.innerText = "Upto discount must be a number";
            uptoDiscountError.style.display = "block";
            hasError = true;
        }

        if(startDateInput.value === "") {
            startDateError.innerText = "Please select start date";
            startDateError.style.display = "block";
            hasError = true;
        }

        if(endDateInput.value === "") {
            endDateError.innerText = "Please select end date";
            endDateError.style.display = "block";
            hasError = true;
        }

        if(startDateInput.value !== "" && endDateInput.value !== "") {
            if(new Date(endDateInput.value) <= new Date(startDateInput.value)) {
                endDateError.innerText = "End date must be greater than start date";
                endDateError.style.display = "block";
                hasError = true;
            }
        }

        if(hasError) return;

        const dataToSend = {
            country_id: countrySelect.value,
            name_english: nameEnglishInput.value.trim(),
            name_arabic: nameArabicInput.value.trim(),
            description_english: descriptionEnglishInput.value.trim(),
            description_arabic: descriptionArabicInput.value.trim(),
            applicable_for: applicableForSelect.value,
            discount_percent: discountPercentInput.value.trim(),
            min_order_value: minOrderValueInput.value.trim(),
            upto_discount: uptoDiscountInput.value.trim(),
            start_date: startDateInput.value,
            end_date: endDateInput.value
        };

        fetch("/admin/add_promocode", {  
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(dataToSend)
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === "success") {
                toastr.success(data.message);
                // const modal = bootstrap.Modal.getInstance(document.getElementById("sentModal2"));
                // modal.hide();
                // Reset form fields
                countrySelect.value = "";
                nameEnglishInput.value = "";
                nameArabicInput.value = "";
                descriptionEnglishInput.value = "";
                descriptionArabicInput.value = "";
                applicableForSelect.value = "";
                discountPercentInput.value = "";
                minOrderValueInput.value = "";
                uptoDiscountInput.value = "";
                startDateInput.value = "";
                endDateInput.value = "";
                setTimeout(() => {
                    window.location.href = "{{ route('admin.promoCodeManagement') }}";
                }, 2000);
            } else {
                toastr.error(data.message || "Failed to add promocode");
            }
        })
        .catch(err => {
           // console.error(err);
            toastr.error("Something went wrong while adding promocode");
        });
    });
});
</script>

<script>
    function updateToDate1() {
        const fromDate = document.getElementById('startDate').value;
        const toDateInput = document.getElementById('endDate');
        
        if (fromDate) {
            const minDate = new Date(fromDate);
            minDate.setDate(minDate.getDate() + 1); 
            toDateInput.setAttribute('min', minDate.toISOString().split('T')[0]);
        } else {
            toDateInput.removeAttribute('min');
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        updateToDate1(); 
        document.getElementById('startDate').addEventListener('input', updateToDate1);
    });
</script>





@endsection