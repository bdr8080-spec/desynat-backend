@extends('admin.layout.app')
@section('content')

<div class="inner-content management">
    <div class="d-flex align-items-center gap-3 mt-2">
        <div class="arrow">
            <a href="{{route('admin.subAdminManagement')}}" class="table-button " type="button">
                <i class="fas fa-angle-left"></i>
            </a>
        </div>
        <h2 class="h2 text-start">Add Sub Admin</h2>

    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center mb-4">
                <div class="profile-box" style="cursor:pointer;">
                    
                    <!-- Preview Image -->
                    <img id="profilePreview" 
                        src="image/profile.jpg" 
                        class="profile-img" style="width:150px; height:150px; object-fit:cover;"/>

                    <!-- Hidden File Input -->
                    <input type="file" 
                        id="profileInput" 
                        accept="image/*" 
                        style="display:none;">
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

                @forelse($modules as $module)
                    <div class="module-block">
                        
                        <h5>{{ $module->display_name }}</h5>

                        <div class="d-flex gap-5 mt-3">

                            <label class="custom-checkbox">
                                <input type="checkbox" 
                                    name="permissions[{{ $module->id }}][]" 
                                    value="view">
                                View
                            </label>

                            <label class="custom-checkbox">
                                <input type="checkbox" 
                                    name="permissions[{{ $module->id }}][]" 
                                    value="edit">
                                Edit
                            </label>

                            <label class="custom-checkbox">
                                <input type="checkbox" 
                                    name="permissions[{{ $module->id }}][]" 
                                    value="both">
                                Both
                            </label>

                        </div>
                    </div>

                @empty
                    <p>No modules found</p>
                @endforelse

            </div>
        </div>
    </div>

    <!-- Submit -->
    <div class="text-center">
        <button type="button" class="btn btn-dark customBtn px-4">Add</button>
    </div>



</div>

<script>
    const preview = document.getElementById('profilePreview');
    const input = document.getElementById('profileInput');

    // Click image → open file picker
    preview.addEventListener('click', function () {
        input.click();
    });

    // Select file → show preview
    input.addEventListener('change', function (event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
            };

            reader.readAsDataURL(file);
        }
    });
</script>



@endsection