<div id="reader" style="width:300px;"></div>

<script src="https://unpkg.com/html5-qrcode"></script>

<script>
function onScanSuccess(decodedText, decodedResult) {
    console.log("Scanned:", decodedText);

    // Send to Laravel
    fetch('/scanner-Seller-details', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                qr: decodedText
            })
        })
        .then(res => res.json())
        .then(data => {
            alert("User: " + data.name);
        });
}

let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader", {
        fps: 10,
        qrbox: 250
    }
);
html5QrcodeScanner.render(onScanSuccess);
</script>