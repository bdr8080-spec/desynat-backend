@extends('admin.layout.app')
@section('content')
<style>
/* Wrapper fix */
.form-group .input-group {
    position: relative !important;
    display: flex !important;
    align-items: center !important;
}

/* Country dropdown button */
#countryDropdown {
    height: 48px !important;
    border-radius: 10px 0 0 10px !important;
    border: 1px solid #ced4da !important;
    background: #fff !important;
    font-size: 14px !important;
    padding: 6px 10px !important;
    display: flex !important;
    align-items: center !important;
    gap: 6px !important;
}

/* Fix dropdown width properly */
.form-group .dropdown {
    /* position: relative !important; */
    width: 110px !important;
    z-index: 2 !important;
}

/* Remove weird absolute overlap */
.form-group .dropdown button {
    width: 100% !important;
}

/* Phone input field */
.form-group input.form-control {
    height: 48px !important;
    border-radius: 0 10px 10px 0 !important;
    border: 1px solid #ced4da !important;
    padding-left: 12px !important;
    font-size: 14px !important;
}

/* Align input beside dropdown */
.form-group .input-group input.form-control {
    margin-top: 0 !important;
    margin-left: 110px !important;
}

/* Dropdown menu styling */
.dropdown-menu {
    border-radius: 10px !important;
    border: 1px solid #eee !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
}

/* Country option hover */
.country-option:hover {
    background: #f5f5f5 !important;
    border-radius: 6px !important;
}

/* Selected state feel */
.country-radio:checked+span {
    font-weight: 600 !important;
}

/* Flag alignment */
#selected-flag img {
    border-radius: 2px !important;
}

/* Label spacing */
.form-label {
    margin-bottom: 6px !important;
    font-weight: 500 !important;
}

/* Error text spacing */
.text-danger {
    font-size: 12px !important;
}

.input-group .btn {
    position: relative;
    z-index: 2;
    background: #fff !important;
    height: 48px;
}

/* Scroll area */
.modal-body {
    max-height: 70vh !important;
    overflow-y: auto !important;
}

/* Module row = grid */
.module-block {
    display: grid !important;
    grid-template-columns: 1fr 300px !important;
    align-items: center !important;
    padding: 14px 16px !important;
    border-bottom: 1px solid #e5e7eb !important;
}

/* Remove extra spacing */
.module-block h5 {
    margin: 0 !important;
    font-size: 15px !important;
    font-weight: 600 !important;
}

/* Checkbox container right side */
.module-block .d-flex {
    display: flex !important;
    justify-content: space-between !important;
    gap: 20px !important;
}

/* Checkbox label */
.custom-checkbox {
    display: flex !important;
    align-items: center !important;
    gap: 6px !important;
    font-size: 14px !important;
    cursor: pointer !important;
}

/* Checkbox size */
.custom-checkbox input[type="checkbox"] {
    width: 16px !important;
    height: 16px !important;
}

/* Make all rows same alignment */
.module-block:nth-child(even) {
    background: #fafafa !important;
}

/* Optional header styling */
.h2 {
    font-weight: 600 !important;
    margin-bottom: 10px !important;
}

/* Fix spacing inside flex */
.module-block .d-flex.mt-3 {
    margin-top: 0 !important;
}
</style>


