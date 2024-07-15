@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">إضافة عملية شركة</h1>

        <form action="{{ route('company_transactions.store') }}" method="POST">
            @csrf

            <!-- Client Selection -->
            <div class="form-group">
                <label for="client_id">العميل</label>
                <select class="form-control" id="client_id" name="client_id" required>
                    <option value="" disabled selected>اختر العميل</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Date -->
            <div class="form-group">
                <label for="date">التاريخ</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>

            <!-- Total Received -->
            <div class="form-group">
                <label for="total_received">وارد منه</label>
                <input type="number" class="form-control" id="total_received" name="total_received">
            </div>

            <!-- Pricing and Charges -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="price_per_ton">سعر الطن مع الشركة</label>
                    <input type="number" class="form-control" id="price_per_ton" name="price_per_ton" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="price_per_ton_car">سعر الطن مع العربية</label>
                    <input type="number" class="form-control" id="price_per_ton_car" name="price_per_ton_car">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="detention">التعتيق</label>
                    <input type="number" class="form-control" id="detention" name="detention">
                </div>
                <div class="form-group col-md-6">
                    <label for="loading">التحميل</label>
                    <input type="number" class="form-control" id="loading" name="loading">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="transfer">التحويل</label>
                    <input type="number" class="form-control" id="transfer" name="transfer">
                </div>
                <div class="form-group col-md-6">
                    <label for="overnight_stay">المبيت</label>
                    <input type="number" class="form-control" id="overnight_stay" name="overnight_stay">
                </div>
            </div>

            <!-- Tonnage and Weight -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="tonnage">عدد الطن</label>
                    <input type="number" class="form-control" id="tonnage" name="tonnage" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="weight">الميزان</label>
                    <input type="number" class="form-control" id="weight" name="weight">
                </div>
            </div>

            <!-- Driver and Vehicle -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="driver_id">السائق</label>
                    <select class="form-control" id="driver_id" name="driver_id">
                        <option value="" disabled selected>اختر السائق</option>
                        @foreach ($drivers as $driver)
                            <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="vehicle_id">السيارة</label>
                    <select class="form-control" id="vehicle_id" name="vehicle_id">
                        <option value="" disabled selected>اختر السيارة</option>
                        @foreach ($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}">{{ $vehicle->license_plate }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Locations -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="location_from">من</label>
                    <input type="text" class="form-control" id="location_from" name="location_from" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="location_to">إلى</label>
                    <input type="text" class="form-control" id="location_to" name="location_to" required>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary mt-4 mb-4 col-md-12">إضافة</button>
        </form>
    </div>
@endsection
