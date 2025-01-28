<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="bill, receipt">
    <meta name="author" content="ElitePOS">
    <title>POS - Invoice Page</title>

    <!-- Style -->
    <link href="https://satsweets.com/assets/css/pos.css" rel="stylesheet" />
</head>

<body class="section-bg-one">
    <main class="container receipt-wrapper" id="download-section">
        <!-- Receipt Header -->
        <div class="receipt-top">
            <div class="company-name">
                <img id="logo" src="https://satsweets.com/logo.png" width="160px" height="107px"
                    title="SAT Sweets" alt="SAT Sweets Logo" />
            </div>
            <div class="company-address">
                3/116A Senkottampalayam, Karunaipalayam Section, Muthiyanerachal (PO) <br>
                Trichy Main Road, Kangeyam
            </div>
            <div class="company-mobile">
                Tiruppur-638701 <br>
                Phone: 90874 49924
            </div>
        </div>

        <!-- Receipt Details -->
        <div class="receipt-body">
            <div class="receipt-heading">
                <span>Cash Memo</span>
            </div>
            <ul class="text-list text-style1">
                <li>
                    <div class="text-list-title">Date:</div>
                    <div class="text-list-desc">{{ $bill->created_at->format('d/m/Y') }}</div>
                </li>
                <li class="text-right">
                    <div class="text-list-title">Time:</div>
                    <div class="text-list-desc">{{ $bill->created_at->format('h:i A') }}</div>
                </li>
                <li>
                    <div class="text-list-title">Branch:</div>
                    <div class="text-list-desc">{{ $branch->name ?? 'Branch Name' }}</div>
                </li>
                <li class="text-right">
                    <div class="text-list-title">Invoice:</div>
                    <div class="text-list-desc">#{{ sprintf('%05d', $bill->id) }}/24-25</div>
                </li>
            </ul>

            <!-- Receipt Table -->
            <table class="receipt-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bill->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>₹{{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Bill Summary -->
            <div class="text-bill-list mb-15">
                <div class="text-bill-list-in">
                    <div class="text-bill-title">Sub-Total:</div>
                    <div class="text-bill-value">₹{{ number_format($bill->sub_total, 2) }}</div>
                </div>
                <div class="text-receipt-seperator"></div>

                @php
                    $groupedTaxes = $bill->items->groupBy('gst_slab')->map(function ($items, $gst_slab) {
                        $taxable = $items->sum('taxable_value');
                        $taxAmount = $items->sum('cgst') + $items->sum('sgst');
                        return [
                            'gst_slab' => $gst_slab,
                            'taxable' => $taxable,
                            'tax_amount' => $taxAmount,
                        ];
                    });
                @endphp

                @foreach ($groupedTaxes as $group)
                    <div class="text-bill-list-in">
                        <div class="text-bill-title"><strong>{{ $group['gst_slab'] }}% GST:</strong></div>
                        <div class="text-bill-value">₹{{ number_format($group['tax_amount'], 2) }}</div>
                    </div>
                @endforeach

                <div class="text-receipt-seperator"></div>
                <div class="text-bill-list-in">
                    <div class="text-bill-title">Total Bill:</div>
                    <div class="text-bill-value">₹{{ number_format($bill->total_amount, 2) }}</div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mb-10">
                <h4 class="mt-4 mb-2 text-title font-700 receipt-top">Thank you for shopping with us!</h4>
                <p class="text-center">Customer: {{ $bill->customer->name ?? 'Walk-In Customer' }}</p>
            </div>
        </div>
    </main>
</body>

</html>
