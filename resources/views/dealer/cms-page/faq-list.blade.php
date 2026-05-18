@include('dealer.layout.header')
<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="{{route('seller.dashboard')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
        <h3> {{__('seller_messages.FAQ')}}  </h3>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="live-pnl">

              
                <div class="faq-lists">
                    <div class="accordion" id="accordionExample">

                        @if($data->isEmpty())

                            <div class="text-center py-4">
                                <strong>{{__('seller_messages.No_FAQ_Found')}} </strong>
                            </div>

                        @else

                            @foreach($data as $key => $faq)

                                <div class="accordion-item mb-4">
                                    <h2 class="accordion-header">

                                        <button class="accordion-button {{ $key != 0 ? 'collapsed' : '' }}"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $faq->id }}"
                                            aria-expanded="{{ $key == 0 ? 'true' : 'false' }}"
                                            aria-controls="collapse{{ $faq->id }}">

                                                @if(App::getlocale()=='ar') 
                                                {{ $faq->question_arabic }}
                                                @else 
                                                {{ $faq->question_english }}

                                                @endif

                  
                                        </button>

                                    </h2>

                                    <div id="collapse{{ $faq->id }}"
                                        class="accordion-collapse collapse {{ $key == 0 ? 'hide' : '' }}"
                                        data-bs-parent="#accordionExample">

                                        <div class="accordion-body">
                                           


                                            @if(App::getlocale()=='ar') 
                                            {!! $faq->answer_arabic !!}
                                            @else 
                                            {!! $faq->answer_english !!}

                                            @endif

                                        </div>

                                    </div>
                                </div>

                            @endforeach

                        @endif

                    </div>
                </div>



            </div>
        </div>
    </div>


</div>

@include('dealer.layout.custom_code')
@include('dealer.layout.footer')