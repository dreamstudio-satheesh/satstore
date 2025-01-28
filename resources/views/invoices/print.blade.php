<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>POS Receipt</title>
    <style>
        @media print {

            html,
            body {
                width: 80mm;
                height: 100%;
                position: absolute;
            }

            /* General styles for body and paragraphs */
            body,
            p {
                color: #000 !important;
                font-weight: bold !important;
                font-size: 0.9em !important;
                /* Slightly larger text */
            }

            /* Heading styles */
            h1 {
                color: #000 !important;
                font-weight: bold !important;
                font-size: 1.8em !important;
                /* Larger for main title */
            }

            h2 {
                color: #000 !important;
                font-weight: bold !important;
                font-size: 1.2em !important;
                /* Slightly larger for subtitles */
            }

            h3 {
                color: #000 !important;
                font-weight: bold !important;
                font-size: 1.5em !important;
                /* Increased for emphasis */
            }

            /* Table styles */
            table {
                width: 100%;
                border-collapse: collapse;
                font-size: 0.9em !important;
                /* Larger for table content */
            }

            td,
            th {
                color: #000 !important;
                font-weight: bold !important;
                font-size: 1em !important;
                /* Slightly larger for clarity */
            }

            .tabletitle {
                font-size: 0.8em !important;
                /* Adjust table title size */
                background: #EEE;
            }

            .service {
                font-size: 1em !important;
                /* Adjust service item font size */
                border-bottom: 1px solid #EEE;
            }

            .item {
                width: 42mm;
            }

            .itemtext {
                font-size: 0.9em !important;
                /* Slightly larger for item details */
                color: #000 !important;
            }

            /* Legal and footer text */
            #legalcopy,
            .legal {
                font-size: 0.9em !important;
                /* Enlarged for readability */
                color: #000 !important;
                font-weight: bold !important;
            }

            /* Page-break for multi-page print */
            .page-break {
                display: block;
                page-break-before: always;
            }

            /* Box shadow removed for print */
            #invoice-POS {
                box-shadow: none;
                padding: 2mm;
                margin: 0 auto;
                width: 80mm;
                background: #FFF;
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
            <div class="logo"><img id="logo" src="https://satsweets.com/logo.png" width="160px" height="107px"
                title="SAT Sweets" alt="SAT Sweets Logo" /></div>
            <div class="info">
              
                <p>
                    3/147 Karunaipalayam Pirivu,  Covai-Tiruchy Main Road,<br>
                    Kangeyam -638701 Phone: 90874 49924 ~ GST NO :33ATOPR7702H1ZF
                </p>
            </div>
        </center>

        <div id="mid">
            <div class="info">
                <p>Bill Number: #{{ sprintf('%04d', $bill->id) }}/24-25</p>
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
                        <td>
                            <h2>Item</h2>
                        </td>
                        <td>
                            <h2>Taxable</h2>
                        </td>
                        <td>
                            <h2>GST</h2>
                        </td>
                        <td>
                            <h2>Qty</h2>
                        </td>
                        <td>
                            <h2>Total</h2>
                        </td>
                    </tr>
                    @foreach ($bill->items as $item)
                        <tr class="service">
                            <td>
                                <p class="itemtext">{{ $item->product->name_tamil }}</p>
                            </td>
                            <td>
                                <p class="itemtext">{{ number_format($item->taxable_value, 2) }}</p>
                            </td>
                            <td>
                                <p class="itemtext">{{ $item->gst_slab }}%</p>
                            </td>
                            <td>
                                <p class="itemtext">{{ $item->quantity }}</p>
                            </td>
                            <td>
                                <p class="itemtext">{{ number_format($item->price * $item->quantity, 2) }}</p>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="tabletitle">
                        <td colspan="4" style="text-align: right;">
                            <h2>CGST</h2>
                        </td>
                        <td style="text-align: right;">
                            <h2>{{ number_format($bill->items->sum('cgst'), 2) }}</h2>
                        </td>
                    </tr>
                    <tr class="tabletitle">
                        <td colspan="4" style="text-align: right;">
                            <h2>SGST</h2>
                        </td>
                        <td style="text-align: right;">
                            <h2>{{ number_format($bill->items->sum('sgst'), 2) }}</h2>
                        </td>
                    </tr>
                    <tr class="tabletitle">
                        <td colspan="4" style="text-align: right;">
                            <h2>GST Total</h2>
                        </td>
                        <td style="text-align: right;">
                            <h2>{{ number_format($bill->items->sum('cgst') + $bill->items->sum('sgst'), 2) }}</h2>
                        </td>
                    </tr>
                    <tr class="tabletitle">
                        <td colspan="4" style="text-align: right;">
                            <h2>Grand Total</h2>
                        </td>
                        <td style="text-align: right;">
                            <h2>{{ number_format($bill->final_amount, 2) }}</h2>
                        </td>
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
