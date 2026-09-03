<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ __('user_messages.order_delivered_subject') }}</title>
</head>

<body>

    <p>{{ __('user_messages.order_delivered_greeting', ['name' => $userName]) }}</p>

    <p>
        {{ __('user_messages.order_delivered_body', ['order_id' => $orderId]) }}
    </p>

    <p>
        {{ __('user_messages.order_delivered_rate_prompt') }}
    </p>

    <p>
        <a href="{{ $ratingUrl }}">
            {{ __('user_messages.rate_product') }}
        </a>
    </p>

    <p>
        {{ __('user_messages.order_delivered_thanks') }}
    </p>

</body>
</html>
