       <!-- Main Image -->
       <div class="main-img-container mb-3">
           <img id="mainImage" src="{{ $images_show[0][0] }}" class="img-fluid" class="img-fluid rounded main-img"
               alt="">
           <!-- <img src="{{ asset('user/assets/images/categorie1.png') }}" class="img-fluid" /> -->
       </div>

       <div class="d-flex justify-content-center gap-2  my-1" style="position:absolute;bottom:1rem;left:50%; transform: translate(-50%, -20%);">

           @foreach ($images_show as $item)

           @foreach ($item as $item1)
           <img src="{{ $item1 }}" class="thumb-img" onclick="changeImage(this.src)">
           @endforeach

           @endforeach



           {{-- <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" class="thumb-img"
                    onclick="changeImage(this.src)">

                <img src="{{ asset('dealer/assets/img/image33.png') }}" class="thumb-img"
           onclick="changeImage(this.src)">

           <img src="{{ asset('dealer/assets/img/image33.png') }}" class="thumb-img" onclick="changeImage(this.src)">
           --}}

       </div>