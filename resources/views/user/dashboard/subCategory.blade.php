        
        
        <div class="row">
          <h3>Categories</h3>
        @forelse ($subCategory as $item)
            <div class="col-lg-4 col-md-4 col-6 my-lg-3 my-2 text-center">
                <div class="categorie_cotent">
                    <div class="categorie_cotent-img">
                        <img src="{{$item->image}}" class="img-fluid" />
                    </div>
                    <h3>{{$item->name_english}}</h3>
                </div>
            </div>
          @empty
            <div class="col-lg-4 col-md-4 col-6 my-3 text-center categorie_cotent">
                {{-- <img src="{{asset('user/assets/images/categorie1.png')}}" class="img-fluid" /> --}}
                <h3>No Category Found</h3>
            </div>
          @endforelse
        </div>