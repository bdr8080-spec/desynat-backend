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
@php
    $admin = auth('admin')->user();

    $permissions = \App\Models\AdminPermission::where('admin_id', $admin->id)
        ->where('can_action', 1)
        ->pluck('module_id')
        ->toArray();
@endphp
      <div id="content-wrapper" class="d-flex flex-column position-relative">
        <div id="content" class="">
        

          <div class="inner-content management">
            <div class="row align-items-center justify-content-between">
              <div class="col-lg-6 col-md-6 col-12">
                <h2 class="h2">{{ __('admin_messages.category_sub_category_management') }}</h2> 
              </div>
            </div>

            <div class="userManagecontent mt-5 ">
              <div class="">
                <!-- <div class="align-items-end d-flex">
                  <div class="search-box" style="position: relative">
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
                        <th scope="col">{{ __('admin_messages.category_name') }}</th>
                        @if(in_array(3, $permissions) || $admin->type == 1)
                        <th scope="col">{{ __('admin_messages.manage_sub_category') }}</th>
                        @endif
                        <th scope="col">{{ __('admin_messages.status') }}</th>
                        @if(in_array(3, $permissions) || $admin->type == 1)
                        <th scope="col">{{ __('admin_messages.action') }}</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($Categories as $key => $category)
                      <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>
                            <img
                                src="{{ $category->image }}"
                                width="40px"
                                height="40px"
                                class="square"
                            />
                        </td>
                         @if(app()->getLocale() == 'en')
                        <td>{{$category->name}}</td>
                        @endif
                         @if(app()->getLocale() == 'ar')
                        <td>{{$category->name_ar}}</td>
                        @endif
                        @if(in_array(3, $permissions) || $admin->type == 1)
                        <td>
                          <a
                            class="btn btn-dark customBtn"
                             href="{{ route('manageSubCategory', ['id' => $category->id]) }}"
                          >
                            <span>{{ __('admin_messages.manage') }}</span>
                          </a>
                        </td>
                        @endif
                        <td>
                            {{ $category->status == 1
                                ? __('admin_messages.active')
                                : __('admin_messages.inactive')
                            }}
                        </td>
                        @if(in_array(3, $permissions) || $admin->type == 1)
                        <td>
                          <div class="d-flex align-items-center justify-content-center gap-2">

                              <a class="table-button editBrandBtn"
                                href="javascript:void(0);"
                                data-bs-toggle="modal"
                                data-bs-target="#editCatModal"
                                data-id="{{ $category->id }}"
                                data-image="{{ $category->image }}">
                                  <i class="bi bi-pencil-square"></i>
                              </a>

                              <div class="form-check form-switch m-0">
                                  <input
                                      class="form-check-input toggleStatus"
                                      type="checkbox"
                                      role="switch"
                                      id="switch{{ $category->id }}"
                                      data-id="{{ $category->id }}"
                                      {{ $category->status == 1 ? 'checked' : '' }}
                                  />
                              </div>

                          </div>
                      </td>
                        @endif
                      </tr>
                      @empty
                          <tr>
                              <td colspan="4" class="text-center text-muted">No Category found</td>
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
    <!-- Edit  Modal -->
<div class="modal fade" id="editCatModal" tabindex="-1" aria-labelledby="editBrandLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">{{ __('admin_messages.edit_category') }}</h2>
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
                            <input type="hidden" name="category_id" id="editCategoryId" class="form-control" value="" />

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
    @endsection

  <!-- Update Category Status -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggleStatus').forEach(toggle => {
        toggle.addEventListener('change', function () {
            let categoryId = this.getAttribute('data-id');

            fetch(`/admin/updateCategoryStatus/${categoryId}`, {
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

<!-- Edit  -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const editModal = new bootstrap.Modal(document.getElementById('editCatModal'));
    const editForm = document.getElementById('editBrandForm');
    const editBrandId = document.getElementById('editBrandId');
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

    // document.querySelectorAll('.editBrandBtn').forEach(button => {
    //     button.addEventListener('click', function() {
    //         const tr = this.closest('tr');
    //         editBrandId.value = this.getAttribute('data-id');
    //         editPreviewImage.src = this.getAttribute('data-image');
    //     });
    // });

    document.querySelectorAll('.editBrandBtn').forEach(button => {
      button.addEventListener('click', function() {

        // console.log(this.dataset.image);
        // console.log(document.getElementById('editPreviewImage'));

          const id = this.dataset.id;
          const tr = this.closest('tr');

          document.getElementById('editBrandId').value = id;
          document.getElementById('editCategoryId').value = id;
          editPreviewImage.src = this.getAttribute('data-image');
      });
  });


    // Submit form
    document.getElementById('editBrandSubmit').addEventListener('click', function() {
        const formData = new FormData(editForm);
        const id = editBrandId.value;


        fetch(`/admin/updateCategory/${id}`, {
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


