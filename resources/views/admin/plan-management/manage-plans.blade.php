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
                                    <th scope="col">No. of Store Employees</th>
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
                                    <td>N/A</td>
                                    <td>KD {{ $plan->price }}</td>
                                    <td>{{ $plan->commission_percentage === null ? 'No' : $plan->commission_percentage . '%' }}
                                    </td>
                                    <td>
                                        <div class="d-flex gap-3 justify-content-center">
                                            <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $plan->id }}">
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
                <!-- <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1> -->
                <h2 class="h2">Add Plan</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="appointment-container">
                    <form>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1" class="form-label">Plan Name
                                            (English)</label>
                                        <input type="text" placeholder="Enter plan name in english" class="form-control"
                                            aria-describedby="passwordHelpInline" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1" class="form-label">Plan Name
                                            (Arabic)</label>
                                        <input type="text" placeholder="Enter plan name in arabic" class="form-control"
                                            aria-describedby="passwordHelpInline" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1" class="form-label">Duration</label>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <input type="text" placeholder="Enter duration" class="form-control"
                                                    aria-describedby="passwordHelpInline" />
                                            </div>
                                            <div class="col-lg-6">
                                                <select class="form-select form-select-lg"
                                                    aria-label="Large select example">
                                                    <option selected>Select Duration</option>
                                                    <option value="1">Week</option>
                                                    <option value="2">Days</option>
                                                    <option value="3">Months</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1" class="form-label">No. of Videos</label>
                                        <input type="text" placeholder="Enter no.of videos" class="form-control"
                                            aria-describedby="passwordHelpInline" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1" class="form-label">No. of Products</label>
                                        <input type="text" placeholder="Enter no.of product" class="form-control"
                                            aria-describedby="passwordHelpInline" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1" class="form-label">No. of
                                            Highlights</label>
                                        <input type="text" placeholder="Enter no.of highlights" class="form-control"
                                            aria-describedby="passwordHelpInline" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1" class="form-label">No. of Employee</label>
                                        <input type="text" placeholder="Enter no.of employee" class="form-control"
                                            aria-describedby="passwordHelpInline" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1" class="form-label">Charges</label>
                                        <input type="text" placeholder="Enter charges" class="form-control"
                                            aria-describedby="passwordHelpInline" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1" class="form-label">Stories</label>
                                    <div class="row">
                                        <div class="col-lg-6 d-flex align-items-center">
                                            <input type="radio" id="chargesYes" name="charges" value="yes"
                                                class="form-check-input me-2" />
                                            <label for="chargesYes" class="form-check-label">Yes</label>
                                        </div>
                                        <div class="col-lg-6 d-flex align-items-center">
                                            <input type="radio" id="chargesNo" name="charges" value="no"
                                                class="form-check-input me-2" />
                                            <label for="chargesNo" class="form-check-label">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1" class="form-label">Commission</label>
                                    <div class="row">
                                        <div class="col-lg-6 d-flex align-items-center">
                                            <input type="radio" id="commissionYes" name="commission" value="yes"
                                                class="form-check-input me-2" />
                                            <label for="commissionYes" class="form-check-label">Yes</label>
                                        </div>

                                        <div class="col-lg-6 d-flex align-items-center">
                                            <input type="radio" id="commissionNo" name="commission" value="no"
                                                class="form-check-input me-2" />
                                            <label for="commissionNo" class="form-check-label">No</label>
                                        </div>
                                    </div>

                                    <!-- Ye input field initially hidden rahegi -->
                                    <div id="commissionInput" style="display: block;margin-top: 10px;width: 210px;">
                                        <input type="text" placeholder="Enter commission details" class="form-control"
                                            aria-describedby="passwordHelpInline" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                                <div class="d-flex align-items-center justify-content-center gap-3 mt-3"
                                    style="margin-top: 30px">
                                    <a class="btn btn-dark customBtn" href=""> Submit</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

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

 <!-- commission perecntage input field open close -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const yesRadio = document.getElementById("commissionYes");
    const noRadio = document.getElementById("commissionNo");
    const commissionInput = document.getElementById("commissionInput");

    function toggleCommissionInput() {
        commissionInput.style.display = yesRadio.checked ? "block" : "none";
    }
    toggleCommissionInput();
    yesRadio.addEventListener("change", toggleCommissionInput);
    noRadio.addEventListener("change", toggleCommissionInput);
});
</script>

<!-- page refresh while closing add modal -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('sentModal2');
    modal.addEventListener('hidden.bs.modal', function () {
        location.reload(); 
    });
});
</script>