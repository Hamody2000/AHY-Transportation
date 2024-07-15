@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Add Salary</h1>

        <form action="{{ route('salaries.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="employee_id">Employee</label>
                <select class="form-control" id="employee_id" name="employee_id" required>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" step="1" class="form-control" id="amount" name="amount" required>
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
