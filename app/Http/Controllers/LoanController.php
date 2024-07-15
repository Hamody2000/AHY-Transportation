<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Loan;
use App\Models\Employee;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        try {
            $loans = Loan::with('employee')->orderBy('loan_date', 'desc')->paginate(15);
            return view('loans.index', compact('loans'));
        } catch (\Exception $e) {
            return redirect()->route('loans.index')
                ->with('error', 'حدث خطأ أثناء جلب السلف: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $employees = Employee::all();
            return view('loans.create', compact('employees'));
        } catch (\Exception $e) {
            return redirect()->route('loans.index')
                ->with('error', 'حدث خطأ أثناء جلب بيانات الموظفين: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'amount' => 'required|numeric',
            'loan_date' => 'required|date',
            'comment' => 'nullable|string',
        ]);

        try {
            Loan::create($validated);
            return redirect()->route('loans.index')->with('success', 'تمت إضافة السلفة بنجاح.');
        } catch (\Exception $e) {
            return redirect()->route('loans.create')
                ->with('error', 'حدث خطأ أثناء إضافة السلفة: ' . $e->getMessage());
        }
    }

    public function edit(Loan $loan)
    {
        try {
            $employees = Employee::all();
            return view('loans.edit', compact('loan', 'employees'));
        } catch (\Exception $e) {
            return redirect()->route('loans.index')
                ->with('error', 'حدث خطأ أثناء جلب بيانات السلفة: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'amount' => 'required|numeric',
            'loan_date' => 'required|date',
            'comment' => 'nullable|string',
        ]);

        try {
            $loan->update($validated);
            return redirect()->route('loans.index')->with('success', 'تمت تحديث السلفة بنجاح.');
        } catch (\Exception $e) {
            return redirect()->route('loans.edit', $loan->id)
                ->with('error', 'حدث خطأ أثناء تحديث السلفة: ' . $e->getMessage());
        }
    }

    public function destroy(Loan $loan)
    {
        try {
            $loan->delete();
            return redirect()->route('loans.index')->with('success', 'تمت حذف القرض بنجاح.');
        } catch (\Exception $e) {
            return redirect()->route('loans.index')
                ->with('error', 'حدث خطأ أثناء حذف السلفة: ' . $e->getMessage());
        }
    }

    public function showEmployeeLoans(Employee $employee)
    {
        try {
            $loans = $employee->loans;  // Fetch loans related to this employee
            return view('loans.index', compact('loans', 'employee'));
        } catch (\Exception $e) {
            return redirect()->route('loans.index')
                ->with('error', 'حدث خطأ أثناء جلب سلف الموظف: ' . $e->getMessage());
        }
    }
}
