@include('dealer.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center mb-5">
        <a class="title24 alink" href="#"> <i class="bi bi-chevron-left"></i> Details</a>
    </div>

    <div class="row mt-3">
        <div class="col-lg-6">
            <div class="deals-box mb-4 ">
                <img src="{{ $single_deal['deal_data']->image}}" alt="image">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="deal-deatils">
                <h4>Starts From - {{ $single_deal['deal_data']->from}}</h4>
                <div class="duration-table">
                    <table class="table">
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
        <table class="table table-bordered datatable tablesearch" id="table1">
            <thead>
                <tr>
                    <th class="no-sort">Add</th>
                    <th class="no-sort">S.No</th>
                    <th class="no-sort">Banner Image</th>
                    <th class="no-sort">Name</th>
                    <th class="no-sort">Brand</th>
                    <th class="no-sort">Rating</th>
                    <th class="no-sort">KD</th>
                </tr>
            </thead>
            <tbody>

                @foreach($single_deal['remaining_Product'] as $key=>$val)

                <tr>
                    <td>
                        <div class="d-flex justify-content-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox">
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
                    <td><i class="bi bi-star-fill"></i> 4.0</td>
                    <td>{{$val->product_variants['0']->actual_price}}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    <div class="dashboard-button mt-4">
        <button type="submit" class="btn add-fillbtn w-100">Add to Deals</button>
    </div>



</section>






@include('dealer.layout.custom_code');

@include('dealer.layout.footer');