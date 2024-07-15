@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">معاملات الأفراد</h1>
    <a href="{{ route('individual_transactions.create') }}" class="btn btn-primary mb-3">إضافة معاملة فردية</a>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>اسم العميل</th>
                    <th>التاريخ</th>
                    <th>من</th>
                    <th>إلى</th>
                    <th>النولون</th>
                    <th>المبيت</th>
                    <th>اسم المندوب</th>
                    <th>العمولة</th>
                    <th>التحميل</th>
                    <th>التعتيق</th>
                    <th>إجمالي المستلم</th>
                    <th>إجمالي المنصرف</th>
                    <th>المتبقي له</th>
                    <th>المتبقي عليه</th>
                    <th>تفاصيل المنصرف</th>
                    <th>الإكرامية</th>
                    <th>باقي النولون</th>
                    <th>العهدة</th>
                    <th>اسم السائق</th>
                    <th>رقم لوحة المركبة</th>
                    <th>عدد أيام الحمولة مع العميل</th>
                    <th>عدد أيام الحمولة مع المركبة</th>
                    <th>عدد أيام المبيت</th>
                    <th>سعر المبيت مع العميل</th>
                    <th>سعر المبيت مع المركبة</th>
                    <th>صافي المبيت</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->client->name }}</td>
                    <td>{{ $transaction->date->format('Y-m-d') }}</td>
                    <td>{{ $transaction->location_from }}</td>
                    <td>{{ $transaction->location_to }}</td>
                    <td>{{ number_format($transaction->fare) }} جنيه</td>
                    <td>{{ number_format($transaction->overnight_stay) }} جنيه</td>
                    <td>{{ $transaction->representative_name }}</td>
                    <td>{{ number_format($transaction->commission) }} جنيه</td>
                    <td>{{ number_format($transaction->loading) }} جنيه</td>
                    <td>{{ number_format($transaction->detention) }} جنيه</td>
                    <td>{{ number_format($transaction->total_received) }} جنيه</td>
                    <td>{{ number_format($transaction->total_spent) }} جنيه</td>
                    <td>{{ number_format($transaction->remaining_for_client) }} جنيه</td>
                    <td>{{ number_format($transaction->remaining_from_client) }} جنيه</td>
                    <td>{{ $transaction->spend_details }}</td>
                    <td>{{ number_format($transaction->tip) }} جنيه</td>
                    <td>{{ number_format($transaction->remaining_fare) }} جنيه</td>
                    <td>{{ number_format($transaction->advance) }} جنيه</td>
                    <td>{{ $transaction->driver_name }}</td>
                    <td>{{ $transaction->vehicle_plate_number }}</td>
                    <td>{{ $transaction->agreed_days_with_client }}</td>
                    <td>{{ $transaction->agreed_days_with_vehicle }}</td>
                    <td>{{ $transaction->overnight_days }}</td>
                    <td>{{ number_format($transaction->overnight_price_with_client) }} جنيه</td>
                    <td>{{ number_format($transaction->overnight_price_with_vehicle) }} جنيه</td>
                    <td>{{ number_format($transaction->net_overnight) }} جنيه</td>
                    <td>
                        <a href="{{ route('individual_transactions.edit', $transaction->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                        <a href="{{ route('invoices.individual', ['id' => $transaction->id]) }}" class="btn btn-primary btn-sm">طباعة فاتورة</a>
                        <form action="{{ route('individual_transactions.destroy', $transaction->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
