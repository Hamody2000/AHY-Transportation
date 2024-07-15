@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">تعديل عملية الشركة</h1>

    <form action="{{ route('company_transactions.update', $transaction->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Client Selection -->
        <div class="form-group">
            <label for="client_id">العميل</label>
            <select class="form-control" id="client_id" name="client_id" required>
                <option value="" disabled selected>اختر العميل</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}" {{ $transaction->client_id == $client->id ? 'selected' : '' }}>
                        {{ $client->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Date -->
        <div class="form-group">
            <label for="date">التاريخ</label>
            <input type="date" class="form-control" id="date" name="date"
                value="{{ $transaction->date->format('Y-m-d') }}" required>
        </div>

        <!-- Total Received -->
        <div class="form-group">
            <label for="total_received">وارد منه</label>
            <input type="number" class="form-control" id="total_received" name="total_received"
                value="{{ $transaction->total_received }}">
        </div>

        <!-- Pricing and Charges -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="price_per_ton">سعر الطن</label>
                <input type="number" class="form-control" id="price_per_ton" name="price_per_ton"
                    value="{{ $transaction->price_per_ton }}" required>
            </div>
            <div class="form-group col-md-6">
                <label for="tonnage">الحمولة</label>
                <input type="number" class="form-control" id="tonnage" name="tonnage"
                    value="{{ $transaction->tonnage }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="detention">التعتيق</label>
                <input type="number" class="form-control" id="detention" name="detention"
                    value="{{ $transaction->detention }}" required>
            </div>
            <div class="form-group col-md-6">
                <label for="loading">التحميل</label>
                <input type="number" class="form-control" id="loading" name="loading"
                    value="{{ $transaction->loading }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="transfer">التحويل</label>
                <input type="number" class="form-control" id="transfer" name="transfer"
                    value="{{ $transaction->transfer }}" required>
            </div>
            <div class="form-group col-md-6">
                <label for="overnight_stay">الإقامة الليلية</label>
                <input type="number" class="form-control" id="overnight_stay" name="overnight_stay"
                    value="{{ $transaction->overnight_stay }}">
            </div>
        </div>

        <!-- Locations -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="location_from">من</label>
                <input type="text" class="form-control" id="location_from" name="location_from"
                    value="{{ $transaction->location_from }}" required>
            </div>
            <div class="form-group col-md-6">
                <label for="location_to">إلى</label>
                <input type="text" class="form-control" id="location_to" name="location_to"
                    value="{{ $transaction->location_to }}" required>
            </div>
        </div>

        <!-- Total -->
        <div class="form-group">
            <label for="total">الإجمالي</label>
            <input type="number" class="form-control" id="total" name="total"
                value="{{ $transaction->total }}" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">تحديث</button>
    </form>
</div>
@endsection
