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
            <h2 class="h2">Story Management</h2>
        </div>


    </div>
    <div class="d-flex justify-content-center">
        <ul class="nav nav-pills mb-3 tabs-pnl custom" id="pills-tab" role="tablist">
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-order-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order"
                    aria-selected="true">
                    Seller Stories
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link active customBtn2 m-0" id="pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="true">
                    Admin Platform Stories
                </button>
            </li>

        </ul>
    </div>
    <div class="userManagecontent">
        <div class="tab-content" id="pills-tabContent">

            <!-- Exchange -->

            <div class="tab-pane fade" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab" tabindex="0">


                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
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

                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group mb-5 w-100">
                            <!-- <label for="from" class="form-label">Country Name</label> -->
                            <select class="form-select form-select-lg" aria-label="Large select example">
                                <option selected>Select Country</option>
                                <option value="1">country One</option>
                                <option value="2">country Two</option>
                                <option value="3">country Three</option>
                            </select>
                        </div>
                    </div>

                </div>



                <div class="table-responsive  w-100">
                    <table class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Seller Name</th>
                                <th scope="col">Country</th>
                                <th scope="col">Posted Image/Video</th>
                                <th scope="col">Posted On</th>


                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>lorem</td>
                                <td>UAE </td>
                                <td> <img src="image/profile.jpg" alt="" width="40px" height="40px" class="square"
                                        data-bs-toggle="modal" data-bs-target="#sentModalphoto" /> </td>
                                <td>2nd September 2025 | 11 AM</td>

                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>lorem</td>
                                <td>UAE </td>
                                <td> <img src="image/profile.jpg" alt="" width="40px" height="40px" class="square"
                                        data-bs-toggle="modal" data-bs-target="#sentModalphoto" /> </td>
                                <td>2nd September 2025 | 11 AM</td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Return -->
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                tabindex="0">

                <div class="row">
                    <div class="align-items-end d-flex">

                        <div class="col-lg-6 col-md-4 col-12">

                            <div class="search-box w-50" style="position: relative;">
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
                        <div class="col-lg-6 ">
                            <div class="d-flex  align-items-end justify-content-end">
                                <a class="btn btn-dark customBtn" data-bs-toggle="modal"
                                    data-bs-target="#sentModalphoto">
                                    <span>Add</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="table-responsive  w-100">
                    <table class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Posted Image/Video</th>
                                <th scope="col">Posted On Date & Time</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>


                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td> <img src="image/profile.jpg" alt="" width="40px" height="40px" class="square"
                                        data-bs-toggle="modal" data-bs-target="#sentModalphoto" /></td>

                                <td>2nd September 2025 | 11 AM</td>
                                <td>Active</td>
                                <td>

                                    <div class="d-flex  justify-content-center">


                                        <a class="table-button" type="button">
                                            <i class="bi bi-trash3-fill"></i>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td> <img src="image/profile.jpg" alt="" width="40px" height="40px" class="square"
                                        data-bs-toggle="modal" data-bs-target="#sentModalphoto" /></td>

                                <td>2nd September 2025 | 11 AM</td>
                                <td>Active</td>
                                <td>

                                    <div class="d-flex  justify-content-center">


                                        <a class="table-button" type="button">
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

    <!-- End of Content Wrapper -->
</div>

<div class="modal fade" id="sentModalphoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                  <div class="modal-header management border-0">
                      <h2 class="h2">Add New </h2>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <div class="modal-body">
                      <div class="appointment-container">
                          <form id="addBrandForm" enctype="multipart/form-data">
                              
                              <div class="row">

                                  <!-- Upload Image -->
                                  <div class="col-lg-12">
                                      <div class="upload-title text-center">Upload Image</div>

                                      <label for="fileUpload" class="upload-box" style="cursor:pointer;">
                                          <img src="/image/imge-upload.svg" id="uploadIcon" />
                                          <img id="previewImage" class="preview-image" style="display:none; max-width:216px; margin-top:-2px;" />
                                          <div class="upload-text">Upload Image</div>
                                          <input type="file" id="fileUpload" name="image" accept="image/*" hidden />
                                      </label>
                                  </div>
                             

                                  <!-- Submit Button -->
                                  <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                                      <a type="button" id="submitBrandBtn" class="btn btn-dark customBtn mt-3">Submit</a>
                                  </div>
                 

                              </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
        </div>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery.js"></script>
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