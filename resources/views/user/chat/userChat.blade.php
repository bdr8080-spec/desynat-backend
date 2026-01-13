@extends('user.layout.app')

@section('content')


<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="{{route('user.allChats')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
        <h3>Chat</h3>
    </div>

    <div class="main-content">
       @if($chatData['record']->type == '2')
        <div class="row">
            <div class="col-lg-4">
                <div class="cart-panel position-relative">
                    <a href="order_details" class="link-content">
                        <div class="cart-card">
                            <div class="card-left mb-2 d-flex">
                                <div>
                                    <div class="chat-odr me-3">
                                        <img src="{{$chatData['record']['product_variation']['variant_image'][0]}}" alt="Product"
                                            class="img-fluid">
                                    </div>
                                </div>

                                <div class="w-100">
                                    <div class="card-right d-flex w-100 justify-content-between">
                                        <div class="product-info">
                                            <h5 class="product-title">{{$chatData['record']['product_variation']['product_details']['product_name_en']}}</h5>
                                            <div class="psize d-flex gap-4 mt-2">
                                                <span>Size: {{$chatData['record']['product_variation']['size']['name']}}</span>
                                                <span class="d-flex align-items-center gap-2">
                                                    Color:
                                                    <div class="colorbox"
                                                        style="width:15px;height:15px;border-radius:3px;background:{{$chatData['record']['product_variation']['color']['hex_code']}};">
                                                    </div>
                                                </span>
                                                <!-- <span>Qnt: {{$chatData['record']['quantity']}}</span> -->
                                            </div>
                                            <h6 class="product-title mt-2"> {{$chatData['record']['price']}} KD</h6>
                                        </div>
                                        @if($chatData['record']['action'] == '0')
                                        <div class="yellow-bg" style="color:#EA9413;background:#EA94131A;">Waiting</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="gift-pnl mt-4">
                    <div class="border-1">
                        <table class="table table-borderless table-font">
                            <tr>
                                <td>
                                    <div class="width-120">Total Quantity</div>
                                </td>
                                <td>
                                    <div>{{$chatData['record']['quantity']}}</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="width-120">Address</div>
                                </td>
                                <td>
                                    <div>33XH+2M3, Al Ahmadi, Kuwait</div>
                                </td>
                            </tr>
                            @if(!empty($chatData['record']['custom_details']))
                            <tr>
                                <td>
                                    <div class="width-120">Custom details</div>
                                </td>
                                <td>
                                    <div>{{$chatData['record']['custom_details']}}</div>
                                </td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                @if($chatData['record']['action'] == '1' || $chatData['record']['action'] == '2')
                <div class="time-pnl">
                    <div class="gift-pnl mt-4">
                        <div class="border-12">
                            <div class="accordion" id="accordionPanelsStayOpenExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#viewRequest" aria-expanded="true" aria-controls="viewRequest">
                                            View Request
                                        </button>
                                    </h2>
                                    <div id="viewRequest" class="accordion-collapse collapse p-3 show">
                                        <table class="table table-borderless table-font">
                                            <tr>
                                                <td>
                                                    <div class="width-120">Item Price</div>
                                                </td>
                                                <td>
                                                    <div>{{$chatData['record']['price']}} KD</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="width-120">Shipping Fees</div>
                                                </td>
                                                <td>
                                                    <div>{{$chatData['record']['shipping']}} KD</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="width-120">Tax</div>
                                                </td>
                                                <td>
                                                    <div>{{$chatData['record']['tax']}} KD</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="width-120">Total Amount </div>
                                                </td>
                                                <td>
                                                    <div>{{$chatData['record']['total_amount']}} KD</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($chatData['record']['action'] == '1' || $chatData['record']['action'] == '2')
                    <div class="chat-pay d-flex gap-3 pt-4 mb-3">
                        <button type="reject" class="customBtn2">Reject</button>
                        <button type="submit" class="customBtn">Accept</button>
                    </div>
                    @endif
                    @if($chatData['record']['action'] == '5')
                    <button type="submit" class="customBtn">Pay Now</button>
                    @endif
                </div>
                @endif
            </div>

            <div class="col-lg-8">
                <div class="categoryDetail_content">
                    <div class="msger card">
                        <header class="msger-header d-flex gap-2 align-items-center">
                            <div class="chat-user-1 me-3">
                                <img src="{{$chatData['record']['seller_details']['profile_pic']}}" alt="Product" class="img-fluid">
                            </div>
                            <h5 class="msger-header-title">{{$chatData['record']['seller_details']['first_name']}} {{$chatData['record']['seller_details']['last_name']}}</h5>
                        </header>

                        <main class="msger-chat">
                            <div class="msg left-msg">
                                <div class="msg-bubble">
                                    <div class="msg-text">
                                        Hi, welcome to SimpleChat! Go ahead and send me a message.
                                    </div>
                                    <div class="msg-info">
                                        <div class="msg-info-time">12:45</div>
                                    </div>
                                </div>
                            </div>

                            <div class="msg right-msg">
                                <div class="msg-bubble">
                                    <div class="msg-text">
                                        You can change your name in JS section!
                                    </div>
                                    <div class="msg-info">
                                        <div class="msg-info-time text-end">12:46</div>
                                    </div>
                                </div>
                            </div>
                        </main>

                        <form class="msger-inputarea d-flex position-relative">
                            <div class="attached-icon">
                                <i class="bi bi-paperclip"></i>
                                <input type="file" id="imageUpload" accept="image/*">
                            </div>

                            <input type="text" class="form-control msger-input" placeholder="Type Message here...">
                            <button type="submit" class="msger-send-btn"><i class="bi bi-send-fill"></i></button>
                        </form>
                    </div>


                </div>
            </div>
        </div>
        @endif

        @if($chatData['record']->type == '1')
        <div class="row">
            <div class="col-lg-12">
                <div class="categoryDetail_content">
                    <div class="msger card">
                        <header class="msger-header d-flex gap-2 align-items-center">
                            <div class="chat-user-1 me-3">
                                <img src="{{$chatData['record']['seller_details']['profile_pic']}}" alt="Product" class="img-fluid">
                            </div>
                            <h5 class="msger-header-title">{{$chatData['record']['seller_details']['first_name']}} {{$chatData['record']['seller_details']['last_name']}} </h5>
                        </header>

                        <main class="msger-chat">
                            <div class="msg left-msg">
                                <div class="msg-bubble">
                                    <div class="msg-text">
                                        Hi, welcome to SimpleChat! Go ahead and send me a message.
                                    </div>
                                    <div class="msg-info">
                                        <div class="msg-info-time">12:45</div>
                                    </div>
                                </div>
                            </div>

                            <div class="msg right-msg">
                                <div class="msg-bubble">
                                    <div class="msg-text">
                                        You can change your name in JS section!
                                    </div>
                                    <div class="msg-info">
                                        <div class="msg-info-time text-end">12:46</div>
                                    </div>
                                </div>
                            </div>
                        </main>

                        <!-- <form class="msger-inputarea d-flex position-relative">
                            <div class="attached-icon">
                                <i class="bi bi-paperclip"></i>
                                <input type="file" id="imageUpload" accept="image/*">
                            </div>

                            <input type="text" class="form-control msger-input" placeholder="Type Message here...">
                            <button type="submit" class="msger-send-btn"><i class="bi bi-send-fill"></i></button>
                        </form> -->
                        <form id="chatFormNormal" class="msger-inputarea d-flex position-relative">
                            @csrf

                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            <input type="hidden" name="seller_id" value="{{ $chatData['record']->seller_id }}">

                            <div class="attached-icon">
                                <i class="bi bi-paperclip"></i>
                                <input type="file" name="image" id="imageUpload" accept="image/*">
                            </div>

                            <input type="text" name="message" class="form-control msger-input" placeholder="Type Message here..." required>
                            <button type="submit" class="msger-send-btn">
                                <i class="bi bi-send-fill"></i>
                            </button>
                        </form>

                    </div>


                </div>
            </div>
        </div>
        @endif


    </div>

