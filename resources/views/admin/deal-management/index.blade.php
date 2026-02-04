@extends('admin.layout.app')
@section('content')
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
            <h2 class="h2">Deals Management</h2>
        </div>

        <div class="col-lg-3 col-md-4 col-12">
            <div class="d-flex justify-content-end">
                <a class="btn btn-dark customBtn" data-bs-toggle="modal" data-bs-target="#sentModal2">
                    <span>Add Deals</span>
                </a>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <ul class="nav nav-pills mb-3 tabs-pnl custom" id="pills-tab" role="tablist">
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-order-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order"
                    aria-selected="true">
                    Active
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link active customBtn2 m-0" id="pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="true">
                    Expired
                </button>
            </li>
        </ul>
    </div>
    <div class="userManagecontent">
        <div class="tab-content" id="pills-tabContent">
            <!-- Exchange -->

            <div class="tab-pane fade" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab" tabindex="0">
                <div class="row">
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
                            <input type="text" class="form-control" placeholder="Search for..."
                                style="padding-left: 35px" />
                        </div> -->
                    </div>
                </div>

                <div class="table-responsive mb-5 w-100">
                    <table id="myTable" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Banner</th>
                                <th scope="col">Deal Name</th>
                                <th scope="col">Discount Percentage</th>
                                <th scope="col">Category</th>
                                <th scope="col">Sub-category</th>
                                <th scope="col">Start From</th>
                                <th scope="col">End To</th>
                                <th scope="col">Number of Sellers Enrolled</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activeDeals as $index => $deal)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>
                                    <img src="{{ $deal['image'] }}" alt="" width="40px" height="40px" class="square" />
                                </td>
                                <td>{{ $deal['name_english'] }}</td>
                                <td>{{ $deal['discount'] }}%</td>
                                <td>{{ $deal['category_details']['name'] }}</td>
                                <td>
                                    {{ collect($deal['subCategory_details'])->pluck('name_english')->implode(', ') }}
                                </td>

                                <td>{{ $deal['from'] }}</td>
                                <td>{{ $deal['to'] }}</td>
                                <td class="short-title">
                                    <a href="{{ route('admin.sellerList', ['id' => $deal['id']]) }}"
                                        class="text">{{ $deal['seller_enrolled']['seller_count'] ?? 0 }} Seller</a>
                                </td>
                                <td>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <a href="javascript:void(0);" class="table-button edit-deal-btn"
                                            data-id="{{ $deal->id }}" data-name-english="{{ $deal->name_english }}"
                                            data-name-arabic="{{ $deal->name_arabic }}"
                                            data-category-id="{{ $deal->category_id }}"
                                            data-sub-category-id="{{ implode(',', $deal->sub_category_id) }}"
                                            data-discount="{{ $deal->discount }}" data-from="{{ $deal->from }}"
                                            data-to="{{ $deal->to }}" data-image="{{ $deal->image }}"
                                            data-bs-toggle="modal" data-bs-target="#editModalDeal">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <a href="javascript:void(0);"
                                            class="table-button text-danger deleteDeal mb-1 mt-1"
                                            data-id="{{ $deal->id }}">
                                            <i class="bi bi-trash3-fill"></i>
                                        </a>

                                        <div class="form-check form-switch" style="justify-content: center;">
                                            <input class="form-check-input toggleStatus" type="checkbox"
                                                id="flexSwitchCheckChecked{{ $deal['id'] }}" data-id="{{ $deal['id'] }}"
                                                {{ $deal['status'] == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="flexSwitchCheckChecked{{ $deal['id'] }}"></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No data found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Return -->
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                tabindex="0">
                <div class="row">
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
                            <input type="text" class="form-control" placeholder="Search for..."
                                style="padding-left: 35px" />
                        </div> -->
                    </div>
                </div>

                <div class="table-responsive mb-5 w-100">
                    <table id="myTable1" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Banner</th>
                                <th scope="col">Deal Name</th>
                                <th scope="col">Discount Percentage</th>
                                <th scope="col">Category</th>
                                <th scope="col">Sub-category</th>
                                <th scope="col">Start From</th>
                                <th scope="col">End To</th>
                                <th scope="col">Number of Sellers Enrolled</th>
                                <th scope="col">Revenue Generated</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expiredDeals as $index => $deal)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>
                                    <img src="{{ $deal['image'] }}" alt="" width="40px" height="40px" class="square" />
                                </td>
                                <td>{{ $deal['name_english'] }}</td>
                                <td>{{ $deal['discount'] }}%</td>
                                <td>{{ $deal['category_details']['name'] }}</td>
                                <td>
                                    {{ collect($deal['subCategory_details'])->pluck('name_english')->implode(', ') }}
                                </td>

                                <td>{{ $deal['from'] }}</td>
                                <td>{{ $deal['to'] }}</td>
                                <td class="short-title">
                                    <a href="{{ route('admin.sellerList', ['id' => $deal['id']]) }}"
                                        class="text">{{ $deal['seller_enrolled']['seller_count'] ?? 0 }} Seller</a>
                                </td>

                                <td>0 KD</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No data found</td>
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



<div class="modal fade" id="sentModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0 p-2">
                <h2 class="h2">Add Deals</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container dealheight">
                    <div class="row">

                        <!-- Image Upload -->
                        <div class="col-lg-12">
                            <div class="upload-title text-center">Upload Image</div>
                            <label for="fileUpload" class="upload-box" style="cursor:pointer;">
                                <img src="/admin/image/imge-upload.svg" id="uploadIcon" />
                                <img id="previewImage" class="preview-image"
                                    style="display:none; max-width:216px; margin-top:-2px;" />
                                <div class="upload-text">Upload Image</div>
                                <input type="file" id="fileUpload" name="image" accept="image/*" hidden />
                            </label>
                            <div class="text-danger" id="imageError"></div>
                        </div>

                        <!-- Name English -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label" for="name">Name (English)</label>
                                <input type="text" name="name_english" class="form-control"
                                    placeholder="Enter Deal Name in English"
                                    oninput="this.value=this.value.replace(/[^A-Za-z0-9 ]/g,'').replace(/^\s+/,'')" />
                                <div class="text-danger" id="nameEnError"></div>
                            </div>
                        </div>

                        <!-- Name Arabic -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label" for="name">Name (Arabic)</label>
                                <input type="text" name="name_arabic" class="form-control"
                                    placeholder="Enter Deal Name in Arabic"
                                    oninput="this.value=this.value.replace(/[^A-Za-z0-9\u0600-\u06FF ]/g,'').replace(/^\s+/,'')" />
                                <div class="text-danger" id="nameArError"></div>
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <label for="category" class="form-label">Select Category</label>
                            <div class="d-flex gap-4 align-items-center">
                                @foreach($categories as $index => $category)
                                <div class="form-check">
                                    <input class="form-check-input category-radio" type="radio" name="category"
                                        id="category{{ $index }}" value="{{ $category->id }}">
                                    <label class="form-check-label" for="category{{ $index }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            <div class="text-danger" id="categoryError"></div>
                        </div>

                        <!-- Subcategory -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group w-100">
                                <label for="subCategory" class="form-label">Select Sub-Category</label>
                                <!-- <select class="form-select form-select-lg" id="subCategorySelect"
                                    aria-label="Large select example">
                                    <option selected>Select Sub-Category</option>
                                </select> -->
                              
                                <select id="subCategorySelect" multiple="multiple" class="form-select">
                                    <!-- <option selected>Select Sub-Category</option> -->
                                </select>

                                <div class="text-danger" id="subCategoryError"></div>
                            </div>
                        </div>

                        <!-- Discount -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group w-100">
                                <label class="form-label" for="discount">Discount %</label>
                                <input type="text" name="discount" class="form-control" placeholder="Enter Discount"
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^\s+|^0+/,'');if(this.value>100)this.value=100;" />
                                <div class="text-danger" id="discountError"></div>
                            </div>
                        </div>

                        <!-- Dates -->
                        <div class="col-lg-12">
                            <div class="d-flex gap-2">

                                <div class="col-lg-6">
                                    <div class="form-group mt-0 w-100">
                                        <label for="fromDate" class="form-label">From:</label>
                                        <input type="date" id="fromDate" class="form-control" />
                                        <div class="text-danger" id="fromDateError"></div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mt-0 w-100">
                                        <label for="toDate" class="form-label">To:</label>
                                        <input type="date" id="toDate" class="form-control" />
                                        <div class="text-danger" id="toDateError"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                            <a type="button" id="submitDealBtn" class="btn btn-dark customBtn mt-3">Submit</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- edit modal -->
