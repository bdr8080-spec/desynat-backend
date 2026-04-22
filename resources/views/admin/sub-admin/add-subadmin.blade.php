@extends('admin.layout.app')
@section('content')

<div class="inner-content management">
    <div class="d-flex align-items-center gap-3 mt-2">
        <div class="arrow">
            <a href="#" class="table-button " type="button">
                <i class="fas fa-angle-left"></i>
            </a>
        </div>
        <h2 class="h2 text-start">Add Sub Admin</h2>

    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center mb-4">
                <div class="profile-box">
                    <img src="image/profile.jpg" class="profile-img" />
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="firstName" class="form-label">First name</label>
                <input type="text" class="form-control" placeholder="Enter first name">
            </div>


            <div class="form-group">
                <label for="Phone number" class="form-label">Phone number</label>
                <input type="text" class="form-control" placeholder="Enter phone number">
            </div>
            <div class="form-group">
                <label for="ID" class="form-label">ID</label>
                <input type="text" class="form-control" placeholder="Enter ID">
            </div>
            <div class="form-group">
                <label for="Password" class="form-label">Password</label>
                <input type="text" class="form-control" placeholder="Enter Password">
            </div>

            <div class="form-group  w-100">
                <label for="to" class="form-label">Country</label>

                <select name="country_id2" class="form-select form-select-lg">
                    <option value="">Select country</option>

                    <option value="">egjo</option>
                </select>
            </div>

        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="lastName" class="form-label">Last name</label>
                <input type="text" class="form-control" placeholder="Enter last name">
            </div>

            <div class="form-group">
                <label for="Email" class="form-label">Email</label>
                <input type="text" class="form-control" placeholder="Enter Email">
            </div>
            <div class="form-group">
                <label for="Confirm password" class="form-label">Confirm password</label>
                <input type="text" class="form-control" placeholder="Enter Confirm password">
            </div>


        </div>
    </div>

    <h2 class="h2 text-start">Access Modules </h2>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">

            <div class="modal-body">

                <!-- Module Row -->
                <div class="module-block">
                    <h5>Module 1</h5>
                    <div class="d-flex gap-5 mt-3">
                        <label class="custom-checkbox">
                            <input type="checkbox"> View
                        </label>

                        <label class="custom-checkbox">
                            <input type="checkbox"> Edit
                        </label>

                        <label class="custom-checkbox">
                            <input type="checkbox"> Both
                        </label>
                    </div>
                </div>

                <!-- Repeat -->
                <div class="module-block">
                    <h5>Module 1</h5>
                    <div class="d-flex gap-5 mt-3">
                        <label class="custom-checkbox">
                            <input type="checkbox"> View
                        </label>

                        <label class="custom-checkbox">
                            <input type="checkbox"> Edit
                        </label>

                        <label class="custom-checkbox">
                            <input type="checkbox"> Both
                        </label>
                    </div>
                </div>

                <div class="module-block">
                    <h5>Module 1</h5>
                    <div class="d-flex gap-5 mt-3">
                        <label class="custom-checkbox">
                            <input type="checkbox"> View
                        </label>

                        <label class="custom-checkbox">
                            <input type="checkbox"> Edit
                        </label>

                        <label class="custom-checkbox">
                            <input type="checkbox"> Both
                        </label>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <!-- Submit -->
    <div class="text-center">
        <button type="button" class="btn btn-dark customBtn px-4">Send</button>
    </div>



</div>



@endsection