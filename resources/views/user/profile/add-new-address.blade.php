@extends('user.layout.app')

@section('content')

<div class="my-profile customContainer">
    <div class="d-flex align-items-center mt-3 justify-content-between">
        <a href=""><i class="fa-solid fa-chevron-left"></i> Add New Address</a>
    </div>

    <div class="row mt-5">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="">Name</label>
                <input type="text" class="form-control" placeholder="Faizan Ansari" />
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="">Mobile No.</label>
                <input type="text" class="form-control" placeholder="Enter Mobile No." />
                <!-- <a class="change">Change</a> -->
            </div>
        </div>
            <div class="col-lg-6  mt-3">
            <div class="form-group position-relative">
                <label for="">Address</label>
                <input type="text" class="form-control" placeholder="Enter Address" />
                <a class="track"  data-bs-toggle="modal" data-bs-target="#changeLocation"><i class="bi bi-crosshair"></i></a>
            </div>
        </div>
        <div class="col-lg-6  mt-3">
            <div class="form-group">
                <label for="">House no./Building no/Area</label>
                <input type="text" class="form-control" placeholder="Enter House no./Building no/Area" />
                <!-- <a class="change">Change</a> -->
            </div>
        </div>
        <div class="col-lg-6  mt-3">
            <div class="form-group">
                <label for="">Block/Street</label>
                <input type="text" class="form-control" placeholder="Enter Block/Street" />
                <!-- <a class="change">Change</a> -->
            </div>
        </div>
        <div class="col-lg-6 mt-3">
            <div class="form-group">
                <label for="">Postal Code (optional)</label>
                <input type="text" class="form-control" placeholder="Enter Postal Code " />
            </div>
        </div>
        <div class="col-lg-6  mt-3">
            <div class="form-group">
                <label for="">City/District</label>
                <input type="text" class="form-control" placeholder="Enter City/District" />
            </div>
        </div>
        <div class="col-lg-6 mt-3">
            <div class="form-group">
                <label for="">State</label>
                <input type="text" class="form-control" placeholder="Enter State " />
            </div>
        </div>
        <div class="col-lg-12  mt-3">
            <div class="form-group">
                <label for="">Save Address As</label>
            </div>
        </div>
        <div class="col-lg-6  mt-3">
            <div class="form-group address-tab position-relative">
                <input type="text" class="form-control" style="background: transparent;" />
                <span><i class="bi bi-house"></i> home</span>
            </div>
        </div>
        <div class="col-lg-6 mt-3">
            <div class="form-group address-tab position-relative">
                <input type="text" class="form-control" style="background: transparent;" />
                <span><i class="bi bi-building"></i> Office</span>
            </div>
        </div>
        <div class="col-lg-12">
            <button class="customBtn w-100 mt-4">Save</button>
        </div>
    </div>
</div>

    <!-- Modal -->
    <div class="modal fade" id="changeLocation" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header  border-0">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Change Location</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="form-group position-relative search">
                            <input type="text" class="form-control" placeholder="Search address" />
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <div>
                            <img src="https://staticmapmaker.com/img/google-placeholder.png" class="img-fluid" />
                        </div>
                        <div class="">
                            <h5>Location</h5>
                            <p>HN- 547, Street no,5 Block d new town hale, Saudi Arabia</p>
                        </div>
                        <button class="customBtn">Change Location</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).ready(function () {
            $(".address-tab").click(function () {
                $(".address-tab").removeClass("active");
                $(this).addClass("active");
            });
        });
    </script>

@endsection