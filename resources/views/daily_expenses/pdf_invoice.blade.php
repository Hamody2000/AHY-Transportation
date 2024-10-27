<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            direction: rtl;
            text-align: right;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 800px;
            /* Set a max-width for better readability */
            margin: 0 auto;
            padding: 10px;
        }

        h1,
        h2,
        h3 {
            text-align: center;
            /* font-size: 1.5rem;  */
        }

        p {
            font-size: 14px;
            line-height: 1.5;
        }

        .invoice-info {
            margin-bottom: 15px;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        .invoice-table th,
        .invoice-table td {
            padding: 8px;
            /* Reduce padding for smaller table cells */
            border: 1px solid #ddd;
            font-size: 12px;
            /* Reduce font size */
        }

        .invoice-table th {
            background-color: #4A90E2;
            color: white;
        }

        .invoice-table td {
            text-align: right;
        }

        /* Ensure the # column is aligned correctly on the right */
        .invoice-table th:first-child,
        .invoice-table td:first-child {
            text-align: center;
            width: 40px;
            /* Reduce column width */
        }

        /* Total Section */
        .total {
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
            text-align: center;
        }

        .total-in-words {
            font-size: 12px;
            text-align: center;
            margin-top: 5px;
            color: #555;
        }

        /* Print Button */
        .print-button {
            text-align: center;
            margin-top: 20px;
        }

        .print-button a {
            padding: 8px 20px;
            background-color: #4A90E2;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }

        /* Footer Section */
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #777;
            font-size: 12px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 5px;
            }

            .invoice-table th,
            .invoice-table td {
                padding: 5px;
                font-size: 10px;
            }

            h1,
            h2,
            h3 {
                font-size: 1.2rem;
            }

            .total {
                font-size: 14px;
            }

            .total-in-words {
                font-size: 10px;
            }

            .print-button a {
                font-size: 12px;
                padding: 5px 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header Section -->
        <h1>تقرير بالمصروفات</h1>
        <h2>لحساب: {{ $category ?? 'كل الفئات' }}</h2>
        <p>للفترة من {{ $startDate }} إلى {{ $endDate }}</p>
        <p>التاريخ: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>

        <!-- Expense Table -->
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>البيان</th>
                    <th>المبلغ</th>
                    <th>التاريخ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($expenses as $index => $expense)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $expense->description }}</td>
                        <td>{{ number_format($expense->amount ?? -$expense->income) }}</td>
                        <td>{{ $expense->date ? $expense->date->format('Y-m-d') : 'لا يوجد تاريخ' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Total Amount -->
        <div class="total">
            الإجمالي: {{ number_format($totalExpenses) }} جنيه
        </div>

        <!-- Total in Words -->
        <div class="total-in-words">
            {{ $totalInWords }} جنيه مصري فقط لا غير.
        </div>

        <!-- Print Button: only show when not generating a PDF -->
        @if (!request()->is('daily-expenses/invoice*'))
            <div class="print-button">
                <a href="{{ route('daily_expenses.invoice', ['start_date' => request('start_date'), 'end_date' => request('end_date'), 'category' => $category]) }}"
                    class="btn btn-primary">
                    طباعة
                </a>
            </div>
        @endif

        <!-- Footer Section -->
        <div class="footer">
            <p>شركة AHY</p>
        </div>
    </div>
</body>

</html>
