@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">إضافة موظف جديد</h1>

    <form action="{{ route('employees.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">الاسم</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="phone">الهاتف</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="form-group">
            <label for="type">النوع</label>
            <select class="form-control" id="type" name="type" required>
                <option value="" selected disabled>اختر النوع</option>
                <option value="driver">سائق</option>
                <option value="loader">عامل تحميل</option>
                <option value="accountant">محاسب</option>
            </select>
        </div>
        <div class="form-group">
            <label for="salary">الراتب</label>
            <input type="number" class="form-control" id="salary" name="salary" required>
        </div>
        <button type="submit" class="btn btn-primary">حفظ</button>
    </form>
</div>
@endsection