<div class="modal fade" id="editModalDeal" tabindex="-1" aria-labelledby="editModalDealLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Edit Deal</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container dealheight">
                    <div class="row">

                        <!-- Image Upload -->
                        <div class="col-lg-12">
                            <div class="upload-title text-center">Upload Image</div>
                            <label for="editFileUpload" class="upload-box" style="cursor:pointer;">
                                <img src="/admin/image/imge-upload.svg" id="editUploadIcon" />
                                <img id="editPreviewImage" class="preview-image"
                                    style="display:none; max-width:216px; margin-top:-2px;" />
                                <div class="upload-text">Upload Image</div>
                                <input type="file" id="editFileUpload" name="image" accept="image/*" hidden />
                            </label>
                            <div class="text-danger" id="editImageError"></div>
                        </div>

                        <!-- Name English -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label" for="editNameEnglish">Name (English)</label>
                                <input type="text" name="name_english" class="form-control" id="editNameEnglish"
                                    placeholder="Enter Deal Name in English"
                                    oninput="this.value=this.value.replace(/[^A-Za-z0-9 ]/g,'').replace(/^\s+/,'')" />
                                <div class="text-danger" id="editNameEnError"></div>
                            </div>
                        </div>

                        <!-- Name Arabic -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label" for="editNameArabic">Name (Arabic)</label>
                                <input type="text" name="name_arabic" class="form-control" id="editNameArabic"
                                    placeholder="Enter Deal Name in Arabic"
                                    oninput="this.value=this.value.replace(/[^A-Za-z0-9\u0600-\u06FF ]/g,'').replace(/^\s+/,'')" />
                                <div class="text-danger" id="editNameArError"></div>
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <label class="form-label">Select Category</label>
                            <div class="d-flex gap-4 align-items-center" id="editCategories">
                                @foreach($categories as $index => $category)
                                <div class="form-check">
                                    <input class="form-check-input edit-category-radio" type="radio"
                                        name="edit_category" id="editCategory{{ $index }}" value="{{ $category->id }}">
                                    <label class="form-check-label" for="editCategory{{ $index }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            <div class="text-danger" id="editCategoryError"></div>
                        </div>

                        <!-- Subcategory -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group w-100">
                                <label for="editSubCategorySelect" class="form-label">Select Sub-Category</label>
                                <!-- <select class="form-select form-select-lg" id="editSubCategorySelect"
                                    aria-label="Large select example">
                                    <option selected>Select Sub-Category</option>
                                </select> -->   

                                <select id="editSubCategorySelect" multiple="multiple" class="form-select">
                                    <!-- <option selected>Select Sub-Category</option> -->
                                </select>

                                <div class="text-danger" id="editSubCategoryError"></div>
                            </div>
                        </div>

                        <!-- Discount -->
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group w-100">
                                <label class="form-label" for="editDiscount">Discount %</label>
                                <input type="text" name="discount" class="form-control" id="editDiscount"
                                    placeholder="Enter Discount"
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/^\s+|^0+/,'');if(this.value>100)this.value=100;" />
                                <div class="text-danger" id="editDiscountError"></div>
                            </div>
                        </div>

                        <!-- Dates -->
                        <div class="col-lg-12">
                            <div class="d-flex gap-2">

                                <div class="col-lg-6">
                                    <div class="form-group mt-0  w-100">
                                        <label for="editFromDate" class="form-label">From:</label>
                                        <input type="date" id="editFromDate" class="form-control" />
                                        <div class="text-danger" id="editFromDateError"></div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mt-0 w-100">
                                        <label for="editToDate" class="form-label">To:</label>
                                        <input type="date" id="editToDate" class="form-control" />
                                        <div class="text-danger" id="editToDateError"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                            <a type="button" id="submitEditDealBtn" class="btn btn-dark customBtn mt-3">Save Changes</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<!-- <script>
    $(document).ready(function () {
        $('#subCategorySelect').multiselect({
            includeSelectAllOption: true,   
            onInitialized: function (select, container) {
            container.find('button.multiselect')
                .attr('data-bs-toggle', 'dropdown');                                    
            }
        });
    });

