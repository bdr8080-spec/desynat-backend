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
            <h2 class="h2">Full Screen Banner Management</h2>
        </div>

        <div class="col-lg-3 col-md-4 col-12">
            <div class="d-flex justify-content-end">
                <a class="btn btn-dark customBtn" data-bs-toggle="modal" data-bs-target="#sentModal2">
                    <span>Add Advertisement</span>
                </a>
            </div>
        </div>
    </div>


    <div class="userManagecontent">
        <div class="">
            <form method="GET" action="{{ route('admin.fullScreenBannerManagement') }}" id="filterForm">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-12">
                    <!-- <div class="search-box" style="position: relative;">
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
                    </div> -->
                </div>

                <div class="col-lg-3 col-md-4 col-12">
                    <div class="form-group mb-5 w-100">
                        <!-- <label for="from" class="form-label">Country Name</label> -->
                        <select name="country"
                            class="form-select form-select-lg "
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
                </div>

            </div>
           </form>

            <div class="table-responsive w-100">
                <table id="myTable" class="table w-100">
                    <thead>
                        <tr>
                            <th scope="col">SR No.</th>
                            <th scope="col">Banner</th>
                            <th scope="col">Title</th>
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
                            <td> <img src="{{ $banner['image'] }}" alt="" width="40px" height="40px" class="square" /> </td>
                            <td>{{ $banner['title'] }}</td>
                            <td>{{ $banner['country_info']['name'] }}</td>
                            <td>{{ $banner['start_date'] }}</td>
                            <td>{{ $banner['end_date'] }}</td>
                            <td>
                                <div class="d-flex gap-3 justify-content-center">
                                    <a href="javascript:void(0);"
                                        class="table-button edit-reason-btn"
                                        data-id="{{ $banner['id'] }}"
                                        data-title="{{ $banner['title'] }}"
                                        data-country-id="{{ $banner['country_id'] }}"
                                        data-start-date="{{ $banner['start_date'] }}"
                                        data-end-date="{{ $banner['end_date'] }}"
                                        data-image="{{ $banner['image'] }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editBannerModal">
                                            <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <a href="javascript:void(0);" class="table-button text-danger deleteBanner mb-1 mt-1"
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
                                       placeholder="Enter Title" oninput="this.value=this.value.replace(/[^A-Za-z0-9 ]/g,'').replace(/^\s+/,'')"/>
                                <div class="text-danger" id="titleError"></div>
                            </div>
                        </div>

                        <!-- Country -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group w-100">
                                <label class="form-label">Select Country</label>
                                <select id="countrySelect" name="country_id"
                                        class="form-select form-select-lg"
                                        aria-label="Large select example">
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger" id="countryError"></div>
                            </div>
                        </div>

                        <!-- Dates -->
                        <div class="col-lg-12">
                            <div class="d-flex gap-2">

                                <div class="col-lg-6">
                                    <div class="form-group mt-4 w-100">
                                        <label class="form-label">From:</label>
                                        <input type="date" id="start_date" name="start_date"
                                               class="form-control" />
                                        <div class="text-danger" id="startDateError"></div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mt-4 w-100">
                                        <label class="form-label">To:</label>
                                        <input type="date" id="end_date" name="end_date"
                                               class="form-control" />
                                        <div class="text-danger" id="endDateError"></div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                            <a type="button" id="submitBannerBtn"
                               class="btn btn-dark customBtn mt-3">
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

                        <div class="col-lg-12">
                            <label class="form-label">Title</label>
                            <input type="text" id="editTitle" class="form-control" oninput="this.value=this.value.replace(/[^A-Za-z0-9 ]/g,'').replace(/^\s+/,'')">
                            <div class="text-danger" id="editTitleError"></div>
                        </div>

                        <div class="col-lg-12">
                            <label class="form-label">Select Country</label>
                            <select id="editCountrySelect" class="form-select form-select-lg">
                                <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                            <div class="text-danger" id="editCountryError"></div>
                        </div>

                        <div class="col-lg-6">
                            <label class="form-label">From</label>
                            <input type="date" id="editStartDate" class="form-control">
                            <div class="text-danger" id="editStartDateError"></div>
                        </div>

                        <div class="col-lg-6">
                            <label class="form-label">To</label>
                            <input type="date" id="editEndDate" class="form-control">
                            <div class="text-danger" id="editEndDateError"></div>
                        </div>

                        <input type="hidden" id="editBannerId">

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
document.addEventListener('DOMContentLoaded', function () {

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

        imageError.innerText = '';
        titleError.innerText = '';
        countryError.innerText = '';
        startDateError.innerText = '';
        endDateError.innerText = '';
    });

    fileInput.addEventListener('change', function () {
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
    start_date.addEventListener('change', () => startDateError.innerText = '');
    end_date.addEventListener('change', () => endDateError.innerText = '');

    submitBannerBtn.addEventListener('click', function () {

        imageError.innerText = '';
        titleError.innerText = '';
        countryError.innerText = '';
        startDateError.innerText = '';
        endDateError.innerText = '';

        let hasError = false;
        const formData = new FormData();

        formData.append('image', fileInput.files[0] ?? '');
        formData.append('title', title.value.trim());
        formData.append('country_id', countrySelect.value);
        formData.append('start_date', start_date.value);
        formData.append('end_date', end_date.value);

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
document.addEventListener('DOMContentLoaded', function () {

    const editModalElement = document.getElementById('editBannerModal');
    const editModal = new bootstrap.Modal(editModalElement);

    const editBannerId = document.getElementById('editBannerId');
    const editTitle = document.getElementById('editTitle');
    const editCountrySelect = document.getElementById('editCountrySelect');
    const editStartDate = document.getElementById('editStartDate');
    const editEndDate = document.getElementById('editEndDate');

    const editFileUpload = document.getElementById('editFileUpload');
    const editPreviewImage = document.getElementById('editPreviewImage');
    const editUploadIcon = document.getElementById('editUploadIcon');

    const updateBannerBtn = document.getElementById('updateBannerBtn');

    const editImageError = document.getElementById('editImageError');
    const editTitleError = document.getElementById('editTitleError');
    const editCountryError = document.getElementById('editCountryError');
    const editStartDateError = document.getElementById('editStartDateError');
    const editEndDateError = document.getElementById('editEndDateError');

    editFileUpload.addEventListener('change', function (e) {
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function (event) {
                editPreviewImage.src = event.target.result;
                editPreviewImage.style.display = 'block';
                editUploadIcon.style.display = 'none';
            };

            reader.readAsDataURL(file);
        }

        editImageError.innerText = '';
    });

    document.querySelectorAll('.edit-reason-btn').forEach(function (button) {

        button.addEventListener('click', function () {

            editBannerId.value = this.getAttribute('data-id');
            editTitle.value = this.getAttribute('data-title');
            editCountrySelect.value = this.getAttribute('data-country-id');
            editStartDate.value = this.getAttribute('data-start-date');
            editEndDate.value = this.getAttribute('data-end-date');

            const image = this.getAttribute('data-image');

            if (image) {
                editPreviewImage.src = image;
                editPreviewImage.style.display = 'block';
                editUploadIcon.style.display = 'none';
            } else {
                editPreviewImage.style.display = 'none';
                editUploadIcon.style.display = 'block';
            }

            editImageError.innerText = '';
            editTitleError.innerText = '';
            editCountryError.innerText = '';
            editStartDateError.innerText = '';
            editEndDateError.innerText = '';
        });
    });

    editTitle.addEventListener('input', function () {
        editTitleError.innerText = '';
    });

    editCountrySelect.addEventListener('change', function () {
        editCountryError.innerText = '';
    });

    editStartDate.addEventListener('change', function () {
        editStartDateError.innerText = '';
    });

    editEndDate.addEventListener('change', function () {
        editEndDateError.innerText = '';
    });

    updateBannerBtn.addEventListener('click', function (e) {

        e.preventDefault(); 

        editImageError.innerText = '';
        editTitleError.innerText = '';
        editCountryError.innerText = '';
        editStartDateError.innerText = '';
        editEndDateError.innerText = '';

        let hasError = false;

        const id = editBannerId.value;
        const formData = new FormData();

        formData.append('title', editTitle.value.trim());
        formData.append('country_id', editCountrySelect.value);
        formData.append('start_date', editStartDate.value);
        formData.append('end_date', editEndDate.value);

        if (editFileUpload.files.length > 0) {
            formData.append('image', editFileUpload.files[0]);
        }

        if (!editTitle.value.trim()) {
            editTitleError.innerText = 'Please enter title';
            hasError = true;
        }

        if (!editCountrySelect.value) {
            editCountryError.innerText = 'Please select country';
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

        if (hasError) {
            return;
        }

        fetch(`{{ url('/admin/updateFullBanner') }}/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {

            if (data.success) {
                toastr.success(data.message);

                setTimeout(function () {
                    editModal.hide();
                    location.reload();
                }, 1500);

            } else {
                toastr.error(data.message || 'Something went wrong.');
            }
        })
        .catch(function (error) {
            toastr.error('Server error.');
            console.error(error);
        });
    });

});
</script>

<script>
    function updateToDate() {
        const fromDate = document.getElementById('start_date').value;
        const toDateInput = document.getElementById('end_date');
        
        if (fromDate) {
            const minDate = new Date(fromDate);
            minDate.setDate(minDate.getDate() + 1); 
            toDateInput.setAttribute('min', minDate.toISOString().split('T')[0]);
        } else {
            toDateInput.removeAttribute('min');
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        updateToDate(); 
        document.getElementById('start_date').addEventListener('input', updateToDate);
    });
</script>

<script>
    function updateToDate1() {
        const fromDate = document.getElementById('editStartDate').value;
        const toDateInput = document.getElementById('editendDate');
        
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
        document.getElementById('editStartDate').addEventListener('input', updateToDate1);
    });
</script>




@endsection