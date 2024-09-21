<style>
    .clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #5D6975;
  text-decoration: underline;
}

body {
  position: relative;
  /* width: 21cm;
  height: 29.7cm; */
  margin: 0 auto;
  color: #001028;
  background: #FFFFFF;
  font-family: Arial, sans-serif;
  font-size: 12px;
  font-family: Arial;
}

header {
  padding: 10px 0;
  margin-bottom: 30px;
}

#logo {
  text-align: center;
  margin-bottom: 10px;
}

#logo img {
  width: 90px;
}

h1 {
  border-top: 1px solid  #5D6975;
  border-bottom: 1px solid  #5D6975;
  color: #5D6975;
  font-size: 15px;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  margin: 0 0 20px 0;
  background: url(dimension.png);
}

/* #project {
  float: left;
}

#project span {
  color: #5D6975;
  text-align: right;
  width: 52px;
  margin-right: 10px;
  display: inline-block;
  font-size: 0.8em;
}

#company {
  float: right;
  text-align: right;
}

#project div,
#company div {
  white-space: nowrap;
} */

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

/* table tr:nth-child(2n-1) td {
  background: #F5F5F5;
} */

table th,
table td {
  text-align: center;
}

table th {
  padding: 5px 20px;
  color: #5D6975;
  /* border-bottom: 1px solid #C1CED9; */
  white-space: nowrap;
  font-weight: normal;
}


table .service,
table .desc {
  text-align: left;
}

table td {
  padding: 10px;
  text-align: left;
}

tr.fee_details  td{
  padding: 0px 10px 10px 10px;
  font-size: 0.9em;
}

table td.service,
table td.desc {
  vertical-align: top;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table td.grand {
  border-top: 1px solid #5D6975;
}

#notices .notice {
  color: #5D6975;
  font-size: 1.2em;
}

footer {
  color: #5D6975;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #C1CED9;
  padding: 8px 0;
  text-align: center;
}
</style>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Example 1</title>
    <link rel="stylesheet" href="style.css" media="all" />
  </head>
  <body>
    {{-- <header class="clearfix">
      <div id="logo">
        <img src="logo.png">
      </div>
      <h1>INVOICE {{ $order_item->invoice_no }}</h1>
      <div id="company" class="clearfix">
        <div>Company Name</div>
        <div>455 Foggy Heights,<br /> AZ 85004, US</div>
        <div>(602) 519-0450</div>
        <div><a href="mailto:company@example.com">company@example.com</a></div>
      </div>
      <div id="project">
        <div><span>PROJECT</span> Website development</div>
        <div><span>CLIENT</span> John Doe</div>
        <div><span>ADDRESS</span> 796 Silver Harbour, TX 79273, US</div>
        <div><span>EMAIL</span> <a href="mailto:john@example.com">john@example.com</a></div>
        <div><span>DATE</span> August 17, 2015</div>
        <div><span>DUE DATE</span> September 17, 2015</div>
      </div>
    </header> --}}
    <main>
        <table>
            <thead>
              <tr>
                <th style="text-align: center" class="service"><h3>Invoice - {{ $order_item->invoice_no }}</h3><small>9809373738</small></th>

              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="text-align: center; border-bottom: 1px dashed #000; border-top: 1px dashed #000;" class="service">
                    10 March 2024<br>
                </td>
              </tr>
              <tr>
                <td class="service">
                    <table>
                        <tr>
                            <td></td>
                            <td>{{ $order_item->product->name }}</td>
                            <td>{{ $order_item->price }} SAR</td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                        </tr>
                        {{-- <tr class="fee_details">
                            <td></td>
                            <td>Additional Service Fee</td>
                            <td>15 SAR</td>
                        </tr> --}}
                        <tr class="fee_details">
                            <td></td>
                            <td>Total Before VAT</td>
                            <td>{{ $order_item->price }} SAR</td>
                        </tr>
                        <tr class="fee_details">
                            <td></td>
                            <td>Value Added Tax (15%)</td>
                            <td>{{ ($order_item->price)*15/100 }} SAR</td>
                        </tr>
                        <tr class="" style="color: blue; font-weight:bold;">
                            <td></td>
                            <td>Total Amount</td>
                            <td>{{ ($order_item->price) + (($order_item->price)*15/100) }}</td>
                        </tr>
                        <tr class="">
                            <td></td>
                            <td>VAT Number</td>
                            <td>{{ $order_item->product->branch->customer->vat }}</td>
                        </tr>
                    </table>
                </td>
              </tr>
              <tr>
                <td class="service">
                    <table >
                        <tr class="" >
                            <td colspan="2" style="text-align:center;">
                                <img width="200" src="{{ $qr_image }}" alt="QR Code" />
                            </td>

                        </tr>
                    </table>

                </td>
              </tr>
            </tbody>
        </table>




      {{-- <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
      </div> --}}
    </main>
    <footer>
      Invoice was created on a computer and is valid without the signature and seal.
    </footer>
  </body>
</html>
