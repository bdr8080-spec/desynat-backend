@extends('admin.layout.app')
@section('content')

<style>
#editPreviewImage {
    display: block;
}

.upload-box {
    width: 220px;
    height: 160px;
    border: 2px dotted #c8ad8d;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    position: relative;
    overflow: hidden;
    cursor: pointer;
}

.upload-icon {
    width: 60px;
    opacity: 0.5;
}

.upload-text {
    margin-top: 10px;
    font-size: 14px;
    color: #444;
}

.preview-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: absolute;
    top: 0;
    left: 0;
    display: none;
}
</style>


<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">Banner Management</h2>
        </div>
    </div>


    <div class="d-flex justify-content-center">
        <ul class="nav nav-pills mb-3 tabs-pnl custom" id="pills-tab" role="tablist">
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0 active" id="pills-fullscreen-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-fullscreen" type="button" role="tab" aria-controls="pills-fullscreen"
                    aria-selected="true">
                    Full Screen
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link  customBtn2 m-0" id="pills-promo-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-promo" type="button" role="tab" aria-controls="pills-promo"
                    aria-selected="true">
                    Promotional
                </button>
            </li>
        </ul>
    </div>


    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-fullscreen" role="tabpanel"
            aria-labelledby="pills-fullscreen-tab" tabindex="0">
            <div class="d-flex justify-content-between align-items-center">
                <form method="GET" action="{{ route('admin.fullScreenBannerManagement') }}" id="filterForm">
                    <div class="form-group mb-3">
                        <label for="from" class="form-label">Country Name</label>
                        <select name="country" class="form-select form-select-lg"
                            onchange="document.getElementById('filterForm').submit();">
                            <option value="">Select country</option>
                            @foreach($countries as $country)
                            <option value="{{ $country['name'] }}"
                                {{ request('country') == $country['name'] ? 'selected' : '' }}>
                                {{ $country['name'] }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </form>
                <div class="d-flex justify-content-end">
                    <a class="btn btn-dark customBtn" data-bs-toggle="modal" data-bs-target="#sentModal2">
                        <span>Add Advertisement</span>
                    </a>
                </div>
            </div>

            <div class="userManagecontent">
                <div class="">
                    <div class="table-responsive mb-5 w-100">
                        <table id="myTable" class="table w-100">
                            <thead>
                                <tr>
                                    <th scope="col">SR No.</th>
                                    <th scope="col">Banner</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Country</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">End Date</th>
                                    <th scope="col">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse($banners as $index => $banner)
                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>
                                        <a href="{{ $banner['image'] }}" target="_blank">
                                            <img src="{{ $banner['image'] }}" alt="" width="40" height="40"
                                                class="square">
                                        </a>
                                    </td>
                                    <td>{{ $banner['title'] }}</td>
                                    <td>
                                        @if($banner['type'] == '1')
                                        Mobile
                                        @else
                                        Web
                                        @endif
                                    </td>
                                    <td>{{ $banner['country_info']['name'] }}</td>
                                    <td>{{ $banner['start_date'] }}</td>
                                    <td>{{ $banner['end_date'] }}</td>
                                    <td>
                                        <div class="d-flex gap-3 justify-content-center">
                                            <a href="javascript:void(0);" class="table-button edit-reason-btn"
                                                data-id="{{ $banner['id'] }}" data-title="{{ $banner['title'] }}"
                                                data-country-id="{{ $banner['country_id'] }}"
                                                data-type="{{ $banner['type'] }}"
                                                data-start-date="{{ $banner['start_date'] }}"
                                                data-end-date="{{ $banner['end_date'] }}"
                                                data-image="{{ $banner['image'] }}" data-bs-toggle="modal"
                                                data-bs-target="#editBannerModal">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <a href="javascript:void(0);"
                                                class="table-button text-danger deleteBanner mb-1 mt-1"
                                                data-id="{{ $banner->id }}">
                                                <i class="bi bi-trash3-fill"></i>
                                            </a>
                                        </div>
                                    </td>

                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No data found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="pills-promo" role="tabpanel" aria-labelledby="pills-promo-tab" tabindex="0">
            <div class="d-flex justify-content-between align-items-center">
                <form method="GET" action="{{ route('admin.fullScreenBannerManagement') }}" id="filterForm">
                    <div class="form-group mb-3">
                        <label for="from" class="form-label">Country Name</label>
                        <select name="country" class="form-select form-select-lg"
                            onchange="document.getElementById('filterForm').submit();">
                            <option value="">Select country</option>
                            @foreach($countries as $country)
                            <option value="{{ $country['name'] }}"
                                {{ request('country') == $country['name'] ? 'selected' : '' }}>
                                {{ $country['name'] }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </form>
                <div class="d-flex justify-content-end">
                    <a class="btn btn-dark customBtn" data-bs-toggle="modal" data-bs-target="#sentModal2">
                        <span>Add Promotional</span>
                    </a>
                </div>
            </div>

            <div class="userManagecontent">
                <div class="table-responsive mb-5 w-100">
                    <table id="myTable" class="table w-100 comyTable3">
                        <thead>
                            <tr>
                                <th scope="col">SR No.</th>
                                <th scope="col">Banner</th>
                                <th scope="col">Title</th>
                                <th scope="col">Type</th>
                                <th scope="col">Position</th>
                                <th scope="col">Country</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                           
                            <tr>
                                <th scope="row">1</th>
                                <td>
                                    <a href="#" target="_blank">
                                        <img src="" alt="image" width="40" height="40" class="square">
                                    </a>
                                </td>
                                <td>rreg</td>
                                <td>Mobile</td>
                                <td>Top</td>
                                <td>India</td>
                                <td>2026-01-21</td>
                                <td>2026-01-21</td>
                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a href="javascript:void(0);" class="table-button edit-reason-btn"
                                           data-bs-toggle="modal"
                                            data-bs-target="#editBannerModal">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <a href="javascript:void(0);"
                                            class="table-button text-danger deleteBanner mb-1 mt-1">
                                            <i class="bi bi-trash3-fill"></i>
                                        </a>
                                    </div>
                                </td>

                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="sentModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Add Advertisement</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <div class="row">

                        <!-- Image Upload -->
                        <div class="col-lg-12">
                            <div class="upload-title text-center">Upload Image</div>

                            <label for="fileUpload" class="upload-box" style="cursor:pointer;">
                                <img src="/admin/image/imge-upload.svg" id="uploadIcon" />
                                <img id="previewImage" class="preview-image"
                                    style="display:none; max-width:216px; margin-top:-2px;" />
                                <div class="upload-text">Upload Image</div>
                                <input type="file" id="fileUpload" name="image" accept="image/*" hidden />
                            </label>
                            <div class="text-danger text-center" id="imageError"></div>
                        </div>

                        <!-- Title -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label" for="title">Title</label>
                                <input type="text" id="title" name="title" class="form-control"
                                    placeholder="Enter Title"
                                    oninput="this.value=this.value.replace(/[^A-Za-z0-9 ]/g,'').replace(/^\s+/,'')" />
                                <div class="text-danger" id="titleError"></div>
                            </div>
                        </div>

                        <!-- Country -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group w-100">
                                <label class="form-label">Select Country</label>
                                <select id="countrySelect" name="country_id" class="form-select form-select-lg"
                                    aria-label="Large select example">
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger" id="countryError"></div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group w-100">
                                <label class="form-label">For</label>
                                <select id="forSelect" name="type" class="form-select form-select-lg"
                                    aria-label="Large select example">
                                    <option value="">Select Type</option>
                                    <option value="1">Mobile</option>
                                    <option value="2">Web</option>
                                </select>
                                <div class="text-danger" id="forError"></div>
                            </div>
                        </div>


                        <!-- Dates -->
                        <div class="col-lg-12">
                            <div class="d-flex gap-2">

                                <div class="col-lg-6">
                                    <div class="form-group  w-100">
                                        <label class="form-label">From:</label>
                                        <input type="date" id="start_date" name="start_date" class="form-control" />
                                        <div class="text-danger" id="startDateError"></div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group  w-100">
                                        <label class="form-label">To:</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control" />
                                        <div class="text-danger" id="endDateError"></div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                            <a type="button" id="submitBannerBtn" class="btn btn-dark customBtn mt-3">
                                Submit
                            </a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- edit modal -->
<div class="modal fade" id="editBannerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header management border-0">
                <h2 class="h2">Edit Advertisement</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="upload-title text-center">Upload Image</div>

                            <label for="editFileUpload" class="upload-box" style="cursor:pointer;">
                                <img src="/admin/image/imge-upload.svg" id="editUploadIcon" />
                                <img id="editPreviewImage" class="preview-image"
                                    style="display:none; max-width:216px; margin-top:-2px;" />
                                <div class="upload-text">Upload Image</div>
                                <input type="file" id="editFileUpload" hidden />
                            </label>
                            <div class="text-danger text-center" id="editImageError"></div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">

                                <label class="form-label">Title</label>
                                <input type="text" id="editTitle" class="form-control"
                                    oninput="this.value=this.value.replace(/[^A-Za-z0-9 ]/g,'').replace(/^\s+/,'')">
                                <div class="text-danger" id="editTitleError"></div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group w-100">
                                <label class="form-label">Select Country</label>
                                <select id="editCountrySelect" class="form-select form-select-lg">
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger" id="editCountryError"></div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group w-100">
                                <label class="form-label">For</label>
                                <select id="editForSelect" class="form-select form-select-lg"
                                    aria-label="Large select example">
                                    <option value="">Select Type</option>
                                    <option value="1">Mobile</option>
                                    <option value="2">Web</option>
                                </select>
                                <div class="text-danger" id="editForError"></div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="d-flex gap-2">
                                <div class="col-lg-6">
                                    <div class="form-group  w-100">

                                        <label class="form-label">From</label>
                                        <input type="date" id="editStartDate" class="form-control">
                                        <div class="text-danger" id="editStartDateError"></div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group  w-100">

                                        <label class="form-label">To</label>
                                        <input type="date" id="editEndDate" class="form-control">
                                        <div class="text-danger" id="editEndDateError"></div>
                                    </div>
                                </div>

                                <input type="hidden" id="editBannerId">
                            </div>

                        </div>
                        <div class="col-lg-12 d-flex justify-content-center">
                            <a id="updateBannerBtn" class="btn btn-dark customBtn mt-3">
                                Update
                            </a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.deleteBanner').forEach(button => {
        button.addEventListener('click', function() {
            let bannerId = this.getAttribute('data-id');

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
                    fetch(`/admin/deleteFullScreenBanner/${bannerId}`, {
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


<script>
document.addEventListener('DOMContentLoaded', function() {

    const modal = document.getElementById('sentModal2');
    const fileInput = document.getElementById('fileUpload');
    const preview = document.getElementById('previewImage');
    const icon = document.getElementById('uploadIcon');
    const uploadText = document.querySelector('.upload-text');

    modal.addEventListener('shown.bs.modal', () => {
        preview.style.display = 'none';
        icon.style.display = 'block';
        uploadText.style.display = 'block';

        fileInput.value = '';
        title.value = '';
        countrySelect.value = '';
        start_date.value = '';
        end_date.value = '';
        forSelect.value = '';

        imageError.innerText = '';
        titleError.innerText = '';
        countryError.innerText = '';
        startDateError.innerText = '';
        endDateError.innerText = '';
        forError.innerText = '';
    });

    fileInput.addEventListener('change', function() {
        if (this.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.style.display = 'block';
                icon.style.display = 'none';
                uploadText.style.display = 'none';
                imageError.innerText = '';
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    title.addEventListener('input', () => titleError.innerText = '');
    countrySelect.addEventListener('change', () => countryError.innerText = '');
    forSelect.addEventListener('change', () => forError.innerText = '');
    start_date.addEventListener('change', () => startDateError.innerText = '');
    end_date.addEventListener('change', () => endDateError.innerText = '');

    submitBannerBtn.addEventListener('click', function() {

        imageError.innerText = '';
        titleError.innerText = '';
        countryError.innerText = '';
        startDateError.innerText = '';
        endDateError.innerText = '';
        forError.innerText = '';

        let hasError = false;
        const formData = new FormData();

        formData.append('image', fileInput.files[0] ?? '');
        formData.append('title', title.value.trim());
        formData.append('country_id', countrySelect.value);
        formData.append('start_date', start_date.value);
        formData.append('end_date', end_date.value);
        formData.append('type', forSelect.value);

        if (!fileInput.files.length) {
            imageError.innerText = 'Please upload image';
            hasError = true;
        }
        if (!title.value.trim()) {
            titleError.innerText = 'Please enter title';
            hasError = true;
        }
        if (!countrySelect.value) {
            countryError.innerText = 'Please select country';
            hasError = true;
        }
        if (!start_date.value) {
            startDateError.innerText = 'Please select start date';
            hasError = true;
        }
        if (!end_date.value) {
            endDateError.innerText = 'Please select end date';
            hasError = true;
        }
        if (!forSelect.value) {
            forError.innerText = 'Please select type';
            hasError = true;
        }

        if (hasError) return;

        fetch('{{ route("admin.addFullBanner") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    toastr.success(data.message);
                    setTimeout(() => {
                        $('#sentModal2').modal('hide');
                        location.reload();
                    }, 1500);
                } else {
                    toastr.error(data.message || 'Something went wrong');
                }
            })
            .catch(() => toastr.error('Server error'));
    });
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function() {

    const editModalEl = document.getElementById('editBannerModal');
    const editModal = new bootstrap.Modal(editModalEl);

    // Inputs
    const editBannerId = document.getElementById('editBannerId');
    const editTitle = document.getElementById('editTitle');
    const editCountrySelect = document.getElementById('editCountrySelect');
    const editForSelect = document.getElementById('editForSelect');
    const editStartDate = document.getElementById('editStartDate');
    const editEndDate = document.getElementById('editEndDate');

    const editFileUpload = document.getElementById('editFileUpload');
    const editPreviewImage = document.getElementById('editPreviewImage');
    const editUploadIcon = document.getElementById('editUploadIcon');

    // Buttons
    const updateBannerBtn = document.getElementById('updateBannerBtn');

    // Errors
    const editImageError = document.getElementById('editImageError');
    const editTitleError = document.getElementById('editTitleError');
    const editCountryError = document.getElementById('editCountryError');
    const editForError = document.getElementById('editForError');
    const editStartDateError = document.getElementById('editStartDateError');
    const editEndDateError = document.getElementById('editEndDateError');

    /* ---------------- IMAGE PREVIEW ---------------- */
    editFileUpload.addEventListener('change', function(e) {
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                editPreviewImage.src = event.target.result;
                editPreviewImage.style.display = 'block';
                editUploadIcon.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }

        editImageError.innerText = '';
    });

    /* ---------------- OPEN EDIT MODAL ---------------- */
    document.querySelectorAll('.edit-reason-btn').forEach(function(button) {

        button.addEventListener('click', function() {

            editBannerId.value = this.dataset.id;
            editTitle.value = this.dataset.title;
            editCountrySelect.value = this.dataset.countryId;
            editForSelect.value = this.dataset.type; // ✅ MOBILE / WEB
            editStartDate.value = this.dataset.startDate;
            editEndDate.value = this.dataset.endDate;

            const image = this.dataset.image;

            if (image) {
                editPreviewImage.src = image;
                editPreviewImage.style.display = 'block';
                editUploadIcon.style.display = 'none';
            } else {
                editPreviewImage.style.display = 'none';
                editUploadIcon.style.display = 'block';
            }

            // Clear errors
            editImageError.innerText = '';
            editTitleError.innerText = '';
            editCountryError.innerText = '';
            editForError.innerText = '';
            editStartDateError.innerText = '';
            editEndDateError.innerText = '';
        });
    });

    /* ---------------- CLEAR ERRORS ON CHANGE ---------------- */
    editTitle.addEventListener('input', () => editTitleError.innerText = '');
    editCountrySelect.addEventListener('change', () => editCountryError.innerText = '');
    editForSelect.addEventListener('change', () => editForError.innerText = '');
    editStartDate.addEventListener('change', () => editStartDateError.innerText = '');
    editEndDate.addEventListener('change', () => editEndDateError.innerText = '');

    /* ---------------- UPDATE SUBMIT ---------------- */
    updateBannerBtn.addEventListener('click', function(e) {

        e.preventDefault();

        // Clear errors
        editImageError.innerText = '';
        editTitleError.innerText = '';
        editCountryError.innerText = '';
        editForError.innerText = '';
        editStartDateError.innerText = '';
        editEndDateError.innerText = '';

        let hasError = false;

        const id = editBannerId.value;
        const formData = new FormData();

        formData.append('title', editTitle.value.trim());
        formData.append('country_id', editCountrySelect.value);
        formData.append('type', editForSelect.value);
        formData.append('start_date', editStartDate.value);
        formData.append('end_date', editEndDate.value);

        if (editFileUpload.files.length > 0) {
            formData.append('image', editFileUpload.files[0]);
        }

        // Validation
        if (!editTitle.value.trim()) {
            editTitleError.innerText = 'Please enter title';
            hasError = true;
        }

        if (!editCountrySelect.value) {
            editCountryError.innerText = 'Please select country';
            hasError = true;
        }

        if (!editForSelect.value) {
            editForError.innerText = 'Please select type';
            hasError = true;
        }

        if (!editStartDate.value) {
            editStartDateError.innerText = 'Please select start date';
            hasError = true;
        }

        if (!editEndDate.value) {
            editEndDateError.innerText = 'Please select end date';
            hasError = true;
        }

        if (hasError) return;

        fetch(`{{ url('/admin/updateFullBanner') }}/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    toastr.success(data.message);

                    setTimeout(() => {
                        editModal.hide();
                        location.reload();
                    }, 1500);
                } else {
                    toastr.error(data.message || 'Something went wrong.');
                }
            })
            .catch(() => toastr.error('Server error.'));
    });

});
</script>



<script>
function getTodayLocal() {
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    return `${yyyy}-${mm}-${dd}`;
}

function setTodayMinDate() {
    const fromInput = document.getElementById('start_date');
    fromInput.min = getTodayLocal();
}

function updateToDate() {
    const fromInput = document.getElementById('start_date');
    const toInput = document.getElementById('end_date');

    if (fromInput.value) {
        const minToDate = new Date(fromInput.value);
        minToDate.setDate(minToDate.getDate() + 1);

        const yyyy = minToDate.getFullYear();
        const mm = String(minToDate.getMonth() + 1).padStart(2, '0');
        const dd = String(minToDate.getDate()).padStart(2, '0');

        toInput.min = `${yyyy}-${mm}-${dd}`;
    } else {
        toInput.removeAttribute('min');
    }
}

function updateFromDate() {
    const fromInput = document.getElementById('start_date');
    const toInput = document.getElementById('end_date');

    if (toInput.value) {
        const maxFromDate = new Date(toInput.value);
        maxFromDate.setDate(maxFromDate.getDate() - 1);

        const yyyy = maxFromDate.getFullYear();
        const mm = String(maxFromDate.getMonth() + 1).padStart(2, '0');
        const dd = String(maxFromDate.getDate()).padStart(2, '0');

        fromInput.max = `${yyyy}-${mm}-${dd}`;
    } else {
        fromInput.removeAttribute('max');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    setTodayMinDate();
    updateToDate();
    updateFromDate();

    document.getElementById('start_date').addEventListener('change', updateToDate);
    document.getElementById('end_date').addEventListener('change', updateFromDate);
});
</script>

<script>
function formatDateLocal(date) {
    const yyyy = date.getFullYear();
    const mm = String(date.getMonth() + 1).padStart(2, '0');
    const dd = String(date.getDate()).padStart(2, '0');
    return `${yyyy}-${mm}-${dd}`;
}

function setEditStartMinToday() {
    const startInput = document.getElementById('editStartDate');
    const today = new Date();
    startInput.min = formatDateLocal(today);
}

function updateEditEndDate() {
    const fromInput = document.getElementById('editStartDate');
    const toInput = document.getElementById('editEndDate');

    if (fromInput.value) {
        const minToDate = new Date(fromInput.value);
        minToDate.setDate(minToDate.getDate() + 1);
        toInput.min = formatDateLocal(minToDate);
    } else {
        toInput.removeAttribute('min');
    }
}

function updateEditStartDate() {
    const fromInput = document.getElementById('editStartDate');
    const toInput = document.getElementById('editEndDate');

    if (toInput.value) {
        const maxFromDate = new Date(toInput.value);
        maxFromDate.setDate(maxFromDate.getDate() - 1);
        fromInput.max = formatDateLocal(maxFromDate);
    } else {
        fromInput.removeAttribute('max');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    setEditStartMinToday();
    updateEditEndDate();
    updateEditStartDate();

    document.getElementById('editStartDate')
        .addEventListener('change', updateEditEndDate);

    document.getElementById('editEndDate')
        .addEventListener('change', updateEditStartDate);
});
</script>







@endsection