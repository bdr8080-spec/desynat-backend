@include('affiliatedUser.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl">
        <div class="title24">Category </div>
    </div>

    <div class="search-field d-flex align-items-center py-4">
        <div class="from-group position-relative w-100">
            <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search" class="search-icon2">
            <input type="search" class="form-control py-3" placeholder="Search">
        </div>
        <button type="button" class="btn btn-success searchlin">Search</button>
    </div>

    <div class="tabs-panel py-3">

        <div class="tabs-panel py-3">
            <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab">
                @foreach($category as $key=>$val)

                <li class="nav-item">
                    <button class="nav-link w-100 category-tab @if($key=='0') active @endif"
                        data-category="{{$val->id}}">
                        {{$val->name}}
                    </button>
                </li>

                @endforeach

            </ul>
        </div>

    </div>

    <div id="show-subcategory">
        <!-- show subcategory code here  -->
    </div>

</section>




<script src="{{ asset('/dealer') }}/assets/custom-file/js/jquery.min.js"></script>


<script>
$(document).ready(function() {

    let selectedCategory = $('.category-tab.active').data('category') || 'all';
    let selectedSubcategory = $('.subcategory-item.active').data('subcategory') || 'all';

    // 🔹 Load Subcategories (ONLY when category changes)
    function loadSubcategories() {

        let searchValue = $('input[type="search"]').val(); // 🔍 get search text


        $.ajax({
            url: "{{ route('affiliate.allsubcategory') }}",
            type: "GET",
            data: {
                category: selectedCategory,
                 search: searchValue 
            },
            beforeSend: function() {
                $('#show-subcategory').html('<p>Loading...</p>');
            },
            success: function(response) {
                $('#show-subcategory').html(response);
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
    });


     $('.searchlin').on('click', function() {
        loadSubcategories();
    });


    // 🔥 On page load
    loadSubcategories();

});
</script>



@include('affiliatedUser.layout.footer')