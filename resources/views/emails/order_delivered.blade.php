<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Delivered</title>
</head>

<body>

    <p>Hello {{ $userName }},</p>

    <p>
        Your order with order Id : {{ $orderId }} is delivered successfully.
    </p>

    <p>
        You can rate the product using the link below:
    </p>

    <p>
        <a href="{{ $ratingUrl }}">
            Rate Product
        </a>
    </p>

    <p>
        Thank you for shopping with us.
    </p>

</body>
</html>