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
                        <div class="col-md-2 col-lg-3 col-12">
                            <a href="{{route('admin.sendNotification')}}" class="btn btn-dark customBtn w-100 ms-auto mb-3">
                                <span>Send Notification</span></a>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="">
                            <h6>Notification 1</h6>
                            <div class="card">
                                <div class="card-body">
                                    <p>
                                        lorem ipsum dolor sit amet, consectetur adipisicing
                                        elit, sed do eiusmod tempor incididunt ut labore et
                                        dolore magna aliqua. Ut enim ad minim veniam, quis
                                        nostrud exercitation ullamco laboris nisi ut aliquip
                                        ex ea commodo consequat. Duis aute irure dolor in
                                        reprehenderit in voluptate velit esse cillum dolore
                                        eu fugiat nulla pariatur. Excepteur sint occaecat
                                        cupidatat non proident, sunt in culpa qui officia
                                        deserunt mollit anim id est laborum.
                                        <br />
                                        lorem ipsum dolor sit amet, consectetur adipisicing
                                        elit, sed do eiusmod tempor incididunt ut labore et
                                        dolore magna aliqua. Ut enim ad minim veniam, quis
                                        nostrud exercitation ullamco laboris nisi ut aliquip
                                        ex ea commodo consequat. Duis aute irure dolor in
                                        reprehenderit in voluptate velit esse cillum dolore
                                        eu fugiat nulla pariatur. Excepteur sint occaecat
                                        cupidatat non proident, sunt in culpa qui officia
                                        deserunt mollit anim id est laborum.
                                    </p>

                                    <p class="d-flex justify-content-end">
                                        07/01/25 01:00 PM
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="sent" role="tabpanel" aria-labelledby="sent-tab" tabindex="0">
                    <div class="row align-items-end d-flex justify-content-end">
                        <div class="col-md-2 col-lg-3 col-12">
                            <a class="btn btn-dark customBtn w-100 ms-auto mb-3" href="/send-notification">
                                <span>Send Notification</span></a>
                        </div>
                    </div>
                    <div class="row">
                        <!-- From Date Filter -->
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="from" class="form-label">From:</label>
                                <input type="date" id="from" name="from_date2" class="form-control" />
                            </div>
                        </div>

                        <!-- To Date Filter -->
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="form-group mt-4 w-100">
                                <label for="to" class="form-label">To:</label>
                                <input type="date" id="to" name="to_date2" class="form-control" />
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-12 col-12">
                            <div class="d-flex gap-3 justify-content-start" style="text-align: start">
                                <a href="" class="btn btn-dark customBtn" style="margin-top: 60px">
                                    <span>Reset</span>
                                </a>
                                <a class="btn btn-dark customBtn" style="margin-top: 60px">
                                    <span>Export</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table w-100">
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
                                <tr>
                                    <th scope="row">1</th>
                                    <td>#2345</td>
                                    <td>Lorem</td>
                                    <td>UAE</td>
                                    <td>2nd July 2025 | 11 Am</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>



@endsection