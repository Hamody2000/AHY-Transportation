@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">إضافة سلفة</h1>

        <form action="{{ route('loans.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="employee_id">الموظف</label>
                <select class="form-control" id="employee_id" name="employee_id" required>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="amount">المبلغ</label>
                <input type="number" class="form-control" id="amount" name="amount" required>
            </div>
            <div class="form-group">
                <label for="loan_date">تاريخ السلفة</label>
                <input type="date" class="form-control" id="loan_date" name="loan_date" required>
            </div>
            <div class="form-group">
                <label for="comment">تعليق (اختياري)</label>
                <textarea class="form-control" id="comment" name="comment"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">حفظ</button>
        </form>
    </div>
@endsection
