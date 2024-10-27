@extends('layouts.app')

@section('content')
<div class="container">
    <h1>المعاملات للعميل: {{ $client->name }}</h1>

    @if($client->type === 'individual')
        <h2>المعاملات الفردية</h2>
        <form action="{{ route('transactions.generate_invoice', $client->id) }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>اختيار</th>
                            <th>التاريخ</th>
                            <th>النولون</th>
                            <th>المبيت</th>
                            <th>العمولة</th>
                            <th>التحميل</th>
                            <th>التعتيق</th>
                            <th> الاجمالي </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($client->individualTransactions as $transaction)
                        <tr>
                            <td>
                                <input type="checkbox" name="transaction_ids[]" value="{{ $transaction->id }}">
                            </td>

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
                   <!-- Pagination links for individual transactions -->
            {{ $individualTransactions->links() }}
            </div>
            <button type="submit" class="btn btn-primary">إنشاء الفاتورة</button>
        </form>

    @elseif($client->type === 'company')
        <h2>المعاملات للشركات</h2>
        <form action="{{ route('transactions.generate_invoice', $client->id) }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>اختيار</th>
                            <th>التاريخ</th>
                            <th>سعر الطن</th>
                            <th>الوزن</th>
                            <th>المبيت</th>
                            <th>الإجمالي</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($client->companyTransactions as $transaction)
                        <tr>
                            <td>
                                <input type="checkbox" name="transaction_ids[]" value="{{ $transaction->id }}">
                            </td>
                            <td>{{ $transaction->date->format('Y-m-d') }}</td>
                            <td>{{ number_format($transaction->price_per_ton) }} ج.م</td>
                            <td>{{ number_format($transaction->tonnage) }} طن</td>
                            <td>{{ number_format($transaction->overnight_stay) }} ج.م</td>
                            <td>{{ number_format($transaction->total) }} ج.م</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                   <!-- Pagination links for company transactions -->
            {{ $companyTransactions->links() }}
            </div>
            <button type="submit" class="btn btn-primary">إنشاء الفاتورة</button>
        </form>

    @else
        <p>لم يتم العثور على معاملات لهذا النوع من العملاء.</p>
    @endif
</div>
@endsection
