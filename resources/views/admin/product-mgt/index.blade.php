@extends('admin.layout.app')
@section('content')

<style>
    .custom-topbar {
      background: linear-gradient(90deg, #c08f53, #a36a2a) !important;
      height: 74px;
      border-radius: 6px;
      padding: 0 25px;
      display: flex;
      align-items: center;
    }

    .header-logo {
      width: 110px;
      height: 66px;
      border-radius: 50%;
      object-fit: contain;
    }

    .brand-name {
      font-size: 22px;
      font-weight: 600;
      font-family: "Georgia", serif;
      margin-left: 12px;
      color: #000;
    }

    .header-divider {
      flex: 1;
      /* border-bottom: 1.5px dotted rgba(0, 0, 0, 0.5); */
      margin: 0 25px;
    }

    .lang-btn {
      background: transparent;
      border: 1px solid rgba(0, 0, 0, 0.7);
      padding: 6px 14px;
      border-radius: 50px;
      font-size: 14px;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .star-rating i,
    .star-rating {
      color: #ffa41b;
    }
  </style>

<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">Product Management</h2>
        </div>

        <div class="col-lg-3 col-md-4 col-12">
            <div class="d-flex justify-content-end">
                <a class="btn btn-dark customBtn" href="">
                    <span>Export in Excel</span>
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
                        <label for="status" class="form-label">Category</label>
                        <select name="Category" class="form-select form-select-lg">
                            <option value="">Select</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <!-- Country Filter -->
                <div class="col-lg-3 col-md-12 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="status" class="form-label">Sub-Category-</label>
                        <select name="Sub-Category" class="form-select form-select-lg">
                            <option value="">Select</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="status" class="form-label">Brand-</label>
                        <select name="Brand" class="form-select form-select-lg">
                            <option value="">Select</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="table-responsive w-100 mt-4">
                <table id="myTable" class="table w-100">
                    <thead>
                        <tr>
                            <th scope="col">SR No.</th>
                            <th scope="col">Seller Name</th>
                            <th scope="col">Country</th>
                            <th scope="col">Image</th>
                            <th scope="col">Category</th>
                            <th scope="col">Sub-Category</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Specification</th>
                            <th scope="col">Actual Price</th>
                            <th scope="col">Size Chart</th>
                            <th scope="col">View Variants</th>
                            <th scope="col">More Details</th>
                            <th scope="col">Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Lorem</td>
                            <td>UAE</td>
                            <td>
                                <img src="image/dummy-image.jpg" alt="Profile Image" width="40px" height="40px"
                                    class="square" />
                            </td>
                            <td>lorem</td>
                            <td>lorem</td>
                            <td>lorem</td>
                            <td>lorem</td>
                            <td>
                                <a class="table-button" type="button" data-bs-toggle="modal"
                                    data-bs-target="#sentModal1">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </td>
                            <td>
                                <a class="table-button" type="button" data-bs-toggle="modal" data-bs-target="#Modal2">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </td>
                            <td>100KD</td>
                            <td>
                                <a class="table-button" type="button" data-bs-toggle="modal"
                                    data-bs-target="#sizeChartModal">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </td>
                            <td>
                                <a class="table-button" type="button" data-bs-toggle="modal" data-bs-target="#Modal3">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </td>
                            <td>
                                <a class="table-button" type="button" data-bs-toggle="modal"
                                    data-bs-target="#moredetails">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </td>
                            <td class="star-rating">
                                0
                                <i class="bi bi-star-fill"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="sentModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Description</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-12">

                            <div class="mb-3">
                                <p class="fw-normal">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate, eveniet amet assumenda sint illo rerum impedit quibusdam labore soluta. Illum minima nisi tempora voluptatem tempore perspiciatis dolorum deleniti iste iure.</p>
                                <!-- <textarea id="description" class="form-control" rows="3" readOnly></textarea> -->
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
                <h3 class="modal-title fs-5">Specification</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <table class="details-table">
                <tr>
                    <th>LOrem</th>
                    <td>Lorem</td>
                </tr>
                <tr>
                    <th>LOrem</th>
                    <td>Lorem</td>
                </tr>
                <tr>
                    <th>LOrem</th>
                    <td>Lorem</td>
                </tr>
                <tr>
                    <th>LOrem</th>
                    <td>Lorem</td>
                </tr>
            </table>

        </div>
    </div>
</div>
<div class="modal fade" id="Modal3" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title fs-5">Variant</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <!-- Variant 1 -->
                <div class="variant-box">
                    <h6 class="variant-heading">Variant 1</h6>

                    <div class="variant-inner">
                        <div class="variant-left">
                            <div class="v-row"><span>Color</span><span>White</span></div>
                            <div class="v-row"><span>Size</span><span>S</span></div>
                            <div class="v-row"><span>Bust</span><span>32</span></div>
                            <div class="v-row"><span>Waist</span><span>32</span></div>
                            <div class="v-row"><span>HIP</span><span>34</span></div>
                            <div class="v-row"><span>Shoulder</span><span>32</span></div>
                            <div class="v-row"><span>Sleeve length</span><span>32</span></div>
                            <div class="v-row"><span>Length</span><span>32</span></div>
                            <div class="v-row"><span>Total Stock</span><span>32</span></div>
                            <div class="v-row"><span>SKU</span><span>32</span></div>
                            <div class="v-row"><span>Price</span><span>KD</span></div>
                            <div class="v-row"><span>Discount Price</span><span>2 KD Or 10 %</span></div>
                        </div>

                        <div class="variant-right">
                            <i class="bi bi-image"></i>
                        </div>
                    </div>
                </div>

                <!-- Variant 2 -->
                <div class="variant-box mt-4">
                    <h6 class="variant-heading">Variant 2</h6>

                    <div class="variant-inner">
                        <div class="variant-left">
                            <div class="v-row"><span>Color</span><span>White</span></div>
                            <div class="v-row"><span>Size</span><span>S</span></div>
                            <div class="v-row"><span>Bust</span><span>32</span></div>
                            <div class="v-row"><span>Waist</span><span>32</span></div>
                            <div class="v-row"><span>HIP</span><span>34</span></div>
                            <div class="v-row"><span>Shoulder</span><span>32</span></div>
                            <div class="v-row"><span>Sleeve length</span><span>32</span></div>
                            <div class="v-row"><span>Length</span><span>32</span></div>
                            <div class="v-row"><span>Total Stock</span><span>32</span></div>
                            <div class="v-row"><span>SKU</span><span>32</span></div>
                            <div class="v-row"><span>Price</span><span>KD</span></div>
                            <div class="v-row"><span>Discount Price</span><span>2 KD Or 10 %</span></div>
                        </div>

                        <div class="variant-right">
                            <i class="bi bi-image"></i>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="sizeChartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Size Chart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <img src="image/product-size-chart.png" alt="Size Chart" class="size-chart-img" />
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="moredetails" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5">More Details</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <table class=" details-table">
                <tr>
                    <th>Min. Cart Value</th>
                    <td>2</td>
                </tr>

                <tr>
                    <th>Max. Cart Value</th>
                    <td>8</td>
                </tr>

                <tr>
                    <th>Product Refundable</th>
                    <td>Yes</td>
                </tr>

                <tr>
                    <th>Review & Rating Allowed</th>
                    <td>Yes</td>
                </tr>

                <tr>
                    <th>Affiliate Products</th>
                    <td>Yes</td>
                </tr>

                <tr>
                    <th>Customized Products</th>
                    <td>Yes</td>
                </tr>

                <tr>
                    <th>Ready to Ship</th>
                    <td>Yes</td>
                </tr>

                <tr>
                    <th>Cash on Delivery Allowed</th>
                    <td>Yes</td>
                </tr>

                <tr>
                    <th>Return Days</th>
                    <td>10</td>
                </tr>

                <tr>
                    <th>Exchange Days</th>
                    <td>10</td>
                </tr>
            </table>


        </div>
    </div>
</div>




@endsection

<script>
$(document).ready(function() {
    $(".inner-content").removeClass("innerToggle");
    $(".menu").click(function() {
        $(".customSidebar").toggleClass("toggle");
        $(".inner-content").toggleClass("toggle");
    });
});
</script>