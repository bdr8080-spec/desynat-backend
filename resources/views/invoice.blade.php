<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <title>Invoice</title>
  <style>
    * {
      box-sizing: border-box;
    }
    .table-bordered td,
    .table-bordered th {
      border: 1px solid #ddd;
      padding: 10px;
      word-break: break-all;
      font-size: 0.75rem;
    }

    body {
      font-family: Arial, Helvetica, sans-serif;
      margin: 0;
      padding: 0;
      font-size: 0.75rem;
    }
    @media print {
      @page {
        size: 80mm auto;
        margin: 0;
      }

    }

    .h4-14 h4 {
      font-size: 0.75rem;
      margin-top: 0;
      margin-bottom: 5px;
    }

    pre,
    p {
      padding: 0;
      margin: 0;
    }

    table {
      font-family: arial, sans-serif;
      width: 100%;
      border-collapse: collapse;
      padding: 1px;
      font-size: 0.75rem;
    }

    .hm-p p {
      text-align: left;
      padding: 1px;
      padding: 5px 4px;
      font-size: 0.75rem;
    }

    td,
    th {
      text-align: left;
      padding: 4px 6px;
      font-size: 0.75rem;
    }

    .table-b td,
    .table-b th {
      border: 1px solid #ddd;
    }

    th {
      font-size: 0.75rem;
      text-align: center;
    }

    .hm-p td,
    .hm-p th {
      padding: 3px 0px;
    }

    .cropped {
      float: right;
      margin-bottom: 20px;
      height: 100px;
      overflow: hidden;
    }

    .cropped img {
      width: 400px;
      margin: 8px 0px 0px 80px;
    }

    .main-pd-wrapper {
      padding: 2mm;
      margin: 20px auto;
      width: 100mm;
      background: #fff;
      border: 1px solid #ddd;
    }

    .table-bordered td,
    .table-bordered th {
      border: 1px solid #ddd;
      padding: 10px;
      font-size: 0.75rem;
    }

    .invoice-items {
      font-size: 0.75rem;
      border-top: 1px dashed #ddd;
    }

    .invoice-items td {
      padding: 14px 0;
      text-align: center;
    }
  </style>
</head>

