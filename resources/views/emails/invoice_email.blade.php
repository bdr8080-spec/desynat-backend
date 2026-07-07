<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>

<h2>Thank you for your order.</h2>

<p>Your order has been placed successfully.</p>

<p>
    You can download your invoice by clicking the link below:
</p>

<p>
    <a href="{{ $invoiceUrl }}">
        Download Invoice
    </a>
</p>

<p>
    If the button doesn't work, copy the following URL into your browser:
</p>

<p>
    {{ $invoiceUrl }}
</p>

</body>
</html>