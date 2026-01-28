@include('dealer.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center mb-5">
        <a class="title24 alink" href="{{ url()->previous() }} "> <i class="bi bi-chevron-left"></i> Details</a>
    </div>

    <div class="row mt-3">
        <div class="col-lg-6">
            <div class="deals-box mb-4 ">
                <img src="{{ $single_deal['deal_data']->image}}" alt="image">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="deal-deatils">
                <h4 class="greentitle">Starts From -{{ date('d M Y', strtotime($single_deal['deal_data']->from)) }}

                </h4>
                <div class="duration-table">
                    <table class="table table-borderless">
                        <tr>
                            <td>Duration - {{ $single_deal['deal_data']->from}} - {{ $single_deal['deal_data']->to}}
                            </td>
                            <td>Category - {{  $single_deal['deal_data']->category_details->name}}</td>
                        </tr>
                        <tr>
                            <td>Discount% - {{  $single_deal['deal_data']->discount }} %</td>
                            <td>Sub-Category - {{  $single_deal['deal_data']->subCategory_details->name_english}}</td>
                        </tr>
                    </table>
                    <p class="single-pad">{{  $single_deal['deal_data']->name_english }}</p>

                </div>
            </div>
        </div>
    </div>

    <div class="search-field d-flex justify-content-between align-item-center">
        <h5>Select Product</h5>
        <div class="from-group position-relative">
            <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search" class="search-icon">
            <input type="search" class="form-control tableSearch" placeholder="Search" data-table="table2">
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered datatable tablesearch" id="table2">
            <thead>
                <tr>
                    <th class="no-sort">Add</th>
                    <th class="no-sort">S.No</th>
                    <th class="no-sort">Banner Image</th>
                    <th class="no-sort">Name</th>
                    <th class="no-sort">Brand</th>
                    <th class="no-sort">Rating</th>
                    <th class="no-sort">Price</th>
                </tr>
            </thead>
            <tbody>

                <form id="addToDealsForm">

                    @foreach($single_deal['remaining_Product'] as $key=>$val)

                    <tr>
                        <td>
                            <div class="d-flex justify-content-center">
                                <div class="form-check">
                                    <input class="form-check-input productCheckbox" type="checkbox" name="product_ids[]"
                                        value="{{$val->id}}">
                                </div>
                            </div>
                        </td>
                        <td>{{$key+1}}</td>
                        <td>
                            <div class="deal-img">
                                <img src="{{$val->product_variants['0']->variant_image['0'] }}" alt="image"
                                    class="img-fluid">
                            </div>
                        </td>
                        <td>{{$val->product_name_en }}</td>
                        <td>{{$val->brand->name_english }}</td>
                        <td><i class="bi bi-star-fill yellow-star"></i> {{$val->avg_product_rating }}</td>
                        <td>{{$val->product_variants['0']->final_price}} KD</td>
                    </tr>
                    @endforeach

            </tbody>
        </table>
    </div>

    <div class="dashboard-button mt-4">
        <button type="submit" id="addToDealsBtn" class="btn add-fillbtn w-100">Add to Deals</button>
    </div>

    </form>

</section>



<!-- Modal -->
<div class="modal fade" id="succesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="p-4 text-center">
                    <img alt="image" src="{{ asset('/dealer') }}/assets/img/success.svg">
                    <h5 class="mt-3">Products Added Successfully!</h5>
                </div>
            </div>

        </div>
    </div>
</div>




<script>
$(document).ready(function() {

    $('#addToDealsBtn').on('click', function() {

        let productIds = [];

        $('input[name="product_ids[]"]:checked').each(function() {
            productIds.push($(this).val());
        });

        if (productIds.length === 0) {
            // alert('Please select at least one product.');
            toastr.error("Please select at least one product.");
            return;
        }

        $.ajax({
            url: "{{ route('seller.add-single-deal-management',Request()->id ) }}", // your Laravel route
            type: "POST",
            data: {
                product_ids: productIds,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                // alert('Products added to deals successfully!');
                console.log(response);

                // toastr.success(response.message);

                $('#succesModal').modal('show');

                window.setTimeout(function() {
                    window.location =
                        "{{ route('seller.View-single-deal-management',request()->id)}}";
                }, 1000);

            },
            error: function(xhr) {
                console.log(xhr.responseText);
                toastr.error("Something went wrong");
                // alert('Something went wrong.');
            }
        });
    });

});



// Data Tbale Search Code 

$(document).ready(function() {

    let table2;

    if (!$.fn.DataTable.isDataTable('#table2')) {
        table2 = $('#table2').DataTable({
            paging: true,
            ordering: true,
            info: true,
            searching: true
        });
    } else {
        table2 = $('#table2').DataTable();
    }

    $('.tableSearch').on('keyup', function() {
        table2.search(this.value).draw();
    });

});


$(document).ready(function() {

    function toggleAddButton() {
        const anyChecked = $('.productCheckbox:checked').length > 0;
        $('#addToDealsBtn').prop('disabled', !anyChecked);
    }

    // Run on checkbox change
    $(document).on('change', '.productCheckbox', function() {
        toggleAddButton();
    });

    // Initial state
    toggleAddButton();
});
</script>




@include('dealer.layout.custom_code');

@include('dealer.layout.footer');