@extends('user.layout.app')

@section('content')


<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="{{route('user.allChats')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
        @if($chatData['record']['product_request'] == '0' && $chatData['record']['action'] == '0')
        <h3>Chat Request</h3>
        @else
        <h3>Chat</h3>
        @endif
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
                                            <h6 class="product-title mt-2"> {{$chatData['record']['product_variation']['final_price']}} KD</h6>
                                        </div>
                                        @if($chatData['record']['action'] == '0' && $chatData['record']['product_request'] == '1')
                                        <div class="yellow-bg" style="color:#EA9413;background:#EA94131A;">Waiting</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!----------- Add Request ---------------->
                @if($chatData['record']['action'] == '0' && $chatData['record']['product_request'] == '0')
                <div class="gift-pnl mt-4">
                    <div class="border-1 my-profile" id="customOrderFormContainer">
                        <div class="form-group mb-3">
                            <label>Add Quantity</label>
                            <input type="text" name="quantity" class="form-control" placeholder="Eg.200">
                            <small class="text-danger d-none" id="quantityError">Please enter quantity</small>
                        </div>

                        <input type="hidden" name="delivery_address" value="{{ $userAddress->id }}">
                        <input type="hidden" name="unique_id" value="{{ $chatData['record']['unique_id'] }}">

                        <div class="form-group mb-3">
                            <label>Custom Details</label>
                            <textarea rows="4" name="custom_details" class="form-control" placeholder="Write Here"></textarea>
                            <small class="text-danger d-none" id="detailsError">Please enter custom details</small>
                        </div>

                        <h6>Delivering Address</h6> 
                        <div class="border-1 d-flex justify-content-between category_filter">
                            <div class="address-title">{{ $userAddress->address }}</div>
                            <a href="{{ route('user.view_address', ['chat' => $chatData['record']['unique_id']]) }}"> Change <i class="bi bi-arrow-right"></i></a>
                        </div>

                        <div class="pt-4">
                            <button type="button" class="customBtn w-100" id="sendCustomOrderBtn">Send Request</button>
                        </div>
                    </div>
                </div>

                @endif


                <!-----------End Add Request ---------------->

               @if($chatData['record']['product_request'] == '1' && in_array($chatData['record']['action'], ['0','1','2']))
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
                @endif

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

                        <main class="msger-chat1">
                            <div class="msg left-msg">
                                <div class="msg-bubble">
                                    <!-- <div class="msg-text">
                                        Hi, welcome to SimpleChat! Go ahead and send me a message.
                                    </div>
                                    <div class="msg-info">
                                        <div class="msg-info-time">12:45</div>
                                    </div> -->
                                </div>
                            </div>

                            <div class="msg right-msg">
                                <!-- <div class="msg-bubble">
                                    <div class="msg-text">
                                        You can change your name in JS section!
                                    </div>
                                    <div class="msg-info">
                                        <div class="msg-info-time text-end">12:46</div>
                                    </div>
                                </div> -->
                            </div>
                        </main>

                        <form id="chatFormCustom" class="msger-inputarea d-flex position-relative">
                            @csrf

                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            <input type="hidden" name="seller_id" value="{{ $chatData['record']->seller_id }}">
                            <input type="hidden" name="unique_id" value="{{ $chatData['record']->unique_id }}">

                            <div class="attached-icon">
                                <i class="bi bi-paperclip"></i>
                                <input type="file" name="image" id="imageUpload1" accept="image/*">
                            </div>

                            <input type="text" name="message" class="form-control msger-input1" placeholder="Type Message here...">
                            <small class="text-danger d-none" id="chatError1">
                                Please enter a message or upload an image
                            </small>
                            <button type="submit" class="msger-send-btn">
                                <i class="bi bi-send-fill"></i>
                            </button>
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
                                    <!-- <div class="msg-text">
                                        Hi, welcome to SimpleChat! Go ahead and send me a message.
                                    </div> -->
                                    <!-- <div class="msg-info">
                                        <div class="msg-info-time">12:45</div>
                                    </div> -->
                                </div>
                            </div>

                            <div class="msg right-msg">
                                <div class="msg-bubble">
                                    <!-- <div class="msg-text">
                                        You can change your name in JS section!
                                    </div> -->
                                    <!-- <div class="msg-info">
                                        <div class="msg-info-time text-end">12:46</div>
                                    </div> -->
                                </div>
                            </div>
                        </main>

                        <form id="chatFormNormal" class="msger-inputarea d-flex position-relative">
                            @csrf

                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            <input type="hidden" name="seller_id" value="{{ $chatData['record']->seller_id }}">
                            <input type="hidden" name="unique_id" value="{{ $chatData['record']->unique_id }}">

                            <div class="attached-icon">
                                <i class="bi bi-paperclip"></i>
                                <input type="file" name="image" id="imageUpload" accept="image/*">
                            </div>

                            <input type="text" name="message" class="form-control msger-input" placeholder="Type Message here...">
                            <small class="text-danger d-none" id="chatError">
                                Please enter a message or upload an image
                            </small>
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

