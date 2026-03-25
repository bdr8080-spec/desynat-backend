@extends('admin.layout.app')
@section('content')

<style>
/* Hide all tab panes initially to avoid flicker */
.tab-content > .tab-pane {
    display: none;
}

/* Show only the active tab pane */
.tab-content > .tab-pane.active {
    display: block;
}

/* Hide entire tab container initially */
#tabContentContainer {
    visibility: hidden;
}

/* Show tab container after JS activates the saved tab */
#tabContentContainer.active-shown {
    visibility: visible;
}
</style>



<div class="inner-content management" id="tabContentContainer">
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
                    <div class=" align-items-end d-flex justify-content-end">
                        <div class="noti">
                            <a href="{{route('admin.sendNotification')}}" class="btn btn-dark customBtn ms-auto mb-3">
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
                    <div class="align-items-end d-flex justify-content-end">
                        <div class="noti">
                            <a href="{{route('admin.sendNotification')}}" class="btn btn-dark customBtn ms-auto mb-3" href="/send-notification">
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
                                     />
                            </div>
                        </div>

                        <!-- To Date Filter -->
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to" class="form-label">To:</label>
                                <input type="date" id="to" name="to_date" class="form-control"
                                    value="{{ request()->to_date }}"
                                     />
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
                    <div id="sentNotificationsWrapper">
                        <div class="table-responsive mt-4">
                            <table id="myTable" class="table w-100">
                                <thead>
                                    <tr>
                                        <th scope="col">Sr.No</th>
                                        <th scope="col">Title English</th>
                                        <th scope="col">Title Arabic</th>
                                        <th scope="col">Sent To</th>
                                        <th scope="col">All Type</th>
                                        <th scope="col">English Description</th>
                                        <th scope="col">Arabic Description</th>
                                        <th scope="col">Date & Time</th>
                                    </tr>
                                </thead>
                                <tbody id="sentNotificationsTbody">
                                    @forelse($sentNotifications as $key => $notification)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $notification['title_english'] }}</td>
                                        <td>{{ $notification['title_arabic'] }}</td>
                                        <td>
                                           @php
                                                $receivers = $notification['receiver_details'] ?? [];

                                                $getName = function ($user) {

                                                    // ✅ If object
                                                    if (is_object($user)) {
                                                        return $user->full_name
                                                            ?? $user->full_name_english
                                                            ?? trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''))
                                                            ?? $user->name
                                                            ?? 'N/A';
                                                    }

                                                    // ✅ If array (AFTER FILTER)
                                                    if (is_array($user)) {
                                                        return $user['full_name']
                                                            ?? $user['full_name_english']
                                                            ?? trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''))
                                                            ?? $user['name']
                                                            ?? 'N/A';
                                                    }

                                                    return 'N/A';
                                                };

                                                $firstName = count($receivers) ? $getName($receivers[0]) : 'N/A';
                                            @endphp

                                            {{ $firstName }}
                                            <span class="text-primary">{{ $notification['total_receivers'] }}+</span>
                                        </td>
                                        <td>
                                           @php
                                                $receivers = $notification['receiver_details'] ?? [];

                                                $classMap = [
                                                    'user' => 'User',
                                                    'affilateduser' => 'Affiliate User',
                                                    'seller' => 'Seller',
                                                    'deliveryboy' => 'Delivery Boy',
                                                ];

                                                $detected = [];

                                                foreach ($receivers as $receiver) {
                                                    $cls = strtolower($receiver['type_name'] ?? '');
                                                    if (isset($classMap[$cls])) {
                                                        $detected[$cls] = $classMap[$cls];
                                                    }
                                                }

                                                $order = ['user', 'affilateduser', 'seller', 'deliveryboy'];

                                                $typeString = collect($order)
                                                    ->filter(fn($c) => isset($detected[$c]))
                                                    ->map(fn($c) => $detected[$c])
                                                    ->implode(', ');
                                                @endphp

                                                {{ $typeString ?: 'N/A' }}
                                        </td>

                                        <td>
                                            <a class="table-button" type="button" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#englishModal" 
                                            data-description="{{ $notification['description_english'] }}">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="table-button" type="button" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#arabicModal" 
                                            data-description="{{ $notification['description_arabic'] }}">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($notification['created_at'])->format('d/m/y \a\t h:i A') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No notifications found</td>
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
</div>

 <!-------- english Description-------->
<div class="modal fade" id="englishModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h5>English Description</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="appointment-container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="mb-3">
                               <p class="text-thin1" id="englishModalDescription">

                               </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-------- Arabic Description-------->
<div class="modal fade" id="arabicModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h5>Arabic Description</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="appointment-container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="mb-3" id="arabicModalDescription">
                                <p class="text-thin1">

                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
