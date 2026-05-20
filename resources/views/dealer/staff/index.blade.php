@include('dealer.layout.header')
<section class="section dashboard">

    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24">
            {{ __('seller_messages.Staff_Management') }}
        </div>

        <a href="{{ route('dealer.add-staff') }}" class="btn btn-success">
            {{ __('seller_messages.Add_New_Staff') }}
        </a>
    </div>

    <div class="datatable-wapper mt-5">
        <div class="table-header mb-2">

            <!-- Search -->
            <div class="search-field">
                <div class="from-group position-relative">
                    <img src="{{ asset('dealer') }}/assets/img/search-icon.svg"
                        alt="search"
                        class="search-icon">

                    <input type="search"
                        class="dt-input tableSearch form-control"
                        id="customTableSearch"
                        placeholder="{{ __('seller_messages.Search') }}"
                        aria-controls="datatable_search">
                </div>
            </div>

            <!-- Filters -->
            <form method="GET" action="">
                <div class="search-filter">

                    <!-- Date Filter -->
                    <div class="from-group">
                        <div class="show-date d-flex gap-2 flex-wrap">
                            <div class="date-form-pnl">
                                <input type="date"
                                    class="form-control datepicker"
                                    name="from"
                                    id="fromDate"
                                    value="{{ request()->from }}">
                                <p class="text-danger" id="error-start_date"></p>
                            </div>

                            <div class="date-form-pnl">
                                <input type="date"
                                    class="form-control datepicker"
                                    name="to"
                                    id="toDate"
                                    value="{{ request()->to }}">
                                <p class="text-danger" id="error-end_date"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div class="from-group">
                        <select name="status_filter"
                            class="form-select form-control width-50">

                            <option value="">
                                {{ __('seller_messages.Filter_by_status') }}
                            </option>

                            <option value="0">
                                {{ __('seller_messages.Active') }}
                            </option>

                            <option value="1">
                                {{ __('seller_messages.In_Active') }}
                            </option>
                        </select>
                    </div>

                    <!-- Role Filter -->
                    <div class="from-group">
                        <select name="role_filter"
                            class="form-select form-control width-50">

                            <option value="">
                                {{ __('seller_messages.Filter_by_Role') }}
                            </option>

                            <option value="1">
                                {{ __('seller_messages.Manager') }}
                            </option>

                            <option value="2">
                                {{ __('seller_messages.Officer') }}
                            </option>

                            <option value="3">
                                {{ __('seller_messages.Sales_Employee') }}
                            </option>
                        </select>
                    </div>

                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered datatable tablesearch" id="datatable_search">
                <thead>
                    <tr>
                        <th class="no-sort">{{ __('seller_messages.S.No') }}</th>
                        <th class="no-sort">{{ __('seller_messages.Image') }}</th>
                        <th class="no-sort">{{ __('seller_messages.Name') }}</th>
                        <th class="no-sort">{{ __('seller_messages.Phone_Number') }}</th>
                        <th class="no-sort">{{ __('seller_messages.Mail_ID') }}</th>
                        <th class="no-sort">{{ __('seller_messages.Role') }}</th>
                        <th class="no-sort">{{ __('seller_messages.Added_on') }}</th>
                        <th class="no-sort">{{ __('seller_messages.View_Modules') }}</th>
                        <th class="no-sort">{{ __('seller_messages.Edit') }}</th>
                        <th class="no-sort">{{ __('seller_messages.Inactive_Active') }}</th>
                        <th class="no-sort">{{ __('seller_messages.Delete') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($all_staff as $key => $val)
                        <tr>
                            <td>{{ $key + 1 }}</td>

                            <td>
                                <img src="{{ $val->profile_pic }}"
                                    class="img-fluid pro-image"
                                    alt="image"
                                    style="width:105px;height:65px;border-radius:5%;object-fit:cover;">
                            </td>

                            <td>{{ $val->first_name }}</td>

                            <td>
                                {{ $val->country_code }} {{ $val->mobile }}
                            </td>

                            <td>{{ $val->email }}</td>

                            <td>
                                {{ app()->getLocale() == 'ar' 
                                    ? $val->seller_category->name_ar 
                                    : $val->seller_category->name_en }}
                            </td>

                            <td>{{ formatDateTimeByLocale($val->created_at) }}</td>

                            <!-- View Modules -->
                            <td>
                                <a href="javascript:void(0)"
                                    data-bs-toggle="modal"
                                    data-bs-target="#showModule"
                                    class="eyebtn openModuleModal"
                                    data-id="{{ $val->id }}">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>

                            <!-- Edit -->
                            <td>
                                <a href="{{ route('dealer.editStaff', $val->id) }}"
                                    class="eyebtn">
                                    <img src="{{ asset('dealer') }}/assets/img/edit-ic.svg"
                                        alt="edit"
                                        class="img-fluid"
                                        width="18px">
                                </a>
                            </td>

                            <!-- Active/Inactive -->
                            <td>
                                <div class="d-flex justify-content-center">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input"
                                            type="checkbox" id="switchCheckDefault"
                                            role="switch"
                                            rel="{{ $val->id }}"
                                            @if ($val->is_block == 0) checked @endif>

                                        <label class="form-check-label"></label>
                                    </div>
                                </div>
                            </td>

                            <!-- Delete -->
                            <td>
                                <span class="eyebtn"
                                    id="deletestaff"
                                    rel="{{ $val->id }}">

                                    <img src="{{ asset('dealer') }}/assets/img/delete-ic.svg"
                                        alt="delete"
                                        class="img-fluid"
                                        width="18px">
                                </span>
                            </td>
                        </tr>

                   @endforeach
                </tbody>
            </table>
        </div>
    </div>

</section>

<!-- Show Module Modal -->
<div class="modal fade"
    id="showModule"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h1 class="modal-title fs-5">
                    {{ __('seller_messages.Module') }}
                </h1>

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>
            </div>

            <div class="modal-body" id="moduleData">
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

                    if (data.data.is_block == 0) {
                        toastr.success(data.message);

                    } else if (data.data.is_block === 1) {
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
        });


// Show menu permission

$(document).on("click", ".openModuleModal", function () {

    let id = $(this).data("id");

    // Show modal first
    $("#showModule").modal("show");

    // Show loader
    $("#moduleData").html("Loading...");

    $.ajax({
        url: "/seller/view-menu-permission", // your route
        type: "GET",
        data: { id: id },
        success: function (res) {

            let html = "";

            res.data.forEach((item, index) => {

                html += `
                <div class="d-flex justify-content-between mb-3">

                    <div class="form-check">
                        <label class="form-check-label"> @if(App::getlocale()=='ar') ${item.single_actionmenu.title_ar}  @else  ${item.single_actionmenu.title} @endif </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" ${item.can_view ? 'checked' : ''}>
                        <label class="form-check-label"> {{ __('seller_messages.View') }}</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" ${item.can_action ? 'checked' : ''}>
                        <label class="form-check-label"> {{ __('seller_messages.Action') }}</label>
                    </div>

                </div>
                `;
            });

            $("#moduleData").html(html);
        }
    });

});


document.addEventListener('DOMContentLoaded', function() {

    const fromDate = document.getElementById('fromDate');
    const toDate = document.getElementById('toDate');
    const form = fromDate.form;

    const today = new Date().toISOString().split('T')[0];

    fromDate.min = today;
    toDate.min = today;

    function canSubmit() {
        return (
            fromDate.value &&
            toDate.value &&
            fromDate.value >= today &&
            toDate.value >= fromDate.value
        );
    }

    fromDate.addEventListener('change', function() {

        if (this.value < today) {
            this.value = '';
            return;
        }

        toDate.min = this.value;

        if (toDate.value && toDate.value < this.value) {
            toDate.value = '';
        }

        if (canSubmit()) {
            form.submit();
        }
    });

    toDate.addEventListener('change', function() {

        if (fromDate.value && this.value < fromDate.value) {
            this.value = '';
            return;
        }

        if (canSubmit()) {
            form.submit();
        }
    });

    const statusFilter = document.querySelector('select[name="status_filter"]');

    statusFilter.addEventListener('change', function() {
        form.submit();
    });

    const roleFilter = document.querySelector('select[name="role_filter"]');

    roleFilter.addEventListener('change', function() {
        form.submit();
    });

});
</script>


@include('dealer.layout.languagetableCode');