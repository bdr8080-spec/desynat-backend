<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/x-icon" href="{{asset('admin/image/favicon.svg')}}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>DESYNAT Invoice</title>

    <style>
    * {
        box-sizing: border-box;
        font-family: Arial, Helvetica, sans-serif;
    }

    body {
        margin: 0;
        padding: 40px;
        background: #eaeaea;
    }

    .invoice {
        width: 794px;
        min-height: 1123px;
        background: #fff;
        margin: auto;
        padding: 40px;
        color: #000;
    }

    /* HEADER */
    .header {
        display: grid;
        grid-template-columns: 1fr 1px 1fr;
        align-items: center;
        padding: 30px;
    }

    .header-divider {
        height: 100%;
        background: #000;
    }

    .left-header {
        padding-right: 15px;
    }

    .right-header {
        padding-left: 25px;
        font-size: 12px;
    }

    .logo {
        font-size: 60px;
        font-weight: bold;
    }

    .sub {
        font-size: 22px;
        color: #555;
    }

    hr {
        border: 1px solid #000;
        margin: 20px 0;
    }

    /* META */
    .meta {
        display: flex;
        justify-content: space-between;
        font-size: 18px;
        text-transform: uppercase;

    }

    /* COMMON TABLE */
    .table {
        /* width: 100%; */
        border-collapse: collapse;
        font-size: 17px;
    }

    /* .table td {
        padding: 6px 0;
      } */

    .section-title {
        font-size: 18px;
        margin: 25px 0 10px;
        text-transform: uppercase;
        font-weight: 600;
    }

    /* PRODUCT + SUMMARY BLOCK */
    .box {
        margin-top: 15px;
        font-size: 13px;
    }

    .box-row {
        display: flex;
        justify-content: space-between;
        gap: 30px;
        padding-bottom: 10px;
    }

    .box-col {
        width: 50%;
    }

    .box-col.right {
        text-align: right;
    }

    .box-title {
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 6px;
        font-size: 18px;

    }

    .inner-table {
        width: 100%;
        border-collapse: collapse;
    }

    .inner-table td {
        padding: 2px 0px;
        /* font-size: 18px; */
    }

    .text-right {
        text-align: right;
    }

    /* ONLY SUBTOTAL BOX */
    .box-footer {
        border: 1px solid #000;
        padding: 6px 8px;
        margin-top: 8px;
    }

    .box-footer table {
        width: 100%;
        border-collapse: collapse;
    }

    .box-footer td {
        padding: 3px 6px;
        font-size: 14px;
    }

    .box-footer td:nth-child(3),
    .box-footer td:nth-child(4) {
        text-align: right;
        /* width: 90px; */
    }

    /* POLICY */
    .policy {
        font-size: 12px;
        padding-left: 18px;
    }

    .policy li {
        margin-bottom: 6px;
        font-size: 17px;
    }

    .footer {
        margin-top: 30px;
        font-size: 21px;
        text-align: center;
    }


    .customer-info td {
        padding: 8px 6px;
        vertical-align: middle;
    }

    .customer-info .label {
        width: 180px;
        /* font-weight: 600; */
        white-space: nowrap;
    }

    .customer-info .line {
        border-bottom: 2px dotted #000;
        width: 100%;
    }
    </style>
</head>

