<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
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
        font-size: 20px;
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
        padding: 2px 0;
            font-size: 18px;
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
        width: 90px;
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
      tr {
    text-transform: uppercase;
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
          <strong>Invoice Number: </strong> DES-INV-0001<br />
          Order Date: 22 OCT 2025<br />
          Seller Type: Fashion Designer<br />
          Platform: DESYNAT
        </div>
        <div>
          Store Name <br />
          Seller Type:
        </div>
      </div>

      <hr />

      <!-- CUSTOMER -->
      <div class="section-title">Customer Information</div>

      <table class="table customer-info">
        <tr>
          <td class="label">Customer Name:</td>
          <td class="line"></td>
        </tr>
        <tr>
          <td class="label">Mobile Number:</td>
          <td class="line"></td>
        </tr>
        <tr>
          <td class="label">Email Address:</td>
          <td class="line"></td>
        </tr>
      </table>

      <hr />

      <!-- PRODUCT + SUMMARY -->
      <div class="box">
        <div class="box-row">
          <div class="box-col">
            <div class="box-title">Product Details</div>
            <table class="inner-table">
              <tr>
                <td>Product Name:</td>
                <td>Dress XZZ</td>
              </tr>
              <tr>
                <td>Color Type(s):</td>
                <td>Black</td>
              </tr>
              <tr>
                <td>Size Quantity:</td>
                <td>Quetotal 55,000 KD</td>
              </tr>
            </table>
          </div>

          <div class="box-col right">
            <div class="box-title">Order Summary</div>
            <table class="inner-table">
              <tr>
                <td></td>
                <td class="text-right">M</td>
              </tr>
              <tr>
                <td></td>
                <td class="text-right">-5,000 KD</td>
              </tr>
              <tr>
                <td>SUBTOTAL</td>
                <td class="text-right">20,000 KD</td>
              </tr>
            </table>
          </div>
        </div>

        <!-- SUBTOTAL BOX -->
        <div class="box-footer">
          <table>
            <tr>
              <td><strong>SUBTOTAL</strong></td>
              <td>Dress XZZ</td>
              <td>-5,000 KD</td>
              <td>2,000 KD</td>
            </tr>
            <tr>
              <td>PRODUCT TYPE:</td>
              <td style="text-transform: uppercase;">Ready-to-Wear / Made-to-Order : ZOMO CODE</td>
              <td>0.000 KD</td>
              <td>Paid</td>
            </tr>
            <tr>
              <td>Delivery Fee</td>
              <td>50,000</td>
              <td>30.000 KD</td>
              <td>Tax (VAT)</td>
            </tr>
          </table>
        </div>
      </div>

      <!-- PAYMENT -->
      <div class="section-title">Payment Information</div>
      <table class="table">
        <tr>
          <td>Payment Method:</td>
          <td>KNET / VISA / MASTERCARD / WALLET</td>
        </tr>
        <tr>
          <td>Delivery Managed By:</td>
          <td>DESYNAT</td>
        </tr>
      </table>

      <hr />

      <!-- POLICY -->
      <div class="section-title">Payment Information</div>
      <div class="section-title">Return & Exchange Policy</div>
      <ul class="policy">
        <li>Exchange & return within 14 days from delivery date.</li>
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
