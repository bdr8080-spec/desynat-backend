@extends('admin.layout.app')
@section('content')

<style>
.user-box {
    position: relative;
}

/* Apply scroll to all dropdown lists */
.user-list {
    max-height: 450px;
    overflow-y: auto;
    border-radius: 6px;
    padding: 6px;
}

/* Optional scrollbar styling */
.user-list::-webkit-scrollbar {
    width: 6px;
}

.user-list::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

.user-list::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>
<style>
.affiliate-list {
    max-height: 450px;      /* controls dropdown height */
    overflow-y: auto;       /* enables vertical slider */
    border-radius: 6px;
    padding: 10px;
}

/* Optional scrollbar styling */
.affiliate-list::-webkit-scrollbar {
    width: 6px;
}

.affiliate-list::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

.affiliate-list::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>
<style>
.seller-list {
    max-height: 450px;
    overflow-y: auto;
    border-radius: 6px;
    padding: 10px;
}

.seller-list::-webkit-scrollbar {
    width: 6px;
}

.seller-list::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

.seller-list::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>
<style>
.delivery-list {
    max-height: 450px;
    overflow-y: auto;
    border-radius: 6px;
    padding: 10px;
}

.delivery-list::-webkit-scrollbar {
    width: 6px;
}

.delivery-list::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

.delivery-list::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>
<style>
.user-item.hidden {
    display: none !important;
}
</style>



