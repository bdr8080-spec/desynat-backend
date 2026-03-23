@extends('admin.layout.app')
@section('content')



<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">Notification Management </h2>
        </div>
    </div>

    <div class="notification-panel">
        <div class="d-flex justify-content-center">
            <ul class="nav nav-pills tabs-pnl custom" id="pills-tab" role="tablist">
                <li class="nav-item m-1" role="presentation">
                    <button class="nav-link active customBtn2 m-0" id="received-tab" data-bs-toggle="pill"
                        data-bs-target="#received" type="button" role="tab" aria-controls="pills-home"
                        aria-selected="true">
                        Received Notification
                    </button>
                </li>
                <li class="nav-item m-1" role="presentation">
                    <button class="nav-link m-0 customBtn2" id="sent-tab" data-bs-toggle="pill" data-bs-target="#sent"
                        type="button" role="tab" aria-controls="sent" aria-selected="false">
                        Sent Notification
                    </button>
                </li>
            </ul>
        </div>
        <div class="userManagecontent">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="received" role="tabpanel" aria-labelledby="received-tab"
                    tabindex="0">
                    <div class="row align-items-end d-flex justify-content-end">
                        <div class="col-md-2 col-lg-2 col-12">
                            <a href="{{route('admin.sendNotification')}}" class="btn btn-dark customBtn w-100 ms-auto mb-3">
                                <span>Send Notification</span></a>
                        </div>
                    </div>
                    <div class="mt-4">
                        @forelse($myNotifications as $notification)
                            <div class="mb-3">
                                <h6>{{ $notification->title_english }}</h6>

                                <div class="card">
                                    <div class="card-body">

                                        <p>
                                            {{ $notification->description_english }}
                                        </p>

                                        <p class="d-flex justify-content-end">
                                            {{ \Carbon\Carbon::parse($notification->created_at)->format('d/m/y h:i A') }}
                                        </p>

                                    </div>
                                </div>

                            </div>
                        @empty
                            <div class="text-center">
                                <p>No notifications found</p>
                            </div>
                        @endforelse

                    </div>

                    <!-- Pagination -->
                    @if($myNotifications instanceof \Illuminate\Pagination\LengthAwarePaginator && $myNotifications->count())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $myNotifications->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
                <div class="tab-pane fade" id="sent" role="tabpanel" aria-labelledby="sent-tab" tabindex="0">
                    <div class="row align-items-end d-flex justify-content-end">
                        <div class="col-md-2 col-lg-2 col-12">
                            <a href="{{route('admin.sendNotification')}}" class="btn btn-dark customBtn w-100 ms-auto mb-3" href="/send-notification">
                                <span>Send Notification</span></a>
                        </div>
                    </div>
                    <form method="GET" action="{{ route('admin.notificationManagement') }}" id="filterForm">
                    <div class="row">
                        <!-- From Date Filter -->
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="from" class="form-label">From:</label>
                                <input type="date" id="from" name="from_date" class="form-control"
                                    value="{{ request()->from_date }}"
                                    onchange="document.getElementById('filterForm').submit();" />
                            </div>
                        </div>

                        <!-- To Date Filter -->
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to" class="form-label">To:</label>
                                <input type="date" id="to" name="to_date" class="form-control"
                                    value="{{ request()->to_date }}"
                                    onchange="document.getElementById('filterForm').submit();" />
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-12 col-12">
                            <div class="d-flex gap-3 justify-content-start mt-5" style="text-align: start">
                                <a href="{{ route('admin.notificationManagement') }}" class="btn btn-dark customBtn mt-2">
                                    <span>Reset</span>
                                </a>
                                <a href="" class="btn btn-dark customBtn mt-2">
                                    <span>Export</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    </form>

                    <div class="table-responsive">
                        <table id="myTable" class="table w-100">
                            <thead>
                                <tr>
                                    <th scope="col">Sr.No</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Sent To</th>
                                    <th scope="col">Content</th>
                                    <th scope="col">Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sentNotifications as $key => $notification)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $notification['title_english'] }}</td>
                                    <td>
                                        @php
                                            $receivers = $notification['receiver_details'] ?? [];

                                            $getName = function ($user) {
                                                return $user->full_name
                                                    ?? $user->full_name_english
                                                    ?? trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''))
                                                    ?? $user->name
                                                    ?? 'N/A';
                                            };

                                            $firstName = count($receivers) ? $getName($receivers[0]) : 'N/A';
                                        @endphp

                                        {{ $firstName }}

                                            <span class="text-primary">{{ $notification['total_receivers'] }}+</span>
                                    </td>
                                    <td>{{ $notification['description_english'] }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($notification['created_at'])->format('d/m/y \a\t h:i A') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No notifications found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    //get active tab from local storage
    const lastTab = localStorage.getItem("activeTab");
    if (lastTab) {
        const triggerEl = document.querySelector(`#${lastTab}`);
        if (triggerEl) {
            const tab = new bootstrap.Tab(triggerEl);
            tab.show();
        }
    }
    //save active tab to local storage
    const tabButtons = document.querySelectorAll('button[data-bs-toggle="pill"]');
    tabButtons.forEach((button) => {
        button.addEventListener("shown.bs.tab", function() {
            localStorage.setItem("activeTab", this.id);
        });
    });
});
</script>

<script>
    function updateToDate() {
        const fromDate = document.getElementById('from').value;
        const toDateInput = document.getElementById('to');
        if (fromDate) {
            toDateInput.setAttribute('min', fromDate);
        } else {
            toDateInput.removeAttribute('min');
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        updateToDate();
    });
</script>



@endsection