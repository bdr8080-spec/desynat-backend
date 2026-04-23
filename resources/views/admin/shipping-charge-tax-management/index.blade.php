@extends('admin.layout.app')
@section('content')
@php
    $admin = auth('admin')->user();

    $permissions = \App\Models\AdminPermission::where('admin_id', $admin->id)
        ->where('can_action', 1)
        ->pluck('module_id')
        ->toArray();
@endphp

<div id="content-wrapper" class="d-flex flex-column position-relative">
    <div id="content" class="">
        <div class="inner-content management">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 col-md-6 col-12">
                    <h2 class="h2">Delivery Charges & Tax Management</h2>
                </div>


            </div>

            <div class="userManagecontent">
                <div class="mt-4">

                    <div class="table-responsive w-100">
                        <table id="myTable" class="table w-100">
                            <thead>
                                <tr>
                                    <th scope="col">SR No.</th>
                                    <th scope="col">Country Name</th>
                                    @if(in_array(11, $permissions) || $admin->type == 1)
                                    <th scope="col">Manage Delivery Charges</th>
                                    @endif
                                    <th scope="col">Tax Percentage</th>
                                    @if(in_array(11, $permissions) || $admin->type == 1)
                                    <th scope="col">Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($getCountries as $key => $country)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>{{ $country->name }}</td>
                                    @if(in_array(11, $permissions) || $admin->type == 1)
                                    <td> <a class="btn btn-dark customBtn" href="{{ route('admin.manageShippingCharges', ['id' => $country->id]) }}">
                                            <span>Manage </span>
                                        </a></td>
                                    @endif
                                    <td>{{ $country['tax_info'] ? $country['tax_info']->tax : 'N/A' }}</td>
                                    @if(in_array(11, $permissions) || $admin->type == 1)
                                    <td>
                                        <div class="d-flex gap-3 justify-content-center">
                                            <a href="javascript:void(0);" 
                                                class="table-button edit-tax-btn" 
                                                data-id="{{ $country['tax_info']->id }}"  
                                                data-tax="{{ $country['tax_info']->tax }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editTaxModal">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                        </div>
                                    </td>
                                    @endif
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

<div class="modal fade" id="editTaxModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Update Tax</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editTaxForm">
                <div class="modal-body m-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="hidden" id="editTaxId" name="tax_id">
                            <div class="form-group w-100">
                                <label for="from" class="form-label"> Tax</label>
                                <input type="text" id="tax" name="tax" placeholder="Enter Tax" oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/(\..*?)\..*/,'$1').replace(/(\.\d{2}).*/,'$1'); if(parseFloat(this.value)>100)this.value='100';" class="form-control"
                                    aria-describedby="passwordHelpInline" />
                                <div id="editTaxError" class="text-danger small" style="display:none;"></div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                                <div class="d-flex align-items-center justify-content-center gap-3 mt-3"
                                    style="margin-top: 30px">
                                    <button type="submit" class="btn btn-dark customBtn">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function() {
    const editButtons = document.querySelectorAll(".edit-tax-btn");
    const editTaxForm = document.getElementById("editTaxForm");
    const editTaxIdInput = document.getElementById("editTaxId");
    const editTaxInput = document.getElementById("tax");
    const editTaxError = document.getElementById("editTaxError");

    editButtons.forEach(btn => {
        btn.addEventListener("click", function() {
            const id = this.getAttribute("data-id");
            const tax = this.getAttribute("data-tax");

            editTaxIdInput.value = id;
            editTaxInput.value = tax;

            editTaxError.style.display = "none";
        });
    });

    editTaxInput.addEventListener("input", () => {
        editTaxError.style.display = "none";
    });

    editTaxForm.addEventListener("submit", function(e) {
        e.preventDefault();

        const tax = editTaxInput.value.trim();
        const id = editTaxIdInput.value;
        let hasError = false;

        if (!tax) {
            editTaxError.innerText = "Please Enter Tax";
            editTaxError.style.display = "block";
            hasError = true;
        }

        if (hasError) return;
        fetch(`/admin/update_tax`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                "Accept": "application/json"
            },
            body: JSON.stringify({
                tax: tax,
                tax_id: id
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                toastr.success(data.message);
                const modal = bootstrap.Modal.getInstance(document.getElementById("editTaxModal"));
                modal.hide();
                editTaxForm.reset();
                setTimeout(() => location.reload(), 2000);
            } else {
                toastr.error(data.message || "Failed to update tax.");
            }
        })
        .catch(err => {
            //console.error(err);
            toastr.error("Something went wrong.");
        });
    });
});

</script>

@endsection