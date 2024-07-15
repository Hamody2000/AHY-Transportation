@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">تعديل السلفة</h1>

    <form action="{{ route('loans.update', $loan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="employee_id">الموظف</label>
            <select class="form-control" id="employee_id" name="employee_id" required>
                @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}" {{ $employee->id == $loan->employee_id ? 'selected' : '' }}>
                        {{ $employee->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="amount">المبلغ</label>
            <input type="number" class="form-control" id="amount" name="amount"
                value="{{ $loan->amount }}" required>
        </div>
        <div class="form-group">
            <label for="loan_date">تاريخ السلفة</label>
            <input type="date" class="form-control" id="loan_date" name="loan_date"
                value="{{ $loan->loan_date->format('Y-m-d') }}" required>
        </div>
        <button type="submit" class="btn btn-primary">تحديث</button>
    </form>
</div>
@endsection