<body>
    <div class="invoice">
        <!-- HEADER -->
        <div class="header">
            <div class="left-header">
                <div class="logo">DESYNAT</div>
                <div class="sub">multi-vendor fashion platform</div>
            </div>

            <div class="header-divider"></div>

            <div class="right-header">
                customer support: support@desynat.com<br />
                phone / whatsapp: +965 XXXXXXX
            </div>
        </div>

        <hr />

        <!-- META -->
        <div class="meta">
            <div>
                <strong>Invoice Number: </strong> {{$checkOrder->order_id}} <br />
                Order Date: {{$checkOrder->created_at->format('Y-m-d') }}<br />
                Order Time: {{ $checkOrder->created_at->format('H-i-s') }}<br />
                Platform: DESYNAT
            </div>
            <div>
                Store Name: Desynat Store<br />
                Seller Type: Fashion Designer <br />
            </div>
        </div>

        <hr />

        <!-- CUSTOMER -->
        <div class="section-title">Customer Information</div>

        <table class="table customer-info">
            <tr>
                <td class="label">Customer Name:</td>
                <td class="line"> {{@$checkOrder->user_details->full_name }}</td>
            </tr>
            <tr>
                <td class="label">Mobile Number:</td>
                <td class="line">{{@$checkOrder->user_details->country_code }} {{@$checkOrder->user_details->mobile }}
                </td>
            </tr>
            <tr>
                <td class="label">Email Address:</td>
                <td class="line"> {{@$checkOrder->user_details->email }} </td>
            </tr>
            <tr>
                <td class="label">Delivery Address::</td>
                <td class="line"> {{@$checkOrder->delivery_details->address }}
                    {{@$checkOrder->delivery_details->state }} {{@$checkOrder->delivery_details->postal_code }} </td>
            </tr>
        </table>

        <hr />

        <!-- PRODUCT + SUMMARY -->
        <div class="box">
            <!-- <div class="box-row">
                <div class="box-col">
                    <div class="box-title">Product Details</div>
                    <table class="inner-table">
                        <tr>
                            <td>Product Name:</td>
                            <td>Dress XZZ</td>
                        </tr>
                        <td>Product Type:</td>
                        <td style="text-transform: uppercase;">Ready-to-Wear / Made-to-Order : ZOMO CODE</td>
                        </tr>
                        <tr>
                            <td>Color Type(s):</td>
                            <td>Black</td>
                        </tr>

                    </table>
                </div>

                <div class="box-col right">
                    <div class="box-title">.</div>

                    <table class="inner-table">
                        <tr>
                            <td>Size:</td>
                            <td class="text-right">M</td>
                        </tr>
                        <tr>
                            <td>Quantity:</td>
                            <td class="text-right">2</td>
                        </tr>
                        <tr>
                            <td>Price per Item:</td>
                            <td class="text-right">25,000 KD</td>
                        </tr>
                        <tr>
                            <td>Subtotal</td>
                            <td class="text-right">20,000 KD</td>
                        </tr>
                    </table>
                </div>
            </div> -->

            <div class="table-container">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Size</th>
                            <th>Color</th>
                            <th>Quantity</th>
                            <th>Price per Item</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($checkOrder->order_details as $key=>$val)

                        <tr>
                            <td><img src="{{$val->variation_details->variant_image[0]}}" width="70px"> </td>
                            <td>{{$val->product_details->product_name_en}}</td>
                            <td>{{$val->variation_details->size->name}}</td>
                            <td>{{$val->variation_details->color->name}}</td>
                            <td>{{$val->quantity}}</td>
                            <td>{{$val->variation_details->actual_price}}</td>
                        </tr>

                        @endforeach


                        <!-- Add more rows -->
                    </tbody>
                </table>
            </div>


            <!-- SUBTOTAL BOX -->
            <div class="box-footer">
                <div class="box-title">Order Summary</div>

                <table>
                    <tr>
                        <td><strong>SUBTOTAL</strong></td>
                        <td>{{$checkOrder->total_mrp}}</td>

                    </tr>
                    <tr>
                        <td>Discount</td>
                        <td>{{$checkOrder->discount_mrp}} KD</td>
                        <td>Promo Code</td>
                        <td>{{@$checkOrder->promocode_details->name_english }}</td>
                    </tr>

                    <tr>
                        <td>Delivery Fee</td>
                        <td>{{$checkOrder->shipping_fees}}</td>
                        <td>Tax (VAT)</td>
                        <td>{{$checkOrder->tax}} KD</td>
                    </tr>
                    <tr>
                        <td>
                            Total Amount:
                        </td>
                        <td>{{$checkOrder->total_amount }} KD</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- PAYMENT -->
        <div class="section-title">Payment Information</div>
        <table class="table">
            <tr>
                <td>Payment Method:</td>
                <td>

                    @if($checkOrder->payment_method==1)
                    KNET / VISA / MASTERCARD / WALLET
                    @elseif($checkOrder->payment_method==2)
                    WALLET
                    @elseif($checkOrder->payment_method==3)
                    COD
                    @endif
                </td>
            </tr>
            <tr>
                <td>Payment Status</td>
                <td>
                    @if($checkOrder->payment_status==0)
                    Pending
                    @elseif($checkOrder->payment_status==1)
                    Paid
                    @elseif($checkOrder->payment_status==2)
                    Cancelled
                    @elseif($checkOrder->payment_status==3)
                    Refund
                    @endif
                </td>
            </tr>
        </table>

        <hr />
        <div class="section-title">Delivery Information</div>
        <table class="table">
            <tr>
                <td>Expected Delivery Date:</td>
                <td>{{$checkOrder->created_at->addDays(6)->format('d M Y') }}</td>
            </tr>
            <tr>
                <td>Expected Delivery Time:</td>
                <td>{{$checkOrder->created_at->addDays(6)->format('h:i:s') }}</td>
            </tr>
            <tr>
                <td>Delivery Managed By:</td>
                <td>Desynat</td>
            </tr>
        </table>

        <hr />

        <!-- POLICY -->

        <div class="section-title">Return & Exchange Policy</div>
        <ul class="policy">
            <li>Exchange & return within 7 days from delivery date.</li>
            <li>Non-refundable unless defective.</li>
            <li>Item must be unused and in original packaging.</li>
            <li>Delivery fee is non-refundable.</li>
        </ul>

        <hr />

        <div class="footer">
            This invoice is generated electronically by DESYNAT and does not require
            a signature.
        </div>
    </div>
</body>

</html>