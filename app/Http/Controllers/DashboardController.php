<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Vehicle;
use App\Models\Client;
use App\Models\FinancialTransaction;

use Carbon\Carbon;
use App\Models\IndividualTransaction;
use App\Models\CompanyTransaction;
use Illuminate\Support\Facades\Log;


class DashboardController extends Controller
{
    public function index()
    {
        $employee = Employee::all();
        $vehicle = Vehicle::all();
        $client = Client::all();

        // $recentTransactions = FinancialTransaction::latest()->take(5)->get();
        $today = Carbon::today()->toDateString();

        // Fetch individual transactions with today's detention date
        $individualTransactions = IndividualTransaction::where('detention_date_car', $today)->get();

        // Fetch company transactions with today's detention date
        $companyTransactions = CompanyTransaction::where('detention_date_car', $today)->get();

        // Log that the task was triggered (optional)
        Log::info('Home page triggered task at: ' . now());

        return view('dashboard', compact('employee', 'vehicle', 'client','individualTransactions', 'companyTransactions', 'today'));
    }
}
