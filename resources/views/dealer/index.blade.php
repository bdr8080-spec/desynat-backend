@include ('dealer/header');


<div class="pagetitle mb-4">
    <h1>Dashboard</h1>

</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl">
        <!-- <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="card border-radious-10">
                    <div class="card-header">
                        <div class="total-revenue">
                            <h3><i class="bi bi-currency-dollar"></i> 1,20,2000</h3>
                        </div>
                        <div class="total-revenue">
                            <h3>Total Revenue</h3>
                            <div>As of now</div>
                        </div>
                        <div class="dolor-icon">
                            <img src="assets/img/all-icons/rev-icon.svg" alt="icon">
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="total-sale b-line text-center col-lg-4">
                                <p>Total Products</p>
                                <h5>136</h5>
                            </div>
                            <div class="total-sale b-line text-center col-lg-4">
                                <p>Total Sales</p>
                                <h5>136</h5>
                            </div>
                            <div class="total-sale b-line-2 text-center col-lg-4">
                                <p>Total Orders</p>
                                <h5>136</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-5">
                <div class="card border-radious-10">
                    <div class="card-header">
                        <div class="total-revenue">
                            <h3>Order Stats</h3>
                        </div>
                        <div class="dolor-icon">
                            <img src="assets/img/all-icons/od-ic.svg" alt="icon">
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="total-sale b-line text-center col-lg-4">
                                <p>Ongoing</p>
                                <h5>136</h5>
                            </div>
                            <div class="total-sale b-line text-center col-lg-4">
                                <p>Completed</p>
                                <h5>136</h5>
                            </div>
                            <div class="total-sale b-line-2 text-center col-lg-4">
                                <p>Canceled</p>
                                <h5>36</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>

    <!-- <div class="new-heading">
        <h4>New Orders</h4>
    </div>

    <div class="order-pnl">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="card-order">
                    <figure>
                        <img src="assets/img/all-icons/image.png" alt="icon">
                    </figure>
                    <figure-caption>
                        <div class="order-flex">
                            <div class="order-content">
                                <h5>Cartier Santos</h5>
                                <p>Order Id:#abc123456</p>
                            </div>
                            <div class="order-amount">
                                <i class="bi bi-currency-dollar"></i>52000
                            </div>
                        </div>
                        </figure-coption>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="card-order">
                    <figure>
                        <img src="assets/img/all-icons/img-2.png" alt="icon">
                    </figure>
                    <figure-caption>
                        <div class="order-flex">
                            <div class="order-content">
                                <h5>Cartier Santos</h5>
                                <p>Order Id:#abc123456</p>
                            </div>
                            <div class="order-amount">
                                <i class="bi bi-currency-dollar"></i>52000
                            </div>
                        </div>
                        </figure-coption>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="card-order">
                    <figure>
                        <img src="assets/img/all-icons/image.png" alt="icon">
                    </figure>
                    <figure-caption>
                        <div class="order-flex">
                            <div class="order-content">
                                <h5>Cartier Santos</h5>
                                <p>Order Id:#abc123456</p>
                            </div>
                            <div class="order-amount">
                                <i class="bi bi-currency-dollar"></i>52000
                            </div>
                        </div>
                        </figure-coption>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="card-order" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <figure>
                        <img src="assets/img/all-icons/img-2.png" alt="icon">
                    </figure>
                    <figure-caption>
                        <div class="order-flex">
                            <div class="order-content">
                                <h5>Cartier Santos</h5>
                                <p>Order Id:#abc123456</p>
                            </div>
                            <div class="order-amount">
                                <i class="bi bi-currency-dollar"></i>52000
                            </div>
                        </div>
                        </figure-coption>
                </div>
            </div>
        </div>
    </div> -->


</section>


<!-- Edit shipping Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
               <div class="delete-body text-center p-3">
                    <div class="trash-box">
                        <i class="bi bi-trash3"></i>
                    </div>
                    <h4 class="domestic-title"> Are you sure you want to delete this domestic cost?</h4>
               </div>
                <div class="login-btn mt-4 d-flex justify-content-between gap-3">
                    <button type="button" class="btn btn-success w-100" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger-outline w-100">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

@include ('dealer/footer');