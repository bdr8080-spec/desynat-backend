<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
      dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <title>Live Chat</title>

    <style>
        html, body {
            height: 100%;
            margin: 0;
            background: #ffffff;
            font-family: Arial, sans-serif;
        }
        .chat-page {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.7);
            z-index: 1;
        }
        #tidio-chat {
            position: fixed !important;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            width: 400px !important;
            height: 600px !important;
            z-index: 999999 !important;
            border-radius: 12px;
            overflow: hidden;
        }

        iframe#tidio-chat-iframe {
            width: 100% !important;
            height: 100% !important;
            border-radius: 12px !important;
        }
        .tidio-chat-iframe__container {
            display: none !important;
        }

    </style>
</head>

<body>

<div class="botchat">
<div class="chat-page"></div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//code.tidio.co/na5y0weklpcd9uxhccfezplsfg0fggvk.js" async></script>

<script>
document.addEventListener("tidioChat-ready", function () {

    if (!window.tidioChatApi) return;

    const fullName = "{{ $seller_details->first_name ?? 'Guest' }} {{ $seller_details->last_name ?? '' }}";
    const email = "{{ $seller_details->email ?? 'guest_' . uniqid() }}";

    window.tidioChatApi.setVisitorData({
        name: fullName,
        email: email,
        role: "seller",
        distinct_id: "seller_" + email
    });

    window.tidioChatApi.open();

    setInterval(() => {
        window.tidioChatApi.open();
        window.tidioChatApi.open(); 
    }, 500);

});
</script>

<script>
function hideTidioCloseButton() {
    const iframe = document.getElementById("tidio-chat-iframe");

    if (!iframe) return;

    try {
        const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

        const buttons = iframeDoc.querySelectorAll('button, [aria-label="Close"], [title="Close"]');

        buttons.forEach(btn => {
            btn.style.display = "none";
        });

    } catch (e) {
        // Cross-origin iframe (expected in Tidio)
        // Cannot access internal DOM
    }
}

// Run repeatedly
setInterval(hideTidioCloseButton, 1000);
</script>
</body>
</html>
