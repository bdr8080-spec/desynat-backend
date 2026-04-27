@extends('admin.layout.app')
@section('content')

<form id="subAdminForm" enctype="multipart/form-data">
  @csrf
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
                            class="profile-img" 
                            style="width:150px; height:150px; object-fit:cover;"/>

                        <!-- Hidden File Input -->
                        <input type="file" 
                            id="profileInput"
                            name="profile_pic" 
                            accept="image/*" 
                            style="display:none;">
                    </div>
                    <small class="text-danger error" id="error_profile_pic"></small>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">

                <div class="form-group">
                    <label class="form-label">Full name(English)</label>
                    <input type="text" name="full_name" class="form-control" placeholder="Enter full name in English" oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')">
                    <small class="text-danger error" id="error_full_name"></small>
                </div>

                <div class="form-group">
                    <label class="form-label">Phone number</label>

                    <div class="dropdown">
                        <button class="btn btn-light border dropdown-toggle d-flex align-items-center justify-content-between w-100 form-control"
                            type="button" data-bs-toggle="dropdown">

                            <span id="selected-flag">
                                <img src="{{ old('country_flag', $country[0]->flag1) }}"
                                    width="25" height="16">
                            </span>

                            <span id="selected-code" class="ms-2">
                                {{ old('country_code', $country[0]->dial_code) }}
                            </span>
                        </button>

                        <ul class="dropdown-menu p-2">

                            @foreach ($country as $item)
                            <li>
                                <label class="dropdown-item d-flex align-items-center gap-2 country-option">

                                    <input type="radio" name="country_code"
                                        value="{{ $item->dial_code }}"
                                        data-flag="{{ $item->flag1 }}"
                                        data-name="{{ $item->name }}"
                                        class="country-radio"
                                        {{ old('country_code', $country[0]->dial_code) == $item->dial_code ? 'checked' : '' }}
                                        hidden>

                                    <span>{{ $item->flag }} {{ $item->dial_code }} ({{ $item->name }})</span>

                                </label>
                            </li>
                            @endforeach

                        </ul>
                    </div>

                    <small class="text-danger error" id="error_country_code"></small>

                    <input type="text" name="mobile" class="form-control" placeholder="Enter phone number" oninput="this.value = this.value.replace(/\D/g, '').slice(0, 15);">
                    <small class="text-danger error" id="error_mobile"></small>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="text" name="password" class="form-control" placeholder="Enter password">
                    <small class="text-danger error" id="error_password"></small>
                </div>

                <div class="form-group w-100">
                    <label class="form-label">Country</label>

                    <select name="country_id" class="form-select form-select-lg">
                        <option value="">Select country</option>
                        @foreach($country as $data)
                            <option value="{{ $data->id }}">
                                {{ $data->name }}
                            </option>
                        @endforeach
                    </select>

                    <small class="text-danger error" id="error_country_id"></small>
                </div>

            </div>

            <div class="col-lg-6">

                <div class="form-group">
                    <label class="form-label">Full name(Arabic)</label>
                    <input type="text" name="full_name_ar" class="form-control" dir="rtl" style="text-align: right;" placeholder="Enter full name in Arabic" oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')">
                    <small class="text-danger error" id="error_full_name_ar"></small>
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="text" name="email" class="form-control" placeholder="Enter email address">
                    <small class="text-danger error" id="error_email"></small>
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm password</label>
                    <input type="text" name="confirm_password" class="form-control" placeholder="Confirm password">
                    <small class="text-danger error" id="error_confirm_password"></small>
                </div>

            </div>
        </div>

        <h2 class="h2 text-start">Access Modules</h2>

        <div class="row">
            <div class="col-lg-12">
                <div class="modal-body">

                    @foreach($modules as $index => $module)

                    <div class="module-block">
                        
                        <h5>{{ $module->display_name }}</h5>

                        <input type="hidden" name="modules[{{ $index }}][module_id]" value="{{ $module->id }}">

                        <div class="d-flex gap-5 mt-3">

                            <label class="custom-checkbox">
                                <input type="checkbox" class="view-checkbox" data-index="{{ $index }}">
                                View
                            </label>

                            <label class="custom-checkbox">
                                <input type="checkbox" class="edit-checkbox" data-index="{{ $index }}">
                                Edit
                            </label>

                            <!-- <label class="custom-checkbox">
                                <input type="checkbox" class="both-checkbox" data-index="{{ $index }}">
                                Both
                            </label> -->

                            <!-- hidden values for backend -->
                            <input type="hidden" name="modules[{{ $index }}][can_view]" value="0" class="can-view-{{ $index }}">
                            <input type="hidden" name="modules[{{ $index }}][can_action]" value="0" class="can-action-{{ $index }}">

                        </div>
                    </div>

                    @endforeach

                    <small class="text-danger error" id="error_modules"></small>

                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="text-center">
            <button type="button" class="btn btn-dark customBtn px-4">Add</button>
        </div>

    </div>
