@extends('admin.layout.app')
@section('content')



<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">Affiliate Commission Management </h2>
        </div>
    </div>

    <div class="userManagecontent">
        <div class="mt-4">
            <div class="align-items-end d-flex">
                <!-- <div class="search-box" style="position: relative">
                    <i class="bi bi-search" style="
                        position: absolute;
                        left: 10px;
                        top: 50%;
                        transform: translateY(-50%);
                        font-size: 16px;
                        color: #888;
                      ">
                    </i>
                    <input type="text" class="form-control" placeholder="Search for..." style="padding-left: 35px" />
                </div> -->
            </div>

            <div class="table-responsive mt-5 w-100">
                <table id="myTable" class="table w-100">
                    <thead>
                        <tr>
                            <th scope="col">SR No.</th>
                            <th scope="col">Country Name</th>
                            <th scope="col">Commission Percentage</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($commissionData as $index => $data)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $data['name'] }}</td>
                            <td>
                                {{ 
                                    floor($data['affiliate_commission_info']['commission']) == $data['affiliate_commission_info']['commission']
                                        ? number_format($data['affiliate_commission_info']['commission'], 0)
                                        : number_format($data['affiliate_commission_info']['commission'], 2)
                                }}%
                            </td>
                            <td>
                                <div class="d-flex gap-3 justify-content-center">
                                    <a href="javascript:void(0);" 
                                        class="table-button edit-commission-btn" 
                                        data-id="{{ $data['affiliate_commission_info']['id'] }}" 
                                        data-commission="{{ $data['affiliate_commission_info']['commission'] }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editCommissionModal">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No data found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>






</div>
<div class="modal fade" id="editCommissionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <!-- <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1> -->
                <h2 class="h2">Affiliate Commission Percentage</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCommissionForm">
            <div class="modal-body m-auto mb-4">
                <div class="row">
                    <input type="hidden" id="editCommissionId" name="commission_id">
                    <div class="col-lg-12">
                        <div class="form-group w-100 m-auto">
                            <label for="from" class="form-label">Set Commission</label>
                            <input type="text" name="commission" id="commission" oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/^0+(\d)/,'$1').replace(/^0(\.|$)/,'').replace(/(\..*?)\..*/,'$1').replace(/(\.\d{2}).*/,'$1');if(parseFloat(this.value)>100)this.value='100';" class="w-100" placeholder="Enter Commission" class="form-control"
                                aria-describedby="passwordHelpInline" />
                                <div id="editCommissionError" class="text-danger small" style="display:none;"></div>
                            <span style="
                      position: absolute;
                      right: 8px;
                      top: 69%;
                      transform: translateY(-50%);
                      color: #6c757d;
                      pointer-events: none;
                      font-weight: 500;
                    ">
                                %
                            </span>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                            <div class="d-flex align-items-center justify-content-center gap-3 mt-3"
                                style="margin-top: 30px">
                                <button type="submit" class="btn btn-dark customBtn">
                                    Save
                                </button>
                                <!-- <button type="button" class="btn btn-dark customBtn" href=""> Submit</button> -->
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
document.addEventListener("DOMContentLoaded", function () {

    const editButtons = document.querySelectorAll(".edit-commission-btn");
    const editCommissionForm = document.getElementById("editCommissionForm");
    const editCommissionIdInput = document.getElementById("editCommissionId");
    const editCommissionInput = document.getElementById("commission");
    const editCommissionError = document.getElementById("editCommissionError");

    // Open modal & set values
    editButtons.forEach(btn => {
        btn.addEventListener("click", function () {
            const id = this.getAttribute("data-id");
            const commission = this.getAttribute("data-commission");

            editCommissionIdInput.value = id;
            let commissionValue = parseFloat(commission);

            if (!isNaN(commissionValue)) {
                editCommissionInput.value =
                    Number.isInteger(commissionValue)
                        ? commissionValue
                        : commissionValue.toFixed(2);
            }

            editCommissionError.style.display = "none";
        });
    });

    // Remove error while typing
    editCommissionInput.addEventListener("input", () => {
        editCommissionError.style.display = "none";
    });

    // Form submit
    editCommissionForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const commission = editCommissionInput.value.trim();
        const commission_id = editCommissionIdInput.value;

        if (!commission) {
            editCommissionError.innerText = "Please enter commission";
            editCommissionError.style.display = "block";
            return;
        }

        fetch(`/admin/update_affiliate_commission`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: JSON.stringify({
                commission: commission,
                commission_id: commission_id
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                toastr.success(data.message);

                const modalEl = document.getElementById("editCommissionModal");
                const modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();

                editCommissionForm.reset();

                setTimeout(() => location.reload(), 1500);
            } else {
                toastr.error(data.message || "Failed to update commission.");
            }
        })
        .catch(err => {
            console.error(err);
            toastr.error("Something went wrong.");
        });
    });
});
</script>



@endsection