</script> -->

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


<!-- add deal -->
<!-- <script>
document.addEventListener('DOMContentLoaded', function() {

    const previewImage = document.getElementById('previewImage');
    const uploadIcon = document.getElementById('uploadIcon');
    const fileUpload = document.getElementById('fileUpload');
    const submitBtn = document.getElementById('submitDealBtn');
    // console.log(submitBtn);

    const nameEnError = document.getElementById('nameEnError');
    const nameArError = document.getElementById('nameArError');
    const categoryError = document.getElementById('categoryError');
    const subCategoryError = document.getElementById('subCategoryError');
    const discountError = document.getElementById('discountError');
    const fromDateError = document.getElementById('fromDateError');
    const toDateError = document.getElementById('toDateError');
    const imageError = document.getElementById('imageError');

    const subCategorySelect = document.getElementById('subCategorySelect');

    /* ===== Image Preview ===== */
    fileUpload.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
                uploadIcon.style.display = 'none';
            }
            reader.readAsDataURL(file);
        }
        imageError.innerText = '';
    });

    /* ===== Clear errors on input/change ===== */
    document.querySelector('input[name="name_english"]').addEventListener('input', () => nameEnError.innerText =
        '');
    document.querySelector('input[name="name_arabic"]').addEventListener('input', () => nameArError.innerText =
        '');
    subCategorySelect.addEventListener('change', () => subCategoryError.innerText = '');
    document.querySelector('input[name="discount"]').addEventListener('input', () => discountError.innerText =
        '');
    document.getElementById('fromDate').addEventListener('change', () => fromDateError.innerText = '');
    document.getElementById('toDate').addEventListener('change', () => toDateError.innerText = '');
    fileUpload.addEventListener('change', () => imageError.innerText = '');
    document.querySelectorAll('.category-radio').forEach(radio => {
        radio.addEventListener('change', () => categoryError.innerText = '');
    });

    /* ===== Fetch Subcategories on Category Select ===== */
        // document.querySelectorAll('.category-radio').forEach(radio => {
        //     radio.addEventListener('change', function() {
        //         const categoryId = this.value;

        //         subCategorySelect.innerHTML = '<option selected>Select Sub-Category</option>';
        //         subCategoryError.innerText = '';

        //         if (!categoryId) return;

        //         fetch(`/admin/getSubCategories/${categoryId}`)
        //             .then(res => res.json())
        //             .then(data => {
        //                 if (data.status === 'success' && data.data.data.length > 0) {
        //                     data.data.data.forEach(sub => {
        //                         const option = document.createElement('option');
        //                         option.value = sub.id;
        //                         option.textContent = sub.name_english;
        //                         subCategorySelect.appendChild(option);
        //                     });
        //                 } else {
        //                     subCategorySelect.innerHTML =
        //                         '<option selected>No subcategories found</option>';
        //                 }
        //             })
        //             .catch(err => {
        //                 console.error(err);
        //                 subCategorySelect.innerHTML =
        //                     '<option selected>Error fetching subcategories</option>';
        //             });
        //     });
        // });

        $(function () {
            const $subCategory = $('#subCategorySelect').multiselect({
            includeSelectAllOption: true,
            nonSelectedText: 'Select Sub-Category',
            onInitialized: function (_, c) {
                c.find('button.multiselect')
                .attr('data-bs-toggle', 'dropdown');
            }
        });

        document.querySelectorAll('.category-radio').forEach(radio => {
            radio.addEventListener('change', function () {
                const categoryId = this.value;
                // clear old options
                $('#subCategorySelect').empty();
                $('#subCategorySelect').multiselect('rebuild');

                if (!categoryId) return;

                fetch(`/admin/getSubCategories/${categoryId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success' && data.data.data.length) {
                    data.data.data.forEach(sub => {
                        $('#subCategorySelect').append(
                        `<option value="${sub.id}">${sub.name_english}</option>`
                        );
                    });

                    } else {
                    $('#subCategorySelect')
                        .append('<option disabled>No subcategories found</option>');
                    }
                    $('#subCategorySelect').multiselect('rebuild');
                })
                .catch(() => {
                    $('#subCategorySelect')
                    .append('<option disabled>Error fetching subcategories</option>')
                    .multiselect('rebuild');
                });
            });
        });

        });


    /* ===== Submit Form ===== */
    submitBtn.addEventListener('click', function() {

        nameEnError.innerText = '';
        nameArError.innerText = '';
        categoryError.innerText = '';
        subCategoryError.innerText = '';
        discountError.innerText = '';
        fromDateError.innerText = '';
        toDateError.innerText = '';
        imageError.innerText = '';

        let hasError = false;

        const nameEnglish = document.querySelector('input[name="name_english"]').value.trim();
        const nameArabic = document.querySelector('input[name="name_arabic"]').value.trim();
        const category = document.querySelector('input[name="category"]:checked');
        const subCategory = subCategorySelect.value;
        const discount = document.querySelector('input[name="discount"]').value.trim();
        const fromDate = document.getElementById('fromDate').value;
        const toDate = document.getElementById('toDate').value;

        if (!nameEnglish) {
            nameEnError.innerText = 'Please enter name in English';
            hasError = true;
        }
        if (!nameArabic) {
            nameArError.innerText = 'Please enter name in Arabic';
            hasError = true;
        }
        if (!category) {
            categoryError.innerText = 'Please select a category';
            hasError = true;
        }
        if (!subCategory || subCategory === 'Select Sub-Category') {
            subCategoryError.innerText = 'Please select a subcategory';
            hasError = true;
        }
        if (!discount) {
            discountError.innerText = 'Please enter discount';
            hasError = true;
        }
        if (!fromDate) {
            fromDateError.innerText = 'Please select from date';
            hasError = true;
        }
        if (!toDate) {
            toDateError.innerText = 'Please select to date';
            hasError = true;
        }
        if (fileUpload.files.length === 0) {
            imageError.innerText = 'Please upload an image';
            hasError = true;
        }

        if (hasError) return;

        const formData = new FormData();
        formData.append('name_english', nameEnglish);
        formData.append('name_arabic', nameArabic);
        formData.append('category_id', category.value);
        formData.append('sub_category_id', subCategory);
        formData.append('discount', discount);
        formData.append('from', fromDate);
        formData.append('to', toDate);
        formData.append('image', fileUpload.files[0]);
        // console.log(formData);


        fetch('{{ url("admin/submitDeal") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    toastr.success(data.message);
                    setTimeout(() => {
                        $('#sentModal2').modal('hide');
                        location.reload();
                    }, 1500);
                } else {
                    toastr.error(data.message || 'Something went wrong.');
                }
            })
            //.catch((error) => toastr.error('Server error'));
            .catch((error) => {
                console.log(error);
            });

    });

});
</script> -->
<script>
document.addEventListener('DOMContentLoaded', function() {

    const previewImage = document.getElementById('previewImage');
    const uploadIcon = document.getElementById('uploadIcon');
    const fileUpload = document.getElementById('fileUpload');
    const submitBtn = document.getElementById('submitDealBtn');

    const nameEnError = document.getElementById('nameEnError');
    const nameArError = document.getElementById('nameArError');
    const categoryError = document.getElementById('categoryError');
    const subCategoryError = document.getElementById('subCategoryError');
    const discountError = document.getElementById('discountError');
    const fromDateError = document.getElementById('fromDateError');
    const toDateError = document.getElementById('toDateError');
    const imageError = document.getElementById('imageError');

    const subCategorySelect = document.getElementById('subCategorySelect');

    /* ===== Image Preview ===== */
    fileUpload.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
                uploadIcon.style.display = 'none';
            }
            reader.readAsDataURL(file);
        }
        imageError.innerText = '';
    });

    /* ===== Clear errors on input/change ===== */
    document.querySelector('input[name="name_english"]').addEventListener('input', () => nameEnError.innerText = '');
    document.querySelector('input[name="name_arabic"]').addEventListener('input', () => nameArError.innerText = '');
    subCategorySelect.addEventListener('change', () => subCategoryError.innerText = '');
    document.querySelector('input[name="discount"]').addEventListener('input', () => discountError.innerText = '');
    document.getElementById('fromDate').addEventListener('change', () => fromDateError.innerText = '');
    document.getElementById('toDate').addEventListener('change', () => toDateError.innerText = '');
    fileUpload.addEventListener('change', () => imageError.innerText = '');
    document.querySelectorAll('.category-radio').forEach(radio => {
        radio.addEventListener('change', () => categoryError.innerText = '');
    });

    /* ===== Fetch Subcategories on Category Select (with multiselect rebuild) ===== */
    $(function () {
        const $subCategory = $('#subCategorySelect').multiselect({
            includeSelectAllOption: true,
            nonSelectedText: 'Select Sub-Category',
            onInitialized: function (_, c) {
                c.find('button.multiselect').attr('data-bs-toggle', 'dropdown');
            }
        });

        document.querySelectorAll('.category-radio').forEach(radio => {
            radio.addEventListener('change', function () {
                const categoryId = this.value;

                // Clear old options
                $('#subCategorySelect').empty();
                $('#subCategorySelect').multiselect('rebuild');

                if (!categoryId) return;

                fetch(`/admin/getSubCategories/${categoryId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success' && data.data.data.length) {
                            data.data.data.forEach(sub => {
                                $('#subCategorySelect').append(
                                    `<option value="${sub.id}">${sub.name_english}</option>`
                                );
                            });
                        } else {
                            $('#subCategorySelect').append('<option disabled>No subcategories found</option>');
                        }
                        $('#subCategorySelect').multiselect('rebuild');
                    })
                    .catch(() => {
                        $('#subCategorySelect')
                            .append('<option disabled>Error fetching subcategories</option>')
                            .multiselect('rebuild');
                    });
            });
        });
    });

    /* ===== Submit Form ===== */
    submitBtn.addEventListener('click', function() {

        // Reset errors
        nameEnError.innerText = '';
        nameArError.innerText = '';
        categoryError.innerText = '';
        subCategoryError.innerText = '';
        discountError.innerText = '';
        fromDateError.innerText = '';
        toDateError.innerText = '';
        imageError.innerText = '';

        let hasError = false;

        const nameEnglish = document.querySelector('input[name="name_english"]').value.trim();
        const nameArabic = document.querySelector('input[name="name_arabic"]').value.trim();
        const category = document.querySelector('input[name="category"]:checked');
        const subCategory = Array.from(subCategorySelect.selectedOptions).map(option => option.value); // <-- Array
        const discount = document.querySelector('input[name="discount"]').value.trim();
        const fromDate = document.getElementById('fromDate').value;
        const toDate = document.getElementById('toDate').value;

        // Validation
        if (!nameEnglish) { nameEnError.innerText = 'Please enter name in English'; hasError = true; }
        if (!nameArabic) { nameArError.innerText = 'Please enter name in Arabic'; hasError = true; }
        if (!category) { categoryError.innerText = 'Please select a category'; hasError = true; }
        if (!subCategory.length) { subCategoryError.innerText = 'Please select a subcategory'; hasError = true; }
        if (!discount) { discountError.innerText = 'Please enter discount'; hasError = true; }
        if (!fromDate) { fromDateError.innerText = 'Please select from date'; hasError = true; }
        if (!toDate) { toDateError.innerText = 'Please select to date'; hasError = true; }
        if (fileUpload.files.length === 0) { imageError.innerText = 'Please upload an image'; hasError = true; }

        if (hasError) return;

        // Build FormData
        const formData = new FormData();
        formData.append('name_english', nameEnglish);
        formData.append('name_arabic', nameArabic);
        formData.append('category_id', category.value);
        subCategory.forEach(id => formData.append('sub_category_id[]', id)); // <-- Send as array
        formData.append('discount', discount);
        formData.append('from', fromDate);
        formData.append('to', toDate);
        formData.append('image', fileUpload.files[0]);

        // Submit form via fetch
        fetch('{{ url("admin/submitDeal") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                toastr.success(data.message);
                setTimeout(() => {
                    $('#sentModal2').modal('hide');
                    location.reload();
                }, 1500);
            } else {
                toastr.error(data.message || 'Something went wrong.');
            }
        })
        .catch(error => { console.log(error); });

    });

});
</script>


