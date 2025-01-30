<div class="print-area">

    <div class="receipt">
        <h2 class="text-center">Sales Report</h2>
        <p class="text-center">{{ now()->format('d M Y') }}</p>
        <hr>

        <table>
            <thead>
                <tr>
                    <th class="left">Customer</th>
                    <th class="right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($todayBills as $bill)
                    <tr>
                        <td class="left">{{ $bill->customer->name ?? 'Walk-in Customer' }}</td>
                        <td class="right">₹{{ number_format($bill->final_amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <hr>
        <p class="text-center">Thank You!</p>
    </div>

    <button onclick="printReceipt()" class="print-btn">Print Report</button>

    <script>
        function printReceipt() {
            window.print();
        }
    </script>

    <style>
        .print-area {
            width: 76mm;
            padding: 10px;
            font-family: Arial, sans-serif;
        }

        .receipt {
            text-align: center;
        }

        h2 {
            font-size: 16px;
            margin: 5px 0;
        }

        table {
            width: 100%;
            font-size: 14px;
        }

        .left {
            text-align: left;
        }

        .right {
            text-align: right;
        }

        hr {
            border: 0;
            border-top: 1px dashed black;
            margin: 5px 0;
        }

        .print-btn {
            display: block;
            width: 100%;
            margin-top: 10px;
            padding: 8px;
            background-color: #000;
            color: white;
            border: none;
            cursor: pointer;
        }

        @media print {
            .print-btn {
                display: none;
            }
        }
    </style>

</div>
