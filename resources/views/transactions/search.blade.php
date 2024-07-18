@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>البحث عن المعاملات</h1>

        <!-- نموذج البحث -->
        <form action="{{ route('transactions.search') }}" method="GET">
            <div class="form-group">
                <label for="start_date">تاريخ البداية</label>
                <input type="date" name="start_date" id="start_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="end_date">تاريخ النهاية</label>
                <input type="date" name="end_date" id="end_date" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">بحث</button>
        </form>

        @if (isset($transactions) && $transactions->count())
            <h2>المعاملات بتاريخ {{ $startDate }} to {{ $endDate }}</h2>
            <p>اجمالي العمولة: {{ number_format($totalCommission) }} جنيه</p>
            <table class="table">
                <thead>
                    <tr>
                        <th>التاريخ</th>
                        <th>اسم العميل</th>
                        <th>وارد منه</th>
                        <th>النولون</th>
                        <th>الإقامة الليلية</th>
                        <th>التحميل</th>
                        <th>التعتيق</th>
                        <th>الحمولة</th>
                        <th>العمولة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->date->format('Y-m-d') }}</td>
                            <td>{{ $transaction->client->name }}</td>
                            <td>{{ number_format($transaction->total_received) }} جنيه</td>
                            <td>{{ number_format($transaction->fare ?? 0, 0) }} جنيه</td>
                            <td>{{ number_format($transaction->overnight_stay ?? 0, 0) }} جنيه</td>
                            <td>{{ number_format($transaction->loading ?? 0, 0) }} جنيه</td>
                            <td>{{ number_format($transaction->detention ?? 0, 0) }} جنيه</td>
                            <td>{{ number_format($transaction->tonnage ?? 0, 0) }} طن</td>
                            <td>{{ number_format($transaction->commission ?? 0, 0) }} جنيه</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>لم يتم العثور على معاملات لهذا التاريخ.</p>
        @endif
    </div>
@endsection
