@include('dealer.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <a href="{{ route('seller.Add_product') }}" class="title24">Add New Product</a>
    </div>

    <div class="pt-3">
     <div class="title24">Select Category</div>

        <div class="group-radio-btn d-flex gap-4 align-items-center flex-wrap py-3">
            <div class="check_radio">
                <label class="radio-group">
                    <input type="radio" name="radio" checked>
                    <span class="custom-radio"></span>
                    <span class="radio-label">Women</span>
                </label>
            </div>
            <div class="check_radio">
                <label class="radio-group">
                    <input type="radio" name="radio">
                    <span class="custom-radio"></span>
                    <span class="radio-label">Men</span>
                </label>
            </div>
            <div class="check_radio">
                <label class="radio-group">
                    <input type="radio" name="radio">
                    <span class="custom-radio"></span>
                    <span class="radio-label">Children</span>
                </label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div class="sub-form">
                <div class="label-flex">
                    <label>Select Sub-Category</label>
                </div>
                <select class="form-select form-control" aria-label="Default select example">
                    <option selected>Dress</option>
                    <option value="1">One</option>
                </select>
            </div>
            <div class="sub-form">
                <div class="label-flex">
                    <label>Other</label>
                    <span>In English</span>
                </div>
                <input type="text" class="form-control" placeholder="Enter Brand name">
            </div>
            <div class="sub-form">
                <div class="label-flex">
                    <label>Product Name</label>
                    <span>In English</span>
                </div>
                <input type="text" class="form-control" placeholder="Enter Product name">
            </div>
            <div class="sub-form">
                <div class="label-flex">
                    <label>Description</label>
                    <span>In English</span>
                </div>
                <textarea rows="3" placeholder="Write Here" class="form-control"></textarea>
            </div>
        </div>

        <div class="col-lg-6 col-md-6">
            <div class="sub-form">
                <div class="label-flex">
                    <label>Select Brand</label>
                </div>

                <select class="form-select form-control" aria-label="Default select example">
                    <option selected>Brand</option>
                    <option value="1">One</option>
                </select>
            </div>
            <div class="sub-form">
                <div class="label-flex">
                    <label>Other</label>
                    <span>In Arabic</span>
                </div>
                <input type="text" class="form-control" placeholder="Enter Brand name">
            </div>
            <div class="sub-form">
                <div class="label-flex">
                    <label>Product Name</label>
                    <span>In Arabic</span>
                </div>
                <input type="text" class="form-control" placeholder="Enter Product name">
            </div>
            <div class="sub-form">
                <div class="label-flex">
                    <label>Description</label>
                    <span>In Arabic</span>
                </div>
                <textarea rows="3" placeholder="Write Here" class="form-control"></textarea>
            </div>
        </div>

    </div>





</section>





@include('dealer.layout.footer');
