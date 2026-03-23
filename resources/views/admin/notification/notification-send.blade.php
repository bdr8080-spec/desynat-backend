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
                         <input type="text" id="search" class="search-box" placeholder="Search user">
                         <div class="user-item  d-flex justify-content-between mt-3">
                            <label>Select All</label>
                            <input type="checkbox" id="selectAll">
                        </div>

                        <div id="userList">
                            <div class="user-item d-flex justify-content-between bottom-border">
                                <span>User 1</span>
                                <input type="checkbox" class="user-checkbox">
                            </div>
                            <div class="user-item d-flex justify-content-between bottom-border">
                                <span>User 2</span>
                                <input type="checkbox" class="user-checkbox">
                            </div>
                            <div class="user-item d-flex justify-content-between bottom-border">
                                <span>Admin User</span>
                                <input type="checkbox" class="user-checkbox">
                            </div>
                        </div>

                    </div>

                </div>

                <!-- BOX 2 -->
                <div class="col-md-3">
                    <div class="multi-box form-group">
                         <input type="text" id="search" class="search-box" placeholder="Search user">
                         <div class="user-item  d-flex justify-content-between mt-3">
                            <label>Select All</label>
                            <input type="checkbox" id="selectAll">
                        </div>

                        <div id="userList">
                            <div class="user-item d-flex justify-content-between bottom-border">
                                <span>User 1</span>
                                <input type="checkbox" class="user-checkbox">
                            </div>
                            <div class="user-item d-flex justify-content-between bottom-border">
                                <span>User 2</span>
                                <input type="checkbox" class="user-checkbox">
                            </div>
                            <div class="user-item d-flex justify-content-between bottom-border">
                                <span>Admin User</span>
                                <input type="checkbox" class="user-checkbox">
                            </div>
                        </div>

                    </div>
                </div>

                <!-- BOX 3 -->
                <div class="col-md-3">
                    <div class="multi-box form-group">
                         <input type="text" id="search" class="search-box" placeholder="Search user">
                         <div class="user-item  d-flex justify-content-between mt-3">
                            <label>Select All</label>
                            <input type="checkbox" id="selectAll">
                        </div>

                        <div id="userList">
                            <div class="user-item d-flex justify-content-between bottom-border">
                                <span>User 1</span>
                                <input type="checkbox" class="user-checkbox">
                            </div>
                            <div class="user-item d-flex justify-content-between bottom-border">
                                <span>User 2</span>
                                <input type="checkbox" class="user-checkbox">
                            </div>
                            <div class="user-item d-flex justify-content-between bottom-border">
                                <span>Admin User</span>
                                <input type="checkbox" class="user-checkbox">
                            </div>
                        </div>

                    </div>

                </div>

                <!-- BOX 4 -->
                <div class="col-md-3">
                     <div class="multi-box form-group">
                         <input type="text" id="search" class="search-box" placeholder="Search user">
                         <div class="user-item  d-flex justify-content-between mt-3">
                            <label>Select All</label>
                            <input type="checkbox" id="selectAll">
                        </div>

                        <div id="userList">
                            <div class="user-item d-flex justify-content-between bottom-border">
                                <span>User 1</span>
                                <input type="checkbox" class="user-checkbox">
                            </div>
                            <div class="user-item d-flex justify-content-between bottom-border">
                                <span>User 2</span>
                                <input type="checkbox" class="user-checkbox">
                            </div>
                            <div class="user-item d-flex justify-content-between bottom-border">
                                <span>Admin User</span>
                                <input type="checkbox" class="user-checkbox">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#selectAll').on('change', function () {
            $('.user-checkbox').prop('checked', $(this).prop('checked'));
        });

        $('.user-checkbox').on('change', function () {
            let total = $('.user-checkbox').length;
            let checked = $('.user-checkbox:checked').length;
            $('#selectAll').prop('checked', total === checked);
        });

        // 🔍 Search Filter
        $('#search').on('keyup', function () {
            let value = $(this).val().toLowerCase();
            $('#userList .user-item').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        });
</script>


@endsection