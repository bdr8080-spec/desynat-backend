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
            <form id="accountForm" enctype="multipart/form-data">

                <div class="tab-pane fade show active" id="received" role="tabpanel" aria-labelledby="received-tab" tabindex="0">
                            
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center mb-4">
                                <label class="form-label">Profile Picture</label>

                                <div class="profile-box" style="cursor:pointer;">
                                    
                                    <!-- Profile Image -->
                                    <img id="profilePreview" 
                                        src="{{ $data->profile_pic ?? asset('image/profile.jpg') }}" 
                                        class="profile-img" 
                                        style="width:150px; height:150px; object-fit:cover;"/>

                                    <!-- File Input -->
                                    <input type="file" 
                                        name="image"
                                        id="profileInput" 
                                        accept="image/*" 
                                        hidden>

                                </div>

                                <!-- ERROR -->
                                <div class="text-danger mt-1" id="error_image"></div>

                            </div>
                        </div>
                    </div>

                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-6">

                            <!-- Full Name -->
                            <div class="form-group">
                                <label class="form-label">Full Name</label>

                                <input type="text" 
                                    name="full_name"
                                    class="form-control" 
                                    placeholder="Enter name" 
                                    value="{{ $data->full_name }}" />

                                <div class="text-danger mt-1" id="error_full_name"></div>
                            </div>

                            <!-- Phone -->
                            <div class="form-group">
                                <label class="form-label">Phone number</label>

                                <div class="dropdown">
                                    <button
                                        class="btn btn-light border dropdown-toggle d-flex align-items-center justify-content-between w-100 form-control"
                                        type="button" id="countryDropdown" data-bs-toggle="dropdown"
                                        aria-expanded="false">

                                        @php
                                            $selectedCountry = $country->firstWhere('dial_code', $data->country_code);
                                        @endphp

                                        <span id="selected-flag">
                                            <img src="{{ $selectedCountry?->flag1 }}" 
                                                width="25" height="16">
                                        </span>

                                        <span id="selected-code" class="ms-2">
                                            {{ $data->country_code }}
                                        </span>

                                    </button>

                                    <ul class="dropdown-menu p-2" aria-labelledby="countryDropdown">

                                        @foreach ($country as $item)
                                            <li>
                                                <label class="dropdown-item d-flex align-items-center gap-2 country-option" style="cursor: pointer;">
                                                    
                                                    <input type="radio" 
                                                        name="country_code"
                                                        value="{{ $item->dial_code }}"
                                                        data-flag="{{ $item->flag1 }}"
                                                        data-name="{{ $item->name }}"
                                                        class="country-radio"
                                                        {{ ($data->country_code == $item->dial_code) ? 'checked' : '' }}
                                                        hidden>

                                                    <span>
                                                        <img src="{{ $item->flag1 }}" width="25" height="16">
                                                        {{ $item->dial_code }} ({{ $item->name }})
                                                    </span>

                                                </label>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>

                                <!-- ERROR -->
                                <div class="text-danger mt-1" id="error_country_code"></div>

                                <input type="text" 
                                    name="mobile"
                                    class="form-control mt-2" 
                                    placeholder="Enter phone number" 
                                    value="{{ $data->mobile }}" oninput="this.value = this.value.replace(/\D/g, '').slice(0, 15);"/>

                                <div class="text-danger mt-1" id="error_mobile"></div>
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label class="form-label">Email</label>

                                <input type="email" 
                                    name="email"
                                    class="form-control" 
                                    placeholder="Enter mail id" 
                                    value="{{ $data->email }}" />

                                <div class="text-danger mt-1" id="error_email"></div>
                            </div>

                        </div>
                    </div>

                    <!-- Button -->
                    <div class="text-center">
                        <button type="submit" id="submitBtn" class="btn btn-dark customBtn px-4">Update</button>
                    </div>

                </div>

                </form>

            <form id="passwordForm">
                <div class="tab-pane fade" id="sent" role="tabpanel" aria-labelledby="sent-tab" tabindex="0">

                    <div class="row d-flex justify-content-center">

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Enter your old password*</label>

                                <input type="password"
                                    name="old_password"
                                    class="form-control"
                                    placeholder="Enter old password" />
                                <small id="error_old_password" class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Enter your new password*</label>

                                <input type="password"
                                    name="new_password"
                                    class="form-control"
                                    placeholder="Enter new password" />
                                <small id="error_new_password" class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Re-enter your new password*</label>

                                <input type="password"
                                    name="confirm_password"
                                    class="form-control"
                                    placeholder="Re-enter new password" />
                                <small id="error_confirm_password" class="text-danger"></small>
                            </div>

                        </div>

                    </div>
                    <div class="d-flex justify-content-center gap-3 mt-4">

                        <button type="button"
                            class="btn btn-dark customBtn px-4 savePasswordBtn">
                            Save Password
                        </button>

                        <button type="button"
                            class="btn btn-secondary px-4"
                            onclick="location.reload();">
                            Cancel
                        </button>

                    </div>

               </div>
           </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- <script>
