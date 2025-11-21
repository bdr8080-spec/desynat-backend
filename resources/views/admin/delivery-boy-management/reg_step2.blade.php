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
                <a href="{{ route('admin.deliveryboy_reg_step1', ['type' => 'session']) }}" class="table-button " type="button">
                    <i class="fas fa-angle-left"></i>
                </a>
            </div>
            <h2 class="h2 text-start">Vehicle Information</h2>

        </div>
        <div class="content">
            <div class="card p-3 mt-4">
                <div class="card-body">
                    <div class="row">

                        <!-- VEHICLE NAME -->
                        <div class="col-lg-6">
                            <div class="mt-3">
                                <label class="mb-0">Vehicle Name</label>
                                <input type="text" placeholder="Enter Vehicle Name" oninput="this.value = this.value.replace(/[^A-Za-z0-9 ]/g,'').replace(/^\s+/,'')" class="form-control mt-1" id="vehicle_name">
                                <div id="vehicle_name_error" class="text-danger small"></div>
                            </div>
                        </div>

                        <!-- VEHICLE REGISTRATION -->
                        <div class="col-lg-6">
                            <div class="mt-3">
                                <label class="mb-0">Vehicle Registration Number</label>
                                <input type="text" placeholder="Enter Vehicle Registration Number" oninput="this.value = this.value.replace(/[^A-Za-z0-9 ]/g,'').replace(/^\s+/,'')" class="form-control mt-1" id="vehicle_reg">
                                <div id="vehicle_reg_error" class="text-danger small"></div>
                            </div>
                        </div>
                    </div>

                    <!-- VEHICLE IMAGE -->
                    <div class="row mt-4">
                        <h5>Upload Vehicle Image</h5>

                        <!-- FRONT -->
                        <div class="col-lg-2 text-center">
                            <label for="vehicleImgFront" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" id="vehicleImgFrontIcon" class="upload-icon">
                                <img id="vehicleImgFrontPreview" class="preview-image">
                                <input type="file" id="vehicleImgFront" hidden accept="image/*">
                            </label>
                            <div class="upload-subtitle">Front</div>
                            <div id="vehicleImgFront_error" class="text-danger small"></div>
                        </div>

                        <!-- BACK -->
                        <div class="col-lg-10 text-center">
                            <label for="vehicleImgBack" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" id="vehicleImgBackIcon" class="upload-icon">
                                <img id="vehicleImgBackPreview" class="preview-image">
                                <input type="file" id="vehicleImgBack" hidden accept="image/*">
                            </label>
                            <div class="upload-subtitle">Back</div>
                            <div id="vehicleImgBack_error" class="text-danger small"></div>
                        </div>
                    </div>

                    <!-- IDENTITY PROOF -->
                    <div class="row mt-4">
                        <h5>Upload Identity Proof</h5>

                        <!-- FRONT -->
                        <div class="col-lg-2 text-center">
                            <label for="idProofFront" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" id="idProofFrontIcon" class="upload-icon">
                                <img id="idProofFrontPreview" class="preview-image">
                                <input type="file" id="idProofFront" hidden accept="image/*">
                            </label>
                            <div class="upload-subtitle">Front</div>
                            <div id="idProofFront_error" class="text-danger small"></div>
                        </div>

                        <!-- BACK -->
                        <div class="col-lg-10 text-center">
                            <label for="idProofBack" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" id="idProofBackIcon" class="upload-icon">
                                <img id="idProofBackPreview" class="preview-image">
                                <input type="file" id="idProofBack" hidden accept="image/*">
                            </label>
                            <div class="upload-subtitle">Back</div>
                            <div id="idProofBack_error" class="text-danger small"></div>
                        </div>
                    </div>

                    <!-- DRIVING LICENSE -->
                    <div class="row mt-4">
                        <h5>Upload Driving License</h5>

                        <!-- FRONT -->
                        <div class="col-lg-2 text-center">
                            <label for="dlFront" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" id="dlFrontIcon" class="upload-icon">
                                <img id="dlFrontPreview" class="preview-image">
                                <input type="file" id="dlFront" hidden accept="image/*">
                            </label>
                            <div class="upload-subtitle">Front</div>
                            <div id="dlFront_error" class="text-danger small"></div>
                        </div>

                        <!-- BACK -->
                        <div class="col-lg-10 text-center">
                            <label for="dlBack" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" id="dlBackIcon" class="upload-icon">
                                <img id="dlBackPreview" class="preview-image">
                                <input type="file" id="dlBack" hidden accept="image/*">
                            </label>
                            <div class="upload-subtitle">Back</div>
                            <div id="dlBack_error" class="text-danger small"></div>
                        </div>
                    </div>

                    <!-- INSURANCE -->
                    <div class="row mt-4">
                        <h5>Upload Vehicle Insurance</h5>

                        <div class="col-lg-2 text-center">
                            <label for="insuranceFront" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" id="insuranceFrontIcon" class="upload-icon">
                                <img id="insuranceFrontPreview" class="preview-image">
                                <input type="file" id="insuranceFront" hidden accept="image/*">
                            </label>
                            <div id="insuranceFront_error" class="text-danger small"></div>
                        </div>
                    </div>

                    <!-- POLLUTION -->
                    <div class="row mt-4">
                        <h5>Upload Pollution Paper (Optional)</h5>

                        <div class="col-lg-2 text-center">
                            <label for="pollutionFront" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" id="pollutionFrontIcon" class="upload-icon">
                                <img id="pollutionFrontPreview" class="preview-image">
                                <input type="file" id="pollutionFront" hidden accept="image/*">
                            </label>
                            <div id="pollutionFront_error" class="text-danger small"></div>
                        </div>

                        <div class="col-lg-10 text-center">
                            <label for="pollutionBack" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" id="pollutionBackIcon" class="upload-icon">
                                <img id="pollutionBackPreview" class="preview-image">
                                <input type="file" id="pollutionBack" hidden accept="image/*">
                            </label>
                            <div id="pollutionBack_error" class="text-danger small"></div>
                        </div>
                    </div>

                    <!-- RC -->
                    <div class="row mt-4">
                        <h5>Upload Registration Certificate (Optional)</h5>

                        <div class="col-lg-2 text-center">
                            <label for="rcFront" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" id="rcFrontIcon" class="upload-icon">
                                <img id="rcFrontPreview" class="preview-image">
                                <input type="file" id="rcFront" hidden accept="image/*">
                            </label>
                            <div id="rcFront_error" class="text-danger small"></div>
                        </div>

                        <div class="col-lg-10 text-center">
                            <label for="rcBack" class="upload-box">
                                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" id="rcBackIcon" class="upload-icon">
                                <img id="rcBackPreview" class="preview-image">
                                <input type="file" id="rcBack" hidden accept="image/*">
                            </label>
                            <div id="rcBack_error" class="text-danger small"></div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-6 d-flex justify-content-center m-auto mb-3 gap-4 mt-4">
                    <a href="{{route('admin.deliveryBoyManagement')}}" class="btn btn-dark customBtn">Cancel</a>
                    <a class="btn btn-dark customBtn" id="submitBtn">Add</a>
                </div>
            </div>
        </div>

    </div>
