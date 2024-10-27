<?php

namespace App\Http\Controllers;

use App\Models\DailyExpense;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use \setasign\Fpdi\Tcpdf\Tcpdf; // Ensure you are using the correct TCPDF class
use NumberToWords\NumberToWords;


class DailyExpenseController extends Controller
{
    public function index(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $selectedCategory = $request->input('category');

            // Build the query
            $query = DailyExpense::query();

            if ($startDate && $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            }

            if ($selectedCategory) {
                $query->where('category', $selectedCategory);
            }

            // Get daily expenses with pagination
            $daily_expenses = $query->orderBy('date', 'desc')->paginate(10);

            // Get total expenses for the selected category (if any)
            $expenses = DailyExpense::select('category', DB::raw('SUM(amount) as total_amount'))
                ->when($selectedCategory, function ($query) use ($selectedCategory) {
                    return $query->where('category', $selectedCategory);
                })
                ->groupBy('category')
                ->get();

            $totalExpenses = $expenses->sum('total_amount');

            return view('daily_expenses.index', compact('expenses', 'totalExpenses', 'startDate', 'endDate', 'daily_expenses', 'selectedCategory'));
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
        $this->validateExpense($request);

        try {
            DailyExpense::create($request->all());
            return redirect()->route('daily_expenses.index')->with('success', 'Expense added successfully.');
        } catch (\Exception $e) {
            return $this->handleError('Error adding expense: ' . $e->getMessage());
        }
    }

    public function search(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'category' => 'nullable|string',
        ]);

        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $category = $request->input('category');

            // Get expenses between the specified dates and optional category
            $query = DailyExpense::whereBetween('date', [$startDate, $endDate]);

            if ($category) {
                $query->where('category', $category);
            }

            $expenses = $query->get();
            $totalExpenses = $expenses->reduce(function ($carry, $expense) {
                return $carry + ($expense->amount ?? 0) - ($expense->income ?? 0);
            }, 0);


            // Convert total amount to words (in Arabic)
            $numberToWords = new NumberToWords();
            $numberTransformer = $numberToWords->getNumberTransformer('ar'); // Arabic transformer
            $totalInWords = $numberTransformer->toWords($totalExpenses);

            //convert numbers to arabic
            $startDateArabic = $this->convertNumbersToArabic($startDate);
            $endDateArabic = $this->convertNumbersToArabic($endDate);
            $totalExpensesArabic = $this->convertNumbersToArabic(number_format($totalExpenses));
            $totalInWordsArabic = $this->convertNumbersToArabic($totalInWords);
            return view('daily_expenses.pdf_invoice', compact('expenses', 'startDateArabic', 'endDateArabic', 'totalExpensesArabic', 'totalInWordsArabic', 'startDate', 'endDate', 'category', 'totalExpenses', 'totalInWords'));
        } catch (\Exception $e) {
            return $this->handleError('Error fetching expenses: ' . $e->getMessage());
        }
    }



    private  function convertNumbersToArabic($input)
    {
        $westernArabic = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $easternArabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        return str_replace($westernArabic, $easternArabic, $input);
    }




    public function generateInvoice(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $category = $request->input('category');

        // Fetch expenses based on date range and category
        $query = DailyExpense::whereBetween('date', [$startDate, $endDate]);

        if ($category) {
            $query->where('category', $category);
        }

        $expenses = $query->get();

        // Calculate total expenses
        $totalExpenses = $expenses->reduce(function ($carry, $expense) {
            return $carry + ($expense->amount ?? 0) - ($expense->income ?? 0);
        }, 0);

        // Convert total amount to words (in Arabic)
        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('ar');
        $totalInWords = $numberTransformer->toWords($totalExpenses);

        // Convert numbers to Arabic numerals (for dates, total amount, etc.)
        $startDateArabic = $this->convertNumbersToArabic($startDate);
        $endDateArabic = $this->convertNumbersToArabic($endDate);
        $totalExpensesArabic = $this->convertNumbersToArabic(number_format($totalExpenses));
        $totalInWordsArabic = $this->convertNumbersToArabic($totalInWords);

        // Create new TCPDF instance
        $pdf = new \TCPDF();
        $pdf->setRTL(true);
        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Company');
        $pdf->SetTitle('Invoice');
        $pdf->SetSubject('Invoice');
        $pdf->SetKeywords('TCPDF, PDF, invoice');

        // Set default header and footer data
        // $pdf->setHeaderData('', 0, 'Invoice', "For the period from $startDateArabic to $endDateArabic");

        // Set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // Set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // Set font for Arabic content
        $pdf->SetFont('dejavusans', '', 12);

        // Add a page
        $pdf->AddPage();

        // Prepare HTML content for the PDF
        $html = view('daily_expenses.pdf_invoice', compact(
            'expenses',
            'startDateArabic',
            'endDateArabic',
            'totalExpensesArabic',
            'totalInWordsArabic',
            'startDate',
            'endDate',
            'category',
            'totalExpenses',
            'totalInWords'
        ))->render();

        // Write HTML content to the PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Output the PDF (Force Download)
        return $pdf->Output('invoice.pdf', 'D');
    }





    private function getExpensesBetweenDates($startDate, $endDate)
    {
        if ($startDate && $endDate) {
            $expenses = DailyExpense::whereBetween('date', [$startDate, $endDate])
                ->select('category', DB::raw('SUM(amount) as total_amount'), DB::raw('SUM(income) as total_income'))
                ->groupBy('category')
                ->get();

            $totalExpenses = $expenses->sum('total_amount');
            $totalIncome = $expenses->sum('total_income'); // Sum of incomes
            $netExpenses = $totalExpenses - $totalIncome; // Calculate net expenses
        } else {
            $expenses = collect(); // Empty collection if no dates provided
            $totalExpenses = $totalIncome = $netExpenses = 0; // Initialize totals
        }

        return [$expenses, $totalExpenses, $totalIncome, $netExpenses];
    }

    private function validateExpense(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
            'amount' => 'nullable|numeric',
            'category' => 'required|string',
            'income' => 'nullable|numeric', // Validate income field
        ]);
    }

    private function handleError($message)
    {
        return redirect()->route('daily_expenses.index')->with('error', $message);
    }


    public function destroy($id)
    {
        try {
            $expense = DailyExpense::findOrFail($id);
            $expense->delete();

            return redirect()->route('daily_expenses.index')->with('success', 'تم حذف المصروف بنجاح.');
        } catch (\Exception $e) {
            return redirect()->route('daily_expenses.index')->with('error', 'حدث خطأ أثناء حذف المصروف: ' . $e->getMessage());
        }
    }
}
