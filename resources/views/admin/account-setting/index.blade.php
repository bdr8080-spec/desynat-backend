@extends('admin.layout.app')
@section('content')

<div class="inner-content management">
    <h2 class="h2">Account Settings</h2>
    <div class="d-flex justify-content-center">
        <ul class="nav nav-pills tabs-pnl custom" id="pills-tab" role="tablist">
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link active customBtn2 m-0" id="received-tab" data-bs-toggle="pill"
                    data-bs-target="#received" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
                    Account Settings
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link m-0 customBtn2" id="sent-tab" data-bs-toggle="pill" data-bs-target="#sent"
                    type="button" role="tab" aria-controls="sent" aria-selected="false">
                    Change Password
                </button>
            </li>
        </ul>
    </div>
    <div class="userManagecontent mt-4">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="received" role="tabpanel" aria-labelledby="received-tab"
                tabindex="0">
               
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mb-4">
                            <label for="firstName" class="form-label">Profile Picture-</label>
                            <div class="profile-box">
                                <img src="image/profile.jpg" class="profile-img" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="firstName" class="form-label">Name-</label>
                            <input type="text" class="form-control" placeholder="Enter  name" />
                        </div>
                        <div class="form-group">
                            <label for="Phone number" class="form-label">Phone number</label>
                            <input type="text" class="form-control" placeholder="Enter phone number" />
                        </div>
                        <div class="form-group">
                            <label for="lastName" class="form-label">Mail Id-</label>
                            <input type="text" class="form-control" placeholder="Enter mail id" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="sent" role="tabpanel" aria-labelledby="sent-tab" tabindex="0">
               
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="firstName" class="form-label">Enter your old password*-</label>
                            <input type="text" class="form-control" placeholder="Enter old password" />
                        </div>
                        <div class="form-group">
                            <label for="Phone number" class="form-label">Enter you new password*</label>
                            <input type="text" class="form-control" placeholder="Enter new password" />
                        </div>
                        <div class="form-group">
                            <label for="lastName" class="form-label">Re-enter you new password*</label>
                            <input type="text" class="form-control" placeholder="Re-enter new password" />
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center gap-3 mt-4">
                    <button type="button" class="btn btn-dark customBtn px-4">
                        Save Password
                    </button>
                    <button type="button" class="btn btn-dark customBtn px-4">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection