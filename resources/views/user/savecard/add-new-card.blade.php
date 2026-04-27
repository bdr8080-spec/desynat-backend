@extends('user.layout.app')

@section('content')


<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="{{route('user.saved_cards')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
        <h3>Add New Cards</h3>
    </div>

    <!-- <div class="main-content categoryDetail">
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




    </div> -->

    <div class="main-content categoryDetail">

        <div class="form-group w-100 py-2">
            <label>Card Holder Name</label>
            <input type="text" id="card_holder_name" class="form-control pline-10" placeholder="Card Holder Name" oninput="this.value = this.value.replace(/[^A-Za-z ]/g,'').replace(/^\s+/,'')">
            <small class="text-danger" id="error_card_holder_name"></small>
        </div>   

        <div class="form-group w-100 py-2">
            <label>Card Number</label>
            <input type="text" id="card_number" class="form-control pline-10" placeholder="Card Number" oninput="this.value = this.value.replace(/\D/g,'').slice(0,19)">
            <small class="text-danger" id="error_card_number"></small>
        </div>   

        <div class="row">

            <div class="col-lg-6">
                <div class="form-group w-100 py-2">
                    <label>Expiry Date</label>
                    <input type="text" id="expiry_date" class="form-control pline-10" placeholder="Expiration Date" oninput="this.value = this.value.replace(/[^0-9\/]/g,'').slice(0,5)">
                    <small class="text-danger" id="error_expiry_date"></small>
                </div>  
            </div>

            <div class="col-lg-6">
                <div class="form-group w-100 py-2">
                    <label>CVV</label>
                    <input type="text" id="cvv" class="form-control pline-10" placeholder="CVV" oninput="this.value = this.value.replace(/\D/g,'').slice(0,4)">
                    <small class="text-danger" id="error_cvv"></small>
                </div>  
            </div>

        </div>

        <div class="form-check py-1 form-group">
            <input class="form-check-input" type="checkbox" value="1" id="savecard" name="accept">
            <label class="form-check-label mt-0" for="savecard">
                Save Card for Future
            </label>
        </div>

        <div class="cmn-btn mt-4">
            <button type="button" id="saveCardBtn" class="btn paybtn-common w-100">
                Save
            </button>
        </div>

    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const btn = document.getElementById('saveCardBtn');

    function showError(id, message) {
        let el = document.getElementById('error_' + id);
        if (el) el.innerText = message;
    }

    function clearError(id) {
        let el = document.getElementById('error_' + id);
        if (el) el.innerText = '';
    }

    document.getElementById('card_holder_name').addEventListener('input', () => clearError('card_holder_name'));
    document.getElementById('card_number').addEventListener('input', () => clearError('card_number'));
    document.getElementById('expiry_date').addEventListener('input', () => clearError('expiry_date'));
    document.getElementById('cvv').addEventListener('input', () => clearError('cvv'));

    function validateForm() {

        let valid = true;

        let holder = document.getElementById('card_holder_name').value.trim();
        let number = document.getElementById('card_number').value.trim();
        let expiry = document.getElementById('expiry_date').value.trim();
        let cvv = document.getElementById('cvv').value.trim();

        if (!holder) {
            showError('card_holder_name', 'Please enter card holder name');
            valid = false;
        }

        if (!number) {
            showError('card_number', 'Please enter card number');
            valid = false;
        } 
        else if (!/^\d{13,19}$/.test(number.replace(/\s+/g, ''))) {
            showError('card_number', 'Card number must be 13 to 19 digits');
            valid = false;
        }

        if (!expiry) {
            showError('expiry_date', 'Please enter expiry date');
            valid = false;
        } 
        else if (!/^\d{2}\/\d{2}$/.test(expiry)) {
            showError('expiry_date', 'Expiry must be in MM/YY format');
            valid = false;
        } 
        else {
            let parts = expiry.split('/');
            let month = parseInt(parts[0], 10);
            let year = parseInt(parts[1], 10);

            if (month < 1 || month > 12) {
                showError('expiry_date', 'Invalid month in expiry date');
                valid = false;
            }
        }

        if (!cvv) {
            showError('cvv', 'Please enter CVV');
            valid = false;
        } else if (!/^\d{3,4}$/.test(cvv)) {
            showError('cvv', 'CVV should be 3-4 digits');
            valid = false;
        }

        return valid;
    }

    btn.addEventListener('click', function () {

        // clear previous errors
        clearError('card_holder_name');
        clearError('card_number');
        clearError('expiry_date');
        clearError('cvv');

        if (!validateForm()) return;

        let payload = {
            card_holder_name: document.getElementById('card_holder_name').value,
            card_number: document.getElementById('card_number').value,
            expiry_date: document.getElementById('expiry_date').value,
            cvv: document.getElementById('cvv').value,
            is_future: document.getElementById('savecard').checked ? 1 : 0
        };

        btn.disabled = true;
        btn.innerText = 'Please wait...';

        fetch("{{ route('user.save_new_card') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {

            btn.disabled = false;
            btn.innerText = 'Save';

            if (data.status === 'success') {
                toastr.success(data.message);

                setTimeout(() => {
                    window.location.href = "{{ route('user.saved_cards') }}";
                }, 1000);

            } else {
                toastr.error(data.message || 'Something went wrong');
            }

        })
        .catch(err => {

            btn.disabled = false;
            btn.innerText = 'Save';

            console.log(err);
            toastr.error('Request failed');

        });

    });

});
</script>










@endsection