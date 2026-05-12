  <div class="tab-body-wapper">
      <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-allproduct" role="tabpanel"
              aria-labelledby="pills-allproduct-tab" tabindex="0">
              <div class="personl-wapper">
                  <div class="title24">{{ __('affiliate_messages.sub_category') }} </div>

                  <div class="sub-category-wrapper py-4">

                      @foreach($all_subcategory as $key=>$sub)
                      <div class="sub-category-pnl">
                          <a
                              href="
                              {{ route('affiliate.allProducts', [
                                    'category_id'    => [$sub->category_id],
                                    'subcategory_id' => [$sub->id]
                                ]) }}">
                              <div class="sub-grid">
                                  <figure>
                                      <img src="{{$sub->image}}" alt="image" class="img-fluid">
                                  </figure>
                              </div>
                              <div class="sub-title">
                                @if(app()->getLocale() == 'en')
                                {{$sub->name_english}}
                                @else
                                {{$sub->name_arabic}}
                                @endif
                            </div>
                          </a>
                      </div>

                      @endforeach

                  </div>

              </div>

          </div>
      </div>
  </div>