document.addEventListener("DOMContentLoaded", function() {
    const tabContentContainer = document.getElementById('tabContentContainer');

    // 1️⃣ Restore last active tab on page load
    const lastTab = localStorage.getItem("activeTab");
    if (lastTab) {
        const triggerEl = document.querySelector(`#${lastTab}`);
        if (triggerEl) {
            const tab = new bootstrap.Tab(triggerEl);
            tab.show(); // Show the saved tab immediately
        }
    }

    // 2️⃣ Show tab container after activating the saved tab
    if (tabContentContainer) {
        tabContentContainer.classList.add('active-shown');
    }

    // 3️⃣ Reload page when user clicks a different tab
    const tabButtons = document.querySelectorAll('button[data-bs-toggle="pill"]');
    tabButtons.forEach((button) => {
        button.addEventListener("click", function(e) {
            const currentTab = localStorage.getItem("activeTab");
            if (currentTab !== this.id) {
                e.preventDefault(); // Stop Bootstrap from switching tab immediately
                localStorage.setItem("activeTab", this.id);
                //location.reload(); // reload before tab content shows
            }
        });
    });
});
</script> -->

<script>
    const preview = document.getElementById('profilePreview');
    const input = document.getElementById('profileInput');

    preview.addEventListener('click', function () {
        input.click();
    });

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

<script>
document.querySelectorAll('.country-radio').forEach(radio => {
    radio.addEventListener('change', function () {

        document.getElementById('selected-code').innerText = this.value;

        document.getElementById('selected-flag').innerHTML =
            `<img src="${this.dataset.flag}" width="25" height="16">`;
    });
});
</script>

<!-- update account -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('accountForm');

    if (!form) return; 

    const fullNameError = document.getElementById('error_full_name');
    const emailError = document.getElementById('error_email');
    const mobileError = document.getElementById('error_mobile');
    const countryError = document.getElementById('error_country_code');

    const fileInput = document.getElementById('profileInput');

    const fullNameInput = document.querySelector('input[name="full_name"]');
    const emailInput = document.querySelector('input[name="email"]');
    const mobileInput = document.querySelector('input[name="mobile"]');
    const countryRadio = document.querySelectorAll('.country-radio');


    if (fullNameInput && fullNameError) {
        fullNameInput.addEventListener('input', function () {
            fullNameError.innerText = '';
        });
    }

    if (emailInput && emailError) {
        emailInput.addEventListener('input', function () {
            emailError.innerText = '';
        });
    }

    if (mobileInput && mobileError) {
        mobileInput.addEventListener('input', function () {
            const value = this.value.trim();

            if (!value) {
                mobileError.innerText = '';
            } else if (value.length < 7) {
                mobileError.innerText = 'Please enter phone number between 7-15 digits';
            } else {
                mobileError.innerText = '';
            }
        });
    }

    if (countryRadio.length) {
        countryRadio.forEach(radio => {
            radio.addEventListener('change', function () {
                if (countryError) countryError.innerText = '';
            });
        });
    }


    form.addEventListener('submit', function (e) {
        e.preventDefault();

        if (fullNameError) fullNameError.innerText = '';
        if (emailError) emailError.innerText = '';
        if (mobileError) mobileError.innerText = '';
        if (countryError) countryError.innerText = '';

        let hasError = false;

        const full_name = fullNameInput ? fullNameInput.value.trim() : '';
        const email = emailInput ? emailInput.value.trim() : '';
        const mobile = mobileInput ? mobileInput.value.trim() : '';
        const country = document.querySelector('input[name="country_code"]:checked');

        if (!full_name) {
            if (fullNameError) fullNameError.innerText = 'Please enter full name';
            hasError = true;
        }

        if (!email) {
            if (emailError) emailError.innerText = 'Please enter email';
            hasError = true;
        } else if (!validateEmail(email)) {
            if (emailError) emailError.innerText = 'Please enter valid email';
            hasError = true;
        }

        if (!mobile) {
            if (mobileError) mobileError.innerText = 'Please enter mobile number';
            hasError = true;
        } else if (!/^\d{7,15}$/.test(mobile)) {
            if (mobileError) mobileError.innerText = 'Please enter phone number between 7-15 digits';
            hasError = true;
        }

        if (!country) {
            if (countryError) countryError.innerText = 'Please select country code';
            hasError = true;
        }

        if (hasError) return;

        let formData = new FormData();

        formData.append('full_name', full_name);
        formData.append('email', email);
        formData.append('mobile', mobile);
        formData.append('country_code', country.value);

        if (fileInput && fileInput.files.length > 0) {
            formData.append('image', fileInput.files[0]);
        }

        fetch("{{ route('admin.update_account') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: formData
        })
        .then(async (res) => {

            let text = await res.text();

            try {
                return JSON.parse(text);
            } catch (e) {
                console.log("Server Error:", text);
                toastr.error("Server error occurred");
                throw e;
            }

        })
        .then(data => {

            if (data.status === 'success') {

                toastr.success(data.message);

                setTimeout(() => {
                    location.reload();
                }, 1500);

            } else {
                toastr.error(data.message || 'Something went wrong');
            }

        })
        .catch(err => {
            console.log(err);
            toastr.error('Request failed');
        });

    });

    function validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

});
</script>

