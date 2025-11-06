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
                        <h6 class="m-0">Subscription Plan</h6>
                    </div>
                </div>

                <div class="col-lg-6 col-md-4 col-12">
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-dark customBtn" data-bs-toggle="modal" data-bs-target="#sentModal2">
                            <span>Add Subscription Plan</span>
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
                                    <th scope="col">SR No.</th>
                                    <th scope="col">Subscription Plan Name(English)</th>
                                    <th scope="col">Subscription Plan Name(Arabic)</th>
                                    <th scope="col">Duration</th>
                                    <th scope="col">No. of Products</th>
                                    <th scope="col">No. of Videos</th>
                                    <th scope="col">No. of Highlights</th>
                                    <th scope="col">Stories</th>
                                    <th scope="col">No. of Employees</th>
                                    <th scope="col">Plan Price</th>
                                    <th scope="col">Commission %</th>
                                    <th scope="col">Action</th>
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
                                        Month
                                        @elseif($plan->duration_type == 2)
                                        Year
                                        @else
                                        N/A
                                        @endif
                                    </td>
                                    <td>{{ $plan->no_of_products }}</td>
                                    <td>{{ $plan->no_of_videos }}</td>
                                    <td>{{ $plan->no_of_highlights }}</td>
                                    <td>
                                        @if($plan->stories == 0)
                                        Close
                                        @elseif($plan->stories == 1)
                                        Open
                                        @else
                                        N/A
                                        @endif
                                    </td>
                                    <td>{{ $plan->no_of_employee }}</td>
                                    <td>KD {{ $plan->price }}</td>
                                    <td>{{ $plan->commission_percentage === null ? 'No' : $plan->commission_percentage . '%' }}
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
                                                data-no-of-videos="{{ $plan->no_of_videos }}"
                                                data-no-of-products="{{ $plan->no_of_products }}"
                                                data-no-of-highlights="{{ $plan->no_of_highlights }}"
                                                data-no-of-employees="{{ $plan->no_of_employee }}"
                                                data-price="{{ $plan->price }}"
                                                data-stories="{{ $plan->stories }}"
                                                data-commission="{{ $plan->commission }}"
                                                data-commission-percentage="{{ $plan->commission_percentage }}">
                                                    <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <a href="javascript:void(0);" class="table-button text-danger deletePlan"
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
                                <tr>
                                    <td colspan="11" class="text-center">No plans found for this country</td>
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


