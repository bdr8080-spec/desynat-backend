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
<div id="content-wrapper" class="d-flex flex-column position-relative">
    <div id="content" class="">


        <div class="inner-content management">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="d-flex align-items-center gap-3 mt-2">
                        <div class="arrow">
                            <a class="table-button" type="button" href="{{route('categoryManagement')}}">
                                <i class="fas fa-angle-left"></i>
                            </a>
                        </div>
                        <h6 class="m-0">{{ __('admin_messages.manage_sub_category') }}</h6>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-12">
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-dark customBtn" data-bs-toggle="modal" data-bs-target="#sentModal2">
                            <span>{{ __('admin_messages.add_sub_category') }}</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="userManagecontent">
                <div class="mt-4">
                    <!-- <div class="align-items-end d-flex">
                  <div
                    class="search-box"
                    style="position: relative; "
                  >
                    <i
                      class="bi bi-search"
                      style="
                        position: absolute;
                        left: 10px;
                        top: 50%;
                        transform: translateY(-50%);
                        font-size: 16px;
                        color: #888;
                      "
                    >
                    </i>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Search for..."
                      style="padding-left: 35px"
                    />
                  </div>
                </div> -->

                    <div class="table-responsive w-100">
                        <table id="myTable" class="table w-100">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('admin_messages.s_no') }}</th>
                                    <th scope="col">{{ __('admin_messages.image') }}</th>

                                    @if(app()->getLocale() == 'en')
                                        <th scope="col">{{ __('admin_messages.sub_category_name_english') }}</th>
                                    @else
                                        <th scope="col">{{ __('admin_messages.sub_category_name_arabic') }}</th>
                                    @endif

                                    <th scope="col">{{ __('admin_messages.status') }}</th>
                                    <th scope="col">{{ __('admin_messages.action') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($subcategories as $key => $scat)
                                    <tr>
                                        <th scope="row">{{ $key + 1 }}</th>

                                        <td>
                                            <img src="{{ $scat->image }}" width="40" height="40" class="square" />
                                        </td>

                                        @if(app()->getLocale() == 'en')
                                            <td>{{ $scat->name_english }}</td>
                                        @else
                                            <td>{{ $scat->name_arabic }}</td>
                                        @endif

                                        <td>
                                            {{ $scat->status == 1
                                                ? __('admin_messages.active')
                                                : __('admin_messages.inactive')
                                            }}
                                        </td>

                                        <td>
                                            <div class="d-flex gap-3 justify-content-center">

                                                <a class="table-button editBrandBtn" href="javascript:void(0);"
                                                    data-bs-toggle="modal" data-bs-target="#editBrandModal"
                                                    data-id="{{ $scat->id }}"
                                                    data-name-english="{{ $scat->name_english }}"
                                                    data-name-arabic="{{ $scat->name_arabic }}"
                                                    data-image="{{ $scat->image }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                <a href="javascript:void(0);" class="table-button deleteBrand"
                                                    data-id="{{ $scat->id }}">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </a>

                                                <div class="form-check form-switch">
                                                    <input class="form-check-input toggleStatus" type="checkbox"
                                                        role="switch"
                                                        id="switch{{ $scat->id }}"
                                                        data-id="{{ $scat->id }}"
                                                        {{ $scat->status == 1 ? 'checked' : '' }} />
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            {{ __('admin_messages.no_data_found') }}
                                        </td>
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

<!-- Add Modal -->
<div class="modal fade" id="sentModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">{{ __('admin_messages.add_sub_category') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <form id="addBrandForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <!-- Upload Image -->
                            <div class="col-lg-12">
                                <div class="upload-title text-center">{{ __('admin_messages.upload_image') }}</div>

                                <!-- <div class="upload-new text-center"> -->
                                    <label for="fileUpload" class="upload-box" style="cursor:pointer;">
                                        <img src="/admin/image/imge-upload.svg"
                                            id="uploadIcon"  class="upload-icon" />
                                        <img id="previewImage" class="preview-image"
                                            style="display:none; max-width:216px; margin-top:-2px;" />
                                        <div class="upload-text">{{ __('admin_messages.upload_image') }}</div>
                                        <input type="file" id="fileUpload" name="image" accept="image/*" hidden />
                                    </label>
                                    <div class="text-danger text-center" id="imageError"></div>
                                <!-- </div> -->
                            </div>
                            <input type="hidden" name="category_id" class="form-control" value="{{ $id }}" />
                            <!-- Brand Name English -->
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('admin_messages.sub_category_name_english') }}</label>
                                    <input type="text" name="name_english" class="form-control"
                                        placeholder="{{ __('admin_messages.please_enter_sub_category_name_in_english') }}"
                                        oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')" />
                                    <div class="text-danger" id="nameEnError"></div>
                                </div>
                            </div>

                            <!-- Brand Name Arabic -->
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('admin_messages.sub_category_name_arabic') }}</label>
                                    <input type="text" name="name_arabic" class="form-control"
                                        placeholder="{{ __('admin_messages.please_enter_sub_category_name_in_arabic') }}"
                                        oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')" />
                                    <div class="text-danger" id="nameArError"></div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                                <a type="button" id="submitBrandBtn" class="btn btn-dark customBtn mt-3">{{ __('admin_messages.submit') }}</a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit  Modal -->