<!-- edit deal -->
<!-- <script>
document.addEventListener('DOMContentLoaded', function() {

    const editModal = document.getElementById('editModalDeal');
    const editPreviewImage = document.getElementById('editPreviewImage');
    const editUploadIcon = document.getElementById('editUploadIcon');
    const editFileUpload = document.getElementById('editFileUpload');
    const submitEditBtn = document.getElementById('submitEditDealBtn');

    const editNameEnError = document.getElementById('editNameEnError');
    const editNameArError = document.getElementById('editNameArError');
    const editCategoryError = document.getElementById('editCategoryError');
    const editSubCategoryError = document.getElementById('editSubCategoryError');
    const editDiscountError = document.getElementById('editDiscountError');
    const editFromDateError = document.getElementById('editFromDateError');
    const editToDateError = document.getElementById('editToDateError');
    const editImageError = document.getElementById('editImageError');

    const editSubCategorySelect = document.getElementById('editSubCategorySelect');

    /* ===== Populate Modal on Open ===== */
    editModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;

        // Deal data from button
        const id = button.getAttribute('data-id');
        const nameEnglish = button.getAttribute('data-name-english');
        const nameArabic = button.getAttribute('data-name-arabic');
        const categoryId = button.getAttribute('data-category-id');
        const subCategoryId = button.getAttribute('data-sub-category-id');
        const discount = button.getAttribute('data-discount');
        const from = button.getAttribute('data-from');
        const to = button.getAttribute('data-to');
        const image = button.getAttribute('data-image');

        // Fill inputs
        document.getElementById('editNameEnglish').value = nameEnglish;
        document.getElementById('editNameArabic').value = nameArabic;
        document.getElementById('editDiscount').value = discount;
        document.getElementById('editFromDate').value = from;
        document.getElementById('editToDate').value = to;

        // Image preview
        if (image) {
            editPreviewImage.src = image;
            editPreviewImage.style.display = 'block';
            editUploadIcon.style.display = 'none';
        } else {
            editPreviewImage.style.display = 'none';
            editUploadIcon.style.display = 'block';
        }

        // Select category radio
        document.querySelectorAll('.edit-category-radio').forEach(radio => {
            radio.checked = radio.value == categoryId;
        });

        // Fetch subcategories
        fetch(`/admin/getSubCategories/${categoryId}`)
            .then(res => res.json())
            .then(data => {
                editSubCategorySelect.innerHTML = '';
                if (data.status === 'success' && data.data.data.length > 0) {
                    data.data.data.forEach(sub => {
                        const option = document.createElement('option');
                        option.value = sub.id;
                        option.textContent = sub.name_english;
                        if (sub.id == subCategoryId) option.selected = true;
                        editSubCategorySelect.appendChild(option);
                    });
                } else {
                    editSubCategorySelect.innerHTML =
                        '<option selected>No subcategories found</option>';
                }
            });

        // Store deal ID in submit button
        submitEditBtn.dataset.id = id;

        // Clear errors
        editNameEnError.innerText = '';
        editNameArError.innerText = '';
        editCategoryError.innerText = '';
        editSubCategoryError.innerText = '';
        editDiscountError.innerText = '';
        editFromDateError.innerText = '';
        editToDateError.innerText = '';
        editImageError.innerText = '';
    });

    /* ===== Image Preview ===== */
    editFileUpload.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                editPreviewImage.src = e.target.result;
                editPreviewImage.style.display = 'block';
                editUploadIcon.style.display = 'none';
            }
            reader.readAsDataURL(file);
        }
        editImageError.innerText = '';
    });

    /* ===== Clear errors on input/change ===== */
    document.getElementById('editNameEnglish').addEventListener('input', () => editNameEnError.innerText = '');
    document.getElementById('editNameArabic').addEventListener('input', () => editNameArError.innerText = '');
    editSubCategorySelect.addEventListener('change', () => editSubCategoryError.innerText = '');
    document.getElementById('editDiscount').addEventListener('input', () => editDiscountError.innerText = '');
    document.getElementById('editFromDate').addEventListener('change', () => editFromDateError.innerText = '');
    document.getElementById('editToDate').addEventListener('change', () => editToDateError.innerText = '');
    editFileUpload.addEventListener('change', () => editImageError.innerText = '');
    document.querySelectorAll('.edit-category-radio').forEach(radio => {
        radio.addEventListener('change', () => editCategoryError.innerText = '');
    });

    /* ===== Update Subcategories on Category Change ===== */
    document.querySelectorAll('.edit-category-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            const categoryId = this.value;
            editSubCategorySelect.innerHTML = '<option selected>Loading...</option>';
            editSubCategoryError.innerText = '';

            fetch(`/admin/getSubCategories/${categoryId}`)
                .then(res => res.json())
                .then(data => {
                    editSubCategorySelect.innerHTML = '';
                    if (data.status === 'success' && data.data.data.length > 0) {
                        data.data.data.forEach(sub => {
                            const option = document.createElement('option');
                            option.value = sub.id;
                            option.textContent = sub.name_english;
                            editSubCategorySelect.appendChild(option);
                        });
                    } else {
                        editSubCategorySelect.innerHTML =
                            '<option selected>No subcategories found</option>';
                    }
                })
                .catch(err => {
                    console.error(err);
                    editSubCategorySelect.innerHTML =
                        '<option selected>Error fetching subcategories</option>';
                });
        });
    });

    /* ===== Submit Edit Deal ===== */
    submitEditBtn.addEventListener('click', function() {
        const id = this.dataset.id;

        // Reset errors
        editNameEnError.innerText = '';
        editNameArError.innerText = '';
        editCategoryError.innerText = '';
        editSubCategoryError.innerText = '';
        editDiscountError.innerText = '';
        editFromDateError.innerText = '';
        editToDateError.innerText = '';
        editImageError.innerText = '';

        let hasError = false;

        const nameEnglish = document.getElementById('editNameEnglish').value.trim();
        const nameArabic = document.getElementById('editNameArabic').value.trim();
        const categoryRadio = document.querySelector('.edit-category-radio:checked');
        const categoryId = categoryRadio ? categoryRadio.value : '';
        const subCategoryId = editSubCategorySelect.value;
        const discount = document.getElementById('editDiscount').value.trim();
        const from = document.getElementById('editFromDate').value;
        const to = document.getElementById('editToDate').value;

        if (!nameEnglish) {
            editNameEnError.innerText = 'Please enter name in English';
            hasError = true;
        }
        if (!nameArabic) {
            editNameArError.innerText = 'Please enter name in Arabic';
            hasError = true;
        }
        if (!categoryId) {
            editCategoryError.innerText = 'Please select a category';
            hasError = true;
        }
        if (!subCategoryId || subCategoryId === 'Select Sub-Category') {
            editSubCategoryError.innerText = 'Please select a subcategory';
            hasError = true;
        }
        if (!discount) {
            editDiscountError.innerText = 'Please enter discount';
            hasError = true;
        }
        if (!from) {
            editFromDateError.innerText = 'Please select from date';
            hasError = true;
        }
        if (!to) {
            editToDateError.innerText = 'Please select to date';
            hasError = true;
        }

        if (hasError) return;

        const formData = new FormData();
        formData.append('name_english', nameEnglish);
        formData.append('name_arabic', nameArabic);
        formData.append('category_id', categoryId);
        formData.append('sub_category_id', subCategoryId);
        formData.append('discount', discount);
        formData.append('from', from);
        formData.append('to', to);
        if (editFileUpload.files[0]) formData.append('image', editFileUpload.files[0]);

        fetch(`/admin/updateDeal/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    toastr.success(data.message);
                    setTimeout(() => {
                        $('#editModalDeal').modal('hide');
                        location.reload();
                    }, 1500);
                } else {
                    toastr.error(data.message || 'Something went wrong.');
                }
            })
            .catch(err => {
                console.error(err);
                toastr.error('Server error');
            });
    });

});
</script> -->

<script>
document.addEventListener('DOMContentLoaded', function() {

    const editModal = document.getElementById('editModalDeal');
    const editPreviewImage = document.getElementById('editPreviewImage');
    const editUploadIcon = document.getElementById('editUploadIcon');
    const editFileUpload = document.getElementById('editFileUpload');
    const submitEditBtn = document.getElementById('submitEditDealBtn');

    const editNameEnError = document.getElementById('editNameEnError');
    const editNameArError = document.getElementById('editNameArError');
    const editCategoryError = document.getElementById('editCategoryError');
    const editSubCategoryError = document.getElementById('editSubCategoryError');
    const editDiscountError = document.getElementById('editDiscountError');
    const editFromDateError = document.getElementById('editFromDateError');
    const editToDateError = document.getElementById('editToDateError');
    const editImageError = document.getElementById('editImageError');

    const editSubCategorySelect = document.getElementById('editSubCategorySelect');

    /* ===== Initialize Bootstrap Multiselect (Checkboxes + Select All) ===== */
    $(editSubCategorySelect).multiselect({
        includeSelectAllOption: true,
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        nonSelectedText: 'Select Sub-Category',
        buttonWidth: '100%',
        onInitialized: function(_, c) {
            c.find('button.multiselect').attr('data-bs-toggle', 'dropdown');
        }
    });

    /* ===== Populate Modal on Open ===== */
    editModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;

        // Deal data from button
        const id = button.getAttribute('data-id');
        const nameEnglish = button.getAttribute('data-name-english');
        const nameArabic = button.getAttribute('data-name-arabic');
        const categoryId = button.getAttribute('data-category-id');
        const subCategoryIdJson = button.getAttribute('data-sub-category-id'); // JSON string: ["32","31"]
        const discount = button.getAttribute('data-discount');
        const from = button.getAttribute('data-from');
        const to = button.getAttribute('data-to');
        const image = button.getAttribute('data-image');

        // Fill inputs
        document.getElementById('editNameEnglish').value = nameEnglish;
        document.getElementById('editNameArabic').value = nameArabic;
        document.getElementById('editDiscount').value = discount;
        document.getElementById('editFromDate').value = from;
        document.getElementById('editToDate').value = to;

        // Image preview
        if (image) {
            editPreviewImage.src = image;
            editPreviewImage.style.display = 'block';
            editUploadIcon.style.display = 'none';
        } else {
            editPreviewImage.style.display = 'none';
            editUploadIcon.style.display = 'block';
        }

        // Select category radio
        document.querySelectorAll('.edit-category-radio').forEach(radio => {
            radio.checked = radio.value == categoryId;
        });

        // Parse subcategories JSON
        let selectedSubCategories = [];
        try {
            selectedSubCategories = JSON.parse(subCategoryIdJson); // ["32","31","30"]
        } catch (e) {
            selectedSubCategories = [];
        }

        // Fetch subcategories and mark selected ones
        fetch(`/admin/getSubCategories/${categoryId}`)
            .then(res => res.json())
            .then(data => {
                editSubCategorySelect.innerHTML = '';
                if (data.status === 'success' && data.data.data.length > 0) {
                    data.data.data.forEach(sub => {
                        const option = document.createElement('option');
                        option.value = sub.id;
                        option.textContent = sub.name_english;
                        if (selectedSubCategories.includes(sub.id.toString())) {
                            option.selected = true;
                        }
                        editSubCategorySelect.appendChild(option);
                    });
                } else {
                    editSubCategorySelect.innerHTML =
                        '<option disabled>No subcategories found</option>';
                }

                // Rebuild Bootstrap Multiselect to show checkboxes and select all
                $(editSubCategorySelect).multiselect('rebuild');
            })
            .catch(err => {
                console.error(err);
                editSubCategorySelect.innerHTML =
                    '<option disabled>Error fetching subcategories</option>';
                $(editSubCategorySelect).multiselect('rebuild');
            });

        // Store deal ID in submit button
        submitEditBtn.dataset.id = id;

        // Clear errors
        editNameEnError.innerText = '';
        editNameArError.innerText = '';
        editCategoryError.innerText = '';
        editSubCategoryError.innerText = '';
        editDiscountError.innerText = '';
        editFromDateError.innerText = '';
        editToDateError.innerText = '';
        editImageError.innerText = '';
    });

    /* ===== Image Preview ===== */
    editFileUpload.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                editPreviewImage.src = e.target.result;
                editPreviewImage.style.display = 'block';
                editUploadIcon.style.display = 'none';
            }
            reader.readAsDataURL(file);
        }
        editImageError.innerText = '';
    });

    /* ===== Clear errors on input/change ===== */
    document.getElementById('editNameEnglish').addEventListener('input', () => editNameEnError.innerText = '');
    document.getElementById('editNameArabic').addEventListener('input', () => editNameArError.innerText = '');
    editSubCategorySelect.addEventListener('change', () => editSubCategoryError.innerText = '');
    document.getElementById('editDiscount').addEventListener('input', () => editDiscountError.innerText = '');
    document.getElementById('editFromDate').addEventListener('change', () => editFromDateError.innerText = '');
    document.getElementById('editToDate').addEventListener('change', () => editToDateError.innerText = '');
    editFileUpload.addEventListener('change', () => editImageError.innerText = '');
    document.querySelectorAll('.edit-category-radio').forEach(radio => {
        radio.addEventListener('change', () => editCategoryError.innerText = '');
    });

    /* ===== Update Subcategories on Category Change ===== */
    document.querySelectorAll('.edit-category-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            const categoryId = this.value;
            editSubCategorySelect.innerHTML = '<option selected>Loading...</option>';
            editSubCategoryError.innerText = '';

            fetch(`/admin/getSubCategories/${categoryId}`)
                .then(res => res.json())
                .then(data => {
                    editSubCategorySelect.innerHTML = '';
                    if (data.status === 'success' && data.data.data.length > 0) {
                        data.data.data.forEach(sub => {
                            const option = document.createElement('option');
                            option.value = sub.id;
                            option.textContent = sub.name_english;
                            editSubCategorySelect.appendChild(option);
                        });
                    } else {
                        editSubCategorySelect.innerHTML =
                            '<option disabled>No subcategories found</option>';
                    }
                    $(editSubCategorySelect).multiselect('rebuild');
                })
                .catch(err => {
                    console.error(err);
                    editSubCategorySelect.innerHTML =
                        '<option disabled>Error fetching subcategories</option>';
                    $(editSubCategorySelect).multiselect('rebuild');
                });
        });
    });

    /* ===== Submit Edit Deal ===== */
    submitEditBtn.addEventListener('click', function() {
        const id = this.dataset.id;

        // Reset errors
        editNameEnError.innerText = '';
        editNameArError.innerText = '';
        editCategoryError.innerText = '';
        editSubCategoryError.innerText = '';
        editDiscountError.innerText = '';
        editFromDateError.innerText = '';
        editToDateError.innerText = '';
        editImageError.innerText = '';

        let hasError = false;

        const nameEnglish = document.getElementById('editNameEnglish').value.trim();
        const nameArabic = document.getElementById('editNameArabic').value.trim();
        const categoryRadio = document.querySelector('.edit-category-radio:checked');
        const categoryId = categoryRadio ? categoryRadio.value : '';
        const subCategoryIds = Array.from(editSubCategorySelect.selectedOptions).map(opt => opt.value);
        const discount = document.getElementById('editDiscount').value.trim();
        const from = document.getElementById('editFromDate').value;
        const to = document.getElementById('editToDate').value;

        if (!nameEnglish) {
            editNameEnError.innerText = 'Please enter name in English';
            hasError = true;
        }
        if (!nameArabic) {
            editNameArError.innerText = 'Please enter name in Arabic';
            hasError = true;
        }
        if (!categoryId) {
            editCategoryError.innerText = 'Please select a category';
            hasError = true;
        }
        if (!subCategoryIds.length) {
            editSubCategoryError.innerText = 'Please select at least one subcategory';
            hasError = true;
        }
        if (!discount) {
            editDiscountError.innerText = 'Please enter discount';
            hasError = true;
        }
        if (!from) {
            editFromDateError.innerText = 'Please select from date';
            hasError = true;
        }
        if (!to) {
            editToDateError.innerText = 'Please select to date';
            hasError = true;
        }

        if (hasError) return;

        const formData = new FormData();
        formData.append('name_english', nameEnglish);
        formData.append('name_arabic', nameArabic);
        formData.append('category_id', categoryId);
        formData.append('sub_category_id', JSON.stringify(subCategoryIds)); // JSON string
        formData.append('discount', discount);
        formData.append('from', from);
        formData.append('to', to);
        if (editFileUpload.files[0]) formData.append('image', editFileUpload.files[0]);

        fetch(`/admin/updateDeal/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    toastr.success(data.message);
                    setTimeout(() => {
                        $('#editModalDeal').modal('hide');
                        location.reload();
                    }, 1500);
                } else {
                    toastr.error(data.message || 'Something went wrong.');
                }
            })
            .catch(err => {
                console.error(err);
                toastr.error('Server error');
            });
    });

});
</script>



