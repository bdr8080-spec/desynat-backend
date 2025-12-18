@extends('admin.layout.app')
@section('content')
<style>

.form-group label.form-label,
.form-check-label {
    font-size: 19px !important;
    line-height: 30px;
    /* font-weight: 600; */
    text-align: start;
}
</style>

<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">Promocode Management</h2>
        </div>

        <!-- <div class="col-lg-3 col-md-4 col-12">
            <div class="d-flex justify-content-end">
                <a class="btn btn-dark customBtn" data-bs-toggle="modal" data-bs-target="#sentModal2">
                    <span>Add New Promocode</span>
                </a>
            </div>
        </div> -->
        <div class="col-lg-3 col-md-4 col-12">
            <div class="d-flex justify-content-end">
                <a class="btn btn-dark customBtn" href="{{route('admin.addPromocode')}}" >
                    <span>Add New Promocode</span>
                </a>
            </div>
        </div>

    </div>

    <div class="userManagecontent">
        <div class="mt-4">
            <form method="GET" action="{{ route('admin.promoCodeManagement') }}" id="filterForm">
                <div class="row align-items-end">
                    <!-- From Date Filter -->
                    <div class="col-lg-2 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from" name="from_date" class="form-control"
                                value="{{ request()->from_date }}"
                                onchange="updateToDate(); document.getElementById('filterForm').submit();" />
                        </div>
                    </div>

                    <!-- To Date Filter -->
                    <div class="col-lg-2 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">To:</label>
                            <input type="date" id="to" name="to_date" class="form-control"
                                value="{{ request()->to_date }}"
                                onchange="updateToDate(); document.getElementById('filterForm').submit();" />
                        </div>
                    </div>

                    <!-- Country Filter -->
                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">Select Country</label>
                            <select name="country_id" id="country_id"
                                class="form-select form-select-lg "
                                onchange="document.getElementById('filterForm').submit();">
                                <option value="">Select country</option>
                                @foreach($countries as $country)
                                <option value="{{ $country['id'] }}"
                                    {{ request('country_id') == $country['id'] ? 'selected' : '' }}>
                                    {{ $country['name'] }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="status" class="form-label">Status-</label>
                            <select id="status" name="status" class="form-select form-select-lg"
                                    onchange="document.getElementById('filterForm').submit();">
                                <option value="">Select Status</option>
                                <option value="1" {{ request()->status == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ request()->status == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-12 ">
                    <div class="d-flex gap-3 justify-content-end" >
                        <a href="{{route('admin.promoCodeManagement')}}" class="btn btn-dark customBtn"
                            style="margin-top: 60px">
                            <span>Reset</span>
                        </a>
                    </div>
                </div>
                </div>
            </form>

            <div class="table-responsive w-100 mt-4">
                <table id="myTable" class="table w-100">
                    <thead>
                        <tr>
                            <th scope="col">SR No.</th>
                            <th scope="col">Promocode <br> Name</th>
                            <th scope="col">Country</th>
                            <th scope="col">View <br> Description</th>
                            <th scope="col">Applicable for</th>
                            <th scope="col">Minimum <br> Order <br> Value</th>
                            <th scope="col">Upto <br> Discount</th>
                            <th scope="col">Discount %</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($promoCodes as $index => $pc)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{$pc['name_english']}}</td>
                            <td>{{ $pc['country_info']['name'] }}</td>
                            <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                    data-bs-target="#sentModal1"
                                    data-description="{{ $pc['description_english'] }}">
                                    <i class="bi bi-eye-fill"></i>
                                </a></td>
                            <td>
                                @if($pc['applicable_for'] == 1)
                                    First Order
                                @elseif($pc['applicable_for'] == 2)
                                    Every Order
                                @endif
                            </td>
                            <td>{{$pc['min_order_value']}} KD</td>
                            <td>{{$pc['upto_discount']}} KD</td>
                            <td>{{$pc['discount_percent']}}%</td>
                            <td>{{ \Carbon\Carbon::parse($pc['start_date'])->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($pc['end_date'])->format('d-m-Y') }}</td>
                            <td>
                                @if($pc['status'] == 1)
                                    Active
                                @elseif($pc['status'] == 0)
                                    Inactive
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-3 justify-content-center ">
                                    <a class="table-button" href="{{ route('admin.editPromocode', $pc['id']) }}" type="button">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                        <!-- <a class="table-button editPromocodeBtn mb-1"
                                            href="javascript:void(0);"
                                            data-id="{{ $pc->id }}"
                                            data-country="{{ $pc->country_id }}"
                                            data-name-en="{{ $pc->name_english }}"
                                            data-name-ar="{{ $pc->name_arabic }}"
                                            data-desc-en="{{ $pc->description_english }}"
                                            data-desc-ar="{{ $pc->description_arabic }}"
                                            data-applicable="{{ $pc->applicable_for }}"
                                            data-discount="{{ $pc->discount_percent }}"
                                            data-min="{{ $pc->min_order_value }}"
                                            data-upto="{{ $pc->upto_discount }}"
                                            data-start="{{ $pc->start_date }}"
                                            data-end="{{ $pc->end_date }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#updatePromocodeModal">

                                            <i class="bi bi-pencil-square"></i>
                                        </a> -->


                                      <!-- Delete button  -->
                                     <a
                                          href="javascript:void(0);"
                                          class="table-button text-danger deletePromoCode mb-1 mt-1"
                                          data-id="{{ $pc->id }}"
                                      >
                                          <i class="bi bi-trash3-fill"></i>
                                      </a>

                                      <!-- Toggle switch -->
                                      <div class="form-check form-switch">
                                          <input
                                              class="form-check-input toggleStatus"
                                              type="checkbox"
                                              role="switch"
                                              id="switch{{ $pc->id }}"
                                              data-id="{{ $pc->id }}"
                                              {{ $pc->status == 1 ? 'checked' : '' }}
                                          />
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

<!-- add promocode -->
<div class="modal fade" id="sentModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Add New Promocode</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
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
                                <input type="text" id="nameEnglish" name="name_english" oninput="this.value = this.value.replace(/[^A-Za-z0-9 ]/g,'').replace(/^\s+/,'')" class="form-control" placeholder="Enter Promocode in English" />
                                <div id="nameEnglishError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Promocode Name Arabic -->
                        <div class="col-lg-6 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label">Promocode Name (Arabic)</label>
                                <input type="text" id="nameArabic" name="name_arabic" oninput="this.value=this.value.replace(/[^0-9\u0600-\u06FF ]/g,'').replace(/^\s+/,'')" class="form-control" placeholder="Enter Promocode in Arabic" />
                                <div id="nameArabicError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Description English -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="mb-3">
                                <label for="descriptionEnglish" class="form-label">Description (English)</label>
                                <textarea id="descriptionEnglish" name="description_english" oninput="this.value = this.value.replace(/[^A-Za-z0-9 \n]/g,'').replace(/^\s+/,'')" class="form-control" rows="3"></textarea>
                                <div id="descriptionEnglishError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Description Arabic -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="mb-3">
                                <label for="descriptionArabic" class="form-label">Description (Arabic)</label>
                                <textarea id="descriptionArabic"  name="description_arabic" oninput="this.value=this.value.replace(/[^0-9\u0600-\u06FF \n]/g,'').replace(/^\s+/,'')" class="form-control" rows="3"></textarea>
                                <div id="descriptionArabicError" class="text-danger small" style="display:none;"></div>
                            </div>
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
                                <input type="text" oninput="this.value = this.value.replace(/\D/g, '').replace(/^0+/, '').slice(0, 3); if (this.value > 100) this.value = 100;" id="discountPercent" name="discount_percent" class="form-control" placeholder="Enter Discount %" />
                                <div id="discountPercentError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Minimum Order Value -->
                        <div class="col-lg-6 ">
                            <div class="form-group mb-3">
                                <label class="form-label">Minimum Order Value</label>
                                <input type="text" id="minOrderValue" oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/^0+([1-9])/,'$1').replace(/^0+$/,'').replace(/(\..*?)\..*/,'$1').replace(/(\.\d{2}).*/,'$1').replace(/^(\d{7})\d*/,'$1').replace(/^(\d{7}\.\d{2})\d*/,'$1')" name="min_order_value" class="form-control" placeholder="Enter Minimum Order Value" />
                                <div id="minOrderValueError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Upto Discount -->
                        <div class="col-lg-12 ">
                            <div class="form-group mb-3">
                                <label class="form-label">Upto Discount</label>
                                <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/^0+([1-9])/,'$1').replace(/^0+$/,'').replace(/(\..*?)\..*/,'$1').replace(/(\.\d{2}).*/,'$1').replace(/^(\d{7})\d*/,'$1').replace(/^(\d{7}\.\d{2})\d*/,'$1')" id="uptoDiscount" name="upto_discount" class="form-control" placeholder="Enter Upto Discount" />
                                <div id="uptoDiscountError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Start Date -->
                        <div class="col-lg-6 col-md-4 col-12">
                            <div class="form-group mb-3">
                                <label for="startDate" class="form-label">From:</label>
                                <input type="date" onchange="updateToDate1();" id="startDate" name="start_date" class="form-control" />
                                <div id="startDateError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- End Date -->
                        <div class="col-lg-6 col-md-4 col-12">
                            <div class="form-group mb-3">
                                <label for="endDate" class="form-label">To:</label>
                                <input type="date" onchange="updateToDate1();" id="endDate" name="end_date" class="form-control" />
                                <div id="endDateError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                            <button type="button" id="submitBrandBtn" class="btn btn-dark customBtn mt-3">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- update promocode -->
