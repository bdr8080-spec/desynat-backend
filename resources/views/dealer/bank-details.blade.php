<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Bank Details</title>
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

    <style>
        .imgshowtwo{
            width: 100%;
            height: 100%;
        }



    </style>
</head>

<body>

<div class="login-header">
    <div class="des-logo">
        <a href="#"><img src="{{asset('/dealer')}}/assets/img/desynat-logo.svg" alt="image" class="img-fluid logo-login">  </a> 
    </div>
    <div class="des-language"></div>
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
                                    <h1><a href="{{ url()->previous()}}"><i class="bi bi-chevron-left"></i></a> Upload documents & Bank details</h1>
                                </div>

                                <form action="{{route('seller.upload_document',Request()->id)}}" method="post" enctype="multipart/form-data">

                                @csrf
                                
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
                                                            <img src="{{asset('/dealer')}}/assets/img/upload-icon.svg"><div class="text-color-upload">Document 1</div>
                                                            <input type="file" name="owner_document[]" accept="image/*" hidden onchange="showPreview(event,1)">
                                                        </label>
                                                        <div class="imgshow">
                                                            <img class="preview1" style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                                                            <span class="removeIcon1" style="display:none;cursor:pointer;font-size:24px;color:red;" onclick="removeImg(1)">&times;</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="upload-image w-100">
                                                        <label class="uploadLabel" style="cursor:pointer;text-align:center;">
                                                            <img src="{{asset('/dealer')}}/assets/img/upload-icon.svg"><div class="text-color-upload">Document 1</div>
                                                            <input type="file" name="owner_document[]" accept="image/*" hidden onchange="showPreview(event,2)">
                                                        </label>
                                                        <div class="imgshow">
                                                            <img class="preview2" style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                                                            <span class="removeIcon2" style="display:none;cursor:pointer;font-size:24px;color:red;" onclick="removeImg(2)">&times;</span>
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
                                                            <img src="{{asset('/dealer')}}/assets/img/upload-icon.svg"><div class="text-color-upload">Document 1</div>
                                                            <input type="file" name="store_document[]" accept="image/*" hidden onchange="showPreview(event,3)">
                                                        </label>
                                                        <div class="imgshow">
                                                            <img class="preview3" style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                                                            <span class="removeIcon3" style="display:none;cursor:pointer;font-size:24px;color:red;" onclick="removeImg(3)">&times;</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="upload-image w-100">
                                                        <label class="uploadLabel" style="cursor:pointer;text-align:center;">
                                                            <img src="{{asset('/dealer')}}/assets/img/upload-icon.svg"><div class="text-color-upload">Document 1</div>
                                                            <input type="file" name="store_document[]" accept="image/*" hidden onchange="showPreview(event,4)">
                                                        </label>
                                                        <div class="imgshow">
                                                            <img class="preview4" style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                                                            <span class="removeIcon4" style="display:none;cursor:pointer;font-size:24px;color:red;" onclick="removeImg(4)">&times;</span>
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
                                                    <input class="form-check-input" type="radio" name="account_type" value="0" @if(@$seller_bank->account_type=='0')  checked @endif >
                                                    <label class="form-check-label mt-0" for="personal"> Personal </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="account_type" value="1" @if(@$seller_bank->account_type=='1')  checked @endif>
                                                    <label class="form-check-label mt-0" for="personal"> Business </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @error('account_type')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    
                                    <div class="form-group">
                                        <label for="name">IBAN</label>
                                        <input type="text" class="form-control" placeholder="KW" name="iban" value="{{ old('iban',@$seller_bank->iban)}}">
                                    </div>
                                    @error('iban')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    <div class="form-group">
                                        <label for="name">SWIFT/BIC</label>
                                        <input type="text" class="form-control" placeholder="Enter Swift" name="swift"  value="{{ old('bank_name',@$seller_bank->swift)}}">
                                    </div>
                                    @error('swift')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    <div class="form-group">
                                        <label for="name">Bank Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Bank Name"  name="bank_name"  value="{{ old('bank_name',@$seller_bank->bank_name)}}">
                                    </div>
                                    @error('bank_name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    <div class="form-group">
                                        <label for="name">Account holder name</label>
                                        <input type="text" class="form-control" placeholder="Enter Account holder name"  name="account_holder_name"  value="{{ old('account_holder_name',@$seller_bank->account_holder_name)}}">
                                    </div>
                                    @error('account_holder_name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    
                                    <!-- <div class="owner-pnl">
                                        <div class="form-group">
                                            <label for="name">Upload proof of account</label>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="upload-image w-100">
                                                        <label class="uploadLabel5" style="cursor:pointer;text-align:center;">
                                                            <img src="{{asset('/dealer')}}/assets/img/upload-icon.svg"><div class="text-color-upload">Bank Statement or Bank Letter,PDF/JPG/PNG</div>
                                                            <input type="file" accept="image/*" hidden onchange="showPreview(event,5)" name="upload_proof">
                                                        </label>
                                                        <div class="imgshow">
                                                            <img class="preview5" style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                                                            <span class="removeIcon5" style="display:none;cursor:pointer;font-size:24px;color:red;" onclick="removeImg()">&times;</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    
                                    </div> -->
                                   
                                    <div class="owner-pnl">
    <div class="form-group">
        <label for="name">Upload proof of account</label>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="upload-image w-100">
                    <label class="uploadLabel5" style="cursor:pointer;text-align:center;">
                        <img src="{{ asset('/dealer/assets/img/upload-icon.svg') }}">
                        <div class="text-color-upload">Bank Statement or Bank Letter, PDF/JPG/PNG</div>
                        <input type="file" accept="image/*" hidden onchange="showPreview(event,5)" name="upload_proof">
                    </label>

                    <div class="imgshow " >
                        {{-- ✅ Show preview if image already exists --}}
                        @if(!empty($seller_bank->upload_proof))
                            <img class="preview5"
                                 src="{{ $seller_bank->upload_proof }}"
                                 style="display:block;max-width:100%;margin-top:10px;border-radius:8px;">
                            <span class="removeIcon5"
                                  style="display:block;cursor:pointer;font-size:24px;color:red;"
                                  onclick="removeImg(5)">&times;</span>
                        @else

                            <img class="preview5"
                                 style="display:none;max-width:100%;margin-top:10px;border-radius:8px;width=100%">
                            <span class="removeIcon5"
                                  style="display:none;cursor:pointer;font-size:24px;color:red;"
                                  onclick="removeImg(5)">&times;</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>


                                    <div class="login-btn mt-5">

                                    <input type="submit" class="btn btn-success w-100" value="Continue">

                                        <!-- <a href="summary_page.php" class="btn btn-success w-100">Continue</a> -->
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


<script>
    function showPreview(e,id) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (x) {
        $('.preview'+id).attr('src', x.target.result).show();
        $('.removeIcon'+id).show();
        $('.uploadLabel'+id).hide(); 
        };
        reader.readAsDataURL(file);
    }
    }

    function removeImg(id) {
    $('.preview'+id).attr('src', '').hide();
    $('.removeIcon'+id).hide();
    $('.uploadLabel'+id).show(); 



}

</script>


</script>

</html>