<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.deleteDeal').forEach(button => {
        button.addEventListener('click', function() {
            let dealId = this.getAttribute('data-id');

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
                    fetch(`/admin/deleteDeal/${dealId}`, {
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.toggleStatus').forEach(toggle => {
        toggle.addEventListener('change', function() {
            let dealId = this.getAttribute('data-id');
            let isChecked = this.checked;

            fetch(`/admin/blockUnblockDeal/${dealId}`, {
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
function updateToDate() {
    const fromDate = document.getElementById('fromDate').value;
    const toDateInput = document.getElementById('toDate');

    if (fromDate) {
        const minDate = new Date(fromDate);
        minDate.setDate(minDate.getDate() + 1);
        toDateInput.setAttribute('min', minDate.toISOString().split('T')[0]);
    } else {
        toDateInput.removeAttribute('min');
    }
}
document.addEventListener('DOMContentLoaded', function() {
    updateToDate();
    document.getElementById('fromDate').addEventListener('input', updateToDate);
});
</script>

<script>
function updateToDate1() {
    const fromDate = document.getElementById('editFromDate').value;
    const toDateInput = document.getElementById('editToDate');

    if (fromDate) {
        const minDate = new Date(fromDate);
        minDate.setDate(minDate.getDate() + 1);
        toDateInput.setAttribute('min', minDate.toISOString().split('T')[0]);
    } else {
        toDateInput.removeAttribute('min');
    }
}
document.addEventListener('DOMContentLoaded', function() {
    updateToDate1();
    document.getElementById('editFromDate').addEventListener('input', updateToDate1);
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('sentModal2');
    modal.addEventListener('hidden.bs.modal', function() {
        location.reload();
    });
});
</script>













@endsection