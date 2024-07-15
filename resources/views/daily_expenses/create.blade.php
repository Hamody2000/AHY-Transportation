@extends('layouts.app')

@section('content')
<div class="container">
    <h1>إضافة مصاريف جديدة</h1>
    <form action="{{ route('daily_expenses.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="amount">المبلغ</label>
            <input type="number" class="form-control" id="amount" name="amount" required>
        </div>
        <div class="form-group">
            <label for="date">التاريخ</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <div class="form-group">
            <label for="description">الوصف</label>
            <input type="text" class="form-control" id="description" name="description">
        </div>
        <div class="form-group">
            <label for="category">الفئة</label>
            <select class="form-control" id="category" name="category" required>
                <option value="" selected disabled>اختر الفئة</option>
                <option value="مصاريف يومية">مصاريف يومية</option>
                <option value="نثريات">نثريات</option>
                <option value="طوارئ">طوارئ</option>
                <option value="صيانة">صيانة</option>
                <option value="أخرى">أخرى</option>
                <option value="مرتبات">مرتبات</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">إضافة</button>
    </form>
</div>
@endsection
