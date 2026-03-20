@extends('admin.layout.app')
@section('content')



<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <div class="arrow">
                <a href="{{ route('admin.notificationManagement') }}" type="button">
                    <i class="fas fa-angle-left"></i>
                </a>
            </div>

            <h2 class="h2">Send Notification Management </h2>
        </div>
    </div>

    <div class="row">
        <!-- LEFT FORM -->
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-group">Notification Title (English)</label>
                <input type="text" class="form-control" />
            </div>

            <div class="mb-3">
                <label class="form-group">Notification Title (Arabic)</label>
                <input type="text" class="form-control" />
            </div>

            <div class="mb-3">
                <label class="form-group">Notification Description (English)</label>
                <textarea rows="4" class="form-control"></textarea>
            </div>

            <div class="mb-4">
                <label class="form-group">Notification Description (Arabic)</label>
                <textarea rows="4" class="form-control"></textarea>
            </div>

            <button type="button" class="btn btn-dark customBtn px-4">Send</button>
        </div>

        <!-- RIGHT MULTI SELECT -->
        <div class="col-md-8">
            <div class="row g-3">
                <!-- BOX 1 -->
                <div class="col-md-3">
                    <div class="multi-box form-group">
                        <input type="text" class="search" placeholder="search user" />
                        <div class="select-all">
                            <span>Select all</span>
                            <input type="checkbox" />
                        </div>
                        <ul>
                            <li>
                                <i class="bi bi-person"></i> User ID
                                <input type="checkbox" checked />
                            </li>
                            <li>
                                <i class="bi bi-person"></i> User ID
                                <input type="checkbox" />
                            </li>
                            <li>
                                <i class="bi bi-person"></i> User ID
                                <input type="checkbox" checked />
                            </li>

                        </ul>
                    </div>
                </div>

                <!-- BOX 2 -->
                <div class="col-md-3">
                    <div class="multi-box">
                        <input type="text" class="search" placeholder="search user" />
                        <div class="select-all">
                            <span>Select all</span>
                            <input type="checkbox" />
                        </div>
                        <ul>
                            <li>
                                <i class="bi bi-person"></i> Seller Name
                                <input type="checkbox" checked />
                            </li>
                            <li>
                                <i class="bi bi-person"></i> Seller Name
                                <input type="checkbox" />
                            </li>
                            <li>
                                <i class="bi bi-person"></i> Seller Name
                                <input type="checkbox" checked />
                            </li>
                            <li>
                                <i class="bi bi-person"></i> Seller Name
                                <input type="checkbox" checked />
                            </li>

                        </ul>
                    </div>
                </div>

                <!-- BOX 3 -->
                <div class="col-md-3">
                    <div class="multi-box">
                        <input type="text" class="search" placeholder="search user" />
                        <div class="select-all">
                            <span>Select all</span>
                            <input type="checkbox" />
                        </div>
                        <ul>
                            <li>
                                <i class="bi bi-person"></i> Delivery Boy
                                <input type="checkbox" />
                            </li>
                            <li>
                                <i class="bi bi-person"></i> Delivery Boy
                                <input type="checkbox" checked />
                            </li>
                            <li>
                                <i class="bi bi-person"></i> Delivery Boy
                                <input type="checkbox" />
                            </li>
                            <li>
                                <i class="bi bi-person"></i> Delivery Boy
                                <input type="checkbox" />
                            </li>

                        </ul>
                    </div>
                </div>

                <!-- BOX 4 -->
                <div class="col-md-3">
                    <div class="multi-box">
                        <input type="text" class="search" placeholder="Affiliate Users" />
                        <div class="select-all">
                            <span>Select all</span>
                            <input type="checkbox" />
                        </div>
                        <ul>
                            <li>
                                <i class="bi bi-person"></i> User ID
                                <input type="checkbox" checked />
                            </li>
                            <li>
                                <i class="bi bi-person"></i> User ID
                                <input type="checkbox" />
                            </li>
                            <li>
                                <i class="bi bi-person"></i> User ID
                                <input type="checkbox" checked />
                            </li>
                            <li>
                                <i class="bi bi-person"></i> User ID
                                <input type="checkbox" checked />
                            </li>
                            <li>
                                <i class="bi bi-person"></i> User ID
                                <input type="checkbox" />
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>



@endsection