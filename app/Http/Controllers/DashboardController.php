<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Vehicle;
use App\Models\Client;
use App\Models\FinancialTransaction;

class DashboardController extends Controller
{
    public function index()
    {
        $employee = Employee::all();
        $vehicle = Vehicle::all();
        $client = Client::all();
        // $recentTransactions = FinancialTransaction::latest()->take(5)->get();

        return view('dashboard', compact('employee', 'vehicle', 'client'));
    }
}
