@extends('user.layout.app')

@section('content')

  <!-- //change password -->
    <div class="my-profile customContainer">
        <div class="d-flex align-items-center mt-3 justify-content-between">
            <a href=""><i class="fa-solid fa-chevron-left"></i>Change Password</a>
        </div>

        <div class="row mt-5">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Old Password</label>
                    <input type="text" class="form-control" placeholder="Enter Password" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Enter New Password</label>
                    <input type="text" class="form-control" placeholder="Enter New Password" />
                </div>
            </div>
            <div class="col-lg-6 mt-3">
                <div class="form-group">
                    <label for="">Confirm Password</label>
                    <input type="text" class="form-control" placeholder="Re-Enter Password" />
                </div>
            </div>
            <div class="col-lg-12">
                <button class="customBtn w-100 mt-4">Save</button>
            </div>
        </div>
    </div>

@endsection
