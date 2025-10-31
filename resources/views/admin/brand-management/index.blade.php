@extends('admin.layout.app')
@section('content')
<style>
  #editPreviewImage {
    display: block; 
}
</style>
      <div id="content-wrapper" class="d-flex flex-column position-relative">
        <div id="content" class="">
          <nav
            class="navbar navbar-expand navbar-light custom-topbar mb-0 static-top shadow"
          >
            <div class="left-section d-flex align-items-center">
              <img src="image/combine_logo.svg" class="header-logo" />
            </div>

            <div class="header-divider"></div>

            <div class="right-section">
              <button class="lang-btn">
                <i class="fas fa-globe"></i> EN
                <i class="fas fa-chevron-down"></i>
              </button>
            </div>
          </nav>

          <div class="inner-content management">
            <div class="row align-items-center justify-content-between">
              <div class="col-lg-6 col-md-6 col-12">
                <h2 class="h2">Brands Management</h2>
              </div>

              <div class="col-lg-3 col-md-4 col-12">
                <div class="d-flex justify-content-end">
                  <a
                    class="btn btn-dark customBtn"
                    data-bs-toggle="modal"
                    data-bs-target="#sentModal2"
                  >
                    <span>Add New Brands</span>
                  </a>
                </div>
              </div>
            </div>

            <div class="userManagecontent">
              <div class="mt-4">
                <!-- <div class="align-items-end d-flex">
                  <div
                    class="search-box"
                    style="position: relative;"
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
                        <th scope="col">SR No.</th>
                        <th scope="col">Image</th>
                        <th scope="col">Brand name(English)</th>
                        <th scope="col">Brand name(Arabic)</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($brands as $key => $brand)
                          <tr>
                              <th scope="row">{{ $key + 1 }}</th>
                              <td>
                                  <img
                                      src="{{ $brand->image }}"
                                      width="40px"
                                      height="40px"
                                      class="square"
                                  />
                              </td>
                              <td>{{ $brand->name_english }}</td>
                              <td>{{ $brand->name_arabic }}</td>
                              <td>{{ $brand->status == 1 ? 'Active' : 'Inactive' }}</td>
                              <td>
                                  <div class="d-flex gap-3 justify-content-center">
                                      <!-- Edit button -->
                                      <a 
                                          class="table-button editBrandBtn" 
                                          href="javascript:void(0);" 
                                          data-bs-toggle="modal" 
                                          data-bs-target="#editBrandModal" 
                                          data-id="{{ $brand->id }}"
                                          data-name-english="{{ $brand->name_english }}"
                                          data-name-arabic="{{ $brand->name_arabic }}"
                                          data-image="{{ $brand->image }}"
                                      >
                                          <i class="bi bi-pencil-square"></i>
                                      </a>

                                      <!-- Delete button  -->
                                     <a
                                          href="javascript:void(0);"
                                          class="table-button text-danger deleteBrand"
                                          data-id="{{ $brand->id }}"
                                      >
                                          <i class="bi bi-trash3-fill"></i>
                                      </a>

                                      <!-- Toggle switch -->
                                      <div class="form-check form-switch">
                                          <input
                                              class="form-check-input toggleStatus"
                                              type="checkbox"
                                              role="switch"
                                              id="switch{{ $brand->id }}"
                                              data-id="{{ $brand->id }}"
                                              {{ $brand->status == 1 ? 'checked' : '' }}
                                          />
                                      </div>
                                  </div>
                              </td>
                          </tr>
                      @empty
                          <tr>
                              <td colspan="4" class="text-center text-muted">No brands found</td>
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

      <!-- Add Brand Modal -->
        <div class="modal fade" id="sentModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                  <div class="modal-header management border-0">
                      <h2 class="h2">Add New Brands</h2>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <div class="modal-body">
                      <div class="appointment-container">
                          <form id="addBrandForm" enctype="multipart/form-data">
                              @csrf
                              <div class="row">

                                  <!-- Upload Image -->
                                  <div class="col-lg-12">
                                      <div class="upload-title text-center">Upload profile image</div>

                                      <label for="fileUpload" class="upload-box" style="cursor:pointer;">
                                          <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" id="uploadIcon" />
                                          <img id="previewImage" class="preview-image" style="display:none; max-width:100px; margin-top:10px;" />
                                          <div class="upload-text">Upload profile image</div>
                                          <input type="file" id="fileUpload" name="image" accept="image/*" hidden />
                                      </label>
                                      <div class="text-danger" id="imageError"></div>
                                  </div>
                                   
                                  <!-- Brand Name English -->
                                  <div class="col-lg-12 col-md-12 col-12">
                                      <div class="form-group">
                                          <label class="form-label">Brand Name (English)</label>
                                          <input type="text" name="name_english" class="form-control" placeholder="Brand Name" />
                                          <div class="text-danger" id="nameEnError"></div>
                                      </div>
                                  </div>

                                  <!-- Brand Name Arabic -->
                                  <div class="col-lg-12 col-md-12 col-12">
                                      <div class="form-group">
                                          <label class="form-label">Brand Name (Arabic)</label>
                                          <input type="text" name="name_arabic" class="form-control" placeholder="Brand Name" />
                                          <div class="text-danger" id="nameArError"></div>
                                      </div>
                                  </div>

                                  <!-- Submit Button -->
                                  <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                                      <button type="button" id="submitBrandBtn" class="btn btn-dark customBtn mt-3">Submit</button>
                                  </div>

                              </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
        </div>

        <!-- Edit Brand Modal -->
        <div class="modal fade" id="editBrandModal" tabindex="-1" aria-labelledby="editBrandLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header management border-0">
                        <h2 class="h2">Edit Brand</h2>
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
                                        <div class="upload-title text-center">Upload profile image</div>
                                        <label for="editFileUpload" class="upload-box" style="cursor:pointer;">
                                            <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" id="editPreviewImage" class="preview-image" style="max-width:100px; margin-top:10px;" />
                                            <div class="upload-text">Upload profile image</div>
                                            <input type="file" id="editFileUpload" name="image" accept="image/*" hidden />
                                        </label>
                                        <div class="text-danger" id="editImageError"></div>
                                    </div>

                                    <!-- Brand Name English -->
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Brand Name (English)</label>
                                            <input type="text" name="name_english" class="form-control" id="editNameEnglish" placeholder="Brand Name" />
                                            <div class="text-danger" id="editNameEnError"></div>
                                        </div>
                                    </div>

                                    <!-- Brand Name Arabic -->
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Brand Name (Arabic)</label>
                                            <input type="text" name="name_arabic" class="form-control" id="editNameArabic" placeholder="Brand Name" />
                                            <div class="text-danger" id="editNameArError"></div>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center mt-3">
                                        <button type="button" class="btn btn-dark customBtn" id="editBrandSubmit">Update</button>
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

