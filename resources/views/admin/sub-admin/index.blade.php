@extends('admin.layout.app')
@section('content')

@php
    $admin = auth('admin')->user();

    $permissions = \App\Models\AdminPermission::where('admin_id', $admin->id)
        ->where('can_action', 1)
        ->pluck('module_id')
        ->toArray();
@endphp

<style>
.custom-checkbox input[type="checkbox"] {
    width: 18px !important;
    height: 18px !important;
    cursor: pointer !important;

    appearance: auto !important;
    -webkit-appearance: checkbox !important;

    background-color: #fff !important;
    border: 2px solid #0d6efd !important;
}

.custom-checkbox input[type="checkbox"]:checked {
    background-color: #0d6efd !important;
    border-color: #0d6efd !important;
}
</style>

<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">Sub-admin management</h2>
        </div>

        <div class="col-lg-3 col-md-4 col-12">
            @if(in_array(31, $permissions) || $admin->type == 1)
            <div class="d-flex justify-content-end">
                <a class="btn btn-dark customBtn" href="{{route('admin.add_subadmin')}}">
                    <span>Add Sub-admin</span>
                </a>
            </div>
            @endif
        </div>
    </div>

    <div class="userManagecontent">
        <div class="mt-4">
            <form method="GET" action="{{ route('admin.subAdminManagement') }}" id="filterForm">
            <div class="row align-items-end">
                <div class="col-lg-3 col-md-12 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="status" class="form-label">Country</label>
                        <select name="country_id" id="country_id" onchange="document.getElementById('filterForm').submit();" class="form-select form-select-lg">
                            <option value="">Select country</option>

                            @foreach($countries as $country)
                                <option value="{{ $country->id }}"
                                    {{ request('country_id') == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="status" class="form-label">Filter by status</label>
                        <select name="status" id="status"
                            onchange="document.getElementById('filterForm').submit();"
                            class="form-select form-select-lg">

                            <option value="">Select</option>

                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>
                                Inactive
                            </option>

                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="from_date" class="form-label">From:</label>
                        <input type="date" id="from_date" name="from_date" class="form-control"
                            value="{{ request()->from_date }}"
                            onchange="updateToDate(); document.getElementById('filterForm').submit();" />
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="to_date" class="form-label">To:</label>
                        <input type="date" id="to_date" name="to_date" class="form-control"
                            value="{{ request()->to_date }}"
                            onchange="updateToDate(); document.getElementById('filterForm').submit();" />
                    </div>
                </div>
                <div class="col-lg-2 col-md-12 col-12">
                    <div class="d-dlex justify-content-end mt-5">
                        <a href="{{route('admin.subAdminManagement')}}" class="btn btn-dark customBtn w-50 mt-2">
                            <span>Reset</span></a>
                    </div>
                </div>

            </div>
            </form>

            <div class="table-responsive w-100 mt-4">
                <table id="myTable" class="table w-100 custom-table">
                    <thead>
                        <tr>
                            <th>SR No.</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Phone number</th>
                            <th>Country</th>
                            <th>Email</th>
                            <th>View module</th>
                            <th>View credentials</th>
                            <th>Send credentials</th>
                            <th>Status</th>
                            @if(in_array(31, $permissions) || $admin->type == 1)
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($subAdmins->list as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d/m/y') }}</td>
                            <td>{{$data->full_name}}</td>

                            <td>
                                @if(!empty($data->profile_pic))
                                <img src="{{$data->profile_pic}}" alt="Profile Image" width="40px" height="40px"
                                    class="square" />
                                    @else
                                    N/A
                                    @endif
                            </td>

                            <td>{{$data->country_code}} {{$data->mobile}}</td>
                            <td>{{$data->country_info->name}}</td>
                            <td>{{$data->email}}</td>

                            <!-- View module -->
                            <td>
                                <a class="table-button view-bank-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#sentModal1"
                                data-modules='@json($data->permission_details)'>
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </td>

                            <!-- View credentials -->
                            <td>
                                <a class="table-button view-bank-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#Modal2"
                                data-email="{{ $data->email }}"
                                data-password="{{ $data->unhashed_password }}">

                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </td>

                            <!-- Send credentials -->
                            <td> 
                               <a class="table-button view-bank-btn send-credentials"
                                type="button"
                                data-id="{{ $data->id }}">
                                    <i class="bi bi-send-fill action-icon"></i>
                                </a>
                            </td>

                            <!-- Status -->
                            <td>
                                @if($data->status=='1')
                                <span class="status active">Active</span>
                                @else
                                <span class="status active">Inactive</span>
                                @endif
                            </td>

                            <!-- Action -->
                             @if(in_array(31, $permissions) || $admin->type == 1)
                            <td>
                                <div class="d-flex gap-3 justify-content-center">
                                    <!-- Edit button -->
                                    <a class="table-button editBrandBtn" href="{{ route('admin.edit_subadmin', $data->id) }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <!-- Delete button  -->
                                    <a class="table-button text-danger deleteSubAdmin mt-1 mb-1" data-id="{{ $data->id }}">
                                        <i class="bi bi-trash3-fill"></i>
                                    </a>

                                    <!-- Toggle switch -->
                                    <div class="form-check form-switch">
                                          <input
                                              class="form-check-input toggleStatus"
                                              type="checkbox"
                                              role="switch"
                                              id="switch{{ $data->id }}"
                                              data-id="{{ $data->id }}"
                                              {{ $data->status == 1 ? 'checked' : '' }}
                                          />
                                      </div>
                                </div>
                            </td>
                            @endif
                        </tr>
                         @empty

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal module -->

<div class="modal fade" id="sentModal1" tabindex="-1" aria-labelledby="sentModal1Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header management border-0">
                <h2 class="h2" id="sentModal1Label">Modules</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="appointment-container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">

                            <div id="moduleContainer">

                                <p class="text-muted text-center">No modules found</p>

                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- view cred modal -->
<div class="modal fade" id="Modal2" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title fs-5">Credential</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="form-group mb-2">
                    <label class="form-label">Email</label>
                    <input type="text" id="cred_email" class="form-control" readonly>
                </div>

                <div class="form-group mb-2">
                    <label class="form-label">Password</label>
                    <input type="text" id="cred_password" class="form-control" readonly>
                </div>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="Modal3" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <img src="image/check.png" alt="Success" class="mb-3 m-auto"
                    style="width: 60px;height: 60px;justify-content: center;display: flex;" />
                <h4 class="mb-3">Credentials sent successfully!</h4>
                <p>The credentials have been sent to the sub-admin's registered email address.</p>

            </div>
        </div>
    </div>
</div>

<!-- view module -->

<script>
// document.addEventListener('DOMContentLoaded', function () {

//     const modal = document.getElementById('sentModal1');
//     const container = document.getElementById('moduleContainer');

//     if (!modal || !container) return;

//     modal.addEventListener('show.bs.modal', function (event) {

//         const button = event.relatedTarget;

//         let modules = [];

//         try {
//             modules = JSON.parse(button.getAttribute('data-modules') || '[]');
//         } catch (e) {
//             console.log('Invalid module JSON');
//             modules = [];
//         }

//         container.innerHTML = '';

//         if (!Array.isArray(modules) || modules.length === 0) {
//             container.innerHTML = `<p class="text-center text-muted">No modules found</p>`;
//             return;
//         }

//         let html = '';

//         modules.forEach((item) => {

//             const moduleName = item?.module_details?.display_name || 'Module';

//             const canView = Number(item.can_view) === 1;
//             const canEdit = Number(item.can_action) === 1;

//             html += `
//                 <div class="module-block mb-3">

//                     <h5>${moduleName}</h5>

//                     <div class="d-flex gap-4 mt-2">

//                         <label class="custom-checkbox">
//                             <input type="checkbox" ${canView ? 'checked' : ''} onclick="return false;">
//                             View
//                         </label>

//                         <label class="custom-checkbox">
//                             <input type="checkbox" ${canEdit ? 'checked' : ''} onclick="return false;">
//                             Edit
//                         </label>

//                         <label class="custom-checkbox">
//                             <input type="checkbox" ${(canView && canEdit) ? 'checked' : ''} onclick="return false;">
//                             Both
//                         </label>

//                     </div>

//                 </div>
//             `;
//         });

//         container.innerHTML = html;

//     });

// });

document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById('sentModal1');
    const container = document.getElementById('moduleContainer');

    if (!modal || !container) return;

    modal.addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;

        let modules = [];

        try {
            modules = JSON.parse(button.getAttribute('data-modules') || '[]');
        } catch (e) {
            console.log('Invalid module JSON');
            modules = [];
        }

        let html = '';

        if (Array.isArray(modules)) {

            modules.forEach((item) => {

                const moduleName = item?.module_details?.display_name || 'Module';

                const canView = Number(item.can_view) === 1;
                const canEdit = Number(item.can_action) === 1;

                //  Skip if no permission at all
                if (!canView && !canEdit) return;

                let block = `
                    <div class="module-block mb-3">
                        <h5>${moduleName}</h5>
                        <div class="d-flex gap-4 mt-2">
                            
                            <label class="custom-checkbox">
                                <input type="checkbox" ${canView ? 'checked' : ''} onclick="return false;">
                                View
                            </label>

                            <label class="custom-checkbox">
                                <input type="checkbox" ${canEdit ? 'checked' : ''} onclick="return false;">
                                Edit
                            </label>

                        </div>
                    </div>
                `;

                html += block;
            });
        }

        if (html === '') {
            container.innerHTML = `<p class="text-center text-muted">No modules found</p>`;
        } else {
            container.innerHTML = html;
        }

    });

});
</script>

