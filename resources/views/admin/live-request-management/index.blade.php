@extends('admin.layout.app')
@section('content')

<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">Live Request & Timeslot Managemen</h2>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <ul class="nav nav-pills mb-4 tabs-pnl custom" id="pills-tab" role="tablist">
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-order-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order"
                    aria-selected="true">
                    Live Request Timeslot
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link active customBtn2 m-0" id="pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="true">
                    Live Requests
                </button>
            </li>
        </ul>
    </div>
    <div class="userManagecontent">
        <form method="GET" action="{{ route('admin.liveRequestManagement') }}" id="filterForm">
        <div class="tab-content" id="pills-tabContent">

            <div class="tab-pane fade" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab" tabindex="0">
                <div class="row">
                    <div class="align-items-end d-flex">

                        <div class="col-lg-6">
                            <div class="align-items-end d-flex">
                                <div class="form-group mb-5 w-100">
                                    <select name="country_id"
                                        class="form-select form-select-lg "
                                        onchange="document.getElementById('filterForm').submit();">
                                        <option value="">Select country</option>
                                        @foreach($countries as $country)
                                        <option value="{{ $country['id'] }}"
                                            {{ request('country_id') == $country['id'] ? 'selected' : '' }}>
                                            {{ $country['name'] }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6 ">
                            <div class="d-flex gap-3 justify-content-end">


                                <a class="btn btn-dark customBtn " style="margin-top: 60px" data-bs-toggle="modal"
                                    data-bs-target="#sentModal3">
                                    <span>Add Timeslot</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- full calender -->

                <div class="container-2 mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-5">
                                <div id="calendar"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Selected Date & Timeslot UI -->
                            <div id="timeslotSection" style="display:none; margin-top:40px">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h3 id="selectedDateText" class="fw-bold"></h3>
                                </div>

                                <div class="row g-3">
                                    <!-- Timeslot Card -->
                                     @forelse($timeslots as $index => $slot)
                                    <div class="col-md-4">
                                        <div class="timeslot-card d-flex">
                                            <div class="timeslot-card active">
                                                <!-- <span>10 AM - 11 AM</span> -->
                                                 <span>{{$slot['from']}}- {{$slot['to']}}</span>
                                            </div>
                                            <div class="actions">
                                                <i class="bi bi-pencil"></i>
                                                <i class="bi bi-toggle-on text-success"></i>
                                                <i class="bi bi-trash"></i>
                                            </div>
                                        </div>
                                    </div>
                                     @empty
                                    <tr>
                                        <span class="text-center">No slots found</span>
                                    </tr>
                                    @endforelse
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Return -->
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                tabindex="0">
                <div class="d-flex justify-content-center">
                    <ul class="nav nav-pills mb-3 tabs-pnl custom" id="pills-tab" role="tablist">
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link customBtn2 m-0" id="pills-new-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-new" type="button" role="tab" aria-controls="pills-new"
                                aria-selected="true">
                                New Requests
                            </button>
                        </li>
                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link  active customBtn2 m-0" id="pills-approved-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-approved" type="button" role="tab"
                                aria-controls="pills-approved" aria-selected="true">
                                Approved
                            </button>
                        </li>

                        <li class="nav-item m-1" role="presentation">
                            <button class="nav-link  customBtn2 m-0" id="pills-reject-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-reject" type="button" role="tab" aria-controls="pills-reject"
                                aria-selected="false">
                                Rejected
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="userManagecontent">
                    <div class="tab-content" id="pills-tabContent">
                        <!-- Exchange -->

                        <div class="tab-pane fade" id="pills-new" role="tabpanel" aria-labelledby="pills-new-tab"
                            tabindex="0">
                            <div class="row">
                                <div class="align-items-end d-flex gap-3">
                                    <div class="search-box" style="position: relative">
                                        <i class="bi bi-search" style="
                                  position: absolute;
                                  left: 10px;
                                  top: 50%;
                                  transform: translateY(-50%);
                                  font-size: 16px;
                                  color: #888;
                                ">
                                        </i>
                                        <input type="text" class="form-control" placeholder="Search for..."
                                            style="padding-left: 35px" />
                                    </div>
                                    <div class="form-group w-25">
                                        <!-- <label for="from" class="form-label">Country Name</label> -->
                                        <select class="form-select form-select-lg" aria-label="Large select example">
                                            <option selected>Select Country</option>
                                            <option value="1">country One</option>
                                            <option value="2">country Two</option>
                                            <option value="3">country Three</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive mt-5 w-100">
                                <table class="table w-100">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sr.No</th>
                                            <th scope="col">Request ID</th>
                                            <th scope="col">Seller Name</th>
                                            <th scope="col">Seller Country</th>
                                            <th scope="col">Request On</th>
                                            <th scope="col">Live Date & Time</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>#22222</td>
                                            <td>lorem</td>
                                            <td>UAE</td>
                                            <td>2nd September 2025 | 11 Am</td>
                                            <td>10th September 2025 | 12 PM</td>
                                            <td>
                                                <div class="d-flex gap-3 justify-content-center">
                                                    <a class="table-button" type="button"><i
                                                            class="bi bi-check-circle-fill"></i></a>

                                                    <a class="table-button" data-bs-toggle="modal"
                                                        data-bs-target="#sentModal2" type="button">
                                                        <i class="bi bi-x-circle-fill"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>#22222</td>
                                            <td>lorem</td>
                                            <td>UAE</td>
                                            <td>2nd September 2025 | 11 Am</td>
                                            <td>10th September 2025 | 12 PM</td>
                                            <td>
                                                <div class="d-flex gap-3 justify-content-center">
                                                    <a class="table-button" type="button"><i
                                                            class="bi bi-check-circle-fill"></i></a>

                                                    <a class="table-button" data-bs-toggle="modal"
                                                        data-bs-target="#sentModal2" type="button">
                                                        <i class="bi bi-x-circle-fill"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Return -->
                        <div class="tab-pane fade show active" id="pills-approved" role="tabpanel"
                            aria-labelledby="pills-approved-tab" tabindex="0">
                            <div class="row">
                                <div class="align-items-end gap-3 d-flex">
                                    <div class="search-box" style="position: relative">
                                        <i class="bi bi-search" style="
                                  position: absolute;
                                  left: 10px;
                                  top: 50%;
                                  transform: translateY(-50%);
                                  font-size: 16px;
                                  color: #888;
                                ">
                                        </i>
                                        <input type="text" class="form-control" placeholder="Search for..."
                                            style="padding-left: 35px" />
                                    </div>
                                    <div class="form-group w-25">
                                        <!-- <label for="from" class="form-label">Country Name</label> -->
                                        <select class="form-select form-select-lg" aria-label="Large select example">
                                            <option selected>Select Country</option>
                                            <option value="1">country One</option>
                                            <option value="2">country Two</option>
                                            <option value="3">country Three</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive mt-5 w-100">
                                <table class="table w-100">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sr.No</th>
                                            <th scope="col">Request ID</th>
                                            <th scope="col">Seller Name</th>
                                            <th scope="col">Seller Country</th>
                                            <th scope="col">Request On</th>
                                            <th scope="col">Live Date & Time</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>#22222</td>
                                            <td>lorem</td>
                                            <td>UAE</td>
                                            <td>2nd September 2025 | 11 Am</td>
                                            <td>10th September 2025 | 12 PM</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>#22222</td>
                                            <td>lorem</td>
                                            <td>UAE</td>
                                            <td>2nd September 2025 | 11 Am</td>
                                            <td>10th September 2025 | 12 PM</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- cancle -->

                        <div class="tab-pane fade" id="pills-reject" role="tabpanel" aria-labelledby="pills-reject-tab"
                            tabindex="0">
                            <div class="row">
                                <div class="align-items-end gap-3 d-flex">
                                    <div class="search-box" style="position: relative">
                                        <i class="bi bi-search" style="
                                  position: absolute;
                                  left: 10px;
                                  top: 50%;
                                  transform: translateY(-50%);
                                  font-size: 16px;
                                  color: #888;
                                ">
                                        </i>
                                        <input type="text" class="form-control" placeholder="Search for..."
                                            style="padding-left: 35px" />
                                    </div>
                                    <div class="form-group w-25">
                                        <!-- <label for="from" class="form-label">Country Name</label> -->
                                        <select class="form-select form-select-lg" aria-label="Large select example">
                                            <option selected>Select Country</option>
                                            <option value="1">country One</option>
                                            <option value="2">country Two</option>
                                            <option value="3">country Three</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive mt-5 w-100">
                                <table class="table w-100">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sr.No</th>
                                            <th scope="col">Request ID</th>
                                            <th scope="col">Seller Name</th>
                                            <th scope="col">Seller Country</th>
                                            <th scope="col">Request On</th>
                                            <th scope="col">Live Date & Time</th>
                                            <th scope="col">Rejection Reason</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>#22222</td>
                                            <td>lorem</td>
                                            <td>UAE</td>
                                            <td>2nd September 2025 | 11 Am</td>
                                            <td>10th September 2025 | 12 PM</td>
                                            <td>lorem</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>#22222</td>
                                            <td>lorem</td>
                                            <td>UAE</td>
                                            <td>2nd September 2025 | 11 Am</td>
                                            <td>10th September 2025 | 12 PM</td>
                                            <td>lorem</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>

    <!-- End of Content Wrapper -->
</div>

<!-- add new model -->
<div class="modal fade" id="sentModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <!-- <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1> -->
                <h2 class="h2">Reason</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="appointment-container">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1" class="form-label">Reason For Rejection
                                        </label>
                                        <textarea class="form-control" id="rejectReason" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                                <div class="d-flex align-items-center justify-content-center gap-3 mt-3"
                                    style="margin-top: 30px">
                                    <a class="btn btn-dark customBtn" href=""> Submit</a>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="sentModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <!-- <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1> -->
                <h2 class="h2">Add Timeslot</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="appointment-container">
                    <div class="time-wrapper">
                        <div id="timeContainer">
                            <!-- First Row (Default) -->
                            <div class="time-row">
                                <div class="time-block">
                                    <label>From</label>
                                    <select>
                                        <option>HH</option>
                                    </select>
                                    <select>
                                        <option>MM</option>
                                    </select>
                                    <select>
                                        <option>AM</option>
                                        <option>PM</option>
                                    </select>
                                </div>

                                <div class="time-block">
                                    <label>To</label>
                                    <select>
                                        <option>HH</option>
                                    </select>
                                    <select>
                                        <option>MM</option>
                                    </select>
                                    <select>
                                        <option>AM</option>
                                        <option>PM</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- <a href="javascript:void(0)" class="add-more" onclick="addRow()">+ Add More</a> -->
                    </div>
                    <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                            <div class="d-flex align-items-center justify-content-center gap-3 mt-3"
                                style="margin-top: 30px">
                                <button type="submit" class="btn btn-dark customBtn">
                                    Submit
                                </button>
                                <!-- <button type="button" class="btn btn-dark customBtn" href=""> Submit</button> -->
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function() {
    // Get last active tab from localStorage
    const lastTab = localStorage.getItem("activeTab");
    if (lastTab) {
        const triggerEl = document.querySelector(`#${lastTab}`);
        if (triggerEl) {
            const tab = new bootstrap.Tab(triggerEl);
            tab.show();
        }
    }

    // Save active tab to localStorage when switched
    const tabButtons = document.querySelectorAll('button[data-bs-toggle="pill"]');
    tabButtons.forEach((button) => {
        button.addEventListener("shown.bs.tab", function() {
            localStorage.setItem("activeTab", this.id);
        });
    });
});
</script>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const url = new URL(window.location);
    const urlParams = url.searchParams;

    // ✅ If date NOT in URL → add today's date & reload ONCE
    if (!urlParams.has('date')) {
        const today = new Date().toISOString().split('T')[0];
        urlParams.set('date', today);
        window.location.replace(url.toString()); // prevents back-button issue
        return;
    }

    // ✅ Date exists in URL
    const selectedDate = urlParams.get('date');

    var calendarEl = document.getElementById("calendar");

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "dayGridMonth",
        selectable: true,
        height: "auto",
        initialDate: selectedDate,

        dateClick: function (info) {
            reloadWithDate(info.dateStr);
        }
    });

    calendar.render();

    // ✅ Highlight selected date
    calendar.select(selectedDate);

    showSelectedDate(selectedDate);
});

function showSelectedDate(dateStr) {
    const date = new Date(dateStr);
    const options = {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    };

    document.getElementById("selectedDateText").innerText =
        `Today, ${date.toLocaleDateString('en-GB', options)}`;

    document.getElementById("timeslotSection").style.display = "block";
}

// ✅ Reload page when user clicks a date
function reloadWithDate(dateStr) {
    const url = new URL(window.location);
    url.searchParams.set('date', dateStr);
    window.location.href = url.toString();
}
</script>





<!-- <script>
function addRow() {
    const container = document.getElementById('timeContainer');

    const row = document.createElement('div');
    row.className = 'time-row';

    row.innerHTML = `
    <div class="time-block">
      <label>From</label>
      <select><option>HH</option></select>
      <select><option>MM</option></select>
      <select><option>AM</option><option>PM</option></select>
    </div>

    <div class="time-block">
      <label>To</label>
      <select><option>HH</option></select>
      <select><option>MM</option></select>
      <select><option>AM</option><option>PM</option></select>
    </div>

    <span class="remove-btn" onclick="removeRow(this)">✖</span>
  `;

    container.appendChild(row);
}

function removeRow(el) {
    el.parentElement.remove();
}
</script> -->

@endsection