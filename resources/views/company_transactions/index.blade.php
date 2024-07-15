@extends('layouts.app')

@section('content')
    <h1 class="mb-4">معاملات الشركات</h1>
    <a href="{{ route('company_transactions.create') }}" class="btn btn-primary mb-3">إضافة معاملة شركة</a>

    <div class="table-responsive">
        <table class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                    <th>التاريخ</th>
                    <th>اسم العميل</th>
                    <th>وارد منه</th>
                    <th>سعر الطن</th>
                    <th>عدد الأطنان</th>
                    <th>الميزان</th>
                    <th>المبيت</th>
                    <th>التحميل</th>
                    <th>التعتيق</th>
                    <th>التحويل</th>
                    <th>العمولة</th>
                    <th>من</th>
                    <th>إلى</th>
                    <th>الإجمالي</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->date->format('Y-m-d') }}</td>
                        <td>{{ $transaction->client->name ?? 'غير متوفر' }}</td>
                        <td>{{ number_format($transaction->total_received) }} جنيه</td>
                        <td>{{ number_format($transaction->price_per_ton) }} جنيه</td>
                        <td>{{ $transaction->tonnage }}</td>
                        <td>{{ number_format($transaction->weight) }} جنيه</td>
                        <td>{{ number_format($transaction->overnight_stay) }} جنيه</td>
                        <td>{{ number_format($transaction->loading) }} جنيه</td>
                        <td>{{ number_format($transaction->detention) }} جنيه</td>
                        <td>{{ number_format($transaction->transfer) }} جنيه</td>
                        <td>{{ number_format($transaction->commission) }} جنيه</td>
                        <td>{{ $transaction->location_from }}</td>
                        <td>{{ $transaction->location_to }}</td>
                        <td>{{ number_format($transaction->total) }} جنيه</td>
                        {{-- <td>
                        <a href="{{ route('company_transactions.edit', $transaction->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                        <a href="{{ route('invoices.company', ['id' => $transaction->id]) }}" class="btn btn-primary btn-sm">طباعة</a>
                        <form action="{{ route('company_transactions.destroy', $transaction->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                        </form>
                    </td> --}}
                        <td class="text-center">
                            <!-- Button Group -->
                            <div class="btn-group" role="group" aria-label="Actions">
                                <!-- Print Button -->
                                <a href="{{ route('invoices.company', ['id' => $transaction->id]) }}"
                                    class="btn btn-secondary btn-sm mx-1" title="طباعة">
                                    <i class="fas fa-print"></i> طباعة
                                </a>
                                <!-- Delete Button -->
                                <form action="{{ route('company_transactions.destroy', $transaction->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mx-1" title="إزالة"
                                        onclick="return confirm('هل أنت متأكد أنك تريد حذف هذه المعاملة؟')">
                                        <i class="fas fa-trash-alt"></i> إزالة
                                    </button>
                                </form>
                                <!-- Edit Button -->
                                <a href="{{ route('company_transactions.edit', $transaction->id) }}"
                                    class="btn btn-warning btn-sm mx-1" title="تعديل">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $transactions->links() }}
    </div>
@endsection
