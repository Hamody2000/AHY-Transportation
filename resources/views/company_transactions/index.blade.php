@extends('layouts.app')

@section('content')
    <h1 class="mb-4">معاملات الشركات</h1>
    <a href="{{ route('company_transactions.create') }}" class="btn btn-primary mb-3">إضافة معاملة شركة</a>

    <div class="table-responsive">
        <table class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                    <th>التاريخ</th>
                    <th>اسم العميل</th>
                    <th>وارد منه</th>
                    <th>سعر الطن</th>
                    <th>عدد الأطنان</th>
                    <th>الميزان</th>
                    <th>السائق</th>
                    <th>صورة بطائة السائق</th>

                    <th>المبيت</th>
                    <th>التحميل</th>
                    <th>التعتيق</th>
                    <th>التحويل</th>
                    <th>العمولة</th>
                    <th>من</th>
                    <th>إلى</th>
                    <th> تاريخ التعتيق السيارة</th>
                    <th> تاريخ التعتيق العميل</th>
                    <th>الإجمالي</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->date->format('Y-m-d') }}</td>
                        <td>{{ $transaction->client->name ?? 'غير متوفر' }}</td>
                        <td>{{ number_format($transaction->total_received) }} جنيه</td>
                        <td>{{ number_format($transaction->price_per_ton) }} جنيه</td>
                        <td>{{ $transaction->tonnage }}</td>
                        <td>{{ number_format($transaction->weight) }} جنيه</td>
                        <td>{{ $transaction->driver_name ? $transaction->driver_name : 'غير متوفر' }}</td>
                        <td>
                            @if ($transaction->driver_id_photo)
                                <img src="{{ asset('storage/' . $transaction->driver_id_photo) }}" class="thumbnail"
                                    id="myImg" alt="Driver ID Photo">
                            @endif
                        </td>
                        <div id="myModal" class="modal">
                            <span class="close">&times;</span>
                            <img class="modal-content" id="img01">
                        </div>
                        <td>{{ number_format($transaction->overnight_stay) }} جنيه</td>
                        <td>{{ number_format($transaction->loading) }} جنيه</td>
                        <td>{{ number_format($transaction->detention) }} جنيه</td>
                        <td>{{ number_format($transaction->transfer) }} جنيه</td>
                        <td>{{ number_format($transaction->commission) }} جنيه</td>
                        <td>{{ $transaction->location_from }}</td>
                        <td>{{ $transaction->location_to }}</td>
                        <td>{{ $transaction->detention_date_car? $transaction->detention_date_car->format('Y-m-d') : '' }}</td>

                        <td>{{ number_format($transaction->total) }} جنيه</td>
                        {{-- <td>
                        <a href="{{ route('company_transactions.edit', $transaction->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                        <a href="{{ route('invoices.company', ['id' => $transaction->id]) }}" class="btn btn-primary btn-sm">طباعة</a>
                        <form action="{{ route('company_transactions.destroy', $transaction->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                        </form>
                    </td> --}}
                        <td class="text-center">
                            <!-- Button Group -->
                            <div class="btn-group" role="group" aria-label="Actions">
                                <!-- Print Button -->
                                <a href="{{ route('invoices.company', ['id' => $transaction->id]) }}"
                                    class="btn btn-secondary btn-sm mx-1" title="طباعة">
                                    <i class="fas fa-print"></i> طباعة
                                </a>
                                <!-- Delete Button -->
                                <form action="{{ route('company_transactions.destroy', $transaction->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mx-1" title="إزالة"
                                        onclick="return confirm('هل أنت متأكد أنك تريد حذف هذه المعاملة؟')">
                                        <i class="fas fa-trash-alt"></i> إزالة
                                    </button>
                                </form>
                                <!-- Edit Button -->
                                <a href="{{ route('company_transactions.edit', $transaction->id) }}"
                                    class="btn btn-warning btn-sm mx-1" title="تعديل">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $transactions->links() }}
    </div>
    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the image and insert it inside the modal - use its "alt" text as a caption
        var img = document.getElementById("myImg");
        var modalImg = document.getElementById("img01");

        img.onclick = function() {
            modal.style.display = "block";
            modalImg.src = this.src;
        }

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }
    </script>
@endsection
