<!-- resources/views/client_revenues/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>إيرادات العملاء</h1>
    <a href="{{ route('client_revenues.create') }}" class="btn btn-primary mb-3">إضافة إيراد</a>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>التاريخ</th>
                <th>اسم العميل</th>
                <th>المبلغ</th>
                <th>التفاصيل</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($revenues as $revenue)
            <tr>
                <td>{{ $revenue->date->format('Y-m-d') }}</td>
                <td>{{ $revenue->client->name }}</td>
                <td>{{ number_format($revenue->amount, 2) }} جنيه</td>
                <td>{{ $revenue->details }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
