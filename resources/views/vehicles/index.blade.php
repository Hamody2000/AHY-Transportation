@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">المركبات</h1>
    <a href="{{ route('vehicles.create') }}" class="btn btn-primary mb-3">إضافة مركبة جديدة</a>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>رقم اللوحة</th>
                    <th>التفاصيل</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vehicles as $vehicle)
                <tr>
                    <td>{{ $vehicle->id }}</td>
                    <td>{{ $vehicle->license_plate }}</td>
                    <td>{{ $vehicle->details }}</td>
                    <td>
                        <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                        <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" style="display:inline;">
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
</div>
@endsection
