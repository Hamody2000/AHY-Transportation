<!-- resources/views/client_revenues/create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>إضافة إيراد للعميل</h1>
    <form action="{{ route('client_revenues.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="client_id">العميل</label>
            <select class="form-control" id="client_id" name="client_id" required>
                <option value="" disabled selected>اختر عميل</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="date">التاريخ</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <div class="form-group">
            <label for="amount">المبلغ</label>
            <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
        </div>
        <div class="form-group">
            <label for="details">التفاصيل</label>
            <input type="text" class="form-control" id="details" name="details">
        </div>
        <button type="submit" class="btn btn-primary">حفظ</button>
    </form>
</div>
@endsection
