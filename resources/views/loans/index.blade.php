@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">السلفة</h1>
    <a href="{{ route('loans.create') }}" class="btn btn-primary mb-3">إضافة سلفة</a>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>الموظف</th>
                    <th>المبلغ</th>
                    <th>تاريخ السلفة</th>
                    <th>التعليق</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loans as $loan)
                <tr>
                    <td>{{ $loan->employee->name }}</td>
                    <td>{{ number_format($loan->amount) }} جنيه</td>
                    <td>{{ $loan->loan_date->format('Y-m-d') }}</td>
                    <td>{{ $loan->comment }}</td>
                    <td>
                        <a href="{{ route('loans.edit', $loan->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                        <form action="{{ route('loans.destroy', $loan->id) }}" method="POST" style="display:inline;">
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
    <div class="mt-4">
        {{ $loans->links() }}
    </div>
</div>
@endsection
