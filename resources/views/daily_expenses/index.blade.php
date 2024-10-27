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
                    <label for="category" class="form-label">الفئة</label>
                    <select class="form-control" id="category" name="category">
                        <option value="" selected>كل الفئات</option>
                        <option value="مصاريف يومية" {{ $selectedCategory == 'مصاريف يومية' ? 'selected' : '' }}>مصاريف يومية</option>
                        <option value="نثريات" {{ $selectedCategory == 'نثريات' ? 'selected' : '' }}>نثريات</option>
                        <option value="طوارئ" {{ $selectedCategory == 'طوارئ' ? 'selected' : '' }}>طوارئ</option>
                        <option value="صيانة" {{ $selectedCategory == 'صيانة' ? 'selected' : '' }}>صيانة</option>
                        <option value="سيارات" {{ $selectedCategory == 'سيارات' ? 'selected' : '' }}>سيارات</option>
                        <option value="مرتبات" {{ $selectedCategory == 'مرتبات' ? 'selected' : '' }}>مرتبات</option>
                        <option value="أخرى" {{ $selectedCategory == 'أخرى' ? 'selected' : '' }}>أخرى</option>
                    </select>
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
                                <td>
                                    <a href="{{ route('daily_expenses.search', ['start_date' => request('start_date'), 'end_date' => request('end_date'), 'category' => $expense->category]) }}">
                                        {{ $expense->category }}
                                    </a>

                                </td>
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
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($daily_expenses as $expense)
                            <tr>
                                <td>{{ $expense->date ? $expense->date->format('Y-m-d') : 'لا يوجد تاريخ' }}</td>
                                <td>{{ $expense->category }}</td>
                                <td>{{ $expense->description }}</td>
                                <td>
                                    @if (($expense->amount != 0 ))
                                        {{ number_format($expense->amount) }} جنيه
                                        @else
                                        {{ number_format(-$expense->income) }} جنيه
                                    @endif
                                </td>
                                <td>
                                    <!-- Delete Form -->
                                    <form action="{{ route('daily_expenses.destroy', $expense->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من أنك تريد حذف هذه المصروفات؟');">
                                        @csrf
                                        @method('DELETE') <!-- Set the form method to DELETE -->
                                        <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                    </form>
                                </td>
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
