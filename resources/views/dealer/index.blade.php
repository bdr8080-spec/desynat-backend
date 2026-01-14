@include('dealer.layout.header')

<section class="section dashboard">
    <div class="page-wapper dashboard-pnl">
        <div class="title24">Dashboard
        </div>
    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="row">
        <div class="col-lg-6 col-xxl-6">
            <div class="bg-header d-flex justify-content-between mt-3 align-items-center">
                <div class="title24">Store availability</div>
                <div class="d-flex gap-3">
                    <div class="buy">Busy/On</div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault"
                            onclick="store_availbilityfunction(this)" @if (@$seller_details->store_info->Store_Availability == 1) checked @endif>
                        <label class="form-check-label" for="switchCheckDefault"></label>
                    </div>
                </div>
            </div>

            <div class="py-4">
                <div class="title24">Total Products <span class="gold-title">(127)</span></div>
                <div class="row mt-3">
                    <div class="col-lg-6 col-md-6">
                        <div class="dash-box border20 shadow20 p20 pnl-flex">
                            <div class="dash-content">
                                <h5>Active</h5>
                                <div class="title30">120</div>
                            </div>
                            <div class="dash-circle">
                                <img src="{{ asset('dealer') }}/assets/img/box.svg" alt="icon" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="dash-box border20 shadow20 p20 pnl-flex">
                            <div class="dash-content">
                                <h5>In-Active</h5>
                                <div class="title30">50</div>
                            </div>
                            <div class="dash-circle">
                                <img src="{{ asset('dealer') }}/assets/img/box.svg" alt="icon" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-2">
                <div class="title24">Total Orders <span class="gold-title">(14)</span></div>
                <div class="row mt-3">
                    <div class="col-lg-6 col-md-6">
                        <div class="dash-box border20 shadow20 p20 pnl-flex mb-4">
                            <div class="dash-content">
                                <h5>New</h5>
                                <div class="title30">120</div>
                            </div>
                            <div class="dash-circle">
                                <img src="{{ asset('dealer') }}/assets/img/box.svg" alt="icon" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="dash-box border20 shadow20 p20 pnl-flex mb-3">
                            <div class="dash-content">
                                <h5>Ongoing</h5>
                                <div class="title30">50</div>
                            </div>
                            <div class="dash-circle">
                                <img src="{{ asset('dealer') }}/assets/img/box.svg" alt="icon" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="dash-box border20 shadow20 p20 pnl-flex">
                            <div class="dash-content">
                                <h5>Completed</h5>
                                <div class="title30">50</div>
                            </div>
                            <div class="dash-circle">
                                <img src="{{ asset('dealer') }}/assets/img/box.svg" alt="icon" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="dash-box border20 shadow20 p20 pnl-flex">
                            <div class="dash-content">
                                <h5>Cancelled</h5>
                                <div class="title30">51</div>
                            </div>
                            <div class="dash-circle">
                                <img src="{{ asset('dealer') }}/assets/img/box.svg" alt="icon" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="py-4">
                <div class="title24">Total Staffs <span class="gold-title">(07)</span></div>
                <div class="row mt-3">
                    <div class="col-lg-6 col-md-6">
                        <div class="dash-box border20 shadow20 p20 pnl-flex py-3">
                            <div class="dash-content">
                                <h5>Active</h5>
                                <div class="title30">120</div>
                            </div>
                            <div class="dash-circle">
                                <img src="{{ asset('dealer') }}/assets/img/female.svg" alt="icon" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="dash-box border20 shadow20 p20 pnl-flex py-3">
                            <div class="dash-content">
                                <h5>In-Active</h5>
                                <div class="title30">50</div>
                            </div>
                            <div class="dash-circle">
                                <img src="{{ asset('dealer') }}/assets/img/female.svg" alt="icon" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-6 col-xxl-6">
            <div class="bg-header mt-3 visitor-pnl">
                <div class="group-radio-btn d-flex gap-4 align-items-center flex-wrap">
                    <div class="check_radio">
                        <label class="radio-group">
                            <input type="radio" name="today" checked>
                            <span class="custom-radio"></span>
                            <span class="radio-label">Today</span>
                        </label>
                    </div>
                    <div class="check_radio">
                        <label class="radio-group">
                            <input type="radio" name="today">
                            <span class="custom-radio"></span>
                            <span class="radio-label">This Week</span>
                        </label>
                    </div>
                    <div class="check_radio">
                        <label class="radio-group">
                            <input type="radio" name="today" >
                            <span class="custom-radio"></span>
                            <span class="radio-label">This Month</span>
                        </label>
                    </div>
                    <div class="show-date d-flex gap-2  flex-wrap">
                        <div class="date-form-pnl">
                            <input type="date" class="form-control">
                        </div>
                        <div class="date-form-pnl">
                            <input type="date" class="form-control">
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="total-revenu border20 shadow20 p20 mt-5">
                <div class="total-revenu-box pnl-flex">
                    <div class="dash-content">
                        <h5>Total Revenue Generated</h5>
                        <h1 class="font-34 py-3">KD 12,542</h1>
                    </div>
                    <div class="total-revenu-image">
                        <img src="{{ asset('dealer') }}/assets/img/profit.svg" alt="icon" class="img-fluid">
                    </div>
                </div>
            </div>

            <div class="padding-top-40 visitor-pnl">
                <div class="title24">Visitor analytics</div>
                <div class="bg-header-white mt-3">
                    <div class="group-radio-btn d-flex gap-4 align-items-center flex-wrap">
                        <div class="check_radio">
                            <label class="radio-group">
                                <input type="radio" name="radio" checked>
                                <span class="custom-radio"></span>
                                <span class="radio-label">Total Order Conversion</span>
                            </label>
                        </div>
                        <div class="check_radio">
                            <label class="radio-group">
                                <input type="radio" name="radio">
                                <span class="custom-radio"></span>
                                <span class="radio-label">Total Customer visits</span>
                            </label>
                        </div>
                        <div class="show-date d-flex gap-2">
                            <div class="date-form-pnl">
                                <input type="date" class="form-control">
                            </div>
                            <div class="date-form-pnl">
                                <input type="date" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="show-chart padding-top-40">
                <div class="dash-box border20 shadow20 p20">
                    <canvas id="pointChart"></canvas>
                </div>
            </div>


        </div>

    </div>


