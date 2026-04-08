@extends('admin.layout.app')
@section('content')

<style>
.custom-topbar {
    background: linear-gradient(90deg, #c08f53, #a36a2a) !important;
    height: 74px;
    border-radius: 6px;
    padding: 0 25px;
    display: flex;
    align-items: center;
}

.header-logo {
    width: 110px;
    height: 66px;
    border-radius: 50%;
    object-fit: contain;
}

.brand-name {
    font-size: 22px;
    font-weight: 600;
    font-family: "Georgia", serif;
    margin-left: 12px;
    color: #000;
}

.header-divider {
    flex: 1;
    /* border-bottom: 1.5px dotted rgba(0, 0, 0, 0.5); */
    margin: 0 25px;
}

.lang-btn {
    background: transparent;
    border: 1px solid rgba(0, 0, 0, 0.7);
    padding: 6px 14px;
    border-radius: 50px;
    font-size: 14px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
}

.multi-box {
    background: #fff;
    border: 1px solid #eee;
}

.user-list li {
    list-style: none;
    margin-bottom: 10px;
}

.custom-radio {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 12px;
    /* border: 1px solid #eee; */
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s;
}



.user-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

.user-info i {
    font-size: 18px;
    color: #0d6efd;
}

.chat-header {
    /* border-bottom: 1px solid #eee; */
    padding-bottom: 10px;
}

/* Profile Image */
.profile-img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

/* Name */
.user-name {
    font-weight: 600;
    font-size: 14px;
}

/* Status */
.user-status {
    font-size: 12px;
}

.chat-box {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

/* Message common */
.message {
    max-width: 70%;
    padding: 8px 12px;
    border-radius: 10px;
    position: relative;
    font-size: 14px;
}

/* Sent (right side) */
.sent {
    align-self: flex-end;
    background: #d1e7ff;
}

/* Received (left side) */
.received {
    align-self: flex-start;
    background: #fff;
}

/* Time */
.time {
    font-size: 10px;
    color: gray;
    text-align: right;
    margin-top: 2px;
}
</style>

<div class="inner-content management">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-6 col-md-6 col-12">
            <h2 class="h2">Support </h2>
        </div>

    </div>

    <div class="row ">
        <div class="col-lg-6 rounded-4 border p-4 pe-lg-3 mb-3">
            <div class="d-flex justify-content-center">
                <ul class="nav nav-pills tabs-pnl custom" id="pills-tab" role="tablist">
                    <li class="nav-item m-1" role="presentation">
                        <button class="nav-link customBtn2 m-0" id="pills-order-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order"
                            aria-selected="false">
                            User
                        </button>
                    </li>
                    <li class="nav-item m-1" role="presentation">
                        <button class="nav-link active customBtn2 m-0" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true">
                            Seller
                        </button>
                    </li>
                    <li class="nav-item m-1" role="presentation">
                        <button class="nav-link customBtn2 m-0" id="pills-return-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-return" type="button" role="tab" aria-controls="pills-return"
                            aria-selected="false">
                            Delivery Boy
                        </button>
                    </li>
                    <li class="nav-item m-1" role="presentation">
                        <button class="nav-link customBtn2 m-0" id="pills-Affiliate-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-Affiliate" type="button" role="tab" aria-controls="pills-Affiliate"
                            aria-selected="false">
                            Affiliate Marketer
                        </button>
                    </li>
                </ul>
            </div>
            <div class="userManagecontent">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab"
                        tabindex="0">
                        <div class="col-md-12 mt-2">
                            <div class="multi-box form-group p-3 shadow-sm rounded">

                                <!-- Search -->
                                <input type="text" class="search form-control mb-3" placeholder="Search user..." />

                                <!-- User List -->
                                <ul class="user-list p-0 m-0">

                                    <li>
                                        <label class="custom-radio">
                                            <div class="user-info">
                                                <img src="image/dummy-image.jpg" alt="Profile Image" width="40px"
                                                    height="40px" class="rounded-circle" />
                                                <span>User Name 1</span>
                                            </div>

                                        </label>
                                    </li>

                                    <li>
                                        <label class="custom-radio">
                                            <div class="user-info">
                                                <img src="image/dummy-image.jpg" alt="Profile Image" width="40px"
                                                    height="40px" class="rounded-circle" />
                                                <span>User Name 2</span>

                                            </div>

                                        </label>
                                    </li>

                                    <li>
                                        <label class="custom-radio">
                                            <div class="user-info">
                                                <img src="image/dummy-image.jpg" alt="Profile Image" width="40px"
                                                    height="40px" class="rounded-circle" />
                                                <span>User Name 3</span>
                                            </div>

                                        </label>
                                    </li>

                                </ul>

                            </div>
                        </div>
                    </div>
                    <!-- approved -->
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                        aria-labelledby="pills-home-tab" tabindex="0">
                        <div class="col-md-12 mt-2">
                            <div class="multi-box form-group p-3 shadow-sm rounded">

                                <!-- Search -->
                                <input type="text" class="search form-control mb-3" placeholder="Search user..." />

                                <!-- User List -->
                                <ul class="user-list p-0 m-0">

                                    <li>
                                        <label class="custom-radio">
                                            <div class="user-info">
                                                <img src="image/dummy-image.jpg" alt="Profile Image" width="40px"
                                                    height="40px" class="rounded-circle" />
                                                <span>User Name 1</span>
                                            </div>

                                        </label>
                                    </li>

                                    <li>
                                        <label class="custom-radio">
                                            <div class="user-info">
                                                <img src="image/dummy-image.jpg" alt="Profile Image" width="40px"
                                                    height="40px" class="rounded-circle" />
                                                <span>User Name 2</span>

                                            </div>

                                        </label>
                                    </li>

                                    <li>
                                        <label class="custom-radio">
                                            <div class="user-info">
                                                <img src="image/dummy-image.jpg" alt="Profile Image" width="40px"
                                                    height="40px" class="rounded-circle" />
                                                <span>User Name 3</span>
                                            </div>

                                        </label>
                                    </li>

                                </ul>

                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-return" role="tabpanel" aria-labelledby="pills-return-tab"
                        tabindex="0">
                        <div class="col-md-12 mt-2">
                            <div class="multi-box form-group p-3 shadow-sm rounded">

                                <!-- Search -->
                                <input type="text" class="search form-control mb-3" placeholder="Search user..." />

                                <!-- User List -->
                                <ul class="user-list p-0 m-0">

                                    <li>
                                        <label class="custom-radio">
                                            <div class="user-info">
                                                <img src="image/dummy-image.jpg" alt="Profile Image" width="40px"
                                                    height="40px" class="rounded-circle" />
                                                <span>User Name 1</span>
                                            </div>

                                        </label>
                                    </li>

                                    <li>
                                        <label class="custom-radio">
                                            <div class="user-info">
                                                <img src="image/dummy-image.jpg" alt="Profile Image" width="40px"
                                                    height="40px" class="rounded-circle" />
                                                <span>User Name 2</span>

                                            </div>

                                        </label>
                                    </li>

                                    <li>
                                        <label class="custom-radio">
                                            <div class="user-info">
                                                <img src="image/dummy-image.jpg" alt="Profile Image" width="40px"
                                                    height="40px" class="rounded-circle" />
                                                <span>User Name 3</span>
                                            </div>

                                        </label>
                                    </li>

                                </ul>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-Affiliate" role="tabpanel"
                        aria-labelledby="pills-Affiliate-tab" tabindex="0">
                        <div class="col-md-12 mt-2">
                            <div class="multi-box form-group p-3 shadow-sm rounded">

                                <!-- Search -->
                                <input type="text" class="search form-control mb-3" placeholder="Search user..." />

                                <!-- User List -->
                                <ul class="user-list p-0 m-0">

                                    <li>
                                        <label class="custom-radio">
                                            <div class="user-info">
                                                <img src="image/dummy-image.jpg" alt="Profile Image" width="40px"
                                                    height="40px" class="rounded-circle" />
                                                <span>User Name 1</span>
                                            </div>

                                        </label>
                                    </li>

                                    <li>
                                        <label class="custom-radio">
                                            <div class="user-info">
                                                <img src="image/dummy-image.jpg" alt="Profile Image" width="40px"
                                                    height="40px" class="rounded-circle" />
                                                <span>User Name 2</span>

                                            </div>

                                        </label>
                                    </li>

                                    <li>
                                        <label class="custom-radio">
                                            <div class="user-info">
                                                <img src="image/dummy-image.jpg" alt="Profile Image" width="40px"
                                                    height="40px" class="rounded-circle" />
                                                <span>User Name 3</span>
                                            </div>

                                        </label>
                                    </li>

                                </ul>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-6 rounded-4 border p-4 position-relative  ps-lg-3 mb-3">

            <div class="d-flex justify-content-start gap-3 mb-3" style="border-bottom: 1px solid #eee;">
                <div class="chat-header d-flex justify-content-between align-items-center mb-3">

                    <!-- Left (Profile + Name) -->
                    <div class="d-flex align-items-center justify-content-between gap-2">
                        <img src="image/dummy-image.jpg" alt="Profile Image" width="40px" height="40px"
                            class="rounded-circle" />

                        <div>
                            <div class="user-name">User Name 1</div>
                            <small class="user-status text-success">Online</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat Area -->
            <div id="chatBox" class="chat-box p-3 rounded"
                style="background: #f8f9fa; height: 400px; overflow-y: auto;">
                <!-- Example incoming -->
                <div class="message received">
                    <div class="msg-text">Hello</div>
                    <div class="time">10:00 AM</div>
                </div>
                <!-- Example outgoing -->
                <div class="message sent">
                    <div class="msg-text">Hi!</div>
                    <div class="time">10:01 AM</div>
                </div>
            </div>

            <!-- Input -->
            <div class="input-group mt-3">
                <input id="messageInput" type="text" class="form-control" placeholder="Type your message..." />
                <button class="btn btn-primary" type="button" onclick="sendMessage()">Send</button>
            </div>

        </div>
    </div>



</div>

@endsection

<script>
function getTime() {
    let now = new Date();
    let hours = now.getHours();
    let minutes = now.getMinutes();

    let ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12 || 12;
    minutes = minutes < 10 ? '0' + minutes : minutes;

    return `${hours}:${minutes} ${ampm}`;
}

function sendMessage() {
    let input = document.getElementById("messageInput");
    let message = input.value.trim();

    if (message === "") return;

    let chatBox = document.getElementById("chatBox");

    // Create message
    let msgDiv = document.createElement("div");
    msgDiv.classList.add("message", "sent");

    msgDiv.innerHTML = `
        <div class="msg-text">${message}</div>
        <div class="time">${getTime()}</div>
    `;

    chatBox.appendChild(msgDiv);

    // Auto scroll
    chatBox.scrollTop = chatBox.scrollHeight;

    input.value = "";

    // Fake reply after 1 sec
    setTimeout(() => {
        receiveMessage("Okay 👍");
    }, 1000);
}

function receiveMessage(text) {
    let chatBox = document.getElementById("chatBox");

    let msgDiv = document.createElement("div");
    msgDiv.classList.add("message", "received");

    msgDiv.innerHTML = `
        <div class="msg-text">${text}</div>
        <div class="time">${getTime()}</div>
    `;

    chatBox.appendChild(msgDiv);

    chatBox.scrollTop = chatBox.scrollHeight;
}

// Enter key support
document.getElementById("messageInput").addEventListener("keypress", function(e) {
    if (e.key === "Enter") {
        sendMessage();
    }
});
</script>