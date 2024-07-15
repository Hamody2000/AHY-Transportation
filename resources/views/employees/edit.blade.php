@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">تعديل موظف</h1>

    <form action="{{ route('employees.update', $employee->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">الاسم</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $employee->name }}" required>
        </div>
        <div class="form-group">
            <label for="phone">الهاتف</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ $employee->phone }}" required>
        </div>
        <div class="form-group">
            <label for="type">النوع</label>
            <select class="form-control" id="type" name="type" required>
                <option value="driver" {{ $employee->type == 'driver' ? 'selected' : '' }}>سائق</option>
                <option value="loader" {{ $employee->type == 'loader' ? 'selected' : '' }}>عامل تحميل</option>
                <option value="accountant" {{ $employee->type == 'accountant' ? 'selected' : '' }}>محاسب</option>
            </select>
        </div>
        <div class="form-group">
            <label for="salary">الراتب</label>
            <input type="number" class="form-control" id="salary" name="salary" value="{{ $employee->salary }}" required>
        </div>
        <button type="submit" class="btn btn-primary">تحديث</button>
    </form>
</div>
@endsection
