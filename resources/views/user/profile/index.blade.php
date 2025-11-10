
@extends('user.layout.app')

@section('content')
    <div class="my-profile customContainer">
        <div class="d-flex align-items-center mt-3 justify-content-between">
            <a href=""><i class="fa-solid fa-chevron-left"></i> My Profile (edit)</a>
            <button class="customBtn2"><i class="fa-solid fa-lock"></i>Change Password</button>
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
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" placeholder="Faizan Ansari" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group mobile position-relative">
                    <label for="">Mobile No.</label>
                    <input type="text" class="form-control" placeholder="Faizan Ansari" />
                    <a href="" class="change">Change</a>
                </div>
            </div>
            <div class="col-lg-12 mt-3">
                <div class="form-group mobile position-relative">
                    <label for="">Email Id</label>
                    <input type="email" class="form-control" placeholder="faizanansari@mail.com" />
                    <a class="change">Change</a>
                </div>
            </div>
            <div class="col-lg-12">
                <button class="customBtn w-100 mt-4">Save</button>
            </div>
        </div>
    </div>


 @endsection