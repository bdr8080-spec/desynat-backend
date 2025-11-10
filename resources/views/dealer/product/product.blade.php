@include('dealer.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24">Product Management</div>
        <a href="#" class="btn btn-success">Add New Product</a>
    </div>

    <div class="tabs-panel py-4">
        <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active w-100" id="pills-allproduct-tab" data-bs-toggle="pill" data-bs-target="#pills-allproduct" type="button" role="tab" aria-controls="pills-allproduct" aria-selected="true">All (123)</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link w-100" id="pills-active-tab" data-bs-toggle="pill" data-bs-target="#pills-active" type="button" role="tab" aria-controls="pills-active" aria-selected="false">Active (100)</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link w-100" id="pills-inactive-tab" data-bs-toggle="pill" data-bs-target="#pills-inactive" type="button" role="tab" aria-controls="pills-inactive" aria-selected="false">Inactive (150)</button>
            </li>
            
        </ul>
    </div>

    <div class="tab-body-wapper">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-allproduct" role="tabpanel" aria-labelledby="pills-allproduct-tab" tabindex="0">
                <div class="datatable-wapper">
                    <div class="table-header">
                        <div class="search-field">
                            <div class="from-group position-relative">
                                <input type="search" class="form-control" placeholder="Search">
                            </div>
                        </div>
                        <div class="search-filter">
                            <div class="from-group">
                                <select class="form-select form-control width-50" aria-label="Default select example">
                                    <option selected>Filter by</option>
                                    <option value="1">One</option>
                                </select>
                            </div>
                            <div class="from-group">
                                <select class="form-select form-control width-50" aria-label="Default select example">
                                    <option selected>Filter by brand</option>
                                    <option value="1">One</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="example" class="table datatable table-bordered">
                            <thead>
                                <tr>
                                    <th class="no-sort">S.No</th>
                                    <th class="no-sort">Image</th>
                                    <th class="no-sort">Product code</th>
                                    <th class="no-sort">Name</th>
                                    <th class="no-sort">Brand</th>
                                    <th class="no-sort">Category</th>
                                    <th class="no-sort">Added on</th>
                                    <th class="no-sort">Availability</th>
                                    <th class="no-sort">Status</th>
                                    <th class="no-sort">View more details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>01</td>
                                    <td>
                                        <img src="{{ asset('dealer') }}/assets/img/profile-img.jpg" alt="image" class="pro-image">
                                    </td>
                                    <td>2123562</td>
                                    <td>Mens Cotton Shirt</td>
                                    <td>Lives</td>
                                    <td>Men</td>
                                    <td>10/11/25</td>
                                    <td>Instock</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault">
                                                <label class="form-check-label" for="switchCheckDefault"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" class="eyebtn"><i class="bi bi-eye"></i></a>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="pills-active" role="tabpanel" aria-labelledby="pills-active-tab" tabindex="0">
            <div class="datatable-wapper">
                    <div class="table-header">
                        <div class="search-field">
                            <div class="from-group position-relative">
                                <input type="search" class="form-control" placeholder="Search">
                            </div>
                        </div>
                        <div class="search-filter">
                            <div class="from-group">
                                <select class="form-select form-control width-50" aria-label="Default select example">
                                    <option selected>Filter by</option>
                                    <option value="1">One</option>
                                </select>
                            </div>
                            <div class="from-group">
                                <select class="form-select form-control width-50" aria-label="Default select example">
                                    <option selected>Filter by brand</option>
                                    <option value="1">One</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table datatable table-bordered">
                            <thead>
                                <tr>
                                    <th class="no-sort">S.No</th>
                                    <th class="no-sort">Image</th>
                                    <th class="no-sort">Product code</th>
                                    <th class="no-sort">Name</th>
                                    <th class="no-sort">Brand</th>
                                    <th class="no-sort">Category</th>
                                    <th class="no-sort">Added on</th>
                                    <th class="no-sort">Availability</th>
                                    <th class="no-sort">Status</th>
                                    <th class="no-sort">View more details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>01</td>
                                    <td>
                                        <img src="{{ asset('dealer') }}/assets/img/profile-img.jpg" alt="image" class="pro-image">
                                    </td>
                                    <td>2123562</td>
                                    <td>Mens Cotton Shirt</td>
                                    <td>Lives</td>
                                    <td>Men</td>
                                    <td>10/11/25</td>
                                    <td>Instock</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault">
                                                <label class="form-check-label" for="switchCheckDefault"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" class="eyebtn"><i class="bi bi-eye"></i></a>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="tab-pane fade" id="pills-inactive" role="tabpanel" aria-labelledby="pills-inactive-tab" tabindex="0">
            <div class="datatable-wapper">
                    <div class="table-header">
                        <div class="search-field">
                            <div class="from-group position-relative">
                                <input type="search" class="form-control" placeholder="Search">
                            </div>
                        </div>
                        <div class="search-filter">
                            <div class="from-group">
                                <select class="form-select form-control width-50" aria-label="Default select example">
                                    <option selected>Filter by</option>
                                    <option value="1">One</option>
                                </select>
                            </div>
                            <div class="from-group">
                                <select class="form-select form-control width-50" aria-label="Default select example">
                                    <option selected>Filter by brand</option>
                                    <option value="1">One</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table  class="table datatable table-bordered">
                            <thead>
                                <tr>
                                    <th class="no-sort">S.No</th>
                                    <th class="no-sort">Image</th>
                                    <th class="no-sort">Product code</th>
                                    <th class="no-sort">Name</th>
                                    <th class="no-sort">Brand</th>
                                    <th class="no-sort">Category</th>
                                    <th class="no-sort">Added on</th>
                                    <th class="no-sort">Availability</th>
                                    <th class="no-sort">Status</th>
                                    <th class="no-sort">View more details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>01</td>
                                    <td>
                                        <img src="{{ asset('dealer') }}/assets/img/profile-img.jpg" alt="image" class="pro-image">
                                    </td>
                                    <td>2123562</td>
                                    <td>Mens Cotton Shirt</td>
                                    <td>Lives</td>
                                    <td>Men</td>
                                    <td>10/11/25</td>
                                    <td>Instock</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault">
                                                <label class="form-check-label" for="switchCheckDefault"></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" class="eyebtn"><i class="bi bi-eye"></i></a>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            
        </div>
    </div>





</div>




@include('dealer.layout.footer');
