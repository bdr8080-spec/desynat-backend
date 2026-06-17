@extends('user.layout.app')

@section('content')


<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="{{route('dashboard')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
        <h3>{{ __('user_messages.chat') }}</h3>
    </div>

    <div class="main-content categoryDetail">
        <div class="row">
            <div class="col-lg-4">
                <div class="category_filter">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h3 class="mb-0">{{ __('user_messages.filter') }}</h3>
                        <a href="{{route('user.allChats')}}">{{ __('user_messages.clear') }}</a>
                    </div>
                    
                    <form>
                        <div class="orderfilter">
                            <label class="custom-radio mb-3">
                                <input type="radio" name="filters" value="1"
                                {{ request('filters') == '1' ? 'checked' : '' }}>
                                <span class="radio-mark"></span>
                                <div class="label-content">
                                    <div class="title">{{ __('user_messages.all') }}</div>
                                </div>
                            </label>
                            <label class="custom-radio mb-3">
                                <input type="radio" name="filters" value="2"
                                {{ request('filters') == '2' ? 'checked' : '' }}>
                                <span class="radio-mark"></span>
                                <div class="label-content">
                                    <div class="title">{{ __('user_messages.waiting') }} </div>
                                </div>
                            </label>
                            <label class="custom-radio mb-3">
                                <input type="radio" name="filters" value="3"
                                {{ request('filters') == '3' ? 'checked' : '' }}>
                                <span class="radio-mark"></span>
                                <div class="label-content">
                                    <div class="title">{{ __('user_messages.quotation_received') }}
                                    </div>
                                </div>
                            </label>
                            <label class="custom-radio mb-3">
                                <input type="radio" name="filters" value="4"
                                {{ request('filters') == '4' ? 'checked' : '' }}>
                                <span class="radio-mark"></span>
                                <div class="label-content">
                                    <div class="title">{{ __('user_messages.quotation_accepted') }}
                                    </div>
                                </div>
                            </label>

                        </div>

                        <button type="submit" class="customBtn customBtn5 mt-5"> {{ __('user_messages.apply') }} </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="categoryDetail_content">
                    <form action="{{ route('user.allChats') }}" method="GET">
                        <div class="seArch">
                            <div class="form-group position-relative search">
                                <input type="text" class="form-control" placeholder="{{ __('user_messages.search') }}" name="search"
                                    value="{{ request()->search }}" />
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                            <button type="submit" class="customBtn customBtn5">
                                {{ __('user_messages.search') }}
                            </button>
                        </div>
                    </form>

                    @forelse ($chatData as $chat)
                        <div class="cart-panel position-relative">
                            <a href="{{ route('user.userChat', ['id' => $chat->unique_id]) }}" class="link-content chat-link" data-id="{{ $chat->unique_id }}">
                                <div class="cart-card">
                                    @if($chat['unread_count'] > 0)
                                    <span class="badge text-bg-danger badge-number">{{ $chat['unread_count'] }}</span>
                                    @endif
                                    <div class="card-left mb-2 d-flex align-items-center">
                                        <div>
                                            <div class="chat-user-circle me-3">
                                                <img src="{{$chat['seller_details']['profile_pic']}}" alt="Product"
                                                    class="img-fluid">
                                            </div>
                                        </div>
                                        <div class="w-100">
                                            <div class="card-right d-flex w-100 justify-content-between">
                                                @if(app()->getLocale() == 'en')
                                                <div class="product-info">
                                                    <div class="product-title">{{$chat['seller_details']['first_name']}} {{$chat['seller_details']['last_name']}}</div>
                                                    @if(!empty($chat['last_chat']))
                                                    <div class="chat-user-light"> {{$chat['last_chat']}}</div>
                                                    @endif
                                                    @if(!empty($chat['last_chat_time']))
                                                    <div class="chat-user-light"> {{ formatDateTimeByLocale($chat['last_chat_time']) }}</div>
                                                    @endif                                            
                                                </div>
                                                @else
                                                <div class="product-info">
                                                    <div class="product-title">{{$chat['seller_details']['first_name']}} {{$chat['seller_details']['last_name']}}</div>
                                                    @if(!empty($chat['last_chat_ar']))
                                                    <div class="chat-user-light"> {{$chat['last_chat_ar']}}</div>
                                                    @endif
                                                    @if(!empty($chat['last_chat_time']))
                                                    <div class="chat-user-light">{{ formatDateTimeByLocale($chat['last_chat_time']) }}</div>
                                                    @endif                                            
                                                </div>
                                                @endif
                                                @if($chat['product_request'] == '1' && $chat['action'] == '0' && $chat['order_create_status'] == null)
                                                    <div class="yellow-bg" style="color:#EA9413;background:#EA94131A;">
                                                        {{ __('user_messages.waiting') }}
                                                    </div>

                                                @elseif($chat['product_request'] == '1' && $chat['action'] == '5' && $chat['order_create_status'] == null)
                                                    <div class="yellow-bg" style="color:#17854C;background:#17854C1A;">
                                                        {{ __('user_messages.quotation_accepted') }}
                                                    </div>

                                                @elseif($chat['product_request'] == '1' && $chat['order_create_status'] == null && in_array($chat['action'], ['3','4']))
                                                    <div class="yellow-bg" style="color:#D32F2F;background:#D32F2F1A;">
                                                        {{ __('user_messages.quotation_rejected') }}
                                                    </div>

                                                @elseif($chat['product_request'] == '1' && $chat['order_create_status'] == null && in_array($chat['action'], ['1','2']))
                                                    <div class="yellow-bg" style="color:#172B85;background:#172B851A;">
                                                    <!-- <div class="yellow-bg" style="color:#17854C;background:#17854C1A;"> -->
                                                        {{ __('user_messages.quotation_received') }}
                                                    </div>
                                                
                                                @elseif($chat['type'] == '2' && $chat['product_request'] == '1' && $chat['order_create_status'] !== null)
                                                <div class="yellow-bg" style="color:#17854C;background:#17854C1A;">
                                                    {{ __('user_messages.order_placed') }}
                                                </div>

                                                @elseif($chat['type'] == '1')
                                                   
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <h6 class="text-muted">{{ __('user_messages.no_chat_found') }}</h6>
                        </div>
                    @endforelse





                </div>
            </div>
        </div>


    </div>

</div>






<div id="loader" style="display:none;">
    <div class="loader"></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).on('click', '.chat-link', function(e) {
    e.preventDefault();
    e.stopPropagation();   
    e.stopImmediatePropagation(); 

    let url = $(this).attr('href');
    let unique_id = $(this).data('id');

    $.ajax({
        url: "{{ route('user.mark_all_chat_msg_as_read') }}",
        type: "POST",
        data: {
            unique_id: unique_id,
            _token: "{{ csrf_token() }}"
        },
        success: function(res) {
            console.log(res);
             window.location.href = url;
        }
    });

    return false; 
});
</script>



@endsection