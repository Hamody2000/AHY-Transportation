@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">إضافة معاملة جديدة</h1>

        <form action="{{ route('individual_transactions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="client_id">العميل</label>
                    <select class="form-control" id="client_id" name="client_id" required>
                        <option value="" disabled selected>اختر العميل</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="date">التاريخ</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="total_received">وارد منه</label>
                    <input type="number" class="form-control" id="total_received" name="total_received">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="agreed_days_with_vehicle">عدد الأيام المتفق عليها مع السيارة</label>
                    <input type="number" class="form-control" id="agreed_days_with_vehicle" name="agreed_days_with_vehicle"
                        required>
                </div>
                <div class="form-group col-md-3">
                    <label for="agreed_days_with_client">عدد الأيام المتفق عليها مع العميل</label>
                    <input type="number" class="form-control" id="agreed_days_with_client" name="agreed_days_with_client"
                        required>
                </div>

                <div class="form-group col-md-3">
                    <label for="overnight_price_with_vehicle">سعر المبيت مع السيارة</label>
                    <input type="number" class="form-control" id="overnight_price_with_vehicle"
                        name="overnight_price_with_vehicle" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="overnight_price_with_client">سعر المبيت مع العميل</label>
                    <input type="number" class="form-control" id="overnight_price_with_client"
                        name="overnight_price_with_client" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="detention_date_client">تاريخ التعتيق (العميل)</label>
                    <input type="date" class="form-control" id="detention_date_client" name="detention_date_client">
                </div>

                <div class="form-group col-md-6">
                    <label for="detention_date_car">تاريخ التعتيق (السيارة)</label>
                    <input type="date" class="form-control" id="detention_date_car" name="detention_date_car">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="driver_name">السائق</label>
                        <input type="text" class="form-control" id="driver_name" name="driver_name">
                    </div>
                    <div>
                        <label for="driver_id_photo">صورة بطاقة السائق</label>
                        <input type="file" name="driver_id_photo" id="driver_id_photo" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="vehicle_id">السيارة</label>
                        <select class="form-control" id="vehicle_id" name="vehicle_id">
                            <option value="" disabled selected>اختر السيارة</option>
                            @foreach ($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}">{{ $vehicle->license_plate }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="location_from">الموقع من</label>
                        <input type="text" class="form-control" id="location_from" name="location_from" required>
                    </div>
                    <div class="form-group">
                        <label for="location_to">الموقع إلى</label>
                        <input type="text" class="form-control" id="location_to" name="location_to" required>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="fare">النولون</label>
                    <input type="number" class="form-control" id="fare" name="fare" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="truck_fare">نولون العربية</label>
                    <input type="number" class="form-control" id="truck_fare" name="truck_fare" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="tips">اكرامية</label>
                    <input type="number" class="form-control" id="tips" name="tips">
                </div>
                <div class="form-group col-md-6">
                    <label for="vehicle_allowance">عهدة العربية</label>
                    <input type="number" class="form-control" id="vehicle_allowance" name="vehicle_allowance">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="detention">التعتيق</label>
                    <input type="number" class="form-control" id="detention" name="detention">
                </div>
                <div class="form-group col-md-4">
                    <label for="loading">التحميل</label>
                    <input type="number" class="form-control" id="loading" name="loading">
                </div>
                <div class="form-group col-md-4">
                    <label for="weight">الميزان</label>
                    <input type="number" class="form-control" id="weight" name="weight">
                </div>
            </div>

            <!-- Section for Spends -->
            <h3 class="mt-4">تفاصيل الإنفاق</h3>
            <div id="spends"></div>
            <button type="button" class="btn btn-secondary mt-2" id="addSpend">إضافة إنفاق آخر</button>
            <!-- End of Section for Spends -->

            <div class="mt-4">
                <button type="submit" class="btn btn-primary col-12 mb-4">حفظ</button>
            </div>
        </form>
    </div>

    <!-- JavaScript for Adding/Removing Spends -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const spendsContainer = document.getElementById('spends');
            const addSpendButton = document.getElementById('addSpend');

            // Function to create spend card
            function createSpendCard(index) {
                return `
                <div class="card mb-3 spend">
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
                        <button type="button" class="btn btn-danger mt-2 removeSpend">إزالة</button>
                    </div>
                </div>
            `;
            }

            // Function to add a new spend card
            function addSpendCard() {
                const index = spendsContainer.children.length;
                const spendCard = createSpendCard(index);
                spendsContainer.insertAdjacentHTML('beforeend', spendCard);
                attachRemoveListeners();
            }

            // Function to attach remove listeners to all remove buttons
            function attachRemoveListeners() {
                const removeButtons = document.querySelectorAll('.removeSpend');
                removeButtons.forEach(button => {
                    button.removeEventListener('click', removeSpendCard);
                    button.addEventListener('click', removeSpendCard);
                });
            }

            // Function to remove a spend card
            function removeSpendCard(event) {
                const spendCard = event.target.closest('.spend');
                if (spendCard) {
                    spendCard.remove();
                }
            }

            // Attach event listener to the add spend button
            addSpendButton.addEventListener('click', addSpendCard);

            // Initial attachment of remove listeners (if there are any existing spend cards)
            attachRemoveListeners();
        });
    </script>
@endsection
