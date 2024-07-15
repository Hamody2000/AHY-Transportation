@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Edit Salary</h1>

        <form action="{{ route('salaries.update', $salary->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="employee_id">Employee</label>
                <select class="form-control" id="employee_id" name="employee_id" required>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}" {{ $employee->id == $salary->employee_id ? 'selected' : '' }}>
                            {{ $employee->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" step="1" class="form-control" id="amount" name="amount"
                    value="{{ $salary->amount }}" required>
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" id="date" name="date"
                    value="{{ $salary->date->format('Y-m-d') }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