<div class="modal fade" id="updatePromocodeModal" tabindex="-1" aria-labelledby="updatePromocodeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Update Promocode</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <div class="row">

                        <!-- Hidden ID -->
                        <input type="hidden" id="promocode_id">

                        <!-- Country Select -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group mb-3">
                                <label>Select Country-</label>
                                <select name="country_id" id="update_country_id" class="form-select">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <div id="update_countryError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Promocode Name English -->
                        <div class="col-lg-6 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label">Promocode Name (English)</label>
                                <input type="text" id="update_nameEnglish" oninput="this.value = this.value.replace(/[^A-Za-z0-9 ]/g,'').replace(/^\s+/,'')" class="form-control" placeholder="Enter Promocode in English" />
                                <div id="update_nameEnglishError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Promocode Name Arabic -->
                        <div class="col-lg-6 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label">Promocode Name (Arabic)</label>
                                <input type="text" id="update_nameArabic" oninput="this.value=this.value.replace(/[^0-9\u0600-\u06FF ]/g,'').replace(/^\s+/,'')" class="form-control" placeholder="Enter Promocode in Arabic" />
                                <div id="update_nameArabicError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Description English -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="mb-3">
                                <label for="update_descriptionEnglish" class="form-label">Description (English)</label>
                                <textarea id="update_descriptionEnglish" oninput="this.value = this.value.replace(/[^A-Za-z0-9 \n]/g,'').replace(/^\s+/,'')" class="form-control" rows="3"></textarea>
                                <div id="update_descriptionEnglishError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Description Arabic -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="mb-3">
                                <label for="update_descriptionArabic" class="form-label">Description (Arabic)</label>
                                <textarea id="update_descriptionArabic" oninput="this.value=this.value.replace(/[^0-9\u0600-\u06FF \n]/g,'').replace(/^\s+/,'')" class="form-control" rows="3"></textarea>
                                <div id="update_descriptionArabicError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Applicable for -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group mb-3">
                                <label>Applicable for-</label>
                                <select id="update_applicableFor" class="form-select">
                                    <option value="">Select Applicable</option>
                                    <option value="1">First Order</option>
                                    <option value="2">Every Order</option>
                                </select>
                                <div id="update_applicableForError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Discount Percent -->
                        <div class="col-lg-6 ">
                            <div class="form-group mb-3">
                                <label class="form-label">Discount %</label>
                                <input type="text" id="update_discountPercent" oninput="this.value = this.value.replace(/\D/g, '').replace(/^0+/, '').slice(0, 3); if (this.value > 100) this.value = 100;" class="form-control" placeholder="Enter Discount %" />
                                <div id="update_discountPercentError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Minimum Order Value -->
                        <div class="col-lg-6 ">
                            <div class="form-group mb-3">
                                <label class="form-label">Minimum Order Value</label>
                                <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/^0+([1-9])/,'$1').replace(/^0+$/,'').replace(/(\..*?)\..*/,'$1').replace(/(\.\d{2}).*/,'$1').replace(/^(\d{7})\d*/,'$1').replace(/^(\d{7}\.\d{2})\d*/,'$1')" id="update_minOrderValue" class="form-control" placeholder="Enter Minimum Order Value" />
                                <div id="update_minOrderValueError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Upto Discount -->
                        <div class="col-lg-12 ">
                            <div class="form-group mb-3">
                                <label class="form-label">Upto Discount</label>
                                <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/^0+([1-9])/,'$1').replace(/^0+$/,'').replace(/(\..*?)\..*/,'$1').replace(/(\.\d{2}).*/,'$1').replace(/^(\d{7})\d*/,'$1').replace(/^(\d{7}\.\d{2})\d*/,'$1')" id="update_uptoDiscount" class="form-control" placeholder="Enter Upto Discount" />
                                <div id="update_uptoDiscountError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Start Date -->
                        <div class="col-lg-6 col-md-4 col-12">
                            <div class="form-group mb-3">
                                <label class="form-label">From:</label>
                                <input type="date" id="update_startDate" class="form-control" />
                                <div id="update_startDateError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- End Date -->
                        <div class="col-lg-6 col-md-4 col-12">
                            <div class="form-group mb-3">
                                <label class="form-label">To:</label>
                                <input type="date" id="update_endDate" class="form-control" />
                                <div id="update_endDateError" class="text-danger small" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                            <button type="button" id="updatePromocodeBtn" class="btn btn-dark customBtn mt-3">Update</button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>






