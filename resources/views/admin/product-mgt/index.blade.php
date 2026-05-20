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
            <h2 class="h2">{{ __('admin_messages.product_management') }}</h2>
        </div>

        <div class="col-lg-3 col-md-4 col-12">
            @if(in_array(22, $permissions) || $admin->type == 1)
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.export_products_data', request()->all()) }}" class="btn btn-dark customBtn" href="">
                    <span>{{ __('admin_messages.export') }}</span>
                </a>
            </div>
            @endif
        </div>
    </div>

    <div class="userManagecontent">
        <div class="mt-4">
            <form method="GET" action="{{ route('admin.productManagement') }}" id="filterForm">
            <div class="row align-items-end">
                <div class="col-lg-2 col-md-12 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="status" class="form-label">{{ __('admin_messages.select_country') }}</label>
                        <select name="country" id="country"
                            class="form-select form-select-lg "
                            onchange="document.getElementById('filterForm').submit();">
                            <option value="">{{ __('admin_messages.select_country') }}</option>
                            @foreach($countries as $country)
                            <option value="{{ $country['id'] }}"
                                {{ request('country') == $country['id'] ? 'selected' : '' }}>
                                @if(app()->getLocale() == 'en')
                                {{ $country['name'] }}
                                @else
                                {{ $country['name_ar'] }}
                                @endif
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-12 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="status" class="form-label">{{ __('admin_messages.select_category') }}</label>
                        <select name="category" id="category"
                            class="form-select form-select-lg "
                            onchange="document.getElementById('filterForm').submit();">
                            <option value="">{{ __('admin_messages.select_category') }}</option>
                            @foreach($categories as $category)
                            <option value="{{ $category['id'] }}"
                                {{ request('category') == $category['id'] ? 'selected' : '' }}>
                                @if(app()->getLocale() == 'en')
                                {{ $category['name'] }}
                                @else
                                {{ $category['name_ar'] }}
                                @endif
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-2 col-md-12 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="status" class="form-label">{{ __('admin_messages.select_sub_category') }}</label>
                        <select name="subcategory" id="subcategory"
                            class="form-select form-select-lg "
                            onchange="document.getElementById('filterForm').submit();">
                            <option value="">{{ __('admin_messages.select_sub_category') }}</option>
                            @foreach($subcategories as $subcategory)
                            <option value="{{ $subcategory['id'] }}"
                                {{ request('subcategory') == $subcategory['id'] ? 'selected' : '' }}>
                                @if(app()->getLocale() == 'en')
                                {{ $subcategory['name_english'] }}
                                @else
                                {{ $subcategory['name_arabic'] }}
                                @endif
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-12">
                    <div class="form-group mt-4 w-100">
                        <label for="status" class="form-label">{{ __('admin_messages.select_brand') }}</label>
                        <select name="brand" id="brand"
                            class="form-select form-select-lg "
                            onchange="document.getElementById('filterForm').submit();">
                            <option value="">{{ __('admin_messages.select_brand') }}</option>
                            @foreach($brands as $brand)
                            <option value="{{ $brand['id'] }}"
                                {{ request('brand') == $brand['id'] ? 'selected' : '' }}>
                                @if(app()->getLocale() == 'en')
                                {{ $brand['name_english'] }}
                                @else
                                {{ $brand['name_arabic'] }}
                                @endif
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-1 col-md-4 col-12 ">
                    <div class="d-flex gap-3 justify-content-end" >
                        <a href="{{route('admin.productManagement')}}" class="btn btn-dark customBtn"
                            style="margin-top: 60px">
                            <span>{{ __('admin_messages.reset') }}</span>
                        </a>
                    </div>
                </div>
            </div>
            </form>

            <div class="table-responsive w-100 mt-4">
                <table id="myTable" class="table w-100">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('admin_messages.s_no') }}</th>
                            <th scope="col">{{ __('admin_messages.seller_name') }}</th>
                            <th scope="col">{{ __('admin_messages.country') }}</th>
                            <th scope="col">{{ __('admin_messages.image') }}</th>
                            <th scope="col">{{ __('admin_messages.category') }}</th>
                            <th scope="col">{{ __('admin_messages.sub_category') }}</th>
                            <th scope="col">{{ __('admin_messages.brand') }}</th>
                            <th scope="col">{{ __('admin_messages.product_name') }}</th>
                            <th scope="col">{{ __('admin_messages.description') }}</th>
                            <th scope="col">{{ __('admin_messages.specification') }}</th>
                            <th scope="col">{{ __('admin_messages.actual_price') }}</th>
                            <th scope="col">{{ __('admin_messages.size_chart') }}</th>
                            <th scope="col">{{ __('admin_messages.view_variants') }}</th>
                            <th scope="col">{{ __('admin_messages.more_details') }}</th>
                            <th scope="col">{{ __('admin_messages.rating') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $index => $product)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{$product['seller_details']['first_name'] ?? __('admin_messages.na')}} {{$product['seller_details']['last_name'] ?? ''}}</td>
                            <td>
                                @if(app()->getLocale() == 'en')
                                {{$product['store']['country_info']['name']?? __('admin_messages.na')}}
                                @else
                                {{$product['store']['country_info']['name_ar']?? __('admin_messages.na')}}
                                @endif
                            </td>
                            <td>
                                <img src="{{$product['product_variants'][0]['variant_image'][0]}}" alt="Profile Image" width="40px" height="40px"
                                    class="square" />
                            </td>
                            <td>
                                @if(app()->getLocale() == 'en')
                                {{$product['category']['name']}}
                                @else
                                {{$product['category']['name_ar']}}
                                @endif
                            </td>
                            <td>
                                @if(app()->getLocale() == 'en')
                                {{$product['subcategory']['name_english'] ?? __('admin_messages.na')}}
                                @else
                                {{$product['subcategory']['name_arabic'] ?? __('admin_messages.na')}}
                                @endif
                            </td>
                            <td>
                                @if(app()->getLocale() == 'en')
                                {{$product['brand']['name_english']?? __('admin_messages.na')}}
                                @else
                                {{$product['brand']['name_arabic']?? __('admin_messages.na')}}
                                @endif
                            </td>
                            <td>
                                @if(app()->getLocale() == 'en')
                                {{$product['product_name_en']}}
                                @else
                                {{$product['product_name_ar']}}
                                @endif
                            </td>
                            <td>
                                <a class="table-button view-description-btn"
                                type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#sentModal1"
                                data-description="{{ app()->getLocale() == 'en' ? $product['description_en'] : $product['description_ar'] }}">
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
                            <td>{{$product['product_variants'][0]['actual_price']}} {{__('admin_messages.kd')}}</td>
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
                <h2 class="h2">{{ __('admin_messages.description') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-12">

                            <div class="mb-3">
                                <p class="fw-normal" id="modalDescription"></p>
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
                <h3 class="modal-title fs-5">{{ __('admin_messages.specification') }}</h3>
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
                <h3 class="modal-title fs-5">{{ __('admin_messages.variant') }}</h3>
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
                <h5 class="modal-title">{{ __('admin_messages.size_chart') }}</h5>
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
                <h3 class="modal-title fs-5">{{ __('admin_messages.more_details') }}</h3>
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
                tableBody.innerHTML = '<tr><td colspan="2">{{ __("admin_messages.no_specifications_found") }}</td></tr>';
                return;
            }

            const locale = "{{ app()->getLocale() }}";

            specs.forEach(spec => {
                const row = `
                    <tr>
                        <th>${locale === 'en' ? spec.name_en : spec.name_ar}</th>
                        <td>${locale === 'en' ? spec.feature_en : spec.feature_ar}</td>
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
        return (value === null || value === undefined || value === '') ?  "{{ __('admin_messages.na') }}" : value;
    }

    buttons.forEach(button => {
        button.addEventListener('click', function () {

            const variants = JSON.parse(this.getAttribute('data-variants'));
            container.innerHTML = '';

            if (!variants || variants.length === 0) {
                container.innerHTML = '<p class="text-muted">{{ __("admin_messages.no_variants_found") }}</p>';
                return;
            }

            variants.forEach((variant, index) => {

                let discountText = '';
               if (variant.discount_value) {
                    discountText = variant.discount_value +
                        (variant.discount_type == 1 ? ' %' : ' {{ __("admin_messages.kd") }}');
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
                const locale = "{{ app()->getLocale() }}";

                const html = `
                <div class="variant-box ${index !== 0 ? 'mt-4' : ''}">
                    <h6 class="variant-heading">{{ __("admin_messages.variant") }} ${index + 1}</h6>

                    <div class="variant-inner">
                    
                        <div class="variant-left">

                            ${createRow("{{ __('admin_messages.color') }}", locale === 'en' ? variant.color?.name : variant.color?.name_ar)}
                            ${createRow("{{ __('admin_messages.size') }}", locale === 'en' ? variant.size?.name : variant.size?.name_ar)}
                            ${createRow("{{ __('admin_messages.bust') }}", variant.bust)}
                            ${createRow("{{ __('admin_messages.waist') }}", variant.waist)}
                            ${createRow("{{ __('admin_messages.hip') }}", variant.hip)}
                            ${createRow("{{ __('admin_messages.shoulder') }}", variant.shoulder)}
                            ${createRow("{{ __('admin_messages.sleeve_length') }}", variant.sleeve_length)}
                            ${createRow("{{ __('admin_messages.length') }}", variant.length)}
                            ${createRow("{{ __('admin_messages.total_stock') }}", variant.total_stock)}
                            ${createRow("{{ __('admin_messages.sku') }}", variant.sku)}
                            ${createRow("{{ __('admin_messages.price') }}", variant.actual_price, " {{ __('admin_messages.kd') }}")}
                            ${createRow("{{ __('admin_messages.discount') }}", discountText)}

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
        return value == 1 ? "{{ __('admin_messages.yes') }}" : "{{ __('admin_messages.no') }}";
    }

    function valueOrNA(value) {
        return (value === null || value === '') ? "{{ __('admin_messages.na') }}" : value;
    }

    buttons.forEach(button => {
        button.addEventListener('click', function () {

            const product = JSON.parse(this.getAttribute('data-product'));
            tableBody.innerHTML = '';

            const rows = [
                ["{{ __('admin_messages.min_cart_value') }}", valueOrNA(product.min_card_quantity)],
                ["{{ __('admin_messages.max_cart_value') }}", valueOrNA(product.max_card_quantity)],
                ["{{ __('admin_messages.product_refundable') }}", yesNo(product.product_return)],
                ["{{ __('admin_messages.review_rating_allowed') }}", yesNo(product.review_rating)],
                ["{{ __('admin_messages.affiliate_products') }}", yesNo(product.affiliated_product)],
                ["{{ __('admin_messages.customized_products') }}", yesNo(product.customized_product)],
                ["{{ __('admin_messages.ready_to_ship') }}", yesNo(product.ready_to_ship)],
                ["{{ __('admin_messages.cash_on_delivery_allowed') }}", yesNo(product.cash_on_delivery)],
                ["{{ __('admin_messages.return_days') }}", valueOrNA(product.return_days)],
                ["{{ __('admin_messages.exchange_days') }}", valueOrNA(product.exchangable_days)]
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