@extends('layouts.app')

@section('content')
    <h1>
        جميع المعاملات الفردية</h1>
    <a href="{{ route('individual_transactions.create') }}" class="btn btn-primary mb-4">إضافة معاملة فردية</a>
    <div class="table-responsive">
        <table class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                    <th>التاريخ</th>
                    <th>العميل</th>
                    <th>وارد منه</th>
                    <th>إجمالي منصرف منه</th>
                    <th>منصرف منه</th>
                    <th>التعتيق</th>
                    <th>تحميل</th>
                    <th>النولون</th>
                    <th>العمولة</th>
                    <th>نولون العربية</th>
                    <th>إكرامية</th>
                    <th>باقي نولون السيارة</th>
                    <th>عهدة العربية</th>
                    <th>باقي نولون العربية بعد العهدة</th>
                    <th>السائق</th>
                    <th>صورة بطائة السائق</th>

                    <th>السيارة</th>
                    <th>الأيام المتفق عليها مع السيارة</th>
                    <th>الأيام المتفق عليها مع العميل</th>
                    <th>سعر أيام المبيت مع السيارة</th>
                    <th>سعر أيام المبيت مع العميل</th>
                    <th>أيام المبيت</th>
                    <th> تاريخ التعتيق السيارة</th>
                    <th> تاريخ التعتيق العميل</th>
                    <th>المبيت</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->date->format('Y-m-d') }}</td>
                        <td>{{ $transaction->client->name }}</td>
                        <td>{{ number_format($transaction->total_received) }} جنيه</td>
                        <td>{{ number_format($transaction->total_spent) }} جنيه</td>
                        <td>
                            <ul>
                                @foreach ($transaction->spends as $spend)
                                    <li>{{ $spend->spend_details }}: {{ number_format($spend->value) }} جنيه</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ number_format($transaction->detention) }} جنيه</td>
                        <td>{{ number_format($transaction->loading) }} جنيه</td>
                        <td>{{ number_format($transaction->fare) }} جنيه</td>
                        <td>{{ number_format($transaction->commission) }} جنيه</td>
                        <td>{{ number_format($transaction->truck_fare) }} جنيه</td>
                        <td>{{ number_format($transaction->tips) }} جنيه</td>
                        <td>{{ number_format($transaction->remaining_truck_fare) }} جنيه</td>
                        <td>{{ number_format($transaction->vehicle_allowance) }} جنيه</td>
                        <td>{{ number_format($transaction->final_truck_fare) }} جنيه</td>
                        <td>{{ $transaction->driver_name ? $transaction->driver_name : 'غير متوفر' }}</td>
                        <td>
                            @if($transaction->driver_id_photo)
                            <img src="{{ asset('storage/' . $transaction->driver_id_photo) }}" class="thumbnail" id="myImg" alt="Driver ID Photo">
                        @endif
                        </td>
                        <div id="myModal" class="modal">
                            <span class="close">&times;</span>
                            <img class="modal-content" id="img01">
                        </div>
                        <td>{{ $transaction->vehicle ? $transaction->vehicle->license_plate : 'غير متوفر' }}</td>
                        <td>{{ number_format($transaction->agreed_days_with_vehicle) }} يوم</td>
                        <td>{{ number_format($transaction->agreed_days_with_client) }} يوم</td>
                        <td>{{ number_format($transaction->overnight_price_with_vehicle) }} جنيه</td>
                        <td>{{ number_format($transaction->overnight_price_with_client) }} جنيه</td>
                        <td>{{ number_format($transaction->overnight_days) }}</td>
                        <td>{{ $transaction->detention_date_car? $transaction->detention_date_car->format('Y-m-d') : '' }}</td>
                        <td>{{ $transaction->detention_date_client? $transaction->detention_date_client->format('Y-m-d') : '' }}</td>

                        <td>{{ number_format($transaction->net_overnight) }} جنيه</td>

                        <td class="text-center">
                            <!-- Button Group -->
                            <div class="btn-group" role="group" aria-label="Transaction Actions"
                                style="display: flex; justify-content: center; gap: 0.5rem;">
                                <!-- Print Button -->
                                <a href="{{ route('invoices.individual', ['id' => $transaction->id]) }}"
                                    class="btn btn-secondary btn-sm" title="طباعة">
                                    <i class="fas fa-print"></i> طباعة
                                </a>
                                <!-- Finish Transaction Button or Finished Icon -->
                                @if ($transaction->is_finished)
                                    <span class="btn btn-success btn-sm" title="تم إنهاء المعاملة">
                                        <i class="fas fa-check-circle"></i> تم إنهاء المعاملة
                                    </span>
                                @else
                                    <button type="button" class="btn btn-info btn-sm" title="إنهاء المعاملة"
                                        onclick="finishTransaction({{ $transaction->id }}, '{{ $transaction->client->name }}', {{ $transaction->overnight_days }})">
                                        <i class="fas fa-check"></i> إنهاء
                                    </button>
                                @endif
                                <!-- Edit Button -->
                                <a href="{{ route('individual_transactions.edit', $transaction->id) }}"
                                    class="btn btn-warning btn-sm" title="تعديل">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <!-- Delete Button -->
                                <form action="{{ route('individual_transactions.destroy', $transaction->id) }}"
                                    method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-bg" title="إزالة"
                                        onclick="return confirm('هل أنت متأكد أنك تريد حذف هذه المعاملة؟')">
                                        <i class="fas fa-trash-alt"></i> إزالة
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <!-- Hidden Form for Finishing Transaction -->
                    <form id="finish-transaction-form-{{ $transaction->id }}"
                        action="{{ route('individual_transactions.finish', $transaction->id) }}" method="POST"
                        style="display:none;">
                        @csrf
                        @method('POST')
                    </form>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $transactions->links() }}
    </div>


    <script>
        function finishTransaction(transactionId, clientName, overnightDays) {
            if (confirm(
                    `هل أنت متأكد أنك تريد إنهاء هذه المعاملة؟\n\nالعميل: ${clientName}\nأيام المبيت: ${overnightDays} يوم`
                )) {
                // Submit the form to finish the transaction
                document.getElementById('finish-transaction-form-' + transactionId).submit();
            }
        }
          // Get the modal
    var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("myImg");
var modalImg = document.getElementById("img01");

img.onclick = function () {
    modal.style.display = "block";
    modalImg.src = this.src;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function () {
    modal.style.display = "none";
}
    </script>
@endsection