</section>

<!-- support chat -->
<div class="support-chat-btn"onclick="openChat()">
    <button>
        <div class="icon">
            <img src="/dealer/assets/img/Frame.svg" width="50px" />
            <div class="notification-badge">


            </div>
        </div>
    </button>
</div>

<!-- Support Chat Button -->
<!-- <div class="support-chat-btn" onclick="openChat()">
  <img src="/dealer/assets/img/Frame.svg" width="50">
</div> -->


<!-- Chat Box -->
<!-- <div class="support-chat" id="supportChat">
  <div class="chat-header">
    <h4>Support Chat</h4>
    <span onclick="closeChat()">✕</span>
  </div>

  <div class="chat-body" id="chatBody">
    <div class="msg left">
      Hi 👋 How can we help you?
      <span class="time">08:30 am</span>
    </div>
</div>

  <div class="chat-footer">
    <input type="text" id="messageInput" placeholder="Type message..." />
    <button onclick="sendMessage()"><i class="bi bi-send"></i></button>
  </div>
</div> -->
  
<!-- Edit shipping Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="delete-body text-center p-3">
                    <div class="trash-box">
                        <i class="bi bi-trash3"></i>
                    </div>
                    <h4 class="domestic-title"> Are you sure you want to delete this domestic cost?</h4>
                </div>
                <div class="login-btn mt-4 d-flex justify-content-between gap-3">
                    <button type="button" class="btn btn-success w-100" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger-outline w-100">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

@include('dealer.layout.footer');

<script>
    const ctx = document.getElementById('pointChart').getContext('2d');

    const pointChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
            datasets: [{
                label: 'Monthly Sales',
                data: [12, 19, 8, 25, 18, 30, 50, 30],
                borderColor: '#55000099',
                borderWidth: 2,
                tension: 0.3,
                fill: false,
                pointStyle: 'circle', // point shape
                pointRadius: 6,
                pointHoverRadius: 8,
                backgroundColor: '#F3D1A2'
            }]
        },
        options: {
            responsive: true,

        }
    });


    function store_availbilityfunction(checkbox) {

        $.ajax({
            url: "{{ url('seller/web_store_on_off') }}",
            type: "get",
            data: {
                "_token": "{{ csrf_token() }}",
            },
            dataType: "json",
            beforeSend: function() {
                $('#loader').show()
            },
            success: function(data) {
                console.log(data.data)

                if (data.data.Store_Availability == 1) {
                    toastr.success(data.message);
                }

                if (data.data.Store_Availability == 0) {
                    toastr.error(data.message);
                }


            },
            error: function() {
                alert("Fail")
            },
              complete: function() {
            // Hide loader (after success or error)
            $('#loader').hide();
        }

        })


    }
</script>



<script>
function openChat() {
  document.getElementById("supportChat").classList.add("active");
}

function closeChat() {
  document.getElementById("supportChat").classList.remove("active");
}

function sendMessage() {
  const input = document.getElementById("messageInput");
  const message = input.value.trim();
  if (!message) return;

  addMessage(message, "right");
  input.value = "";

  // Fake support reply (API ki jagah)
  setTimeout(() => {
    addMessage("Thanks for your message. Our team will contact you shortly 😊", "left");
  }, 1200);
}

function addMessage(text, side) {
  const chatBody = document.getElementById("chatBody");
  const msgDiv = document.createElement("div");
  msgDiv.className = `msg ${side}`;

  const time = new Date().toLocaleTimeString([], {
    hour: '2-digit',
    minute: '2-digit'
  });

  msgDiv.innerHTML = `${text}<span>${time}</span>`;
  chatBody.appendChild(msgDiv);

  chatBody.scrollTop = chatBody.scrollHeight;
}

/* Enter key support */
document.getElementById("messageInput").addEventListener("keypress", function(e) {
  if (e.key === "Enter") sendMessage();
});
</script>