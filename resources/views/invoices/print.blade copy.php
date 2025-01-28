<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>POS Receipt</title>
    <style>
        @media print {
            html, body {
                width: 80mm;
                height: 100%;
                position: absolute;
            }
            .page-break {
                display: block;
                page-break-before: always;
            }
        }

        #invoice-POS {
            box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
            padding: 2mm;
            margin: 0 auto;
            width: 80mm;
            background: #FFF;
        }

        #invoice-POS h1 {
            font-size: 1.5em;
            color: #222;
        }

        #invoice-POS h2 {
            font-size: .9em;
        }

        #invoice-POS h3 {
            font-size: 1.2em;
            font-weight: 300;
            line-height: 2em;
        }

        #invoice-POS p {
            font-size: .7em;
            color: #666;
            line-height: 1.2em;
        }

        #invoice-POS .info {
            display: block;
            margin-left: 0;
        }

        #invoice-POS table {
            width: 100%;
            border-collapse: collapse;
        }

        #invoice-POS .tabletitle {
            font-size: .5em;
            background: #EEE;
        }

        #invoice-POS .service {
            font-size: 1.2em;
            border-bottom: 1px solid #EEE;
        }

        #invoice-POS .item {
            width: 42mm;
        }

        #invoice-POS .itemtext {
            font-size: .5em;
        }

        #invoice-POS #legalcopy {
            margin-top: 5mm;
        }
    </style>
</head>

<body>
    <div id="invoice-POS">
        <center id="top">
            <div class="logo"></div>
            <div class="info">
                <h2>SAT Sweets</h2>
                <p>
                    3/147 Karunaipalayam Pirivu,<br>
                    Covai-Tiruchy Main Road,<br>
                    Kangeyam -638701
                </p>
            </div>
        </center>

        <div id="mid">
            <div class="info">
                <p>Bill Number: {{ sprintf('%04d', $bill->id) }}</p>
                <p>Bill Date: {{ $bill->created_at->format('d-m-Y') }}</p>
                <h2>Billing Address:</h2>
                <p>{{ $bill->customer->name ?? 'Walk-In Customer' }}</p>
                <p>{{ $bill->customer->address ?? '-' }}</p>
            </div>
        </div>

        <div id="bot">
            <div id="table">
                <table>
                    <tr class="tabletitle">
                        <td><h2>Item</h2></td>
                        <td><h2>Price</h2></td>
                        <td><h2>Qty</h2></td>
                        <td><h2>Sub Total</h2></td>
                    </tr>
                    @foreach ($bill->items as $item)
                        <tr class="service">
                            <td><p class="itemtext">{{ $item->product->name_tamil }}</p></td>
                            <td><p class="itemtext">{{ number_format($item->price, 2) }}</p></td>
                            <td><p class="itemtext">{{ $item->quantity }}</p></td>
                            <td><p class="itemtext">{{ number_format($item->price * $item->quantity, 2) }}</p></td>
                        </tr>
                    @endforeach
                    <tr class="tabletitle">
                        <td></td>
                        <td></td>
                        <td class="Rate"><h2>Tax</h2></td>
                        <td class="payment"><h2>{{ number_format($bill->items->sum('cgst') + $bill->items->sum('sgst'), 2) }}</h2></td>
                    </tr>
                    <tr class="tabletitle">
                        <td></td>
                        <td></td>
                        <td class="Rate"><h2>Total</h2></td>
                        <td class="payment"><h2>{{ number_format($bill->final_amount, 2) }}</h2></td>
                    </tr>
                </table>
            </div>

            <div id="legalcopy">
                <p class="legal"><strong>Thank you for your business!</strong> SAT Sweets.</p>
            </div>
        </div>
    </div>
</body>

</html>
