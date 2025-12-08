@extends('admin.layout.app')
@section('content')


<div id="content-wrapper" class="d-flex flex-column position-relative">
    <div id="content" class="">


        <div class="inner-content management">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="d-flex align-items-center gap-3 mt-2">
                        <div class="arrow">
                            <a class="table-button" type="button" href="{{route('admin.shippingManagement')}}">
                                <i class="fas fa-angle-left"></i>
                            </a>
                        </div>
                        <h6 class="m-0">{{$country->name}}</h6>
                    </div>
                </div>

                <div class="col-lg-6 col-md-4 col-12">
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-dark customBtn" data-bs-toggle="modal" data-bs-target="#sentModal2">
                            <span>Add Shipping Fee</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="userManagecontent mt-5">
                <div class="">

                    <div class="table-responsive w-100">
                        <table id="myTable" class="table w-100">
                            <thead>
                                <tr>
                                    <th scope="col">SR No.</th>
                                    <th scope="col">Range From to To (KM)</th>
                                    <th scope="col">Shipping Fee</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($shippingCharges as $key => $charge)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>{{ rtrim(rtrim(number_format($charge['range_from'], 2, '.', ''), '0'), '.') }}Km 
                                        to 
                                        {{ rtrim(rtrim(number_format($charge['range_to'], 2, '.', ''), '0'), '.') }}Km
                                    </td>

                                    <td>{{ rtrim(rtrim(number_format($charge['shipping_fee'], 2, '.', ''), '0'), '.') }} KD</td>
                                    <td>
                                        <div class="d-flex gap-3 justify-content-center">
                                            <a class="table-button editShippingBtn"
                                            data-id="{{ $charge['id'] }}"
                                            data-from="{{ $charge['range_from'] }}"
                                            data-to="{{ $charge['range_to'] }}"
                                            data-fee="{{ $charge['shipping_fee'] }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#sentModal3">

                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <!-- Delete button  -->
                                            <a
                                                href="javascript:void(0);"
                                                class="table-button text-danger deleteShippingCharge"
                                                data-id="{{ $charge->id }}"
                                            >
                                                <i class="bi bi-trash3-fill"></i>
                                            </a>

                                            <!-- Toggle switch -->
                                            <div class="form-check form-switch">
                                                <input
                                                    class="form-check-input toggleStatus"
                                                    type="checkbox"
                                                    role="switch"
                                                    id="switch{{ $charge->id }}"
                                                    data-id="{{ $charge->id }}"
                                                    {{ $charge->status == 1 ? 'checked' : '' }}
                                                />
                                            </div>
                                        </div>

                                    </td>

                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No Data found</td>
                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Shipping Fee Modal -->
<div class="modal fade" id="sentModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Add Shipping Fee</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <div class="row">

                        <input type="hidden" id="country_id" name="country_id" value="{{ $country->id }}">

                        <!-- Range Section -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label">Range</label>
                                <div class="row">

                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">From</label>
                                            <input type="text" name="range_from" oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^(\d{7}).*/,'$1')" class="form-control" placeholder="Enter range from" />
                                            <span id="rangeFromError" class="text-danger" style="display:none"></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">To</label>
                                            <input type="text" name="range_to" oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'').replace(/^(\d{7}).*/,'$1')" class="form-control" placeholder="Enter range to" />
                                            <span id="rangeToError" class="text-danger" style="display:none"></span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Shipping Fee -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label">Shipping Fee</label>
                                <input type="text" name="shipping_fee" oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/^0+([1-9])/,'$1').replace(/^0+$/,'').replace(/(\..*?)\..*/,'$1').replace(/(\.\d{2}).*/,'$1').replace(/^(\d{7})\d*/,'$1').replace(/^(\d{7}\.\d{2})\d*/,'$1')" class="form-control" placeholder="Enter shipping fee" />
                                <span id="shippingFeeError" class="text-danger" style="display:none"></span>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                            <a type="button" id="submitBrandBtn" class="btn btn-dark customBtn mt-3">
                                Submit
                            </a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Edit Shipping Fee Modal -->
