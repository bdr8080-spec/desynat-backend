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
            <!-- <div class="d-flex justify-content-end">
                <a class="btn btn-dark customBtn" href="">
                    <span>Export in Excel</span>
                </a>
            </div> -->
        </div>
    </div>

    <div class="userManagecontent">
        <div class="mt-4">
            <form method="GET" action="{{ route('admin.productManagement') }}" id="filterForm">
            <div class="row align-items-end">
                <div class="col-lg-2 col-md-12 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="status" class="form-label">Country</label>
                        <select name="country" id="country"
                            class="form-select form-select-lg "
                            onchange="document.getElementById('filterForm').submit();">
                            <option value="">Select country</option>
                            @foreach($countries as $country)
                            <option value="{{ $country['id'] }}"
                                {{ request('country') == $country['id'] ? 'selected' : '' }}>
                                {{ $country['name'] }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-12 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="status" class="form-label">Category</label>
                        <select name="category" id="category"
                            class="form-select form-select-lg "
                            onchange="document.getElementById('filterForm').submit();">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category['id'] }}"
                                {{ request('category') == $category['id'] ? 'selected' : '' }}>
                                {{ $category['name'] }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-2 col-md-12 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="status" class="form-label">Sub-Category</label>
                        <select name="subcategory" id="subcategory"
                            class="form-select form-select-lg "
                            onchange="document.getElementById('filterForm').submit();">
                            <option value="">Select Sub-Category</option>
                            @foreach($subcategories as $subcategory)
                            <option value="{{ $subcategory['id'] }}"
                                {{ request('subcategory') == $subcategory['id'] ? 'selected' : '' }}>
                                {{ $subcategory['name_english'] }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="status" class="form-label">Brand</label>
                        <select name="brand" id="brand"
                            class="form-select form-select-lg "
                            onchange="document.getElementById('filterForm').submit();">
                            <option value="">Select Brand</option>
                            @foreach($brands as $brand)
                            <option value="{{ $brand['id'] }}"
                                {{ request('brand') == $brand['id'] ? 'selected' : '' }}>
                                {{ $brand['name_english'] }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-1 col-md-4 col-12 ">
                    <div class="d-flex gap-3 justify-content-end" >
                        <a href="{{route('admin.productManagement')}}" class="btn btn-dark customBtn"
                            style="margin-top: 60px">
                            <span>Reset</span>
                        </a>
                    </div>
                </div>
            </div>
            </form>

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
                        @foreach($products as $index => $product)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{$product['seller_details']['first_name']}} {{$product['seller_details']['last_name']}}</td>
                            <td>{{$product['store']['country_info']['name']??'N/A'}}</td>
                            <td>
                                <img src="{{$product['product_variants'][0]['variant_image'][0]}}" alt="Profile Image" width="40px" height="40px"
                                    class="square" />
                            </td>
                            <td>{{$product['category']['name']}}</td>
                            <td>{{$product['subcategory']['name_english']}}</td>
                            <td>{{$product['brand']['name_english']??'N/A'}}</td>
                            <td>{{$product['product_name_en']}}</td>
                            <td>
                                <a class="table-button view-description-btn"
                                type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#sentModal1"
                                data-description="{{ $product['description_en'] }}">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </td>
                            <td>
                                <a class="table-button view-spec-btn"
                                type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#Modal2"
                                data-specifications='@json($product["product_specifications"])'>
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </td>
                            <td>{{$product['product_variants'][0]['actual_price']}} KD</td>
                            <td>
                                <a class="table-button view-size-chart-btn"
                                type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#sizeChartModal"
                                data-image="{{ $product['upload_size_chart'] }}">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </td>
                            <td>
                                <a class="table-button view-variant-btn"
                                type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#Modal3"
                                data-variants='@json($product["product_variants"])'>
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </td>
                            <td>
                                <a class="table-button view-more-details-btn"
                                type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#moredetails"
                                data-product='@json($product)'>
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </td>
                            <td class="star-rating">
                                {{ $product['average_rating']['product'] }}
                                <i class="bi bi-star-fill"></i>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- description modal -->
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
                                <p class="fw-normal" id="modalDescription">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate, eveniet amet assumenda sint illo rerum impedit quibusdam labore soluta. Illum minima nisi tempora voluptatem tempore perspiciatis dolorum deleniti iste iure.</p>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- specifications modal -->
<div class="modal fade" id="Modal2" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5">Specification</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <table class="details-table">
                <tbody id="specificationTableBody">
                    <!-- Dynamic rows will come here -->
                </tbody>
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
              <div id="variantContainer">
                <!-- variants will show here -->
              </div>
            </div>
        </div>
    </div>
</div>

<!-- size chart modal -->
<div class="modal fade" id="sizeChartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Size Chart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center chart-img">
                <a href="#" target="_blank" id="sizeChartLink" class="size-chart-img">
                    <img src="" alt="Size Chart" class="size-chart-img" id="sizeChartImage" />
                </a>
            </div>

        </div>
    </div>
</div>

<!-- more details modal -->
<div class="modal fade" id="moredetails" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5">More Details</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <table class=" details-table">
             <tbody id="moreDetailsBody"></tbody>
            </table>


        </div>
    </div>
</div>

<!-- show description -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.view-description-btn');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const description = this.getAttribute('data-description');
                document.getElementById('modalDescription').textContent = description;
            });
        });
    });
