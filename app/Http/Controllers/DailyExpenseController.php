<?php

namespace App\Http\Controllers;

use App\Models\DailyExpense;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DailyExpenseController extends Controller
{
    public function index(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            // Get all daily expenses for display
            $daily_expenses = DailyExpense::paginate(10);

            // Validate dates
            if ($startDate && $endDate) {
                $expenses = DailyExpense::whereBetween('date', [$startDate, $endDate])
                    ->select('category', DB::raw('SUM(amount) as total_amount'))
                    ->groupBy('category')
                    ->get();

                $totalExpenses = $expenses->sum('total_amount');
            } else {
                $expenses = collect(); // Empty collection if no dates provided
                $totalExpenses = 0;
            }

            return view('daily_expenses.index', compact('expenses', 'totalExpenses', 'startDate', 'endDate', 'daily_expenses'));
        } catch (\Exception $e) {
            return redirect()->route('daily_expenses.index')->with('error', 'حدث خطأ أثناء جلب المصاريف اليومية: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('daily_expenses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
            'amount' => 'required|numeric',
            'category' => 'required|string',
        ]);

        try {
            DailyExpense::create($request->all());
            return redirect()->route('daily_expenses.index')->with('success', 'تمت إضافة المصاريف بنجاح.');
        } catch (\Exception $e) {
            return redirect()->route('daily_expenses.index')->with('error', 'حدث خطأ أثناء إضافة المصاريف: ' . $e->getMessage());
        }
    }
}
