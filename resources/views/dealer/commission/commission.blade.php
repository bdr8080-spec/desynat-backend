@include('dealer.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <div class="title24">Affiliated Commission</div>
    </div>

    <div class="personl-wapper">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="sub-form">
                    <div class="label-flex">
                        <label>Set Commission % for affiliated customer</label>
                    </div>
                    <input type="text" class="form-control" placeholder="Eg. 5%">
                </div>
            </div>
        </div>

        <div class="dashboard-button mt-4">
            <button type="submit" class="btn add-fillbtn w-100">Save</button>
        </div>
    </div>


</section>


@include('dealer.layout.footer');