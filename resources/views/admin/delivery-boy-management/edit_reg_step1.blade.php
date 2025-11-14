@extends('admin.layout.app')
@section('content')

<div class="inner-content management">
    <div class="d-flex flex-column align-items-start back-btn-box">

        <div class="d-flex align-items-center gap-3 mt-2">
            <div class="arrow">
                <a class="table-button " type="button">
                    <i class="fas fa-angle-left"></i>
                </a>
            </div>
            <h2 class="h2 text-start">Edit Delivery Boy</h2>

        </div>
        <div class="content">
            <div class="card p-3 mt-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="upload-title text-center">
                                Upload profile image
                            </div>

                            <label for="fileUpload" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" id="uploadIcon" />
                                <img id="previewImage" class="preview-image" />
                                <div class="upload-text">Upload profile image</div>
                                <input type="file" id="fileUpload" hidden accept="image/*" />
                            </label>
                        </div>
                        <!-- Left Column -->
                        <div class="col-lg-6">
                            <!-- First Name -->
                            <div class="mt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="mb-0">First Name</label>
                                    <span class="text-muted" style="font-size: 12px;">In English</span>
                                </div>

                                <input type="text" placeholder="Anwar" class="form-control mt-1" />
                            </div>

                            <!-- Email -->
                            <div class="mt-3">
                                <label>Email-id</label>
                                <input type="email" placeholder="xyz@gmail.com" class="form-control" />
                            </div>
                            <div class="mt-3">

                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="mb-0">Address line 01</label>

                                </div>

                                <div class="position-relative mt-1">
                                    <input type="text" class="form-control" />

                                    <i class="bi bi-crosshair"
                                        style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor:pointer;">
                                    </i>
                                </div>

                            </div>
                            <div class="mt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="mb-0">City</label>
                                </div>

                                <input type="text" placeholder="" class="form-control mt-1" />
                            </div>

                            <!-- Password -->
                            <div class="mt-3 position-relative">
                                <label>Password</label>
                                <input type="password" id="password" class="form-control"
                                    placeholder="Enter password" />
                                <i class="fas fa-eye toggle-password position-absolute" toggle="#password"
                                    style="right: 15px;  cursor: pointer;"></i>
                            </div>

                            <!-- Select Role -->
                            <div class="mt-3">
                                <label>Select ZOne</label>
                                <select class="form-select">
                                    <option>select</option>
                                    <option value="1">Zone 1</option>
                                    <option value="2">Zone 2</option>
                                </select>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-lg-6">
                            <!-- Last Name -->
                            <div class="mt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="mb-0">Last Name</label>
                                    <span class="text-muted" style="font-size: 12px;">In Arabic</span>
                                </div>

                                <input type="text" placeholder="Anwar" class="form-control mt-1" />
                            </div>

                            <!-- Mobile -->
                            <div class="mt-3">
                                <label>Phone Number</label>
                                <input type="text" placeholder="2345678" class="form-control" />
                            </div>

                            <div class="mt-3">

                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="mb-0">Address line 02</label>

                                </div>

                                <div class="position-relative mt-1">
                                    <input type="text" class="form-control" />

                                    <i class="bi bi-crosshair"
                                        style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor:pointer;">
                                    </i>
                                </div>

                            </div>
                            <div class="mt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="mb-0">State</label>
                                </div>

                                <input type="text" placeholder="" class="form-control mt-1" />
                            </div>
                            <!-- Confirm Password -->
                            <div class="mt-3 position-relative">
                                <label>Confirm Password</label>
                                <input type="password" id="confirmPassword" class="form-control"
                                    placeholder="Enter password" />
                                <i class="fas fa-eye toggle-password position-absolute" toggle="#confirmPassword"
                                    style="right: 15px;  cursor: pointer;"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Submit Button -->
            <div class="col-lg-6 d-flex justify-content-center m-auto mb-3 mt-4 ">
                <a href="{{route('admin.edit_deliveryboy_step2')}}" class="btn btn-dark customBtn">Next</a>

            </div>
        </div>
    </div>
</div>

<script>
    const fileInput = document.getElementById("fileUpload");
    const previewImage = document.getElementById("previewImage");
    const uploadIcon = document.getElementById("uploadIcon");

   fileInput.addEventListener("change", function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewImage.style.display = "block";
            uploadIcon.style.display = "none";
        };
        reader.readAsDataURL(file);
    }
    });
</script>
<script>
  function previewImg(event, previewId) {
    const preview = document.getElementById(previewId);

    preview.src = URL.createObjectURL(event.target.files[0]);
    preview.style.display = "block";

    // Hide placeholder icon
    preview.previousElementSibling.style.display = "none";
   }
</script>

@endsection