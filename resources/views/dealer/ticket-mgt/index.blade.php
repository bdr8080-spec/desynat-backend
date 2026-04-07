@include('dealer.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24">Ticket Management</div>
    </div>

    <div class="search-field d-flex align-items-center py-4 gap-3">
        <div class="search-field d-flex align-items-center w-100">
            <div class="from-group position-relative w-100">
                <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search" class="search-icon2">
                <input type="search" name="search" class="form-control py-3" placeholder="Search" value="">
            </div>
            <button type="submit" class="btn btn-success searchlin"> Search </button>
        </div>
        <a href="#" data-bs-toggle="modal" data-bs-target="#ticketModal"><img src="{{ asset('user') }}/assets/images/add-icon.svg" alt="add icon"></a>
    </div>

 
    <div class="ticket-pnl mt-5">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <div class="ticket">
                    <p class="text-muted mb-1">Ticket Type </p>
                </div>
                <div class="ticket">
                    <p class="text-muted mb-1"> Lorem Ipsum </p>
                </div>
            </div>

            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="text-muted mb-1">Ticket ID </p>
                    <p class="fst-500">723KL </p>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <p class="text-muted mb-1">Raised on</p>
                    <p class="fst-500">06 Apr 2026, 14:00 PM</p>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <p class="text-muted mb-1">Status</p>
                    <p class="fst-500">
                        <span class="text-red">In progress</span>
                    </p>
                </div>
            </div>
        </div>
    </div>





</section>


<!-- Success Modal -->
<div class="modal fade" id="ticketModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Ticket deatils </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
           
            <div class="modal-body">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Ticket Type</label>
                    </div>
                    <select class="form-select form-control" aria-label="Default select example">
                        <option type="1">Ticket 1</option>
                        <option type="2">Ticket 2</option>
                    </select>
                </div>

                <div class="sub-form">
                    <div class="label-flex">
                        <label>Title</label>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter Product name">
                </div>
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Description</label>
                    </div>
                    <textarea class="form-control" rows="4" placeholder="Enter description"></textarea>
                </div>

                <div class="sub-form">
                    <div class="label-flex">
                        <label>Upload attachment (if any)</label>
                    </div>
                    <div class="upload-image w-100 mt-2">
                        <label class="uploadLabel" style="cursor:pointer;text-align:center;">
                            <img src="{{ asset('user/assets/images/upload-icon.svg') }}">
                            <div class="text-color-upload">Upload profile image</div>
                            <input type="file" accept="image/*" name="image" enctype="multipart/form-data" hidden
                                onchange="showPreview(event)">
                        </label>
                        <div class="imgshow">
                            <img class="preview" style="display:none;max-width:100%;margin-top:10px;border-radius:8px;">
                            <span class="removeIcon" style="display:none;cursor:pointer;font-size:24px;color:red;"
                                onclick="removeImg()">&times;</span>
                        </div>
                    </div>
                   
                </div>



                <div class="cmn-btn mt-4">
                    <button type="submit" class="btn add-fillbtn w-100">Submit </button>
                </div>

            </div>
           
        </div>
    </div>
</div>




@include('dealer.layout.footer');
@include('dealer.product.ajax.datatablejs');

<script>
    function showPreview(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(x) {
                $('.preview').attr('src', x.target.result).show();
                $('.removeIcon').show();
                $('.uploadLabel').hide();
            };
            reader.readAsDataURL(file);
        }
    }

    function removeImg() {
        $('.preview').attr('src', '').hide();
        $('.removeIcon').hide();
        $('.uploadLabel').show();
    }

</script>