<!-- view credentials -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById('Modal2');

    modal.addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;

        const email = button.getAttribute('data-email') || '';
        const password = button.getAttribute('data-password') || '';

        document.getElementById('cred_email').value = email;
        document.getElementById('cred_password').value = password;

    });

});
</script>

<!-- send credentials -->
<script>
document.addEventListener('click', function (e) {

    if (e.target.closest('.send-credentials')) {

        let btn = e.target.closest('.send-credentials');
        let id = btn.getAttribute('data-id');

        btn.style.pointerEvents = 'none';

        fetch("{{ route('admin.sendCredentials') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ id: id })
        })
        .then(async res => {

            let data = await res.json();

            btn.style.pointerEvents = 'auto';

            if (data.status === 'success') {
                toastr.success(data.message);
            } else {
                toastr.error(data.message || 'Something went wrong');
            }

        })
        .catch(error => {

            btn.style.pointerEvents = 'auto';

            console.log(error);
            toastr.error('Request failed');

        });

    }

});
</script>

<!-- delete sub admin -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.deleteSubAdmin').forEach(button => {

        button.addEventListener('click', function () {

            let id = this.getAttribute('data-id');
            let row = this.closest('tr');

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {

                if (!result.isConfirmed) return;

                fetch(`/admin/deleteSubAdmin/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(async res => {

                    let data = await res.json();

                    if (!res.ok) {
                        throw data;
                    }

                    return data;
                })
                .then(data => {

                    if (data.status === 'success') {

                        toastr.success(data.message);
                        row.remove();

                    } else {
                        toastr.error(data.message || 'Something went wrong');
                    }

                })
                .catch(err => {

                    toastr.error(err.message || 'Something went wrong');

                });

            });

        });

    });

});
</script>

<!-- Update Brand Status -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.toggleStatus').forEach(toggle => {

        toggle.addEventListener('change', function () {

            let id = this.getAttribute('data-id');

            fetch(`/admin/updateSubAdminStatus/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {

                if (data.status === 'success') {

                    toastr.success(data.message); 

                } else {

                    toastr.error(data.message); 
                }

                setTimeout(() => {
                    location.reload();
                }, 1200);

            })
            .catch(() => {
                toastr.error('Something went wrong while updating status.');
            });

        });

    });

});
</script>

<script>
    function updateToDate() {
        const fromDate = document.getElementById('from_date').value;
        const toDateInput = document.getElementById('to_date');
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