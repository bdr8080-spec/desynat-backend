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
            <div class="tab-pane fade show active" id="pills-allproduct" role="tabpanel" aria-labelledby="pills-allproduct-tab" tabindex="0">...</div>
            <div class="tab-pane fade" id="pills-active" role="tabpanel" aria-labelledby="pills-active-tab" tabindex="0">...</div>
            <div class="tab-pane fade" id="pills-inactive" role="tabpanel" aria-labelledby="pills-inactive-tab" tabindex="0">...</div>
            
        </div>
    </div>





</div>




@include('dealer.layout.footer');