<form id="subAdminFormUpdate" enctype="multipart/form-data">
    @csrf

    <div class="inner-content management">

        <div class="d-flex align-items-center gap-3 mt-2">
            <div class="arrow">
                <a href="{{route('admin.subAdminManagement')}}" class="table-button" type="button">
                    <i class="fas fa-angle-left"></i>
                </a>
            </div>
            <h2 class="h2 text-start">{{ __('admin_messages.edit_sub_admin') }}</h2>
        </div>

        <div class="row">
            <input type="hidden" name="id" value="{{ $data->id }}">
            <div class="col-lg-12">
                <div class="text-center mb-4">

                    <div class="profile-box" style="cursor:pointer;">

                        <!-- Preview Image -->
                        <img id="profilePreview"
                            src="{{ !empty($data->profile_pic) ? asset($data->profile_pic) : asset('admin/image/profile.jpg') }}"
                            class="profile-img" style="width:150px; height:150px; object-fit:cover;" />

                        <!-- Hidden File Input -->
                        <input type="file" id="profileInput" name="profile_pic" accept="image/*" style="display:none;">

                    </div>

                    <small class="text-danger error" id="error_profile_pic"></small>

                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-6">

                <div class="form-group">
                    <label class="form-label">{{ __('admin_messages.full_name_english') }}</label>
                    <input type="text" name="full_name" class="form-control" value="{{ $data->full_name ?? '' }}"
                        placeholder="{{ __('admin_messages.enter_full_name_in_english') }}"
                        oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')">
                    <small class="text-danger error" id="error_full_name"></small>
                </div>

                <div class="form-group">
                    <label class="form-label">{{ __('admin_messages.phone_number') }}</label>
                    <div class="input-group">
                        <div class="dropdown" style="width: 20%; position: absolute;">

                            <button
                                class="btn btn-light border dropdown-toggle d-flex align-items-center justify-content-between w-100 form-control"
                                type="button" data-bs-toggle="dropdown"
                                style="border-top-right-radius: 0; border-bottom-right-radius: 0;">

                                <span id="selected-flag">{{ $data->country_flag ?? $country[0]->flag }}
                                    <!-- <img src="{{ $data->country_flag ?? $country[0]->flag1 }}" width="25" height="16"> -->
                                </span>

                                <span id="selected-code" class="ms-2">
                                    {{ $data->country_code ?? $country[0]->dial_code }}
                                </span>

                            </button>

                            <ul class="dropdown-menu p-2" style="max-height: 300px; overflow-y: auto;">

                                @foreach ($country as $item)
                                <li>
                                    <label class="dropdown-item d-flex align-items-center gap-2 country-option"
                                        style="cursor: pointer;">

                                        <input type="radio" name="country_code" value="{{ $item->dial_code }}"
                                            data-flag="{{ $item->flag }}" data-name="{{ $item->name }}"
                                            class="country-radio"
                                            {{ ($data->country_code ?? $country[0]->dial_code) == $item->dial_code ? 'checked' : '' }}
                                            hidden>

                                        <span>{{ $item->flag }} {{ $item->dial_code }} ({{ $item->name }})</span>

                                    </label>
                                </li>
                                @endforeach

                            </ul>

                        </div>


                        <input type="text" name="mobile" class="form-control" value="{{ $data->mobile ?? '' }}"
                            placeholder="{{ __('admin_messages.enter_mobile_number') }}"
                            oninput="this.value = this.value.replace(/\D/g, '').slice(0, 15);">
                    </div>
                    <div class="d-flex gap-2">
                        <small class="text-danger error" id="error_country_code"></small>
                        <small class="text-danger error" id="error_mobile"></small>
                    </div>


                </div>

                <div class="form-group">
                    <label class="form-label">{{ __('admin_messages.password') }}</label>
                    <input type="text" name="password" class="form-control" placeholder="{{ __('admin_messages.enter_password') }}"
                        value="{{ $data->unhashed_password ?? '' }}">
                    <small class="text-danger error" id="error_password"></small>
                </div>

                <div class="form-group w-100">
                    <label class="form-label">{{ __('admin_messages.select_country') }}</label>

                    <select name="country_id" class="form-select form-select-lg">

                        <option value="">{{ __('admin_messages.select_country') }}</option>

                        @foreach($country as $item)
                        <option value="{{ $item->id }}" {{ ($data->country_id ?? '') == $item->id ? 'selected' : '' }}>
                            @if(app()->getLocale() == 'en')
                                  {{ $item->name }}
                                  @else
                                  {{ $item->name_ar }}
                                  @endif
                        </option>
                        @endforeach

                    </select>

                    <small class="text-danger error" id="error_country_id"></small>

                </div>

            </div>

            <div class="col-lg-6">

                <div class="form-group">
                    <label class="form-label">{{ __('admin_messages.full_name_arabic') }}</label>
                    <input type="text" name="full_name_ar" class="form-control" value="{{ $data->full_name_ar ?? '' }}"
                        dir="rtl" style="text-align: right;" placeholder="{{ __('admin_messages.enter_full_name_in_arabic') }}"
                        oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')">
                    <small class="text-danger error" id="error_full_name_ar"></small>
                </div>

                <div class="form-group">
                    <label class="form-label">{{ __('admin_messages.email') }}</label>
                    <input type="text" name="email" class="form-control" value="{{ $data->email ?? '' }}"
                        placeholder="{{ __('admin_messages.enter_email_id') }}">
                    <small class="text-danger error" id="error_email"></small>
                </div>

                <div class="form-group">
                    <label class="form-label">{{ __('admin_messages.confirm_password') }}</label>
                    <input type="text" name="confirm_password" class="form-control" placeholder="{{ __('admin_messages.enter_confirm_password') }}"
                        value="{{ $data->unhashed_password ?? '' }}">
                    <small class="text-danger error" id="error_confirm_password"></small>
                </div>

            </div>

        </div>

        <h2 class="h2 text-start">{{ __('admin_messages.access_modules') }}</h2>

        @php
        $permissionMap = [];

        foreach ($data->permission_details as $p) {
        $permissionMap[$p->module_id] = $p;
        }
        @endphp

        <div class="row">

            <div class="col-lg-12">

                <div class="modal-body">

                    @foreach($modules as $index => $module)

                    <div class="module-block">

                        <h5>
                            @if(app()->getLocale() == 'en')
                            {{ $module->display_name }}
                            @else
                            {{ $module->display_name_ar }}
                            @endif
                        </h5>

                        <input type="hidden" name="modules[{{ $index }}][module_id]" value="{{ $module->id }}">

                        <div class="d-flex gap-5 mt-3">

                            <label class="custom-checkbox">

                                <input type="checkbox" class="view-checkbox" data-index="{{ $index }}"
                                    {{ isset($permissionMap[$module->id]) && $permissionMap[$module->id]->can_view ? 'checked' : '' }}>

                                {{ __('admin_messages.view') }}

                            </label>

                            <label class="custom-checkbox">

                                <input type="checkbox" class="edit-checkbox" data-index="{{ $index }}"
                                    {{ isset($permissionMap[$module->id]) && $permissionMap[$module->id]->can_action ? 'checked' : '' }}>

                                {{ __('admin_messages.edit') }}

                            </label>

                            <!-- <label class="custom-checkbox">

                            <input type="checkbox"
                                class="both-checkbox"
                                data-index="{{ $index }}"
                                {{ isset($permissionMap[$module->id]) &&
                                   $permissionMap[$module->id]->can_view &&
                                   $permissionMap[$module->id]->can_action ? 'checked' : '' }}>

                            Both

                        </label> -->

                            <input type="hidden" name="modules[{{ $index }}][can_view]"
                                value="{{ isset($permissionMap[$module->id]) ? $permissionMap[$module->id]->can_view : 0 }}"
                                class="can-view-{{ $index }}">

                            <input type="hidden" name="modules[{{ $index }}][can_action]"
                                value="{{ isset($permissionMap[$module->id]) ? $permissionMap[$module->id]->can_action : 0 }}"
                                class="can-action-{{ $index }}">

                        </div>

                    </div>

                    @endforeach

                    <small class="text-danger error" id="error_modules"></small>

                </div>

            </div>

        </div>

        <!-- Submit -->
        <div class="text-center mt-3 mb-4">
            <button type="button" class="btn btn-dark customBtn px-4 w-25 ">{{ __('admin_messages.update') }}</button>
        </div>

    </div>

