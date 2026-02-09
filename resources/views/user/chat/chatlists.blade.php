@extends('user.layout.app')

@section('content')


<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="{{route('dashboard')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
        <h3>Chat</h3>
    </div>

    <div class="main-content categoryDetail">
        <div class="row">
            <div class="col-lg-4">
                <div class="category_filter">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h3 class="mb-0">Filter</h3>
                        <a href="{{route('user.allChats')}}">Clear</a>
                    </div>
                    
                    <form>
                        <div class="orderfilter">
                            <label class="custom-radio mb-3">
                                <input type="radio" name="filters" value="1"
                                {{ request('filters') == '1' ? 'checked' : '' }}>
                                <span class="radio-mark"></span>
                                <div class="label-content">
                                    <div class="title">All</div>
                                </div>
                            </label>
                            <label class="custom-radio mb-3">
                                <input type="radio" name="filters" value="2"
                                {{ request('filters') == '2' ? 'checked' : '' }}>
                                <span class="radio-mark"></span>
                                <div class="label-content">
                                    <div class="title">Waiting </div>
                                </div>
                            </label>
                            <label class="custom-radio mb-3">
                                <input type="radio" name="filters" value="3"
                                {{ request('filters') == '3' ? 'checked' : '' }}>
                                <span class="radio-mark"></span>
                                <div class="label-content">
                                    <div class="title">Quotation Received
                                    </div>
                                </div>
                            </label>
                            <label class="custom-radio mb-3">
                                <input type="radio" name="filters" value="4"
                                {{ request('filters') == '4' ? 'checked' : '' }}>
                                <span class="radio-mark"></span>
                                <div class="label-content">
                                    <div class="title">Quotation Accepted
                                    </div>
                                </div>
                            </label>

                        </div>

                        <button type="submit" class="customBtn customBtn5 mt-5"> Apply </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="categoryDetail_content">
                    <form action="{{ route('user.allChats') }}" method="GET">
                        <div class="seArch">
                            <div class="form-group position-relative search">
                                <input type="text" class="form-control" placeholder="Search" name="search"
                                    value="{{ request()->search }}" />
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                            <button type="submit" class="customBtn customBtn5">
                                Search
                            </button>
                        </div>
                    </form>

                    @forelse ($chatData as $chat)
                        <div class="cart-panel position-relative">
                            <a href="{{ route('user.userChat', ['id' => $chat->unique_id]) }}" class="link-content">
                                <div class="cart-card">
                                    <div class="card-left mb-2 d-flex align-items-center">
                                        <div>
                                            <div class="chat-user-circle me-3">
                                                <img src="{{$chat['seller_details']['profile_pic']}}" alt="Product"
                                                    class="img-fluid">
                                            </div>
                                        </div>
                                        <div class="w-100">
                                            <div class="card-right d-flex w-100 justify-content-between">
                                                <div class="product-info">
                                                    <div class="product-title">{{$chat['seller_details']['first_name']}} {{$chat['seller_details']['last_name']}}</div>
                                                    @if(!empty($chat['last_chat']))
                                                    <div class="chat-user-light"> {{$chat['last_chat']}}</div>
                                                    @endif
                                                    @if(!empty($chat['last_chat_time']))
                                                    <div class="chat-user-light"> {{$chat['last_chat_time']}}</div>
                                                    @endif                                            
                                                </div>
                                                @if($chat['product_request'] == '1' && $chat['action'] == '0' && $chat['order_create_status'] == null)
                                                    <div class="yellow-bg" style="color:#EA9413;background:#EA94131A;">
                                                        Waiting
                                                    </div>

                                                @elseif($chat['product_request'] == '1' && $chat['action'] == '5' && $chat['order_create_status'] == null)
                                                    <div class="yellow-bg" style="color:#17854C;background:#17854C1A;">
                                                        Quotation Accepted
                                                    </div>

                                                @elseif($chat['product_request'] == '1' && $chat['order_create_status'] == null && in_array($chat['action'], ['3','4']))
                                                    <div class="yellow-bg" style="color:#D32F2F;background:#D32F2F1A;">
                                                        Quotation Rejected
                                                    </div>

                                                @elseif($chat['product_request'] == '1' && $chat['order_create_status'] == null && in_array($chat['action'], ['1','2']))
                                                    <div class="yellow-bg" style="color:#172B85;background:#172B851A;">
                                                    <!-- <div class="yellow-bg" style="color:#17854C;background:#17854C1A;"> -->
                                                        Quotation Received
                                                    </div>
                                                
                                                @elseif($chat['type'] == '2' && $chat['product_request'] == '1' && $chat['order_create_status'] !== null)
                                                <div class="yellow-bg" style="color:#17854C;background:#17854C1A;">
                                                    Order Placed
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
                            <h6 class="text-muted">No Chat Found</h6>
                        </div>
                    @endforelse

                    <!-- <div class="cart-panel position-relative">
                        <a href="order_details" class="link-content">
                            <div class="cart-card">
                                <div class="card-left mb-2 d-flex align-items-center">
                                    <div>
                                        <div class="chat-user-circle me-3">
                                            <img src="{{asset('user/assets/images/categorie1.png')}}" alt="Product"
                                                class="img-fluid">
                                        </div>
                                    </div>
                                    <div class="w-100">
                                        <div class="card-right d-flex w-100 justify-content-between">
                                            <div class="product-info">
                                                <h6 class="product-title"> Max jacobson</h6>
                                                <div class="chat-user-light"> Thank you, bro!</div>
                                                <div class="chat-user-light"> Today 5 PM</div>                                            
                                            </div>
                                            <div class="yellow-bg" style="color:#172B85;background:#172B851A;">Quotation Received</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div> -->

                    <!-- <div class="cart-panel position-relative">
                        <a href="order_details" class="link-content">
                            <div class="cart-card">
                                <div class="card-left mb-2 d-flex align-items-center">
                                    <div>
                                        <div class="chat-user-circle me-3">
                                            <img src="{{asset('user/assets/images/item-2.svg')}}" alt="Product"
                                                class="img-fluid">
                                        </div>
                                    </div>
                                    <div class="w-100">
                                        <div class="card-right d-flex w-100 justify-content-between">
                                            <div class="product-info">
                                                <h6 class="product-title"> Max jacobson</h6>
                                                <div class="chat-user-light"> Thank you, bro!</div>
                                                <div class="chat-user-light"> Today 5 PM</div>                                            
                                            </div>
                                            <div class="yellow-bg" style="color:#17854C;background:#17854C1A;">Quotation Accepted</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div> -->

                    <!-- <div class="cart-panel position-relative">
                        <a href="order_details" class="link-content">
                            <div class="cart-card">
                                <div class="card-left mb-2 d-flex align-items-center">
                                    <div>
                                        <div class="chat-user-circle me-3">
                                            <img src="{{asset('user/assets/images/item-1.svg')}}" alt="Product"
                                                class="img-fluid">
                                        </div>
                                    </div>
                                    <div class="w-100">
                                        <div class="card-right d-flex w-100 justify-content-between">
                                            <div class="product-info">
                                                <h6 class="product-title"> Max jacobson</h6>
                                                <div class="chat-user-light"> Thank you, bro!</div>
                                                <div class="chat-user-light"> Today 5 PM</div>                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div> -->




                </div>
            </div>
        </div>


    </div>

</div>






<div id="loader" style="display:none;">
    <div class="loader"></div>
</div>



@endsection