// document.addEventListener("DOMContentLoaded", function() {
//     //get active tab from local storage
//     const lastTab = localStorage.getItem("activeTab");
//     if (lastTab) {
//         const triggerEl = document.querySelector(`#${lastTab}`);
//         if (triggerEl) {
//             const tab = new bootstrap.Tab(triggerEl);
//             tab.show();
//         }
//     }
//     //save active tab to local storage
//     const tabButtons = document.querySelectorAll('button[data-bs-toggle="pill"]');
//     tabButtons.forEach((button) => {
//         button.addEventListener("shown.bs.tab", function() {
//             localStorage.setItem("activeTab", this.id);
//         });
//     });
// });
document.addEventListener("DOMContentLoaded", function() {
    const tabContentContainer = document.getElementById('tabContentContainer');

    // 1️⃣ Restore last active tab on page load
    const lastTab = localStorage.getItem("activeTab");
    if (lastTab) {
        const triggerEl = document.querySelector(`#${lastTab}`);
        if (triggerEl) {
            const tab = new bootstrap.Tab(triggerEl);
            tab.show(); // Show the saved tab immediately
        }
    }

    // 2️⃣ Show tab container after activating the saved tab
    if (tabContentContainer) {
        tabContentContainer.classList.add('active-shown');
    }

    // 3️⃣ Reload page when user clicks a different tab
    const tabButtons = document.querySelectorAll('button[data-bs-toggle="pill"]');
    tabButtons.forEach((button) => {
        button.addEventListener("click", function(e) {
            const currentTab = localStorage.getItem("activeTab");
            if (currentTab !== this.id) {
                e.preventDefault(); // Stop Bootstrap from switching tab immediately
                localStorage.setItem("activeTab", this.id);
                //location.reload(); // reload before tab content shows
            }
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

            // ✅ Optional: reset TO date if it's smaller than FROM
            if (toDateInput.value && toDateInput.value < fromDate) {
                toDateInput.value = '';
            }

        } else {
            toDateInput.removeAttribute('min');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Run on load
        updateToDate();

        // ✅ Run when FROM date changes
        document.getElementById('from').addEventListener('change', updateToDate);
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const englishModal = document.getElementById('englishModal');
    
    englishModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const description = button.getAttribute('data-description');
        const modalBody = englishModal.querySelector('#englishModalDescription');
        modalBody.textContent = description;
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const englishModal = document.getElementById('arabicModal');
    
    englishModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const description = button.getAttribute('data-description');
        const modalBody = englishModal.querySelector('#arabicModalDescription');
        modalBody.textContent = description;
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const fromInput = document.getElementById('from');
    const toInput = document.getElementById('to');
    const tableBody = document.getElementById('sentNotificationsTbody');

    fromInput.addEventListener('change', fetchFilteredNotifications);
    toInput.addEventListener('change', fetchFilteredNotifications);

    function fetchFilteredNotifications() {
        const fromDate = fromInput.value;
        const toDate = toInput.value;

        fetch(`{{ route('admin.notificationManagement') }}?from_date=${fromDate}&to_date=${toDate}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json()) // return JSON instead of HTML
        .then(data => {
            // data should include filtered notifications
            let html = '';
            if (data.sentNotifications.length) {
                data.sentNotifications.forEach((notification, key) => {
                    const receivers = notification.receiver_details || [];
                    const firstName = receivers.length ? (receivers[0].full_name || receivers[0].full_name_english || 'N/A') : 'N/A';

                    const classMap = {
                        'user': 'User',
                        'affilateduser': 'Affiliate User',
                        'seller': 'Seller',
                        'deliveryboy': 'Delivery Boy'
                    };
                    let detected = {};
                    receivers.forEach(r => {
                        const cls = r.type_name?.toLowerCase() || '';
                        if (classMap[cls]) detected[cls] = classMap[cls];
                    });
                    const order = ['user','affilateduser','seller','deliveryboy'];
                    const typeString = order.filter(c => detected[c]).map(c => detected[c]).join(', ') || 'N/A';

                    html += `
                        <tr>
                            <th scope="row">${key+1}</th>
                            <td>${notification.title_english}</td>
                            <td>${notification.title_arabic}</td>
                            <td>${firstName} <span class="text-primary">${notification.total_receivers}+</span></td>
                            <td>${typeString}</td>
                            <td><a class="table-button" type="button" data-bs-toggle="modal" data-bs-target="#englishModal" data-description="${notification.description_english}"><i class="bi bi-eye-fill"></i></a></td>
                            <td><a class="table-button" type="button" data-bs-toggle="modal" data-bs-target="#arabicModal" data-description="${notification.description_arabic}"><i class="bi bi-eye-fill"></i></a></td>
                            <td>${notification.created_at_formatted}</td>
                        </tr>
                    `;
                });
            } else {
                html = `<tr><td colspan="8" class="text-center">No notifications found</td></tr>`;
            }

            tableBody.innerHTML = html;
        })
        .catch(err => console.error(err));
    }
});
</script>



@endsection