</div>






<div id="loader" style="display:none;">
    <div class="loader"></div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const chatForm = document.getElementById('chatForm');
    const chatBox  = document.querySelector('.msger-chat');

    chatForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(chatForm);
        const message  = chatForm.querySelector('.msger-input').value.trim();

        if (!message) return;

        fetch("{{ route('user.snedNormalMessage') }}", {
            method: "POST",
            headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
            body: formData
        })
        .then(res => res.json())
        .then(res => {
            if (res.status === 'success') {
                appendMessage(message, 'right');
                chatForm.reset();
                scrollToBottom();
            } else {
                toastr.error(res.message || 'Failed to send message');
            }
        })
        .catch(() => {
            toastr.error('Something went wrong');
        });
    });

    function appendMessage(text, side = 'right') {
        const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        const msgHTML = `
            <div class="msg ${side}-msg">
                <div class="msg-bubble">
                    <div class="msg-text">${text}</div>
                    <div class="msg-info">
                        <div class="msg-info-time ${side === 'right' ? 'text-end' : ''}">${time}</div>
                    </div>
                </div>
            </div>
        `;

        chatBox.insertAdjacentHTML('beforeend', msgHTML);
    }

    function scrollToBottom() {
        chatBox.scrollTop = chatBox.scrollHeight;
    }

});
</script>



@endsection