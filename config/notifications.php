<?php

return [

/*
|--------------------------------------------------------------------------
| CUSTOMER APP
|--------------------------------------------------------------------------
*/

'ORDER_CREATED' => [
    'title' => 'Order Created',
    'body'  => 'Hi {name}, your order #{order_id} has been placed successfully',
    'roles' => ['customer']
],

'ORDER_CONFIRMED' => [
    'title' => 'Order Confirmed',
    'body'  => 'Your order #{order_id} has been confirmed by seller',
    'roles' => ['customer']
],

'ORDER_PROCESSED' => [
    'title' => 'Order Processing',
    'body'  => 'Your order #{order_id} is being processed',
    'roles' => ['customer']
],

'ORDER_DRIVER_ASSIGNED' => [
    'title' => 'Driver Assigned',
    'body'  => 'Driver has picked your order #{order_id}',
    'roles' => ['customer']
],

'DRIVER_EN_ROUTE' => [
    'title' => 'Driver On The Way',
    'body'  => 'Driver is on the way with your order',
    'roles' => ['customer']
],

'DRIVER_ARRIVED' => [
    'title' => 'Driver Arrived',
    'body'  => 'Driver has arrived at your location',
    'roles' => ['customer']
],

'ORDER_DELIVERED' => [
    'title' => 'Order Delivered',
    'body'  => 'Your order #{order_id} has been delivered',
    'roles' => ['customer']
],

'ORDER_CANCELLED' => [
    'title' => 'Order Cancelled',
    'body'  => 'Your order #{order_id} has been cancelled',
    'roles' => ['customer']
],

'REFUND_REQUESTED' => [
    'title' => 'Refund Requested',
    'body'  => 'Refund requested for order #{order_id}',
    'roles' => ['customer','admin']
],

'PAYMENT_SUCCESS' => [
    'title' => 'Payment Successful',
    'body'  => 'Payment of ₹{amount} successful',
    'roles' => ['customer']
],

'PAYMENT_FAILED' => [
    'title' => 'Payment Failed',
    'body'  => 'Payment failed. Please try again',
    'roles' => ['customer']
],

'WALLET_ADDED' => [
    'title' => 'Wallet Updated',
    'body'  => '₹{amount} added to your wallet',
    'roles' => ['customer']
],

'NEW_MESSAGE_SELLER' => [
    'title' => 'New Message',
    'body'  => 'You received a new message from seller',
    'roles' => ['customer']
],

'CUSTOM_DESIGN_ACCEPTED' => [
    'title' => 'Design Accepted',
    'body'  => 'Your custom design has been accepted',
    'roles' => ['customer']
],

'DELIVERY_DELAYED' => [
    'title' => 'Delivery Delayed',
    'body'  => 'Delivery of your order is delayed',
    'roles' => ['customer']
],

'LIVE_STREAM_STARTED' => [
    'title' => 'Live Stream',
    'body'  => 'A store you follow is live now',
    'roles' => ['customer']
],

'NEW_OFFER' => [
    'title' => 'New Offer',
    'body'  => 'New offer available from your favorite store',
    'roles' => ['customer']
],

'PROMO_ACCEPTED' => [
    'title' => 'Promo Applied',
    'body'  => 'Promo code applied successfully',
    'roles' => ['customer']
],

'GIFT_SENT' => [
    'title' => 'Gift Sent',
    'body'  => 'Your gift has been sent successfully',
    'roles' => ['customer']
],

'REVIEW_REQUEST' => [
    'title' => 'Review Request',
    'body'  => 'Please rate your recent order',
    'roles' => ['customer']
],

'ACCOUNT_LOGIN' => [
    'title' => 'New Login',
    'body'  => 'New login detected on your account',
    'roles' => ['customer','seller','admin']
],

/*
|--------------------------------------------------------------------------
| SELLER APP
|--------------------------------------------------------------------------
*/

'NEW_ORDER_SELLER' => [
    'title' => 'New Order',
    'body'  => 'You received a new order #{order_id}',
    'roles' => ['seller']
],

'ORDER_CANCELLED_SELLER' => [
    'title' => 'Order Cancelled',
    'body'  => 'Order #{order_id} has been cancelled',
    'roles' => ['seller']
],

'DAILY_REPORT' => [
    'title' => 'Daily Report',
    'body'  => 'Your daily sales report is ready',
    'roles' => ['seller']
],

'PRODUCT_APPROVED' => [
    'title' => 'Product Approved',
    'body'  => 'Your product has been approved',
    'roles' => ['seller']
],

'PRODUCT_REJECTED' => [
    'title' => 'Product Rejected',
    'body'  => 'Your product has been rejected',
    'roles' => ['seller']
],

'AD_STARTED' => [
    'title' => 'Ad Campaign Started',
    'body'  => 'Your ad campaign has started',
    'roles' => ['seller']
],

'SUBSCRIPTION_EXPIRE' => [
    'title' => 'Subscription Expiry',
    'body'  => 'Your subscription will expire soon',
    'roles' => ['seller']
],

/*
|--------------------------------------------------------------------------
| DRIVER APP
|--------------------------------------------------------------------------
*/

'NEW_DELIVERY' => [
    'title' => 'New Delivery',
    'body'  => 'You have a new delivery request',
    'roles' => ['driver']
],

'DELIVERY_STARTED' => [
    'title' => 'Delivery Started',
    'body'  => 'Delivery has started',
    'roles' => ['driver']
],

'DELIVERY_COMPLETED' => [
    'title' => 'Delivery Completed',
    'body'  => 'Order delivered successfully',
    'roles' => ['driver']
],

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

'NEW_ORDER_ADMIN' => [
    'title' => 'New Order',
    'body'  => 'A new order has been placed',
    'roles' => ['admin']
],

'SELLER_REGISTERED' => [
    'title' => 'New Seller',
    'body'  => 'New seller registration received',
    'roles' => ['admin']
],

'PAYMENT_FAILED_ADMIN' => [
    'title' => 'Payment Failed',
    'body'  => 'A payment has failed',
    'roles' => ['admin']
],

'SYSTEM_ALERT' => [
    'title' => 'System Alert',
    'body'  => 'Security or system alert triggered',
    'roles' => ['admin']
],

/*
|--------------------------------------------------------------------------
| AFFILIATE
|--------------------------------------------------------------------------
*/

'NEW_SALE' => [
    'title' => 'New Sale',
    'body'  => 'A product was purchased via your link',
    'roles' => ['affiliate']
],

'COMMISSION_ADDED' => [
    'title' => 'Commission Added',
    'body'  => 'New commission has been added',
    'roles' => ['affiliate']
],

];