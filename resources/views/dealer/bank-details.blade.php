<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Bank Details</title>
    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/css/intlTelInput.css"/>
    <link href="assets/custom-file/css/bootstrap.min.css" rel="stylesheet">
    <!-- Main CSS File -->
    <link href="assets/custom-file/css/style.css" rel="stylesheet">
</head>

<body>

<div class="login-header">
    <div class="des-logo">
        <a href="#"><img src="assets/img/desynat-logo.svg" alt="image" class="img-fluid logo-login">  </a> 
    </div>
    <div class="des-language"></div>
</div>

    <div class="login-wapper">
        <div class="container-fluid p-0">
            <div class="login-grid-bg">
                <div class="row g-0">
                    <div class="col-lg-6 bg-logo-wapper">
                        <div class="login-img">
                            <img src="assets/img/Desynat-logo-2.svg" alt="image" class="img-fluid logo-login">                          
                        </div>
                        <img src="assets/img/Vector-left.svg" alt="image" class="vector-left">
                        <img src="assets/img/Vector-right.svg" alt="image" class="vector-right">
                    </div>
                    <div class="col-lg-6">
                        <div class="login-content pt-40">
                            <div class="login-grid-2 signup-scroll pagescroll p-3">
                                <div class="cmn-header mb-3">
                                    <h1><a href="store_page.php"><i class="bi bi-chevron-left"></i></a> Upload documents & Bank details</h1>
                                </div>

                                <form>
                                    <div class="step-progress py-4">
                                        <div class="progress pro-1" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 100%"></div>
                                        </div>
                                        <div class="progress pro-1" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 100%"></div>
                                        </div>
                                        <div class="progress pro-1" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 100%"></div>
                                        </div>
                                        <div class="progress pro-1" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 100%"></div>
                                        </div>
                                    </div>

                                    <div class="owner-pnl">
                                        <div class="form-group">
                                            <label for="name">Owner's Documents</label>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="upload-image w-100">
                                                        <label class="uploadLabel" style="cursor:pointer;text-align:center;">
                                                            <img src="assets/img/upload-icon.svg"><div class="text-color-upload">Document 1</div>
                                                            <input type="file" accept="image/*" hidden onchange="showPreview(event)">
                                                        </label>
                                                        <div class="imgshow">
                                                            <img class="preview" style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                                                            <span class="removeIcon" style="display:none;cursor:pointer;font-size:24px;color:red;" onclick="removeImg()">&times;</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="upload-image w-100">
                                                        <label class="uploadLabel" style="cursor:pointer;text-align:center;">
                                                            <img src="assets/img/upload-icon.svg"><div class="text-color-upload">Document 1</div>
                                                            <input type="file" accept="image/*" hidden onchange="showPreview(event)">
                                                        </label>
                                                        <div class="imgshow">
                                                            <img class="preview" style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                                                            <span class="removeIcon" style="display:none;cursor:pointer;font-size:24px;color:red;" onclick="removeImg()">&times;</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="owner-pnl">
                                        <div class="form-group">
                                            <label for="name">Store Documents</label>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="upload-image w-100">
                                                        <label class="uploadLabel" style="cursor:pointer;text-align:center;">
                                                            <img src="assets/img/upload-icon.svg"><div class="text-color-upload">Document 1</div>
                                                            <input type="file" accept="image/*" hidden onchange="showPreview(event)">
                                                        </label>
                                                        <div class="imgshow">
                                                            <img class="preview" style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                                                            <span class="removeIcon" style="display:none;cursor:pointer;font-size:24px;color:red;" onclick="removeImg()">&times;</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="upload-image w-100">
                                                        <label class="uploadLabel" style="cursor:pointer;text-align:center;">
                                                            <img src="assets/img/upload-icon.svg"><div class="text-color-upload">Document 1</div>
                                                            <input type="file" accept="image/*" hidden onchange="showPreview(event)">
                                                        </label>
                                                        <div class="imgshow">
                                                            <img class="preview" style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                                                            <span class="removeIcon" style="display:none;cursor:pointer;font-size:24px;color:red;" onclick="removeImg()">&times;</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="owner-pnl mt-4">
                                        <h5 class="mb-2">Bank details</h5>
                                        <div class="form-group">
                                            <label for="name">Account Type</label>
                                            <div class="d-flex gap-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="personal">
                                                    <label class="form-check-label mt-0" for="personal"> Personal </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="personal">
                                                    <label class="form-check-label mt-0" for="personal"> Business </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="name">IBAN</label>
                                        <input type="text" class="form-control" placeholder="KW">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">SWIFT/BIC</label>
                                        <input type="text" class="form-control" placeholder="Enter Swift">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Bank Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Bank Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Account holder name</label>
                                        <input type="text" class="form-control" placeholder="Enter Account holder name">
                                    </div>
                                    
                                    <div class="owner-pnl">
                                        <div class="form-group">
                                            <label for="name">Upload proof of account</label>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="upload-image w-100">
                                                        <label class="uploadLabel" style="cursor:pointer;text-align:center;">
                                                            <img src="assets/img/upload-icon.svg"><div class="text-color-upload">Bank Statement or Bank Letter,PDF/JPG/PNG</div>
                                                            <input type="file" accept="image/*" hidden onchange="showPreview(event)">
                                                        </label>
                                                        <div class="imgshow">
                                                            <img class="preview" style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                                                            <span class="removeIcon" style="display:none;cursor:pointer;font-size:24px;color:red;" onclick="removeImg()">&times;</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                   
                                    <div class="login-btn mt-5">
                                        <a href="summary_page.php" class="btn btn-success w-100">Continue</a>
                                    </div>

                                </form>

                              
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>


<!-- Vendor JS Files -->
<script src="assets/custom-file/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/intlTelInput.min.js"></script>
<script src="assets/custom-file/js/bootstrap.bundle.min.js"></script>

<!--Main JS File -->
<script src="assets/custom-file/js/main.js"></script>


<script>
    function showPreview(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (x) {
        $('.preview').attr('src', x.target.result).show();
        $('.removeIcon').show();
        $('.uploadLabel').hide(); 
        };
        reader.readAsDataURL(file);
    }
    }

    function removeImg() {
    $('.preview').attr('src', '').hide();
    $('.removeIcon').hide();
    $('.uploadLabel').show(); 
    }
</script>

</html>