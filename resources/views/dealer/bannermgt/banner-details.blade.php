@include('dealer.layout.header')

<section class="section dashboard">
    <!-- <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <a class="title24 alink"> <i class="bi bi-chevron-left"></i>Details</a>

    </div> -->
    <div class="d-flex justify-content-between mt-4">
        <a class="title24 alink"> <i class="bi bi-chevron-left"></i>Details</a>
        <span class="upper-text">Confirmed</span>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="banner-box mb-4">
                <img src="dealer/assets/img/banner-box.svg" />
            </div>
            <label class="banner-text">Banner position</label>
            <input type="text" class="form-control" value="Homepage - Top" />

            <div class="d-flex justify-content-between mt-4">
                <h6 class="banner-texts">Select Duration</h6>
                <span class="banner-texts">Total days - 07</span>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <label class="banner-text">From</label>
                    <input type="date" class="form-control mb-4" />
                </div>
                <div class="col-md-12">
                    <label class="banner-text">To</label>
                    <input type="date" class="form-control" />
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <h6>SELECT PAYMENT METHOD</h6>
            <div class="payment-box">

                <div class="check_radio">
                    <label class="radio-group">
                        <input type="radio" name="category_id">
                        <span class="custom-radio"></span>
                        <img src="dealer/assets/img/credit-card.svg">
                        <span class="radio-label"> Credit / Debit Card</span>
                    </label>
                </div>


                <div class="card-option">
                    <label class="radio-group">
                        <input type="radio" name="category_id">
                        <span class="custom-radio"></span>
                        <span class="radio-label"> XXXXXXXX2783</span>
                    </label>
                </div>

                <div class="card-option">
                    <label class="radio-group">
                        <input type="radio" name="category_id">
                        <span class="custom-radio"></span>
                        <span class="radio-label"> XXXXXXXX2783</span>
                    </label>
                </div>

                <button class="add-card" id="openAddCard">+ Add new card</button>
            </div>
        </div>
        <div class="dashboard-button d-flex mt-5 gap-5">
            <button type="button" class="btn total-outline w-100">Total Price <strong>499KD</strong></button>
            <button type="submit" class="btn add-fillbtn w-100">Pay Now</button>
        </div>


</section>

<!-- OVERLAY -->
<div class="overlay" id="overlay"></div>

<!-- ADD CARD DRAWER -->
<div class="add-card-drawer" id="addCardDrawer">
    <div class="drawer-header">
        <h5>Add Card</h5>
        <span class="close-btn" id="closeDrawer">&times;</span>
    </div>
    <div class="drawer-body">

        <!-- CARD INPUT BOX -->
        <div class="card-form-box">
            <label>Card Holder Name</label>
            <input type="text" placeholder="Card Holder Name" />

            <label>Card Number</label>
            <input type="text" placeholder="Card Number" />

            <div class="row">
                <div class="col-8">
                    <label>Expiry Date</label>
                    <input type="text" placeholder="MM / YY" />
                </div>
                <div class="col-4">
                    <label>CVV</label>
                    <input type="password" placeholder="CVV" />
                </div>
            </div>
        </div>

        <!-- ✅ CHECKBOX OUTSIDE BOX -->
        <!-- <div class="save-card">
            <input type="checkbox" />
            <span>Save Card for Future</span>
        </div> -->

        <div class="check-field">
            <input type='checkbox' />
            <span>Save Card For Future </span>
        </div>

    </div>


    <div class="drawer-footer">
        <button class="pay-btn">Pay Now</button>
    </div>
</div>


<script>
const openBtn = document.getElementById("openAddCard");
const closeBtn = document.getElementById("closeDrawer");
const drawer = document.getElementById("addCardDrawer");
const overlay = document.getElementById("overlay");

openBtn.addEventListener("click", () => {
    drawer.classList.add("active");
    overlay.classList.add("active");
});

closeBtn.addEventListener("click", closeDrawer);
overlay.addEventListener("click", closeDrawer);

function closeDrawer() {
    drawer.classList.remove("active");
    overlay.classList.remove("active");
}
</script>


@include('dealer.layout.custom_code');



@include('dealer.layout.footer');