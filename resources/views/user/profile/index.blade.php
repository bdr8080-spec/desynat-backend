
@extends('user.layout.app')

@section('content')
    <div class="my-profile customContainer">
        <div class="d-lg-flex d-md-flex d-block align-items-center mt-3 justify-content-between">
            <a href="{{route('dashboard')}}" class="my-profie-nav"><i class="fa-solid fa-chevron-left"></i> My Profile (edit)</a>
            <div>
                <a href="{{route('userChangePassword')}}" class="customBtn2"><i class="fa-solid fa-lock pe-3"></i>Change Password</a>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="profile d-flex align-items-center gap-3">
                    <div class="profileContainer_img">
                        <img id="profileImg" src="assets/images/user.png" class="img-fluid" alt="Profile Image" />
                    </div>
                    <label for="fileInput" class="changeImageText">Change Image</label>
                    <input type="file" id="fileInput" accept="image/*" hidden />
                </div>
            </div>
            <div class="col-lg-6 mt-3">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" placeholder="Please enter full name" value="{{$user->full_name}}" />
                </div>
            </div>
            <div class="col-lg-6 mt-3">
                <div class="form-group mobile position-relative">
                    <label for="">Mobile No.</label>
                    <input type="text" name="country_code" class="tag" value="{{$user->country_code}}" readonly>
                    <input type="text" class="form-control number" placeholder="Please enter mobile number" value="{{$user->mobile}}" readonly/>            
                    <a class="change"
                    href="{{ route('userOldNumberSendOtp', [
                        'mobile' => $user->mobile,
                        'country_code' => $user->country_code,
                        'for' => 'mobile',
                        'type' => '0'
                    ]) }}">
                    Change
                    </a>
                </div>
            </div>
            <div class="col-lg-12 mt-3">
                <div class="form-group mobile position-relative">
                    <label for="">Email Id</label>
                    <input type="email" class="form-control" placeholder="Please enter email address" value="{{$user->email}}"  readonly/>
                    <a class="change"
                           href="{{ route('userOldNumberSendOtp', [
                        'email' => $user->email,
                        'for' => 'email',
                        'type' => '0'
                    ]) }}">
                    Change
                    </a>
                </div>
            </div>
            <div class="col-lg-12">
                <button class="customBtn w-100 mt-4">Save</button>
            </div>
        </div>
    </div>


    
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

 @endsection