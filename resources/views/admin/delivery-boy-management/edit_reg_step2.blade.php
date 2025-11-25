@extends('admin.layout.app')
@section('content')
<style>
.upload-box {
    /* width: 176px; */
    height: 160px;
    border: 2px dotted #c8ad8d;
    border-radius: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    /* IMPORTANT */
    position: relative;
}

/* .upload-icon {
    width: 60px;
    opacity: 0.4;
} */

.preview-image {
    width: 100%;
    height: 100%;
    object-fit: contain !important;
    /* FULL COVER */
    display: none;
    /* Hidden before upload */
    position: absolute;
    top: 0;
    left: 0;
}

.card-body {
    background: #6c757d0a;
}

@media (min-width: 1200px) and (max-width: 1440px) {
  
      /* Column adjustments */
    .col-lg-6 .col-6 {
        padding: 10px;
    }

    .row.mt-4 h5 {
        font-size: 18px;
    }
    .upload-box {
    width: 143px !important;
  
}
label {
    font-size: 18px;
}
}
</style>

<div class="inner-content management">
    <div class="d-flex flex-column align-items-start back-btn-box">

        <div class="d-flex align-items-center gap-3 mt-2">
            <div class="arrow">
                <a href="{{ route('admin.edit_deliveryboy_step1', ['id' => $step1Data['id'], 'type' => 'session']) }}"
                    class="table-button " type="button">
                    <i class="fas fa-angle-left"></i>
                </a>
            </div>
            <h2 class="h2 text-start">Vehicle Information</h2>

        </div>

        <div class="content">
            <div class="card p-3 mt-4">
                <div class="card-body">

                    <!-- Vehicle Name & Registration -->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mt-3">
                                <label class="mb-0">Vehicle Name</label>
                                <input type="text" placeholder="Enter Vehicle Name"
                                    oninput="this.value = this.value.replace(/[^A-Za-z0-9 ]/g,'').replace(/^\s+/,'')"
                                    class="form-control mt-1" id="vehicle_name"
                                    value="{{ $deliveryBoy->vehicle_name ?? '' }}">
                                <div id="vehicle_name_error" class="text-danger small"></div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mt-3">
                                <label class="mb-0">Vehicle Registration Number</label>
                                <input type="text" placeholder="Enter Vehicle Registration Number"
                                    oninput="this.value = this.value.replace(/[^A-Za-z0-9 ]/g,'').replace(/^\s+/,'')"
                                    class="form-control mt-1" id="vehicle_reg"
                                    value="{{ $deliveryBoy->vehicle_reg_no ?? '' }}">
                                <div id="vehicle_reg_error" class="text-danger small"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Vehicle Images -->
                    <div class="row mt-4">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <h5>Upload Vehicle Image</h5>
                            <div class="row mt-3">
                                <div class="col-6 text-center">
                                    <label for="vehicleImgFront" class="upload-box">
                                        <img src="{{ isset($deliveryBoy->vehicle_image) && $deliveryBoy->vehicle_image->firstWhere('is_front', 1) ? $deliveryBoy->vehicle_image->firstWhere('is_front', 1)->document_path : '/admin/image/imge-upload.svg' }}"
                                            id="vehicleImgFrontIcon" class="upload-icon" alt="Vehicle Front Image">
                                        <img id="vehicleImgFrontPreview" class="preview-image" alt="Vehicle Front Preview">
                                        <input type="file" id="vehicleImgFront" hidden accept="image/*"
                                            data-existing-image="{{ isset($deliveryBoy->vehicle_image) && $deliveryBoy->vehicle_image->firstWhere('is_front', 1) ? $deliveryBoy->vehicle_image->firstWhere('is_front', 1)->document_path : '' }}">
                                    </label>
                                    <div class="upload-subtitle">Front</div>
                                    <div id="vehicleImgFront_error" class="text-danger small"></div>
                                </div>

                                <div class="col-6 text-center">
                                    <label for="vehicleImgBack" class="upload-box">
                                        <img src="{{ isset($deliveryBoy->vehicle_image[1]) ? $deliveryBoy->vehicle_image[1]->document_path : '/admin/image/imge-upload.svg' }}"
                                            id="vehicleImgBackIcon" class="upload-icon" alt="Vehicle Back Image">
                                        <img id="vehicleImgBackPreview" class="preview-image" alt="Vehicle Back Preview">
                                        <input type="file" id="vehicleImgBack" hidden accept="image/*"
                                            data-existing-image="{{ isset($deliveryBoy->vehicle_image[1]) ? $deliveryBoy->vehicle_image[1]->document_path : '' }}">
                                    </label>
                                    <div class="upload-subtitle">Back</div>
                                    <div id="vehicleImgBack_error" class="text-danger small"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Identity Proof -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <h5>Upload Identity Proof</h5>
                            <div class="row mt-3">
                                <div class="col-6 text-center">
                                    <label for="idProofFront" class="upload-box">
                                        <img src="{{ isset($deliveryBoy->identity_proof[0]) ? $deliveryBoy->identity_proof[0]->document_path : '/admin/image/imge-upload.svg' }}"
                                            id="idProofFrontIcon" class="upload-icon" alt="Identity Proof Front">
                                        <img id="idProofFrontPreview" class="preview-image" alt="Identity Proof Front Preview">
                                        <input type="file" id="idProofFront" hidden accept="image/*"
                                            data-existing-image="{{ isset($deliveryBoy->identity_proof[0]) ? $deliveryBoy->identity_proof[0]->document_path : '' }}">
                                    </label>
                                    <div class="upload-subtitle">Front</div>
                                    <div id="idProofFront_error" class="text-danger small"></div>
                                </div>

                                <div class="col-6 text-center">
                                    <label for="idProofBack" class="upload-box">
                                        <img src="{{ isset($deliveryBoy->identity_proof[1]) ? $deliveryBoy->identity_proof[1]->document_path : '/admin/image/imge-upload.svg' }}"
                                            id="idProofBackIcon" class="upload-icon" alt="Identity Proof Back">
                                        <img id="idProofBackPreview" class="preview-image" alt="Identity Proof Back Preview">
                                        <input type="file" id="idProofBack" hidden accept="image/*"
                                            data-existing-image="{{ isset($deliveryBoy->identity_proof[1]) ? $deliveryBoy->identity_proof[1]->document_path : '' }}">
                                    </label>
                                    <div class="upload-subtitle">Back</div>
                                    <div id="idProofBack_error" class="text-danger small"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Driving License & Insurance -->
                    <div class="row mt-4">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <h5>Upload Driving License</h5>
                            <div class="row mt-3">
                                <div class="col-6 text-center">
                                    <label for="dlFront" class="upload-box">
                                        <img src="{{ isset($deliveryBoy->driving_license[0]) ? $deliveryBoy->driving_license[0]->document_path : '/admin/image/imge-upload.svg' }}"
                                            id="dlFrontIcon" class="upload-icon" alt="Driving License Front">
                                        <img id="dlFrontPreview" class="preview-image" alt="Driving License Front Preview">
                                        <input type="file" id="dlFront" hidden accept="image/*"
                                            data-existing-image="{{ isset($deliveryBoy->driving_license[0]) ? $deliveryBoy->driving_license[0]->document_path : '' }}">
                                    </label>
                                    <div class="upload-subtitle">Front</div>
                                    <div id="dlFront_error" class="text-danger small"></div>
                                </div>

                                <div class="col-6 text-center">
                                    <label for="dlBack" class="upload-box">
                                        <img src="{{ isset($deliveryBoy->driving_license[1]) ? $deliveryBoy->driving_license[1]->document_path : '/admin/image/imge-upload.svg' }}"
                                            id="dlBackIcon" class="upload-icon" alt="Driving License Back">
                                        <img id="dlBackPreview" class="preview-image" alt="Driving License Back Preview">
                                        <input type="file" id="dlBack" hidden accept="image/*"
                                            data-existing-image="{{ isset($deliveryBoy->driving_license[1]) ? $deliveryBoy->driving_license[1]->document_path : '' }}">
                                    </label>
                                    <div class="upload-subtitle">Back</div>
                                    <div id="dlBack_error" class="text-danger small"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <h5>Upload Vehicle Insurance</h5>
                            <div class="row mt-3">
                                <div class="col-6 text-center">
                                    <label for="insuranceFront" class="upload-box">
                                        <img src="{{ isset($deliveryBoy->vehicle_insurance[0]) ? $deliveryBoy->vehicle_insurance[0]->document_path : '/admin/image/imge-upload.svg' }}"
                                            id="insuranceFrontIcon" class="upload-icon" alt="Vehicle Insurance">
                                        <img id="insuranceFrontPreview" class="preview-image" alt="Vehicle Insurance Preview">
                                        <input type="file" id="insuranceFront" hidden accept="image/*"
                                            data-existing-image="{{ isset($deliveryBoy->vehicle_insurance[0]) ? $deliveryBoy->vehicle_insurance[0]->document_path : '' }}">
                                    </label>
                                    <div class="upload-subtitle">Insurance</div>
                                    <div id="insuranceFront_error" class="text-danger small"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Optional Papers -->
                    <div class="row mt-4">
                        <!-- Pollution Paper -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <h5>Upload Pollution Paper (Optional)</h5>
                            <div class="row mt-3">
                                <div class="col-6 text-center">
                                    <label for="pollutionFront" class="upload-box">
                                        <img src="{{ isset($deliveryBoy->pollution_paper[0]) ? $deliveryBoy->pollution_paper[0]->document_path : '/admin/image/imge-upload.svg' }}"
                                            id="pollutionFrontIcon" class="upload-icon" alt="Pollution Paper Front">
                                        <img id="pollutionFrontPreview" class="preview-image" alt="Pollution Paper Front Preview">
                                        <input type="file" id="pollutionFront" hidden accept="image/*"
                                            data-existing-image="{{ isset($deliveryBoy->pollution_paper[0]) ? $deliveryBoy->pollution_paper[0]->document_path : '' }}">
                                    </label>
                                    <div class="upload-subtitle">Front</div>
                                    <div id="pollutionFront_error" class="text-danger small"></div>
                                </div>

                                <div class="col-6 text-center">
                                    <label for="pollutionBack" class="upload-box">
                                        <img src="{{ isset($deliveryBoy->pollution_paper[1]) ? $deliveryBoy->pollution_paper[1]->document_path : '/admin/image/imge-upload.svg' }}"
                                            id="pollutionBackIcon" class="upload-icon" alt="Pollution Paper Back">
                                        <img id="pollutionBackPreview" class="preview-image" alt="Pollution Paper Back Preview">
                                        <input type="file" id="pollutionBack" hidden accept="image/*"
                                            data-existing-image="{{ isset($deliveryBoy->pollution_paper[1]) ? $deliveryBoy->pollution_paper[1]->document_path : '' }}">
                                    </label>
                                    <div class="upload-subtitle">Back</div>
                                    <div id="pollutionBack_error" class="text-danger small"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Registration Certificate -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <h5>Upload Registration Certificate (Optional)</h5>
                            <div class="row mt-3">
                                <div class="col-6 text-center">
                                    <label for="rcFront" class="upload-box">
                                        <img src="{{ isset($deliveryBoy->registration_certificate[0]) ? $deliveryBoy->registration_certificate[0]->document_path : '/admin/image/imge-upload.svg' }}"
                                            id="rcFrontIcon" class="upload-icon" alt="Registration Certificate Front">
                                        <img id="rcFrontPreview" class="preview-image" alt="Registration Certificate Front Preview">
                                        <input type="file" id="rcFront" hidden accept="image/*"
                                            data-existing-image="{{ isset($deliveryBoy->registration_certificate[0]) ? $deliveryBoy->registration_certificate[0]->document_path : '' }}">
                                    </label>
                                    <div class="upload-subtitle">Front</div>
                                    <div id="rcFront_error" class="text-danger small"></div>
                                </div>

                                <div class="col-6 text-center">
                                    <label for="rcBack" class="upload-box">
                                        <img src="{{ isset($deliveryBoy->registration_certificate[1]) ? $deliveryBoy->registration_certificate[1]->document_path : '/admin/image/imge-upload.svg' }}"
                                            id="rcBackIcon" class="upload-icon" alt="Registration Certificate Back">
                                        <img id="rcBackPreview" class="preview-image" alt="Registration Certificate Back Preview">
                                        <input type="file" id="rcBack" hidden accept="image/*"
                                            data-existing-image="{{ isset($deliveryBoy->registration_certificate[1]) ? $deliveryBoy->registration_certificate[1]->document_path : '' }}">
                                    </label>
                                    <div class="upload-subtitle">Back</div>
                                    <div id="rcBack_error" class="text-danger small"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="col-lg-6 d-flex justify-content-center m-auto mb-3 gap-4 mt-4">
                        <a href="{{route('admin.deliveryBoyManagement')}}" class="btn btn-dark customBtn">Cancel</a>
                        <a class="btn btn-dark customBtn" id="submitBtn">Update</a>
                    </div>

                </div>
            </div>
        </div>




    </div>






