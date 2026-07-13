@extends('admin.layout.app')
@section('content')
@php
    $admin = auth('admin')->user();

    $permissions = \App\Models\AdminPermission::where('admin_id', $admin->id)
        ->where('can_action', 1)
        ->pluck('module_id')
        ->toArray();
@endphp


<style>
  #editPreviewImage {
    display: block; 
}
.upload-box {
    width: 220px;
    height: 160px;
    border: 2px dotted #c8ad8d;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    position: relative;
    overflow: hidden;
    cursor: pointer;
}

.upload-icon {
    width: 60px;
    opacity: 0.5;
}

.upload-text {
    margin-top: 10px;
    font-size: 14px;
    color: #444;
}

.preview-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: absolute;
    top: 0;
    left: 0;
    display: none;
}


</style>

<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">{{ __('admin_messages.banner_per_day_charges_for_sellers') }}</h2>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <ul class="nav nav-pills mb-3 tabs-pnl custom" id="pills-tab" role="tablist">
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-order-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order"
                    aria-selected="true">
                    {{ __('admin_messages.home_top') }}
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link active customBtn2 m-0" id="pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="true">
                    {{ __('admin_messages.home_bottom') }}
                </button>
            </li>

            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-return-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-return" type="button" role="tab" aria-controls="pills-return"
                    aria-selected="false">
                    {{ __('admin_messages.sub_category') }}
                </button>
            </li>
             <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-story-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-story" type="button" role="tab" aria-controls="pills-story"
                    aria-selected="false">
                 Story Charges
                </button>
            </li>
        </ul>
    </div>
    <div class="userManagecontent mb-4">
        <div class="tab-content" id="pills-tabContent">
            <!-- Top -->

            <div class="tab-pane fade" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab" tabindex="0">
                <div class="row">
                </div>

                <div class="table-responsive mb-5">
                    <table id="myTable" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('admin_messages.s_no') }}</th>
                                <th scope="col">{{ __('admin_messages.country') }}</th>
                                <th scope="col">{{ __('admin_messages.per_day_charges') }}</th>
                                @if(in_array(13, $permissions) || $admin->type == 1)
                                <th scope="col">{{ __('admin_messages.action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topBanner as $index => $banner)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>
                                    @if(app()->getLocale() == 'en')
                                    {{ $banner['country_info']['name'] }}
                                    @else
                                    {{ $banner['country_info']['name_ar'] }}
                                    @endif
                                </td>
                                <td>{{ $banner['per_day_price'] }} {{ __('admin_messages.kd') }}</td>
                                @if(in_array(13, $permissions) || $admin->type == 1)
                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a href="javascript:void(0);" 
                                            class="table-button edit-banner-btn" 
                                            data-id="{{ $banner['id'] }}" 
                                            data-country-id="{{ $banner['country_id'] }}" 
                                            data-per-day-price="{{ $banner['per_day_price'] }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editBannerModal">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </div>
                                </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">{{ __('admin_messages.no_data_found') }}</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Bottom -->
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                tabindex="0">
                <div class="row">
                    <div class="align-items-end d-flex">
                    </div>
                </div>

                <div class="table-responsive w-100">
                    <table id="myTable1" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('admin_messages.s_no') }}</th>
                                <th scope="col">{{ __('admin_messages.country') }}</th>
                                <th scope="col">{{ __('admin_messages.per_day_charges') }}</th>
                                @if(in_array(13, $permissions) || $admin->type == 1)
                                <th scope="col">{{ __('admin_messages.action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bottomBanner as $index => $banner)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>
                                    @if(app()->getLocale() == 'en')
                                    {{ $banner['country_info']['name'] }}
                                    @else
                                    {{ $banner['country_info']['name_ar'] }}
                                    @endif
                                </td>
                                <td>{{ $banner['per_day_price'] }} {{ __('admin_messages.kd') }}</td>
                                @if(in_array(13, $permissions) || $admin->type == 1)
                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a href="javascript:void(0);" 
                                            class="table-button edit-banner-btn" 
                                            data-id="{{ $banner['id'] }}" 
                                            data-country-id="{{ $banner['country_id'] }}" 
                                            data-per-day-price="{{ $banner['per_day_price'] }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editBannerModal">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </div>
                                </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">{{ __('admin_messages.no_data_found') }}</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>

                </div>
            </div>

            <!-- sub category -->

            <div class="tab-pane fade" id="pills-return" role="tabpanel" aria-labelledby="pills-return-tab"
                tabindex="0">
                <div class="row">
                    <div class="align-items-end d-flex">
                    </div>
                </div>

                <div class="table-responsive w-100">
                    <table id="myTable2" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('admin_messages.s_no') }}</th>
                                <th scope="col">{{ __('admin_messages.country') }}</th>
                                <th scope="col">{{ __('admin_messages.per_day_charges') }}</th>
                                @if(in_array(13, $permissions) || $admin->type == 1)
                                <th scope="col">{{ __('admin_messages.action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subCategoryBanner as $index => $banner)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>
                                    @if(app()->getLocale() == 'en')
                                    {{ $banner['country_info']['name'] }}
                                    @else
                                    {{ $banner['country_info']['name_ar'] }}
                                    @endif
                                </td>
                                <td>{{ $banner['per_day_price'] }} {{ __('admin_messages.kd') }}</td>
                                @if(in_array(13, $permissions) || $admin->type == 1)
                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a href="javascript:void(0);" 
                                            class="table-button edit-banner-btn" 
                                            data-id="{{ $banner['id'] }}" 
                                            data-country-id="{{ $banner['country_id'] }}" 
                                            data-per-day-price="{{ $banner['per_day_price'] }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editBannerModal">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </div>
                                </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">{{ __('admin_messages.no_data_found') }}</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
              <div class="tab-pane fade" id="pills-story" role="tabpanel" aria-labelledby="pills-story-tab"
                tabindex="0">
                <div class="row">
                    <div class="align-items-end d-flex">
                    </div>
                </div>

                <div class="table-responsive w-100">
                   <table id="myTable2" class="table w-100">
    <thead>
        <tr>
            <th scope="col">S.No</th>
            <th scope="col">Country</th>
            <th scope="col">Per Day Charges</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row">1</th>
            <td>India</td>
            <td>15.00 KD</td>
            <td>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="javascript:void(0);" 
                       class="table-button edit-banner-btn" 
                       data-bs-toggle="modal"
                       data-bs-target="#editBannerModal">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                </div>
            </td>
        </tr>

        <tr>
            <th scope="row">2</th>
            <td>Kuwait</td>
            <td>25.50 KD</td>
            <td>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="javascript:void(0);" 
                       class="table-button edit-banner-btn" 
                       data-bs-toggle="modal"
                       data-bs-target="#editBannerModal">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                </div>
            </td>
        </tr>

        <tr>
            <th scope="row">3</th>
            <td>United Arab Emirates</td>
            <td>20.00 KD</td>
            <td>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="javascript:void(0);" 
                       class="table-button edit-banner-btn" 
                       data-bs-toggle="modal"
                       data-bs-target="#editBannerModal">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                </div>
            </td>
        </tr>
    </tbody>
</table>
                </div>
            </div>
        </div>
    </div>

    <!-- End of Content Wrapper -->
</div>

<!-- add new model -->
<div class="modal fade" id="editBannerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <!-- <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1> -->
                <h2 class="h2">{{ __('admin_messages.per_day_charges') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editBannerForm">
                <div class="modal-body m-auto mb-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="hidden" id="editBannerId" name="banner_id">
                            <div class="form-group w-50 m-auto">
                                <label for="from" class="form-label"> {{ __('admin_messages.per_day_price_in_kd') }}</label>
                                <input type="text" class="w-100" id="perDayPrice" name="per_day_price" placeholder="{{ __('admin_messages.enter_per_day_charge') }}" oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/^0+([1-9])/,'$1').replace(/^0+$/,'').replace(/(\..*?)\..*/,'$1').replace(/(\.\d{2}).*/,'$1').replace(/^(\d{7})\d*/,'$1').replace(/^(\d{7}\.\d{2})\d*/,'$1')" class="form-control"
                                    aria-describedby="passwordHelpInline" />
                                <div id="editPerDayPriceError" class="text-danger small" style="display:none;"></div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                                <div class="d-flex align-items-center justify-content-center gap-3 mt-3"
                                    style="margin-top: 30px">
                                    <button type="submit" class="btn btn-dark customBtn">
                                        {{ __('admin_messages.save') }}
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
    const editButtons = document.querySelectorAll(".edit-banner-btn");
    const editReasonForm = document.getElementById("editBannerForm");
    const editBannerIdInput = document.getElementById("editBannerId");
    const editPerDayPriceInput = document.getElementById("perDayPrice");
    const editPerDayPriceError = document.getElementById("editPerDayPriceError");

    editButtons.forEach(btn => {
        btn.addEventListener("click", function() {
            const id = this.getAttribute("data-id");
            const english = this.getAttribute("data-english");
            const perDayPrice = this.getAttribute("data-per-day-price");

            editBannerIdInput.value = id;
            editPerDayPriceInput.value = perDayPrice;

            editPerDayPriceError.style.display = "none";
        });
    });

    editPerDayPriceInput.addEventListener("input", () => {
        editPerDayPriceError.style.display = "none";
    });

    editBannerForm.addEventListener("submit", function(e) {
        e.preventDefault();

        const per_day_price = editPerDayPriceInput.value.trim();
        const banner_id = editBannerIdInput.value;
        let hasError = false;

        if (!per_day_price) {
            editPerDayPriceError.innerText = "{{ __('admin_messages.please_enter_per_day_charge') }}";
            editPerDayPriceError.style.display = "block";
            hasError = true;
        }
        if (hasError) return;

        fetch(`/admin/update_banner`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                "Accept": "application/json"
            },
            body: JSON.stringify({
                per_day_price: per_day_price,
                banner_id: banner_id
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                toastr.success(data.message);
                const modal = bootstrap.Modal.getInstance(document.getElementById("editBannerModal"));
                modal.hide();
                editBannerForm.reset();
                setTimeout(() => location.reload(), 2000);
            } else {
                toastr.error(data.message || "Failed to update banner per day charge.");
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


@endsection