<!-- send normal chat -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const chatForm  = document.getElementById('chatFormNormal');
    const chatBox   = document.querySelector('.msger-chat');
    const messageEl = chatForm.querySelector('.msger-input');
    const imageEl   = chatForm.querySelector('#imageUpload');
    const errorEl   = document.getElementById('chatError');

    // Remove error on typing or image select
    messageEl.addEventListener('input', hideError);
    imageEl.addEventListener('change', hideError);

    chatForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const message = messageEl.value.trim();
        const image   = imageEl.files[0] ?? null;

        //  Validation
        if (!message && !image) {
            showError();
            return;
        }

        const formData = new FormData(chatForm);

        // type: 0 = text, 1 = image
        const type = image ? 1 : 0;
        formData.append('type', type);

        fetch("{{ route('user.sendNormalMessage') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: formData
        })
        .then(res => res.json())
        .then(res => {
            if (res.status === 'success') {

                if (type === 0) {
                    appendTextMessage(res.message);
                } else {
                    appendImageMessage(res.message);
                }

                chatForm.reset();
                hideError();
                scrollToBottom();
            } else {
                toastr.error(res.message || 'Failed to send message');
            }
        })
        .catch(() => toastr.error('Something went wrong'));
    });

    function showError() {
        errorEl.classList.remove('d-none');
    }

    function hideError() {
        errorEl.classList.add('d-none');
    }

    function appendTextMessage(text) {
        appendMessage(`<div class="msg-text">${text}</div>`);
    }

    function appendImageMessage(imageUrl) {
        appendMessage(`<img src="${imageUrl}" class="img-fluid rounded" style="max-width:200px">`);
    }

    function appendMessage(content) {
        const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        chatBox.insertAdjacentHTML('beforeend', `
            <div class="msg right-msg">
                <div class="msg-bubble">
                    ${content}
                    <div class="msg-info">
                        <div class="msg-info-time text-end">${time}</div>
                    </div>
                </div>
            </div>
        `);
    }

    function scrollToBottom() {
        chatBox.scrollTop = chatBox.scrollHeight;
    }

});
</script>

<!-- send custom chat -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const chatForm  = document.getElementById('chatFormCustom');
    const chatBox   = document.querySelector('.msger-chat1');
    const messageEl = chatForm.querySelector('.msger-input1');
    const imageEl   = chatForm.querySelector('#imageUpload1');
    const errorEl   = document.getElementById('chatError1');

    // Remove error on typing or image select
    messageEl.addEventListener('input', hideError);
    imageEl.addEventListener('change', hideError);

    chatForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const message = messageEl.value.trim();
        const image   = imageEl.files[0] ?? null;

        //  Validation
        if (!message && !image) {
            showError();
            return;
        }

        const formData = new FormData(chatForm);

        // type: 0 = text, 1 = image
        const type = image ? 1 : 0;
        formData.append('type', type);

        fetch("{{ route('user.sendNormalMessage') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: formData
        })
        .then(res => res.json())
        .then(res => {
            if (res.status === 'success') {

                if (type === 0) {
                    appendTextMessage(res.message);
                } else {
                    appendImageMessage(res.message);
                }

                chatForm.reset();
                hideError();
                scrollToBottom();
            } else {
                toastr.error(res.message || 'Failed to send message');
            }
        })
        .catch(() => toastr.error('Something went wrong'));
    });

    function showError() {
        errorEl.classList.remove('d-none');
    }

    function hideError() {
        errorEl.classList.add('d-none');
    }

    function appendTextMessage(text) {
        appendMessage(`<div class="msg-text">${text}</div>`);
    }

    function appendImageMessage(imageUrl) {
        appendMessage(`<img src="${imageUrl}" class="img-fluid rounded" style="max-width:200px">`);
    }

    function appendMessage(content) {
        const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        chatBox.insertAdjacentHTML('beforeend', `
            <div class="msg right-msg">
                <div class="msg-bubble">
                    ${content}
                    <div class="msg-info">
                        <div class="msg-info-time text-end">${time}</div>
                    </div>
                </div>
            </div>
        `);
    }

    function scrollToBottom() {
        chatBox.scrollTop = chatBox.scrollHeight;
    }

});
</script>

<!-- send custom order request -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const formContainer = document.getElementById('customOrderFormContainer');
    const btnSend = document.getElementById('sendCustomOrderBtn');
    const quantityEl = formContainer.querySelector('input[name="quantity"]');
    const detailsEl = formContainer.querySelector('textarea[name="custom_details"]');
    const deliveryAddressEl = formContainer.querySelector('input[name="delivery_address"]');
    const uniqueIdEl = formContainer.querySelector('input[name="unique_id"]');

    const quantityError = document.getElementById('quantityError');
    const detailsError = document.getElementById('detailsError');

    // Remove error on typing
    quantityEl.addEventListener('input', () => quantityError.classList.add('d-none'));
    detailsEl.addEventListener('input', () => detailsError.classList.add('d-none'));

    btnSend.addEventListener('click', function () {
        const quantity = quantityEl.value.trim();
        const customDetails = detailsEl.value.trim();
        const deliveryAddress = deliveryAddressEl.value;
        const uniqueId = uniqueIdEl.value;

        let hasError = false;

        if (!quantity) {
            quantityError.classList.remove('d-none');
            hasError = true;
        }

        if (!customDetails) {
            detailsError.classList.remove('d-none');
            hasError = true;
        }

        if (hasError) return;

        const formData = new FormData();
        formData.append('quantity', quantity);
        formData.append('custom_details', customDetails);
        formData.append('delivery_address', deliveryAddress);
        formData.append('unique_id', uniqueId);

        fetch("{{ route('user.sendCustomOrderRequest') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: formData
        })
        .then(res => res.json())
        .then(res => {
            if (res.status === 'success') {
                toastr.success(res.message || 'Request sent successfully!');
                setTimeout(() => {
                    location.reload();
                }, 1500);

            } else {
                toastr.error(res.message || 'Failed to send request');
            }
        })
        .catch(() => toastr.error('Something went wrong'));
    });

});

</script>






@endsection