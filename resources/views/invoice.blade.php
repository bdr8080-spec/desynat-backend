<?php

if (isset(request()->lang)) {

  $lang = request()->input('lang', 'en');


  if (!in_array($lang, ['en', 'ar'])) {
    $lang = 'en';
  }
  app()->setLocale($lang);

}

?>


<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
  <meta charset="utf-8" />
  <title>{{ __('user_messages.invoice') }}</title>
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
        {{ __('user_messages.multi_vendor_fashion_platform') }}
      </p>

      <p style="margin: 5px auto">
        {{ __('user_messages.customer_support') }}: support@desynat.com<br />
        <!-- {{ __('user_messages.phone') }} / {{ __('user_messages.whatsapp') }}: +965 XXXXXXX -->
      </p>
      <p><b>{{ __('user_messages.invoice_number') }}:</b> #{{$checkOrder->order_id}}</p>
      <p><b>{{ __('user_messages.order_date') }}:</b> {{$checkOrder->created_at->format('Y-m-d') }}</p>
      <p><b>{{ __('user_messages.order_time') }} :</b> {{ $checkOrder->created_at->format('h:i A') }}</p>
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

    <div style="text-align: center; font-weight: 600;">{{ __('user_messages.customer_info') }} </div>
    <table style="width: 100%;margin-top: 10px;">
      <thead>
        <tr>
          <th>{{ __('user_messages.name') }}</th>
          <th>{{ __('user_messages.mobile') }}</th>
          <th>{{ __('user_messages.email') }}</th>
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
          <th>{{ __('user_messages.delivery_address') }}</th>
        </tr>
      </thead>
      <tbody>
        <tr class="invoice-items">
          <td>{{@$checkOrder->delivery_details->address }}
            {{@$checkOrder->delivery_details->state }} {{@$checkOrder->delivery_details->postal_code }}
          </td>
        </tr>
      </tbody>
    </table>

    <hr style="border: 1px dashed rgb(131, 131, 131); margin: 10px auto" />
    <table style="width: 100%; table-layout: fixed">
      <thead>
        <tr>
          <th>{{ __('user_messages.image') }}</th>
          <th>{{ __('user_messages.item') }}</th>
          <th>{{ __('user_messages.store') }}</th>
          <th>{{ __('user_messages.type') }}</th>
          <th>{{ __('user_messages.size') }}</th>
          <th>{{ __('user_messages.color') }}</th>
          <th>{{ __('user_messages.qty') }}</th>
          <th>{{ __('user_messages.price') }}</th>
        </tr>
      </thead>
      <tbody>
        @foreach($checkOrder->order_details as $key => $val)
          <tr class="invoice-items">
            <td><img src="{{$val->variation_details->variant_image[0]}}" style="width: 30px; height: 30px;"></td>
            <td>
              @if(app()->getLocale() == 'en')
                {{$val->product_details->product_name_en}}
              @else
                {{$val->product_details->product_name_ar}}
              @endif
            </td>
            <td>{{$val->product_details->seller_details->store_info->store_name}}</td>
            <td>@if($val->order_type == '1')
              {{ __('user_messages.normal') }}
            @elseif($val->order_type == '2')
                {{ __('user_messages.custom') }}
              @endif
            </td>
            <td>
              <!-- @if(app()->getLocale() == 'en')
                  {{$val->variation_details->size->name}}
                  @else
                  {{$val->variation_details->size->name_ar}}
                  @endif -->
              {{$val->variation_details->size->name}}
            </td>
            <td>
              @if(app()->getLocale() == 'en')
                {{$val->variation_details->color->name}}
              @else{{$val->variation_details->color->name_ar}}
              @endif
            </td>
            <td>{{$val->quantity}}</td>
            <td>
              @if($val->order_type == '1')
                {{$val->variation_details->actual_price}} KD
              @elseif($val->order_type == '2')
                {{$val->amount}} KD
              @endif
            </td>
          </tr>
        @endforeach

      </tbody>
    </table>


    <div style="font-weight: 600; margin-top: 15px;">{{ __('user_messages.order_summary') }} </div>
    <table style="
          width: 100%;
          margin-top: 5px;
          border: 1px dashed #838383;
          border-radius: 3px;
        ">
      <thead>
        <tr>
          <td>{{ __('user_messages.sub_total') }}:</td>
          <td style="text-align: right">{{$checkOrder->total_mrp}} KD</td>
        </tr>
        <tr>
          <td>{{ __('user_messages.discount') }}:</td>
          <td style="text-align: right">{{$checkOrder->discount_mrp}} KD</td>
        </tr>
        @if($checkOrder->promocode_details)

          <td>{{ __('user_messages.promo_code') }}</td>
          <td style="text-align: right">
            @if(app()->getLocale() == 'en')
              {{@$checkOrder->promocode_details->name_english }}
            @else
              {{@$checkOrder->promocode_details->name_arabic }}
            @endif
          </td>

        @endif
        <tr>
          <td>{{ __('user_messages.delivery_fee') }}:</td>
          <td style="text-align: right">{{$checkOrder->shipping_fees}} KD</td>
        </tr>
        <tr>
          <td>{{ __('user_messages.tax_vat') }}</td>
          <td style="text-align: right">{{$checkOrder->tax}} KD</td>
        </tr>
        <tr>
          <td style="font-weight: 600;"> {{ __('user_messages.total_amount') }}: </td>
          <td style="text-align: right;font-weight: 600;">{{$checkOrder->total_amount }} KD</td>
        </tr>
      </thead>
    </table>

    <div style="font-weight: 600; margin-top: 15px;">{{ __('user_messages.payment_information') }} </div>
    <table style="width: 100%;margin-top: 5px;">
      <thead>
        <tr>
          <td>{{ __('user_messages.payment_method') }}:</td>
          <td style="text-align: right">
            @if($checkOrder->payment_method == 1)
              {{ __('user_messages.visa') }} / {{ __('user_messages.mastercard') }}
            @elseif($checkOrder->payment_method == 2)
              {{ __('user_messages.wallet') }}
            @elseif($checkOrder->payment_method == 3)
              {{ __('user_messages.cod') }}
            @endif
          </td>
        </tr>
        <tr>
          <td>{{ __('user_messages.payment_status') }}:</td>
          <td style="text-align: right">
            @if($checkOrder->payment_status == 0)
              {{ __('user_messages.pending') }}
            @elseif($checkOrder->payment_status == 1)
              {{ __('user_messages.paid') }}
            @elseif($checkOrder->payment_status == 2)
              {{ __('user_messages.cancelled') }}
            @elseif($checkOrder->payment_status == 3)
              {{ __('user_messages.refund') }}
            @endif
          </td>
        </tr>
      </thead>
    </table>

    <div style=" font-weight: 600; margin-top: 15px;">{{ __('user_messages.delivery_information') }} </div>
    <table style="width: 100%;margin-top: 5px;">
      <thead>
        <tr>
          <td>{{ __('user_messages.expected_delivery_date') }}:</td>
          <td style="text-align: right">{{$checkOrder->created_at->addDays(6)->format('d M Y') }}</td>
        </tr>
        <tr>
          <td>{{ __('user_messages.expected_delivery_time') }}:</td>
          <td style="text-align: right">{{$checkOrder->created_at->addDays(6)->format('h:i:s') }}</td>
        </tr>
        <tr>
          <td>{{ __('user_messages.delivery_managed_by') }}:</td>
          <td style="text-align: right">Desynat</td>
        </tr>
      </thead>
    </table>

    <div style="font-weight: 600; margin-top: 15px;">{{ __('user_messages.return_&_exchange_policy') }} </div>
    <table style="width: 100%;margin-top: 1px;">
      <thead>
        <tr>
          <td>
            <div>{{ __('user_messages.exchange_&_return_within_14_days_from_delivery_date') }}.</div>
            <div>{{ __('user_messages.non_refundable_unless_defective') }}.</div>
            <div>{{ __('user_messages.item_must_be_unused_and_in_original_packaging') }}.</div>
            <div>{{ __('user_messages.delivery_fee_is_non_refundable') }}.</div>
          </td>
        </tr>

      </thead>
    </table>

    <hr style="border: 1px dashed rgb(131, 131, 131); margin: 10px auto" />
    <div style="text-align: center; font-weight: 600; font-size: 0.75rem;">
      {{ __('user_messages.this_invoice_is_generated_electronically_by') }} DESYNAT
      {{ __('user_messages.and_does_not_require_a_signature') }}.
    </div>


  </section>
</body>

</html>