<!-- add new model -->
<div class="modal fade" id="sentModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Add Plan</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="appointment-container">
                    <form id="addPlanForm">
                        <div class="row">
                            <input type="hidden" name="country_id" value="{{ request()->segment(3) }}" >
                            <!-- Plan Name English -->
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Plan Name (English)</label>
                                    <input type="text" name="plan_name_english" placeholder="Enter plan name in English" oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')" class="form-control">
                                    <span class="text-danger error-text plan_name_english_err"></span>
                                </div>
                            </div>

                            <!-- Plan Name Arabic -->
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Plan Name (Arabic)</label>
                                    <input type="text" name="plan_name_arabic" placeholder="Enter plan name in Arabic" oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')" class="form-control">
                                    <span class="text-danger error-text plan_name_arabic_err"></span>
                                </div>
                            </div>

                            <!-- Duration -->
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Duration</label>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input type="text" name="duration" placeholder="Enter duration" oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')" maxlength="2" class="form-control">
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

                            <!-- No. of Videos -->
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>No. of Videos</label>
                                    <input type="text" name="no_of_videos" placeholder="Enter number of videos" oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')" maxlength="3" class="form-control">
                                    <span class="text-danger error-text no_of_videos_err"></span>
                                </div>
                            </div>

                            <!-- No. of Products -->
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>No. of Products</label>
                                    <input type="text" name="no_of_products" placeholder="Enter number of products" oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')" maxlength="4" class="form-control">
                                    <span class="text-danger error-text no_of_products_err"></span>
                                </div>
                            </div>

                            <!-- No. of Highlights -->
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>No. of Highlights</label>
                                    <input type="text" name="no_of_highlights" placeholder="Enter number of highlights" oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')" maxlength="3" class="form-control">
                                    <span class="text-danger error-text no_of_highlights_err"></span>
                                </div>
                            </div>

                            <!-- No. of Employee -->
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>No. of Employees</label>
                                    <input type="text" name="no_of_employee" placeholder="Enter number of employees" oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')" maxlength="4" class="form-control">
                                    <span class="text-danger error-text no_of_employee_err"></span>
                                </div>
                            </div>

                            <!-- Charges -->
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Charges</label>
                                    <input type="text" name="price" placeholder="Enter charges" oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/^0+([1-9])/,'$1').replace(/^0+$/,'').replace(/(\..*?)\..*/,'$1').replace(/(\.\d{2}).*/,'$1')" class="form-control">
                                    <span class="text-danger error-text price_err"></span>
                                </div>
                            </div>

                            <!-- Stories -->
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Stories</label>
                                    <div class="row">
                                        <div class="col-lg-6 d-flex align-items-center">
                                            <input type="radio" id="storiesYes" name="stories" value="yes" class="form-check-input me-2">
                                            <label for="storiesYes" class="form-check-label">Yes</label>
                                        </div>
                                        <div class="col-lg-6 d-flex align-items-center">
                                            <input type="radio" id="storiesNo" name="stories" value="no" class="form-check-input me-2">
                                            <label for="storiesNo" class="form-check-label">No</label>
                                        </div>
                                    </div>
                                    <span class="text-danger error-text stories_err"></span>
                                </div>
                            </div>

                            <!-- Commission -->
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Commission</label>
                                    <div class="row">
                                        <div class="col-lg-6 d-flex align-items-center">
                                            <input type="radio" id="commissionYes" name="commission" value="yes" class="form-check-input me-2">
                                            <label for="commissionYes" class="form-check-label">Yes</label>
                                        </div>
                                        <div class="col-lg-6 d-flex align-items-center">
                                            <input type="radio" id="commissionNo" name="commission" value="no" class="form-check-input me-2">
                                            <label for="commissionNo" class="form-check-label">No</label>
                                        </div>
                                    </div>
                                    <span class="text-danger error-text commission_err"></span>

                                    <!-- Commission Percentage -->
                                    <div id="commissionInput" style="display:none; margin-top:10px;">
                                        <input type="text" name="commission_percentage" placeholder="Enter commission percentage" class="form-control">
                                        <span class="text-danger error-text commission_percentage_err"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-lg-12 d-flex justify-content-center mt-3">
                                <button type="submit" class="btn btn-dark customBtn">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Plan Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Edit Plan</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <form class="editPlanForm" data-id="{{ $plan->id }}">
                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                        <input type="hidden" name="country_id" value="{{ request()->segment(3) }}">

                        <div class="row">
                            <!-- Plan Name English -->
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Plan Name (English)</label>
                                    <input type="text" name="plan_name_english" value="{{ $plan->plan_name_english }}" oninput="this.value=this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')" class="form-control">
                                    <span class="text-danger error-text plan_name_english_err"></span>
                                </div>
                            </div>

                            <!-- Plan Name Arabic -->
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Plan Name (Arabic)</label>
                                    <input type="text" name="plan_name_arabic" value="{{ $plan->plan_name_arabic }}" oninput="this.value=this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')" class="form-control">
                                    <span class="text-danger error-text plan_name_arabic_err"></span>
                                </div>
                            </div>

                            <!-- Duration -->
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Duration</label>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input type="text" name="duration" value="{{ $plan->duration }}" placeholder="Enter duration" oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')" maxlength="2" class="form-control">
                                            <span class="text-danger error-text duration_err"></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <select name="duration_type" class="form-select">
                                                <option value="">Select Duration</option>
                                                <option value="1" {{ $plan->duration_type == 1 ? 'selected' : '' }}>Months</option>
                                                <option value="2" {{ $plan->duration_type == 2 ? 'selected' : '' }}>Years</option>
                                            </select>
                                            <span class="text-danger error-text duration_type_err"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Numeric Fields -->
                            <div class="col-lg-12">
                                <label>No. of Videos</label>
                                <input type="text" name="no_of_videos" value="{{ $plan->no_of_videos }}" oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')" class="form-control">
                                <span class="text-danger error-text no_of_videos_err"></span>
                            </div>

                            <div class="col-lg-12">
                                <label>No. of Products</label>
                                <input type="text" name="no_of_products" value="{{ $plan->no_of_products }}" oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')" class="form-control">
                                <span class="text-danger error-text no_of_products_err"></span>
                            </div>

                            <div class="col-lg-12">
                                <label>No. of Highlights</label>
                                <input type="text" name="no_of_highlights" value="{{ $plan->no_of_highlights }}" oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')" class="form-control">
                                <span class="text-danger error-text no_of_highlights_err"></span>
                            </div>

                            <div class="col-lg-12">
                                <label>No. of Employees</label>
                                <input type="text" name="no_of_employee" value="{{ $plan->no_of_employee }}" oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'')" class="form-control">
                                <span class="text-danger error-text no_of_employee_err"></span>
                            </div>

                            <!-- Charges -->
                            <div class="col-lg-12">
                                <label>Charges</label>
                                <input type="text" name="price" value="{{ $plan->price }}" oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/^0+([1-9])/,'$1').replace(/^0+$/,'').replace(/(\..*?)\..*/,'$1').replace(/(\.\d{2}).*/,'$1')" class="form-control">
                                <span class="text-danger error-text price_err"></span>
                            </div>

                            <!-- Stories -->
                            <div class="col-lg-12">
                                <label>Stories</label>
                                <div class="row">
                                    <div class="col-lg-6 d-flex align-items-center">
                                        <input type="radio" name="stories" value="yes" {{ $plan->stories == 1 ? 'checked' : '' }}> Yes
                                    </div>
                                    <div class="col-lg-6 d-flex align-items-center">
                                        <input type="radio" name="stories" value="no" {{ $plan->stories == 0 ? 'checked' : '' }}> No
                                    </div>
                                </div>
                                <span class="text-danger error-text stories_err"></span>
                            </div>

                            <!-- Commission -->
                            <div class="col-lg-12">
                                <label>Commission</label>
                                <div class="row">
                                    <div class="col-lg-6 d-flex align-items-center">
                                        <input type="radio" class="commissionRadio" name="commission" value="yes" {{ $plan->commission == 1 ? 'checked' : '' }}> Yes
                                    </div>
                                    <div class="col-lg-6 d-flex align-items-center">
                                        <input type="radio" class="commissionRadio" name="commission" value="no" {{ $plan->commission == 0 ? 'checked' : '' }}> No
                                    </div>
                                </div>
                                <span class="text-danger error-text commission_err"></span>

                                <div class="commissionInput" style="margin-top:10px; {{ $plan->commission == 1 ? '' : 'display:none;' }}">
                                    <input type="text" name="commission_percentage" value="{{ $plan->commission_percentage }}" placeholder="Enter commission percentage" class="form-control">
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
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, delete it!"
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

