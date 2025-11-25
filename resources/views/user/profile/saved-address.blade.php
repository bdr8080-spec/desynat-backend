@extends('user.layout.app')

@section('content')

<div class="my-profile customContainer" style="margin-top: 11%;">
    <div class="d-flex align-items-center mt-3 justify-content-between">
        <a href=""><i class="fa-solid fa-chevron-left"></i>My Saved Address</a>
    </div>

    <div class="saved-address-contenar">
        <div class="saved_address_content">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span><i class="bi bi-building"></i> Office</span>
                </div>
                <div>
                    <a><img src="assets/images/edit.svg" class="img-fluid" /></a>
                    <a><img src="assets/images/delete.svg" class="img-fluid" /></a>
                    <span class="setAsdefault custom-btn3">Set as Default</span>
                </div>
            </div>
            <h6>Alex</h6>
            <p>HN- 547, Street no,5 Block d new town hale, Saudi Arabia Riyad- 10214</p>
        </div>
        <div class="saved_address_content">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span><i class="bi bi-house"></i> Home</span>
                </div>
                <div>
                    <a><img src="assets/images/edit.svg" class="img-fluid" /></a>
                    <a><img src="assets/images/delete.svg" class="img-fluid" /></a>
                    <span class="setAsdefault custom-btn3">Set as Default</span>
                </div>
            </div>
            <h6>Alex</h6>
            <p>HN- 547, Street no,5 Block d new town hale, Saudi Arabia Riyad- 10214</p>
        </div>
        <a href="add-new-addres.html" class="custom-btn3 add_new_address" >+ Add New Address</a>
    </div>
</div>


@endsection