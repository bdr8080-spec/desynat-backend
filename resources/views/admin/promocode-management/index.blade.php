@extends('admin.layout.app')
@section('content')
<style>
#editPreviewImage {
    display: block;
}

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

        <div class="col-lg-3 col-md-4 col-12">
            <div class="d-flex justify-content-end">
                <a class="btn btn-dark customBtn" data-bs-toggle="modal" data-bs-target="#sentModal2">
                    <span>Add New Promocode</span>
                </a>
            </div>
        </div>
    </div>

    <div class="userManagecontent">
        <div class="mt-4">
            <form method="GET" action="{{ route('admin.promoCodeManagement') }}" id="filterForm">
                <div class="row">
                    <!-- From Date Filter -->
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" id="from" name="from_date" class="form-control"
                                value="{{ request()->from_date }}"
                                onchange="document.getElementById('filterForm').submit();" />
                        </div>
                    </div>

                    <!-- To Date Filter -->
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mt-4 w-100">
                            <label for="to" class="form-label">To:</label>
                            <input type="date" id="to" name="to_date" class="form-control"
                                value="{{ request()->to_date }}"
                                onchange="document.getElementById('filterForm').submit();" />
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
                    <div class="col-lg-3 ">
                    <div class="d-flex gap-3 justify-content-end" >
                        <a href="{{route('admin.promoCodeManagement')}}" class="btn btn-dark customBtn"
                            style="margin-top: 60px">
                            <span>Reset</span>
                        </a>
                    </div>
                </div>
                </div>
            </form>

            <div class="table-responsive w-100">
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
                                <div class="d-flex gap-3 justify-content-center">
                                    <a class="table-button" type="button" data-bs-toggle="modal"
                                        data-bs-target="#sentModal3"><i class="bi bi-pencil-square"></i></a>

                                      <!-- Delete button  -->
                                     <a
                                          href="javascript:void(0);"
                                          class="table-button text-danger deletePromoCode"
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

<div class="modal fade" id="sentModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Add New Brands</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group mb-3">
                                <label>Select country-</label>

                                <select name="new_duration_type" class="form-select">
                                    <option value="">All</option>
                                    <option value="1">Country 1</option>
                                    <option value="2">Country 2</option>
                                </select>

                            </div>
                        </div>

                        <!-- Brand Name English -->
                        <div class="col-lg-6 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label">Promocode Name (English)</label>
                                <input type="text" name="name_english" class="form-control"
                                    placeholder="EnterPromocode in English" />
                            </div>
                        </div>

                        <!-- Brand Name Arabic -->
                        <div class="col-lg-6 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label">Promocode Name (Arabic)</label>
                                <input type="text" name="name_arabic" class="form-control"
                                    placeholder="Enter Promocode in Arabic" />
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">

                            <div class="mb-3">
                                <label for="editReasonEnglish" class="form-label">Description (English)</label>
                                <textarea id="editReasonEnglish" name="reason_english" class="form-control"
                                    rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">

                            <div class="mb-3">
                                <label for="editReasonArabic" class="form-label">Description (Arabic)</label>
                                <textarea id="editReasonArabic" name="reason_arabic" class="form-control"
                                    rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group mb-3">
                                <label>Applicable for-</label>

                                <select name="new_duration_type" class="form-select">
                                    <option value="">All</option>
                                    <option value="1">First Order</option>
                                    <option value="2">Every Order</option>
                                </select>

                            </div>
                        </div>

                        <!-- Brand Name English -->
                        <div class="col-lg-6 ">
                            <div class="form-group mb-3">
                                <label class="form-label">Discount %</label>
                                <input type="text" name="name_english" class="form-control" placeholder="Enter " />
                            </div>
                        </div>

                        <!-- Brand Name Arabic -->
                        <div class="col-lg-6 ">
                            <div class="form-group mb-3">
                                <label class="form-label">Minimum Order Value</label>
                                <input type="text" name="name_arabic" class="form-control" placeholder="Enter " />
                            </div>
                        </div>
                        <div class="col-lg-12 ">
                            <div class="form-group mb-3">
                                <label class="form-label">Upto Discount</label>
                                <input type="text" name="name_arabic" class="form-control" placeholder="Enter " />
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-4 col-12">
                            <div class="form-group mb-3 ">
                                <label for="from" class="form-label">From:</label>
                                <input type="date" id="from" class="form-control" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-4 col-12">
                            <div class="form-group  mb-3">
                                <label for="from" class="form-label">To:</label>
                                <input type="date" id="from" class="form-control" />
                            </div>
                        </div>


                        <!-- Submit Button -->
                        <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                            <a type="button" id="submitBrandBtn" class="btn btn-dark customBtn mt-3">Submit</a>
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
                                <label for="description" class="form-label">Description</label>
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
                        toastr.success(data.message); // Green for active
                    } else {
                        toastr.error(data.message);   // Red for deactivated
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

@endsection