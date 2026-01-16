@extends('admin.layout.app')
@section('content')


<div class="inner-content management">
    <h2 class="h2">REASON MANAGEMENT</h2>

    <div class="d-flex justify-content-center">
        <ul class="nav nav-pills tabs-pnl custom" id="pills-tab" role="tablist">
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-order-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order"
                    aria-selected="false">
                    Exchange
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0 active" id="pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="true">
                    Return
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-return-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-return" type="button" role="tab" aria-controls="pills-return"
                    aria-selected="false">
                    Cancel
                </button>
            </li>
        </ul>
    </div>
    <div class="userManagecontent mb-4">
        <div class="tab-content" id="pills-tabContent">

            <!-- Exchange -->

            <div class="tab-pane fade" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab" tabindex="0">
                <div class="row align-items-end justify-content-end">


                    <div class="col-lg-6 col-md-4 col-12">
                        <div class="d-flex justify-content-end">
                            <a class="btn btn-dark customBtn button add-reason-btn" data-type="1" data-bs-toggle="modal" data-bs-target="#sentModal2">
                                <span>Add</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mb-5">
                    <table id="myTable" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Exchange Reason</th>
                                <th scope="col">Action</th>


                            </tr>
                        </thead>
                        <tbody>
                            @forelse($exchangeReason as $index => $reason)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $reason['reason_english'] }}</td>
                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a href="javascript:void(0);" 
                                            class="table-button edit-reason-btn" 
                                            data-id="{{ $reason['id'] }}" 
                                            data-english="{{ $reason['reason_english'] }}" 
                                            data-arabic="{{ $reason['reason_arabic'] }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editReasonModal">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <a href="javascript:void(0);" class="table-button text-danger deleteReason mb-1 mt-1"
                                            data-id="{{ $reason->id }}">
                                            <i class="bi bi-trash3-fill"></i>
                                        </a>

                                        <div class="form-check form-switch" style="justify-content: center;">
                                            <input class="form-check-input toggleStatus" type="checkbox"
                                                id="flexSwitchCheckChecked{{ $reason['id'] }}" data-id="{{ $reason['id'] }}"
                                                {{ $reason['status'] == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckChecked{{ $reason['id'] }}"></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No data found</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Return -->
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                tabindex="0">
                <div class="row align-items-end justify-content-end">


                    <div class="col-lg-6 col-md-4 col-12">
                        <div class="d-flex justify-content-end">
                            <a class="btn btn-dark customBtn button add-reason-btn" data-type="2" data-bs-toggle="modal" data-bs-target="#sentModal2">
                                <span>Add</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mb-5">
                    <table id="myTable1" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Return Reason</th>
                                <th scope="col">Action</th>


                            </tr>
                        </thead>
                        <tbody>
                            @forelse($returnReason as $index => $reason)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $reason['reason_english'] }}</td>
                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a href="javascript:void(0);" 
                                            class="table-button edit-reason-btn" 
                                            data-id="{{ $reason['id'] }}" 
                                            data-english="{{ $reason['reason_english'] }}" 
                                            data-arabic="{{ $reason['reason_arabic'] }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editReasonModal">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <a href="javascript:void(0);" class="table-button text-danger deleteReason"
                                            data-id="{{ $reason->id }}">
                                            <i class="bi bi-trash3-fill"></i>
                                        </a>

                                        <div class="form-check form-switch" style="justify-content: center;">
                                            <input class="form-check-input toggleStatus" type="checkbox"
                                                id="flexSwitchCheckChecked{{ $reason['id'] }}" data-id="{{ $reason['id'] }}"
                                                {{ $reason['status'] == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckChecked{{ $reason['id'] }}"></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No data found</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>
            </div>

            <!-- cancle -->

            <div class="tab-pane fade" id="pills-return" role="tabpanel" aria-labelledby="pills-return-tab"
                tabindex="0">
               <div class="row align-items-end justify-content-end">


                    <div class="col-lg-6 col-md-4 col-12">
                        <div class="d-flex justify-content-end">
                            <a class="btn btn-dark customBtn button add-reason-btn" data-type="3" data-bs-toggle="modal" data-bs-target="#sentModal2">
                                <span>Add</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mb-5">
                    <table id="myTable2" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Cancle Reason</th>
                                <th scope="col">Action</th>


                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cancelReason as $index => $reason)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $reason['reason_english'] }}</td>
                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a href="javascript:void(0);" 
                                            class="table-button edit-reason-btn" 
                                            data-id="{{ $reason['id'] }}" 
                                            data-english="{{ $reason['reason_english'] }}" 
                                            data-arabic="{{ $reason['reason_arabic'] }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editReasonModal">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <a href="javascript:void(0);" class="table-button text-danger deleteReason"
                                            data-id="{{ $reason->id }}">
                                            <i class="bi bi-trash3-fill"></i>
                                        </a>

                                        <div class="form-check form-switch" style="justify-content: center;">
                                            <input class="form-check-input toggleStatus" type="checkbox"
                                                id="flexSwitchCheckChecked{{ $reason['id'] }}" data-id="{{ $reason['id'] }}"
                                                {{ $reason['status'] == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckChecked{{ $reason['id'] }}"></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No data found</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- End of Content Wrapper -->
</div>


<!-- add new model -->
<div class="modal fade" id="sentModal2" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Add Reason</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="reasonForm">
                    <input type="hidden" id="reasonType" name="type" value="" />
                    <div class="mb-3">
                        <label for="reasonEnglish" class="form-label">Reason (English)</label>
                        <textarea id="reasonEnglish" name="reason_english" class="form-control" placeholder="Enter Reason in English"
                            oninput="this.value=this.value.replace(/[^A-Za-z0-9 \n]/g,'').replace(/^\s+/,'')"
                            rows="3"></textarea>
                        <div class="text-danger mt-1 error-message" id="englishError" style="display:none;"></div>
                    </div>

                    <div class="mb-3">
                        <label for="reasonArabic" class="form-label">Reason (Arabic)</label>
                        <textarea id="reasonArabic" name="reason_arabic" class="form-control" placeholder="Enter Reason in Arabic"
                            oninput="this.value=this.value.replace(/[^0-9\u0600-\u06FF \n]/g,'').replace(/^\s+/,'')"
                            rows="3"></textarea>
                        <div class="text-danger mt-1 error-message" id="arabicError" style="display:none;"></div>
                    </div>
                    <div class="d-flex justify-content-center gap-3 mt-3">
                        <button type="button" class="btn btn-dark customBtn" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-dark customBtn">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- edit modal -->
 <div class="modal fade" id="editReasonModal" tabindex="-1" aria-labelledby="editReasonModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <div class="modal-header management border-0">
              <h5 class="modal-title" id="editReasonModalLabel">Edit Reason</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="editReasonForm">
          <input type="hidden" id="editReasonId" name="reason_id" value="">
          <div class="mb-3">
                <label for="editReasonEnglish" class="form-label">Reason (English)</label>
                <textarea id="editReasonEnglish" name="reason_english" class="form-control"
                    oninput="this.value=this.value.replace(/[^A-Za-z0-9 \n]/g,'').replace(/^\s+/,'')"
                    rows="3"></textarea>
                <div id="editEnglishError" class="text-danger small" style="display:none;"></div>
            </div>

            <div class="mb-3">
                <label for="editReasonArabic" class="form-label">Reason (Arabic)</label>
                <textarea id="editReasonArabic" name="reason_arabic" class="form-control"
                    oninput="this.value=this.value.replace(/[^0-9\u0600-\u06FF \n]/g,'').replace(/^\s+/,'')"
                    rows="3"></textarea>
                <div id="editArabicError" class="text-danger small" style="display:none;"></div>
            </div>

          <div class="d-flex justify-content-center gap-3 mt-3">
            <button type="button" class="btn btn-dark customBtn" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-dark customBtn">Update</button>
           </div>
        </form>
        </div>
      </div>
  </div>
</div>




@endsection

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/38.0.0/classic/ckeditor.js"></script>

<!-- activate deactivate reason -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.toggleStatus').forEach(toggle => {
        toggle.addEventListener('change', function() {
            let reasonId = this.getAttribute('data-id');
            let isChecked = this.checked;

            fetch(`/admin/blockUnblockReason/${reasonId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        is_block: isChecked ? 0 : 1
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        if (isChecked) {
                            toastr.success(data.message);
                        } else {
                            toastr.error(data.message);
                        }
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    } else {
                        toastr.error(data.message);
                        this.checked = !isChecked;
                    }
                })
                .catch(error => {
                    toastr.error('Something went wrong while updating status.');
                    this.checked = !isChecked;
                });
        });
    });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Get last active tab from localStorage
    const lastTab = localStorage.getItem("activeTab");
    if (lastTab) {
        const triggerEl = document.querySelector(`#${lastTab}`);
        if (triggerEl) {
            const tab = new bootstrap.Tab(triggerEl);
            tab.show();
        }
    }

    // Save active tab to localStorage when switched
    const tabButtons = document.querySelectorAll('button[data-bs-toggle="pill"]');
    tabButtons.forEach((button) => {
        button.addEventListener("shown.bs.tab", function() {
            localStorage.setItem("activeTab", this.id);
        });
    });
});
</script>

<!-- delete reason -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.deleteReason').forEach(button => {
        button.addEventListener('click', function() {
            let reasonId = this.getAttribute('data-id');

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/deleteReason/${reasonId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                toastr.success(data.message);
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
                            } else {
                                toastr.error(data.message);
                            }
                        })
                        .catch(() => {
                            toastr.error('Something went wrong.');
                        });
                }
            });
        });
    });
});
</script>

