<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\IndividualTransaction;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        try {
            $employees = Employee::all();
            $totalTips = Employee::tipsForCurrentMonth();
            $totalEmployees = Employee::count();
            $tipsPerEmployee = $totalEmployees > 0 ? $totalTips / $totalEmployees : 0;
            $typeTranslations = [
                'driver' => 'سائق',
                'loader' => 'عامل تحميل',
                'accountant' => 'محاسب',
            ];
            return view('employees.index', compact('employees', 'totalTips', 'tipsPerEmployee','typeTranslations'));
        } catch (\Exception $e) {
            return redirect()->route('employees.index')->with('error', 'حدث خطأ أثناء جلب بيانات الموظفين: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'type' => 'required|in:driver,loader,accountant',
            'salary' => 'required|numeric',
        ]);

        try {
            Employee::create($validated);
            return redirect()->route('employees.index')->with('success', 'تمت إضافة الموظف بنجاح.');
        } catch (\Exception $e) {
            return redirect()->route('employees.index')->with('error', 'حدث خطأ أثناء إضافة الموظف: ' . $e->getMessage());
        }
    }

    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'type' => 'required|in:driver,loader,accountant',
            'salary' => 'required|numeric',
        ]);

        try {
            $employee->update($validated);
            return redirect()->route('employees.index')->with('success', 'تم تحديث بيانات الموظف بنجاح.');
        } catch (\Exception $e) {
            return redirect()->route('employees.index')->with('error', 'حدث خطأ أثناء تحديث بيانات الموظف: ' . $e->getMessage());
        }
    }

    public function destroy(Employee $employee)
    {
        try {
            $employee->loans()->delete();
            $employee->delete();
            return redirect()->route('employees.index')->with('success', 'تم حذف الموظف بنجاح.');
        } catch (\Exception $e) {
            return redirect()->route('employees.index')->with('error', 'حدث خطأ أثناء حذف الموظف: ' . $e->getMessage());
        }
    }

    public function markSalaryAsPaid(Employee $employee)
    {
        try {
            $employee->salary_paid_for_current_month = true;
            $employee->save();
            return redirect()->route('employees.index')->with('success', 'تم تعليم راتب ' . $employee->name . ' على أنه مدفوع.');
        } catch (\Exception $e) {
            return redirect()->route('employees.index')->with('error', 'حدث خطأ أثناء تعليم الراتب كمدفوع: ' . $e->getMessage());
        }
    }
}
