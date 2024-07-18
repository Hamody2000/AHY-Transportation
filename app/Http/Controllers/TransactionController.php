<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IndividualTransaction;
use App\Models\CompanyTransaction;
use App\Models\Transaction;
use App\Models\Client;


class TransactionController extends Controller
{
    public function search(Request $request)
    {
        // Get the date range from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Parse the dates using Carbon
        $start = \Carbon\Carbon::parse($startDate)->startOfDay();
        $end = \Carbon\Carbon::parse($endDate)->endOfDay();

        // Fetch individual transactions within the date range
        $individualTransactions = IndividualTransaction::whereBetween('date', [$start, $end])->get();

        // Fetch company transactions within the date range
        $companyTransactions = CompanyTransaction::whereBetween('date', [$start, $end])->get();

        // Merge individual and company transactions
        $transactions = $individualTransactions->merge($companyTransactions);

        // Calculate total commission (assuming you have a 'commission' column in your transactions table)
        $totalCommission = $transactions->sum('commission');

        return view('transactions.search', [
            'transactions' => $transactions,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalCommission' => $totalCommission
        ]);
    }

    public function addTransaction(Request $request, $clientId)
    {
        // Validate the request
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'client_id' => 'required|exists:clients,id',
            'type' => 'required|in:credit,debit',
        ]);


        // Find the client
        $client = Client::findOrFail($clientId);
        // Create a new transaction
        $transaction = new Transaction();
        $transaction->client_id = $clientId;
        $transaction->amount = $request->amount;
        $transaction->type = $request->type;
        $transaction->save();

        // Update total received or spent based on the type
        $this->updateClientTotals($clientId);

        // Redirect or return response
        return redirect()->route('clients.index')->with('success', 'تمت إضافة المعاملة بنجاح');
    }
    public function viewClientTransactions($clientId)
    {
        $client = Client::findOrFail($clientId);
        $transactions = $client->transactions()->orderBy('created_at', 'desc')->get();

        return view('transactions.client', [
            'client' => $client,
            'transactions' => $transactions
        ]);
    }
    private function updateClientTotals($clientId)
    {
        $client = Client::findOrFail($clientId);

        // Calculate total received from all sources
        $totalReceivedIndividual = $client->individualTransactions->sum('amount');
        $totalReceivedCompany = $client->companyTransactions->sum('amount');
        $totalReceivedGeneral = Transaction::where('client_id', $clientId)->where('type', 'credit')->sum('amount');

        $totalReceived = $totalReceivedIndividual + $totalReceivedCompany + $totalReceivedGeneral;

        // Calculate total spent from general transactions
        $totalSpent = Transaction::where('client_id', $clientId)->where('type', 'debit')->sum('amount');

        $client->total_received = $totalReceived;
        $client->total_spent = $totalSpent;
        $client->save();
    }
}
