<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $bill->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }
        .header, .footer {
            text-align: center;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
        }
        .items-table th, .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .items-table th {
            background-color: #f2f2f2;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <h1>DreamCoderZ</h1>
            <p>2/104 Ganapany Maanagar, Paapampatti, Coimbatore - 641016</p>
            <p>Mobile: 6379108040, 9600673035 | Email: admin@dreamcoderz.com</p>
        </div>

        <h2>Invoice</h2>
        <p><strong>Invoice ID:</strong> {{ $bill->id }}</p>
        <p><strong>Date:</strong> {{ $bill->created_at->format('d-m-Y') }}</p>
        <p><strong>Customer Name:</strong> {{ $bill->customer->name ?? 'Walk-In Customer' }}</p>
        <p><strong>Mobile:</strong> {{ $bill->customer->mobile ?? '-' }}</p>

        <table class="items-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>HSN Code</th>
                    <th>GST %</th>
                    <th>Qty</th>
                    <th>Price (Incl. Tax)</th>
                    <th>Taxable Value</th>
                    <th>CGST</th>
                    <th>SGST</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bill->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->product->name_tamil }}</td>
                        <td>{{ $item->product->hsn_code }}</td>
                        <td>{{ $item->gst_slab }}%</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price, 2) }}</td>
                        <td>{{ number_format($item->taxable_value, 2) }}</td>
                        <td>{{ number_format($item->cgst, 2) }}</td>
                        <td>{{ number_format($item->sgst, 2) }}</td>
                        <td>{{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Total: ₹{{ number_format($bill->final_amount, 2) }}</h3>

        <div class="footer">
            <p>Thank you for your business!</p>
        </div>
    </div>
</body>
</html>