<div class="modal fade" id="sentModal3" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header management border-0">
                <h2 class="h2">Edit Shipping Fee</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <div class="row">

                        <input type="hidden" id="edit_charge_id">
                        <input type="hidden" id="edit_country_id" value="{{ $country->id }}">

                        <!-- Range -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label">Range</label>

                                <div class="row">

                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">From</label>
                                            <input type="text" id="edit_range_from"
                                                oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^(\d{7}).*/,'$1')"
                                                class="form-control" placeholder="Enter range from">
                                            <span id="editRangeFromError" class="text-danger" style="display:none"></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">To</label>
                                            <input type="text" id="edit_range_to"
                                                oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^0+/,'').replace(/^(\d{7}).*/,'$1')"
                                                class="form-control" placeholder="Enter range to">
                                            <span id="editRangeToError" class="text-danger" style="display:none"></span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Shipping Fee -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label">Shipping Fee</label>
                                <input type="text" id="edit_shipping_fee"
                                    oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/^0+([1-9])/,'$1').replace(/^0+$/,'').replace(/(\..*?)\..*/,'$1').replace(/(\.\d{2}).*/,'$1').replace(/^(\d{7})\d*/,'$1').replace(/^(\d{7}\.\d{2})\d*/,'$1')"
                                    class="form-control" placeholder="Enter shipping fee">

                                <span id="editShippingFeeError" class="text-danger" style="display:none"></span>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                            <a id="updateShippingBtn" class="btn btn-dark customBtn mt-3">Update</a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- Delete -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.deleteShippingCharge').forEach(button => {
        button.addEventListener('click', function () {
            let shippingId = this.getAttribute('data-id');

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
                    fetch(`/admin/deleteShippingCharge/${shippingId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.status == "success"){
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

<!-- Update Status -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggleStatus').forEach(toggle => {
        toggle.addEventListener('change', function () {
            let shippingId = this.getAttribute('data-id');

            fetch(`/admin/updateShippingChargeStatus/${shippingId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // toastr.success(data.message);
                     if(data.status == 1){
                        toastr.success(data.message); // Green for active
                    } else {
                        toastr.error(data.message);   // Red for deactivated
                    }
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    toastr.error(data.message);
                }
            })
            .catch(error => {
                //console.error(error);
                toastr.error('Something went wrong while updating status.');
            });
        });
    });
});
</script>

<!-- add -->
<script>
document.addEventListener("DOMContentLoaded", function() {

    const rangeFrom = document.querySelector("input[name='range_from']");
    const rangeTo = document.querySelector("input[name='range_to']");
    const shippingFee = document.querySelector("input[name='shipping_fee']");
    const countryId = document.getElementById("country_id");
    const submitBtn = document.getElementById("submitBrandBtn");

    const rangeFromError = document.getElementById("rangeFromError");
    const rangeToError = document.getElementById("rangeToError");
    const shippingFeeError = document.getElementById("shippingFeeError");

    // Remove errors on typing
    rangeFrom.addEventListener("input", () => rangeFromError.style.display = "none");
    rangeTo.addEventListener("input", () => rangeToError.style.display = "none");
    shippingFee.addEventListener("input", () => shippingFeeError.style.display = "none");

    submitBtn.addEventListener("click", function(e) {
        e.preventDefault();

        let hasError = false;

        // Validate Range From
        if (rangeFrom.value.trim() === "") {
            rangeFromError.innerText = "Please enter range from";
            rangeFromError.style.display = "block";
            hasError = true;
        } 

        // Validate Range To
        if (rangeTo.value.trim() === "") {
            rangeToError.innerText = "Please enter range to";
            rangeToError.style.display = "block";
            hasError = true;
        } 

        // Compare Ranges
        if (rangeFrom.value && rangeTo.value && Number(rangeTo.value) <= Number(rangeFrom.value)) {
            rangeToError.innerText = "Range To must be greater than Range From";
            rangeToError.style.display = "block";
            hasError = true;
        }

        // Validate Shipping Fee
        if (shippingFee.value.trim() === "") {
            shippingFeeError.innerText = "Please enter shipping fee";
            shippingFeeError.style.display = "block";
            hasError = true;
        } else if (isNaN(shippingFee.value.trim())) {
            shippingFeeError.innerText = "Shipping fee must be a number";
            shippingFeeError.style.display = "block";
            hasError = true;
        }

        if (hasError) return;

        // Data to send
        const dataToSend = {
            country_id: countryId.value,
            range_from: rangeFrom.value.trim(),
            range_to: rangeTo.value.trim(),
            shipping_fee: shippingFee.value.trim()
        };

        // AJAX Request
        fetch("/admin/add_shipping_fee", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify(dataToSend)
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {

                toastr.success(data.message);

                const modal = bootstrap.Modal.getInstance(document.getElementById("sentModal2"));
                modal.hide();

                // Reset form
                rangeFrom.value = "";
                rangeTo.value = "";
                shippingFee.value = "";

                setTimeout(() => location.reload(), 1500);

            } else {
                toastr.error(data.message || "Failed to add shipping fee");
            }
        })
        .catch(() => {
            toastr.error("Something went wrong");
        });
    });

});
</script>

