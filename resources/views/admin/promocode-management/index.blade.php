@extends('admin.layout.app')
@section('content')
<style>
#editPreviewImage {
    display: block;
}

.form-group label.form-label,
.form-check-label {
    font-size: 19px !important;
    line-height: 30px;
    /* font-weight: 600; */
    text-align: start;
}
</style>

<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">Promocode Management</h2>
        </div>

        <div class="col-lg-3 col-md-4 col-12">
            <div class="d-flex justify-content-end">
                <a class="btn btn-dark customBtn" data-bs-toggle="modal" data-bs-target="#sentModal2">
                    <span>Add New Promocode</span>
                </a>
            </div>
        </div>
    </div>

    <div class="userManagecontent">
        <div class="mt-4">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="from" class="form-label">From:</label>
                        <input type="date" id="from" class="form-control" />
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="from" class="form-label">To:</label>
                        <input type="date" id="from" class="form-control" />
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="from" class="form-label">Country Name</label>
                        <select class="form-select form-select-lg" aria-label="Large select example">
                            <option selected>Select Country</option>
                            <option value="1">country One</option>
                            <option value="2">country Two</option>
                            <option value="3">country Three</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="from" class="form-label">Status-</label>
                        <select class="form-select form-select-lg" aria-label="Large select example">
                            <option selected>Select Status</option>
                            <option value="1">Status One</option>
                            <option value="2">Status Two</option>
                            <option value="3">Status Three</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="table-responsive w-100">
                <table class="table w-100">
                    <thead>
                        <tr>
                            <th scope="col">SR No.</th>
                            <th scope="col">Promocode <br> Name</th>
                            <th scope="col">Country</th>
                            <th scope="col">View <br> Description</th>
                            <th scope="col">Applicable for</th>
                            <th scope="col">Minimum <br> Order <br> Value</th>
                            <th scope="col">Upto <br> Discount</th>
                            <th scope="col">Discount %</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Save20</td>
                            <td>LOrem</td>
                            <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                    data-bs-target="#sentModal1">
                                    <i class="bi bi-eye-fill"></i>
                                </a></td>
                            <td>First Order</td>
                            <td>KD 299</td>
                            <td>KD 20</td>
                            <td>10%</td>
                            <td>21/05/25</td>
                            <td>21/05/25</td>
                            <td>Active</td>
                            <td>
                                <div class="d-flex gap-3 justify-content-center">
                                    <a class="table-button" type="button" data-bs-toggle="modal"
                                        data-bs-target="#sentModal3"><i class="bi bi-pencil-square"></i></a>

                                    <a class="table-button" type="button">
                                        <i class="bi bi-trash3-fill"></i>
                                    </a>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckChecked" />
                                        <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">1</th>
                            <td>Save20</td>
                            <td>LOrem</td>
                            <td> <a class="table-button" type="button" data-bs-toggle="modal"
                                    data-bs-target="#sentModal2">
                                    <i class="bi bi-eye-fill"></i>
                                </a></td>
                            <td>First Order</td>
                            <td>KD 299</td>
                            <td>KD 20</td>
                            <td>10%</td>
                            <td>21/05/25</td>
                            <td>21/05/25</td>
                            <td>Active</td>
                            <td>
                                <div class="d-flex gap-3 justify-content-center">
                                    <a class="table-button" type="button" data-bs-toggle="modal"
                                        data-bs-target="#sentModal3"><i class="bi bi-pencil-square"></i></a>

                                    <a class="table-button" type="button">
                                        <i class="bi bi-trash3-fill"></i>
                                    </a>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckChecked" />
                                        <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="sentModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Add New Brands</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group mb-3">
                                <label>Select country-</label>

                                <select name="new_duration_type" class="form-select">
                                    <option value="">All</option>
                                    <option value="1">Country 1</option>
                                    <option value="2">Country 2</option>
                                </select>

                            </div>
                        </div>

                        <!-- Brand Name English -->
                        <div class="col-lg-6 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label">Promocode Name (English)</label>
                                <input type="text" name="name_english" class="form-control"
                                    placeholder="EnterPromocode in English" />
                            </div>
                        </div>

                        <!-- Brand Name Arabic -->
                        <div class="col-lg-6 col-md-12 col-12">
                            <div class="form-group">
                                <label class="form-label">Promocode Name (Arabic)</label>
                                <input type="text" name="name_arabic" class="form-control"
                                    placeholder="Enter Promocode in Arabic" />
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">

                            <div class="mb-3">
                                <label for="editReasonEnglish" class="form-label">Description (English)</label>
                                <textarea id="editReasonEnglish" name="reason_english" class="form-control"
                                    rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">

                            <div class="mb-3">
                                <label for="editReasonArabic" class="form-label">Description (Arabic)</label>
                                <textarea id="editReasonArabic" name="reason_arabic" class="form-control"
                                    rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group mb-3">
                                <label>Applicable for-</label>

                                <select name="new_duration_type" class="form-select">
                                    <option value="">All</option>
                                    <option value="1">First Order</option>
                                    <option value="2">Every Order</option>
                                </select>

                            </div>
                        </div>

                        <!-- Brand Name English -->
                        <div class="col-lg-6 ">
                            <div class="form-group mb-3">
                                <label class="form-label">Discount %</label>
                                <input type="text" name="name_english" class="form-control" placeholder="Enter " />
                            </div>
                        </div>

                        <!-- Brand Name Arabic -->
                        <div class="col-lg-6 ">
                            <div class="form-group mb-3">
                                <label class="form-label">Minimum Order Value</label>
                                <input type="text" name="name_arabic" class="form-control" placeholder="Enter " />
                            </div>
                        </div>
                        <div class="col-lg-12 ">
                            <div class="form-group mb-3">
                                <label class="form-label">Upto Discount</label>
                                <input type="text" name="name_arabic" class="form-control" placeholder="Enter " />
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-4 col-12">
                            <div class="form-group mb-3 ">
                                <label for="from" class="form-label">From:</label>
                                <input type="date" id="from" class="form-control" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-4 col-12">
                            <div class="form-group  mb-3">
                                <label for="from" class="form-label">To:</label>
                                <input type="date" id="from" class="form-control" />
                            </div>
                        </div>


                        <!-- Submit Button -->
                        <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                            <a type="button" id="submitBrandBtn" class="btn btn-dark customBtn mt-3">Submit</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="sentModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Add New Brands</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <div class="row">
             
                        <div class="col-lg-12 col-md-12 col-12">

                            <div class="mb-3">
                                <label for="editReasonArabic" class="form-label">Description</label>
                                <textarea id="editReasonArabic" name="reason_arabic" class="form-control"
                                    rows="3"></textarea>
                            </div>
                        </div>
                      

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery.js"></script>

<script>
const fileInput = document.getElementById("fileUpload");
const previewImage = document.getElementById("previewImage");
const uploadIcon = document.getElementById("uploadIcon");

fileInput.addEventListener("change", function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewImage.style.display = "block";
            uploadIcon.style.display = "none";
        };
        reader.readAsDataURL(file);
    }
});
</script>

@endsection