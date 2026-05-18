@extends('admin.layout.app')
@section('content')
<style>
.upload-box {
     width: 250px;
    height: 181px;
    border: 2px dotted #c8ad8d;
    border-radius: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    /* IMPORTANT */
    position: relative;
}

.upload-icon {
    width: 60px;
    opacity: 0.4;
}

.preview-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
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
}
</style>

<div class="inner-content management">
    <div class="d-flex flex-column align-items-start back-btn-box">

        <div class="d-flex align-items-center gap-3 mt-2">
            <div class="arrow">
                <a href="{{ route('admin.deliveryboy_reg_step1', ['type' => 'session']) }}" class="table-button "
                    type="button">
                    <i class="fas fa-angle-left"></i>
                </a>
            </div>
            <h2 class="h2 text-start">{{ __('admin_messages.vehicle_information') }}</h2>

        </div>
        <div class="content">
            <div class="card p-3 mt-4">
                <div class="card-body">
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="mt-3">
                                <label class="mb-0">{{ __('admin_messages.vehicle_name') }}</label>
                                <input type="text" placeholder="{{ __('admin_messages.enter_vehicle_name') }}"
                                    oninput="this.value = this.value.replace(/[^A-Za-z0-9 ]/g,'').replace(/^\s+/,'')"
                                    class="form-control mt-1" id="vehicle_name">
                                <div id="vehicle_name_error" class="text-danger small"></div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mt-3">
                                <label class="mb-0">{{ __('admin_messages.registration_number') }}</label>
                                <input type="text" placeholder="{{ __('admin_messages.enter_vehicle_registration_number') }}"
                                    oninput="this.value = this.value.replace(/[^A-Za-z0-9 ]/g,'').replace(/^\s+/,'')"
                                    class="form-control mt-1" id="vehicle_reg">
                                <div id="vehicle_reg_error" class="text-danger small"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <h5>{{ __('admin_messages.upload_vehicle_image') }}</h5>
                            <div class="row mt-3">
                                <div class="col-6 text-center">
                                    <label for="vehicleImgFront" class="upload-box">
                                        <img src="/admin/image/imge-upload.svg" id="vehicleImgFrontIcon" class="upload-icon">
                                        <img id="vehicleImgFrontPreview" class="preview-image" style="display:none; pointer-events:none;">
                                        <embed id="vehicleImgFrontPdfPreview" type="application/pdf" style="display:none; width:100%; height:150px; pointer-events:none;">
                                        <input type="file" id="vehicleImgFront" hidden accept="image/*,.pdf">
                                    </label>
                                    <div class="upload-subtitle">{{ __('admin_messages.front') }}</div>
                                    <div id="vehicleImgFront_error" class="text-danger small"></div>
                                </div>

                                <div class="col-6 text-center">
                                    <label for="vehicleImgBack" class="upload-box">
                                        <img src="/admin/image/imge-upload.svg" id="vehicleImgBackIcon" class="upload-icon">
                                        <img id="vehicleImgBackPreview" class="preview-image" style="display:none; pointer-events:none;">
                                        <embed id="vehicleImgBackPdfPreview" type="application/pdf" style="display:none; width:100%; height:150px; pointer-events:none;">
                                        <input type="file" id="vehicleImgBack" hidden accept="image/*,.pdf">
                                    </label>
                                    <div class="upload-subtitle">{{ __('admin_messages.back') }}</div>
                                    <div id="vehicleImgBack_error" class="text-danger small"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <h5>{{ __('admin_messages.upload_identity_proof') }}</h5>
                            <div class="row mt-3">
                                <div class="col-6 text-center">
                                    <label for="idProofFront" class="upload-box">
                                        <img src="/admin/image/imge-upload.svg" id="idProofFrontIcon" class="upload-icon">
                                        <img id="idProofFrontPreview" class="preview-image" style="display:none; pointer-events:none;">
                                        <embed id="idProofFrontPdfPreview" type="application/pdf" style="display:none; width:100%; height:150px; pointer-events:none;">
                                        <input type="file" id="idProofFront" hidden accept="image/*,.pdf">
                                    </label>
                                    <div class="upload-subtitle">{{ __('admin_messages.front') }}</div>
                                    <div id="idProofFront_error" class="text-danger small"></div>
                                </div>

                                <div class="col-6 text-center">
                                    <label for="idProofBack" class="upload-box">
                                        <img src="/admin/image/imge-upload.svg" id="idProofBackIcon" class="upload-icon">
                                        <img id="idProofBackPreview" class="preview-image" style="display:none; pointer-events:none;">
                                        <embed id="idProofBackPdfPreview" type="application/pdf" style="display:none; width:100%; height:150px; pointer-events:none;">
                                        <input type="file" id="idProofBack" hidden accept="image/*,.pdf">
                                    </label>
                                    <div class="upload-subtitle">{{ __('admin_messages.back') }}</div>
                                    <div id="idProofBack_error" class="text-danger small"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <h5>{{ __('admin_messages.upload_driving_license') }}</h5>
                            <div class="row mt-3">
                                <div class="col-6 text-center">
                                    <label for="dlFront" class="upload-box">
                                        <img src="/admin/image/imge-upload.svg" id="dlFrontIcon" class="upload-icon">
                                        <img id="dlFrontPreview" class="preview-image" style="display:none; pointer-events:none;">
                                        <embed id="dlFrontPdfPreview" type="application/pdf" style="display:none; width:100%; height:150px; pointer-events:none;">
                                        <input type="file" id="dlFront" hidden accept="image/*,.pdf">
                                    </label>
                                    <div class="upload-subtitle">{{ __('admin_messages.front') }}</div>
                                    <div id="dlFront_error" class="text-danger small"></div>
                                </div>

                                <div class="col-6 text-center">
                                    <label for="dlBack" class="upload-box">
                                        <img src="/admin/image/imge-upload.svg" id="dlBackIcon" class="upload-icon">
                                        <img id="dlBackPreview" class="preview-image" style="display:none; pointer-events:none;">
                                        <embed id="dlBackPdfPreview" type="application/pdf" style="display:none; width:100%; height:150px; pointer-events:none;">
                                        <input type="file" id="dlBack" hidden accept="image/*,.pdf">
                                    </label>
                                    <div class="upload-subtitle">{{ __('admin_messages.back') }}</div>
                                    <div id="dlBack_error" class="text-danger small"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <h5>{{ __('admin_messages.upload_vehicle_insurance') }}</h5>
                            <div class="row mt-3 justify-content-start">
                                <div class="col-6 text-center">
                                    <label for="insuranceFront" class="upload-box">
                                        <img src="/admin/image/imge-upload.svg" id="insuranceFrontIcon" class="upload-icon">
                                        <img id="insuranceFrontPreview" class="preview-image" style="display:none; pointer-events:none;">
                                        <embed id="insuranceFrontPdfPreview" type="application/pdf" style="display:none; width:100%; height:150px; pointer-events:none;">
                                        <input type="file" id="insuranceFront" hidden accept="image/*,.pdf">
                                    </label>
                                    <div id="insuranceFront_error" class="text-danger small"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <h5>{{ __('admin_messages.upload_pollution_paper_optional') }}</h5>
                            <div class="row mt-3">
                                <div class="col-6 text-center">
                                    <label for="pollutionFront" class="upload-box">
                                        <img src="/admin/image/imge-upload.svg" id="pollutionFrontIcon" class="upload-icon">
                                        <img id="pollutionFrontPreview" class="preview-image" style="display:none; pointer-events:none;">
                                        <embed id="pollutionFrontPdfPreview" type="application/pdf" style="display:none; width:100%; height:150px; pointer-events:none;">
                                        <input type="file" id="pollutionFront" hidden accept="image/*,.pdf">
                                    </label>
                                    <div class="upload-subtitle">{{ __('admin_messages.front') }}</div>
                                    <div id="pollutionFront_error" class="text-danger small"></div>
                                </div>

                                <div class="col-6 text-center">
                                    <label for="pollutionBack" class="upload-box">
                                        <img src="/admin/image/imge-upload.svg" id="pollutionBackIcon" class="upload-icon">
                                        <img id="pollutionBackPreview" class="preview-image" style="display:none; pointer-events:none;">
                                        <embed id="pollutionBackPdfPreview" type="application/pdf" style="display:none; width:100%; height:150px; pointer-events:none;">
                                        <input type="file" id="pollutionBack" hidden accept="image/*,.pdf">
                                    </label>
                                    <div class="upload-subtitle">{{ __('admin_messages.back') }}</div>
                                    <div id="pollutionBack_error" class="text-danger small"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <h5>{{ __('admin_messages.upload_registration_certificate_optional') }}</h5>
                            <div class="row mt-3">
                                <div class="col-6 text-center">
                                    <label for="rcFront" class="upload-box">
                                        <img src="/admin/image/imge-upload.svg" id="rcFrontIcon" class="upload-icon">
                                        <img id="rcFrontPreview" class="preview-image" style="display:none; pointer-events:none;">
                                        <embed id="rcFrontPdfPreview" type="application/pdf" style="display:none; width:100%; height:150px; pointer-events:none;">
                                        <input type="file" id="rcFront" hidden accept="image/*,.pdf">
                                    </label>
                                       <div class="upload-subtitle">{{ __('admin_messages.front') }}</div>
                                   <div id="rcFront_error" class="text-danger small"></div>
                                </div>

                                <div class="col-6 text-center">
                                    <label for="rcBack" class="upload-box">
                                        <img src="/admin/image/imge-upload.svg" id="rcBackIcon" class="upload-icon">
                                        <img id="rcBackPreview" class="preview-image" style="display:none; pointer-events:none;">
                                        <embed id="rcBackPdfPreview" type="application/pdf" style="display:none; width:100%; height:150px; pointer-events:none;">
                                        <input type="file" id="rcBack" hidden accept="image/*,.pdf">
                                    </label>
                                    <div class="upload-subtitle">{{ __('admin_messages.back') }}</div>
                                    <div id="rcBack_error" class="text-danger small"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 d-flex justify-content-center m-auto mb-3 gap-4 mt-4">
                        <a href="{{route('admin.deliveryBoyManagement')}}" class="btn btn-dark customBtn">{{ __('admin_messages.cancel') }}</a>
                        <a class="btn btn-dark customBtn" id="submitBtn">{{ __('admin_messages.add') }}</a>
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
        "vehicle_name", "vehicle_reg",
        "vehicleImgFront", "vehicleImgBack",
        "idProofFront", "idProofBack",
        "dlFront", "dlBack",
        "insuranceFront",
        "pollutionFront", "pollutionBack",
        "rcFront", "rcBack"
    ];

    const requiredText = ["vehicle_name", "vehicle_reg"];
    const requiredImages = [
        "vehicleImgFront", "vehicleImgBack",
        "idProofFront", "idProofBack",
        "dlFront", "dlBack",
        "insuranceFront"
    ];

    const textErrors = {
        vehicle_name: "{{ __('admin_messages.please_enter_vehicle_name') }}",
        vehicle_reg: "{{ __('admin_messages.enter_vehicle_registration_number') }}",
    };

    const imageErrors = {
        vehicleImgFront: "{{ __('admin_messages.please_upload_vehicle_front_image') }}",
        vehicleImgBack: "{{ __('admin_messages.please_upload_vehicle_back_image') }}",
        idProofFront: "{{ __('admin_messages.please_upload_id_proof_front_image') }}",
        idProofBack: "{{ __('admin_messages.please_upload_id_proof_back_image') }}",
        dlFront: "{{ __('admin_messages.please_upload_driving_license_front_image') }}",
        dlBack: "{{ __('admin_messages.please_upload_driving_license_back_image') }}",
        insuranceFront: "{{ __('admin_messages.please_upload_vehicle_insurance_image') }}",
    };

    const typeErrorMsg = "{{ __('admin_messages.invalid_file_type_allowed') }}";
    const sizeErrorMsg = "{{ __('admin_messages.image_size_less_than_4mb') }}";

    fields.forEach(id => {
        let input = document.getElementById(id);
        if (input && input.type === "file") {
            input.addEventListener("change", e => {
                let file = e.target.files[0];
                let errorBox = document.getElementById(id + "_error");
                errorBox.innerHTML = "";

                let previewImg = document.getElementById(id + "Preview");
                let previewPdf = document.getElementById(id + "PdfPreview");

                if (file) {
                    let ext = file.name.split(".").pop().toLowerCase();

                    if (!ALLOWED_EXT.includes(ext)) {
                        errorBox.innerHTML = typeErrorMsg;
                        input.value = "";
                        previewImg.style.display = "none";
                        previewPdf.style.display = "none";
                        return;
                    }

                    if (file.size > MAX_FILE_SIZE) {
                        errorBox.innerHTML = sizeErrorMsg;
                        input.value = "";
                        previewImg.style.display = "none";
                        previewPdf.style.display = "none";
                        return;
                    }

                    // if (ext === "pdf") {
                    //     previewImg.style.display = "none";
                    //     previewPdf.src = URL.createObjectURL(file);
                    //     previewPdf.style.display = "block";
                    // } else {
                    //     previewPdf.style.display = "none";
                    //     const reader = new FileReader();
                    //     reader.onload = ev => {
                    //         previewImg.src = ev.target.result;
                    //         previewImg.style.display = "block";
                    //     };
                    //     reader.readAsDataURL(file);
                    // }
                    if (ext === "pdf") {
                        previewPdf.style.display = "none"; 
                        previewImg.src = "/admin/image/PDF_file_icon.svg";
                        previewImg.style.display = "block";
                    } else {
                        previewPdf.style.display = "none";
                        const reader = new FileReader();
                        reader.onload = ev => {
                            previewImg.src = ev.target.result;
                            previewImg.style.display = "block";
                        };
                        reader.readAsDataURL(file);
                    }

                }
            });
        }
    });

    requiredText.forEach(id => {
        document.getElementById(id).addEventListener("input", () => {
            document.getElementById(id + "_error").innerHTML = "";
        });
    });

    document.getElementById("submitBtn").addEventListener("click", () => {
        clearErrors();
        let valid = true;

        requiredText.forEach(id => {
            if (!document.getElementById(id).value.trim()) {
                document.getElementById(id + "_error").innerHTML = textErrors[id];
                valid = false;
            }
        });

        requiredImages.forEach(id => {
            let input = document.getElementById(id);
            if (!input.files || input.files.length === 0) {
                document.getElementById(id + "_error").innerHTML = imageErrors[id];
                valid = false;
            }
        });

        if (!valid) return;

        let formData = new FormData();
        fields.forEach(id => {
            let el = document.getElementById(id);
            if (el.type === "file" && el.files.length > 0) {
                formData.append(id, el.files[0]);
            } else {
                formData.append(id, el.value);
            }
        });

        fetch("{{ route('admin.store_reg2') }}", {
            method: "POST",
            body: formData,
            headers: { "X-CSRF-TOKEN": '{{ csrf_token() }}' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                toastr.success(data.message);
                setTimeout(() => window.location.href = "{{ route('admin.deliveryBoyManagement') }}", 2000);
            } else {
                toastr.error(data.message || 'Something went wrong', 'Error');
            }
        })
        .catch(err => toastr.error('An unexpected error occurred.', 'Error'));
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