<!-- update -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const rangeFrom   = document.getElementById("edit_range_from");
    const rangeTo     = document.getElementById("edit_range_to");
    const shippingFee = document.getElementById("edit_shipping_fee");

    const idField     = document.getElementById("edit_charge_id");
    const countryId   = document.getElementById("edit_country_id");

    rangeFrom.addEventListener("input", function() {
        this.value = this.value.replace(/[^0-9]/g,'').replace(/^(\d{7}).*/,'$1');
    });

    rangeTo.addEventListener("input", function() {
        this.value = this.value.replace(/[^0-9]/g,'').replace(/^0+/,'').replace(/^(\d{7}).*/,'$1');
    });

    shippingFee.addEventListener("input", function() {
        this.value = this.value
            .replace(/[^0-9.]/g,'')
            .replace(/^0+([1-9])/,'$1')
            .replace(/^0+$/,'')
            .replace(/(\..*?)\..*/,'$1')
            .replace(/(\.\d{2}).*/,'$1')
            .replace(/^(\d{7})\d*/,'$1')
            .replace(/^(\d{7}\.\d{2})\d*/,'$1');
    });

    const errFrom = document.getElementById("editRangeFromError");
    const errTo   = document.getElementById("editRangeToError");
    const errFee  = document.getElementById("editShippingFeeError");

    const updateBtn = document.getElementById("updateShippingBtn");

    function cleanNumber(value) {

        if (!value) return "";

        return value
            .toString()
            .replace(/\.00$/, "");  // remove .00 at end
    }

    document.querySelectorAll(".editShippingBtn").forEach(button => {

        button.addEventListener("click", function() {

            idField.value = this.dataset.id;

            rangeFrom.value   = cleanNumber(this.dataset.from);
            rangeTo.value     = cleanNumber(this.dataset.to);
            shippingFee.value = cleanNumber(this.dataset.fee);

            // remove error messages
            errFrom.style.display = "none";
            errTo.style.display   = "none";
            errFee.style.display  = "none";
        });
    });

    rangeFrom.oninput   = () => errFrom.style.display = "none";
    rangeTo.oninput     = () => errTo.style.display = "none";
    shippingFee.oninput = () => errFee.style.display = "none";

    updateBtn.addEventListener("click", function(e) {
        e.preventDefault();

        let hasError = false;

        // Validate range from
        if (rangeFrom.value.trim() === "") {
            errFrom.innerText = "Please enter range from";
            errFrom.style.display = "block";
            hasError = true;
        }

        // Validate range to
        if (rangeTo.value.trim() === "") {
            errTo.innerText = "Please enter range to";
            errTo.style.display = "block";
            hasError = true;
        }

        // Validate correct order
        if (rangeFrom.value && rangeTo.value && Number(rangeTo.value) <= Number(rangeFrom.value)) {
            errTo.innerText = "Range To must be greater than Range From";
            errTo.style.display = "block";
            hasError = true;
        }

        // Validate shipping fee
        if (shippingFee.value.trim() === "") {
            errFee.innerText = "Please enter shipping fee";
            errFee.style.display = "block";
            hasError = true;
        }

        if (hasError) return;

        const payload = {
            shipping_charge_id: idField.value,
            // country_id: countryId.value,
            range_from: rangeFrom.value,
            range_to: rangeTo.value,
            shipping_fee: shippingFee.value
        };

        fetch("/admin/update_shipping_fee", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {

            if (data.status === "success") {

                toastr.success(data.message);

                const modal = bootstrap.Modal.getInstance(
                    document.getElementById("sentModal3")
                );

                modal.hide();

                setTimeout(() => location.reload(), 1500);
            }
            else {
                toastr.error(data.message || "Failed to update shipping fee");
            }
        })
        .catch(() => {
            toastr.error("Something went wrong");
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




@endsection