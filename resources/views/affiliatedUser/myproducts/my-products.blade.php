@include('affiliatedUser.layout.header')


<style>
.all-product-lists.active {
    border: 2px solid #000;
    background-color: #f8f8f8;
    cursor: pointer;
}
</style>


<section class="section dashboard">
    <div class="d-flex justify-content-between mt-4 mb-5">
        <a href="/category" class="title24 alink">
            <i class="bi bi-chevron-left"></i> My Product
        </a>
    </div>
    <div class="search-field d-flex align-items-center mb-4">
        <div class="from-group position-relative w-100">
            <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search" class="search-icon2">
            <input type="search" class="form-control py-3" placeholder="Search">
        </div>
        <button type="button" class="btn btn-success searchlin">Search</button>
    </div>

    <div class="tabs-panel py-3">

        <div class="tabs-panel py-3">
            <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab">

                <li class="nav-item">
                    <button class="nav-link active w-100 category-tab" data-category="all">
                        All
                    </button>
                </li>

                @foreach($category as $key=>$val)

                <li class="nav-item">
                    <button class="nav-link w-100 category-tab " data-category="{{$val->id}}">
                        {{$val->name}}
                    </button>
                </li>

                @endforeach

            </ul>
        </div>

        <!-- Product Show Code  -->

        <div class="tab-body-wapper">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-allproduct" role="tabpanel"
                    aria-labelledby="pills-allproduct-tab" tabindex="0">

                    <div class="personl-wapper">
                        <div class="row">
                            <div class="col-lg-3">

                                <div class="all-tabs">

                                    <div id="product-subcategory">
                                        <!-- code Write Here  -->
                                    </div>


                                </div>
                            </div>


                            <div class="col-lg-9">
                                <div id="product-container">
                                    <!-- code Write Here  -->
                                </div>

                            </div>


                        </div>
                    </div>
                </div>

            </div>
        </div>


</section>


<script src="{{ asset('/dealer') }}/assets/custom-file/js/jquery.min.js"></script>


<script>
$(document).ready(function() {

    let selectedCategory = $('.category-tab.active').data('category') || 'all';
    let selectedSubcategory = $('.subcategory-item.active').data('subcategory') || 'all';

    // 🔹 Load Subcategories (ONLY when category changes)
    function loadSubcategories() {
        $.ajax({
            url: "{{ route('affiliate.myProductFiltersubcategory') }}",
            type: "GET",
            data: {
                category: selectedCategory
            },
            beforeSend: function() {
                $('#product-subcategory').html('<p>Loading...</p>');
            },
            success: function(response) {
                $('#product-subcategory').html(response);
            }
        });
    }

    // 🔹 Load Products
    function loadProducts() {
        $.ajax({
            url: "{{ route('affiliate.Myproductfilter') }}",
            type: "GET",
            data: {
                category: selectedCategory,
                subcategory: selectedSubcategory
            },
            beforeSend: function() {
                $('#product-container').html('<p>Loading...</p>');
            },
            success: function(response) {
                $('#product-container').html(response);
            }
        });
    }

    // ✅ Category Click → Load BOTH
    $(document).on('click', '.category-tab', function() {

        $('.category-tab').removeClass('active');
        $(this).addClass('active');

        selectedCategory = $(this).data('category');
        selectedSubcategory = 'all';

        loadSubcategories(); // 🔥 only here
        loadProducts(); // 🔥 and here
    });

    // ✅ Subcategory Click → Load ONLY Products
    $(document).on('click', '.subcategory-item', function(e) {

        e.preventDefault();

        $('.subcategory-item').removeClass('active');
        $(this).addClass('active');

        selectedSubcategory = $(this).data('subcategory');

        loadProducts(); // 🔥 only this route
    });

    // 🔥 On page load
    loadSubcategories();
    loadProducts();

});
</script>

@include('affiliatedUser.layout.footer')