@extends('admin.layout.app')
@section('content')
<style>
.upload-box {
    width: 220px;
    height: 160px;
    border: 2px dotted #c8ad8d;
    border-radius: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden; /* IMPORTANT */
    position: relative;
}

.upload-icon {
    width: 60px;
    opacity: 0.4;
}

.preview-image {
    width: 100%;
    height: 100%;
    object-fit: cover;  /* FULL COVER */
    display: none; /* Hidden before upload */
    position: absolute;
    top: 0;
    left: 0;
}

    </style>

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

                                <input type="text" placeholder=" Enter Vehicle Name" class="form-control mt-1" />
                            </div>

                        </div>

                        <!-- Right Column -->
                        <div class="col-lg-6">
                            <!-- Last Name -->
                            <div class="mt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="mb-0">Vehicle Registration Number</label>
                                </div>

                                <input type="text" placeholder=" Enter Vehicle Registration Number"
                                    class="form-control mt-1" />
                            </div>

                        </div>
                    </div>
                    <!-- Upload Vehicle Image -->
                    <div class="row mt-4">
                        <h5>Upload Vehicle Image</h5>

                        <!-- FRONT -->
                        <div class="col-lg-2 text-center">
                            <label for="vehicleImgFront" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png"
                                    id="vehicleImgFrontIcon" class="upload-icon" />
                                <img id="vehicleImgFrontPreview" class="preview-image" />
                                <input type="file" id="vehicleImgFront" hidden accept="image/*" />
                            </label>
                            <div class="upload-subtitle">Front</div>
                        </div>

                        <!-- BACK -->
                        <div class="col-lg-10 text-center">
                            <label for="vehicleImgBack" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" id="vehicleImgBackIcon"
                                    class="upload-icon" />
                                <img id="vehicleImgBackPreview" class="preview-image" />
                                <input type="file" id="vehicleImgBack" hidden accept="image/*" />
                            </label>
                            <div class="upload-subtitle">Back</div>
                        </div>
                    </div>

                    <!-- Upload Vehicle Image 2 -->
                    <div class="row mt-4">
                        <h5>Upload Vehicle Image (Second)</h5>

                        <!-- FRONT -->
                        <div class="col-lg-2 text-center">
                            <label for="vehicleImg2Front" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png"
                                    id="vehicleImg2FrontIcon" class="upload-icon" />
                                <img id="vehicleImg2FrontPreview" class="preview-image" />
                                <input type="file" id="vehicleImg2Front" hidden accept="image/*" />
                            </label>
                            <div class="upload-subtitle">Front</div>
                        </div>

                        <!-- BACK -->
                        <div class="col-lg-10 text-center">
                            <label for="vehicleImg2Back" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png"
                                    id="vehicleImg2BackIcon" class="upload-icon" />
                                <img id="vehicleImg2BackPreview" class="preview-image" />
                                <input type="file" id="vehicleImg2Back" hidden accept="image/*" />
                            </label>
                            <div class="upload-subtitle">Back</div>
                        </div>
                    </div>

                    <!-- Upload Identity Proof -->
                    <div class="row mt-4">
                        <h5>Upload Identity Proof</h5>

                        <div class="col-lg-2 text-center">
                            <label for="idProofFront" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" id="idProofFrontIcon"
                                    class="upload-icon" />
                                <img id="idProofFrontPreview" class="preview-image" />
                                <input type="file" id="idProofFront" hidden accept="image/*" />
                            </label>
                            <div class="upload-subtitle">Front</div>
                        </div>

                        <div class="col-lg-10 text-center">
                            <label for="idProofBack" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" id="idProofBackIcon"
                                    class="upload-icon" />
                                <img id="idProofBackPreview" class="preview-image" />
                                <input type="file" id="idProofBack" hidden accept="image/*" />
                            </label>
                            <div class="upload-subtitle">Back</div>
                        </div>
                    </div>

                    <!-- Upload Driving License -->
                    <div class="row mt-4">
                        <h5>Upload Driving License</h5>

                        <div class="col-lg-2 text-center">
                            <label for="dlFront" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" id="dlFrontIcon"
                                    class="upload-icon" />
                                <img id="dlFrontPreview" class="preview-image" />
                                <input type="file" id="dlFront" hidden accept="image/*" />
                            </label>
                            <div class="upload-subtitle">Front</div>
                        </div>

                        <div class="col-lg-10 text-center">
                            <label for="dlBack" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" id="dlBackIcon"
                                    class="upload-icon" />
                                <img id="dlBackPreview" class="preview-image" />
                                <input type="file" id="dlBack" hidden accept="image/*" />
                            </label>
                            <div class="upload-subtitle">Back</div>
                        </div>
                    </div>

                    <!-- Upload Vehicle Insurance -->
                    <div class="row mt-4">
                        <h5>Upload Vehicle Insurance</h5>

                        <div class="col-lg-2 text-center">
                            <label for="insuranceFront" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" id="insuranceFrontIcon"
                                    class="upload-icon" />
                                <img id="insuranceFrontPreview" class="preview-image" />
                                <input type="file" id="insuranceFront" hidden accept="image/*" />
                            </label>
                            <div class="upload-subtitle">Front</div>
                        </div>

                        <div class="col-lg-10 text-center">
                            <label for="insuranceBack" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" id="insuranceBackIcon"
                                    class="upload-icon" />
                                <img id="insuranceBackPreview" class="preview-image" />
                                <input type="file" id="insuranceBack" hidden accept="image/*" />
                            </label>
                            <div class="upload-subtitle">Back</div>
                        </div>
                    </div>

                    <!-- Upload Pollution Certificate (Optional) -->
                    <div class="row mt-4">
                        <h5>Upload Pollution Paper (Optional)</h5>

                        <div class="col-lg-2 text-center">
                            <label for="pollutionFront" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" id="pollutionFrontIcon"
                                    class="upload-icon" />
                                <img id="pollutionFrontPreview" class="preview-image" />
                                <input type="file" id="pollutionFront" hidden accept="image/*" />
                            </label>
                            <div class="upload-subtitle">Front</div>
                        </div>

                        <div class="col-lg-10 text-center">
                            <label for="pollutionBack" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" id="pollutionBackIcon"
                                    class="upload-icon" />
                                <img id="pollutionBackPreview" class="preview-image" />
                                <input type="file" id="pollutionBack" hidden accept="image/*" />
                            </label>
                            <div class="upload-subtitle">Back</div>
                        </div>
                    </div>

                    <!-- Upload Registration Certificate (Optional) -->
                    <div class="row mt-4">
                        <h5>Upload Registration Certificate (Optional)</h5>

                        <div class="col-lg-2 text-center">
                            <label for="rcFront" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" id="rcFrontIcon"
                                    class="upload-icon" />
                                <img id="rcFrontPreview" class="preview-image" />
                                <input type="file" id="rcFront" hidden accept="image/*" />
                            </label>
                            <div class="upload-subtitle">Front</div>
                        </div>

                        <div class="col-lg-10 text-center">
                            <label for="rcBack" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" id="rcBackIcon"
                                    class="upload-icon" />
                                <img id="rcBackPreview" class="preview-image" />
                                <input type="file" id="rcBack" hidden accept="image/*" />
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