<!-- add plan -->
<script>
$(document).ready(function() {

    $('input[name="commission"]').change(function() {
        if($(this).val() === 'yes'){
            $('#commissionInput').show();
        } else {
            $('#commissionInput').hide();
            $('input[name="commission_percentage"]').val('');
            $('.commission_percentage_err').text('');
        }
    });

    $('#addPlanForm').on('input change', 'input, select', function() {
        let name = $(this).attr('name');
        $('.' + name + '_err').text('');
    });

    $('#addPlanForm').submit(function(e){
        e.preventDefault();
        $('.error-text').text(''); 

        let plan_name_english = $('input[name="plan_name_english"]').val().trim();
        let plan_name_arabic = $('input[name="plan_name_arabic"]').val().trim();
        let duration = $('input[name="duration"]').val().trim();
        let duration_type = $('select[name="duration_type"]').val();
        let no_of_videos = $('input[name="no_of_videos"]').val().trim();
        let no_of_products = $('input[name="no_of_products"]').val().trim();
        let no_of_highlights = $('input[name="no_of_highlights"]').val().trim();
        let no_of_employee = $('input[name="no_of_employee"]').val().trim();
        let stories = $('input[name="stories"]:checked').val();
        let price = $('input[name="price"]').val().trim();
        let commission = $('input[name="commission"]:checked').val();
        let commission_percentage = $('input[name="commission_percentage"]').val().trim();
        let country_id = $('input[name="country_id"]').val().trim(); 

        let valid = true;

        if(!plan_name_english){ $('.plan_name_english_err').text('Please Enter Plan Name (English)'); valid=false; }
        if(!plan_name_arabic){ $('.plan_name_arabic_err').text('Please Enter Plan Name (Arabic)'); valid=false; }
        if(!duration){ $('.duration_err').text('Please Enter Duration'); valid=false; }
        if(!duration_type){ $('.duration_type_err').text('Please Select Duration Type'); valid=false; }
        if(!no_of_videos){ $('.no_of_videos_err').text('Please Enter Number Of Videos'); valid=false; }
        if(!no_of_products){ $('.no_of_products_err').text('Please Enter Number Of Products'); valid=false; }
        if(!no_of_highlights){ $('.no_of_highlights_err').text('Please Enter Number Of Highlights'); valid=false; }
        if(!no_of_employee){ $('.no_of_employee_err').text('Please Enter Number Of Employees'); valid=false; }
        if(!stories){ $('.stories_err').text('Please Select Stories'); valid=false; }
        if(!price){ $('.price_err').text('Please Enter Charges'); valid=false; }
        if(!commission){ $('.commission_err').text('Please Select Commission'); valid=false; }
        if(commission === 'yes' && !commission_percentage){ $('.commission_percentage_err').text('Please Enter Commission Percentage'); valid=false; }

        if(duration_type === '1' && parseInt(duration) > 12){
            $('.duration_err').text('Duration cannot be more than 12 months');
            valid = false;
        }

        if(!valid) return;

        let formData = {
            plan_name_english, plan_name_arabic, duration, duration_type, no_of_videos, 
            no_of_products, no_of_highlights, no_of_employee, stories, price, commission, commission_percentage,country_id
        };

        $.ajax({
            url: "{{ route('admin.add_plan') }}",
            method: 'POST',
            data: formData,
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            success: function(response){
                if(response.status === 'success'){
                    toastr.success(response.message, 'Success');
                    setTimeout(() => {
                        $('#sentModal2').modal('hide');
                        location.reload();
                    }, 2000);
                } else {
                    toastr.error(response.message || 'Something went wrong', 'Error');
                }
            },
            error: function(xhr){
                toastr.error('Something went wrong! Please try again.', 'Error');
                console.log(xhr.responseText);
            }
        });
    });

});
</script>


