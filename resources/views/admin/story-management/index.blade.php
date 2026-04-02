@extends('admin.layout.app')
@section('content')

  <style>
#editPreviewImage {
    display: block;
}

.upload-box {
    width: 220px;
    height: 160px;
    border: 2px dotted #c8ad8d;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    position: relative;
    overflow: hidden;
    cursor: pointer;
}

.upload-icon {
    width: 60px;
    opacity: 0.5;
}

.upload-text {
    margin-top: 10px;
    font-size: 14px;
    color: #444;
}

.preview-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: absolute;
    top: 0;
    left: 0;
    display: none;
}
</style>

<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">Story Management</h2>
        </div>


    </div>
    <div class="d-flex justify-content-center">
        <ul class="nav nav-pills mb-3 tabs-pnl custom" id="pills-tab" role="tablist">
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link customBtn2 m-0" id="pills-order-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order"
                    aria-selected="true">
                    Seller Stories
                </button>
            </li>
            <li class="nav-item m-1" role="presentation">
                <button class="nav-link active customBtn2 m-0" id="pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="true">
                    Admin Platform Stories
                </button>
            </li>

        </ul>
    </div>
    <div class="userManagecontent">
        <div class="tab-content" id="pills-tabContent">

            <!-- Exchange -->

            <div class="tab-pane fade" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab" tabindex="0">

                <form method="GET" action="{{ route('admin.storyManagement') }}" id="filterForm">
                <div class="row">
                    <!-- <div class="col-lg-3 col-md-4 col-12">
                        <div class="search-box" style="position: relative;">
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
                    </div> -->

                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="form-group mb-5 ">
                            <select name="country"
                                class="form-select form-select-lg w-50 "
                                onchange="document.getElementById('filterForm').submit();">
                                <option value="">Select country</option>
                                @foreach($countries as $country)
                                <option value="{{ $country['name'] }}"
                                    {{ request('country') == $country['name'] ? 'selected' : '' }}>
                                    {{ $country['name'] }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                </form>



                <div class="table-responsive  w-100">
                    <table id="myTable" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Seller Name</th>
                                <th scope="col">Country</th>
                                <th scope="col">Posted Image/Video</th>
                                <th scope="col">Posted On</th>


                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sellerStory as $index => $story)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $story['seller_details']['first_name'] }} {{ $story['seller_details']['last_name'] }}</td>
                                <td>{{ $story['seller_details']['country_details']['name']??'N/A' }} </td>
                                <td>
                                    @php
                                        $ext = strtolower(pathinfo($story['file'], PATHINFO_EXTENSION));
                                        $imageExtensions = ['jpg','jpeg','png','gif','svg'];
                                        $videoExtensions = ['mp4','mov','avi','mkv'];
                                    @endphp

                                    @if(in_array($ext, $imageExtensions))
                                        <a href="{{ $story['file'] }}" target="_blank">
                                            <img src="{{ $story['file'] }}" alt="Story" width="40" height="40" class="square" />
                                        </a>
                                    @elseif(in_array($ext, $videoExtensions))
                                        <a href="{{ $story['file'] }}" target="_blank">
                                            <video width="40" height="40" class="square" muted playsinline loop>
                                                <source src="{{ $story['file'] }}" type="video/{{ $ext }}">
                                                Your browser does not support the video tag.
                                            </video>
                                        </a>
                                    @else
                                        <span>File not supported</span>
                                    @endif
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($story['created_at'])
                                        ->timezone('Asia/Kolkata')
                                        ->format('jS F Y | h:i A') }}
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No data found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Return -->
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                tabindex="0">

                <div class="row">
                    <div class="align-items-end d-flex">

                        <div class="col-lg-6 col-md-4 col-12">

                            <!-- <div class="search-box w-50" style="position: relative;">
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
                            </div> -->

                        </div>
                        <div class="col-lg-6 ">
                            <div class="d-flex  align-items-end justify-content-end">
                                <a class="btn btn-dark customBtn" data-bs-toggle="modal"
                                    data-bs-target="#sentModalphoto">
                                    <span>Add</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="table-responsive mt-2 w-100">
                    <table id="myTable1" class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Posted Image/Video</th>
                                <th scope="col">Posted On Date & Time</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>


                            </tr>
                        </thead>
                        <tbody>
                            @forelse($adminStory as $index => $story)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>
                                    @php
                                        $ext = strtolower(pathinfo($story['file'], PATHINFO_EXTENSION));
                                        $imageExtensions = ['jpg','jpeg','png','gif','svg'];
                                        $videoExtensions = ['mp4','mov','avi','mkv'];
                                    @endphp

                                    @if(in_array($ext, $imageExtensions))
                                        <a href="{{ $story['file'] }}" target="_blank">
                                            <img src="{{ $story['file'] }}" alt="Story" width="40" height="40" class="square" />
                                        </a>
                                    @elseif(in_array($ext, $videoExtensions))
                                        <a href="{{ $story['file'] }}" target="_blank">
                                            <video width="40" height="40" class="square" muted playsinline loop>
                                                <source src="{{ $story['file'] }}" type="video/{{ $ext }}">
                                                Your browser does not support the video tag.
                                            </video>
                                        </a>
                                    @else
                                        <span>File not supported</span>
                                    @endif
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($story['created_at'])
                                        ->timezone('Asia/Kolkata')
                                        ->format('jS F Y | h:i A') }}
                                </td>
                                <td>{{ $story['status'] == 1 ? 'Active' : 'Inactive' }}</td>
                                <td>

                                    <div class="d-flex  justify-content-center">


                                        <a href="javascript:void(0);" class="table-button text-danger deleteStory mb-1 mt-1"
                                            data-id="{{ $story['id'] }}">
                                            <i class="bi bi-trash3-fill"></i>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                             @empty
                            <tr>
                                <td colspan="6" class="text-center">No data found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- End of Content Wrapper -->
