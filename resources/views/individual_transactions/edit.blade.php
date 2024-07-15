@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">تعديل معاملة</h1>

        <form action="{{ route('individual_transactions.update', $transaction->id) }}" method="POST">
            @csrf
            @method('PUT')
            <!-- Form Fields -->
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="client_id">العميل</label>
                    <select class="form-control" id="client_id" name="client_id" required>
                        <option value="" disabled>اختر العميل</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}" {{ $transaction->client_id == $client->id ? 'selected' : '' }}>
                                {{ $client->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="date">التاريخ</label>
                    <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $transaction->date->format('Y-m-d')) }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="total_received">وارد منه</label>
                    <input type="number" step="0.01" class="form-control" id="total_received" name="total_received" value="{{ old('total_received', $transaction->total_received) }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="agreed_days_with_vehicle">عدد الأيام المتفق عليها مع السيارة</label>
                    <input type="number" class="form-control" id="agreed_days_with_vehicle" name="agreed_days_with_vehicle" value="{{ old('agreed_days_with_vehicle', $transaction->agreed_days_with_vehicle) }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="agreed_days_with_client">عدد الأيام المتفق عليها مع العميل</label>
                    <input type="number" class="form-control" id="agreed_days_with_client" name="agreed_days_with_client" value="{{ old('agreed_days_with_client', $transaction->agreed_days_with_client) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="overnight_price_with_vehicle">سعر المبيت مع السيارة</label>
                    <input type="number" class="form-control" id="overnight_price_with_vehicle" name="overnight_price_with_vehicle" value="{{ old('overnight_price_with_vehicle', $transaction->overnight_price_with_vehicle) }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="overnight_price_with_client">سعر المبيت مع العميل</label>
                    <input type="number" class="form-control" id="overnight_price_with_client" name="overnight_price_with_client" value="{{ old('overnight_price_with_client', $transaction->overnight_price_with_client) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="driver_id">السائق</label>
                    <select class="form-control" id="driver_id" name="driver_id">
                        <option value="" disabled>اختر السائق</option>
                        @foreach ($drivers as $driver)
                            <option value="{{ $driver->id }}" {{ $transaction->driver_id == $driver->id ? 'selected' : '' }}>
                                {{ $driver->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="vehicle_id">السيارة</label>
                    <select class="form-control" id="vehicle_id" name="vehicle_id">
                        <option value="" disabled>اختر السيارة</option>
                        @foreach ($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}" {{ $transaction->vehicle_id == $vehicle->id ? 'selected' : '' }}>
                                {{ $vehicle->license_plate }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="location_from">الموقع من</label>
                    <input type="text" class="form-control" id="location_from" name="location_from" value="{{ old('location_from', $transaction->location_from) }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="location_to">الموقع إلى</label>
                    <input type="text" class="form-control" id="location_to" name="location_to" value="{{ old('location_to', $transaction->location_to) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="fare">النولون</label>
                    <input type="number" step="0.01" class="form-control" id="fare" name="fare" value="{{ old('fare', $transaction->fare) }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="truck_fare">نولون العربية</label>
                    <input type="number" step="0.01" class="form-control" id="truck_fare" name="truck_fare" value="{{ old('truck_fare', $transaction->truck_fare) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="tips">اكرامية</label>
                    <input type="number" step="0.01" class="form-control" id="tips" name="tips" value="{{ old('tips', $transaction->tips) }}">
                </div>
                <div class="form-group col-md-6">
                    <label for="vehicle_allowance">عهدة العربية</label>
                    <input type="number" step="0.01" class="form-control" id="vehicle_allowance" name="vehicle_allowance" value="{{ old('vehicle_allowance', $transaction->vehicle_allowance) }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="detention">التعتيق</label>
                    <input type="number" step="0.01" class="form-control" id="detention" name="detention" value="{{ old('detention', $transaction->detention) }}">
                </div>
                <div class="form-group col-md-6">
                    <label for="loading">التحميل</label>
                    <input type="number" step="0.01" class="form-control" id="loading" name="loading" value="{{ old('loading', $transaction->loading) }}">
                </div>
                <div class="form-group col-md-6">
                    <label for="weight">الميزان</label>
                    <input type="number" step="0.01" class="form-control" id="weight" name="weight" value="{{ old('weight', $transaction->weight) }}">
                </div>
            </div>

            <!-- Section for Spends -->
            <h3 class="mt-4">تفاصيل الإنفاق</h3>
            <div id="spends">
                @foreach ($transaction->spends as $index => $spend)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="spends[{{ $index }}][spend_details]">تفاصيل الإنفاق</label>
                                    <input type="text" name="spends[{{ $index }}][spend_details]" class="form-control" value="{{ old("spends[$index][spend_details]", $spend->spend_details) }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="spends[{{ $index }}][value]">القيمة</label>
                                    <input type="number" name="spends[{{ $index }}][value]" class="form-control" value="{{ old("spends[$index][value]", $spend->value) }}">
                                </div>
                            </div>
                            <button type="button" class="btn btn-danger removeSpend">إزالة</button>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-secondary mt-2" id="addSpend">إضافة إنفاق آخر</button>
            <!-- End of Section for Spends -->

            <button type="submit" class="btn btn-primary mt-3">حفظ</button>
        </form>
    </div>

    <!-- JavaScript for Adding/Removing Spends -->
    <script>
        document.getElementById('addSpend').addEventListener('click', function() {
            const spends = document.getElementById('spends');
            const index = spends.children.length;
            const spendTemplate = `
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="spends[${index}][spend_details]">تفاصيل الإنفاق</label>
                                <input type="text" name="spends[${index}][spend_details]" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="spends[${index}][value]">القيمة</label>
                                <input type="number" name="spends[${index}][value]" class="form-control" required>
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger removeSpend">إزالة</button>
                    </div>
                </div>
            `;
            spends.insertAdjacentHTML('beforeend', spendTemplate);

            // Add event listener to the remove button
            spends.querySelector('.removeSpend:last-child').addEventListener('click', function() {
                this.parentElement.parentElement.remove();
            });
        });

        // Event listener for initial remove buttons
        document.querySelectorAll('.removeSpend').forEach(button => {
            button.addEventListener('click', function() {
                this.parentElement.parentElement.remove();
            });
        });
    </script>
    <!-- End of JavaScript -->
@endsection