<body>
  <section class="main-pd-wrapper">
    <div style="
          text-align: center;
          margin: auto;
          line-height: 1.5;
          font-size: 13px;
          color: #4a4a4a;
        ">
        <img src="{{ asset('admin/image/Desynat-logo-2.svg') }}" alt="logo" style="width:205px;">
      <p style="
            font-weight: bold;
            color: #000;
            margin-top: 5px;
               font-size: 0.75rem;
          ">
        multi-vendor fashion platform
      </p>

      <p style="margin: 5px auto">
        customer support: support@desynat.com<br />
                phone / whatsapp: +965 XXXXXXX
      </p>
      <p><b>Invoice Number:</b> #{{$checkOrder->order_id}}</p>
      <p><b>Order Date:</b> {{$checkOrder->created_at->format('Y-m-d') }}</p>
      <p><b>Order Time :</b> {{ $checkOrder->created_at->format('h:i A') }}</p>
      <hr style="border: 1px dashed rgb(131, 131, 131); margin: 15px 0px 10px" />
    </div>

    <!-- <table style="width: 100%;margin-top: 10px;">
      <thead>
        <tr>
          <th>Store Name</th>
          <th>Seller Type</th>
        </tr>
      </thead>
      <tbody>
        <tr class="invoice-items">
          <td>Desynat Store</td>
          <td>Fashion Designer</td>
        </tr>
      </tbody>
    </table> -->
    <!-- <hr style="border: 1px dashed rgb(131, 131, 131); margin: 1px 0px 10px" /> -->

    <div style="text-align: center; font-weight: 600;">Customer Info </div>
    <table style="width: 100%;margin-top: 10px;">
      <thead>
        <tr>
          <th>Name</th>
          <th>Mobile</th>
          <th>Email</th>
        </tr>
      </thead>
      <tbody>
        <tr class="invoice-items">
          <td>{{@$checkOrder->delivery_details->name }}</td>
          <td>{{@$checkOrder->delivery_details->country_code }} {{@$checkOrder->delivery_details->mobile }}</td>
          <td>{{@$checkOrder->user_details->email }}</td>
        </tr>
      </tbody>
    </table>

    <table style="width: 100%;">
      <thead>
        <tr>
          <th>Delivery Address</th>
        </tr>
      </thead>
      <tbody>
        <tr class="invoice-items">
          <td>{{@$checkOrder->delivery_details->address }}
                    {{@$checkOrder->delivery_details->state }} {{@$checkOrder->delivery_details->postal_code }} </td>
        </tr>
      </tbody>
    </table>

    <hr style="border: 1px dashed rgb(131, 131, 131); margin: 10px auto" />
    <table style="width: 100%; table-layout: fixed">
      <thead>
        <tr>
          <th>Image</th>
          <th>Item</th>
          <th>Store</th>
          <th>Type</th>
          <th>Size</th>
          <th>Color</th>
          <th>Qty</th>
          <th>Price</th>
        </tr>
      </thead>
      <tbody>
        @foreach($checkOrder->order_details as $key=>$val)
        <tr class="invoice-items">
          <td><img src="{{$val->variation_details->variant_image[0]}}" style="width: 30px; height: 30px;"></td>
          <td>{{$val->product_details->product_name_en}}</td>
          <td>{{$val->product_details->seller_details->store_info->store_name}}</td>
          <td>@if($val->order_type=='1')
                Normal
                @elseif($val->order_type=='2')
                Custom
                @endif
            </td>
          <td>{{$val->variation_details->size->name}}</td>
          <td>{{$val->variation_details->color->name}}</td>
          <td>{{$val->quantity}}</td>
          <td>
           @if($val->order_type=='1')
                                {{$val->variation_details->actual_price}} KD
                                @elseif($val->order_type=='2')
                                {{$val->amount}} KD
                                @endif
          </td>
        </tr>
        @endforeach
        
      </tbody>
    </table>

   
    <div style="font-weight: 600; margin-top: 15px;">Order Summary </div>
    <table style="
          width: 100%;
          margin-top: 5px;
          border: 1px dashed #838383;
          border-radius: 3px;
        ">
      <thead>
        <tr>
          <td>SubTotal:</td>
          <td style="text-align: right">{{$checkOrder->total_mrp}} KD</td>
        </tr>
        <tr>
          <td>Discount:</td>
          <td style="text-align: right">{{$checkOrder->discount_mrp}} KD</td>
        </tr>
        @if($checkOrder->promocode_details)

        <td>Promo Code</td>
        <td style="text-align: right">{{@$checkOrder->promocode_details->name_english }}</td>

        @endif
        <tr>
          <td>Delivery Fee:</td>
          <td style="text-align: right">{{$checkOrder->shipping_fees}} KD</td>
        </tr>
        <tr>
          <td>Tax (VAT)</td>
          <td style="text-align: right">{{$checkOrder->tax}} KD</td>
        </tr>
        <tr>
          <td style="font-weight: 600;"> Total Amount:  </td>
          <td style="text-align: right;font-weight: 600;">{{$checkOrder->total_amount }} KD</td>
      </tr>
      </thead>
    </table>

    <div style="font-weight: 600; margin-top: 15px;">Payment Information </div>
    <table style="width: 100%;margin-top: 5px;">
      <thead>
        <tr>
          <td>Payment Method:</td>
          <td style="text-align: right">
            @if($checkOrder->payment_method==1)
                    VISA / MASTERCARD
                    @elseif($checkOrder->payment_method==2)
                    WALLET
                    @elseif($checkOrder->payment_method==3)
                    COD
                    @endif
          </td>
        </tr>
        <tr>
          <td>Payment Status:</td>
          <td style="text-align: right">
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
      </thead>
    </table>

    <div style=" font-weight: 600; margin-top: 15px;">Delivery Information </div>
    <table style="width: 100%;margin-top: 5px;">
      <thead>
        <tr>
          <td>Expected Delivery Date:</td>
          <td style="text-align: right">{{$checkOrder->created_at->addDays(6)->format('d M Y') }}</td>
        </tr>
        <tr>
          <td>Expected Delivery Time:</td>
          <td style="text-align: right">{{$checkOrder->created_at->addDays(6)->format('h:i:s') }}</td>
        </tr>
        <tr>
          <td>Delivery Managed By:</td>
          <td style="text-align: right">Desynat</td>
        </tr>
      </thead>
    </table>

    <div style="font-weight: 600; margin-top: 15px;">Return & Exchange Policy </div>
    <table style="width: 100%;margin-top: 1px;">
      <thead>
        <tr>
          <td>
              <div>Exchange & return within 7 days from delivery date.</div>
              <div>Non-refundable unless defective.</div>
              <div>Item must be unused and in original packaging.</div>
              <div>Delivery fee is non-refundable.</div>
          </td>
        </tr>
       
      </thead>
    </table>

    <hr style="border: 1px dashed rgb(131, 131, 131); margin: 10px auto" />
    <div style="text-align: center; font-weight: 600; font-size: 0.75rem;">This invoice is generated electronically by DESYNAT and does not require
      a signature.</div>


  </section>
</body>

</html>