@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">تعديل عميل</h1>

    <form action="{{ route('clients.update', $client->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">الاسم</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $client->name }}" required>
        </div>
        <div class="form-group">
            <label for="type">النوع</label>
            <select class="form-control" id="type" name="type" required >
                <option value="" disabled>اختيار نوع العميل</option>
                <option value="individual">أفراد</option>
                <option value="company">شركات</option>
            </select>
        </div>
        <div class="form-group">
            <label for="phone">الهاتف</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ $client->phone }}">
        </div>
        <button type="submit" class="btn btn-primary">تحديث</button>
    </form>
</div>
@endsection
