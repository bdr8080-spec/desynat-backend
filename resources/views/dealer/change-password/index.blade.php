@include('dealer.layout.header')


<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <h3>{{ __('seller_messages.change_password') }}</h3>
    </div>
    
    <form id="passwordForm">
    <div class="payment-box">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group position-relative">
                    <label for="password">  {{ __('seller_messages.old_password') }}</label>
                    <input type="password" class="form-control notapplyspace" id="old_password" name="old_password"
                        placeholder="{{ __('seller_messages.enter_password') }}" >
                    <i class="toggle-password  bi bi-eye-slash "></i>
                    <small id="error_old_password" class="text-danger"></small>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group position-relative">
                    <label for="password">{{ __('seller_messages.enter_new_password') }}</label>
                    <input type="password" class="form-control notapplyspace" id="new_password" name="new_password"
                        placeholder="{{ __('seller_messages.enter_new_password') }}" >
                    <i class="toggle-password  bi bi-eye-slash "></i>
                    <small id="error_new_password" class="text-danger"></small>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group position-relative">
                    <label for="password"> {{ __('seller_messages.confirm_password') }}</label>
                    <input type="password" class="form-control notapplyspace"  id="confirm_password" name="confirm_password"
                        placeholder="{{ __('seller_messages.re_enter_password') }}" >
                    <i class="toggle-password  bi bi-eye-slash "></i>
                    <small id="error_confirm_password" class="text-danger"></small>
                </div>
            </div>
        </div>
        
        <div class="login-btn mt-5 mb-3">
            <button type="button" class="btn btn-success w-100 savePasswordBtn">
                 {{ __('seller_messages.save') }}
            </button>
        </div>

    </div>
    </form>



</div>



@include('dealer.layout.custom_code');
@include('dealer.layout.footer');

<script>
     $(".toggle-password").click(function() {
        $(this).toggleClass("bi-eye bi-eye-slash");
        input = $(this).parent().find("input");
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

</script>

<!-- update password -->
<script>
document.addEventListener('DOMContentLoaded', function() {

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

        saveBtn.addEventListener('click', function() {

            oldError.innerText = '';
            newError.innerText = '';
            confirmError.innerText = '';

            let hasError = false;

            const old_password = oldInput.value.trim();
            const new_password = newInput.value.trim();
            const confirm_password = confirmInput.value.trim();


            if (!old_password) {
                oldError.innerText =  "{{ __('seller_messages.enter_old_password_validation') }}";
                hasError = true;
            }

            if (!new_password) {
                newError.innerText = "{{ __('seller_messages.enter_new_password_validation') }}";
                hasError = true;
            } else if (!validatePassword(new_password)) {
                newError.innerText =
                    "{{ __('seller_messages.password_validation_message') }}";
                hasError = true;
            }

            if (!confirm_password) {
                confirmError.innerText = "{{ __('seller_messages.confirm_password_validation') }}";
                hasError = true;
            } else if (new_password !== confirm_password) {
                confirmError.innerText = "{{ __('seller_messages.password_not_match') }}";
                hasError = true;
            }

            if (hasError) return;


            let formData = new FormData();
            formData.append('old_password', old_password);
            formData.append('new_password', new_password);
            formData.append('confirm_password', confirm_password);

            fetch("{{ route('seller.update_password') }}", {
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




