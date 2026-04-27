@extends('user.layout.app')

@section('content')


<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="{{route('dashboard')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
        <h3>Add New Cards</h3>
    </div>

    <div class="main-content categoryDetail">
        <div class="form-group w-100 py-2">
            <label>Card Holder Name </label>
            <input type="text" class="form-control pline-10" placeholder="Card Holder Name">
        </div>   
        <div class="form-group w-100 py-2">
            <label>Card Number</label>
            <input type="text" class="form-control pline-10" placeholder="Card Number">
        </div>   
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group w-100 py-2">
                    <label>Expiry Date</label>
                    <input type="text" class="form-control pline-10" placeholder="Expiration Date ">
                </div>  
            </div>
            <div class="col-lg-6">
                <div class="form-group w-100 py-2">
                    <label>CVV</label>
                    <input type="text" class="form-control pline-10" placeholder="CVV">
                </div>  
            </div>
        </div>
        <div class="form-check py-1 form-group">
            <input class="form-check-input" type="checkbox" value="1" id="savecard" name="accept">
            <label class="form-check-label mt-0" for="savecard"> Save Card for Future</label>
        </div>

        <div class="cmn-btn mt-4">
            <button type="submit" class="btn paybtn-common w-100">Save</button>
        </div>




    </div>
</div>










@endsection