<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <div class="arrow">
                <a href="{{ route('admin.notificationManagement') }}" type="button">
                    <i class="fas fa-angle-left"></i>
                </a>
            </div>

            <h2 class="h2">{{ __('admin_messages.send_notification') }}</h2>
        </div>
    </div>

    <div class="row">
        <!-- LEFT FORM -->
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-group">{{ __('admin_messages.notification_title_english') }}</label>
                <input type="text" id="title_english" placeholder="{{ __('admin_messages.enter_title_english') }}" oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')" class="form-control" />
            </div>
            <h6 class="text-danger error-title_english"></h6>

            <div class="mb-3">
                <label class="form-group">{{ __('admin_messages.notification_title_arabic') }}</label>
                <input type="text" id="title_arabic" placeholder="{{ __('admin_messages.enter_title_arabic') }}" dir="rtl" oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')" class="form-control" />
            </div>
            <h6 class="text-danger error-title_arabic"></h6>

            <div class="mb-3">
                <label class="form-group">{{ __('admin_messages.notification_description_english') }}</label>
                <textarea rows="4" id="description_english" placeholder="{{ __('admin_messages.enter_description_english') }}" oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')" class="form-control"></textarea>
            </div>
            <h6 class="text-danger error-description_english"></h6>

            <div class="mb-4">
                <label class="form-group">{{ __('admin_messages.notification_description_arabic') }}</label>
                <textarea rows="4" id="description_arabic"  placeholder="{{ __('admin_messages.enter_description_arabic') }}"  dir="rtl" oninput="this.value = this.value.replace(/[^\u0600-\u06FF ]/g,'').replace(/^\s+/,'')" class="form-control"></textarea>
            </div>
            <h6 class="text-danger error-description_arabic"></h6>

            <button type="button" id="sendNotificationBtn" class="btn btn-dark customBtn px-4">{{ __('admin_messages.send') }}</button>
        </div>

        <!-- RIGHT MULTI SELECT -->
        <div class="col-md-8">
            <div class="row g-3">

                <!-- ================= USERS ================= -->
                <div class="col-md-3">
                    <div class="multi-box form-group user-box users-wrapper">

                        <!-- Search -->
                        <input type="text" class="search-box users-search form-control"
                            placeholder="{{ __('admin_messages.search_user') }}">

                        <!-- Select All -->
                        <div class="user-item d-flex justify-content-between mt-3">
                            <label>{{ __('admin_messages.select_all') }}</label>
                            <input type="checkbox" class="users-select-all">
                        </div>

                        <!-- List -->
                        <div class="user-list users-list">

                            @foreach($users as $user)
                                <div class="user-item d-flex justify-content-between bottom-border user-row">

                                    <span>{{ $user['full_name'] }}</span>

                                    <input type="checkbox"
                                        class="user-checkbox users-checkbox"
                                        name="users[]"
                                        value="{{ $user['id'] }}">

                                </div>
                            @endforeach

                        </div>

                    </div>
                </div>

                <!-- ================= AFFILIATES ================= -->
                <div class="col-md-3">
                    <div class="multi-box form-group user-box affiliate-box">

                        <!-- Search -->
                        <input type="text" class="search-box affiliate-search form-control"
                            placeholder="{{ __('admin_messages.search_affiliate_user') }}">

                        <!-- Select All -->
                        <div class="user-item d-flex justify-content-between mt-3">
                            <label>{{ __('admin_messages.select_all') }}</label>
                            <input type="checkbox" class="affiliate-select-all">
                        </div>

                        <!-- List -->
                        <div class="user-list affiliate-list">

                            @foreach($affiliateUsers as $user)
                                <div class="user-item d-flex justify-content-between bottom-border user-row">

                                    <span>{{ $user['full_name'] }}</span>

                                    <input type="checkbox"
                                        class="user-checkbox affiliate-checkbox"
                                        name="affiliate_users[]"
                                        value="{{ $user['id'] }}">

                                </div>
                            @endforeach

                        </div>

                    </div>
                </div>

                <!-- ================= SELLERS ================= -->
                <div class="col-md-3">
                    <div class="multi-box form-group user-box seller-box">

                        <!-- Search -->
                        <input type="text" class="search-box seller-search form-control"
                            placeholder="{{ __('admin_messages.search_seller') }}">

                        <!-- Select All -->
                        <div class="user-item d-flex justify-content-between mt-3">
                            <label>{{ __('admin_messages.select_all') }}</label>
                            <input type="checkbox" class="seller-select-all">
                        </div>

                        <!-- List -->
                        <div class="user-list seller-list">

                            @foreach($sellers as $seller)
                                <div class="user-item d-flex justify-content-between bottom-border user-row">

                                    <span>{{ $seller['first_name'] }} {{ $seller['last_name'] }}</span>

                                    <input type="checkbox"
                                        class="user-checkbox seller-checkbox"
                                        name="seller_users[]"
                                        value="{{ $seller['id'] }}">

                                </div>
                            @endforeach

                        </div>

                    </div>
                </div>

                <!-- ================= DELIVERY BOYS ================= -->
                <div class="col-md-3">
                    <div class="multi-box form-group user-box delivery-box">

                        <!-- Search -->
                        <input type="text" class="search-box delivery-search form-control"
                            placeholder="{{ __('admin_messages.search_delivery_boy') }}">

                        <!-- Select All -->
                        <div class="user-item d-flex justify-content-between mt-3">
                            <label>{{ __('admin_messages.select_all') }}</label>
                            <input type="checkbox" class="delivery-select-all">
                        </div>

                        <!-- List -->
                        <div class="user-list delivery-list">

                            @foreach($deliveryBoys as $boy)
                                <div class="user-item d-flex justify-content-between bottom-border user-row">

                                    <span>{{ $boy['full_name_english'] }}</span>

                                    <input type="checkbox"
                                        class="user-checkbox delivery-checkbox"
                                        name="delivery_users[]"
                                        value="{{ $boy['id'] }}">

                                </div>
                            @endforeach

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>


