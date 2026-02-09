@include('affiliatedUser.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl">
        <div class="title24">Category </div>
    </div>

    <div class="tabs-panel py-4">
        <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active w-100" id="pills-allproduct-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-allproduct" type="button" role="tab" aria-controls="pills-allproduct"
                    aria-selected="true">Men </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link w-100" id="pills-address-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-address" type="button" role="tab" aria-controls="pills-active"
                    aria-selected="false"> Woman</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link w-100" id="pills-inactive-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-bank" type="button" role="tab" aria-controls="pills-bank"
                    aria-selected="false"> Kids</button>
            </li>

        </ul>
    </div>

    <div class="tab-body-wapper">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-allproduct" role="tabpanel"
                aria-labelledby="pills-allproduct-tab" tabindex="0">
                <div class="personl-wapper">
                   
                   

                   
                </div>

            </div>

            <div class="tab-pane fade" id="pills-address" role="tabpanel" aria-labelledby="pills-address-tab"
                tabindex="0">
               


            </div>

            <div class="tab-pane fade" id="pills-bank" role="tabpanel" aria-labelledby="pills-bank-tab" tabindex="0">

            

            </div>
        </div>
    </div>

</section>




@include('affiliatedUser.layout.footer');


</script>