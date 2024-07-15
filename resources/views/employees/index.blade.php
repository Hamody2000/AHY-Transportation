@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">الموظفون</h1>
    <a href="{{ route('employees.create') }}" class="btn btn-primary mb-3">إضافة موظف جديد</a>
    <h6 class="mb-4">اجمالي الاكرامية: {{ number_format($totalTips, 0) }} جنيه</h6>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>الهاتف</th>
                    <th>النوع</th>
                    <th>الراتب</th>
                    <th>السلفة (الشهر الحالي)</th>
                    <th>الاكرامية (الشهر الحالي)</th>
                    <th>باقي المرتب</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->phone }}</td>
                    <td>{{ $typeTranslations[$employee->type] ?? $employee->type }}</td>
                    <td>{{ number_format($employee->salary, 0) }} جنيه</td>
                    <td>{{ number_format($employee->totalLoansForCurrentMonth(), 0) }} جنيه</td>
                    <td>{{ number_format($tipsPerEmployee, 0) }} جنيه</td>
                    <td>{{ number_format($employee->remainingSalary(), 0) }} جنيه</td>
                    <td class="text-center">
                        <!-- Button Group -->
                        <div class="btn-group" role="group" aria-label="Employee Actions" style="display: flex; justify-content: center;">
                            <!-- Loans Button -->
                            <a href="{{ route('employees.loans', $employee->id) }}" class="btn btn-info btn-sm" title="عرض السلف" style="margin-right: 0.5rem;">
                                <i class="fas fa-dollar-sign"></i> سلف
                            </a>

                            <!-- Edit Button -->
                            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning btn-sm" title="تعديل" style="margin-right: 0.5rem;">
                                <i class="fas fa-edit"></i> تعديل
                            </a>

                            <!-- Delete Button -->
                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="حذف" style="margin-right: 0.5rem;"
                                        onclick="return confirm('هل أنت متأكد أنك تريد حذف هذا الموظف؟')">
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
</div>
@endsection
