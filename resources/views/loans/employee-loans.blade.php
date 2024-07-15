@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">تاريخ السلف لـ {{ $employee->name }}</h1>

    <a href="{{ route('employees.index') }}" class="btn btn-secondary mb-3">العودة إلى الموظفين</a>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>المبلغ</th>
                    <th>التاريخ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($loans as $loan)
                <tr>
                    <td>{{ $loan->id }}</td>
                    <td>{{ number_format($loan->amount) }} جنيه</td>
                    <td>{{ $loan->loan_date->format('Y-m-d') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">لم يتم العثور على سلف لهذا الموظف.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $loans->links() }}
    </div>
</div>
@endsection
