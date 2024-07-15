@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Salaries</h1>
    <a href="{{ route('salaries.create') }}" class="btn btn-primary mb-3">Add Salary</a>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Employee</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salaries as $salary)
            <tr>
                <td>{{ $salary->id }}</td>
                <td>{{ $salary->employee->name }}</td>
                <td>${{ number_format($salary->amount) }}</td>
                <td>{{ $salary->date->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('salaries.edit', $salary->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('salaries.destroy', $salary->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
