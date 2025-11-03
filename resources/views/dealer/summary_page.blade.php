<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Summary Information</title>
    <!-- Favicons -->
    <link href="{{asset('/dealer')}}/assets/img/favicon.png" rel="icon">
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/css/intlTelInput.css"/>
    <link href="{{asset('/dealer')}}/assets/custom-file/css/bootstrap.min.css" rel="stylesheet">
    <!-- Main CSS File -->
    <link href="{{asset('/dealer')}}/assets/custom-file/css/style.css" rel="stylesheet">
</head>

<body>

<div class="login-header">
    <div class="des-logo">
        <a href="#"><img src="{{asset('/dealer')}}/assets/img/desynat-logo.svg" alt="image" class="img-fluid logo-login">  </a> 
    </div>
    <div class="des-language">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{asset('/dealer')}}/assets/img/global.svg" class="img-fluid" /> EN
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
                            <img src="{{asset('/dealer')}}/assets/img/Desynat-logo-2.svg" alt="image" class="img-fluid logo-login">                          
                        </div>
                        <img src="{{asset('/dealer')}}/assets/img/Vector-left.svg" alt="image" class="vector-left">
                        <img src="{{asset('/dealer')}}/assets/img/Vector-right.svg" alt="image" class="vector-right">
                    </div>
                    <div class="col-lg-6">
                        <div class="login-content pt-40">
                            <div class="login-grid-2 signup-scroll pagescroll p-3">
                                <div class="cmn-header mb-3">
                                    <h1><a href="bank-details.php"><i class="bi bi-chevron-left"></i></a> Summary information</h1>
                                </div>

                                    <h5 class="summary-title">Personal Information</h5>
                                    <div class="personal-box">
                                        <div class="upload-image w-50">
                                            <label class="uploadLabel-summary">
                                                <img src="{{$review-> profile_pic}}" class="img-fluid" alt="image">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="personal-list">
                                        <div class="lightName">Full Name</div>
                                        <div class="title_black">{{$review-> first_name}} {{$review-> last_name}}</div>
                                    </div>
                                    <div class="personal-list">
                                        <div class="lightName">Phone Number</div>
                                        <div class="title_black">{{$review-> country_code}} - {{$review-> mobile}}</div>
                                    </div>
                                    <div class="personal-list">
                                        <div class="lightName">Mail Id</div>
                                        <div class="title_black">{{$review-> email}}</div>
                                    </div>

                                    <hr class="light-line">

                                    <h5 class="summary-title">Store Information</h5>
                                    <div class="personal-box">
                                        
                                    
                                    </div>
                                    <div class="personal-list">
                                        <div class="lightName">Store Name</div>
                                        <div class="title_black">{{$review-> store_info->store_name}}</div>
                                    </div>
                                    <div class="personal-list">
                                        <div class="lightName">Address</div>
                                        <div class="title_black">{{$review-> store_info->address_line1}}</div>
                                    </div>
                                    <div class="personal-list">
                                        <div class="lightName">Phone Number</div>
                                        <div class="title_black">{{$review-> store_info->store_phone}}</div>
                                    </div>
                                    <div class="personal-list">
                                        <div class="lightName">Mail Id</div>
                                        <div class="title_black">{{$review-> store_info->store_mail_id}}</div>
                                    </div>
                                    <div class="personal-list">
                                        <div class="lightName">Bio</div>
                                        <div class="title_black">{{$review-> store_info->bio}}</div>
                                    </div>
                                    <hr class="light-line">
                                    <h5 class="summary-title">Documents</h5>

                                    <div class="owner-pnl">
                                        <div class="form-group">
                                            <label for="name">Owner's Documents</label>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="upload-image w-100">
                                                        <label class="uploadLabel-summary">
                                                            <img src="{{$review-> owner_document[0]->document_path}}" class="img-fluid" alt="image">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="upload-image w-100">
                                                        <label class="uploadLabel-summary">
                                                             <img src="{{$review-> owner_document[1]->document_path}}" class="img-fluid" alt="image">
                                                        </label>
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
                                                    <label class="uploadLabel-summary">
                                                        <img src="{{$review-> store_document[1]->document_path}}" class="img-fluid" alt="image">
                                                    </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="upload-image w-100">
                                                    <label class="uploadLabel-summary">
                                                        <img src="{{$review-> store_document[1]->document_path}}" class="img-fluid" alt="image">
                                                    </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                    <hr class="light-line">
                                    <h5 class="summary-title">Bank Details</h5>
                                    <div class="personal-list">
                                        <div class="lightName">Account Type</div>
                                        <div class="title_black">
                                            @if($review-> seller_bank_details->account_type=='0')  
                                            Personal
                                            @else
                                            Business
                                            @endif
                                        </div>
                                    </div>
                                    <div class="personal-list">
                                        <div class="lightName">IBAN</div>
                                        <div class="title_black">{{ $review-> seller_bank_details->iban}}</div>
                                    </div>
                                    <div class="personal-list">
                                        <div class="lightName">SWIFT/BIC</div>
                                        <div class="title_black">{{ $review-> seller_bank_details->swift}}</div>
                                    </div>
                                    <div class="personal-list">
                                        <div class="lightName">Bank Name</div>
                                        <div class="title_black">{{ $review-> seller_bank_details->bank_name}}</div>
                                    </div>
                                    <div class="personal-list">
                                        <div class="lightName">Account holder name</div>
                                        <div class="title_black">{{ $review-> seller_bank_details->account_holder_name}}</div>
                                    </div>
                                    <div class="personal-list">
                                        <div class="lightName">Proof of account</div>
                                        <div class="upload-image w-50">
                                            <label class="uploadLabel-summary">
                                                <img src="{{ $review-> seller_bank_details->upload_proof}}" class="img-fluid" alt="image">
                                            </label>
                                        </div>
                                    </div>


                                    <form action="{{ route('seller.review_submit_page',Request()->id)}}">
                                    <div class="login-btn mt-5">
                                        <input type="submit" class="btn btn-success w-100" value="Submit">
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
<script src="{{asset('/dealer')}}/assets/custom-file/js/jquery.min.js"></script>
<script src="{{asset('/dealer')}}/https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/intlTelInput.min.js"></script>
<script src="{{asset('/dealer')}}/assets/custom-file/js/bootstrap.bundle.min.js"></script>

<!--Main JS File -->
<script src="{{asset('/dealer')}}/assets/custom-file/js/main.js"></script>


</html>