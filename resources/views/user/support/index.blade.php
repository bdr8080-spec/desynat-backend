@extends('user.layout.app')

@section('content')
<div class="my-profile-2 customContainer my-lg-5 my-2 mb-4">
    <div class="d-lg-flex d-md-flex d-block align-items-center mt-3 justify-content-between">
        <div class="my-profie-nav"><a class="text-black" href="#"><i class="fa-solid fa-chevron-left"></i></a> Support
        </div>
    </div>

    <div class="tabs-panel py-4">
        <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active w-100" id="pills-listed-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-listed" type="button" role="tab" aria-controls="pills-listed"
                    aria-selected="true">Contact </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link w-100" id="pills-plan-tab" data-bs-toggle="pill" data-bs-target="#pills-plan"
                    type="button" role="tab" aria-controls="pills-plan" aria-selected="false">Ticket Management</button>
            </li>
        </ul>
    </div>


    <div class="tab-body-wapper">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-listed" role="tabpanel" aria-labelledby="pills-listed-tab" tabindex="0">
                <div class="support-wap border-1 p-3">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="border-1">
                                <div class="d-flex gap-3">
                                    <div class="sup-icon">
                                        <img src="{{ asset('user/assets/images/order-ic/email.svg') }}">
                                    </div>

                                    <div class="giftinfo-2">
                                        <p>Support Email Address</p>
                                        <a href="#">Loremipsum@gmail.com</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="border-1">
                                <div class="d-flex gap-3">
                                    <div class="sup-icon">
                                        <img src="{{ asset('user/assets/images/order-ic/call.svg') }}">
                                    </div>

                                    <div class="giftinfo-2">
                                        <p>Support Contact Number</p>
                                        <a href="#">+966 57689025</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="border-1 mt-3">
                                <div class="d-flex justify-content-between">
                                    <div class="giftinfo-2">
                                        <p>Chat on Whatsapp</p>
                                    </div>
                                    <div class="sup-icon">
                                        <img src="{{ asset('user/assets/images/order-ic/whatsapp.svg') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="border-1 mt-3">
                                <div class="d-flex justify-content-between">
                                    <div class="giftinfo-2">
                                        <p>Chat with the Support Team</p>
                                    </div>
                                    <div class="sup-icon">
                                        <img src="{{ asset('user/assets/images/order-ic/support-ic.svg') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>   


            </div>


            <div class="tab-pane fade" id="pills-plan" role="tabpanel" aria-labelledby="pills-plan-tab" tabindex="0">
               
                <div class="giftsearch py-3 d-flex w-100 gap-4">
                    <form action="#" method="GET" class="w-100 d-flex gap-0">
                        <div class="form-group w-100 d-flex">
                            <div class="searchicon"><i class="bi bi-search"></i></div>
                            <input type="search"  class="form-control giftcontrol" placeholder="Search">
                        </div>
                        <button type="submit" class="btn btnsearch">Search</button>
                    </form>

                    <a href="javascript:void(0)" class="add-icon" data-bs-toggle="modal" data-bs-target="#ticketModal">
                        <img src="{{ asset('user/assets/images/add-icon.svg') }}" alt="add" class="img-fluid">
                    </a>
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

            </div>

        </div>
    </div>

</div>


<!-- Add ticket Modal -->
<div class="modal fade" id="ticketModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Ticket deatils </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
           
            <div class="modal-body">
                <div class="sub-form py-2">
                    <div class="label-flex">
                        <label>Ticket Type</label>
                    </div>
                    <select class="form-select form-control  pline-10" aria-label="Default select example">
                        <option type="1">Ticket 1</option>
                        <option type="2">Ticket 2</option>
                    </select>
                </div>
                
                <div class="sub-form py-2">
                    <div class="label-flex">
                        <label>Title</label>
                    </div>
                    <input type="text" class="form-control pline-10" placeholder="Enter Product name">
                </div>
                <div class="sub-form py-2">
                    <div class="label-flex">
                        <label>Description</label>
                    </div>
                    <textarea class="form-control pline-10" rows="4" placeholder="Enter description"></textarea>
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



                <div class="cmn-btn mt-2">
                    <button type="submit" class="customBtn customBtn5 mt-5"> Submit </button>
                </div>

            </div>
           
        </div>
    </div>
</div>




@endsection

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