<!-- add reason -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const addButtons = document.querySelectorAll(".add-reason-btn");
    const reasonTypeInput = document.getElementById("reasonType");
    const reasonForm = document.getElementById("reasonForm");
    const englishInput = document.getElementById("reasonEnglish");
    const arabicInput = document.getElementById("reasonArabic");
    const englishError = document.getElementById("englishError");
    const arabicError = document.getElementById("arabicError");

    addButtons.forEach(btn => {
        btn.addEventListener("click", function() {
            const type = this.getAttribute("data-type");
            reasonTypeInput.value = type;
           // console.log(reasonTypeInput.value);
            englishError.style.display = "none";
            arabicError.style.display = "none";
        });
    });

    englishInput.addEventListener("input", function() {
        englishError.style.display = "none";
    });

    arabicInput.addEventListener("input", function() {
        arabicError.style.display = "none";
    });

    reasonForm.addEventListener("submit", function(e) {
        e.preventDefault();

        const reasonEnglish = englishInput.value.trim();
        const reasonArabic = arabicInput.value.trim();
        const type = reasonTypeInput.value;
        let hasError = false;

        // Frontend validation
        if (!reasonEnglish) {
            englishError.innerText = "Enter Reason in English";
            englishError.style.display = "block";
            hasError = true;
        }

        if (!reasonArabic) {
            arabicError.innerText = "Enter Reason in Arabic";
            arabicError.style.display = "block";
            hasError = true;
        }

        if (hasError) return;


        fetch("/admin/add_reason", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                "Accept": "application/json"
            },
            body: JSON.stringify({
                reason_english: reasonEnglish,
                reason_arabic: reasonArabic,
                type: type
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                toastr.success(data.message); 
                const modal = bootstrap.Modal.getInstance(document.getElementById("sentModal2"));
                modal.hide();
                reasonForm.reset();
                setTimeout(() => {
                    location.reload();
                }, 2000);
            } else {
                toastr.error(data.message || "Something went wrong."); 
            }
        })
        .catch(error => {
            console.error(error);
            toastr.error("Failed to submit reason.");
        });
    });

});
</script>

