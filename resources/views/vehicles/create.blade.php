@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">إضافة مركبة جديدة</h1>

    <form action="{{ route('vehicles.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="license_plate">رقم اللوحة</label>
            <input type="text" class="form-control" id="license_plate" name="license_plate" required>
        </div>
        <div class="form-group">
            <label for="details">التفاصيل</label>
            <input type="text" class="form-control" id="details" name="details">
        </div>
        <button type="submit" class="btn btn-primary">حفظ</button>
    </form>
</div>
@endsection
