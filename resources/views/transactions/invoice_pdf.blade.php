<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice PDF</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            direction: rtl; /* Set direction to RTL */
            text-align: right; /* Align text to the right */
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .invoice-table th,
        .invoice-table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .invoice-table th {
            background-color: #4A90E2;
            color: white;
        }

        .total {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>فاتورة</h1>
            <p>العميل: {{ $client->name }}</p>
            <p>التاريخ: {{ \Carbon\Carbon::now()->format('Y-m-d') }}</p>
        </div>

        @if($client->type === 'individual')

            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>التاريخ</th>
                        <th>النولون</th>
                        <th>المبيت</th>
                        <th>العمولة</th>
                        <th>التحميل</th>
                        <th>التعتيق</th>
                        <th>الاجمالي</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($client->individualTransactions()->whereIn('id', request('transaction_ids'))->get() as $index => $transaction)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $transaction->date->format('Y-m-d') }}</td>
                            <td>{{ number_format($transaction->fare) }} ج.م</td>
                            <td>{{ number_format($transaction->overnight_stay) }} ج.م</td>
                            <td>{{ number_format($transaction->commission) }} ج.م</td>
                            <td>{{ number_format($transaction->loading) }} ج.م</td>
                            <td>{{ number_format($transaction->detention) }} ج.م</td>
                            <td>{{ number_format($transaction->TotalSpent) }} ج.م</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @elseif($client->type === 'company')

            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>التاريخ</th>
                        <th>سعر الطن</th>
                        <th>الوزن</th>
                        <th>المبيت</th>
                        <th>الإجمالي</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($client->companyTransactions()->whereIn('id', request('transaction_ids'))->get() as $index => $transaction)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $transaction->date->format('Y-m-d') }}</td>
                            <td>{{ number_format($transaction->price_per_ton) }} ج.م</td>
                            <td>{{ number_format($transaction->tonnage) }} طن</td>
                            <td>{{ number_format($transaction->overnight_stay) }} ج.م</td>
                            <td>{{ number_format($transaction->TotalSpent) }} ج.م</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>لم يتم العثور على معاملات لهذا النوع من العملاء.</p>
        @endif

        <div class="total">
            الإجمالي: {{ number_format($totalAmount) }} ج.م
        </div>
    </div>
</body>
</html>
