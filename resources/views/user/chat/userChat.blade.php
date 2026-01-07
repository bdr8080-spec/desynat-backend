@extends('user.layout.app')

@section('content')


<div class="customContainer common-padding">
    <div class="common-title d-flex gap-3 mb-4">
        <a href="{{route('dashboard')}}"> <img src="{{asset('user/assets/images/left-ic.svg')}}" class="img-fluid"></a>
        <h3>Chat</h3>
    </div>

    <div class="main-content">
        <div class="row">
            <div class="col-lg-4">
                <div class="cart-panel position-relative">
                    <a href="order_details" class="link-content">
                        <div class="cart-card">
                            <div class="card-left mb-2 d-flex">
                                <div>
                                    <div class="chat-odr me-3">
                                        <img src="{{asset('user/assets/images/categorie1.png')}}" alt="Product"
                                            class="img-fluid">
                                    </div>
                                </div>

                                <div class="w-100">
                                    <div class="card-right d-flex w-100 justify-content-between">
                                        <div class="product-info">
                                            <h5 class="product-title">Mooei 3 Pcs set</h5>
                                            <div class="psize d-flex gap-4 mt-2">
                                                <span>Size: M</span>
                                                <span class="d-flex align-items-center gap-2">
                                                    Color:
                                                    <div class="colorbox"
                                                        style="width:15px;height:15px;border-radius:3px;background:#000;">
                                                    </div>
                                                </span>
                                                <span>Qnt: 1</span>
                                            </div>
                                            <h6 class="product-title mt-2"> 440 KD</h6>
                                        </div>
                                        <div class="yellow-bg" style="color:#EA9413;background:#EA94131A;">Waiting</div>
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
                                    <div>1</div>
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
                            <tr>
                                <td>
                                    <div class="width-120">Custom details</div>
                                </td>
                                <td>
                                    <div>1</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="width-120">Total Quantity</div>
                                </td>
                                <td>
                                    <div class="mb-0">Lorem ipsum dolor sit amet consectetur, adipisicing elit.</div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

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
                                    <div id="viewRequest" class="accordion-collapse collapse p-3">
                                        <table class="table table-borderless table-font">
                                            <tr>
                                                <td>
                                                    <div class="width-120">Item Price</div>
                                                </td>
                                                <td>
                                                    <div>4000 KD</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="width-120">Shipping Fees</div>
                                                </td>
                                                <td>
                                                    <div>80 KD</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="width-120">Tax</div>
                                                </td>
                                                <td>
                                                    <div>00.00 KD</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="width-120">Total Amount </div>
                                                </td>
                                                <td>
                                                    <div>4000.00 KD</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-pay d-flex gap-3 pt-4 mb-3">
                        <button type="reject" class="customBtn2">Reject</button>
                        <button type="submit" class="customBtn">Accept</button>
                    </div>
                    <button type="submit" class="customBtn">Pay Now</button>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="categoryDetail_content">
                    <div class="msger card">
                        <header class="msger-header d-flex gap-2 align-items-center">
                            <div class="chat-user-1 me-3">
                                <img src="{{asset('user/assets/images/categorie1.png')}}" alt="Product" class="img-fluid">
                            </div>
                            <h5 class="msger-header-title">Rahul </h5>
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

                        <form class="msger-inputarea d-flex">
                            <input type="text" class="form-control msger-input" placeholder="Type Message here...">
                            <button type="submit" class="msger-send-btn"><i class="bi bi-send-fill"></i></button>
                        </form>
                    </div>


                </div>
            </div>
        </div>


    </div>

</div>






<div id="loader" style="display:none;">
    <div class="loader"></div>
</div>



@endsection