<div class="modal fade" id="sentModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Description</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <div class="row">
             
                        <div class="col-lg-12 col-md-12 col-12">

                            <div class="mb-3">
                                <!-- <label for="description" class="form-label">Description</label> -->
                                <textarea id="description" class="form-control"
                                    rows="3" readOnly></textarea>
                            </div>
                        </div>
                      

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const sentModal = document.getElementById('sentModal1');
    const descriptionTextarea = document.getElementById('description');

    sentModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; 
        const description = button.getAttribute('data-description');

        descriptionTextarea.value = description;
    });
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.deletePromoCode').forEach(button => {
        button.addEventListener('click', function () {
            let promoCodeId = this.getAttribute('data-id');

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/deletePromocode/${promoCodeId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.status == "success"){
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

<!-- Update Promocode Status -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggleStatus').forEach(toggle => {
        toggle.addEventListener('change', function () {
            let promoCodeId = this.getAttribute('data-id');

            fetch(`/admin/updatePromoCodeStatus/${promoCodeId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                    // toastr.success(data.message);
                     if (data.status == 1) {
                        toastr.success(data.message); 
                    } else {
                        toastr.error(data.message);
                    }
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
            })
            .catch(error => {
                //console.error(error);
                toastr.error('Something went wrong while updating status.');
            });
        });
    });
});
</script>


<!-- update -->
<!-- <script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".editPromocodeBtn").forEach(btn => {
        btn.addEventListener("click", function () {

            document.getElementById("promocode_id").value = this.dataset.id;
            document.getElementById("update_country_id").value = this.dataset.country;
            document.getElementById("update_nameEnglish").value = this.dataset.nameEn;
            document.getElementById("update_nameArabic").value = this.dataset.nameAr;
            document.getElementById("update_descriptionEnglish").value = this.dataset.descEn;
            document.getElementById("update_descriptionArabic").value = this.dataset.descAr;
            document.getElementById("update_applicableFor").value = this.dataset.applicable;
            document.getElementById("update_discountPercent").value = this.dataset.discount;
            document.getElementById("update_minOrderValue").value = this.dataset.min;
            document.getElementById("update_uptoDiscount").value = this.dataset.upto;

            document.getElementById("update_startDate").value = this.dataset.start.substring(0, 10);
            document.getElementById("update_endDate").value   = this.dataset.end.substring(0, 10);
        });
    });

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

        if (discountPercent.value.trim() === "" || isNaN(discountPercent.value)) { discountError.innerText="Discount percent must be number"; discountError.style.display="block"; hasError=true; }
        if (minOrderValue.value.trim() === "" || isNaN(minOrderValue.value)) { minOrderError.innerText="Minimum order must be number"; minOrderError.style.display="block"; hasError=true; }
        if (uptoDiscount.value.trim() === "" || isNaN(uptoDiscount.value)) { uptoError.innerText="Upto discount must be number"; uptoError.style.display="block"; hasError=true; }

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

                const modal = bootstrap.Modal.getInstance(document.getElementById("updatePromocodeModal"));
                modal.hide();

                setTimeout(() => location.reload(), 1500);
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
</script> -->

<!-- <script>
document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('sentModal2');
    modal.addEventListener('hidden.bs.modal', function () {
        location.reload(); 
    });
});
</script> -->

<script>
    function updateToDate() {
        const fromDate = document.getElementById('from').value;
        const toDateInput = document.getElementById('to');
        if (fromDate) {
            toDateInput.setAttribute('min', fromDate);
        } else {
            toDateInput.removeAttribute('min');
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        updateToDate();
    });
</script>


@endsection