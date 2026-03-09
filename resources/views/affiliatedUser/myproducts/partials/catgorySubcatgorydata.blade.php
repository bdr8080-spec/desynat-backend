    <div class="all-product-lists subcategory-item active" id="selectSubcatgoty_all" data-subcategory="all">
        <div class="af-box" style="background: #a8825a;">
            <img src="{{ asset('dealer') }}/assets/img/all-ic.svg" class="img-fluid">
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