</div>
</div>


<script>

document.addEventListener("DOMContentLoaded", () => {
    const MAX_FILE_SIZE = 4 * 1024 * 1024; // 4 MB
    const ALLOWED_EXT = ["jpg", "jpeg", "png", "gif", "pdf"];

    const fields = [
        "vehicle_name","vehicle_reg",
        "vehicleImgFront","vehicleImgBack",
        "idProofFront","idProofBack",
        "dlFront","dlBack",
        "insuranceFront",
        "pollutionFront","pollutionBack",
        "rcFront","rcBack"
    ];

    const requiredText = ["vehicle_name","vehicle_reg"];
    const requiredImages = [
        "vehicleImgFront","vehicleImgBack",
        "idProofFront","idProofBack",
        "dlFront","dlBack",
        "insuranceFront"
    ];

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

    // Preview & validation clearing
    fields.forEach(id => {
        const input = document.getElementById(id);
        if(!input) return;
        if(input.type === "file") {
            input.addEventListener("change", e => {
                const file = e.target.files[0];
                const errBox = document.getElementById(id+"_error");
                if(errBox) errBox.innerHTML="";
                if(!file) return;

                const ext = file.name.split(".").pop().toLowerCase();
                if(!ALLOWED_EXT.includes(ext)){
                    errBox.innerHTML="Invalid file type. Allowed: JPG, JPEG, PNG, GIF, PDF.";
                    input.value="";
                    return;
                }
                if(file.size > MAX_FILE_SIZE){
                    errBox.innerHTML="File size should not exceed 4 MB.";
                    input.value="";
                    return;
                }

                const preview = document.getElementById(id+"Preview");
                if(preview && ext!=="pdf"){
                    const reader = new FileReader();
                    reader.onload = ev => { preview.src = ev.target.result; preview.style.display="block"; };
                    reader.readAsDataURL(file);
                }
            });
        } else {
            input.addEventListener("input", ()=>{ 
                const err = document.getElementById(id+"_error"); if(err) err.innerHTML=""; 
            });
        }
    });

    // Submit
    document.getElementById("submitBtn").addEventListener("click", e=>{
        e.preventDefault();
        let valid=true;

        // Clear errors
        fields.forEach(id=>{
            const err = document.getElementById(id+"_error");
            if(err) err.innerHTML="";
        });

        // Validate text
        requiredText.forEach(id=>{
            const el = document.getElementById(id);
            if(el && !el.value.trim()){
                document.getElementById(id+"_error").innerHTML = textErrors[id];
                valid=false;
            }
        });

        // Validate images
        requiredImages.forEach(id=>{
            const el = document.getElementById(id);
            if(!el) return;
            const existing = el.dataset.existingImage ? el.dataset.existingImage.trim() : '';
            if(el.files.length === 0 && existing === ''){
                document.getElementById(id+"_error").innerHTML = imageErrors[id];
                valid=false;
            }
        });

        if(!valid) return;

        const formData = new FormData();
        fields.forEach(id=>{
            const el = document.getElementById(id);
            if(!el) return;
            if(el.type==="file"){
                if(el.files.length>0) formData.append(id, el.files[0]);
                else if(el.dataset.existingImage) formData.append(id+"_url", el.dataset.existingImage);
            } else {
                formData.append(id, el.value);
            }
        });

        fetch("{{ route('admin.store_reg2_edit') }}", {
            method:"POST",
            body:formData,
            headers: {"X-CSRF-TOKEN": '{{ csrf_token() }}'}
        })
        .then(res=>res.json())
        .then(data=>{
            if(data.success){
                toastr.success(data.message);
                setTimeout(()=>{ window.location.href="{{ route('admin.deliveryBoyManagement') }}"; },2000);
            } else {
                toastr.error(data.message || 'Something went wrong', 'Error');
            }
        })
        .catch(err=>{
            console.error(err);
            toastr.error('An unexpected error occurred.', 'Error');
        });
    });
});



</script>




@endsection