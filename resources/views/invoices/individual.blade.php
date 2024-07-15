<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاتورة التعامل مع الأفراد</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        @media print {
            .print-button {
                display: none;
            }
        }

        body {
            direction: rtl;
            text-align: right;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .invoice-container {
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 8px;
            max-width: 800px;
            margin: 20px auto;
            background-color: #ffffff;
        }

        .invoice-header {
            position: relative;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 2px solid #007bff;
            /* Blue border for header */
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .company-info {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .company-info .info {
            text-align: right;
            font-size: 16px;
            margin-right: 20px;
            Space between logo and text
        }

        .company-info img {
            max-width: 150px;
            height: auto;
        }

        .invoice-header h1 {
            font-size: 24px;
            margin: 0;
            text-align: center;
        }

        .invoice-header p {
            margin: 0;
            font-size: 16px;
            text-align: center;
        }

        .invoice-details {
            margin-bottom: 20px;
        }

        .invoice-details table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .invoice-details th,
        .invoice-details td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: right;
        }

        .invoice-details th {
            background-color: #f4f4f4;
            text-align: right;
            width: 30%;
        }

        .invoice-details td {
            text-align: right;
            width: 70%;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }

        .footer p {
            margin: 5px 0;
        }

        .print-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <!-- Invoice Header -->
        <div class="invoice-header">
            <!-- Company Information -->
            <div class="company-info">
                <img src="{{ asset('img/logo.png') }}" alt="Company Logo">
                <div class="info">
                    {{-- <h2 style="text-align: center; color:#301d66">HAY</h2> --}}
                    <p style="text-align: right">العنوان: العاشر من رمضان - ش 4 - عمارة 121 - الحي العاشر</p>
                    <p style="text-align: right">التليفون: 01025361300</p>
                    <p style="text-align: right">أ / حماده فوزي محمد</p>
                </div>
            </div>
        </div>
        <!-- Invoice Title -->
        <div class="invoice-title">
            <h1>فاتورة</h1>
            <p>التاريخ: {{ $transaction->date->format('Y-m-d') }}</p>
        </div>

        <!-- Invoice Details -->
        <div class="invoice-details">
            <table>
                <tbody>
                    @if ($transaction->client->name)
                        <tr>
                            <th>اسم العميل</th>
                            <td>{{ $transaction->client->name }}</td>
                        </tr>
                    @endif
                    @if ($transaction->location_from)
                        <tr>
                            <th>المكان من</th>
                            <td>{{ $transaction->location_from }}</td>
                        </tr>
                    @endif
                    @if ($transaction->location_to)
                        <tr>
                            <th>المكان إلى</th>
                            <td>{{ $transaction->location_to }}</td>
                        </tr>
                    @endif
                    @if ($transaction->fare > 0)
                        <tr>
                            <th>النولون</th>
                            <td>{{ number_format($transaction->fare) }} جنيه</td>
                        </tr>
                    @endif
                    @if ($transaction->OvernightForClient > 0)
                        <tr>
                            <th>مبيت</th>
                            <td>{{ number_format($transaction->OvernightForClient) }} جنيه</td>
                        </tr>
                    @endif
              
                    @if ($transaction->transfer > 0)
                        <tr>
                            <th>التحويل </th>
                            <td>{{ $transaction->transfer }}</td>
                        </tr>
                    @endif

                    @if ($transaction->loading > 0)
                        <tr>
                            <th>تحميل</th>
                            <td>{{ number_format($transaction->loading) }} جنيه</td>
                        </tr>
                    @endif
                    @if ($transaction->detention > 0)
                        <tr>
                            <th>تعتيق</th>
                            <td>{{ number_format($transaction->detention) }} جنيه</td>
                        </tr>
                    @endif
                    @if ($transaction->spends)
                        @foreach ($transaction->spends as $spend)
                            <tr>
                                <th>{{ $spend->spend_details }}</th>
                                <td>{{ number_format($spend->value) }} جنيه</td>
                            </tr>
                        @endforeach
                    @endif
                    @if ($transaction->total_spent > 0)
                        <tr>
                            <th>الاجمالي</th>
                            <td>{{ number_format($transaction->total_spent) }} جنيه</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Action Button -->
        <button class="print-button" onclick="window.print()">طباعة الفاتورة</button>
    </div>
</body>

</html>
