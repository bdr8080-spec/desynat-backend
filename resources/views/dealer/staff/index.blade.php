@include('dealer.layout.header')

<section class="section dashboard">
  
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24">Staff Management</div>
        <a href="{{route('dealer.add-staff')}}" class="btn btn-success">Add New Staff</a>
    </div>

    <div class="datatable-wapper mt-5">
        <div class="table-header mb-2">
            <div class="search-field">
                <div class="from-group position-relative">
                    <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search" class="search-icon">
                    <input type="search" class="dt-input tableSearch form-control" id="customTableSearch"
                        placeholder="Search" aria-controls="table1">
                </div>
            </div>

            <form method="GET" action="">
                <div class="search-filter">
                    <div class="from-group">
                        <div class="show-date d-flex gap-2  flex-wrap">
                            <div class="date-form-pnl">
                                <input type="date" class="form-control" name="from" id="fromDate"
                                    value="{{request()->from }}">
                                <p class="text-danger" id="error-start_date"></p>
                            </div>
                            <div class="date-form-pnl">
                                <input type="date" class="form-control" name="to" id="toDate"
                                    value="{{request()->to }}">

                                <p class="text-danger" id="error-end_date"></p>
                            </div>
                        </div>
                    </div>

                    <div class="from-group">
                        <select class="form-select form-control width-50" aria-label="Default select example">
                            <option value="">Filter by status</option>
                            <option value="1"> Active </option>
                            <option value="2"> confirmed </option>
                        </select>
                    </div>
                    <div class="from-group">
                        <select class="form-select form-control width-50" aria-label="Default select example">
                            <option value="">Filter by Role</option>
                            <option value="1"> Active </option>
                            <option value="2"> confirmed </option>
                        </select>
                    </div>


                </div>

            </form>
        </div>


        <div class="table-responsive">
            <table class="table table-bordered datatable tablesearch" id="table1">
                <thead>
                    <tr>
                        <th class="no-sort">S.No</th>
                        <th class="no-sort">Image</th>
                        <th class="no-sort">Name</th>
                        <th class="no-sort">Phone Number</th>
                        <th class="no-sort">Mail ID</th>
                        <th class="no-sort">Role</th>
                        <th class="no-sort">Added on</th>
                        <th class="no-sort">View Modules</th>
                        <th class="no-sort">Edit</th>
                        <th class="no-sort">Active/Inactive </th>
                        <th class="no-sort">Delete</th>
                    </tr>
                </thead>
                <tbody>

                @forelse($all_staff as $key=>$val)

                    <tr>
                        <td>{{$key+1}}</td>
                        <td>
                            <img src="{{$val->profile_pic}}" class="img-fluid" alt="image" class="pro-image" style="width: 105px;height: 65px;border-radius: 5%;object-fit: cover;">
                        </td>
                        <td> {{$val->first_name}}</td>
                        <td>{{$val->country_code}} {{$val->mobile}} </td>
                        <td>{{$val->email}} </td>
                        <td>{{$val->seller_category->name_en}}</td>

                        <td>{{$val->created_at->format('Y-m-d')}}</td>
                        <td>
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#showModule" class="eyebtn"><i class="bi bi-eye"></i></a>
                        </td>
                        <td>
                            <a href="#" class="eyebtn">
                                <img src="{{ asset('dealer') }}/assets/img/edit-ic.svg" alt="edit" class="img-fluid" width="18px">
                            </a>
                        </td>
                        
                          <td>
                            <div class="d-flex justify-content-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="switchCheckDefault" rel="{{ $val->id }}"
                                        @if ($val->is_block == 1) checked @endif>
                                    <label class="form-check-label" for="switchCheckDefault"></label>
                                </div>
                            </div>
                        </td>

                        <td>
                            <span class="eyebtn" id="deletestaff"  rel="{{ $val->id }}">
                                <img src="{{ asset('dealer') }}/assets/img/delete-ic.svg" alt="delete" class="img-fluid" width="18px">
                            </span>
                        </td>
                    </tr>

                    @empty


                    No data found


                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

</section>

<!-- Success Modal -->
<div class="modal fade" id="showModule" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Module</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

        
            <div class="d-flex gap-2 justify-content-between w-100 mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="checkDefault">
                    <label class="form-check-label" for="checkDefault">
                        Module
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="checkDefault">
                    <label class="form-check-label" for="checkDefault">
                        View
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="checkDefault">
                    <label class="form-check-label" for="checkDefault">
                        Action
                    </label>
                </div>
            </div>
            
</div>
           
        </div>
    </div>
</div>




@include('dealer.layout.custom_code');
@include('dealer.layout.footer');

<script>
$(document).ready(function() {
    $('#customTableSearch').on('keyup search', function() {
        let value = $(this).val().toLowerCase().trim();

        $('.tablesearch tbody tr').each(function() {
            let rowText = $(this).text().toLowerCase();

            if (value === "") {
                // input empty → show all rows
                $(this).show();
            } else {
                // match text
                $(this).toggle(rowText.indexOf(value) > -1);
            }
        });
    });
});


 $('body').on('click', '#switchCheckDefault', function() {
            //alert('Hello');
            var id = $(this).attr('rel');
            //alert(id)
            $.ajax({
                url: "{{ url('seller/active-and-inactive-staff') }}",
                type: "get",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                dataType: "json",
                beforeSend: function() {
                    $('#loader').show()
                },
                success: function(data) {

                    if (data.data.is_block == 1) {
                        toastr.success(data.message);

                    } else if (data.data.is_block === 0) {
                        toastr.error(data.message);

                    } else {
                        toastr.error("<?php echo 'Unexpected_response_from_server'; ?>");
                    }

                    // setInterval(() => {
                    //     window.location.reload();
                    // }, 1000);


                },
                error: function() {
                    alert("Fail")
                },
                 complete: function() {
                    $('#loader').hide()
                },
            })
        })


 $('body').on('click', '#deletestaff', function() {
            //alert('Hello');
            var id = $(this).attr('rel');
            //alert(id)
            $.ajax({
                url: "{{ url('seller/delete-staff') }}",
                type: "get",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                dataType: "json",
                beforeSend: function() {
                    $('#loader').show()
                },
                success: function(data) {

                    toastr.success(data.message);
                    setInterval(() => {
                        window.location.reload();
                    }, 1000);
                },
                error: function() {
                    alert("Fail")
                },
                 complete: function() {
                    $('#loader').hide()
                },
            })
        })

</script>