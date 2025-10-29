<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Store Information</title>
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
    <div class="des-language">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="assets/img/global.svg" class="img-fluid" /> EN
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#"><span>AR</span> Arabic</a></li>
                <li><a class="dropdown-item" href="#"><span>EN</span> English</a></li>
            </ul>
        </div>
    </div>
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
                                    <h1><a href="signup_otp.php"><i class="bi bi-chevron-left"></i></a> Store information</h1>
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
                                            <div class="progress-bar" style="width: 0%"></div>
                                        </div>
                                    </div>

                                    <div class="upload-image w-100">
                                        <label id="uploadLabel" style="cursor:pointer;text-align:center;">
                                            <img src="assets/img/upload-icon.svg"><div>Upload Profile Photo</div>
                                            <input type="file" accept="image/*" hidden onchange="showPreview(event)">
                                        </label>
                                        <div class="imgshow">
                                            <img id="preview" style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                                            <span id="remove" style="display:none;cursor:pointer;font-size:24px;color:red;" onclick="removeImg()">&times;</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Store Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Store name">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Choose Country</label>
                                        <input type="text" class="form-control" placeholder="Enter Last Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Store Address</label>
                                        <input type="text" class="form-control" placeholder="Enter Store Address">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Address line 1</label>
                                        <input type="text" class="form-control" placeholder="Enter Address line 1">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Address line 2</label>
                                        <input type="text" class="form-control" placeholder="Enter Address line 2">
                                    </div>
                                    <div class="form-group phone-pnl">
                                        <label for="name">Store Phone Number</label>
                                        <input class="form-control" type="tel" id="phone" placeholder="Enter Store Phone Number">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Store mail Id</label>
                                        <input type="text" class="form-control" placeholder="Enter Store mail Id">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Bio</label>
                                        <textarea class="form-control" rows="3" placeholder="Write a massage...."></textarea>
                                    </div>

                                   
                                   
                                    <div class="login-btn mt-5">
                                        <a href="bank-details.php" class="btn btn-success w-100">Continue</a>
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
    const f = e.target.files[0],
          p = preview,
          r = remove,
          u = uploadLabel;

    if (f) {
      const rdr = new FileReader();
      rdr.onload = x => {
        p.src = x.target.result;
        p.style.display = 'block';
        r.style.display = 'inline';
        u.style.display = 'none';
      };
      rdr.readAsDataURL(f);
    }
  }

  function removeImg() {
    preview.src = '';
    preview.style.display = 'none';
    remove.style.display = 'none';
    uploadLabel.style.display = 'block';
  }
</script>

</html>