<!-- update reason -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const editButtons = document.querySelectorAll(".edit-reason-btn");
    const editReasonForm = document.getElementById("editReasonForm");
    const editReasonIdInput = document.getElementById("editReasonId");
    const editEnglishInput = document.getElementById("editReasonEnglish");
    const editArabicInput = document.getElementById("editReasonArabic");
    const editEnglishError = document.getElementById("editEnglishError");
    const editArabicError = document.getElementById("editArabicError");

    editButtons.forEach(btn => {
        btn.addEventListener("click", function() {
            const id = this.getAttribute("data-id");
            const english = this.getAttribute("data-english");
            const arabic = this.getAttribute("data-arabic");

            editReasonIdInput.value = id;
            editEnglishInput.value = english;
            editArabicInput.value = arabic;

            editEnglishError.style.display = "none";
            editArabicError.style.display = "none";
        });
    });

    editEnglishInput.addEventListener("input", () => {
        editEnglishError.style.display = "none";
    });

    editArabicInput.addEventListener("input", () => {
        editArabicError.style.display = "none";
    });

    editReasonForm.addEventListener("submit", function(e) {
        e.preventDefault();

        const reasonEnglish = editEnglishInput.value.trim();
        const reasonArabic = editArabicInput.value.trim();
        const reasonId = editReasonIdInput.value;
        let hasError = false;

        if (!reasonEnglish) {
            editEnglishError.innerText = "Enter Reason in English";
            editEnglishError.style.display = "block";
            hasError = true;
        }
        if (!reasonArabic) {
            editArabicError.innerText = "Enter Reason in Arabic";
            editArabicError.style.display = "block";
            hasError = true;
        }
        if (hasError) return;

        fetch(`/admin/update_reason`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                "Accept": "application/json"
            },
            body: JSON.stringify({
                reason_english: reasonEnglish,
                reason_arabic: reasonArabic,
                reason_id: reasonId 
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                toastr.success(data.message);
                const modal = bootstrap.Modal.getInstance(document.getElementById("editReasonModal"));
                modal.hide();
                editReasonForm.reset();
                setTimeout(() => location.reload(), 2000);
            } else {
                toastr.error(data.message || "Failed to update reason.");
            }
        })
        .catch(err => {
            console.error(err);
            toastr.error("Something went wrong.");
        });
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('sentModal2');
    modal.addEventListener('hidden.bs.modal', function () {
        location.reload(); 
    });
});
</script>