<!-- update password -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.querySelector('#passwordForm') || document;

    const oldError = document.getElementById('error_old_password');
    const newError = document.getElementById('error_new_password');
    const confirmError = document.getElementById('error_confirm_password');

    const oldInput = document.querySelector('input[name="old_password"]');
    const newInput = document.querySelector('input[name="new_password"]');
    const confirmInput = document.querySelector('input[name="confirm_password"]');

    const saveBtn = document.querySelector('.savePasswordBtn');

    if (oldInput) {
        oldInput.addEventListener('input', () => oldError.innerText = '');
    }

    if (newInput) {
        newInput.addEventListener('input', () => newError.innerText = '');
    }

    if (confirmInput) {
        confirmInput.addEventListener('input', () => confirmError.innerText = '');
    }

    if (saveBtn) {

        saveBtn.addEventListener('click', function () {

            oldError.innerText = '';
            newError.innerText = '';
            confirmError.innerText = '';

            let hasError = false;

            const old_password = oldInput.value.trim();
            const new_password = newInput.value.trim();
            const confirm_password = confirmInput.value.trim();


            if (!old_password) {
                oldError.innerText = 'Please enter old password';
                hasError = true;
            }

            if (!new_password) {
                newError.innerText = 'Please enter new password';
                hasError = true;
            } else if (!validatePassword(new_password)) {
                newError.innerText = 'Password must be 8+ chars with uppercase, number & special character';
                hasError = true;
            }

            if (!confirm_password) {
                confirmError.innerText = 'Please confirm password';
                hasError = true;
            } else if (new_password !== confirm_password) {
                confirmError.innerText = 'Confirm password does not match';
                hasError = true;
            }

            if (hasError) return;


            let formData = new FormData();
            formData.append('old_password', old_password);
            formData.append('new_password', new_password);
            formData.append('confirm_password', confirm_password);

            fetch("{{ route('admin.update_password') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: formData
            })
            .then(async (res) => {

                let text = await res.text();

                try {
                    return JSON.parse(text);
                } catch (e) {
                    toastr.error("Server error occurred");
                    console.log(text);
                    throw e;
                }

            })
            .then(data => {

                if (data.status === 'success') {

                    toastr.success(data.message);

                    setTimeout(() => {
                        location.reload();
                    }, 1500);

                } else {
                    toastr.error(data.message || 'Something went wrong');
                }

            })
            .catch(err => {
                console.log(err);
                toastr.error('Request failed');
            });

        });

    }


    function validatePassword(password) {
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/;
        return regex.test(password);
    }

});
</script>


@endsection