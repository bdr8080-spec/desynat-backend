@include('affiliatedUser.layout.header')

<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="{{route('affiliate.affiliateDashboard')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
        <h3> {{ __('affiliate_messages.faqs') }} </h3>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="live-pnl">

                <div class="faq-lists">
                    <div class="accordion" id="accordionExample">

                        @if($data->isEmpty())

                            <div class="text-center py-4">
                                <strong>{{ __('affiliate_messages.no_faq_found') }}</strong>
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
                                            
                                            @if(app()->getLocale() == 'en')
                                            {{ $faq->question_english }}
                                            @else
                                            {{ $faq->question_arabic }}
                                            @endif

                                        </button>

                                    </h2>

                                    <div id="collapse{{ $faq->id }}"
                                        class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}"
                                        data-bs-parent="#accordionExample">

                                        <div class="accordion-body">
                                             @if(app()->getLocale() == 'en')
                                            {!! $faq->answer_english !!}
                                            @else
                                            {!! $faq->answer_arabic !!}
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

@include('affiliatedUser.layout.footer')