</form>




<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('subAdminForm');
    const submitBtn = document.querySelector('.customBtn');

    const profileBox = document.querySelector('.profile-box');
    const profileInput = document.getElementById('profileInput');
    const profilePreview = document.getElementById('profilePreview');


    function validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function validatePassword(password) {
        return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/.test(password);
    }

    function setError(field, msg) {
        let el = document.getElementById('error_' + field);
        if (el) el.innerText = msg;
    }

    function clearError(name) {
        let el = document.getElementById('error_' + name);
        if (el) el.innerText = '';
    }

    if (profileBox) {
        profileBox.addEventListener('click', function () {
            profileInput.click();
        });
    }

    if (profileInput) {
        profileInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                profilePreview.src = URL.createObjectURL(this.files[0]);
                clearError('profile_pic');
            }
        });
    }

    document.querySelectorAll('.country-radio').forEach(radio => {

        radio.addEventListener('change', function () {

            let flagEl = document.getElementById('selected-flag');
            let codeEl = document.getElementById('selected-code');

            if (flagEl) {
                flagEl.innerHTML = `<img src="${this.dataset.flag}" width="25" height="16">`;
            }

            if (codeEl) {
                codeEl.innerText = this.value;
            }

            clearError('country_code');
        });
    });

    let selectedCountry = document.querySelector('.country-radio:checked');

    if (selectedCountry) {
        let flagEl = document.getElementById('selected-flag');
        let codeEl = document.getElementById('selected-code');

        if (flagEl) {
            flagEl.innerHTML = `<img src="${selectedCountry.dataset.flag}" width="25" height="16">`;
        }

        if (codeEl) {
            codeEl.innerText = selectedCountry.value;
        }
    }

    document.querySelectorAll('input, select').forEach(el => {
        el.addEventListener('input', () => clearError(el.name));
        el.addEventListener('change', () => clearError(el.name));
    });


    function updateHidden(index) {

        let view = document.querySelector(`.view-checkbox[data-index="${index}"]`);
        let edit = document.querySelector(`.edit-checkbox[data-index="${index}"]`);

        let canView = document.querySelector(`.can-view-${index}`);
        let canAction = document.querySelector(`.can-action-${index}`);

        if (canView) canView.value = view && view.checked ? 1 : 0;
        if (canAction) canAction.value = edit && edit.checked ? 1 : 0;
    }

    // document.querySelectorAll('.both-checkbox').forEach(cb => {

    //     cb.addEventListener('change', function () {

    //         let i = this.dataset.index;

    //         let view = document.querySelector(`.view-checkbox[data-index="${i}"]`);
    //         let edit = document.querySelector(`.edit-checkbox[data-index="${i}"]`);

    //         if (this.checked) {
    //             view.checked = true;
    //             edit.checked = true;
    //         } else {
    //             view.checked = false;
    //             edit.checked = false;
    //         }

    //         updateHidden(i);
    //         clearError('modules');
    //     });

    // });

    // document.querySelectorAll('.view-checkbox, .edit-checkbox').forEach(cb => {

    //     cb.addEventListener('change', function () {

    //         let i = this.dataset.index;

    //         let view = document.querySelector(`.view-checkbox[data-index="${i}"]`);
    //         let edit = document.querySelector(`.edit-checkbox[data-index="${i}"]`);
    //         let both = document.querySelector(`.both-checkbox[data-index="${i}"]`);

    //         if (view.checked && edit.checked) {
    //             both.checked = true;
    //         } else {
    //             both.checked = false;
    //         }

    //         updateHidden(i);
    //         clearError('modules');
    //     });

    // });

    document.querySelectorAll('.view-checkbox, .edit-checkbox').forEach(cb => {

        cb.addEventListener('change', function () {

            let i = this.dataset.index;

            let view = document.querySelector(`.view-checkbox[data-index="${i}"]`);
            let edit = document.querySelector(`.edit-checkbox[data-index="${i}"]`);

            //  If Edit is checked → force View checked
            if (this.classList.contains('edit-checkbox') && edit.checked) {
                view.checked = true;
            }

            //  Optional: if View is unchecked → also uncheck Edit
            if (this.classList.contains('view-checkbox') && !view.checked) {
                edit.checked = false;
            }

            updateHidden(i);
            clearError('modules');
        });

    });

    function validateForm() {

        let valid = true;

        let full_name = form.full_name.value.trim();
        let full_name_ar = form.full_name_ar.value.trim();
        let email = form.email.value.trim();
        let password = form.password.value.trim();
        let confirm_password = form.confirm_password.value.trim();
        let country_id = form.country_id.value;
        let mobile = form.mobile.value;
        let profile = profileInput?.files[0];

        // if (!profile) {
        //     setError('profile_pic', 'Please select an image');
        //     valid = false;
        // }

        if (!full_name) {
            setError('full_name', 'Please enter full name in English');
            valid = false;
        }

        if (!full_name_ar) {
            setError('full_name_ar', 'Please enter full name in Arabic');
            valid = false;
        }

        if (!email) {
            setError('email', 'Please enter email');
            valid = false;
        } else if (!validateEmail(email)) {
            setError('email', 'Please enter valid email');
            valid = false;
        }

        if (!password) {
            setError('password', 'Please enter password');
            valid = false;
        } else if (!validatePassword(password)) {
            setError('password', 'Password must be 8+ chars with uppercase, number & special character');
            valid = false;
        }

        if (!confirm_password) {
            setError('confirm_password', 'Please confirm password');
            valid = false;
        } else if (password !== confirm_password) {
            setError('confirm_password', 'Confirm password does not match');
            valid = false;
        }

        let hasModule = false;

        document.querySelectorAll('.view-checkbox, .edit-checkbox').forEach(cb => {
            if (cb.checked) hasModule = true;
        });

        if (!hasModule) {
            setError('modules', 'Please select at least one module');
            valid = false;
        }

        return valid;
    }

    submitBtn?.addEventListener('click', function () {

        document.querySelectorAll('.error').forEach(e => e.innerText = '');

        if (!validateForm()) return;

        submitBtn.disabled = true;
        submitBtn.innerText = 'Please wait...';

        let formData = new FormData();

        formData.append('full_name', form.full_name.value);
        formData.append('full_name_ar', form.full_name_ar.value);
        formData.append('email', form.email.value);
        formData.append('password', form.password.value);
        formData.append('confirm_password', form.confirm_password.value);
        formData.append('country_id', form.country_id.value);
        formData.append('mobile', form.mobile.value);
        formData.append('country_code', document.querySelector('input[name="country_code"]:checked')?.value);

        if (profileInput.files[0]) {
            formData.append('image', profileInput.files[0]);
        }

        document.querySelectorAll('.module-block').forEach((block, index) => {

            let moduleId = block.querySelector('input[name^="modules"]').value;
            let view = block.querySelector('.view-checkbox')?.checked ? 1 : 0;
            let edit = block.querySelector('.edit-checkbox')?.checked ? 1 : 0;

            formData.append(`modules[${index}][module_id]`, moduleId);
            formData.append(`modules[${index}][can_view]`, view);
            formData.append(`modules[${index}][can_action]`, edit);
        });

        fetch("{{ route('admin.addSubadmin') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {

            submitBtn.disabled = false;
            submitBtn.innerText = 'Add';

            if (data.status === 'success') {
                toastr.success(data.message);
                setTimeout(() => {
                    window.location.href = "{{ route('admin.subAdminManagement') }}";
                }, 1500);
            } else if (data.errors) {
                Object.keys(data.errors).forEach(key => {
                    let main = key.split('.')[0];
                    setError(main, data.errors[key][0]);
                });
            } else {
                toastr.error(data.message || 'Something went wrong');
            }

        })
        .catch(err => {

            submitBtn.disabled = false;
            submitBtn.innerText = 'Add';

            console.log(err);
            toastr.error('Request failed');

        });

    });

});
</script>



@endsection