@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">العملاء</h1>
        <a href="{{ route('clients.create') }}" class="btn btn-primary mb-3">إضافة عميل جديد</a>

        <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>النوع</th>
                    <th>الهاتف</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                    <td>{{ $typeTranslations[$client->type] ?? $client->type }}</td>
                    <td>{{ $client->phone }}</td>
                    <td class="text-center">
                        <!-- Button Group -->
                        <div class="btn-group" role="group" aria-label="Client Actions">
                            <!-- Transactions Button -->
                            <a href="{{ route('clients.transactions', $client->id) }}" class="btn btn-info btn-sm mx-1" title="عرض المعاملات">
                                <i class="fas fa-list"></i> معاملات
                            </a>

                            <!-- Edit Button -->
                            <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning btn-sm mx-1" title="تعديل">
                                <i class="fas fa-edit"></i> تعديل
                            </a>

                            <!-- Delete Button -->
                            <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm mx-1" title="حذف"
                                        onclick="return confirm('هل أنت متأكد أنك تريد حذف هذا العميل؟')">
                                    <i class="fas fa-trash-alt"></i> حذف
                                </button>
                            </form>
                        </div>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        <div class="table-responsive">
            <table class="table table-hover table-bordered text-center">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>العميل</th>
                        <th>إجمالي الوارد</th>
                        <th>إجمالي المنصرف</th>
                        <th>الفرق</th>
                        <th>إضافة معاملة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientData as $data)
                        <tr>
                            <td>{{ $data['client']->id }} ID</td>
                            <td>{{ $data['client']->name }}</td>
                            <td>{{ number_format($data['total_received'], 2) }} جنيه</td>
                            <td>{{ number_format($data['total_spent'], 2) }} جنيه</td>

                            <td>
                                @if ($data['balance'] > 0)
                                    <span class="text-danger">{{ number_format($data['balance'], 2) }} جنيه (عليك)</span>
                                @elseif ($data['balance'] < 0)
                                    <span class="text-success">{{ number_format(abs($data['balance']), 2) }} جنيه
                                        (لصالحك)
                                    </span>
                                @else
                                    <span>{{ number_format($data['balance'], 2) }} جنيه</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-info btn-sm" onclick= " showTransactionForm('{{ $data['client']->id }}')">إضافة معاملة مالية</button>
                                    <a href="{{ route('clients.transactions', $data['client']->id) }}" class="btn btn-primary btn-sm">عرض المعاملات</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Transaction Form -->
    <div id="transactionFormContainer" style="display:none;">
        <h2>إضافة معاملة</h2>
        <form id="addTransactionForm" method="POST" action="">
            @csrf
            <input type="hidden" name="client_id" id="client_id">
            <div class="form-group">
                <label for="amount">المبلغ</label>
                <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
            </div>
            <div class="form-group">
                <label for="type">النوع</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="" disabled selected>اختر النوع</option>
                    <option value="credit">وارد</option>
                    <option value="debit">منصرف</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">إضافة</button>
            <button type="button" class="btn btn-secondary" onclick="hideTransactionForm()">إغلاق</button>
        </form>
    </div>

    <script>
        function showTransactionForm(clientId) {
            document.getElementById('client_id').value = clientId;
            document.getElementById('addTransactionForm').action = '/clients/' + clientId + '/add-transaction';
            document.getElementById('transactionFormContainer').style.display = 'block';
        }

        function hideTransactionForm() {
            document.getElementById('transactionFormContainer').style.display = 'none';
        }
    </script>
@endsection