</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const sendBtn = document.getElementById("sendNotificationBtn");

    sendBtn.addEventListener("click", function () {

        // Clear previous errors
        clearErrors();

        let isValid = true;

        let titleEnglish = document.getElementById("title_english").value.trim();
        let titleArabic = document.getElementById("title_arabic").value.trim();
        let descEnglish = document.getElementById("description_english").value.trim();
        let descArabic = document.getElementById("description_arabic").value.trim();

        // ✅ FRONTEND VALIDATION

        if (!titleEnglish) {
            showError("title_english", "{{ __('admin_messages.please_enter_notification_title_in_english') }}");
            isValid = false;
        }

        if (!titleArabic) {
            showError("title_arabic", "{{ __('admin_messages.please_enter_notification_title_in_arabic') }}");
            isValid = false;
        }

        if (!descEnglish) {
            showError("description_english", "{{ __('admin_messages.please_enter_notification_description_in_english') }}");
            isValid = false;
        }

        if (!descArabic) {
            showError("description_arabic", "{{ __('admin_messages.please_enter_notification_description_in_arabic') }}");
            isValid = false;
        }

        // Optional: at least one receiver
        let users = getCheckedValues("users-checkbox");
        let affiliates = getCheckedValues("affiliate-checkbox");
        let sellers = getCheckedValues("seller-checkbox");
        let drivers = getCheckedValues("delivery-checkbox");

        if (
            users.length === 0 &&
            affiliates.length === 0 &&
            sellers.length === 0 &&
            drivers.length === 0
        ) {
            toastr.error("{{ __('admin_messages.please_select_at_least_one_recipient') }}");
            isValid = false;
        }

        if (!isValid) return;

        // ✅ AJAX CALL
        let payload = {
            title_english: titleEnglish,
            title_arabic: titleArabic,
            description_english: descEnglish,
            description_arabic: descArabic,
            user_id: users,
            affiliate_id: affiliates,
            seller_id: sellers,
            driver_id: drivers,
            sender_type: 1
        };
       // console.log("Payload going to server:", payload);

        fetch("{{ route('admin.send_notification') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(res => {

            if (res.status === "error") {
                toastr.error(res.message || "Something went wrong");
            } else {
                toastr.success(res.message);

                window.location.href = "{{ route('admin.notificationManagement') }}";
            }

        })
        .catch(() => {
            toastr.error("Something went wrong");
        });

    });


    /***********************
     * GET CHECKED VALUES
     ***********************/
    function getCheckedValues(className) {
        let values = [];
        document.querySelectorAll("." + className + ":checked").forEach(cb => {
            values.push(cb.value);
        });
        return values;
    }


    /***********************
     * SHOW ERROR
     ***********************/
    function showError(field, message) {
        let el = document.querySelector(".error-" + field);
        if (el) {
            el.innerText = message;
        }
    }


    /***********************
     * CLEAR ERRORS
     ***********************/
    function clearErrors() {
        document.querySelectorAll(".text-danger").forEach(el => {
            el.innerText = "";
        });
    }


    /***********************
     * REMOVE ERROR ON TYPING
     ***********************/
    document.querySelectorAll("input, textarea").forEach(input => {
        input.addEventListener("input", function () {
            let errorEl = document.querySelector(".error-" + this.id);
            if (errorEl) {
                errorEl.innerText = "";
            }
        });
    });

});
</script>



<script>
document.addEventListener("DOMContentLoaded", function () {
    // SELECT ALL
    document.querySelectorAll(".users-select-all, .affiliate-select-all, .seller-select-all, .delivery-select-all")
    .forEach(selectAll => {

        selectAll.addEventListener("change", function () {

            let wrapper = this.closest(".multi-box");
            if (!wrapper) return;

            let checkboxes = wrapper.querySelectorAll("input[type='checkbox']");

            checkboxes.forEach(cb => {

                if (cb === selectAll) return;

                let item = cb.closest(".user-item");

                if (item && item.style.display !== "none") {
                    cb.checked = selectAll.checked;
                }

            });

        });

    });

});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    //console.log("✅ Search script loaded");

    document.querySelectorAll(".search-box").forEach(input => {

        input.addEventListener("input", function () {

           // console.log("⌨️ Typing:", this.value);

            const wrapper = this.closest(".multi-box");
            if (!wrapper) return;

            const filter = this.value.toLowerCase().trim();

            const rows = wrapper.querySelectorAll(".user-list .user-item");

            rows.forEach(row => {

                const nameEl = row.querySelector("span");
                const text = nameEl ? nameEl.innerText.toLowerCase() : "";

                if (text.includes(filter)) {
                    row.classList.remove("hidden");
                } else {
                    row.classList.add("hidden");
                }

            });

        });

    });

});
</script>


@endsection