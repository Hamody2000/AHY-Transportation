<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinancialTransactionController;
use App\Http\Controllers\IndividualTransactionController;
use App\Http\Controllers\CompanyTransactionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DailyExpenseController;
use App\Http\Controllers\ClientRevenueController;



Route::group(['middleware' => 'auth'], function () {
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('employees', EmployeeController::class);
Route::resource('vehicles', VehicleController::class);
Route::resource('clients', ClientController::class);
Route::resource('salaries', SalaryController::class);
Route::resource('loans', LoanController::class);
Route::resource('individual_transactions', IndividualTransactionController::class);
Route::resource('company_transactions', CompanyTransactionController::class);

Route::get('employees/{employee}/loans', [LoanController::class, 'showEmployeeLoans'])->name('employees.loans');
Route::get('/invoices/individual/{id}', [IndividualTransactionController::class, 'printInvoice'])->name('invoices.individual');
Route::get('/invoices/company/{id}', [CompanyTransactionController::class, 'printInvoice'])->name('invoices.company');
Route::get('clients/{id}/transactions', [ClientController::class, 'showTransactions'])->name('clients.transactions');
Route::get('/transactions/search', [TransactionController::class, 'search'])->name('transactions.search');
Route::patch('/employees/{employee}/mark-salary-as-paid', [EmployeeController::class, 'markSalaryAsPaid'])->name('employees.markSalaryAsPaid');

Route::resource('daily_expenses', DailyExpenseController::class);
Route::get('/daily-expenses/invoice', [DailyExpenseController::class, 'generateInvoice'])->name('daily_expenses.invoice');
Route::match(['get', 'post'], '/daily-expenses/search', [DailyExpenseController::class, 'search'])->name('daily_expenses.search');
Route::delete('/daily-expenses/{id}', [DailyExpenseController::class, 'destroy'])->name('daily_expenses.destroy');


Route::resource('client_revenues', ClientRevenueController::class);


// Route::post('/clients/{id}/add-transaction', [ClientController::class, 'addTransaction'])->name('clients.addTransaction');
Route::post('/clients/{clientId}/add-transaction', [TransactionController::class, 'addTransaction'])->name('transactions.add');

Route::post('/individual_transactions/{id}/toggle_overnight_days', [IndividualTransactionController::class, 'toggleOvernightDays'])->name('individual_transactions.toggle_overnight_days');

Route::post('/individual_transactions/{id}/finish', [IndividualTransactionController::class, 'finishTransaction'])->name('individual_transactions.finish');


//select Transactions

Route::get('/clients/{clientId}/select-transactions', [TransactionController::class, 'selectTransactionsForInvoice'])->name('transactions.select_invoice');
Route::post('/clients/{clientId}/generate-invoice', [TransactionController::class, 'generateInvoice'])->name('transactions.generate_invoice');





});
require __DIR__ . '/auth.php';





