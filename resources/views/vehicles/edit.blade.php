@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">تعديل المركبة</h1>

    <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="license_plate">رقم اللوحة</label>
            <input type="text" class="form-control" id="license_plate" name="license_plate" value="{{ $vehicle->license_plate }}" required>
        </div>
        <div class="form-group">
            <label for="details">التفاصيل</label>
            <input type="text" class="form-control" id="details" name="details" value="{{ $vehicle->details }}">
        </div>
        <button type="submit" class="btn btn-primary">تحديث</button>
    </form>
</div>
@endsection
