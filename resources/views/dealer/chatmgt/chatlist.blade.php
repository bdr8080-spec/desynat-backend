@include('dealer.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl d-flex justify-content-between align-center">
        <a class="title24 alink"> Chat </a>
    </div>


    <div class="main-content categoryDetail mt-4">
        <div class="row">
            <div class="col-lg-4">
                <div class="category_filter">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h3 class="mb-0">Filter</h3>
                        <a href="#" class="link-apply">Apply</a>
                    </div>

                    <form>
                        <div class="orderfilter">
                            <div class="check_radio mb-3">
                                <label class="radio-group">
                                    <input type="radio" value="1" name="allcheck" checked="">
                                    <span class="custom-radio"></span>
                                    <span class="radio-label">All</span>
                                </label>
                            </div>
                            <div class="check_radio mb-3">
                                <label class="radio-group">
                                    <input type="radio" value="2" name="allcheck">
                                    <span class="custom-radio"></span>
                                    <span class="radio-label">New </span>
                                </label>
                            </div>
                            <div class="check_radio mb-3">
                                <label class="radio-group">
                                    <input type="radio" value="3" name="allcheck">
                                    <span class="custom-radio"></span>
                                    <span class="radio-label">Quotation Sent</span>
                                </label>
                            </div>
                            <div class="check_radio">
                                <label class="radio-group">
                                    <input type="radio" value="4" name="allcheck">
                                    <span class="custom-radio"></span>
                                    <span class="radio-label">Quotation Accepted</span>
                                </label>
                            </div>
                        </div>

                        <!-- <button type="submit" class="customBtn customBtn5 mt-5"> Apply </button> -->
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="categoryDetail_content">
                    <form>
                        <div class="chatsearch d-flex mb-3">
                            <div class="form-group position-relative w-100">
                                <input type="text" class="form-control search-line" placeholder="Search" />
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                            <button type="submit" class="btn btn-success">Search </button>
                        </div>
                    </form>


                    @foreach($all_chats as $key=>$val)

                    <div class="cart-panel position-relative">
                        <a href="{{route('seller.single-chat-info', $val->unique_id)}}" class="link-content">
                            <div class="cart-card">
                                <div class="card-left mb-2 d-flex align-items-center">
                                    <div>
                                        <div class="chat-user-circle me-3">
                                            <img src="{{ $val->user_details->profile_image }}" alt="Product"
                                                class="img-fluid">
                                        </div>
                                    </div>
                                    <div class="w-100">
                                        <div
                                            class="card-right d-flex w-100 justify-content-between align-items-baseline">
                                            <div class="product-info">
                                                <h6 class="product-title linkgold"> {{ $val->user_details->full_name }}
                                                </h6>
                                                @if($val->message_type=='0')
                                                <div class="chat-user-light"> {{ $val->last_chat }}</div>
                                                @else
                                                <div class="chat-user-light"> <img src="{{ $val->last_chat }}"
                                                        width="50px"></div>

                                                @endif

                                                <div class="chat-user-light"> {{ $val->last_chat_time }}
                                                </div>
                                            </div>


                                            @if($val->type=='2' && $val->product_request=='1' && $val->action=='0')

                                            <div class="yellow-bg" style="color:#172B85;background:#172B851A;">Request
                                                Quotation
                                            </div>

                                            @elseif($val->type=='2' && $val->product_request=='1' && $val->action=='1'
                                            || $val->action=='2' )

                                            <div class="yellow-bg" style="color:#17854C;background:#17854C1A;">Quotation
                                                Send</div>

                                            @elseif($val->type=='2' && $val->product_request=='1' && $val->action=='3'
                                            || $val->action=='4')

                                            <div class="red-bg yellow-bg" style="color:#EA9413;background:##fb0b0b;">
                                                Request
                                                Cancelled
                                            </div>

                                            @elseif($val->type=='2' && $val->product_request=='1' && $val->action=='5'
                                            && $val->order_create_status=='null')

                                            <div class="yellow-bg" style="color:#17854C;background:#17854C1A;">
                                                Quotation Accepted
                                            </div>

                                            @elseif($val->type=='2' &&
                                            $val->product_request=='1' && $val->action=='5' &&
                                            $val->order_create_status!=='null')

                                            <div class="red-bg yellow-bg" style="color:#17854C;background:#17854C1A;">
                                                Place order
                                            </div>

                                            @else
                                            <div class="yellow-bg" style="color:#EA9413;background:#EA94131A;">Waiting
                                            </div>



                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    @endforeach






                </div>
            </div>
        </div>


    </div>






</section>



@include('dealer.layout.custom_code');
@include('dealer.layout.footer');