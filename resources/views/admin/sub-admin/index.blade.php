@extends('admin.layout.app')
@section('content')

<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">Sub-admin management</h2>
        </div>

        <div class="col-lg-3 col-md-4 col-12">
            <div class="d-flex justify-content-end">
                <a class="btn btn-dark customBtn" href="{{route('admin.add_subadmin')}}">
                    <span>Add Sub-admin</span>
                </a>
            </div>
        </div>
    </div>

    <div class="userManagecontent">
        <div class="mt-4">
            <div class="row align-items-end">
                <div class="col-lg-3 col-md-12 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="status" class="form-label">Country-</label>
                        <select name="Country" class="form-select form-select-lg">
                            <option value="">Select</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="status" class="form-label">Filter by status</label>
                        <select name="Category" class="form-select form-select-lg">
                            <option value="">Select</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="table-responsive w-100 mt-4">
                <table id="myTable" class="table w-100 custom-table">
                    <thead>
                        <tr>
                            <th>SR No.</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Phone number</th>
                            <th>Country</th>
                            <th>Email</th>
                            <th>View module</th>
                            <th>View credentials</th>
                            <th>Send credentials</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($subAdmins->list as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>25/02/25</td>
                            <td>John Doe</td>

                            <td>
                                <img src="image/dummy-image.jpg" alt="Profile Image" width="40px" height="40px"
                                    class="square" />
                            </td>

                            <td>1-212-456-7890</td>
                            <td>Lorem</td>
                            <td>johndoe123@gmail.com</td>

                            <!-- View module -->
                            <td>
                                <a class="table-button view-bank-btn" type="button" data-bs-toggle="modal"
                                    data-bs-target="#sentModal1">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </td>

                            <!-- View credentials -->
                            <td>
                                <a class="table-button view-bank-btn" type="button" data-bs-toggle="modal"
                                    data-bs-target="#Modal2">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </td>

                            <!-- Send credentials -->
                            <td> <a class="table-button view-bank-btn" type="button" data-bs-toggle="modal"
                                    data-bs-target="#Modal3">
                                    <i class="bi bi-send-fill action-icon"></i>
                                </a>

                            </td>

                            <!-- Status -->
                            <td>
                                <span class="status active">Active</span>
                            </td>

                            <!-- Action -->
                            <td>
                                <div class="d-flex gap-3 justify-content-center">
                                    <!-- Edit button -->
                                    <a class="table-button editBrandBtn">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <!-- Delete button  -->
                                    <a class="table-button text-danger deleteBrand mt-1 mb-1">
                                        <i class="bi bi-trash3-fill"></i>
                                    </a>

                                    <!-- Toggle switch -->
                                    <div class="form-check form-switch">
                                        <input class="form-check-input toggleStatus" type="checkbox" role="switch" />
                                    </div>
                                </div>
                            </td>
                        </tr>
                         @empty

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal section -->

<div class="modal fade" id="sentModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Modules</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="modal-body">
                                <!-- Module Row -->
                                <div class="module-block">
                                    <h5>Module 1</h5>
                                    <div class="d-flex gap-5 mt-3">
                                        <label class="custom-checkbox">
                                            <input type="checkbox"> View
                                        </label>

                                        <label class="custom-checkbox">
                                            <input type="checkbox"> Edit
                                        </label>

                                        <label class="custom-checkbox">
                                            <input type="checkbox"> Both
                                        </label>
                                    </div>
                                </div>

                                <!-- Repeat -->
                                <div class="module-block">
                                    <h5>Module 1</h5>
                                    <div class="d-flex gap-5 mt-3">
                                        <label class="custom-checkbox">
                                            <input type="checkbox"> View
                                        </label>

                                        <label class="custom-checkbox">
                                            <input type="checkbox"> Edit
                                        </label>

                                        <label class="custom-checkbox">
                                            <input type="checkbox"> Both
                                        </label>
                                    </div>
                                </div>

                                <div class="module-block">
                                    <h5>Module 1</h5>
                                    <div class="d-flex gap-5 mt-3">
                                        <label class="custom-checkbox">
                                            <input type="checkbox"> View
                                        </label>

                                        <label class="custom-checkbox">
                                            <input type="checkbox"> Edit
                                        </label>

                                        <label class="custom-checkbox">
                                            <input type="checkbox"> Both
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="Modal2" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5">Credential </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="form-group mb-2">
                <label class="form-label" for="email"> id-</label>
                <input type="text" id="email" class="form-control space" />
            </div>
            <div class="form-group mb-2">
                <label class="form-label" for="email">Password-</label>
                <input type="text" id="email" class="form-control space" />
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="Modal3" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <img src="image/check.png" alt="Success" class="mb-3 m-auto"
                    style="width: 60px;height: 60px;justify-content: center;display: flex;" />
                <h4 class="mb-3">Credentials sent successfully!</h4>
                <p>The credentials have been sent to the sub-admin's registered email address.</p>

            </div>
        </div>
    </div>
</div>


@endsection