<script>
function preview(idInput, idPreview, idIcon) {
    document.getElementById(idInput).addEventListener("change", function() {
        const file = this.files[0];
        if (file) {
            document.getElementById(idIcon).style.display = "none";
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(idPreview).src = e.target.result;
                document.getElementById(idPreview).style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    });
}

// Call previews for all uploads
preview("vehicleImgFront", "vehicleImgFrontPreview", "vehicleImgFrontIcon");
preview("vehicleImgBack", "vehicleImgBackPreview", "vehicleImgBackIcon");

preview("vehicleImg2Front", "vehicleImg2FrontPreview", "vehicleImg2FrontIcon");
preview("vehicleImg2Back", "vehicleImg2BackPreview", "vehicleImg2BackIcon");

preview("idProofFront", "idProofFrontPreview", "idProofFrontIcon");
preview("idProofBack", "idProofBackPreview", "idProofBackIcon");

preview("dlFront", "dlFrontPreview", "dlFrontIcon");
preview("dlBack", "dlBackPreview", "dlBackIcon");

preview("insuranceFront", "insuranceFrontPreview", "insuranceFrontIcon");
preview("insuranceBack", "insuranceBackPreview", "insuranceBackIcon");

preview("pollutionFront", "pollutionFrontPreview", "pollutionFrontIcon");
preview("pollutionBack", "pollutionBackPreview", "pollutionBackIcon");

preview("rcFront", "rcFrontPreview", "rcFrontIcon");
preview("rcBack", "rcBackPreview", "rcBackIcon");
</script>

@endsection