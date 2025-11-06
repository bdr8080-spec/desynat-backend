@extends('admin.layout.app')
@section('content')

<div id="content-wrapper" class="d-flex flex-column position-relative">
    <div id="content" class="">


        <div class="inner-content management">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="d-flex align-items-center gap-3 mt-2">
                        <div class="arrow">
                            <a class="table-button" type="button" href="{{route('countryManagement')}}">
                                <i class="fas fa-angle-left"></i>
                            </a>
                        </div>
                        <h6 class="m-0">Manage City({{$country->name}})</h6>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-12">
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-dark customBtn" data-bs-toggle="modal" data-bs-target="#sentModal2">
                            <span>Add City</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="userManagecontent">
                <div class="mt-4">
                    <!-- <div class="align-items-end d-flex">
                        <div class="search-box" style="position: relative; ">
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
                                    <th scope="col">City Name</th>
                                    <th scope="col">Manage Zones</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($serviceCities as $index => $city)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $city->name }}</td>
                                        <td>
                                            <a class="btn btn-dark customBtn"
                                            href="{{ route('manageZones', ['id' => $city->id ]) }}">
                                                <span>Manage</span>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-3 justify-content-center">
                                                <a href="javascript:void(0);" class="table-button text-danger deleteCity"
                                                    data-id="{{ $city->id }}">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </a>

                                                <div class="form-check form-switch">
                                                    <input class="form-check-input toggleStatus" type="checkbox"
                                                        role="switch" id="switch{{ $city->id }}" data-id="{{ $city->id }}"
                                                        {{ $city->status == 1 ? 'checked' : '' }} />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No cities found for this country.</td>
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
</div>

<!-- add new model -->
<div class="modal fade" id="sentModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <!-- <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1> -->
                <h2 class="h2">Add City</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-lg-12">

                        <div class="form-group w-100">
                            <label for="city_id" class="form-label">City Name</label>
                            <select name="city_id" id="city_id" class="form-select form-select-lg" aria-label="Select City">
                                <option value="" selected disabled>Select City</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text city_id_err"></span>
                        </div>


                    </div>
                    <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                        <div class="d-flex align-items-center justify-content-center gap-3 mt-3" style="margin-top: 30px">
                            <button type="button" id="addServiceCityBtn" class="btn btn-dark customBtn">Submit</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


@endsection
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- add service city -->
<script>
$(document).ready(function() {

    $('#addServiceCityBtn').on('click', function(e) {
        e.preventDefault();

        $('.error-text').text('');

        let cityId = $('#city_id').val();

        if (!cityId) {
            $('.city_id_err').text('Please select a city.');
            return;
        }

        $.ajax({
            url: "{{ route('admin.addServiceCity') }}",
            type: "POST",
            data: {
                city_id: cityId,
                _token: "{{ csrf_token() }}"
            },
            beforeSend: function() {
                $('#addServiceCityBtn').prop('disabled', true).text('Submitting...');
            },
            success: function(response) {
                if (response.status === 'success') {
                    toastr.success(response.message);
                    $('#sentModal2').modal('hide');
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    toastr.error(response.message || 'Failed to add city');
                }
            },
            error: function(xhr) {
                toastr.error('Something went wrong! Please try again.');
                console.error(xhr.responseText);
            },
            complete: function() {
                $('#addServiceCityBtn').prop('disabled', false).text('Submit');
            }
        });
    });

});
</script>

<!-- Update service city status -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.toggleStatus').forEach(toggle => {
        toggle.addEventListener('change', function() {
            let cityId = this.getAttribute('data-id');

            fetch(`/admin/change_service_city_status/${cityId}`, {
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

<!-- Delete service city -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.deleteCity').forEach(button => {
        button.addEventListener('click', function() {
            let cityId = this.getAttribute('data-id');

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
                    fetch(`/admin/deleteServiceCity/${cityId}`, {
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
