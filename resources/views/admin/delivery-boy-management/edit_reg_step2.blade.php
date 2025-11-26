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

                    <!-- VEHICLE NAME & REGISTRATION -->
                    <div class="row">
                        <div class="col-lg-6 mt-3">
                            <label class="mb-0">Vehicle Name</label>
                            <input type="text" placeholder="Enter Vehicle Name"
                                oninput="this.value=this.value.replace(/[^A-Za-z0-9 ]/g,'').replace(/^\s+/,'')"
                                class="form-control mt-1" id="vehicle_name"
                                value="{{ $deliveryBoy->vehicle_name ?? '' }}">
                            <div id="vehicle_name_error" class="text-danger small"></div>
                        </div>

                        <div class="col-lg-6 mt-3">
                            <label class="mb-0">Vehicle Registration Number</label>
                            <input type="text" placeholder="Enter Vehicle Registration Number"
                                oninput="this.value=this.value.replace(/[^A-Za-z0-9 ]/g,'').replace(/^\s+/,'')"
                                class="form-control mt-1" id="vehicle_reg"
                                value="{{ $deliveryBoy->vehicle_reg_no ?? '' }}">
                            <div id="vehicle_reg_error" class="text-danger small"></div>
                        </div>
                    </div>

                    <!-- ===== VEHICLE IMAGE ===== -->
                    <div class="row mt-4">
                        <div class="col-lg-6">
                            <h5>Upload Vehicle Image</h5>
                            <div class="row mt-3">

                                <!-- Vehicle Front -->
                                <div class="col-6 text-center">
                                    <label for="vehicleImgFront" class="upload-box">

                                        @php
                                            $front = $deliveryBoy->vehicle_image->firstWhere('is_front', 1)->document_path ?? '';
                                            $extF = strtolower(pathinfo($front, PATHINFO_EXTENSION));
                                        @endphp

                                        <img id="vehicleImgFrontPreview" class="preview-image" style="display:{{ $front && $extF !== 'pdf' ? 'block' : 'none' }}; pointer-events:none;" src="{{ $front ?: '/admin/image/imge-upload.svg' }}">
                                        <embed id="vehicleImgFrontPdfPreview" class="preview-pdf" style="display:{{ $front && $extF === 'pdf' ? 'block' : 'none' }}; pointer-events:none;" type="application/pdf" src="{{ $front }}">

                                        <input type="file" id="vehicleImgFront" hidden accept="image/*,.pdf" data-existing-image="{{ $front }}">
                                    </label>

                                    <div class="upload-subtitle">Front</div>
                                    <div id="vehicleImgFront_error" class="text-danger small"></div>
                                </div>

                                <!-- Vehicle Back -->
                                <div class="col-6 text-center">
                                    <label for="vehicleImgBack" class="upload-box">

                                        @php
                                            $back = $deliveryBoy->vehicle_image[1]->document_path ?? '';
                                            $extB = strtolower(pathinfo($back, PATHINFO_EXTENSION));
                                        @endphp

                                        <img id="vehicleImgBackPreview" class="preview-image" style="display:{{ $back && $extB !== 'pdf' ? 'block' : 'none' }}; pointer-events:none;" src="{{ $back ?: '/admin/image/imge-upload.svg' }}">
                                        <embed id="vehicleImgBackPdfPreview" class="preview-pdf" style="display:{{ $back && $extB === 'pdf' ? 'block' : 'none' }}; pointer-events:none;" type="application/pdf" src="{{ $back }}">

                                        <input type="file" id="vehicleImgBack" hidden accept="image/*,.pdf" data-existing-image="{{ $back }}">
                                    </label>

                                    <div class="upload-subtitle">Back</div>
                                    <div id="vehicleImgBack_error" class="text-danger small"></div>
                                </div>
                            </div>
                        </div>

                        <!-- ===== IDENTITY PROOF ===== -->
                        <div class="col-lg-6">
                            <h5>Upload Identity Proof</h5>
                            <div class="row mt-3">

                                <!-- ID Front -->
                                <div class="col-6 text-center">
                                    <label for="idProofFront" class="upload-box">

                                        @php
                                            $idF = $deliveryBoy->identity_proof[0]->document_path ?? '';
                                            $ext = strtolower(pathinfo($idF, PATHINFO_EXTENSION));
                                        @endphp

                                        <img id="idProofFrontPreview" class="preview-image" style="display:{{ $idF && $ext !== 'pdf' ? 'block' : 'none' }}; pointer-events:none;" src="{{ $idF ?: '/admin/image/imge-upload.svg' }}">
                                        <embed id="idProofFrontPdfPreview" class="preview-pdf" style="display:{{ $idF && $ext === 'pdf' ? 'block' : 'none' }}; pointer-events:none;" type="application/pdf" src="{{ $idF }}">

                                        <input type="file" id="idProofFront" hidden accept="image/*,.pdf" data-existing-image="{{ $idF }}">
                                    </label>

                                    <div class="upload-subtitle">Front</div>
                                    <div id="idProofFront_error" class="text-danger small"></div>
                                </div>

                                <!-- ID Back -->
                                <div class="col-6 text-center">
                                    <label for="idProofBack" class="upload-box">

                                        @php
                                            $idB = $deliveryBoy->identity_proof[1]->document_path ?? '';
                                            $ext = strtolower(pathinfo($idB, PATHINFO_EXTENSION));
                                        @endphp

                                        <img id="idProofBackPreview" class="preview-image" style="display:{{ $idB && $ext !== 'pdf' ? 'block' : 'none' }}; pointer-events:none;" src="{{ $idB ?: '/admin/image/imge-upload.svg' }}">
                                        <embed id="idProofBackPdfPreview" class="preview-pdf" style="display:{{ $idB && $ext === 'pdf' ? 'block' : 'none' }}; pointer-events:none;" type="application/pdf" src="{{ $idB }}">

                                        <input type="file" id="idProofBack" hidden accept="image/*,.pdf" data-existing-image="{{ $idB }}">
                                    </label>

                                    <div class="upload-subtitle">Back</div>
                                    <div id="idProofBack_error" class="text-danger small"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===== DRIVING LICENSE ===== -->
                    <div class="row mt-4">
                        <div class="col-lg-6">
                            <h5>Upload Driving License</h5>
                            <div class="row mt-3">

                                <!-- DL Front -->
                                <div class="col-6 text-center">
                                    <label for="dlFront" class="upload-box">
                                        @php
                                            $dlF = $deliveryBoy->driving_license[0]->document_path ?? '';
                                            $ext = strtolower(pathinfo($dlF, PATHINFO_EXTENSION));
                                        @endphp

                                        <img id="dlFrontPreview" class="preview-image" style="display:{{ $dlF && $ext !== 'pdf' ? 'block' : 'none' }}; pointer-events:none;" src="{{ $dlF ?: '/admin/image/imge-upload.svg' }}">
                                        <embed id="dlFrontPdfPreview" class="preview-pdf" style="display:{{ $dlF && $ext === 'pdf' ? 'block' : 'none' }}; pointer-events:none;" type="application/pdf" src="{{ $dlF }}">

                                        <input type="file" id="dlFront" hidden accept="image/*,.pdf" data-existing-image="{{ $dlF }}">
                                    </label>
                                    <div class="upload-subtitle">Front</div>
                                    <div id="dlFront_error" class="text-danger small"></div>
                                </div>

                                <!-- DL Back -->
                                <div class="col-6 text-center">
                                    <label for="dlBack" class="upload-box">
                                        @php
                                            $dlB = $deliveryBoy->driving_license[1]->document_path ?? '';
                                            $ext = strtolower(pathinfo($dlB, PATHINFO_EXTENSION));
                                        @endphp

                                        <img id="dlBackPreview" class="preview-image" style="display:{{ $dlB && $ext !== 'pdf' ? 'block' : 'none' }}; pointer-events:none;" src="{{ $dlB ?: '/admin/image/imge-upload.svg' }}">
                                        <embed id="dlBackPdfPreview" class="preview-pdf" style="display:{{ $dlB && $ext === 'pdf' ? 'block' : 'none' }}; pointer-events:none;" type="application/pdf" src="{{ $dlB }}">

                                        <input type="file" id="dlBack" hidden accept="image/*,.pdf" data-existing-image="{{ $dlB }}">
                                    </label>
                                    <div class="upload-subtitle">Back</div>
                                    <div id="dlBack_error" class="text-danger small"></div>
                                </div>
                            </div>
                        </div>

                        <!-- ===== INSURANCE ===== -->
                        <div class="col-lg-6">
                            <h5>Upload Vehicle Insurance</h5>
                            <div class="mt-3">
                                @php
                                    $ins = $deliveryBoy->vehicle_insurance[0]->document_path ?? '';
                                    $ext = strtolower(pathinfo($ins, PATHINFO_EXTENSION));
                                @endphp

                                <label for="insuranceFront" class="upload-box text-center">
                                    <img id="insuranceFrontPreview" class="preview-image" style="display:{{ $ins && $ext !== 'pdf' ? 'block' : 'none' }}; pointer-events:none;" src="{{ $ins ?: '/admin/image/imge-upload.svg' }}">
                                    <embed id="insuranceFrontPdfPreview" class="preview-pdf" style="display:{{ $ins && $ext === 'pdf' ? 'block' : 'none' }}; pointer-events:none;" type="application/pdf" src="{{ $ins }}">

                                    <input type="file" id="insuranceFront" hidden accept="image/*,.pdf" data-existing-image="{{ $ins }}">
                                </label>

                                <div class="upload-subtitle">Insurance</div>
                                <div id="insuranceFront_error" class="text-danger small"></div>
                            </div>
                        </div>
                    </div>

                    <!-- OPTIONAL DOCUMENTS -->
                    <div class="row mt-4">
                        <!-- POLLUTION PAPERS -->
                        <div class="col-lg-6">
                            <h5>Upload Pollution Paper (Optional)</h5>
                            <div class="row mt-3">
                                <div class="col-6 text-center">
                                    @php
                                        $pf = $deliveryBoy->pollution_paper[0]->document_path ?? '';
                                        $ext = strtolower(pathinfo($pf, PATHINFO_EXTENSION));
                                    @endphp

                                    <label for="pollutionFront" class="upload-box">
                                        <img id="pollutionFrontPreview" class="preview-image" style="display:{{ $pf && $ext !== 'pdf' ? 'block' : 'none' }}; pointer-events:none;" src="{{ $pf ?: '/admin/image/imge-upload.svg' }}">
                                        <embed id="pollutionFrontPdfPreview" class="preview-pdf" style="display:{{ $pf && $ext === 'pdf' ? 'block' : 'none' }}; pointer-events:none;" type="application/pdf" src="{{ $pf }}">

                                        <input type="file" id="pollutionFront" hidden accept="image/*,.pdf" data-existing-image="{{ $pf }}">
                                    </label>

                                    <div class="upload-subtitle">Front</div>
                                    <div id="pollutionFront_error" class="text-danger small"></div>
                                </div>

                                <div class="col-6 text-center">
                                    @php
                                        $pb = $deliveryBoy->pollution_paper[1]->document_path ?? '';
                                        $ext = strtolower(pathinfo($pb, PATHINFO_EXTENSION));
                                    @endphp

                                    <label for="pollutionBack" class="upload-box">
                                        <img id="pollutionBackPreview" class="preview-image" style="display:{{ $pb && $ext !== 'pdf' ? 'block' : 'none' }}; pointer-events:none;" src="{{ $pb ?: '/admin/image/imge-upload.svg' }}">
                                        <embed id="pollutionBackPdfPreview" class="preview-pdf" style="display:{{ $pb && $ext === 'pdf' ? 'block' : 'none' }}; pointer-events:none;" type="application/pdf" src="{{ $pb }}">

                                        <input type="file" id="pollutionBack" hidden accept="image/*,.pdf" data-existing-image="{{ $pb }}">
                                    </label>

                                    <div class="upload-subtitle">Back</div>
                                    <div id="pollutionBack_error" class="text-danger small"></div>
                                </div>
                            </div>
                        </div>

                        <!-- RC CERTIFICATE -->
                        <div class="col-lg-6">
                            <h5>Upload Registration Certificate (Optional)</h5>
                            <div class="row mt-3">
                                <div class="col-6 text-center">
                                    @php
                                        $rcF = $deliveryBoy->registration_certificate[0]->document_path ?? '';
                                        $ext = strtolower(pathinfo($rcF, PATHINFO_EXTENSION));
                                    @endphp

                                    <label for="rcFront" class="upload-box">
                                        <img id="rcFrontPreview" class="preview-image" style="display:{{ $rcF && $ext !== 'pdf' ? 'block' : 'none' }}; pointer-events:none;" src="{{ $rcF ?: '/admin/image/imge-upload.svg' }}">
                                        <embed id="rcFrontPdfPreview" class="preview-pdf" style="display:{{ $rcF && $ext === 'pdf' ? 'block' : 'none' }}; pointer-events:none;" type="application/pdf" src="{{ $rcF }}">

                                        <input type="file" id="rcFront" hidden accept="image/*,.pdf" data-existing-image="{{ $rcF }}">
                                    </label>

                                    <div class="upload-subtitle">Front</div>
                                    <div id="rcFront_error" class="text-danger small"></div>
                                </div>

                                <div class="col-6 text-center">
                                    @php
                                        $rcB = $deliveryBoy->registration_certificate[1]->document_path ?? '';
                                        $ext = strtolower(pathinfo($rcB, PATHINFO_EXTENSION));
                                    @endphp

                                    <label for="rcBack" class="upload-box">
                                        <img id="rcBackPreview" class="preview-image" style="display:{{ $rcB && $ext !== 'pdf' ? 'block' : 'none' }}; pointer-events:none;" src="{{ $rcB ?: '/admin/image/imge-upload.svg' }}">
                                        <embed id="rcBackPdfPreview" class="preview-pdf" style="display:{{ $rcB && $ext === 'pdf' ? 'block' : 'none' }}; pointer-events:none;" type="application/pdf" src="{{ $rcB }}">

                                        <input type="file" id="rcBack" hidden accept="image/*,.pdf" data-existing-image="{{ $rcB }}">
                                    </label>

                                    <div class="upload-subtitle">Back</div>
                                    <div id="rcBack_error" class="text-danger small"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BUTTONS -->
                    <div class="col-lg-6 d-flex justify-content-center m-auto mb-3 gap-4 mt-4">
                        <a href="{{ route('admin.deliveryBoyManagement') }}" class="btn btn-dark customBtn">Cancel</a>
                        <a class="btn btn-dark customBtn" id="submitBtn">Update</a>
                    </div>
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

    // ------------------- File input preview -------------------
    function setupFileInput(inputId, imgPreviewId, pdfPreviewId) {
        const input = document.getElementById(inputId);
        const imgPreview = document.getElementById(imgPreviewId);
        const pdfPreview = document.getElementById(pdfPreviewId);
        const errBox = document.getElementById(inputId+"_error");

        // On file selection
        input.addEventListener('change', function() {
            const file = this.files[0];
            if (!file) return;

            // Clear error
            if(errBox) errBox.innerHTML="";

            const ext = file.name.split('.').pop().toLowerCase();
            if (!ALLOWED_EXT.includes(ext)) {
                if(errBox) errBox.innerHTML="Invalid file type. Allowed: JPG, JPEG, PNG, GIF, PDF.";
                input.value="";
                return;
            }
            if (file.size > MAX_FILE_SIZE) {
                if(errBox) errBox.innerHTML="File size should not exceed 4 MB.";
                input.value="";
                return;
            }

            const url = URL.createObjectURL(file);
            if (ext === 'pdf') {
                if (imgPreview) imgPreview.style.display='none';
                if (pdfPreview) { pdfPreview.src = url; pdfPreview.style.display='block'; }
            } else {
                if (pdfPreview) pdfPreview.style.display='none';
                if (imgPreview) { imgPreview.src = url; imgPreview.style.display='block'; }
            }
        });
    }

    // Initialize all file inputs
    const fileFields = [
        "vehicleImgFront","vehicleImgBack",
        "idProofFront","idProofBack",
        "dlFront","dlBack",
        "insuranceFront",
        "pollutionFront","pollutionBack",
        "rcFront","rcBack"
    ];
    fileFields.forEach(id=>{
        setupFileInput(id, id+"Preview", id+"PdfPreview");
    });

    // ------------------- Text input validation -------------------
    fields.forEach(id=>{
        const el = document.getElementById(id);
        if(el && el.type !== "file") {
            el.addEventListener("input", () => {
                const err = document.getElementById(id+"_error");
                if(err) err.innerHTML="";
            });
        }
    });

    // ------------------- Submit -------------------
    document.getElementById("submitBtn").addEventListener("click", e=>{
        e.preventDefault();
        let valid=true;

        // Clear all errors
        fields.forEach(id=>{
            const err = document.getElementById(id+"_error");
            if(err) err.innerHTML="";
        });

        // Validate required text
        requiredText.forEach(id=>{
            const el = document.getElementById(id);
            if(el && !el.value.trim()){
                document.getElementById(id+"_error").innerHTML = textErrors[id];
                valid=false;
            }
        });

        // Validate required images
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

        // Build FormData
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

        // Submit via fetch
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