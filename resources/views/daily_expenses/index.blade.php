@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">المصاريف اليومية</h1>

        <!-- Search Form -->
        <form method="GET" action="{{ route('daily_expenses.index') }}" class="mb-4">
            <div class="row align-items-end">
                <div class="col-md-4 mb-3">
                    <label for="start_date" class="form-label">تاريخ البداية</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="end_date" class="form-label">تاريخ النهاية</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <button type="submit" class="btn btn-primary w-100">بحث</button>
                </div>
            </div>
        </form>

        <!-- Total Expenses -->
        <div class="mb-4">
            <h2>اجمالي المصاريف</h2>
            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>الفئة</th>
                            <th>إجمالي المصاريف</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expenses as $expense)
                            <tr>
                                <td>{{ $expense->category }}</td>
                                <td>{{ number_format($expense->total_amount) }} جنيه</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><strong>الإجمالي</strong></td>
                            <td><strong>{{ number_format($totalExpenses) }} جنيه</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Daily Expenses Details -->
        <div class="mb-4">
            <h2 class="mb-4">تفاصيل المصاريف</h2>
            <a href="{{ route('daily_expenses.create') }}" class="btn btn-primary mb-3">إضافة مصاريف</a>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>التاريخ</th>
                            <th>الفئة</th>
                            <th>تعليق</th>
                            <th>المبلغ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($daily_expenses as $expense)
                            <tr>
                                <td>{{ $expense->date ? $expense->date->format('Y-m-d') : 'لا يوجد تاريخ' }}</td>
                                <td>{{ $expense->category }}</td>
                                <td>{{ $expense->description }}</td>
                                <td>{{ number_format($expense->amount) }} جنيه</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $daily_expenses->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
