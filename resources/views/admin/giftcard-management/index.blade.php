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
                    <h2 class="h2">Gift Card Category Management</h2>
                </div>

                <div class="col-lg-3 col-md-4 col-12">
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-dark customBtn" data-bs-toggle="modal" data-bs-target="#sentModal2">
                            <span>Add Gift Card Category</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="userManagecontent">
                <div class="mt-4">
                    <div class="align-items-end d-flex">
                        <div class="search-box" style="position: relative;">
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
                    </div>

                    <div class="table-responsive w-100">
                        <table class="table w-100">
                            <thead>
                                <tr>
                                    <th scope="col">SR No.</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Gift Card Category Name</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>
                                        <img src="image/profile.jpg" alt="" width="40px" height="40px" class="square" />
                                    </td>
                                    <td>Zenith</td>
                                    <td>
                                        <div class="d-flex gap-3 justify-content-center">
                                            <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal3"><i class="bi bi-pencil-square"></i></a>

                                            <a class="table-button" type="button">
                                                <i class="bi bi-trash3-fill"></i>
                                            </a>

                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="flexSwitchCheckChecked" />
                                                <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>
                                        <img src="image/profile.jpg" alt="" width="40px" height="40px" class="square" />
                                    </td>
                                    <td>Rolex</td>
                                    <td>
                                        <div class="d-flex gap-3 justify-content-center">
                                            <a class="table-button" type="button" data-bs-toggle="modal"
                                                data-bs-target="#sentModal3"><i class="bi bi-pencil-square"></i></a>

                                            <a class="table-button" type="button" id="delete_category">
                                                <i class="bi bi-trash3-fill"></i>
                                            </a>

                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="flexSwitchCheckChecked" />
                                                <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                            </div>
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
</div>


<div class="modal fade" id="sentModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Add Category</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                        <div class="row">
                            <!-- Upload Image -->
                            <div class="col-lg-12">
                                <div class="upload-title text-center">Upload Image</div>

                                <label for="fileUpload" class="upload-box" style="cursor: pointer">
                                    <img src="/admin/image/imge-upload.svg" id="uploadIcon" />
                                    <img id="previewImage" class="preview-image" style="
                                            display: none;
                                            max-width: 216px;
                                            margin-top: -2px;
                                            " />
                                    <div class="upload-text">Upload Image</div>
                                    <input type="file" id="fileUpload" name="image" accept="image/*" hidden />
                                </label>
                                <div class="text-danger text-center" id="imageError"></div>
                            </div>

                            <!-- Brand Name English -->
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <label class="form-label">
                                        Add Category Name (English)</label>
                                    <input type="text" name="name_english" class="form-control"
                                        placeholder="Enter Category Name in English"
                                        oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')" />
                                    <div class="text-danger" id="nameEnError"></div>
                                </div>
                            </div>

                            <!-- Brand Name Arabic -->
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <label class="form-label">Add Category Name (Arabic)</label>
                                    <input type="text" name="name_arabic" class="form-control"
                                        placeholder="Enter Category Name in Arabic"
                                        oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')" />
                                    <div class="text-danger" id="nameArError"></div>
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



<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery.js"></script>
<script>
$(document).ready(function() {
    $(".inner-content").removeClass("innerToggle");
    $(".menu").click(function() {
        $(".customSidebar").toggleClass("toggle");
        $(".inner-content").toggleClass("toggle");
    });
});
</script>
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

@endsection