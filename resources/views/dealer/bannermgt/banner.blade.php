@include('dealer.layout.header')

<style>
td img {
    width: 65px;
    height: 65px !important;
    border-radius: 50%;
    object-fit: fill;
    "

}

td {
    max-width: 200px;
    text: truncate;
}

table#table1 {
    text-align: center;
}
</style>

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24">Banner Management</div>
        <a href="{{route('seller.add_banner')}}" class="btn btn-success">Add New Banner</a>

    </div>
    <div class="datatable-wapper mt-4">
        <div class="table-header">
            <div class="search-field">
                <div class="from-group position-relative">
                    <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search" class="search-icon">
                    <input type="search" class="form-control tableSearch" placeholder="Search" data-table="table1">

                </div>
            </div>

            <form method="GET" action="">

                <input type="hidden" name="type" value="0">

                <div class="search-filter">
                    <div class="from-group">
                        <div class="show-date d-flex gap-2  flex-wrap">
                            <div class="date-form-pnl">
                                <input type="date" class="form-control">
                            </div>
                            <div class="date-form-pnl">
                                <input type="date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="from-group">
                        <select class="form-select form-control width-50" aria-label="Default select example"
                            name="brand_filter" onchange="this.form.submit()">
                            <option value="">Filter by status</option>

                            <option value="">
                            </option>

                        </select>
                    </div>
                </div>

            </form>
        </div>


        <div class="table-responsive">
            <table class="table  table-bordered " id="table1">
                <thead>
                    <tr>
                        <th class="no-sort">S.No</th>
                        <th class="no-sort"> Banner Image</th>
                        <th class="no-sort">Request Id</th>
                        <th class="no-sort">Requested On</th>
                        <th class="no-sort">Total Amount</th>
                        <th class="no-sort">status</th>
                        <th class="no-sort">
                            View more details
                        </th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($banners as $key=>$val)

                    <tr>
                        <td>{{$key+1}}</td>
                        <td>

                            <img src="{{$val->upload_banner}}" class="img-fluid" alt="image" class="pro-image"
                                style="width: 65px;height: 65px;border-radius: 50%;object-fit: cover;">


                        </td>
                        <td> {{$val->order_id}}</td>
                        <td>{{$val->created_at}}</td>
                        <td> {{$val->price}} KD </td>
                        <td>
                            @if($val->Admin_verify=='0')
                            Pending
                            @elseif($val->Admin_verify=='1')
                            COnfirmed
                            @else
                            Rejected
                            @endif


                        </td>
                        <td>
                            <a href="{{route('seller.show_single_banner',$val->id)}}" class="eyebtn"><i
                                    class="bi bi-eye"></i></a>
                        </td>
                    </tr>

                    @endforeach




                </tbody>
            </table>
        </div>
    </div>


</section>


@include('dealer.layout.custom_code');



@include('dealer.layout.footer');