</div>

<!-- <div class="modal fade" id="sentModalphoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Add New </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <form id="addBrandForm" enctype="multipart/form-data">
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="upload-title text-center">Upload Image</div>

                                <label for="fileUpload" class="upload-box" style="cursor:pointer;">
                                    <img src="/admin/image/upload-icon.svg" id="uploadIcon" />
                                    <img id="previewImage" class="preview-image" style="display:none; max-width:216px; margin-top:-2px;" />
                                    <div class="upload-text">Upload Image</div>
                                    <input type="file" id="fileUpload" name="image" accept="image/*" hidden />
                                </label>
                            </div>
                            <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                                <a type="button" id="submitBrandBtn" class="btn btn-dark customBtn mt-3">Submit</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
<div class="modal fade" id="sentModalphoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header management border-0">
                <h2 class="h2">Add New</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="appointment-container">
                    <form id="addBrandForm" enctype="multipart/form-data">
                        <div class="row">

                            <!-- Upload Image/Video -->
                            <div class="col-lg-12">
                                <div class="upload-title text-center">Upload Image or Video</div>

                                <label for="fileUpload" class="upload-box" style="cursor:pointer;">
                                    <img src="/admin/image/upload-icon.svg" id="uploadIcon" />
                                    <img id="previewImage" class="preview-image" style="display:none; max-width:216px; margin-top:-2px;" />
                                    <video id="previewVideo" class="preview-image" style="display:none; max-width:216px; margin-top:-2px;" controls></video>
                                    <div class="upload-text">Upload Image or Video</div>
                                    <input type="file" id="fileUpload" name="file" accept="image/*,video/*" hidden />
                                </label>
                                <div id="fileError" style="color:red; font-size: 0.875rem; margin-top:5px;"></div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                                <a type="button" id="submitStoryBtn" class="btn btn-dark customBtn mt-3">Submit</a>
                            </div>
                        </div>
                    </form>
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
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.deleteStory').forEach(button => {
        button.addEventListener('click', function() {
            let storyId = this.getAttribute('data-id');

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/deleteStory/${storyId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                toastr.success(data.message);
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
                            } else {
                                toastr.error(data.message);
                            }
                        })
                        .catch(() => {
                            toastr.error('Something went wrong.');
                        });
                }
            });
        });
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    const fileUpload = document.getElementById('fileUpload');
    const uploadIcon = document.getElementById('uploadIcon');
    const previewImage = document.getElementById('previewImage');
    const previewVideo = document.getElementById('previewVideo');
    const submitBtn = document.getElementById('submitStoryBtn');
    const fileError = document.getElementById('fileError');

    /* ===== Preview Image/Video ===== */
    fileUpload.addEventListener('change', function(e) {
        const file = e.target.files[0];
        fileError.innerText = '';

        if (!file) return;

        const type = file.type;

        if(type.startsWith('image/')){
            previewVideo.style.display = 'none';
            previewVideo.src = '';
            previewImage.src = URL.createObjectURL(file);
            previewImage.style.display = 'block';
        } else if(type.startsWith('video/')){
            previewImage.style.display = 'none';
            previewImage.src = '';
            previewVideo.src = URL.createObjectURL(file);
            previewVideo.style.display = 'block';
        } else {
            fileError.innerText = 'File must be an image or video';
            fileUpload.value = '';
            previewImage.style.display = 'none';
            previewVideo.style.display = 'none';
            return;
        }

        uploadIcon.style.display = 'none';
    });

    submitBtn.addEventListener('click', function() {
        fileError.innerText = '';

        const file = fileUpload.files[0];
        if(!file){
            fileError.innerText = 'Please select an image or video';
            return;
        }

        submitBtn.innerText = 'Uploading...';
        submitBtn.classList.add('disabled');
        submitBtn.style.pointerEvents = 'none';

        const formData = new FormData();
        formData.append('file', file);

        fetch('{{ url("admin/addStory") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                toastr.success(data.message);
                setTimeout(() => {
                    $('#sentModalphoto').modal('hide');
                    location.reload();
                }, 1500);
            } else {
                toastr.error(data.message);
            }
        })
        .catch(err => {
            console.error(err);
            toastr.error(data.message);
        });
    });

});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('sentModalphoto');
    modal.addEventListener('hidden.bs.modal', function () {
        location.reload(); 
    });
});
</script>

@endsection