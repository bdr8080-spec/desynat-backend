@extends('admin.layout.app')
@section('content')
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
            <h2 class="h2 text-start">Vehicle Information</h2>

        </div>
        <div class="content">
            <div class="card p-3 mt-4">
                <div class="card-body">
                    <div class="row">

                        <!-- Left Column -->
                        <div class="col-lg-6">
                            <!-- First Name -->
                            <div class="mt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="mb-0">Vehicle Name</label>
                                </div>

                                <input type="text" placeholder="Enter Vehicle Name" class="form-control mt-1" />
                            </div>

                        </div>

                        <!-- Right Column -->
                        <div class="col-lg-6">
                            <!-- Last Name -->
                            <div class="mt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="mb-0">Vehicle Registration Number</label>
                                </div>

                                <input type="text" placeholder="Enter Vehicle Registration Number"
                                    class="form-control mt-1" />
                            </div>

                        </div>
                    </div>
                    <div class="row mt-4">
                        <h5>Upload vehicle Image</h5>

                        <!-- FRONT -->
                        <div class="col-lg-2 text-center">
                            <label for="vehicleFront" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" class="upload-icon" />
                                <img id="previewFront" class="preview-image" />
                                <input type="file" id="vehicleFront" hidden accept="image/*" />
                            </label>
                            <div class="upload-subtitle">Front</div>
                        </div>

                        <!-- BACK -->
                        <div class="col-lg-10 text-center">
                            <label for="vehicleBack" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" class="upload-icon" />
                                <img id="previewBack" class="preview-image" />
                                <input type="file" id="vehicleBack" hidden accept="image/*" />
                            </label>
                            <div class="upload-subtitle">Back</div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <h5>Upload vehicle Image</h5>

                        <!-- FRONT -->
                        <div class="col-lg-2 text-center">
                            <label for="vehicleFront" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" class="upload-icon" />
                                <img id="previewFront" class="preview-image" />
                                <input type="file" id="vehicleFront" hidden accept="image/*" />
                            </label>
                            <div class="upload-subtitle">Front</div>
                        </div>

                        <!-- BACK -->
                        <div class="col-lg-10 text-center">
                            <label for="vehicleBack" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" class="upload-icon" />
                                <img id="previewBack" class="preview-image" />
                                <input type="file" id="vehicleBack" hidden accept="image/*" />
                            </label>
                            <div class="upload-subtitle">Back</div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <h5>Upload Identity Proof</h5>

                        <!-- FRONT -->
                        <div class="col-lg-2 text-center">
                            <label for="vehicleFront" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" class="upload-icon" />
                                <img id="previewFront" class="preview-image" />
                                <input type="file" id="vehicleFront" hidden accept="image/*" />
                            </label>
                            <div class="upload-subtitle">Front</div>
                        </div>

                        <!-- BACK -->
                        <div class="col-lg-10 text-center">
                            <label for="vehicleBack" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" class="upload-icon" />
                                <img id="previewBack" class="preview-image" />
                                <input type="file" id="vehicleBack" hidden accept="image/*" />
                            </label>
                            <div class="upload-subtitle">Back</div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <h5>Upload driving license</h5>

                        <!-- FRONT -->
                        <div class="col-lg-2 text-center">
                            <label for="vehicleFront" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" class="upload-icon" />
                                <img id="previewFront" class="preview-image" />
                                <input type="file" id="vehicleFront" hidden accept="image/*" />
                            </label>
                            <div class="upload-subtitle">Front</div>
                        </div>

                        <!-- BACK -->
                        <div class="col-lg-10 text-center">
                            <label for="vehicleBack" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" class="upload-icon" />
                                <img id="previewBack" class="preview-image" />
                                <input type="file" id="vehicleBack" hidden accept="image/*" />
                            </label>
                            <div class="upload-subtitle">Back</div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <h5>Upload vehicle insurance</h5>

                        <!-- FRONT -->
                        <div class="col-lg-2 text-center">
                            <label for="vehicleFront" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" class="upload-icon" />
                                <img id="previewFront" class="preview-image" />
                                <input type="file" id="vehicleFront" hidden accept="image/*" />
                            </label>

                        </div>

                        <div class="row mt-4">
                            <h5>Upload pollution paper (optional)</h5>

                            <!-- FRONT -->
                            <div class="col-lg-2 text-center">
                                <label for="vehicleFront" class="upload-box">
                                    <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png"
                                        class="upload-icon" />
                                    <img id="previewFront" class="preview-image" />
                                    <input type="file" id="vehicleFront" hidden accept="image/*" />
                                </label>
                                <div class="upload-subtitle">Front</div>
                            </div>

                            <!-- BACK -->
                            <div class="col-lg-10 text-center">
                                <label for="vehicleBack" class="upload-box">
                                    <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png"
                                        class="upload-icon" />
                                    <img id="previewBack" class="preview-image" />
                                    <input type="file" id="vehicleBack" hidden accept="image/*" />
                                </label>
                                <div class="upload-subtitle">Back</div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <h5>Upload registration certificate (optional)</h5>

                            <!-- FRONT -->
                            <div class="col-lg-2 text-center">
                                <label for="vehicleFront" class="upload-box">
                                    <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png"
                                        class="upload-icon" />
                                    <img id="previewFront" class="preview-image" />
                                    <input type="file" id="vehicleFront" hidden accept="image/*" />
                                </label>
                                <div class="upload-subtitle">Front</div>
                            </div>

                            <!-- BACK -->
                            <div class="col-lg-10 text-center">
                                <label for="vehicleBack" class="upload-box">
                                    <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png"
                                        class="upload-icon" />
                                    <img id="previewBack" class="preview-image" />
                                    <input type="file" id="vehicleBack" hidden accept="image/*" />
                                </label>
                                <div class="upload-subtitle">Back</div>
                            </div>
                        </div>


                    </div>
                    <!-- Submit Button -->
                    <div class="col-lg-6 d-flex justify-content-center m-auto mb-3 gap-4 mt-4 ">
                        <a class="btn btn-dark customBtn">Cancel</a>
                        <a class="btn btn-dark customBtn">Add</a>


                    </div>
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

    @endsection

    @endsection