</div>


<script>

document.addEventListener("DOMContentLoaded", () => {

    const MAX_FILE_SIZE = 4 * 1024 * 1024; // 4 MB
    const ALLOWED_EXT = ["jpg", "jpeg", "png", "gif", "pdf"];

    // All input IDs
    const fields = [
        "vehicle_name", "vehicle_reg",
        "vehicleImgFront", "vehicleImgBack",
        "idProofFront", "idProofBack",
        "dlFront", "dlBack",
        "insuranceFront",
        "pollutionFront", "pollutionBack",
        "rcFront", "rcBack"
    ];

    // Required lists
    const requiredText = ["vehicle_name", "vehicle_reg"];
    const requiredImages = [
        "vehicleImgFront", "vehicleImgBack",
        "idProofFront", "idProofBack",
        "dlFront", "dlBack",
        "insuranceFront"
    ];

    // Error messages
    const textErrors = {
        vehicle_name: "Please enter vehicle name.",
        vehicle_reg: "Please enter vehicle registration number."
    };

    const imageErrors = {
        vehicleImgFront: "Please upload vehicle front image.",
        vehicleImgBack: "Please upload vehicle back image.",
        idProofFront: "Please upload ID proof front image.",
        idProofBack: "Please upload ID proof back image.",
        dlFront: "Please upload driving license front image.",
        dlBack: "Please upload driving license back image.",
        insuranceFront: "Please upload insurance image."
    };

    const typeErrorMsg = "Invalid file type. Allowed: JPG, JPEG, PNG, GIF, PDF.";
    const sizeErrorMsg = "File size should not exceed 4 MB.";


    fields.forEach(id => {
        let input = document.getElementById(id);

        if (input && input.type === "file") {
            input.addEventListener("change", e => {
                let file = e.target.files[0];
                let errorBox = document.getElementById(id + "_error");
                errorBox.innerHTML = "";

                if (file) {
                    let ext = file.name.split(".").pop().toLowerCase();

                    // Validate extension
                    if (!ALLOWED_EXT.includes(ext)) {
                        errorBox.innerHTML = typeErrorMsg;
                        input.value = "";
                        return;
                    }

                    // Validate size
                    if (file.size > MAX_FILE_SIZE) {
                        errorBox.innerHTML = sizeErrorMsg;
                        input.value = "";
                        return;
                    }

                    // Show preview only for images (not PDF)
                    let preview = document.getElementById(id + "Preview");

                    if (preview) {
                        if (ext === "pdf") {
                            preview.src = "";  
                            preview.style.display = "none";
                        } else {
                            const reader = new FileReader();
                            reader.onload = ev => {
                                preview.src = ev.target.result;
                                preview.style.display = "block";
                            };
                            reader.readAsDataURL(file);
                        }
                    }
                }
            });
        }
    });

    // Clear text errors on typing
    requiredText.forEach(id => {
        document.getElementById(id).addEventListener("input", () => {
            document.getElementById(id + "_error").innerHTML = "";
        });
    });

    document.getElementById("submitBtn").addEventListener("click", () => {

        clearErrors();
        let valid = true;

        // Validate text fields
        requiredText.forEach(id => {
            if (!document.getElementById(id).value.trim()) {
                document.getElementById(id + "_error").innerHTML = textErrors[id];
                valid = false;
            }
        });

        // Validate required images
        requiredImages.forEach(id => {
            let input = document.getElementById(id);
            let errorBox = document.getElementById(id + "_error");

            if (input.files.length === 0) {
                errorBox.innerHTML = imageErrors[id];
                valid = false;
            }
        });

        if (!valid) return;

        let formData = new FormData();
        fields.forEach(id => {
            let el = document.getElementById(id);
            if (el.type === "file") {
                if (el.files.length > 0)
                    formData.append(id, el.files[0]);
            } else {
                formData.append(id, el.value);
            }
        });

        fetch("{{ route('admin.store_reg2') }}", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                toastr.success(data.message); 
                setTimeout(() => {
                    window.location.href = "{{ route('admin.deliveryBoyManagement') }}";
                }, 2000);
            } else {
                toastr.error(data.message || 'Something went wrong', 'Error');
            }
        })
        .catch(error => {
            console.error(error);
            toastr.error('An unexpected error occurred.', 'Error'); 
        });

    });


    function clearErrors() {
        fields.forEach(id => {
            let err = document.getElementById(id + "_error");
            if (err) err.innerHTML = "";
        });
    }
});

</script>

@endsection