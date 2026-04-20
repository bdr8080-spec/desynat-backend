@include('dealer.layout.header')

<section class="section dashboard">
  
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24">Staff Management</div>
        <a href="/add-staff" class="btn btn-success">Add New Staff</a>
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

                    <tr>
                        <td>01</td>
                        <td>
                            <img src="#" class="img-fluid" alt="image" class="pro-image" style="width: 105px;height: 65px;border-radius: 5%;object-fit: cover;">
                        </td>
                        <td> Ankit</td>
                        <td>123456789</td>
                        <td>ankit@gmail.com </td>
                        <td>Manager</td>
                        <td>21/02/2026</td>
                        <td>
                            <a href="#" class="eyebtn"><i class="bi bi-eye"></i></a>
                        </td>
                        <td>
                            <a href="#" class="eyebtn">
                                <img src="{{ asset('dealer') }}/assets/img/edit-ic.svg" alt="edit" class="img-fluid" width="18px">
                            </a>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="switchinactive">
                                    <label class="form-check-label" for="switchinactive"></label>
                                </div>
                            </div>
                        </td>

                        <td>
                            <a href="#" class="eyebtn">
                                <img src="{{ asset('dealer') }}/assets/img/delete-ic.svg" alt="delete" class="img-fluid" width="18px">
                            </a>
                        </td>
                    </tr>

                  

                </tbody>
            </table>
        </div>
    </div>




</section>


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


</script>