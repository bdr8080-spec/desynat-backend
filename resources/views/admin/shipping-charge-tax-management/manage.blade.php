@extends('admin.layout.app')
@section('content')


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
                        <h6 class="m-0">{{$country->name}}</h6>
                    </div>
                </div>

                <div class="col-lg-6 col-md-4 col-12">
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-dark customBtn" data-bs-toggle="modal" data-bs-target="#sentModal2">
                            <span>Add Shipping Fee</span>
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
                                    <th scope="col">SR No.</th>
                                    <th scope="col">Range From to To (KM)</th>
                                    <th scope="col">Shipping Fee</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($shippingCharges as $key => $charge)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>{{$charge['range_from']}}Km to {{$charge['range_to']}}Km</td>
                                    <td>{{$charge['shipping_fee']}} KD</td>
                                    <td>
                                        <div class="d-flex gap-3 justify-content-center">
                                            <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal3"><i class="bi bi-pencil-square"></i>
                                            </a>

                                            <!-- Delete button  -->
                                            <a
                                                href="javascript:void(0);"
                                                class="table-button text-danger deleteShippingCharge"
                                                data-id="{{ $charge->id }}"
                                            >
                                                <i class="bi bi-trash3-fill"></i>
                                            </a>

                                            <!-- Toggle switch -->
                                            <div class="form-check form-switch">
                                                <input
                                                    class="form-check-input toggleStatus"
                                                    type="checkbox"
                                                    role="switch"
                                                    id="switch{{ $charge->id }}"
                                                    data-id="{{ $charge->id }}"
                                                    {{ $charge->status == 1 ? 'checked' : '' }}
                                                />
                                            </div>
                                        </div>

                                    </td>

                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No Data found</td>
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


<div class="modal fade" id="sentModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Add Shipping Fee</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label">Range</label>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <label class="form-label">From</label>
                                        <select class="form-select form-select-lg mb-3"
                                            aria-label="Large select example">
                                            <option selected>0KM</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <label class="form-label">To</label>
                                        <select class="form-select form-select-lg mb-3"
                                            aria-label="Large select example">
                                            <option selected>0KM</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label">For User</label>
                                <input type="text" name="name_english" class="form-control" placeholder="Enter " />
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

<!-- Delete -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.deleteShippingCharge').forEach(button => {
        button.addEventListener('click', function () {
            let shippingId = this.getAttribute('data-id');

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

<!-- Update Status -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggleStatus').forEach(toggle => {
        toggle.addEventListener('change', function () {
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
                     if(data.status == 1){
                        toastr.success(data.message); // Green for active
                    } else {
                        toastr.error(data.message);   // Red for deactivated
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

@endsection