<div class="modal fade" id="editBrandModal" tabindex="-1" aria-labelledby="editBrandLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">{{ __('admin_messages.edit_sub_category') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="appointment-container">
                    <form id="editBrandForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="brand_id" id="editBrandId" value="" />

                        <div class="row">
                            <!-- Upload Image -->
                            <div class="col-lg-12">
                                <div class="upload-title text-center">{{ __('admin_messages.upload_image') }}</div>
                                <label for="editFileUpload" class="upload-box" style="cursor:pointer;">
                                    <img src="/admin/image/imge-upload.svg"
                                        id="editPreviewImage" class="preview-image"
                                        style="max-width:216px; margin-top:-2px;" />
                                    <div class="upload-text">{{ __('admin_messages.upload_image') }}</div>
                                    <input type="file" id="editFileUpload" name="image" accept="image/*" hidden />
                                </label>
                                <div class="text-danger" id="editImageError"></div>
                            </div>
                            <input type="hidden" name="category_id" class="form-control" value="{{ $id }}" />
                            <!-- Brand Name English -->
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('admin_messages.sub_category_name_english') }}</label>
                                    <input type="text" name="name_english" class="form-control" id="editNameEnglish"
                                        placeholder="{{ __('admin_messages.please_enter_sub_category_name_in_english') }}"
                                        oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')" />
                                    <div class="text-danger" id="editNameEnError"></div>
                                </div>
                            </div>

                            <!-- Brand Name Arabic -->
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('admin_messages.sub_category_name_arabic') }}</label>
                                    <input type="text" name="name_arabic" class="form-control" id="editNameArabic"
                                        placeholder="{{ __('admin_messages.please_enter_sub_category_name_in_arabic') }}"
                                        oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')" />
                                    <div class="text-danger" id="editNameArError"></div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center mt-3">
                                <a type="button" class="btn btn-dark customBtn" id="editBrandSubmit">{{ __('admin_messages.update') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


@endsection

<!-- Delete -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.deleteBrand').forEach(button => {
        button.addEventListener('click', function() {
            let scatId = this.getAttribute('data-id');

            Swal.fire({
                title: "{{ __('admin_messages.are_you_sure?') }}",
                text: "{{ __('admin_messages.you_wont_be_able_to_revert_this') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "{{ __('admin_messages.yes_delete_it') }}",
                cancelButtonText: "{{ __('admin_messages.cancel') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/deleteSubCategory/${scatId}`, {
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

<!-- Update  Status -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.toggleStatus').forEach(toggle => {
        toggle.addEventListener('change', function() {
            let scatId = this.getAttribute('data-id');

            fetch(`/admin/updateSubCategoryStatus/${scatId}`, {
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

<!-- Add  -->
<script>
document.addEventListener('DOMContentLoaded', function() {

    const fileInput = document.getElementById('fileUpload');
    const preview = document.getElementById('previewImage');
    const icon = document.getElementById('uploadIcon');
    const text = document.querySelector('.upload-box .upload-text');

    // Show preview when selecting image
    fileInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                icon.style.display = 'none'; // Hide default icon
                text.style.display = 'none'; // Hide upload text
                document.getElementById('imageError').innerText = '';
            }
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
            icon.style.display = 'block';
            text.style.display = 'block';
        }
    });


    // Clear validation when typing in inputs
    const nameEnInput = document.querySelector('input[name="name_english"]');
    const nameArInput = document.querySelector('input[name="name_arabic"]');

    nameEnInput.addEventListener('input', function() {
        document.getElementById('nameEnError').innerText = '';
    });

    nameArInput.addEventListener('input', function() {
        document.getElementById('nameArError').innerText = '';
    });

    const submitBtn = document.getElementById('submitBrandBtn');
    submitBtn.addEventListener('click', function(e) {
        e.preventDefault();

        document.getElementById('nameEnError').innerText = '';
        document.getElementById('nameArError').innerText = '';
        document.getElementById('imageError').innerText = '';

        const form = document.getElementById('addBrandForm');
        const formData = new FormData(form);

        let hasError = false;
        if (!formData.get('image').name) {
            document.getElementById('imageError').innerText = "{{ __('admin_messages.please_upload_image') }}";
            hasError = true;
        }
        if (!formData.get('name_english').trim()) {
            document.getElementById('nameEnError').innerText = "{{ __('admin_messages.please_enter_sub_category_name_in_english') }}";
            hasError = true;
        }
        if (!formData.get('name_arabic').trim()) {
            document.getElementById('nameArError').innerText = "{{ __('admin_messages.please_enter_sub_category_name_in_arabic') }}";
            hasError = true;
        }
        if (hasError) return;

        fetch('{{ route("addSubCategory") }}', {
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
                    }, 2000);
                } else {
                    toastr.error(data.message || 'Something went wrong.');
                }
            })
            .catch(err => {
                toastr.error('Server error.');
                console.log(err);
            });
    });

});
</script>

<!-- Edit  -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const editModal = new bootstrap.Modal(document.getElementById('editBrandModal'));
    const editForm = document.getElementById('editBrandForm');
    const editBrandId = document.getElementById('editBrandId');
    const editNameEnglish = document.getElementById('editNameEnglish');
    const editNameArabic = document.getElementById('editNameArabic');
    const editPreviewImage = document.getElementById('editPreviewImage');

    // Image preview when selecting a new file
    document.getElementById('editFileUpload').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                editPreviewImage.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
        document.getElementById('editImageError').innerText = '';
    });

    document.querySelectorAll('.editBrandBtn').forEach(button => {
        button.addEventListener('click', function() {
            const tr = this.closest('tr');
            editBrandId.value = this.getAttribute('data-id');
            editNameEnglish.value = this.getAttribute('data-name-english');
            editNameArabic.value = this.getAttribute('data-name-arabic');
            editPreviewImage.src = this.getAttribute('data-image');
        });
    });

    // Clear errors while typing
    editNameEnglish.addEventListener('input', () => document.getElementById('editNameEnError').innerText = '');
    editNameArabic.addEventListener('input', () => document.getElementById('editNameArError').innerText = '');

    // Submit form
    document.getElementById('editBrandSubmit').addEventListener('click', function() {
        const formData = new FormData(editForm);
        const id = editBrandId.value;

        // Clear errors
        document.getElementById('editNameEnError').innerText = '';
        document.getElementById('editNameArError').innerText = '';
        document.getElementById('editImageError').innerText = '';

        let hasError = false;
        if (!formData.get('name_english').trim()) {
            document.getElementById('editNameEnError').innerText =
                "{{ __('admin_messages.please_enter_sub_category_name_in_english') }}";
            hasError = true;
        }
        if (!formData.get('name_arabic').trim()) {
            document.getElementById('editNameArError').innerText =
            "{{ __('admin_messages.please_enter_sub_category_name_in_arabic') }}";
            hasError = true;
        }
        if (hasError) return;

        fetch(`/admin/updateSubCategory/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': editForm.querySelector('input[name="_token"]').value
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
                    }, 2000);
                } else {
                    toastr.error(data.message || 'Something went wrong.');
                }
            })
            .catch(err => {
                toastr.error('Server error.');
                //console.log(err);
            });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('sentModal2');
    modal.addEventListener('hidden.bs.modal', function() {
        location.reload();
    });
});
</script>