</script>

<!-- show specifications -->
 <script>
document.addEventListener('DOMContentLoaded', function () {

    const buttons = document.querySelectorAll('.view-spec-btn');
    const tableBody = document.getElementById('specificationTableBody');

    buttons.forEach(button => {
        button.addEventListener('click', function () {

            const specs = JSON.parse(this.getAttribute('data-specifications'));

            tableBody.innerHTML = '';

            if (specs.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="2">No specifications found</td></tr>';
                return;
            }

            specs.forEach(spec => {
                const row = `
                    <tr>
                        <th>${spec.name_en}</th>
                        <td>${spec.feature_en}</td>
                    </tr>
                `;
                tableBody.insertAdjacentHTML('beforeend', row);
            });

        });
    });

});
</script>

<!-- size chart -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const buttons = document.querySelectorAll('.view-size-chart-btn');
    const modalImage = document.getElementById('sizeChartImage');
    const imageLink = document.getElementById('sizeChartLink');

    buttons.forEach(button => {
        button.addEventListener('click', function () {

            const imageUrl = this.getAttribute('data-image');

            if (imageUrl && imageUrl !== 'null') {
                modalImage.src = imageUrl;
                imageLink.href = imageUrl; 
                modalImage.style.display = 'inline-block';
            } else {
                modalImage.src = '';
                imageLink.href = '#';
                modalImage.style.display = 'none';
            }

        });
    });

});
</script>

<!-- product variants -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const buttons = document.querySelectorAll('.view-variant-btn');
    const container = document.getElementById('variantContainer');

    function valueOrNA(value) {
        return (value === null || value === undefined || value === '') ? 'N/A' : value;
    }

    buttons.forEach(button => {
        button.addEventListener('click', function () {

            const variants = JSON.parse(this.getAttribute('data-variants'));
            container.innerHTML = '';

            if (!variants || variants.length === 0) {
                container.innerHTML = '<p class="text-muted">No variants found</p>';
                return;
            }

            variants.forEach((variant, index) => {

                let discountText = '';
                if (variant.discount_value) {
                    discountText = variant.discount_value +
                        (variant.discount_type == 1 ? ' %' : ' KD');
                }

                const images = variant.variant_image || [];
                let imageHtml = '<i class="bi bi-image fs-1 text-muted"></i>';

                if (images.length > 0) {
                    imageHtml = `<img src="${images[0]}" class="img-fluid" style="max-height:150px;">`;
                }

                // Helper to create row only if value exists
                function createRow(label, value, suffix = '') {
                    if (value === null || value === undefined || value === '') {
                        return '';
                    }
                    return `<div class="v-row"><span>${label}</span><span>${value}${suffix}</span></div>`;
                }

                const html = `
                <div class="variant-box ${index !== 0 ? 'mt-4' : ''}">
                    <h6 class="variant-heading">Variant ${index + 1}</h6>

                    <div class="variant-inner">
                        <div class="variant-left">

                            ${createRow('Color', variant.color?.name)}
                            ${createRow('Size', variant.size?.name)}
                            ${createRow('Bust', variant.bust)}
                            ${createRow('Waist', variant.waist)}
                            ${createRow('Hip', variant.hip)}
                            ${createRow('Shoulder', variant.shoulder)}
                            ${createRow('Sleeve Length', variant.sleeve_length)}
                            ${createRow('Length', variant.length)}
                            ${createRow('Total Stock', variant.total_stock)}
                            ${createRow('SKU', variant.sku)}
                            ${createRow('Price', variant.actual_price, ' KD')}
                            ${createRow('Discount', discountText)}

                        </div>

                        <div class="variant-right  text-center">
                            ${imageHtml}
                        </div>
                    </div>
                </div>
                `;

                container.insertAdjacentHTML('beforeend', html);
            });

        });
    });

});
</script>

<!-- more details -->
 <script>
document.addEventListener('DOMContentLoaded', function () {

    const buttons = document.querySelectorAll('.view-more-details-btn');
    const tableBody = document.getElementById('moreDetailsBody');

    function yesNo(value) {
        return value == 1 ? 'Yes' : 'No';
    }

    function valueOrNA(value) {
        return (value === null || value === '') ? 'N/A' : value;
    }

    buttons.forEach(button => {
        button.addEventListener('click', function () {

            const product = JSON.parse(this.getAttribute('data-product'));
            tableBody.innerHTML = '';

            const rows = [
                ['Min. Cart Value', valueOrNA(product.min_card_quantity)],
                ['Max. Cart Value', valueOrNA(product.max_card_quantity)],
                ['Product Refundable', yesNo(product.product_return)],
                ['Review & Rating Allowed', yesNo(product.review_rating)],
                ['Affiliate Products', yesNo(product.affiliated_product)],
                ['Customized Products', yesNo(product.customized_product)],
                ['Ready to Ship', yesNo(product.ready_to_ship)],
                ['Cash on Delivery Allowed', yesNo(product.cash_on_delivery)],
                ['Return Days', valueOrNA(product.return_days)],
                ['Exchange Days', valueOrNA(product.exchangable_days)]
            ];

            rows.forEach(row => {
                tableBody.insertAdjacentHTML('beforeend', `
                    <tr>
                        <th>${row[0]}</th>
                        <td>${row[1]}</td>
                    </tr>
                `);
            });

        });
    });

});
</script>


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