<!-- page refresh while closing add modal -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('sentModal2');
    modal.addEventListener('hidden.bs.modal', function () {
        location.reload(); 
    });
    var modal = document.getElementById('editModal');
    modal.addEventListener('hidden.bs.modal', function () {
        location.reload(); 
    });
});
</script>

<!-- edit plan -->
<script>
$(document).ready(function() {

    $(document).on('click', '[data-bs-target="#editModal"]', function() {
        var button = $(this); 

        var plan_id = button.data('plan-id');
        var english_name = button.data('english-name');
        var arabic_name = button.data('arabic-name');
        var duration = button.data('duration');
        var duration_type = button.data('duration-type');
        var no_of_videos = button.data('no-of-videos');
        var no_of_products = button.data('no-of-products');
        var no_of_highlights = button.data('no-of-highlights');
        var no_of_employees = button.data('no-of-employees');
        var price = button.data('price');
        var stories = button.data('stories');
        var commission = button.data('commission');
        var commission_percentage = button.data('commission-percentage');

        $('#editModal').find('input[name="plan_id"]').val(plan_id);
        $('#editModal').find('input[name="plan_name_english"]').val(english_name);
        $('#editModal').find('input[name="plan_name_arabic"]').val(arabic_name);
        $('#editModal').find('input[name="duration"]').val(duration);
        $('#editModal').find('select[name="duration_type"]').val(duration_type);
        $('#editModal').find('input[name="no_of_videos"]').val(no_of_videos);
        $('#editModal').find('input[name="no_of_products"]').val(no_of_products);
        $('#editModal').find('input[name="no_of_highlights"]').val(no_of_highlights);
        $('#editModal').find('input[name="no_of_employee"]').val(no_of_employees);
        $('#editModal').find('input[name="price"]').val(price);
        $('#editModal').find('input[name="stories"]').prop('checked', false);
    $('#editModal').find('input[name="stories"][value="' + (stories == 1 ? 'yes' : 'no') + '"]').prop('checked', true);

    // Reset and set Commission radio
    $('#editModal').find('input[name="commission"]').prop('checked', false);
    $('#editModal').find('input[name="commission"][value="' + (commission == 1 ? 'yes' : 'no') + '"]').prop('checked', true);

        if (commission == '1') {
            $('#editModal').find('.commissionInput').show();
            $('#editModal').find('input[name="commission_percentage"]').val(commission_percentage);
        } else {
            $('#editModal').find('.commissionInput').hide();
        }
    });

    $(document).on('change', '.commissionRadio', function() {
        let parent = $(this).closest('.modal');
        if ($(this).val() === 'yes') {
            parent.find('.commissionInput').show(); 
        } else {
            parent.find('.commissionInput').hide(); 
            parent.find('input[name="commission_percentage"]').val(''); 
        }
    });

    $(document).on('submit', '.editPlanForm', function(e) {
        e.preventDefault(); 

        let form = $(this); 
        let modal = form.closest('.modal');  
        let valid = true; 

        modal.find('.error-text').text(''); 

        let formData = form.serializeArray().reduce((obj, item) => {
            obj[item.name] = item.value.trim();
            return obj;
        }, {});

        if (!formData.plan_name_english) {
            modal.find('.plan_name_english_err').text('Please Enter Plan Name (English)');
            valid = false;
        }
        if (!formData.plan_name_arabic) {
            modal.find('.plan_name_arabic_err').text('Please Enter Plan Name (Arabic)');
            valid = false;
        }
        if (!formData.duration) {
            modal.find('.duration_err').text('Please Enter Duration');
            valid = false;
        }
        if (!formData.duration_type) {
            modal.find('.duration_type_err').text('Please Select Duration Type');
            valid = false;
        }
        if (!formData.no_of_videos) {
            modal.find('.no_of_videos_err').text('Please Enter Number Of Videos');
            valid = false;
        }
        if (!formData.no_of_products) {
            modal.find('.no_of_products_err').text('Please Enter Number Of Products');
            valid = false;
        }
        if (!formData.no_of_highlights) {
            modal.find('.no_of_highlights_err').text('Please Enter Number Of Highlights');
            valid = false;
        }
        if (!formData.no_of_employee) {
            modal.find('.no_of_employee_err').text('Please Enter Number Of Employees');
            valid = false;
        }
        if (!formData.stories) {
            modal.find('.stories_err').text('Please Select Stories');
            valid = false;
        }
        if (!formData.price) {
            modal.find('.price_err').text('Please Enter Charges');
            valid = false;
        }
        if (!formData.commission) {
            modal.find('.commission_err').text('Please Select Commission');
            valid = false;
        }

        if (formData.commission === 'yes' && !formData.commission_percentage) {
            modal.find('.commission_percentage_err').text('Please Enter Commission Percentage');
            valid = false;
        }

        if (formData.duration_type === '1' && parseInt(formData.duration) > 12) {
            modal.find('.duration_err').text('Duration cannot be more than 12 months');
            valid = false;
        }

        if (!valid) return;

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
                    }, 2000);
                } else {
                    toastr.error(response.message || 'Failed to update plan'); 
                }
            },
            error: function(xhr) {
                toastr.error('Something went wrong! Please try again.');  
               // console.log(xhr.responseText);  
            }
        });
    });

});

</script>
