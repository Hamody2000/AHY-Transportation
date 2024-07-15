@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">إضافة عميل جديد</h1>

    <form action="{{ route('clients.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">الاسم</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="type">النوع</label>
            <select class="form-control" id="type" name="type" required>
                <option value="" disabled selected>اختيار نوع العميل</option>
                <option value="individual">أفراد</option>
                <option value="company">شركات</option>
            </select>
        </div>
        <div class="form-group">
            <label for="phone">رقم التليفون</label>
            <input type="text" class="form-control" id="phone" name="phone">
        </div>
        <button type="submit" class="btn btn-primary">حفظ</button>
    </form>
</div>
@endsection
