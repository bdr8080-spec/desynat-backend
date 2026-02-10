@include('affiliatedUser.layout.header')

<section class="section dashboard">
    <div class="d-flex justify-content-between mt-4 mb-5">
        <a href="/category" class="title24 alink"> 
            <i class="bi bi-chevron-left"></i> All Products
        </a>
    </div>
    <div class="search-field d-flex align-items-center">
        <div class="from-group position-relative w-100">
            <img src="{{ asset('dealer') }}/assets/img/search-icon.svg" alt="search" class="search-icon2">
            <input type="search" class="form-control py-3" placeholder="Search">
        </div>
        <button type="button" class="btn btn-success searchlin">Search</button>
    </div>
    
   

    

   

</section>




@include('affiliatedUser.layout.footer');


