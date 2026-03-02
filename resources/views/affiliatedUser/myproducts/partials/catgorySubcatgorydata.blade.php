    <div class="all-product-lists subcategory-item active" id="selectSubcatgoty_all" data-subcategory="all">
        <div class="af-box">
            <img src="image.jpg" class="img-fluid">
        </div>
        <div class="af-title">All</div>
    </div>

    @foreach($all_subcategory as $val)
    <div class="all-product-lists subcategory-item" data-subcategory="{{ $val->id }}"
        id="selectSubcatgoty_{{$val->id}}">
        <div class="af-box">
            <img src="{{ $val->image }}" class="img-fluid">
        </div>
        <div class="af-title">{{ $val->name_english }}</div>
    </div>
    @endforeach