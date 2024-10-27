@extends('layouts.app')

@section('content')
<div class="container">
    <h1>إضافة مصاريف جديدة</h1>
    <form action="{{ route('daily_expenses.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>نوع الإدخال</label>
            <div>
                <label>
                    <input type="radio" name="entry_type" value="amount" checked onclick="toggleInputFields()"> مصاريف
                </label>
                <label>
                    <input type="radio" name="entry_type" value="income" onclick="toggleInputFields()"> إيرادات
                </label>
            </div>
        </div>

        <div class="form-group" id="amountField">
            <label for="amount">مصاريف</label>
            <input type="number" class="form-control" id="amount" name="amount" required>
        </div>

        <div class="form-group d-none" id="incomeField">
            <label for="income">إرادات</label>
            <input type="number" class="form-control" id="income" name="income">
        </div>

        <div class="form-group">
            <label for="date">التاريخ</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>

        <div class="form-group">
            <label for="description">الوصف</label>
            <input type="text" class="form-control" id="description" name="description">
        </div>

        <div class="form-group">
            <label for="category">الفئة</label>
            <select class="form-control" id="category" name="category" required>
                <option value="" selected disabled>اختر الفئة</option>
                <option value="مصاريف يومية">مصاريف يومية</option>
                <option value="نثريات">نثريات</option>
                <option value="طوارئ">طوارئ</option>
                <option value="صيانة">صيانة</option>
                <option value="أخرى">سيارات</option>
                <option value="مرتبات">مرتبات</option>
                <option value="أخرى">أخرى</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">إضافة</button>
    </form>
</div>

<script>
    function toggleInputFields() {
        const entryType = document.querySelector('input[name="entry_type"]:checked').value;
        const amountField = document.getElementById('amountField');
        const incomeField = document.getElementById('incomeField');

        if (entryType === 'amount') {
            amountField.classList.remove('d-none');
            incomeField.classList.add('d-none');
            document.getElementById('amount').required = true; // Make amount required
            document.getElementById('income').required = false; // Make income not required
        } else {
            amountField.classList.add('d-none');
            incomeField.classList.remove('d-none');
            document.getElementById('amount').required = false; // Make amount not required
            document.getElementById('income').required = true; // Make income required
        }
    }
</script>
@endsection
