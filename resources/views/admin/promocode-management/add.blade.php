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
            <h2 class="h2 text-start">Add Delivery Boy</h2>

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





@endsection