<!-- Delete Brand -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.deleteBrand').forEach(button => {
        button.addEventListener('click', function () {
            let brandId = this.getAttribute('data-id');

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
                    fetch(`/admin/deleteBrand/${brandId}`, {
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

<!-- Update Brand Status -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggleStatus').forEach(toggle => {
        toggle.addEventListener('change', function () {
            let brandId = this.getAttribute('data-id');

            fetch(`/admin/updateBrandStatus/${brandId}`, {
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

<!-- Add Brand -->
<script>
document.addEventListener('DOMContentLoaded', function() {

    const fileInput = document.getElementById('fileUpload');
    const preview = document.getElementById('previewImage');

    // Show preview when selecting image
    fileInput.addEventListener('change', function(event){
        const file = event.target.files[0];
        if(file){
            const reader = new FileReader();
            reader.onload = function(e){
                preview.src = e.target.result;
                preview.style.display = 'block';
                document.getElementById('imageError').innerText = ''; 
            }
            reader.readAsDataURL(file);
        }
    });

    // Clear validation when typing in inputs
    const nameEnInput = document.querySelector('input[name="name_english"]');
    const nameArInput = document.querySelector('input[name="name_arabic"]');

    nameEnInput.addEventListener('input', function(){
        document.getElementById('nameEnError').innerText = '';
    });

    nameArInput.addEventListener('input', function(){
        document.getElementById('nameArError').innerText = '';
    });

    const submitBtn = document.getElementById('submitBrandBtn');
    submitBtn.addEventListener('click', function(e){
        e.preventDefault();

        document.getElementById('nameEnError').innerText = '';
        document.getElementById('nameArError').innerText = '';
        document.getElementById('imageError').innerText = '';

        const form = document.getElementById('addBrandForm');
        const formData = new FormData(form);

        let hasError = false;
        if(!formData.get('image').name){
            document.getElementById('imageError').innerText = 'Image is required';
            hasError = true;
        }
        if(!formData.get('name_english').trim()){
            document.getElementById('nameEnError').innerText = 'English name is required';
            hasError = true;
        }
        if(!formData.get('name_arabic').trim()){
            document.getElementById('nameArError').innerText = 'Arabic name is required';
            hasError = true;
        }
        if(hasError) return;

        fetch('{{ route("addBrand") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
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

<!-- Edit Brand -->
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
        if(file){
            const reader = new FileReader();
            reader.onload = function(e){
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
        if(!formData.get('name_english').trim()){
            document.getElementById('editNameEnError').innerText = 'English name is required';
            hasError = true;
        }
        if(!formData.get('name_arabic').trim()){
            document.getElementById('editNameArError').innerText = 'Arabic name is required';
            hasError = true;
        }
        if(hasError) return;

        fetch(`/admin/updateBrand/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': editForm.querySelector('input[name="_token"]').value
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
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