</form>




<script>
document.addEventListener('DOMContentLoaded', function() {

    const form = document.getElementById('subAdminFormUpdate');
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
        profileBox.addEventListener('click', function() {
            profileInput.click();
        });
    }

    if (profileInput) {
        profileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                profilePreview.src = URL.createObjectURL(this.files[0]);
                clearError('profile_pic');
            }
        });
    }

    document.querySelectorAll('.country-radio').forEach(radio => {

        radio.addEventListener('change', function() {

            let flagEl = document.getElementById('selected-flag');
            let codeEl = document.getElementById('selected-code');

            if (flagEl) {
                // flagEl.innerHTML = `<img src="${this.dataset.flag}" width="25" height="16">`;
                flagEl.textContent = this.dataset.flag || '';
            }

            if (codeEl) {
                codeEl.textContent = this.value;
            }

            clearError('country_code');
        });
    });

    let selectedCountry = document.querySelector('.country-radio:checked');

    if (selectedCountry) {
        let flagEl = document.getElementById('selected-flag');
        let codeEl = document.getElementById('selected-code');

        if (flagEl) {
            // flagEl.innerHTML = `<img src="${selectedCountry.dataset.flag}" width="25" height="16">`;
            flagEl.textContent = selectedCountry.dataset.flag || '';
        }

        if (codeEl) {
            codeEl.textContent = selectedCountry.value;
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

    document.querySelectorAll('.edit-checkbox').forEach(cb => {
        let i = cb.dataset.index;

        let view = document.querySelector(`.view-checkbox[data-index="${i}"]`);

        if (cb.checked && view && !view.checked) {
            view.checked = true;
        }
    });

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

        cb.addEventListener('change', function() {

            let i = this.dataset.index;

            let view = document.querySelector(`.view-checkbox[data-index="${i}"]`);
            let edit = document.querySelector(`.edit-checkbox[data-index="${i}"]`);

            // ✅ If Edit checked → force View checked
            if (this.classList.contains('edit-checkbox') && edit.checked) {
                view.checked = true;
            }

            // ❌ If View unchecked → remove Edit
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
            setError('full_name', "{{ __('admin_messages.please_enter_full_name_in_english') }}");
            valid = false;
        }

        if (!full_name_ar) {
            setError('full_name_ar', "{{ __('admin_messages.please_enter_full_name_in_arabic') }}");
            valid = false;
        }

        if (!email) {
            setError('email', "{{ __('admin_messages.please_enter_email_id') }}");
            valid = false;
        } else if (!validateEmail(email)) {
            setError('email', "{{ __('admin_messages.please_enter_valid_email') }}");
            valid = false;
        }
           if (!mobile) {
            setError('mobile', "{{ __('admin_messages.please_enter_mobile_number') }}");
            valid = false;
            } else if (!/^\d{7,15}$/.test(mobile)) {
            setError('mobile', "{{ __('admin_messages.mobile_number_must_be_between_7_to_15_digits') }}");
            valid = false;
            }

        if (!password) {
            setError('password', "{{ __('admin_messages.please_enter_password') }}");
            valid = false;
        } else if (!validatePassword(password)) {
            setError('password', "{{ __('admin_messages.password_must_be_8_chars_uppercase_number_special') }}");
            valid = false;
        }

        if (!confirm_password) {
            setError('confirm_password', "{{ __('admin_messages.please_confirm_password') }}");
            valid = false;
        } else if (password !== confirm_password) {
            setError('confirm_password', "{{ __('admin_messages.confirm_password_does_not_match') }}");
            valid = false;
        }
        

        let hasModule = false;

        document.querySelectorAll('.view-checkbox, .edit-checkbox').forEach(cb => {
            if (cb.checked) hasModule = true;
        });

        if (!hasModule) {
            setError('modules', "{{ __('admin_messages.please_select_at_least_one_module') }}");
            valid = false;
        }

        return valid;
    }

    submitBtn?.addEventListener('click', function() {

        document.querySelectorAll('.error').forEach(e => e.innerText = '');

        if (!validateForm()) return;

        submitBtn.disabled = true;
        submitBtn.innerText = 'Please wait...';

        let formData = new FormData();
        formData.append('id', form.id.value);
        formData.append('full_name', form.full_name.value);
        formData.append('full_name_ar', form.full_name_ar.value);
        formData.append('email', form.email.value);
        formData.append('password', form.password.value);
        formData.append('confirm_password', form.confirm_password.value);
        formData.append('country_id', form.country_id.value);
        formData.append('mobile', form.mobile.value);
        formData.append('country_code', document.querySelector('input[name="country_code"]:checked')
            ?.value);

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

        //console.log(formData);

        fetch("{{ route('admin.updateSubadmin') }}", {
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
                submitBtn.innerText = 'Update';

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